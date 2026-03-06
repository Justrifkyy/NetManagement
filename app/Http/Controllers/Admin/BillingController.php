<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    // 1. Tampilkan Daftar Tagihan & Statistik
    public function index()
    {
        $invoices = Invoice::with(['subscription.customer.user', 'subscription.package'])
            ->latest()
            ->get();

        $stats = [
            'paid_this_month' => Invoice::where('status', 'paid')->whereMonth('paid_at', now()->month)->sum('amount'),
            'unpaid_total'    => Invoice::where('status', 'unpaid')->sum('amount'),
            'unpaid_count'    => Invoice::where('status', 'unpaid')->count(),
        ];

        return view('Admin.billing.index', compact('invoices', 'stats'));
    }

    // 2. Tampilkan Detail Tagihan (Invoice)
    public function show(Invoice $invoice)
    {
        $invoice->load(['subscription.customer.user', 'subscription.package']);
        return view('Admin.billing.show', compact('invoice'));
    }

    // 3. Konfirmasi Pembayaran Manual (Oleh Admin)
    public function markAsPaid(Request $request, Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'Tagihan ini sudah lunas.');
        }

        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
            'payment_method' => 'manual_admin',
        ]);

        // Opsional: Jika pelanggan terisolir, kita bisa menyalakan internetnya kembali di sini nanti

        return back()->with('success', 'Tagihan berhasil ditandai LUNAS secara manual.');
    }

    // Tampilkan Form Edit Tagihan
    public function edit(Invoice $invoice)
    {
        $invoice->load(['subscription.customer.user', 'subscription.package']);
        return view('Admin.billing.edit', compact('invoice'));
    }

    // Simpan Perubahan Tagihan
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:unpaid,paid',
        ]);

        $data = $request->except(['_token', '_method']);

        // Jika diubah jadi lunas tapi tanggal bayar kosong, otomatis isi dengan hari ini
        if ($data['status'] === 'paid' && empty($data['paid_at'])) {
            $data['paid_at'] = now();
        } elseif ($data['status'] === 'unpaid') {
            $data['paid_at'] = null; // Kosongkan tanggal bayar jika diubah kembali ke belum lunas
        }

        $invoice->update($data);

        return redirect()->route('admin.billing.show', $invoice->id)->with('success', 'Data tagihan berhasil diperbarui oleh Admin.');
    }
}