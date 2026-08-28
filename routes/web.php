<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// BUAT YANG BELUM LOGIN
Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/login', 'login')->name('login.proses');
    });
});

// BUAT YANG SUDAH LOGIN
Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route::get('/dashboard', function () {
    //     return view('dashboard'); // ganti sesuai view kamu
    // })->name('dashboard');

    // BUAT SUPER ADMIN
    Route::middleware('role:super_admin')->prefix('super-admin')->group(function () {
        // route khusus super_admin
    });

    // BUAT PROGRAMMER
    Route::middleware('role:programmer')->prefix('programmer')->group(function () {
        // route khusus programmer
    });

    // BUAT VIEWER
    Route::middleware('role:viewer')->prefix('viewer')->group(function () {
        // route khusus viewer
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
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');