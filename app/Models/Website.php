<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'website_name',
        'domain',
        'url',
        'category',
        'monitoring_status',
        'check_interval',
        'timeout_seconds',
        'notes',
    ];

    protected $casts = [
        'check_interval' => 'integer',
        'timeout_seconds' => 'integer',
    ];

    /* ==========================================
     | RELATIONS
     ========================================== */

    /**
     * Relasi ke seluruh riwayat log pengecekan.
     */
    public function monitoringLogs(): HasMany
    {
        return $this->hasMany(MonitoringLog::class);
    }

    /**
     * Relasi untuk mengambil 1 log TERBARU dari tabel monitoring_logs.
     */
    public function latestLog(): HasOne
    {
        return $this->hasOne(MonitoringLog::class)->latestOfMany('checked_at');
    }

    /**
     * Relasi ke seluruh riwayat insiden.
     */
    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }

    /* ==========================================
     | SCOPES
     ========================================== */

    public function scopeActive($query)
    {
        return $query->where('monitoring_status', 'active');
    }
}