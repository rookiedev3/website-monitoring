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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('website_name');
            $table->string('domain');
            $table->string('url');
            $table->string('category')->nullable();
            $table->enum('monitoring_status', ['active', 'paused'])->default('active');
            $table->unsignedInteger('check_interval')->default(5); // dalam menit
            $table->unsignedInteger('timeout_seconds')->default(10);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('monitoring_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
