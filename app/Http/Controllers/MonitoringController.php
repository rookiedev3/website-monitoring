<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Website;

class MonitoringController extends Controller
{
    public function index()
    {
        // Ambil website beserta log terbaru & 30 log terakhir untuk bar chart
        $websites = Website::with(['latestLog', 'monitoringLogs' => function ($query) {
            $query->latest('checked_at')->take(30);
        }])->orderBy('website_name')->get();

        $stats = [
            'total' => $websites->count(),
            'online' => $websites->filter(fn ($w) => optional($w->latestLog)->status === 'online')->count(),
            'warning' => $websites->filter(fn ($w) => optional($w->latestLog)->status === 'warning')->count(),
            'down' => $websites->filter(fn ($w) => in_array(optional($w->latestLog)->status, ['down', 'ssl_error']))->count(),
            'paused' => $websites->filter(fn ($w) => $w->monitoring_status === 'paused')->count(),
        ];

        $activeIncidents = Incident::with(['website', 'assignedUser'])
            ->whereIn('status', ['open', 'on_progress'])
            ->latest()
            ->get();

        return view('dashboard.index', compact('websites', 'stats', 'activeIncidents'));
    }

    /**
     * Menampilkan Detail Riwayat Log untuk Satu Website
     */
    public function show(Website $website)
    {
        $logs = $website->monitoringLogs()
            ->latest('checked_at')
            ->paginate(10);

        $incidents = $website->incidents()
            ->with(['assignedUser', 'notes.user'])
            ->latest()
            ->get();

        return view('dashboard.show', compact('website', 'logs', 'incidents'));
    }

    public function apiStatus()
    {
        // Ambil data beserta 30 history log untuk AJAX update
        $websites = Website::with(['latestLog', 'monitoringLogs' => function ($query) {
            $query->latest('checked_at')->take(30);
        }])->get();

        // Hitung persentase Uptime 30 pengecekan terakhir
        $websites->transform(function ($web) {
            $logs = $web->monitoringLogs;
            $totalLogs = $logs->count();
            $upLogs = $logs->filter(fn ($l) => in_array($l->status, ['online', 'warning']))->count();

            $web->uptime_percentage = $totalLogs > 0 ? round(($upLogs / $totalLogs) * 100, 1) : 100;

            return $web;
        });

        $stats = [
            'total' => $websites->count(),
            'online' => $websites->filter(fn ($w) => optional($w->latestLog)->status === 'online')->count(),
            'warning' => $websites->filter(fn ($w) => optional($w->latestLog)->status === 'warning')->count(),
            'down' => $websites->filter(fn ($w) => in_array(optional($w->latestLog)->status, ['down', 'ssl_error']))->count(),
            'paused' => $websites->filter(fn ($w) => $w->monitoring_status === 'paused')->count(),
        ];

        return response()->json([
            'stats' => $stats,
            'websites' => $websites,
        ]);
    }
}
