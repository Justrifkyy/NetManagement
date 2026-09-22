<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
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
            // 1. Total seluruh pelanggan terdaftar
            'total_customers' => Customer::count(),

            // 2. Total pelanggan yang internetnya sedang aktif
            'active_subs' => Subscription::where('status', 'active')->count(),

            // 3. Total pelanggan yang sedang diisolir
            'isolated_customers' => Customer::where('is_isolated', true)->count(),

            // 4. Total uang dari tagihan yang sudah lunas
            'total_revenue' => Invoice::where('status', 'paid')->sum('amount'),

            // 5. Jumlah tiket QC (Selesai dipasang, butuh verifikasi Admin)
            'pending_qc'  => Ticket::where('status', 'resolved')->count(),

            // 6. Jumlah prospek baru
            'new_leads'   => Lead::where('status', 'prospek')->count(),
        ];


        // Ambil 5 tiket terbaru yang menunggu QC dengan optimized eager loading
        $pendingTickets = Ticket::with(['customer.user', 'technician'])
            ->where('status', 'resolved')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'pendingTickets'));
    }
}