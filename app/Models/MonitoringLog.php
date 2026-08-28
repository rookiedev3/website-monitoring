<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonitoringLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'website_id',
        'status',
        'http_code',
        'response_time_ms',
        'ssl_valid',
        'ssl_expired_at',
        'ssl_days_left',
        'error_type',
        'error_message',
        'checked_at',
    ];

    protected $casts = [
        'http_code' => 'integer',
        'response_time_ms' => 'integer',
        'ssl_valid' => 'boolean',
        'ssl_expired_at' => 'datetime',
        'ssl_days_left' => 'integer',
        'checked_at' => 'datetime',
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}