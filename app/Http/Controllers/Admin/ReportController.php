<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Invoice;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\AuditLog;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function customerReport(Request $request)
    {
        $fromDate = $request->input('from_date', now()->subMonth()->format('Y-m-d'));
        $toDate = $request->input('to_date', now()->format('Y-m-d'));

        $report = Customer::with(['subscriptions', 'user'])
            ->whereBetween('created_at', [
                Carbon::parse($fromDate)->startOfDay(),
                Carbon::parse($toDate)->endOfDay()
            ])
            ->get();

        return view('admin.reports.customers', compact('report', 'fromDate', 'toDate'));
    }

    public function arrearsReport(Request $request)
    {
        $toDate = $request->input('to_date', now()->format('Y-m-d'));

        $arrears = Invoice::with(['subscription.customer.user'])
            ->where('status', 'unpaid')
            ->where('due_date', '<=', Carbon::parse($toDate)->endOfDay())
            ->get();

        $totalArrears = $arrears->sum('amount');

        return view('admin.reports.arrears', compact('arrears', 'totalArrears', 'toDate'));
    }

    public function activationLog(Request $request)
    {
        $fromDate = $request->input('from_date', now()->subMonth()->format('Y-m-d'));
        $toDate = $request->input('to_date', now()->format('Y-m-d'));

        $logs = AuditLog::where(function ($q) {
                $q->where('action', 'activate_customer')
                  ->orWhere('action', 'like', '%activate%');
            })
            ->whereBetween('created_at', [
                Carbon::parse($fromDate)->startOfDay(),
                Carbon::parse($toDate)->endOfDay()
            ])
            ->with('user')
            ->latest('created_at')
            ->get();

        return view('admin.reports.activation-log', compact('logs', 'fromDate', 'toDate'));
    }

    public function isolationLog(Request $request)
    {
        $fromDate = $request->input('from_date', now()->subMonth()->format('Y-m-d'));
        $toDate = $request->input('to_date', now()->format('Y-m-d'));

        $startDateTime = Carbon::parse($fromDate)->startOfDay();
        $endDateTime = Carbon::parse($toDate)->endOfDay();

        // Sinkronisasi otomatis: Jika ada pelanggan berstatus is_isolated = true
        // yang belum memiliki catatan log di audit_logs, buatkan catatan log sistemnya
        $isolatedCustomers = Customer::with('user')->where('is_isolated', true)->get();
        foreach ($isolatedCustomers as $cust) {
            $hasLog = AuditLog::where(function ($q) {
                $q->where('action', 'isolate_customer')
                  ->orWhere('action', 'like', '%isolate%');
            })->where(function ($q) use ($cust) {
                $q->where('description', 'like', "%{$cust->customer_code}%")
                  ->orWhere('description', 'like', "%Pelanggan {$cust->id}%");
            })->exists();

            if (!$hasLog) {
                $customerName = $cust->user?->name ?? $cust->customer_code;
                AuditLog::create([
                    'user_id'     => null,
                    'action'      => 'isolate_customer',
                    'description' => "Pelanggan {$cust->customer_code} ({$customerName}) tercatat dalam status terisolir.",
                    'details'     => [
                        'customer_id'   => $cust->id,
                        'customer_code' => $cust->customer_code,
                        'reason'        => 'Sinkronisasi status isolasi pelanggan',
                    ],
                    'created_at'  => $cust->updated_at ?? now(),
                ]);
            }
        }

        $logs = AuditLog::where(function ($q) {
                $q->where('action', 'isolate_customer')
                  ->orWhere('action', 'like', '%isolate%');
            })
            ->whereBetween('created_at', [$startDateTime, $endDateTime])
            ->with('user')
            ->latest('created_at')
            ->get();

        return view('admin.reports.isolation-log', compact('logs', 'fromDate', 'toDate'));
    }

    public function revenueReport(Request $request)
    {
        $fromDate = $request->input('from_date', now()->subMonth()->format('Y-m-d'));
        $toDate = $request->input('to_date', now()->format('Y-m-d'));

        $revenue = Invoice::where('status', 'paid')
            ->whereBetween('paid_at', [
                Carbon::parse($fromDate)->startOfDay(),
                Carbon::parse($toDate)->endOfDay()
            ])
            ->with('subscription.package')
            ->get();

        $totalRevenue = $revenue->sum('amount');

        return view('admin.reports.revenue', compact('revenue', 'totalRevenue', 'fromDate', 'toDate'));
    }

    public function exportToCsv(Request $request)
    {
        $type = $request->input('type', 'customers');
        
        // Generate CSV based on report type
        return response()->download('report.csv');
    }
}
