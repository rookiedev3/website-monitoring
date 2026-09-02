<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            // Diisi persis pada saat PIC mengirim root_cause/resolution.
            // Dibandingkan dengan resolved_at untuk menentukan apakah laporan
            // masuk SEBELUM sistem konfirmasi online (berarti PIC yang
            // menyelesaikan) atau SESUDAHNYA (berarti auto-resolved, laporan
            // cuma dokumentasi post-mortem).
            $table->timestamp('report_submitted_at')->nullable()->after('resolution');
        });
    }

    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn('report_submitted_at');
        });
    }
};