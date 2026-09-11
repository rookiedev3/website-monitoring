<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Website;
use App\Services\PingHistoryService;
use Illuminate\Support\Collection;

class MonitoringController extends Controller
{
    public function __construct(protected PingHistoryService $pingHistory) {}

    public function index()
    {
        // Catatan: relasi 'pingLogs' dari DB TIDAK dipakai lagi.
        // Riwayat ping & persentase uptime sekarang berasal dari Cache (file/database driver).
        $websites = $this->attachPingCacheData(
            Website::with(['latestLog'])->orderBy('website_name')->get()
        );

        $stats = $this->buildStats($websites);

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

        // Riwayat ping realtime (30 terakhir) untuk grafik di halaman detail, dari cache.
        $pingHistory = $this->pingHistory->get($website->id);
        $uptimePercentage = $this->pingHistory->uptimePercentage($website->id);

        return view('dashboard.show', compact('website', 'logs', 'incidents', 'pingHistory', 'uptimePercentage'));
    }

    public function apiStatus()
    {
        // Dipanggil oleh AJAX setiap beberapa detik dari dashboard.
        // Ping history & uptime % dibaca langsung dari Cache (file/database), bukan query berat ke DB.
        $websites = $this->attachPingCacheData(
            Website::with(['latestLog'])->get()
        );

        $stats = $this->buildStats($websites);

        return response()->json([
            'stats' => $stats,
            'websites' => $websites,
        ]);
    }

    /**
     * Tempelkan `ping_history` (array) dan `uptime_percentage` ke setiap
     * model Website berdasarkan data ring buffer di Cache (file/database).
     */
    private function attachPingCacheData(Collection $websites): Collection
    {
        return $websites->map(function (Website $website) {
            $website->ping_history = $this->pingHistory->get($website->id);
            $website->uptime_percentage = $this->pingHistory->uptimePercentage($website->id);
            $website->last_status = $website->latestLog?->status;

            return $website;
        });
    }

    private function buildStats(Collection $websites): array
    {
        return [
            'total' => $websites->count(),
            'online' => $websites->filter(fn ($w) => ($w->last_status ?? optional($w->latestLog)->status) === 'online')->count(),
            'warning' => $websites->filter(fn ($w) => ($w->last_status ?? optional($w->latestLog)->status) === 'warning')->count(),
            'down' => $websites->filter(fn ($w) => in_array($w->last_status ?? optional($w->latestLog)->status, ['down', 'ssl_error']))->count(),
            'paused' => $websites->filter(fn ($w) => $w->monitoring_status === 'paused')->count(),
        ];
    }
}
