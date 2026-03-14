<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lead;

class MarketingDashboardController extends Controller
{
    public function index()
    {
        $marketingId = Auth::id();

        // Statistik berdasarkan ENUM status yang baru
        $stats = [
            'total' => Lead::where('marketing_id', $marketingId)->count(),
            'prospek' => Lead::where('marketing_id', $marketingId)->where('status', 'prospek')->count(),
            'proses' => Lead::where('marketing_id', $marketingId)->whereIn('status', ['survey', 'instalasi'])->count(),
            'converted' => Lead::where('marketing_id', $marketingId)->whereIn('status', ['aktif', 'converted'])->count(),
        ];

        // 5 Prospek terakhir milik sales yang sedang login
        $recentLeads = Lead::where('marketing_id', $marketingId)
            ->with('package')
            ->latest()
            ->take(5)
            ->get();

        return view('marketing.dashboard.index', compact('stats', 'recentLeads'));
    }
}