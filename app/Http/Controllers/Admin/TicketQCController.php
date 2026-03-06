<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\NetworkAsset; // Import ini untuk pilihan Router
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TicketQCController extends Controller
{
    // 1. Tampilkan Daftar Tiket
    public function index()
    {
        $tickets = Ticket::with(['customer.user', 'technician'])
            ->where('status', 'resolved')
            ->latest()
            ->get();

        return view('Admin.tickets.index', compact('tickets'));
    }

    // 2. Tampilkan Detail Laporan
    public function show(Ticket $ticket)
    {
        return view('Admin.tickets.show', compact('ticket'));
    }

    // 3. EDIT: Form untuk Admin
    public function edit(Ticket $ticket)
    {
        $routers = NetworkAsset::where('is_active', true)->get();
        return view('Admin.tickets.edit', compact('ticket', 'routers'));
    }

    // 4. UPDATE: Simpan Perubahan dari Admin
    public function update(Request $request, Ticket $ticket)
    {
        // Menyimpan data teks
        $ticket->update($request->except(['_token', '_method', 'location_photo', 'speedtest_photo', 'evidence_photo']));

        // Menyimpan jika Admin ikut mengupdate foto
        if ($request->hasFile('location_photo')) {
            $ticket->update(['location_photo_path' => $request->file('location_photo')->store('uploads/teknisi/lokasi', 'public')]);
        }
        if ($request->hasFile('speedtest_photo')) {
            $ticket->update(['speedtest_photo_path' => $request->file('speedtest_photo')->store('uploads/teknisi/speedtest', 'public')]);
        }
        if ($request->hasFile('evidence_photo')) {
            $ticket->update(['evidence_photo_path' => $request->file('evidence_photo')->store('uploads/teknisi/bukti', 'public')]);
        }

        return redirect()->route('admin.tickets.show', $ticket->id)->with('success', 'Data laporan teknisi berhasil direvisi oleh Admin.');
    }

    // 5. ACTION: Setujui & Aktifkan
    public function approve(Request $request, Ticket $ticket)
    {
        if ($ticket->status !== 'resolved') {
            return back()->with('error', 'Hanya tiket status Resolved yang bisa diaktivasi.');
        }

        DB::transaction(function () use ($ticket) {
            $ticket->update(['status' => 'closed', 'completed_at' => now()]);

            $package = $ticket->customer->lead->package;
            $subscription = Subscription::create([
                'customer_id' => $ticket->customer_id,
                'package_id' => $package->id,
                'pppoe_username' => $ticket->pppoe_username,
                'pppoe_password' => $ticket->pppoe_password,
                'ip_address' => $ticket->connection_mode === 'Static IP' ? '192.168.1.100' : null,
                'installation_date' => $ticket->installation_date ?? now(),
                'billing_due_date' => Carbon::now()->addMonth()->day,
                'status' => 'active',
            ]);

            $totalAmount = $package->price + ($package->installation_fee ?? 0);
            Invoice::create([
                'subscription_id' => $subscription->id,
                'invoice_number' => 'INV-' . date('Ymd') . '-' . str_pad($subscription->id, 4, '0', STR_PAD_LEFT),
                'amount' => $totalAmount,
                'status' => 'unpaid',
                'due_date' => Carbon::now()->addDays(7),
                'payment_method' => 'manual',
            ]);
            
            $ticket->customer->lead->update(['status' => 'aktif']);
        });

        return redirect()->route('admin.tickets.index')->with('success', 'QC Berhasil! Internet aktif & Tagihan telah diterbitkan.');
    }

    // 6. ACTION: Tolak (Kembalikan ke Teknisi)
    public function reject(Request $request, Ticket $ticket)
    {
        $request->validate(['reject_reason' => 'required|string']);

        $ticket->update([
            'status' => 'in_progress',
            'final_technician_notes' => $ticket->final_technician_notes . "\n\n[REVISI ADMIN]: " . $request->reject_reason
        ]);

        return redirect()->route('admin.tickets.index')->with('warning', 'Laporan dikembalikan ke teknisi untuk direvisi.');
    }
}