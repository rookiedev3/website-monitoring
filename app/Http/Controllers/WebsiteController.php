<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebsiteRequest;
use App\Jobs\CheckWebsiteJob;
use App\Models\MonitoringSetting;
use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index(Request $request)
    {
        // Search, filter kategori/status, dan pagination sekarang ditangani
        // sepenuhnya di client-side (JavaScript) pada view websites.index,
        // sama seperti pola di Dashboard. Jadi di sini kita cukup mengirim
        // seluruh data website tanpa paginate() dan tanpa filter query string.
        $websites = Website::latest()->get();

        $categories = Website::select('category')->distinct()->pluck('category')->filter();

        return view('websites.index', compact('websites', 'categories'));
    }

    public function create()
    {
        $setting = MonitoringSetting::first() ?? (object) [
            'default_interval_minutes' => 5,
            'timeout_seconds' => 10,
        ];

        return view('websites.create', compact('setting'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'website_name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'category' => 'nullable|string|max:255',
            'check_interval' => 'required|integer|min:1',
            'timeout_seconds' => 'required|integer|min:1|max:60',
            'monitoring_status' => 'required|in:active,paused',
            'notes' => 'nullable|string',
        ]);

        // Ekstrak hostname domain otomatis dari URL
        $parsedHost = parse_url($validated['url'], PHP_URL_HOST);
        $validated['domain'] = $parsedHost ?? $validated['url'];

        $website = Website::create($validated);

        if ($website->monitoring_status === 'active') {
            CheckWebsiteJob::dispatch($website);
        }

        return redirect()
            ->route('websites.index')
            ->with('success', 'Website berhasil ditambahkan ke sistem pemantauan.');
    }

    public function edit(Website $website)
    {
        return view('websites.edit', compact('website'));
    }

    public function update(WebsiteRequest $request, Website $website)
    {
        $data = $request->validated();
        $parsedHost = parse_url($data['url'], PHP_URL_HOST);
        $data['domain'] = $parsedHost ?? $data['url'];

        $website->update($data);

        return redirect()->route('websites.index')->with('success', 'Data website berhasil diperbarui.');
    }

    public function destroy(Website $website)
    {
        $website->delete();

        return redirect()->route('websites.index')->with('success', 'Website berhasil dihapus.');
    }

    // Aksi Toggle Pause / Active
    public function toggleStatus(Website $website)
    {
        $newStatus = $website->monitoring_status === 'active' ? 'paused' : 'active';
        $website->update(['monitoring_status' => $newStatus]);

        return back()->with('success', "Status pemantauan website berhasil diubah ke {$newStatus}.");
    }
}
