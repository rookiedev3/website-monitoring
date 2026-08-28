<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Incident extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'website_id',
        'assigned_to',
        'incident_type',
        'status',
        'started_at',
        'resolved_at',
        'duration_seconds',
        'root_cause',
        'resolution',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at'       => 'datetime',
        'resolved_at'      => 'datetime',
        'duration_seconds' => 'integer',
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

    /**
     * Relasi ke user / programmer yang ditugaskan sebagai PIC.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Relasi ke seluruh catatan penanganan insiden.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(IncidentNote::class);
    }

    /* ==========================================
     | SCOPES
     ========================================== */

    /**
     * Scope untuk menyaring insiden yang masih aktif (belum selesai).
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['open', 'on_progress']);
    }

    /**
     * Scope untuk menyaring insiden yang sudah teratasi.
     */
    public function scopeSolved($query)
    {
        return $query->where('status', 'solved');
    }

    /**
     * Scope berdasarkan jenis insiden.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('incident_type', $type);
    }
}