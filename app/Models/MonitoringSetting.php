<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'default_interval_minutes',
        'timeout_seconds',
        'slow_threshold_ms',
        'max_parallel_jobs',
        'ssl_warning_days',
    ];

    protected $casts = [
        'default_interval_minutes' => 'integer',
        'timeout_seconds' => 'integer',
        'slow_threshold_ms' => 'integer',
        'max_parallel_jobs' => 'integer',
        'ssl_warning_days' => 'integer',
    ];
}