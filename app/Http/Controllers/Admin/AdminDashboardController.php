<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Subscription;
use App\Models\Lead;
use App\Models\Invoice; // Pastikan ini ada
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Menghitung statistik untuk Widget di Dashboard Admin
        // Using count() is more efficient than with() when you only need counts
        $stats = [
            // 1. Total pelanggan yang internetnya sedang aktif
            'active_subs' => Subscription::where('status', 'active')->count(),
            
            // 2. Total uang dari tagihan yang sudah lunas
            'total_revenue' => Invoice::where('status', 'paid')->sum('amount'),
            
            // 3. Jumlah tiket QC (Selesai dipasang, butuh verifikasi Admin)
            'pending_qc'  => Ticket::where('status', 'resolved')->count(), 
            
            // 4. Jumlah prospek baru
            'new_leads'   => Lead::where('status', 'prospek')->count(),
        ];

        // Ambil 5 tiket terbaru yang menunggu QC dengan optimized eager loading
        $pendingTickets = Ticket::with(['customer.user', 'technician.user'])
            ->where('status', 'resolved')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'pendingTickets'));
    }
}