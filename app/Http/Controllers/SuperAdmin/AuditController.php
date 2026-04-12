<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(20);

        return view('superadmin.audits.index', compact('logs'));
    }

    public function show(AuditLog $log)
    {
        return view('superadmin.audits.show', compact('log'));
    }

    public function export(Request $request)
    {
        // Export audit logs to CSV/Excel
        $logs = AuditLog::query();

        if ($request->filled('date_from')) {
            $logs->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $logs->where('created_at', '<=', $request->date_to);
        }

        return response()->download('export.csv');
    }
}
