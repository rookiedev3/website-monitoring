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
        'started_at' => 'datetime',
        'resolved_at' => 'datetime',
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

    // app/Models/Incident.php — tambahin dua method ini
    public function getTypeLabelAttribute(): string
    {
        return match ($this->incident_type) {
            'down' => 'Website Down',
            'timeout' => 'Connection Timeout',
            'http_error' => 'HTTP Error',
            'ssl' => 'SSL Certificate Error',
            'slow' => 'Slow Response',
            default => ucfirst($this->incident_type),
        };
    }

    /**
     * Durasi gangguan yang sudah diformat jadi "X hari Y jam Z menit".
     * - Incident 'solved' pakai duration_seconds yang sudah tersimpan di DB.
     * - Incident yang masih berjalan dihitung real-time dari started_at.
     * abs() dipakai supaya incident yang baru saja dibuat (selisih bisa
     * sedikit negatif karena micro-lag) tidak wrap jadi "23 jam 59 menit".
     */
    public function getFormattedDurationAttribute(): string
    {
        $seconds = $this->status === 'solved'
            ? $this->duration_seconds
            : abs(now()->diffInSeconds($this->started_at));

        $days = intdiv($seconds, 86400);
        $hours = intdiv($seconds % 86400, 3600);
        $minutes = intdiv($seconds % 3600, 60);

        $parts = [];
        if ($days > 0) {
            $parts[] = "{$days} hari";
        }
        if ($hours > 0 || $days > 0) {
            $parts[] = "{$hours} jam";
        }
        $parts[] = "{$minutes} menit";

        return implode(' ', $parts);
    }

    /* ==========================================
 | SCOPES
 ========================================== */

    /**
     * Scope untuk insiden yang masih aktif (Open / On Progress).
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['open', 'on_progress']);
    }

    public function getBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'open' => 'open',
            'on_progress' => 'progress',
            'solved' => 'solved',
            default => 'open',
        };
    }
}