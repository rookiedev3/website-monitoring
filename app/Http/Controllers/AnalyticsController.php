<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\MonitoringLog;
use App\Models\Website;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        [$startDate, $endDate, $range] = $this->resolveDateRange($request);

        $stats    = $this->buildStats($startDate, $endDate);
        $rankings = $this->buildRankings($startDate, $endDate);

        return view('analytics.index', [
            'stats'      => $stats,
            'mostStable' => $rankings['most_stable'],
            'mostErrors' => $rankings['most_errors'],
            'slowest'    => $rankings['slowest'],
            'range'      => $range,
            'startDate'  => $startDate->format('Y-m-d'),
            'endDate'    => $endDate->format('Y-m-d'),
        ]);
    }

    /**
     * Tentukan rentang tanggal berdasarkan filter yang dipilih user.
     *
     * @return array{0: Carbon, 1: Carbon, 2: string}
     */
    private function resolveDateRange(Request $request): array
    {
        $range = $request->input('range', '7days');
        $now   = Carbon::now();

        switch ($range) {
            case 'today':
                $start = $now->copy()->startOfDay();
                $end   = $now->copy()->endOfDay();
                break;

            case '30days':
                $start = $now->copy()->subDays(29)->startOfDay();
                $end   = $now->copy()->endOfDay();
                break;

            case 'custom':
                $start = $request->filled('start')
                    ? Carbon::parse($request->input('start'))->startOfDay()
                    : $now->copy()->subDays(6)->startOfDay();

                $end = $request->filled('end')
                    ? Carbon::parse($request->input('end'))->endOfDay()
                    : $now->copy()->endOfDay();

                // Jaga-jaga kalau user salah input (start > end)
                if ($start->greaterThan($end)) {
                    [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
                }
                break;

            case '7days':
            default:
                $range = '7days';
                $start = $now->copy()->subDays(6)->startOfDay();
                $end   = $now->copy()->endOfDay();
                break;
        }

        return [$start, $end, $range];
    }

    /**
     * Hitung 5 metrik utama di bagian atas halaman.
     */
    private function buildStats(Carbon $start, Carbon $end): array
    {
        $logsQuery = MonitoringLog::whereBetween('checked_at', [$start, $end]);

        $avgResponseTime = (clone $logsQuery)
            ->whereNotNull('response_time_ms')
            ->avg('response_time_ms');

        $totalLogs  = (clone $logsQuery)->count();
        $onlineLogs = (clone $logsQuery)->where('status', 'online')->count();

        $uptimePercentage = $totalLogs > 0
            ? round(($onlineLogs / $totalLogs) * 100, 2)
            : null;

        $incidentsQuery = Incident::whereBetween('started_at', [$start, $end]);

        $totalIncidents = (clone $incidentsQuery)->count();

        $totalDowntimeSeconds = (clone $incidentsQuery)
            ->whereNotNull('duration_seconds')
            ->sum('duration_seconds');

        $avgRecoverySeconds = (clone $incidentsQuery)
            ->whereNotNull('resolved_at')
            ->whereNotNull('duration_seconds')
            ->avg('duration_seconds');

        return [
            'avg_response_time'      => $avgResponseTime ? (int) round($avgResponseTime) : null,
            'total_incidents'        => $totalIncidents,
            'total_downtime_minutes' => $totalDowntimeSeconds ? (int) round($totalDowntimeSeconds / 60) : 0,
            'uptime_percentage'      => $uptimePercentage,
            'recovery_time_minutes'  => $avgRecoverySeconds ? (int) round($avgRecoverySeconds / 60) : null,
        ];
    }

    /**
     * Hitung 3 ranking: paling stabil, paling sering error, paling lambat.
     */
    private function buildRankings(Carbon $start, Carbon $end, int $limit = 5): array
    {
        $websites = Website::query()
            ->withCount(['incidents as incidents_count' => function ($query) use ($start, $end) {
                $query->whereBetween('started_at', [$start, $end]);
            }])
            ->with(['monitoringLogs' => function ($query) use ($start, $end) {
                $query->whereBetween('checked_at', [$start, $end])
                    ->select('id', 'website_id', 'status', 'response_time_ms');
            }])
            ->get();

        $withMetrics = $websites->map(function ($website) {
            $logs        = $website->monitoringLogs;
            $totalLogs   = $logs->count();
            $onlineLogs  = $logs->where('status', 'online')->count();
            $avgResponse = $logs->whereNotNull('response_time_ms')->avg('response_time_ms');

            return (object) [
                'website'          => $website,
                'uptime'           => $totalLogs > 0 ? round(($onlineLogs / $totalLogs) * 100, 2) : null,
                'avg_response_time'=> $avgResponse ? (int) round($avgResponse) : null,
                'incidents_count'  => $website->incidents_count,
            ];
        });

        $mostStable = $withMetrics
            ->filter(fn ($item) => $item->uptime !== null)
            ->sortByDesc('uptime')
            ->take($limit)
            ->values();

        $mostErrors = $withMetrics
            ->filter(fn ($item) => $item->incidents_count > 0)
            ->sortByDesc('incidents_count')
            ->take($limit)
            ->values();

        $slowest = $withMetrics
            ->filter(fn ($item) => $item->avg_response_time !== null)
            ->sortByDesc('avg_response_time')
            ->take($limit)
            ->values();

        return [
            'most_stable' => $mostStable,
            'most_errors' => $mostErrors,
            'slowest'     => $slowest,
        ];
    }
}