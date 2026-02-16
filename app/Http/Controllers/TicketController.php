<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\NetworkAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    // ==========================================
    // AREA 1: JOBDESK (BURSA TUGAS)
    // ==========================================

    /**
     * Menampilkan daftar tiket yang masih OPEN (Belum diambil siapapun).
     */
    public function index()
    {
        $tickets = Ticket::with(['customer.user'])
            ->where('status', 'open')
            ->latest()
            ->get();

        return view('technician.tickets.index', compact('tickets'));
    }

    /**
     * Menampilkan detail tiket OPEN untuk direview sebelum diambil.
     */
    public function show(Ticket $ticket)
    {
        // Pastikan tiket masih open agar tidak bisa diintip jika sudah diambil orang lain
        if ($ticket->status !== 'open') {
            return redirect()->route('technician.tickets.index')->with('error', 'Tiket ini sudah tidak tersedia.');
        }

        return view('technician.tickets.show', compact('ticket'));
    }

    /**
     * Proses mengambil tiket (Claim).
     * Memindahkan tiket dari Jobdesk ke "Tugas Saya".
     */
    public function claim(Ticket $ticket)
    {
        if ($ticket->status !== 'open') {
            return back()->with('error', 'Tiket sudah diambil teknisi lain.');
        }

        $ticket->update([
            'technician_id' => Auth::id(),
            'status' => 'assigned', // Status berubah jadi Assigned (Tugaskan)
        ]);

        // Redirect langsung ke daftar "Processed" (Tugas Saya)
        return redirect()->route('technician.process.index')->with('success', 'Tugas berhasil diambil! Silakan mulai pengerjaan di menu Processed.');
    }

    // ==========================================
    // AREA 2: PROCESSED (MEJA KERJA TEKNISI)
    // ==========================================

    /**
     * Menampilkan daftar tugas milik teknisi yang sedang login.
     * Baik yang masih dikerjakan (Assigned) maupun yang sudah selesai (Resolved).
     */
    public function processIndex()
    {
        $tickets = Ticket::with(['customer.user'])
            ->where('technician_id', Auth::id())
            ->orderByRaw("FIELD(status, 'assigned', 'in_progress', 'resolved', 'closed')") // Prioritas sorting
            ->latest()
            ->get();

        return view('technician.tickets.process.index', compact('tickets'));
    }

    /**
     * Menampilkan Form Input Data (Worksheet) pertama kali.
     * View: update.blade.php
     */
    public function processInput(Ticket $ticket)
    {
        // Keamanan: Pastikan tiket ini milik teknisi yang login
        if ($ticket->technician_id !== Auth::id()) {
            abort(403);
        }

        $routers = NetworkAsset::where('is_active', true)->get();

        // Ubah status jadi in_progress saat mulai mengisi form
        if ($ticket->status === 'assigned') {
            $ticket->update(['status' => 'in_progress']);
        }

        return view('technician.tickets.process.update', compact('ticket', 'routers'));
    }

    /**
     * Menyimpan data laporan dari form Input.
     */
    public function processStore(Request $request, Ticket $ticket)
    {
        if ($ticket->technician_id !== Auth::id()) {
            abort(403);
        }

        $this->updateTicketData($request, $ticket);

        return redirect()->route('technician.process.show', $ticket->id)->with('success', 'Laporan pekerjaan berhasil disimpan!');
    }

    /**
     * Menampilkan Detail Hasil Laporan yang sudah diisi (Read Only).
     * View: show.blade.php (di folder process)
     */
    public function processShow(Ticket $ticket)
    {
        if ($ticket->technician_id !== Auth::id()) {
            abort(403);
        }

        return view('technician.tickets.process.show', compact('ticket'));
    }

    /**
     * Menampilkan Form Edit untuk merevisi data laporan.
     * View: edit.blade.php
     */
    public function processEdit(Ticket $ticket)
    {
        if ($ticket->technician_id !== Auth::id()) {
            abort(403);
        }

        // Cegah edit jika status sudah closed (Final)
        if ($ticket->status === 'closed') {
            return back()->with('error', 'Tiket sudah ditutup oleh Admin, tidak bisa diedit.');
        }

        $routers = NetworkAsset::where('is_active', true)->get();
        return view('technician.tickets.process.edit', compact('ticket', 'routers'));
    }

    /**
     * Menyimpan perubahan data dari form Edit.
     */
    public function processUpdate(Request $request, Ticket $ticket)
    {
        if ($ticket->technician_id !== Auth::id()) {
            abort(403);
        }

        $this->updateTicketData($request, $ticket);

        return redirect()->route('technician.process.show', $ticket->id)->with('success', 'Data laporan berhasil diperbarui.');
    }

    // ==========================================
    // PRIVATE HELPER (LOGIKA INTI)
    // ==========================================

    /**
     * Fungsi privat untuk menangani validasi, upload file, dan update database
     * Digunakan oleh processStore dan processUpdate agar tidak duplikasi kode.
     */
    private function updateTicketData($request, Ticket $ticket)
    {
        // 1. Validasi Input
        $request->validate([
            'installation_status' => 'required',
            // File validasi (opsional saat update jika tidak diganti)
            'location_photo' => 'nullable|image|max:5120',
            'speedtest_photo' => 'nullable|image|max:5120',
            'evidence_photo' => 'nullable|image|max:5120',
        ]);

        // 2. Handle Upload File
        // Jika ada file baru diupload, simpan dan ganti path lama. Jika tidak, pakai path lama.
        $locPath = $request->file('location_photo') ? $request->file('location_photo')->store('uploads/teknisi/lokasi', 'public') : $ticket->location_photo_path;

        $speedPath = $request->file('speedtest_photo') ? $request->file('speedtest_photo')->store('uploads/teknisi/speedtest', 'public') : $ticket->speedtest_photo_path;

        $eviPath = $request->file('evidence_photo') ? $request->file('evidence_photo')->store('uploads/teknisi/bukti', 'public') : $ticket->evidence_photo_path;

        // 3. Update Database (Massive Update sesuai inputan teknisi)
        $ticket->update([
            // --- A. SURVEY ---
            'survey_status' => $request->survey_status,
            'survey_date' => $request->survey_date,
            'survey_notes' => $request->survey_notes,
            'location_obstacle' => $request->location_obstacle,
            'location_photo_path' => $locPath,

            // --- B. INSTALASI ---
            'installation_date' => $request->installation_date,
            'connection_type' => $request->connection_type,
            'cable_length' => $request->cable_length,
            'mounting_position' => $request->mounting_position,
            'installation_status' => $request->installation_status, // Berhasil / Gagal
            'installation_notes' => $request->installation_notes,

            // --- C. PERANGKAT ---
            'device_type' => $request->device_type,
            'device_brand' => $request->device_brand,
            'device_sn' => $request->device_sn,
            'device_mac' => $request->device_mac,
            'device_condition' => $request->device_condition,

            // --- D. JARINGAN ---
            'router_id' => $request->router_id,
            'port_interface' => $request->port_interface,
            'vlan_id' => $request->vlan_id,
            'olt_source' => $request->olt_source,
            'connection_mode' => $request->connection_mode,
            'odp_port' => $request->odp_port,
            'dbm_signal' => $request->dbm_signal,

            // --- E. AKUN INTERNET ---
            'pppoe_username' => $request->pppoe_username,
            'pppoe_password' => $request->pppoe_password,
            'service_status' => $request->service_status,

            // --- F. UJI KONEKSI ---
            'connectivity_status' => $request->connectivity_status,
            'speed_test_result' => $request->speed_test_result,
            'latency' => $request->latency,
            'speedtest_photo_path' => $speedPath,

            // --- G. SERAH TERIMA ---
            'internet_active_confirmation' => $request->has('internet_active_confirmation'),
            'handover_date' => $request->handover_date,
            'final_technician_notes' => $request->final_technician_notes,
            'evidence_photo_path' => $eviPath,

            // Status Akhir
            'status' => 'resolved', // Menandakan teknisi sudah selesai lapor
            'completed_at' => now(),
        ]);
    }
}
