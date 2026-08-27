<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monitoring_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('default_interval_minutes')->default(5);
            $table->unsignedInteger('timeout_seconds')->default(10);
            $table->unsignedInteger('slow_threshold_ms')->default(2000);
            $table->unsignedInteger('max_parallel_jobs')->default(5);
            $table->unsignedInteger('ssl_warning_days')->default(14);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_settings');
    }
};