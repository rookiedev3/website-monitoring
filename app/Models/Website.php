<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function monitoringLogs(): HasMany
    {
        return $this->hasMany(MonitoringLog::class);
    }

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }
}