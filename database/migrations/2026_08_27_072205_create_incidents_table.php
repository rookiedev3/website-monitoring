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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')
                ->constrained('websites')
                ->cascadeOnDelete();

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('incident_type', ['down', 'timeout', 'http_error', 'ssl', 'slow']);
            $table->enum('status', ['open', 'on_progress', 'solved'])->default('open');

            $table->timestamp('started_at');
            $table->timestamp('resolved_at')->nullable();
            $table->unsignedInteger('duration_seconds')->nullable();

            $table->text('root_cause')->nullable();
            $table->text('resolution')->nullable();

            $table->timestamps();

            $table->index(['website_id', 'status']);
            $table->index('incident_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};