<?php

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Scheduler Uptime Monitoring — SHARED HOSTING EDITION
|--------------------------------------------------------------------------
|
| Cron di panel shared hosting (cPanel/Plesk/dsb) HANYA mendukung entri
| minimal "setiap 1 menit" — tidak ada opsi per detik. Solusinya:
|
|   php artisan schedule:run
|
| tetap didaftarkan sebagai SATU-SATUNYA entri cron (jalan tiap menit),
| lalu di dalam Laravel, tugas-tugas di bawah ini yang mengatur diri
| masing-masing:
|
| Contoh entri cron di cPanel ("Cron Jobs"):
|   * * * * * php /home/USERNAME/domains/namadomain.com/artisan schedule:run >> /dev/null 2>&1
|
*/

// 1) HTTP check — command ini jalan tiap menit, tapi di dalamnya
//    masing-masing website hanya benar-benar dicek kalau check_interval
//    miliknya (dalam menit, dari DB) sudah lewat.
Schedule::command('monitor:dispatch-http')
    ->everyMinute()
    ->withoutOverlapping();

// 2) Ping check — berjalan setiap detik (everySecond)
// Cocok untuk proses daemon / schedule:work yang disupervisi Supervisor/systemd.
Schedule::command('monitor:dispatch-ping')
    ->everySecond()
    ->withoutOverlapping();

// 2b) Ping sweep — alternatif untuk Shared Hosting dengan Cron cPanel standar per menit (* * * * * schedule:run)
// Melakukan internal loop tiap ±1 detik selama 55 detik agar tetap real-time per detik.
Schedule::command('monitor:ping-sweep', ['--duration' => 55])
    ->everyMinute()
    ->withoutOverlapping()
    ->runInBackground();

// 3) SSL expiration check — cukup sekali sehari.
Schedule::command('monitor:dispatch-ssl')
    ->dailyAt('01:00')
    ->withoutOverlapping();
