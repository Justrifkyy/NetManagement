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

        // Statistik berdasarkan ENUM status yang baru (optimized with single query)
        $baseQuery = Lead::where('marketing_id', $marketingId);
        $stats = [
            'total' => (clone $baseQuery)->count(),
            'prospek' => (clone $baseQuery)->where('status', 'prospek')->count(),
            'proses' => (clone $baseQuery)->whereIn('status', ['survey', 'instalasi'])->count(),
            'converted' => (clone $baseQuery)->whereIn('status', ['aktif', 'converted'])->count(),
        ];

        // 5 Prospek terakhir milik sales yang sedang login dengan eager loading
        $recentLeads = Lead::where('marketing_id', $marketingId)
            ->with('package')
            ->latest()
            ->take(5)
            ->get();

        return view('marketing.dashboard.index', compact('stats', 'recentLeads'));
    }
}