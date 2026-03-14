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
            $invoices = Invoice::whereHas('subscription', function($query) use ($customer) {
                $query->where('customer_id', $customer->id);
            })->latest()->get();
        }

        return view('user.billing.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        // Pastikan invoice ini milik user yang sedang login
        if ($invoice->subscription->customer->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        return view('user.billing.show', compact('invoice'));
    }
}