<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Log - {{ $website->website_name }}</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
    :root {
        --bg: #0b120f;
        --card: #111b16;
        --card-hover: #17231d;
        --ink: #dce9e1;
        --muted: #82988c;
        --line: #1b2a22;
        --green: #0f9f6e;
        --green-soft: rgba(15, 159, 110, 0.12);
        --red: #d94c4c;
        --red-soft: rgba(217, 76, 76, 0.12);
        --amber: #d98b1d;
        --amber-soft: rgba(217, 139, 29, 0.12);
        --blue: #3b82f6;
        --blue-soft: rgba(59, 130, 246, 0.12);
        --shadow: 0 10px 30px rgba(0, 0, 0, .3);
        --sidebar-width: 260px;
        --sidebar-collapsed: 76px;
    }

    * {
        box-sizing: border-box;
        transition: width 0.3s ease, padding 0.3s ease;
    }

    body {
        margin: 0;
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
        color: var(--ink);
        background: var(--bg);
        display: flex;
        min-height: 100vh;
        overflow-x: hidden;
    }

    a {
        color: inherit;
        text-decoration: none;
    }

    main {
        margin-left: var(--sidebar-width);
        flex: 1;
        padding: 30px;
        min-width: 0;
    }

    aside.collapsed ~ main {
        margin-left: var(--sidebar-collapsed);
    }

    .container {
        max-width: 1180px;
        margin: 0 auto;
    }

    /* Tombol Kembali */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--muted);
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 20px;
        transition: color 0.2s ease;
    }

    .btn-back:hover {
        color: #fff;
    }

    /* Header Card */
    .header-card {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: var(--shadow);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 16px;
    }

    .header-info h2 {
        font-size: 24px;
        margin: 0 0 6px;
        color: #fff;
        font-weight: 800;
    }

    .header-info a {
        color: var(--green);
        font-size: 14px;
        font-weight: 500;
        word-break: break-all;
    }

    .header-info a:hover {
        text-decoration: underline;
    }

    .meta-tags {
        display: flex;
        gap: 8px;
        margin-top: 14px;
        flex-wrap: wrap;
    }

    /* Cards Layout */
    .card {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 20px;
        box-shadow: var(--shadow);
        margin-bottom: 24px;
    }

    .card-title {
        font-size: 15px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Table Styling */
    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    th {
        color: var(--muted);
        font-size: 11px;
        text-transform: uppercase;
        padding: 12px;
        border-bottom: 1px solid var(--line);
    }

    td {
        padding: 14px 12px;
        border-bottom: 1px solid var(--line);
        color: var(--ink);
        vertical-align: middle;
    }

    tr:last-child td {
        border-bottom: none;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-online {
        background: var(--green-soft);
        color: var(--green);
    }

    .badge-down {
        background: var(--red-soft);
        color: var(--red);
    }

    .badge-warning {
        background: var(--amber-soft);
        color: var(--amber);
    }

    .badge-muted {
        background: rgba(255, 255, 255, 0.05);
        color: var(--muted);
        border: 1px solid var(--line);
    }

    .text-error {
        color: var(--red);
        font-size: 12px;
        font-family: monospace;
    }

    /* UI Custom Pagination Layout */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 16px;
        margin-top: 16px;
        border-top: 1px solid var(--line);
        flex-wrap: wrap;
        gap: 12px;
    }

    .pagination-info {
        font-size: 12px;
        color: var(--muted);
    }

    .pagination-buttons {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-page {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--line);
        color: var(--ink);
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-page:hover:not(:disabled) {
        background: var(--card-hover);
        color: #fff;
        border-color: var(--muted);
    }

    .btn-page:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .page-numbers {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .page-num {
        min-width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: 1px solid var(--line);
        background: transparent;
        color: var(--ink);
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .page-num:hover {
        background: var(--card-hover);
        color: #fff;
    }

    .page-num.active {
        background: var(--green);
        color: #fff;
        border-color: var(--green);
    }

    .page-dots {
        color: var(--muted);
        font-size: 12px;
        padding: 0 4px;
    }

    /* Laravel Bawaan / Tailwind Pagination Overrides */
    .pagination-wrapper {
        padding-top: 16px;
        margin-top: 12px;
        border-top: 1px solid var(--line);
    }

    .pagination-wrapper nav {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        flex-wrap: wrap;
        gap: 12px;
        width: 100%;
        font-size: 12px !important;
        color: var(--muted);
    }

    .pagination-wrapper nav > div:first-child,
    .pagination-wrapper nav p {
        font-size: 12px !important;
        color: var(--muted) !important;
        margin: 0 !important;
    }

    .pagination-wrapper nav > div:last-child,
    .pagination-wrapper ul.pagination,
    .pagination-wrapper nav span.relative {
        display: inline-flex !important;
        align-items: center !important;
        gap: 4px !important;
        margin: 0 !important;
        padding: 0 !important;
        list-style: none !important;
    }

    .pagination-wrapper svg {
        width: 14px !important;
        height: 14px !important;
        fill: currentColor !important;
        vertical-align: middle;
    }

    .pagination-wrapper a,
    .pagination-wrapper span[aria-current="page"] > span,
    .pagination-wrapper span[aria-disabled="true"] > span {
        min-width: 32px !important;
        height: 32px !important;
        padding: 0 8px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 8px !important;
        border: 1px solid var(--line) !important;
        background: rgba(255, 255, 255, 0.03) !important;
        color: var(--ink) !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        transition: all 0.2s ease !important;
        line-height: 1.4 !important;
    }

    .pagination-wrapper a:hover {
        background: var(--card-hover) !important;
        color: #fff !important;
        border-color: var(--muted) !important;
    }

    .pagination-wrapper span[aria-current="page"] > span {
        background: var(--green) !important;
        color: #fff !important;
        border-color: var(--green) !important;
    }

    .pagination-wrapper span[aria-disabled="true"] > span {
        opacity: 0.3 !important;
        cursor: not-allowed !important;
        background: transparent !important;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        main {
            margin-left: 0 !important;
        }
    }
</style>
</head>

<body>

    <!-- SIDEBAR LARAVEL LAYOUT -->
    @include('layouts.sidebar')

    <main>
        <div class="container">

            <!-- TOMBOL KEMBALI -->
            <a href="{{ route('dashboard.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>

            <!-- HEADER WEBSITE DETAIL -->
            <div class="header-card">
                <div class="header-info">
                    <h2>{{ $website->website_name }}</h2>
                    <a href="{{ $website->url }}" target="_blank">
                        {{ $website->url }} <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 11px;"></i>
                    </a>
                    <div class="meta-tags">
                        <span class="badge badge-muted">
                            <i class="bi bi-folder me-1"></i> {{ $website->category ?? 'Umum' }}
                        </span>
                        <span class="badge badge-muted">
                            <i class="bi bi-clock me-1"></i> Interval: Setiap {{ $website->check_interval }} Menit
                        </span>
                    </div>
                </div>
            </div>

            <!-- RIWAYAT LOG PENGECEKAN -->
            <div class="card">
                <div class="card-title">
                    <i class="bi bi-clock-history text-success"></i>
                    <span>Riwayat Log Pengecekan</span>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 22%;">Waktu Cek</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 15%;">HTTP Code</th>
                                <th style="width: 18%;">Latency</th>
                                <th style="width: 30%;">Detail Error</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td style="color:var(--muted); font-size:12px;">
                                        {{ $log->checked_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $log->status === 'online' ? 'badge-online' : ($log->status === 'warning' ? 'badge-warning' : 'badge-down') }}">
                                            ● {{ strtoupper($log->status_label ?? $log->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong
                                            style="color:#fff;">{{ $log->formatted_http_code ?? $log->http_code ?? '-' }}</strong>
                                    </td>
                                    <td>
                                        @if($log->response_time_ms)
                                            <span
                                                style="color: {{ $log->response_time_ms > 3000 ? 'var(--amber)' : 'var(--green)' }}; font-weight:700;">
                                                {{ number_format($log->response_time_ms) }} ms
                                            </span>
                                        @else
                                            <span style="color:var(--muted);">-</span>
                                        @endif
                                    </td>
                                    <td class="text-error">
                                        {{ $log->display_error ?? $log->error_message ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align:center; padding: 24px; color:var(--muted);">
                                        Belum ada riwayat log untuk website ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- UI Pagination Navigator Log -->
                <div class="pagination-container">
                    <div class="pagination-info">
                        Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari
                        {{ $logs->total() }} data
                    </div>

                    @if ($logs->hasPages())
                        <div class="pagination-buttons">
                            {{-- Tombol Previous --}}
                            @if ($logs->onFirstPage())
                                <button class="btn-page" disabled>
                                    <i class="bi bi-chevron-left"></i> Prev
                                </button>
                            @else
                                <a href="{{ $logs->previousPageUrl() }}" class="btn-page">
                                    <i class="bi bi-chevron-left"></i> Prev
                                </a>
                            @endif

                            {{-- Nomor Halaman Ringkas (Max 3 Halaman di Sekitar Halaman Aktif) --}}
                            <div class="page-numbers">
                                @php
                                    $currentPage = $logs->currentPage();
                                    $lastPage = $logs->lastPage();
                                    $side = 1; // Jumlah halaman yang tampil di kiri/kanan halaman aktif

                                    $start = max(1, $currentPage - $side);
                                    $end = min($lastPage, $currentPage + $side);
                                @endphp

                                {{-- Halaman Pertama & Ellipsis Kiri --}}
                                @if ($start > 1)
                                    <a href="{{ $logs->url(1) }}" class="page-num">1</a>
                                    @if ($start > 2)
                                        <span class="page-dots">...</span>
                                    @endif
                                @endif

                                {{-- Loop Halaman Utama --}}
                                @for ($p = $start; $p <= $end; $p++)
                                    @if ($p == $currentPage)
                                        <span class="page-num active">{{ $p }}</span>
                                    @else
                                        <a href="{{ $logs->url($p) }}" class="page-num">{{ $p }}</a>
                                    @endif
                                @endfor

                                {{-- Ellipsis Kanan & Halaman Terakhir --}}
                                @if ($end < $lastPage)
                                    @if ($end < $lastPage - 1)
                                        <span class="page-dots">...</span>
                                    @endif
                                    <a href="{{ $logs->url($lastPage) }}" class="page-num">{{ $lastPage }}</a>
                                @endif
                            </div>

                            {{-- Tombol Next --}}
                            @if ($logs->hasMorePages())
                                <a href="{{ $logs->nextPageUrl() }}" class="btn-page">
                                    Next <i class="bi bi-chevron-right"></i>
                                </a>
                            @else
                                <button class="btn-page" disabled>
                                    Next <i class="bi bi-chevron-right"></i>
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </main>

</body>

</html>