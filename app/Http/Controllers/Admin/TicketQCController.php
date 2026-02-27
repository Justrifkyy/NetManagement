<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Subscription;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TicketQCController extends Controller
{
    // 1. Tampilkan Daftar Tiket yang Butuh QC (Status: Resolved)
    public function index()
    {
        $tickets = Ticket::with(['customer.user', 'technician'])
            ->where('status', 'resolved')
            ->latest()
            ->get();

        return view('Admin.tickets.index', compact('tickets'));
    }

    // 2. Tampilkan Detail Laporan Teknisi
    public function show(Ticket $ticket)
    {
        return view('Admin.tickets.show', compact('ticket'));
    }

    // 3. ACTION: Setujui & Aktifkan Pelanggan
    public function approve(Request $request, Ticket $ticket)
    {
        if ($ticket->status !== 'resolved') {
            return back()->with('error', 'Hanya tiket status Resolved yang bisa diaktivasi.');
        }

        DB::transaction(function () use ($ticket) {
            // A. Tutup Tiket
            $ticket->update([
                'status' => 'closed',
                'completed_at' => now(),
            ]);

            // B. Buat Langganan (Subscription)
            $package = $ticket->customer->lead->package;
            $subscription = Subscription::create([
                'customer_id' => $ticket->customer_id,
                'package_id' => $package->id,
                'pppoe_username' => $ticket->pppoe_username,
                'pppoe_password' => $ticket->pppoe_password,
                'ip_address' => $ticket->connection_mode === 'Static IP' ? '192.168.1.100' : null,
                'installation_date' => $ticket->installation_date ?? now(),
                'billing_due_date' => Carbon::now()->addMonth()->day, // Tanggal jatuh tempo bulan depan
                'status' => 'active',
            ]);

            // C. Generate Invoice Pertama
            $amount = $package->price;
            $installationFee = $package->installation_fee ?? 0; // Misal ada biaya pasang
            $totalAmount = $amount + $installationFee;

            Invoice::create([
                'subscription_id' => $subscription->id,
                'invoice_number' => 'INV-' . date('Ymd') . '-' . str_pad($subscription->id, 4, '0', STR_PAD_LEFT),
                'amount' => $totalAmount,
                'status' => 'unpaid',
                'due_date' => Carbon::now()->addDays(7), // Batas bayar 7 hari
                'payment_method' => 'manual',
            ]);
            
            // D. Ubah status Lead agar marketing tahu sudah berhasil
            $ticket->customer->lead->update(['status' => 'aktif']);
        });

        return redirect()->route('admin.tickets.index')->with('success', 'QC Berhasil! Internet aktif & Tagihan telah diterbitkan.');
    }

    // 4. ACTION: Tolak (Kembalikan ke Teknisi)
    public function reject(Request $request, Ticket $ticket)
    {
        $request->validate(['reject_reason' => 'required|string']);

        $ticket->update([
            'status' => 'in_progress', // Kembalikan statusnya
            'final_technician_notes' => $ticket->final_technician_notes . "\n\n[REVISI ADMIN]: " . $request->reject_reason
        ]);

        return redirect()->route('admin.tickets.index')->with('warning', 'Laporan dikembalikan ke teknisi untuk direvisi.');
    }
}