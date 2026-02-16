<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lead;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        switch ($role) {
            case 'super_admin':
            case 'admin':
                return view('dashboard.admin'); 
                
            case 'marketing':
                $stats = [
                    'total' => Lead::where('marketing_id', Auth::id())->count(),
                    'new' => Lead::where('marketing_id', Auth::id())->where('status', 'new')->count(),
                    'converted' => Lead::where('marketing_id', Auth::id())->where('status', 'converted')->count(),
                    'follow_up' => Lead::where('marketing_id', Auth::id())->where('status', 'follow_up')->count(),
                ];
                $recentLeads = Lead::where('marketing_id', Auth::id())->latest()->take(5)->get();
                return view('dashboard.marketing', compact('stats', 'recentLeads'));

            case 'technician':
                $tickets = Ticket::where('technician_id', Auth::id())->orWhere('status', 'open')->latest()->take(5)->get();
                return view('dashboard.technician', compact('tickets'));

            case 'customer':
                return view('dashboard.customer');

            default:
                return view('dashboard');
        }
    }
}