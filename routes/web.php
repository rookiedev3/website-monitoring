<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\MonitoringSettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
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
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Monitoring
    Route::get('/dashboard', [MonitoringController::class, 'index'])->name('dashboard.index');

    // Detail Monitoring & Log per Website
    Route::get('/dashboard/{website}', [MonitoringController::class, 'show'])->name('dashboard.show');
    Route::get('/api/dashboard/status', [MonitoringController::class, 'apiStatus'])->name('api.dashboard.status');

    Route::resource('websites', WebsiteController::class);
    Route::patch('websites/{website}/toggle-status', [WebsiteController::class, 'toggleStatus'])->name('websites.toggle-status');

    Route::resource('incidents', IncidentController::class)
        ->only(['index', 'show', 'update']);

    Route::post('/incidents/{incident}/notes', [IncidentController::class, 'storeNote'])
        ->name('incidents.notes.store');

    Route::resource('incidents', IncidentController::class)->only(['index', 'show', 'update']);
    Route::post('/incidents/{incident}/take', [IncidentController::class, 'take'])->name('incidents.take');
    Route::post('/incidents/{incident}/notes', [IncidentController::class, 'storeNote'])->name('incidents.notes.store');

    // BUAT SUPER ADMIN
    Route::middleware('role:super_admin')->prefix('super-admin')->group(function () {
        // route khusus super_admin
        // Dashboard Monitoring
        // Route::get('/dashboard', [MonitoringController::class, 'index'])->name('dashboard.index');
        Route::get('/settings', [MonitoringSettingController::class, 'edit'])->name('settings.index');
        Route::put('/settings', [MonitoringSettingController::class, 'update'])->name('settings.update');

    });

    // BUAT PROGRAMMER
    Route::middleware('role:programmer')->prefix('programmer')->group(function () {
        // route khusus programmer
        // Dashboard Monitoring
    });

    // BUAT VIEWER
    Route::middleware('role:viewer')->prefix('viewer')->group(function () {
        // route khusus viewer
    });
});

// //// PERCOBAAN ROUTE (NANTI MASUKIN KE USER WOIII)
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::resource('/pengguna', UserController::class)->names('user');
Route::resource('/users', UserController::class);

//
// Halaman Analytics
// Route::get('/analytics', function () {
//     return view('analytics.index');
// })->name('analytics.index');

   Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

// route ridho


//route chyntia
// Route untuk halaman profil utama
Route::view('/profile', 'profile.index')->name('profile.index');

// Route untuk halaman form edit profil & password
Route::view('/profile/edit', 'profile.edit')->name('profile.edit');