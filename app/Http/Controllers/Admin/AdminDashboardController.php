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
        $stats = [
            // 1. Total pelanggan yang internetnya sedang aktif
            'active_subs' => Subscription::where('status', 'active')->count(),
            
            // 2. Total uang dari tagihan yang sudah lunas (Ini yang menyebabkan error tadi)
            'total_revenue' => Invoice::where('status', 'paid')->sum('amount'),
            
            // 3. Jumlah tiket QC (Selesai dipasang, butuh verifikasi Admin)
            'pending_qc'  => Ticket::where('status', 'resolved')->count(), 
            
            // 4. Jumlah prospek baru
            'new_leads'   => Lead::where('status', 'prospek')->count(),
        ];

        // Ambil 5 tiket terbaru yang menunggu QC
        $pendingTickets = Ticket::with(['customer.user', 'technician'])
            ->where('status', 'resolved')
            ->latest()
            ->take(5)
            ->get();

        return view('Admin.index', compact('stats', 'pendingTickets'));
    }
}