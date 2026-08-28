<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Log - {{ $website->website_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container py-4">
    <a href="{{ route('monitoring.index') }}" class="btn btn-link text-decoration-none mb-3"><i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard</a>

    <div class="card border-0 shadow-sm p-4 mb-4">
        <h2 class="fw-bold text-dark mb-1">{{ $website->website_name }}</h2>
        <a href="{{ $website->url }}" target="_blank" class="text-primary text-decoration-none">{{ $website->url }}</a>
        <div class="mt-3">
            <span class="badge bg-secondary">Kategori: {{ $website->category ?? 'Umum' }}</span>
            <span class="badge bg-dark">Interval Cek: Setiap {{ $website->check_interval }} Menit</span>
        </div>
    </div>

    <!-- Riwayat Log Pengecekan -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="card-title fw-bold m-0"><i class="bi bi-clock-history me-2"></i>Riwayat Log Pengecekan (Last 15)</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Waktu Cek</th>
                        <th>Status</th>
                        <th>HTTP Code</th>
                        <th>Latency</th>
                        <th>Detail Error</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->checked_at->format('d/m/Y H:i:s') }}</td>
                            <td><span class="badge {{ $log->status_badge_class }}">{{ $log->status_label }}</span></td>
                            <td>{{ $log->formatted_http_code }}</td>
                            <td>{{ $log->response_time_ms ? $log->response_time_ms . ' ms' : '-' }}</td>
                            <td class="text-danger small">{{ $log->display_error }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat log.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $logs->links() }}
        </div>
    </div>
</div>

</body>
</html>