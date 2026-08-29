<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MonitoringController;
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
        Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Route::get('/dashboard', function () {
    //     return view('dashboard'); // ganti sesuai view kamu
    // })->name('dashboard');

    Route::resource('incidents', IncidentController::class)->only(['index', 'show', 'update']);
    Route::post('/incidents/{incident}/take', [IncidentController::class, 'take'])->name('incidents.take');
    Route::post('/incidents/{incident}/notes', [IncidentController::class, 'storeNote'])->name('incidents.notes.store');

    // BUAT SUPER ADMIN
    Route::middleware('role:super_admin')->prefix('super-admin')->group(function () {
        // route khusus super_admin
        // Dashboard Monitoring
        Route::get('/dashboard', [MonitoringController::class, 'index'])->name('dashboard.index');

        // Detail Monitoring & Log per Website
        Route::get('/dashboard/{website}', [MonitoringController::class, 'show'])->name('dashboard.show');
        Route::get('/api/dashboard/status', [MonitoringController::class, 'apiStatus'])->name('api.dashboard.status');
    });

    // BUAT PROGRAMMER
    Route::middleware('role:programmer')->prefix('programmer')->group(function () {
        // route khusus programmer
        // Dashboard Monitoring
        Route::get('/dashboard', [MonitoringController::class, 'index'])->name('dashboard.index');

        // Detail Monitoring & Log per Website
        Route::get('/dashboard/{website}', [MonitoringController::class, 'show'])->name('dashboard.show');
        Route::get('/api/dashboard/status', [MonitoringController::class, 'apiStatus'])->name('api.dashboard.status');
    });

    // BUAT VIEWER
    Route::middleware('role:viewer')->prefix('viewer')->group(function () {
        // route khusus viewer
        // Dashboard Monitoring
        Route::get('/dashboard', [MonitoringController::class, 'index'])->name('dashboard.index');

        // Detail Monitoring & Log per Website
        Route::get('/dashboard/{website}', [MonitoringController::class, 'show'])->name('dashboard.show');
        Route::get('/api/dashboard/status', [MonitoringController::class, 'apiStatus'])->name('api.dashboard.status');
    });
});

////// PERCOBAAN ROUTE (NANTI MASUKIN KE USER WOIII)
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::resource('/pengguna', UserController::class)->names('user');
Route::resource('/users', UserController::class);

//ROUTE CHYNTIA

    // dashboard sama buat semua role (data-nya sama, kata Chyntia)


    // Dashboard Utama dengan nama route
// Route::get('/', function () {
//     return view('dashboard.index');
// })->name('dashboard');

// Website Management
Route::get('/websites', function () {
    return view('websites.index');
})->name('websites.index');

// Halaman Form Tambah Website
Route::get('/websites/create', function () {
    return view('websites.create');
})->name('websites.create');

// Proses Simpan Data Website (Backend Target)
Route::post('/websites', function () {
    // Logic simpan data oleh backend
})->name('websites.store');

//edit
Route::get('/websites/edit', function () {
    return view('websites.edit');
})->name('websites.edit');

// Halaman List Incidents / Errors
Route::get('/incidents', function () {
    return view('incidents.index');
})->name('incidents.index');

// Halaman Detail Incident & Form Update Penanganan (Programmer)
Route::get('/incidents/{id}', function ($id) {
    return view('incidents.show', ['id' => $id]);
})->name('incidents.show');

// Halaman List Incidents / Errors
Route::get('/incidents', function () {
    return view('incidents.index');
})->name('incidents.index');

// Halaman Detail Incident & Form Update (Programmer)
Route::get('/incidents/{id}', function ($id) {
    return view('incidents.show', ['id' => $id]);
})->name('incidents.show');

    // Proses Simpan Update Penanganan Incident (Backend Target)
    Route::patch('/incidents/{id}', function ($id) {
        // Logic update oleh backend
    })->name('incidents.update');


    Route::resource('incidents', IncidentController::class)
    ->only(['index', 'show', 'update']);

    Route::post('/incidents/{incident}/notes', [IncidentController::class, 'storeNote'])
    ->name('incidents.notes.store');

    Route::patch('/incidents/{id}', function ($id) {
        // Logic update oleh backend
    })->name('incidents.update');

    // Halaman Analytics
    Route::get('/analytics', function () {
        return view('analytics.index');
    })->name('analytics.index');

    // Halaman Settings
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings.index');

    // Proses Simpan Settings
    Route::post('/settings', function () {
        // Logic simpan pengaturan oleh backend
    })->name('settings.update');

    // Halaman daftar & tambah user (khusus Super Admin)
    Route::get('/users', function () {
        return view('users.index');
    })->name('users.index');

    Route::post('/users', function () {
        // Logic menyimpan user baru
    })->name('users.store');



//route ridho
// Dashboard Monitoring
Route::get('/dashboard', [MonitoringController::class, 'index'])->name('dashboard.index');

// Detail Monitoring & Log per Website
Route::get('/dashboard/{website}', [MonitoringController::class, 'show'])->name('dashboard.show');
Route::get('/api/dashboard/status', [MonitoringController::class, 'apiStatus'])->name('api.dashboard.status');

Route::resource('websites', WebsiteController::class);
Route::patch('websites/{website}/toggle-status', [WebsiteController::class, 'toggleStatus'])->name('websites.toggle-status');