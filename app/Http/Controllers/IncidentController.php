<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\IncidentNote;
use App\Models\MonitoringLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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

    public function show(Incident $incident): View
    {
        $incident->load(['website', 'assignedUser', 'notes.user']);

        $latestLog = MonitoringLog::where('website_id', $incident->website_id)
            ->latest('checked_at')
            ->first();

        $picOptions = User::where('role', 'programmer')->orderBy('name')->get();

        return view('incidents.show', compact('incident', 'latestLog', 'picOptions'));
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
            // admin CUMA boleh ubah PIC
            $data = $request->validate([
                'assigned_to' => 'nullable|exists:users,id',
            ]);

            if (! empty($data['assigned_to']) && $incident->status === 'open') {
                $data['status'] = 'on_progress';
            }

        } elseif ($user->role === 'programmer') {
            // programmer WAJIB PIC dirinya sendiri, nggak boleh ubah assigned_to ke orang lain
            if ($incident->assigned_to !== $user->id) {
                abort(403, 'Anda bukan PIC incident ini.');
            }

            $data = $request->validate([
                'status'     => ['required', Rule::in(['on_progress', 'solved'])],
                'root_cause' => 'nullable|string',
                'resolution' => 'nullable|string',
            ], [
                'status.required' => 'Status wajib dipilih',
            ]);

            if ($data['status'] === 'solved' && $incident->status !== 'solved') {
                $data['resolved_at']      = now();
                $data['duration_seconds'] = abs(now()->diffInSeconds($incident->started_at));
            }

        } else {
            abort(403, 'Anda tidak punya akses untuk mengubah incident.');
        }

        $incident->update($data);

        return back()->with('success', 'Incident berhasil diperbarui.');
    }
}