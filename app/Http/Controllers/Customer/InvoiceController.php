<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        $invoices = [];

        if ($customer) {
            // Ambil tagihan berdasarkan subscription milik customer ini
            // Eager load subscription dan customer relationships to avoid N+1
            $invoices = Invoice::with('subscription.customer')
                ->whereHas('subscription', function($query) use ($customer) {
                    $query->where('customer_id', $customer->id);
                })
                ->latest()
                ->paginate(10);
        }

        return view('user.billing.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        // Eager load relationships to avoid N+1 queries
        $invoice->load('subscription.customer.user');

        // Pastikan invoice ini milik user yang sedang login
        if ($invoice->subscription->customer->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        return view('user.billing.show', compact('invoice'));
    }

    /**
     * Handle customer self-service payment.
     * Saat ini berfungsi sebagai placeholder untuk integrasi Payment Gateway (Midtrans/dll).
     */
    public function pay(Request $request, Invoice $invoice)
    {
        // Validasi kepemilikan invoice
        $invoice->load('subscription.customer.user');

        if ($invoice->subscription->customer->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        // Jika sudah lunas, jangan proses lagi
        if ($invoice->status === 'paid') {
            return back()->with('info', 'Tagihan ini sudah berstatus lunas.');
        }

        // TODO: Integrasi Midtrans / Payment Gateway di sini
        // Untuk saat ini, arahkan ke halaman informasi pembayaran manual
        return back()->with('payment_info', [
            'invoice_number' => $invoice->invoice_number,
            'amount'         => $invoice->amount,
            'due_date'       => $invoice->due_date,
        ]);
    }
}