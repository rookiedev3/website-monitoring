<?php

namespace App\Http\Controllers;

use App\Models\MonitoringSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MonitoringSettingController extends Controller
{
    public function edit(): View
    {
        $setting = MonitoringSetting::firstOrCreate([], [
            'default_interval_minutes' => 5,
            'timeout_seconds' => 10,
            'slow_threshold_ms' => 2000,
            'max_parallel_jobs' => 5,
            'ssl_warning_days' => 14,
        ]);

        return view('settings.index', compact('setting'));
    }

    public function update(Request $request): RedirectResponse
    {
        if (Auth::user()->role !== 'super_admin') {
            abort(403, 'Hanya Super Admin yang bisa mengubah pengaturan ini.');
        }

        $setting = MonitoringSetting::firstOrCreate([]);

        $data = $request->validate([
            'default_interval_minutes' => 'required|integer|min:1|max:1440',
            'timeout_seconds' => 'required|integer|min:1|max:120',
            'slow_threshold_ms' => 'required|integer|min:100|max:60000',
            'max_parallel_jobs' => 'required|integer|min:1|max:50',
            'ssl_warning_days' => 'required|integer|min:1|max:90',
        ], [
            'default_interval_minutes.required' => 'Interval wajib diisi',
            'default_interval_minutes.min' => 'Interval minimal 1 menit',
            'timeout_seconds.required' => 'Timeout wajib diisi',
            'slow_threshold_ms.required' => 'Threshold wajib diisi',
            'max_parallel_jobs.required' => 'Max parallel jobs wajib diisi',
            'ssl_warning_days.required' => 'SSL warning days wajib diisi',
        ]);

        $setting->update($data);
        Cache::forget('global_monitoring_settings');

        return back()->with('success', 'Pengaturan monitoring berhasil diperbarui.');
    }
}
