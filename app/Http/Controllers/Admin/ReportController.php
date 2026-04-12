<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Invoice;
use Illuminate\Http\Request;

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
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->get();

        return view('admin.reports.customers', compact('report', 'fromDate', 'toDate'));
    }

    public function arrearsReport(Request $request)
    {
        $toDate = $request->input('to_date', now()->format('Y-m-d'));

        $arrears = Invoice::with(['subscription.customer.user'])
            ->where('status', 'unpaid')
            ->where('due_date', '<', $toDate)
            ->get();

        $totalArrears = $arrears->sum('amount');

        return view('admin.reports.arrears', compact('arrears', 'totalArrears', 'toDate'));
    }

    public function activationLog(Request $request)
    {
        $fromDate = $request->input('from_date', now()->subMonth()->format('Y-m-d'));
        $toDate = $request->input('to_date', now()->format('Y-m-d'));

        // Get activation logs from audit_logs table or similar
        $logs = \App\Models\AuditLog::where('action', 'activate_customer')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->with('user')
            ->get();

        return view('admin.reports.activation-log', compact('logs', 'fromDate', 'toDate'));
    }

    public function isolationLog(Request $request)
    {
        $fromDate = $request->input('from_date', now()->subMonth()->format('Y-m-d'));
        $toDate = $request->input('to_date', now()->format('Y-m-d'));

        $logs = \App\Models\AuditLog::where('action', 'isolate_customer')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->with('user')
            ->get();

        return view('admin.reports.isolation-log', compact('logs', 'fromDate', 'toDate'));
    }

    public function revenueReport(Request $request)
    {
        $fromDate = $request->input('from_date', now()->subMonth()->format('Y-m-d'));
        $toDate = $request->input('to_date', now()->format('Y-m-d'));

        $revenue = Invoice::where('status', 'paid')
            ->whereBetween('paid_at', [$fromDate, $toDate])
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
