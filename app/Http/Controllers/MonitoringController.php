<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\MonitoringLog;
use App\Models\Incident;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    /**
     * Menampilkan Dashboard Utama Monitoring Status Website
     */
    public function index()
    {
        // 1. Ambil seluruh master website beserta log pengecekan terbarunya
        $websites = Website::with('latestLog')
            ->orderBy('website_name')
            ->get();

        // 2. Ambil ringkasan statistik status terkini
        $stats = [
            'total' => $websites->count(),
            'online' => $websites->filter(fn($w) => optional($w->latestLog)->status === 'online')->count(),
            'warning' => $websites->filter(fn($w) => optional($w->latestLog)->status === 'warning')->count(),
            'down' => $websites->filter(fn($w) => in_array(optional($w->latestLog)->status, ['down', 'ssl_error']))->count(),
        ];

        // 3. Ambil insiden aktif (Open / On Progress)
        $activeIncidents = Incident::with(['website', 'assignedUser'])
            ->active()
            ->latest()
            ->get();

        return view('monitoring.index', compact('websites', 'stats', 'activeIncidents'));
    }

    /**
     * Menampilkan Detail Riwayat Log untuk Satu Website
     */
    public function show(Website $website)
    {
        $logs = $website->monitoringLogs()
            ->latest('checked_at')
            ->paginate(15);

        $incidents = $website->incidents()
            ->with(['assignedUser', 'notes.user'])
            ->latest()
            ->get();

        return view('monitoring.show', compact('website', 'logs', 'incidents'));
    }

    public function apiStatus()
    {
        $websites = Website::with('latestLog')->get();

        $stats = [
            'total' => $websites->count(),
            'online' => $websites->filter(fn($w) => optional($w->latestLog)->status === 'online')->count(),
            'warning' => $websites->filter(fn($w) => optional($w->latestLog)->status === 'warning')->count(),
            'down' => $websites->filter(fn($w) => in_array(optional($w->latestLog)->status, ['down', 'ssl_error']))->count(),
        ];

        return response()->json([
            'stats' => $stats,
            'websites' => $websites
        ]);
    }
    
}