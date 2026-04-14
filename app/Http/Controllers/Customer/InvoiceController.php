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
}