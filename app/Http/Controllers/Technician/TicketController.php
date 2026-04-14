<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller; // Wajib import Base Controller
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

    public function index()
    {
        // Hanya tiket OPEN (Belum diambil siapapun)
        $tickets = Ticket::with(['customer.user'])
            ->where('status', 'open')
            ->latest()
            ->get();

        return view('technician.ticket.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->status !== 'open') {
            return redirect()->route('technician.ticket.index')->with('error', 'Tiket ini sudah tidak tersedia.');
        }

        return view('technician.ticket.show', compact('ticket'));
    }

    public function claim(Ticket $ticket)
    {
        if ($ticket->status !== 'open') {
            return back()->with('error', 'Tiket sudah diambil teknisi lain.');
        }

        $ticket->update([
            'technician_id' => Auth::id(),
            'status' => 'assigned', // Tugas diambil
        ]);

        return redirect()->route('technician.process.index')->with('success', 'Tugas berhasil diambil! Silakan mulai pengerjaan di menu Meja Kerja.');
    }

    // ==========================================
    // AREA 2: PROCESSED (MEJA KERJA TEKNISI)
    // ==========================================

    public function processIndex()
    {
        $tickets = Ticket::with(['customer.user'])
            ->where('technician_id', Auth::id())
            ->orderByRaw("FIELD(status, 'assigned', 'in_progress', 'resolved', 'closed')") 
            ->latest()
            ->get();

        return view('technician.ticket.process.index', compact('tickets'));
    }

    public function processInput(Ticket $ticket)
    {
        if ($ticket->technician_id !== Auth::id()) abort(403);

        $routers = NetworkAsset::where('is_active', true)->get();

        if ($ticket->status === 'assigned') {
            $ticket->update(['status' => 'in_progress']);
        }

        return view('technician.ticket.process.update', compact('ticket', 'routers'));
    }

    public function processStore(Request $request, Ticket $ticket)
    {
        if ($ticket->technician_id !== Auth::id()) abort(403);

        $this->updateTicketData($request, $ticket);

        return redirect()->route('technician.process.show', $ticket->id)->with('success', 'Laporan pekerjaan berhasil disimpan!');
    }

    public function processShow(Ticket $ticket)
    {
        if ($ticket->technician_id !== Auth::id()) abort(403);

        return view('technician.ticket.process.show', compact('ticket'));
    }

    public function processEdit(Ticket $ticket)
    {
        if ($ticket->technician_id !== Auth::id()) abort(403);

        if ($ticket->status === 'closed') {
            return back()->with('error', 'Tiket sudah ditutup oleh Admin, tidak bisa diedit.');
        }

        $routers = NetworkAsset::where('is_active', true)->get();
        return view('technician.ticket.process.edit', compact('ticket', 'routers'));
    }

    public function processUpdate(Request $request, Ticket $ticket)
    {
        if ($ticket->technician_id !== Auth::id()) abort(403);

        $this->updateTicketData($request, $ticket);

        return redirect()->route('technician.process.show', $ticket->id)->with('success', 'Data laporan berhasil diperbarui.');
    }

    // ==========================================
    // PRIVATE HELPER (LOGIKA INTI)
    // ==========================================

    private function updateTicketData($request, Ticket $ticket)
    {
        $request->validate([
            'installation_status' => 'required',
            'location_photo' => 'nullable|image|max:5120',
            'speedtest_photo' => 'nullable|image|max:5120',
            'evidence_photo' => 'nullable|image|max:5120',
        ]);

        $locPath = $request->file('location_photo') ? $request->file('location_photo')->store('uploads/teknisi/lokasi', 'public') : $ticket->location_photo_path;
        $speedPath = $request->file('speedtest_photo') ? $request->file('speedtest_photo')->store('uploads/teknisi/speedtest', 'public') : $ticket->speedtest_photo_path;
        $eviPath = $request->file('evidence_photo') ? $request->file('evidence_photo')->store('uploads/teknisi/bukti', 'public') : $ticket->evidence_photo_path;

        $ticket->update([
            'survey_status' => $request->survey_status,
            'survey_date' => $request->survey_date,
            'survey_notes' => $request->survey_notes,
            'location_obstacle' => $request->location_obstacle,
            'location_photo_path' => $locPath,

            'installation_date' => $request->installation_date,
            'connection_type' => $request->connection_type,
            'cable_length' => $request->cable_length,
            'mounting_position' => $request->mounting_position,
            'installation_status' => $request->installation_status,
            'installation_notes' => $request->installation_notes,

            'device_type' => $request->device_type,
            'device_brand' => $request->device_brand,
            'device_sn' => $request->device_sn,
            'device_mac' => $request->device_mac,
            'device_condition' => $request->device_condition,

            'router_id' => $request->router_id,
            'port_interface' => $request->port_interface,
            'vlan_id' => $request->vlan_id,
            'olt_source' => $request->olt_source,
            'connection_mode' => $request->connection_mode,
            'odp_port' => $request->odp_port,
            'dbm_signal' => $request->dbm_signal,

            'pppoe_username' => $request->pppoe_username,
            'pppoe_password' => $request->pppoe_password,
            'service_status' => $request->service_status,

            'connectivity_status' => $request->connectivity_status,
            'speed_test_result' => $request->speed_test_result,
            'latency' => $request->latency,
            'speedtest_photo_path' => $speedPath,

            'internet_active_confirmation' => $request->has('internet_active_confirmation'),
            'handover_date' => $request->handover_date,
            'final_technician_notes' => $request->final_technician_notes,
            'evidence_photo_path' => $eviPath,

            'status' => 'resolved',
            'completed_at' => now(),
        ]);
    }
}