<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    private function resolveDateRange(string $period): array
    {
        return match ($period) {
            'last_month'    => [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()],
            'last_3_months' => [now()->subMonths(2)->startOfMonth(), now()->endOfMonth()],
            'this_year'     => [now()->startOfYear(), now()->endOfYear()],
            'all'           => [now()->subYears(10)->startOfDay(), now()->endOfDay()],
            default         => [now()->startOfMonth(), now()->endOfMonth()], // 'this_month'
        };
    }

    public function index(Request $request)
    {
        $marketingId = Auth::id();
        $period = $request->input('period', 'this_month');
        $dateRange = $this->resolveDateRange($period);

        $periodLabels = [
            'this_month'    => 'Bulan Ini',
            'last_month'    => 'Bulan Lalu',
            'last_3_months' => '3 Bulan Terakhir',
            'this_year'     => 'Tahun Ini',
            'all'           => 'Semua Waktu',
        ];
        $currentPeriodLabel = $periodLabels[$period] ?? 'Bulan Ini';

        // Leads acquired pada periode ini
        $leadsQuery = Lead::where('marketing_id', $marketingId);
        if ($period !== 'all') {
            $leadsQuery->whereBetween('created_at', $dateRange);
        }
        $totalLeads = $leadsQuery->count();

        // Converted customer count
        $convertedQuery = Lead::where('marketing_id', $marketingId)->where('status', 'aktif');
        if ($period !== 'all') {
            $convertedQuery->whereBetween('updated_at', $dateRange);
        }
        $convertedCount = $convertedQuery->count();

        $conversionRate = $totalLeads > 0 ? round(($convertedCount / $totalLeads) * 100, 1) : 0;

        // Estimated revenue from converted customers
        $customerRevenueQuery = Customer::whereHas('lead', function ($q) use ($marketingId, $period, $dateRange) {
            $q->where('marketing_id', $marketingId);
            if ($period !== 'all') {
                $q->whereBetween('created_at', $dateRange);
            }
        })->whereHas('subscriptions', function ($sq) {
            $sq->where('status', 'active');
        })->with(['subscriptions.package', 'lead.package']);

        $totalRevenue = $customerRevenueQuery->get()->sum(function ($cust) {
            $subPrice = $cust->subscriptions->where('status', 'active')->sum(function($sub) {
                return $sub->package?->price ?? 0;
            });
            return $subPrice > 0 ? $subPrice : ($cust->lead?->package?->price ?? 0);
        });

        // Pipeline statuses
        $statusBase = Lead::where('marketing_id', $marketingId);
        if ($period !== 'all') {
            $statusBase->whereBetween('created_at', $dateRange);
        }

        $statuses = [
            ['label' => 'Prospek Baru', 'count' => (clone $statusBase)->where('status', 'prospek')->count(), 'color' => 'indigo'],
            ['label' => 'Tahap Survey', 'count' => (clone $statusBase)->where('status', 'survey')->count(), 'color' => 'amber'],
            ['label' => 'Tahap Instalasi', 'count' => (clone $statusBase)->where('status', 'instalasi')->count(), 'color' => 'purple'],
            ['label' => 'Akun Aktif', 'count' => $convertedCount, 'color' => 'emerald'],
        ];

        // Monthly trends (3 bulan terakhir)
        $monthlyTrends = [];
        for ($m = 2; $m >= 0; $m--) {
            $date = now()->subMonths($m);
            $count = Lead::where('marketing_id', $marketingId)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $monthlyTrends[] = [
                'month' => $date->translatedFormat('F Y'),
                'count' => $count,
                'percentage' => $totalLeads > 0 ? min(100, round(($count / max($totalLeads, 1)) * 100)) : 0,
            ];
        }

        // Daily activity breakdown (10 hari terakhir dari akhir periode)
        $dailyBreakdown = [];
        $endDate = $dateRange[1]->isFuture() ? now() : $dateRange[1];
        for ($d = 0; $d < 10; $d++) {
            $date = (clone $endDate)->subDays($d);
            $leadsCount = Lead::where('marketing_id', $marketingId)
                ->whereDate('created_at', $date)
                ->count();
            $convCount = Lead::where('marketing_id', $marketingId)
                ->where('status', 'aktif')
                ->whereDate('updated_at', $date)
                ->count();
            $rate = $leadsCount > 0 ? round(($convCount / $leadsCount) * 100, 1) : 0;
            $estRev = $convCount * 150000;

            $dailyBreakdown[] = [
                'date' => $date,
                'leads' => $leadsCount,
                'followup' => max(0, $leadsCount),
                'conversions' => $convCount,
                'rate' => $rate,
                'revenue' => $estRev,
            ];
        }

        $kpis = [
            'total_leads' => $totalLeads,
            'conversions' => $convertedCount,
            'conversion_rate' => $conversionRate,
            'revenue' => $totalRevenue,
        ];

        return view('marketing.reports.index', compact('kpis', 'statuses', 'monthlyTrends', 'dailyBreakdown', 'period', 'currentPeriodLabel', 'periodLabels'));
    }

    public function export(Request $request)
    {
        $marketingId = Auth::id();
        $period = $request->input('period', 'this_month');
        $dateRange = $this->resolveDateRange($period);

        $periodLabels = [
            'this_month'    => 'Bulan Ini',
            'last_month'    => 'Bulan Lalu',
            'last_3_months' => '3 Bulan Terakhir',
            'this_year'     => 'Tahun Ini',
            'all'           => 'Semua Waktu',
        ];
        $periodLabel = $periodLabels[$period] ?? 'Bulan Ini';

        // Ambil data leads pada periode
        $leadsQuery = Lead::with('package')->where('marketing_id', $marketingId);
        if ($period !== 'all') {
            $leadsQuery->whereBetween('created_at', $dateRange);
        }
        $leads = $leadsQuery->latest()->get();

        $totalLeads = $leads->count();
        $convertedCount = $leads->where('status', 'aktif')->count();
        $conversionRate = $totalLeads > 0 ? round(($convertedCount / $totalLeads) * 100, 1) : 0;

        $fileName = 'laporan-kinerja-marketing-' . $period . '-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($leads, $periodLabel, $totalLeads, $convertedCount, $conversionRate) {
            $output = fopen('php://output', 'w');
            
            // UTF-8 BOM untuk Microsoft Excel
            fputs($output, "\xEF\xBB\xBF");

            // Header Laporan
            fputcsv($output, ['LAPORAN KINERJA MARKETING - NETMANAGER']);
            fputcsv($output, ['Periode', $periodLabel]);
            fputcsv($output, ['Tanggal Unduh', now()->format('d-m-Y H:i:s')]);
            fputcsv($output, []);

            // Ringkasan KPI
            fputcsv($output, ['RINGKASAN KPI']);
            fputcsv($output, ['Total Prospek (Leads)', $totalLeads]);
            fputcsv($output, ['Total Konversi (Akun Aktif)', $convertedCount]);
            fputcsv($output, ['Success Rate (%)', $conversionRate . '%']);
            fputcsv($output, []);

            // Tabel Data Leads
            fputcsv($output, ['DATA PROSPEK & PELANGGAN']);
            fputcsv($output, ['No', 'Nama Lengkap', 'Nomor Telepon', 'Email', 'Paket Layanan', 'Tipe', 'Alamat', 'Status Pipeline', 'Tanggal Terdaftar']);

            foreach ($leads as $index => $lead) {
                fputcsv($output, [
                    $index + 1,
                    $lead->name,
                    "'" . $lead->phone,
                    $lead->email ?? '-',
                    $lead->package?->name ?? '-',
                    strtoupper($lead->customer_type ?? 'Personal'),
                    $lead->address ?? '-',
                    ucfirst($lead->status ?? 'Prospek'),
                    $lead->created_at ? $lead->created_at->format('d-m-Y H:i') : '-',
                ]);
            }

            fclose($output);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }
}
