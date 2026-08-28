<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uptime Monitoring Dashboard</title>
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark"><i class="bi bi-activity text-primary me-2"></i>Dashboard Uptime Monitoring</h1>
        <a href="{{ route('monitoring.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-clockwise me-1"></i>Refresh Data</a>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <span class="text-muted small fw-semibold text-uppercase">Total Monitored</span>
                <h2 class="fw-bold my-1 text-dark" id="stat-total">{{ $stats['total'] }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3 border-start border-success border-4">
                <span class="text-success small fw-semibold text-uppercase">Online (Normal)</span>
                <h2 class="fw-bold my-1 text-success" id="stat-online">{{ $stats['online'] }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3 border-start border-warning border-4">
                <span class="text-warning small fw-semibold text-uppercase">Warning (Slow)</span>
                <h2 class="fw-bold my-1 text-warning" id="stat-warning">{{ $stats['warning'] }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3 border-start border-danger border-4">
                <span class="text-danger small fw-semibold text-uppercase">Down / Error</span>
                <h2 class="fw-bold my-1 text-danger" id="stat-down">{{ $stats['down'] }}</h2>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Website & Status Terkini -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="card-title fw-bold m-0"><i class="bi bi-globe me-2"></i>Daftar Status Website</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Website / Domain</th>
                        <th>Status</th>
                        <th>HTTP Response</th>
                        <th>Latency</th>
                        <th>Masa SSL</th>
                        <th>Pengecekan Terakhir</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="website-table-body">
                    @forelse($websites as $web)
                        @php $log = $web->latestLog; @endphp
                        <tr>
                            <td>
                                <strong class="text-dark">{{ $web->website_name }}</strong>
                                <small class="text-muted d-block">{{ $web->url }}</small>
                            </td>
                            <td>
                                @if($log)
                                    <span class="badge {{ $log->status_badge_class }}">
                                        {{ $log->status_label }}
                                    </span>
                                @else
                                    <span class="badge bg-light text-muted">Belum Dicek</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold text-dark">
                                    {{ $log ? $log->formatted_http_code : '-' }}
                                </span>
                            </td>
                            <td>
                                @if($log && $log->response_time_ms)
                                    <span class="{{ $log->response_time_ms > 3000 ? 'text-warning fw-bold' : 'text-success' }}">
                                        {{ number_format($log->response_time_ms) }} ms
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($log && $log->ssl_valid)
                                    <span class="badge bg-info text-dark">
                                        Valid ({{ $log->ssl_days_left }} Hari)
                                    </span>
                                @elseif($log && $log->ssl_valid === false)
                                    <span class="badge bg-danger">SSL Invalid / Expired</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="small text-muted">
                                {{ $log ? $log->checked_at->diffForHumans() : '-' }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('monitoring.show', $web->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>Detail Log
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data website. Silakan jalankan Seeder.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Insiden Aktif -->
    @if($activeIncidents->count() > 0)
        <div class="card border-danger shadow-sm">
            <div class="card-header bg-danger text-white py-3">
                <h5 class="card-title fw-bold m-0"><i class="bi bi-exclamation-triangle-fill me-2"></i>Insiden Gangguan Aktif</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Website</th>
                            <th>Tipe Gangguan</th>
                            <th>Status Insiden</th>
                            <th>PIC Assigned</th>
                            <th>Mulai Gangguan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activeIncidents as $incident)
                            <tr>
                                <td><strong>{{ $incident->website->website_name }}</strong></td>
                                <td><span class="badge bg-outline-danger border border-danger text-danger">{{ strtoupper($incident->incident_type) }}</span></td>
                                <td><span class="badge bg-warning text-dark">{{ strtoupper($incident->status) }}</span></td>
                                <td>{{ $incident->assignedUser->name ?? 'Belum Ditugaskan' }}</td>
                                <td class="small text-muted">{{ $incident->started_at->format('d M Y, H:i:s') }} ({{ $incident->started_at->diffForHumans() }})</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

</body>
</html>

<script>
    function fetchRealtimeData() {
        fetch("{{ route('api.monitoring.status') }}")
            .then(response => response.json())
            .then(data => {
                // 1. Update Angka Kartu Statistik
                if (data && data.stats) {
                    document.getElementById('stat-total').innerText = data.stats.total ?? 0;
                    document.getElementById('stat-online').innerText = data.stats.online ?? 0;
                    document.getElementById('stat-warning').innerText = data.stats.warning ?? 0;
                    document.getElementById('stat-down').innerText = data.stats.down ?? 0;
                }

                // 2. Update Baris Tabel Website secara Real-time
                const tbody = document.getElementById('website-table-body');
                if (tbody && data.websites) {
                    if (data.websites.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data website.</td></tr>`;
                        return;
                    }

                    let html = '';
                    data.websites.forEach(web => {
                        // Mengambil log terbaru dari JSON API
                        const log = web.latest_log || web.latestLog;
                        
                        // Helper Badge Status
                        let statusBadge = '<span class="badge bg-light text-muted">Belum Dicek</span>';
                        let httpCode = '-';
                        let responseTime = '-';
                        let sslBadge = '-';
                        let checkedAt = '-';

                        if (log) {
                            // Formatter Badge Status
                            const badgeClasses = {
                                'online': 'bg-success text-white',
                                'warning': 'bg-warning text-dark',
                                'down': 'bg-danger text-white',
                                'ssl_error': 'bg-secondary text-white'
                            };
                            const statusLabels = {
                                'online': 'Online',
                                'warning': 'Slow Response',
                                'down': 'Down / Offline',
                                'ssl_error': 'SSL Error'
                            };

                            const badgeClass = badgeClasses[log.status] || 'bg-light text-dark';
                            const statusLabel = statusLabels[log.status] || log.status;
                            statusBadge = `<span class="badge ${badgeClass}">${statusLabel}</span>`;

                            // Formatter HTTP Code
                            httpCode = log.http_code ? `<span class="fw-bold text-dark">${log.http_code}</span>` : '<span class="fw-bold text-muted">No Response (N/A)</span>';

                            // Formatter Response Time
                            if (log.response_time_ms) {
                                const latencyClass = log.response_time_ms > 3000 ? 'text-warning fw-bold' : 'text-success';
                                responseTime = `<span class="${latencyClass}">${Number(log.response_time_ms).toLocaleString()} ms</span>`;
                            }

                            // Formatter SSL
                            if (log.ssl_valid) {
                                sslBadge = `<span class="badge bg-info text-dark">Valid (${log.ssl_days_left} Hari)</span>`;
                            } else if (log.ssl_valid === false) {
                                sslBadge = `<span class="badge bg-danger">SSL Invalid / Expired</span>`;
                            }

                            // Timestamp
                            checkedAt = log.checked_at ? new Date(log.checked_at).toLocaleTimeString('id-ID') : '-';
                        }

                        // Generate URL Detail
                        const detailUrl = `/monitoring/${web.id}`;

                        html += `
                            <tr>
                                <td>
                                    <strong class="text-dark">${web.website_name}</strong>
                                    <small class="text-muted d-block">${web.url}</small>
                                </td>
                                <td>${statusBadge}</td>
                                <td>${httpCode}</td>
                                <td>${responseTime}</td>
                                <td>${sslBadge}</td>
                                <td class="small text-muted">${checkedAt}</td>
                                <td class="text-center">
                                    <a href="${detailUrl}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>Detail Log
                                    </a>
                                </td>
                            </tr>
                        `;
                    });

                    tbody.innerHTML = html;
                }
            })
            .catch(error => console.error('Error fetching monitoring data:', error));
    }

    // Jalankan setiap 5 detik (5000 ms)
    setInterval(fetchRealtimeData, 5000);
</script>