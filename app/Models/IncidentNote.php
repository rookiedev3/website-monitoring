<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncidentNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'user_id',
        'note',
    ];

    /**
     * Incident yang dicatat.
     */
    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }

    /**
     * User yang menulis catatan ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}