<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Invoice;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        // 1. Cari data customer berdasarkan user yang sedang login (Lebih Aman)
        $customer = Customer::where('user_id', Auth::id())->first();

        // Jika profil pelanggan tidak ditemukan (Belum di-Approve Admin)
        // Arahkan ke halaman "Menunggu Persetujuan" yang ramah — bukan error 403
        if (!$customer) {
            return view('user.dashboard.pending');
        }

        // 2. Ambil data langganan yang sedang berjalan
        $subscription = $customer->subscriptions()->with('package')->latest()->first();

        // 3. Cek tagihan yang belum dibayar
        $unpaidInvoices = []; // Default array kosong
        if ($subscription) {
            $unpaidInvoices = Invoice::where('subscription_id', $subscription->id)->where('status', 'unpaid')->latest()->get();
        }

        $recentTickets = $customer->tickets()->latest()->take(5)->get();

        return view('user.dashboard.index', compact('customer', 'subscription', 'unpaidInvoices', 'recentTickets'));
    }
}
