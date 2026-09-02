<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\MonitoringSettingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// BUAT YANG BELUM LOGIN
Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/', 'index')->name('login');
        Route::post('/login', 'login')->name('login.proses');
    });
});

// BUAT YANG SUDAH LOGIN
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Monitoring
    Route::get('/dashboard', [MonitoringController::class, 'index'])->name('dashboard.index');

    // Detail Monitoring & Log per Website
    Route::get('/dashboard/{website}', [MonitoringController::class, 'show'])->name('dashboard.show');
    Route::get('/api/dashboard/status', [MonitoringController::class, 'apiStatus'])->name('api.dashboard.status');

    Route::resource('websites', WebsiteController::class);
    Route::patch('websites/{website}/toggle-status', [WebsiteController::class, 'toggleStatus'])->name('websites.toggle-status');

    Route::resource('incidents', IncidentController::class)->only(['index', 'show', 'update']);
    Route::post('/incidents/{incident}/take', [IncidentController::class, 'take'])->name('incidents.take');
    Route::post('/incidents/{incident}/notes', [IncidentController::class, 'storeNote'])->name('incidents.notes.store');
    Route::get('/api/incidents/status', [IncidentController::class, 'apiStatus'])
    ->name('api.incidents.status');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Redirect & Tandai dibaca satu notifikasi
    Route::get('/notifications/{id}/read', function ($id, Request $request) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $data = $notification->data;
        $target = $request->query('redirect');

        if (! empty($data['incident_id'])) {
            $target = route('incidents.show', $data['incident_id']);
        } elseif (empty($target)) {
            $target = $data['action_url'] ?? route('incidents.index');
        }

        return redirect($target);
    })->name('notifications.readAndRedirect');

    // Tandai semua notifikasi dibaca
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    })->name('notifications.markAllRead');

    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // BUAT SUPER ADMIN
    Route::middleware('role:super_admin')->prefix('super-admin')->group(function () {
        Route::resource('/users', UserController::class);

        // Route::get('/dashboard', [MonitoringController::class, 'index'])->name('dashboard.index');
        Route::get('/settings', [MonitoringSettingController::class, 'edit'])->name('settings.index');
        Route::put('/settings', [MonitoringSettingController::class, 'update'])->name('settings.update');

    });

    Route::middleware('role:super_admin,viewer')->group(function () {
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    });

    // BUAT PROGRAMMER
    Route::middleware('role:programmer')->prefix('programmer')->group(function () {
    });

    // BUAT VIEWER
    Route::middleware('role:viewer')->prefix('viewer')->group(function () {
    });
});


// route ridho
