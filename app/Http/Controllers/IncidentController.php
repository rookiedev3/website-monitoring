<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\IncidentNote;
use App\Models\MonitoringLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class IncidentController extends Controller
{
    public function index(Request $request): View
    {
        $incidents = Incident::with(['website', 'assignedUser'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('pic'), fn ($q) => $q->where('assigned_to', $request->pic))
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->whereHas('website', function ($sub) use ($search) {
                    $sub->where('website_name', 'like', "%{$search}%")
                        ->orWhere('domain', 'like', "%{$search}%");
                })->orWhere('incident_type', 'like', "%{$search}%");
            })
            ->latest('started_at')
            ->paginate(10)
            ->withQueryString();

        $picOptions = User::where('role', 'programmer')->orderBy('name')->get();

        return view('incidents.index', compact('incidents', 'picOptions'));
    }

    /**
     * Endpoint JSON untuk pencarian & filter realtime (AJAX) di halaman index,
     * sama gayanya dengan api.dashboard.status. Mengembalikan SELURUH incident
     * (tanpa filter di server) — pencarian, filter status/PIC, dan pagination
     * dilakukan sepenuhnya di client (JS), sesuai gaya dashboard.
     */
    public function apiStatus(): JsonResponse
    {
        $incidents = Incident::with(['website', 'assignedUser'])
            ->latest('started_at')
            ->get()
            ->map(function (Incident $incident) {
                return [
                    'id' => $incident->id,
                    'website_name' => $incident->website->website_name,
                    'customer_name' => $incident->website->customer_name,
                    'domain' => $incident->website->domain,
                    'incident_type' => $incident->incident_type,
                    'type_label' => $incident->type_label,
                    'started_at' => $incident->started_at->toIso8601String(),
                    'resolved_at' => $incident->resolved_at?->toIso8601String(),
                    'duration' => $incident->formatted_duration,
                    'is_running' => $incident->status !== 'solved',
                    'status' => $incident->status,
                    'badge_class' => $incident->badge_class,
                    'assigned_to' => $incident->assigned_to,
                    'assigned_user_name' => $incident->assignedUser?->name,
                    'show_url' => route('incidents.show', $incident->id),
                ];
            });

        return response()->json(['incidents' => $incidents]);
    }

    public function show(Incident $incident): View
    {
        $incident->load(['website', 'assignedUser', 'notes.user']);

        $latestLog = MonitoringLog::where('website_id', $incident->website_id)
            ->latest('checked_at')
            ->first();

        // Log pengecekan yang terjadi SELAMA insiden ini berlangsung saja:
        // dari started_at sampai resolved_at (kalau sudah solved), atau sampai
        // sekarang kalau masih open/on_progress.
        $incidentLogs = MonitoringLog::where('website_id', $incident->website_id)
            ->where('checked_at', '>=', $incident->started_at)
            ->when($incident->resolved_at, function ($q) use ($incident) {
                $q->where('checked_at', '<=', $incident->resolved_at);
            })
            ->orderBy('checked_at')
            ->get();

        $picOptions = User::where('role', 'programmer')->orderBy('name')->get();

        return view('incidents.show', compact('incident', 'latestLog', 'incidentLogs', 'picOptions'));
    }

    /**
     * Programmer "ambil" incident yang masih open -> jadi PIC + status on_progress.
     */
    public function take(Incident $incident): RedirectResponse
    {
        $user = Auth::user();

        if ($user->role !== 'programmer') {
            abort(403, 'Hanya programmer yang bisa mengambil incident.');
        }

        if ($incident->status !== 'open') {
            return back()->with('error', 'Incident ini sudah ditangani.');
        }

        $incident->update([
            'assigned_to' => $user->id,
            'status' => 'on_progress',
        ]);

        return back()->with('success', 'Incident berhasil diambil, silakan lanjutkan penanganan.');
    }

    /**
     * Tambah catatan penanganan. Khusus programmer (yang jadi PIC incident ini).
     */
    public function storeNote(Request $request, Incident $incident): RedirectResponse
    {
        $user = Auth::user();

        if ($user->role !== 'programmer') {
            abort(403, 'Hanya programmer yang bisa menambahkan catatan.');
        }

        if ($incident->assigned_to !== $user->id) {
            abort(403, 'Anda bukan PIC incident ini.');
        }

        $request->validate([
            'note' => 'required|string',
        ], [
            'note.required' => 'Catatan tidak boleh kosong',
        ]);

        IncidentNote::create([
            'incident_id' => $incident->id,
            'user_id' => $user->id,
            'note' => $request->note,
        ]);

        return back()->with('success', 'Catatan berhasil ditambahkan.');
    }

    public function update(Request $request, Incident $incident): RedirectResponse
    {
        $user = Auth::user();

        if ($user->role === 'super_admin') {
            $data = $request->validate([
                'assigned_to' => 'nullable|exists:users,id',
            ]);

            if (! empty($data['assigned_to']) && $incident->status === 'open') {
                $data['status'] = 'on_progress';
            }

            $incident->update($data);

            return back()->with('success', 'Incident berhasil diperbarui.');

        } elseif ($user->role === 'programmer') {
            if ($incident->assigned_to !== $user->id) {
                abort(403, 'Anda bukan PIC incident ini.');
            }

            // Laporan (root cause, penyelesaian, catatan) HANYA boleh diisi
            // SETELAH website kembali online dan sistem sudah menandai incident
            // ini 'solved'. Selama masih open/on_progress, PIC cukup menangani
            // dulu di lapangan — laporan baru relevan begitu sudah confirmed up.
            if ($incident->status !== 'solved') {
                return back()->with('error', 'Laporan baru bisa diisi setelah website kembali online dan incident berstatus Solved.');
            }

            // Satu-satunya proteksi one-time-submit: root_cause yang sudah pernah diisi.
            if ($incident->root_cause) {
                abort(403, 'Penanganan untuk incident ini sudah dikirim sebelumnya.');
            }

            $data = $request->validate([
                'root_cause' => 'required|string',
                'resolution' => 'required|string',
                'note' => 'nullable|string',
            ], [
                'root_cause.required' => 'Root cause wajib diisi',
                'resolution.required' => 'Penyelesaian wajib diisi',
            ]);

            $note = $data['note'] ?? null;
            unset($data['note']);

            // Catat kapan laporan ini dikirim. Dibandingkan dengan resolved_at + 48 jam
            // (dihitung di view) untuk menentukan apakah PIC masih dapat "kredit"
            // sebagai penyelesai, atau incident tetap tercatat Auto-resolved karena
            // laporan baru masuk setelah batas waktu.
            $data['report_submitted_at'] = now();

            $incident->update($data);

            if ($note) {
                IncidentNote::create([
                    'incident_id' => $incident->id,
                    'user_id' => $user->id,
                    'note' => $note,
                ]);
            }

            return back()->with('success', 'Laporan penanganan berhasil dikirim. Incident akan otomatis ditandai Solved setelah sistem mengonfirmasi website kembali online.');

        } else {
            abort(403, 'Anda tidak punya akses untuk mengubah incident.');
        }
    }
}