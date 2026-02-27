<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller; // Wajib import Base Controller
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lead;

class MarketingDashboardController extends Controller
{
    public function index()
    {
        $marketingId = Auth::id();

        // Hitung Statistik berdasarkan status (Sesuai ENUM database yang baru)
        $stats = [
            'total' => Lead::where('marketing_id', $marketingId)->count(),
            'prospek' => Lead::where('marketing_id', $marketingId)->where('status', 'prospek')->count(),
            'proses' => Lead::where('marketing_id', $marketingId)->whereIn('status', ['survey', 'instalasi'])->count(),
            'converted' => Lead::where('marketing_id', $marketingId)->whereIn('status', ['aktif', 'converted'])->count(),
        ];

        // Ambil 5 prospek terbaru milik marketing ini
        $recentLeads = Lead::where('marketing_id', $marketingId)
            ->with('package')
            ->latest()
            ->take(5)
            ->get();

        // Mengarah ke resources/views/marketing/index.blade.php
        return view('marketing.index', compact('stats', 'recentLeads'));
    }
}