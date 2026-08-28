<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonitoringLog extends Model
{
    use HasFactory;

    /**
     * Disable default updated_at column since the table only uses created_at.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ssl_valid'        => 'boolean',
        'ssl_expired_at'   => 'datetime',
        'ssl_days_left'    => 'integer',
        'http_code'        => 'integer',
        'response_time_ms' => 'integer',
        'checked_at'       => 'datetime',
        'created_at'       => 'datetime',
    ];

    /* ==========================================
     | RELATIONS
     ========================================== */

    /**
     * Relasi balik ke master data website.
     */
    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    /* ==========================================
     | SCOPES
     ========================================== */

    /**
     * Scope untuk menyaring log berdasarkan status tertentu.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk mengambil log dalam rentang waktu tertentu.
     */
    public function scopeCheckedBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('checked_at', [$startDate, $endDate]);
    }
}