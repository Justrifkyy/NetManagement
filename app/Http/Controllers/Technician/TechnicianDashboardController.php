<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller; // Wajib import Base Controller
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class TechnicianDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Tiket baru yang belum diambil (Jobdesk)
        $openTickets = Ticket::where('status', 'open')->count();
        
        // 2. Tugas aktif yang sedang dikerjakan teknisi ini
        $myActiveTasks = Ticket::where('technician_id', $user->id)
            ->whereIn('status', ['assigned', 'in_progress'])
            ->count();
            
        // 3. Pekerjaan yang diselesaikan bulan ini
        $completedThisMonth = Ticket::where('technician_id', $user->id)
            ->whereIn('status', ['resolved', 'closed'])
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();

        // Mengarah ke resources/views/technician/index.blade.php
        return view('technician.dashboard.index', compact('openTickets', 'myActiveTasks', 'completedThisMonth'));
    }
}