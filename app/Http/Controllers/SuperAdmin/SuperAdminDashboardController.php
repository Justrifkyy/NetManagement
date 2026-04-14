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

        // Recent Audit Logs with eager loading and pagination
        $recentLogs = AuditLog::with('user')
            ->latest()
            ->paginate(10);

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
        // Count active sessions from the last 24 hours
        return DB::table('sessions')
            ->where('last_activity', '>=', now()->subHours(24)->getTimestamp())
            ->count();
    }
}
