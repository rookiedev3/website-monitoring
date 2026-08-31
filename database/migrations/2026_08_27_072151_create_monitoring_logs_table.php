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
        Schema::create('monitoring_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')
                ->constrained('websites')
                ->cascadeOnDelete();

            $table->enum('status', ['online', 'warning', 'down', 'ssl_error']);
            $table->unsignedSmallInteger('http_code')->nullable();
            $table->unsignedInteger('response_time_ms')->nullable();

            $table->boolean('ssl_valid')->nullable();
            $table->timestamp('ssl_expired_at')->nullable();
            $table->integer('ssl_days_left')->nullable();

            $table->string('error_type')->nullable();
            $table->text('error_message')->nullable();

            $table->timestamp('checked_at');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['website_id', 'checked_at']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_logs');
    }
};
