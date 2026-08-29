<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Http\Requests\WebsiteRequest;
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
        return view('websites.create');
    }

    public function store(WebsiteRequest $request)
    {
        $data = $request->validated();
        // Otomatis mengambil domain dari URL
        $data['domain'] = parse_url($request->url, PHP_URL_HOST);

        Website::create($data);

        return redirect()->route('websites.index')->with('success', 'Website berhasil ditambahkan ke sistem pemantauan.');
    }

    public function edit(Website $website)
    {
        return view('websites.edit', compact('website'));
    }

    public function update(WebsiteRequest $request, Website $website)
    {
        $data = $request->validated();
        $data['domain'] = parse_url($request->url, PHP_URL_HOST);

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