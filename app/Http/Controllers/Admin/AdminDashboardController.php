<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Wajib import ini
use App\Models\Ticket;
use App\Models\Subscription;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik untuk Widget Dashboard
        $stats = [
            'total_users' => User::count(),
            'active_subs' => Subscription::where('status', 'active')->count(),
            'pending_qc'  => Ticket::where('status', 'resolved')->count(), // Perlu diverifikasi
            'new_leads'   => Lead::where('status', 'prospek')->count(),
        ];

        // Ambil 5 pekerjaan teknisi terbaru yang butuh diverifikasi
        $recentTickets = Ticket::with(['customer.user', 'technician'])
            ->where('status', 'resolved')
            ->latest()
            ->take(5)
            ->get();

        // Mengarah ke resources/views/Admin/index.blade.php
        return view('Admin.index', compact('stats', 'recentTickets'));
    }
}