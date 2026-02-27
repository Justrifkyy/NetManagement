<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Menampilkan semua daftar tagihan (Lunas & Belum Lunas)
     */
    public function index()
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();

        if (!$customer) {
            abort(404, 'Data pelanggan tidak ditemukan.');
        }

        // Ambil semua tagihan yang terhubung dengan langganan pelanggan ini
        $invoices = Invoice::whereHas('subscription', function($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        })->orderBy('due_date', 'desc')->get();

        // Mengarah ke resources/views/user/billing/index.blade.php
        return view('user.billing.index', compact('invoices'));
    }

    /**
     * Menampilkan detail satu tagihan spesifik
     */
    public function show(Invoice $invoice)
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();

        // KEAMANAN: Pastikan pelanggan tidak mengintip tagihan milik orang lain
        if ($invoice->subscription->customer_id !== $customer->id) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk melihat tagihan ini.');
        }

        // Mengarah ke resources/views/user/billing/show.blade.php
        return view('user.billing.show', compact('invoice'));
    }
}