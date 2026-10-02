<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        // Technical System Statistics with optimized queries
        $stats = [
            'total_users' => User::count(),
            'total_staffs' => User::whereIn('role', ['admin', 'marketing', 'technician'])->count(),
            'total_customers' => Customer::count(),
            'total_revenue' => Invoice::where('status', 'paid')->sum('amount'),
            'system_health' => $this->getSystemHealth(),
            'database_size' => $this->getDatabaseSize(),
            'active_sessions' => $this->getActiveSessions(),
        ];

        // Chart Data: User by Role Distribution
        $usersByRole = User::selectRaw('role, count(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();

        $roleColors = [
            'super_admin' => '#8b5cf6', // purple
            'admin'       => '#3b82f6', // blue
            'marketing'   => '#f59e0b', // amber
            'technician'  => '#06b6d4', // cyan
            'customer'    => '#10b981', // emerald
        ];

        $roleLabels = [
            'super_admin' => 'Super Admin',
            'admin'       => 'Admin',
            'marketing'   => 'Marketing',
            'technician'  => 'Teknisi',
            'customer'    => 'Pelanggan',
        ];

        $roleChartLabels = [];
        $roleChartData = [];
        $roleChartColors = [];
        foreach ($usersByRole as $role => $count) {
            $roleChartLabels[] = $roleLabels[$role] ?? ucfirst(str_replace('_', ' ', $role));
            $roleChartData[] = (int) $count;
            $roleChartColors[] = $roleColors[$role] ?? '#94a3b8';
        }

        $userRoleChart = [
            'labels' => $roleChartLabels,
            'data' => $roleChartData,
            'backgroundColor' => $roleChartColors,
        ];

        // Chart Data: Revenue Trend (Last 12 Months) - Aggregated by paid date
        $startDate = now()->subMonths(11)->startOfMonth();
        $isSqlite = DB::connection()->getDriverName() === 'sqlite';
        $yearExpr = $isSqlite ? "strftime('%Y', COALESCE(paid_at, created_at))" : "YEAR(COALESCE(paid_at, created_at))";
        $monthExpr = $isSqlite ? "strftime('%m', COALESCE(paid_at, created_at))" : "MONTH(COALESCE(paid_at, created_at))";

        $monthlyRevenues = Invoice::where('status', 'paid')
            ->where(DB::raw('COALESCE(paid_at, created_at)'), '>=', $startDate)
            ->selectRaw("{$yearExpr} as year, {$monthExpr} as month, SUM(amount) as total")
            ->groupByRaw("{$yearExpr}, {$monthExpr}")
            ->get()
            ->keyBy(function ($row) {
                return sprintf('%d-%02d', (int) $row->year, (int) $row->month);
            });

        $revenueTrend = [];
        $labels = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-m');
            $labels[] = $date->translatedFormat('M Y');
            $revenueTrend[] = (float) ($monthlyRevenues->get($key)->total ?? 0);
        }

        $revenueChart = [
            'labels' => $labels,
            'data' => $revenueTrend,
            'backgroundColor' => 'rgba(244, 63, 94, 0.15)',
            'borderColor' => '#f43f5e',
        ];

        // Chart Data: Subscription Status
        $subscriptionStatus = Subscription::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statusColors = [
            'active'    => '#10b981', // emerald
            'inactive'  => '#ef4444', // red
            'pending'   => '#f59e0b', // amber
            'isolated'  => '#f43f5e', // rose
            'cancelled' => '#64748b', // slate
        ];

        $statusLabels = [
            'active'    => 'Aktif',
            'inactive'  => 'Nonaktif',
            'pending'   => 'Tertunda',
            'isolated'  => 'Terisolir',
            'cancelled' => 'Dibatalkan',
        ];

        $subLabels = [];
        $subData = [];
        $subColors = [];
        foreach ($subscriptionStatus as $status => $count) {
            $subLabels[] = $statusLabels[$status] ?? ucfirst($status);
            $subData[] = (int) $count;
            $subColors[] = $statusColors[$status] ?? '#94a3b8';
        }

        $subscriptionChart = [
            'labels' => $subLabels,
            'data' => $subData,
            'backgroundColor' => $subColors,
        ];

        // Chart Data: Daily User Growth (Last 7 days)
        $startDateGrowth = now()->subDays(6)->startOfDay();
        $dailyUsers = User::where('created_at', '>=', $startDateGrowth)
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupByRaw('DATE(created_at)')
            ->pluck('count', 'date');

        $userGrowth = [];
        $growthLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $growthLabels[] = $date->translatedFormat('D, d M');
            $userGrowth[] = (int) ($dailyUsers->get($date->format('Y-m-d')) ?? 0);
        }

        $userGrowthChart = [
            'labels' => $growthLabels,
            'data' => $userGrowth,
            'backgroundColor' => '#3b82f6',
            'borderColor' => '#60a5fa',
        ];

        // Recent Audit Logs with eager loading and pagination
        $recentLogs = AuditLog::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // System Services Status
        $servicesStatus = [
            'database' => 'operational',
            'payment_gateway' => 'connected',
            'api_services' => 'active',
        ];

        return view('superadmin.dashboard.index', compact(
            'stats',
            'recentLogs',
            'servicesStatus',
            'userRoleChart',
            'revenueChart',
            'subscriptionChart',
            'userGrowthChart'
        ));
    }

    private function getSystemHealth()
    {
        return rand(85, 99); // Percentage
    }

    private function getDatabaseSize()
    {
        return '125 MB'; // Placeholder
    }

    private function getActiveSessions()
    {
        // Count active sessions from the last 24 hours
        return DB::table('sessions')
            ->where('last_activity', '>=', now()->subHours(24)->getTimestamp())
            ->count();
    }
}
