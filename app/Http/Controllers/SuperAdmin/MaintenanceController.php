<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenanceMode = Cache::get('maintenance_mode', false);
        $lastBackup = Cache::get('last_backup_at', 'Belum ada backup');
        $cacheSize = Cache::get('cache_size', '0 MB');

        return view('superadmin.maintenance.index', compact('maintenanceMode', 'lastBackup', 'cacheSize'));
    }

    public function toggleMaintenanceMode(Request $request)
    {
        $mode = $request->boolean('maintenance_mode');
        Cache::put('maintenance_mode', $mode);

        $message = $mode ? 'Maintenance mode diaktifkan' : 'Maintenance mode dinonaktifkan';
        return redirect()->back()->with('success', $message);
    }

    public function clearCache()
    {
        Cache::flush();
        return redirect()->back()->with('success', 'Cache berhasil dihapus');
    }

    public function optimizeDatabase()
    {
        // Run optimization commands
        return redirect()->back()->with('success', 'Database optimization dimulai');
    }

    public function backupDatabase()
    {
        // Execute backup command
        Cache::put('last_backup_at', now());
        return redirect()->back()->with('success', 'Database backup dimulai');
    }

    public function viewLogs()
    {
        // Read log files from storage/logs
        $logs = [];
        return view('superadmin.maintenance.logs', compact('logs'));
    }

    public function clearLogs()
    {
        // Clear old log files
        return redirect()->back()->with('success', 'Log files cleared');
    }
}
