<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'created_at',
    ];

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

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    /* ==========================================
     | ACCESSORS FOR BLADE VIEWS
     ========================================== */

    /**
     * Formatting HTTP Code untuk Tampilan UI
     * Contoh: "200 OK", "500 Server Error", atau "No Response (N/A)"
     */
    protected function formattedHttpCode(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (is_null($this->http_code)) {
                    return 'No Response (N/A)';
                }

                $statusTexts = [
                    200 => '200 OK',
                    301 => '301 Moved Permanently',
                    302 => '302 Found',
                    400 => '400 Bad Request',
                    401 => '401 Unauthorized',
                    403 => '403 Forbidden',
                    404 => '404 Not Found',
                    500 => '500 Internal Server Error',
                    502 => '502 Bad Gateway',
                    503 => '503 Service Unavailable',
                    504 => '504 Gateway Timeout',
                ];

                return $statusTexts[$this->http_code] ?? "{$this->http_code} Unknown Status";
            }
        );
    }

    /**
     * Label Badge Warna Bootstrap / Tailwind berdasarkan status
     * Contoh panggil di Blade: $log->status_badge_class
     */
    protected function statusBadgeClass(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->status) {
                'online'    => 'bg-success text-white',
                'warning'   => 'bg-warning text-dark',
                'down'      => 'bg-danger text-white',
                'ssl_error' => 'bg-secondary text-white',
                default     => 'bg-light text-dark',
            }
        );
    }

    /**
     * Label Status Manusiawi untuk Header UI
     * Contoh: "Online", "Slow Response (Warning)", "Down / Offline"
     */
    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->status) {
                'online'    => 'Online',
                'warning'   => 'Slow Response',
                'down'      => 'Down / Offline',
                'ssl_error' => 'SSL Invalid / Expired',
                default     => 'Unknown',
            }
        );
    }

    /**
     * Ringkasan Pesan Error yang Bersih & Aman untuk UI
     */
    protected function displayError(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->error_message)) {
                    return 'Tidak ada error';
                }

                // Potong pesan error yang terlalu panjang jika melebihi 80 karakter
                return \Illuminate\Support\Str::limit($this->error_message, 80);
            }
        );
    }
}