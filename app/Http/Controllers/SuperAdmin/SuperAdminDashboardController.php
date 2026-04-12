<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        // Technical System Statistics
        $stats = [
            'total_users' => User::count(),
            'total_staffs' => User::whereIn('role', ['admin', 'marketing', 'technician'])->count(),
            'total_customers' => Customer::count(),
            'total_revenue' => Invoice::where('status', 'paid')->sum('amount'),
            'system_health' => $this->getSystemHealth(),
            'database_size' => $this->getDatabaseSize(),
            'active_sessions' => $this->getActiveSessions(),
        ];

        // Recent Audit Logs
        $recentLogs = AuditLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        // System Services Status
        $servicesStatus = [
            'database' => 'operational',
            'payment_gateway' => 'connected',
            'api_services' => 'active',
        ];

        return view('superadmin.dashboard.index', compact('stats', 'recentLogs', 'servicesStatus'));
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
        return User::whereNotNull('last_activity_at')
            ->where('last_activity_at', '>=', now()->subHours(24))
            ->count();
    }
}
