<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data spesifik pelanggan berdasarkan User ID yang login
        $customer = Customer::where('user_id', $user->id)->first();

        // Fallback jika terjadi anomali data (User ada tapi data Customer terhapus)
        if (!$customer) {
            return view('user.index', [
                'customer' => null, 
                'subscription' => null, 
                'unpaidInvoices' => [], 
                'recentTickets' => []
            ]);
        }

        // Ambil Data Langganan Aktif & Paketnya
        $subscription = Subscription::with('package')->where('customer_id', $customer->id)->first();

        // Ambil Tagihan yang Belum Dibayar (Jika punya langganan)
        $unpaidInvoices = [];
        if ($subscription) {
            $unpaidInvoices = Invoice::where('subscription_id', $subscription->id)
                ->where('status', 'unpaid')
                ->latest()
                ->get();
        }

        // Ambil 5 Riwayat Laporan Gangguan (Tiket) Terakhir milik pelanggan
        $recentTickets = Ticket::where('customer_id', $customer->id)
            ->latest()
            ->take(5)
            ->get();

        // Kirim data ke view (sesuai struktur folder: resources/views/user/index.blade.php)
        return view('user.index', compact('customer', 'subscription', 'unpaidInvoices', 'recentTickets'));
    }
}