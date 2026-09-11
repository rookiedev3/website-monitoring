<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Log - {{ $website->website_name }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.jpeg') }}">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --bg: #f4f7fc;
            --card: #ffffff;
            --card-hover: #f8fafc;
            --ink: #172033;
            --muted: #778195;
            --line: #e8edf5;
            --green: #013220;
            --green-vibrant: #006B3F;
            --green-soft: #e6f7ee;
            --red: #dc2626;
            --red-soft: #fef2f2;
            --amber: #d97706;
            --amber-soft: #fef3c7;
            --blue: #0284c7;
            --blue-soft: #e0f2fe;
            --shadow: 0 10px 25px -5px rgba(31, 53, 97, 0.05), 0 8px 10px -6px rgba(31, 53, 97, 0.03);
            --sidebar-width: 260px;
            --sidebar-collapsed: 80px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
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

        /* MAIN CONTENT & PERGESERAN SIDEBAR */
        main {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 85px 12px 16px 12px;
            min-width: 0;
            transition: margin-left 0.3s ease, width 0.3s ease;
            width: calc(100% - var(--sidebar-width));
        }

        aside#sidebar.collapsed~main {
            margin-left: var(--sidebar-collapsed);
            width: calc(100% - var(--sidebar-collapsed));
        }

        .container {
            max-width: none;
            margin: 0;
            width: 100%;
        }

        /* Tombol Kembali */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 20px;
            transition: color 0.2s ease;
        }

        .btn-back:hover {
            color: var(--ink);
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

        .header-card.is-paused {
            border-color: rgba(119, 129, 149, 0.35);
        }

        .header-info h2 {
            font-size: 22px;
            margin: 0 0 6px;
            color: var(--ink);
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .header-info a {
            color: var(--green-vibrant);
            font-size: 13px;
            font-weight: 600;
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

        /* Banner peringatan saat monitoring dijeda */
        .paused-banner {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fef3c7;
            border: 1px solid rgba(217, 119, 6, 0.25);
            color: var(--amber);
            font-size: 13px;
            font-weight: 600;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
        }

        .paused-banner i {
            font-size: 16px;
            color: var(--amber);
        }

        /* Cards Layout */
        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 24px;
        }

        .card-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Table Styling */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
            min-width: 700px;
        }

        th {
            background: #f8fafc;
            color: var(--muted);
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 14px;
            border-bottom: 1px solid var(--line);
            white-space: nowrap;
        }

        td {
            padding: 14px 14px;
            border-bottom: 1px solid var(--line);
            color: var(--ink);
            vertical-align: middle;
            font-weight: 600;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .badge-online {
            background: var(--green-soft);
            color: #137a48;
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
            background: #f1f5f9;
            color: var(--muted);
            border: 1px solid var(--line);
        }

        .badge-paused {
            background: rgba(119, 129, 149, 0.12);
            color: var(--muted);
            border: 1px solid rgba(119, 129, 149, 0.25);
        }

        /* Status Dot - indikator "hidup" berkedip pelan */
        .status-dot {
            display: inline-block;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
            position: relative;
            flex-shrink: 0;
        }

        .status-dot.pulse::before {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.55;
            animation: statusDotPulse 2.6s ease-out infinite;
        }

        @keyframes statusDotPulse {
            0% { transform: scale(0.5); opacity: 0.55; }
            70% { transform: scale(2.4); opacity: 0; }
            100% { transform: scale(2.4); opacity: 0; }
        }

        .text-error {
            color: var(--red);
            font-size: 12px;
            font-family: monospace;
            font-weight: 600;
            max-width: 260px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f8fafc;
            border: 1px solid var(--line);
            color: var(--ink);
            font-size: 11px;
            font-weight: 700;
            padding: 6px 10px;
            border-radius: 8px;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-detail:hover {
            background: var(--green);
            color: #fff;
            border-color: var(--green);
        }

        /* UI Custom Pagination Layout */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 16px;
            margin-top: 12px;
            border-top: 1px solid var(--line);
            flex-wrap: wrap;
            gap: 12px;
        }

        .pagination-info {
            font-size: 11px;
            color: var(--muted);
            font-weight: 600;
        }

        .pagination-buttons {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-page {
            background: #f8fafc;
            border: 1px solid var(--line);
            color: var(--ink);
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-page:hover:not(:disabled) {
            background: var(--green);
            color: #fff;
            border-color: var(--green);
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
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .page-num:hover {
            background: #f8fafc;
            color: var(--green);
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
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
            font-size: 11px !important;
            color: var(--muted);
        }

        .pagination-wrapper nav>div:first-child,
        .pagination-wrapper nav p {
            font-size: 11px !important;
            color: var(--muted) !important;
            margin: 0 !important;
            font-weight: 600 !important;
        }

        .pagination-wrapper nav>div:last-child,
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
        .pagination-wrapper span[aria-current="page"]>span,
        .pagination-wrapper span[aria-disabled="true"]>span {
            min-width: 32px !important;
            height: 32px !important;
            padding: 0 8px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 8px !important;
            border: 1px solid var(--line) !important;
            background: #f8fafc !important;
            color: var(--ink) !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
            line-height: 1.4 !important;
        }

        .pagination-wrapper a:hover {
            background: var(--green) !important;
            color: #fff !important;
            border-color: var(--green) !important;
        }

        .pagination-wrapper span[aria-current="page"]>span {
            background: var(--green) !important;
            color: #fff !important;
            border-color: var(--green) !important;
        }

        .pagination-wrapper span[aria-disabled="true"]>span {
            opacity: 0.4 !important;
            cursor: not-allowed !important;
            background: transparent !important;
        }

        /* Live Preview Card */
        .preview-card-body {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--line);
            background: #f1f5f9;
            min-height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
        }

        .preview-card-body img {
            width: 100%;
            display: block;
        }

        .preview-card-body .preview-hint {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, 0);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            opacity: 0;
            transition: all 0.2s ease;
        }

        .preview-card-body:hover .preview-hint {
            background: rgba(15, 23, 42, 0.35);
            opacity: 1;
        }

        .preview-card-loading {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 8px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
        }

        .preview-card-loading i {
            font-size: 22px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .preview-refresh-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f8fafc;
            border: 1px solid var(--line);
            color: var(--ink);
            font-size: 12px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
        }

        .preview-refresh-btn:hover {
            background: #e8edf5;
        }

        /* Modal Live Preview (Ukuran Besar) */
        .preview-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.65);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .preview-modal-box {
            background: var(--card);
            border-radius: 16px;
            width: 100%;
            max-width: 700px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            overflow: hidden;
        }

        .preview-modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 18px;
            border-bottom: 1px solid var(--line);
        }

        .preview-modal-close {
            background: none;
            border: none;
            font-size: 20px;
            line-height: 1;
            color: var(--muted);
            cursor: pointer;
        }

        .preview-modal-body {
            background: #f1f5f9;
            min-height: 380px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-modal-body img {
            width: 100%;
            display: block;
        }

        /* Modal Detail Log */
        .log-modal-box {
            max-width: 560px;
        }

        .log-modal-body {
            background: var(--card);
            min-height: unset;
            display: block;
            padding: 20px;
        }

        .log-detail-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 10px 0;
            border-bottom: 1px solid var(--line);
            font-size: 13px;
        }

        .log-detail-row:last-of-type {
            border-bottom: none;
        }

        .log-detail-label {
            color: var(--muted);
            font-weight: 700;
            flex-shrink: 0;
        }

        .log-detail-value {
            color: var(--ink);
            font-weight: 600;
            text-align: right;
        }

        .log-detail-error-box {
            margin-top: 12px;
            background: var(--red-soft);
            border: 1px solid rgba(220, 38, 38, 0.2);
            color: var(--red);
            border-radius: 10px;
            padding: 14px;
            font-family: monospace;
            font-size: 12.5px;
            line-height: 1.6;
            white-space: pre-wrap;
            word-break: break-word;
            max-height: 300px;
            overflow-y: auto;
        }

        .log-detail-error-label {
            display: block;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--muted);
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 14px;
            margin-bottom: 8px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            main {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 85px 16px 16px 16px;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR LARAVEL LAYOUT -->
    @include('layouts.navigation')

    <main>
        <div class="container">

            <!-- TOMBOL KEMBALI -->
            <a href="{{ route('dashboard.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>

            @php $isPaused = $website->monitoring_status === 'paused'; @endphp

            <!-- BANNER PERINGATAN JIKA MONITORING DIJEDA -->
            @if($isPaused)
                <div class="paused-banner">
                    <i class="bi bi-pause-circle-fill"></i>
                    <span>Monitoring untuk website ini sedang <strong>dijeda</strong>. Pengecekan otomatis tidak berjalan dan data di bawah adalah riwayat sebelum dijeda.</span>
                </div>
            @endif

            <!-- HEADER WEBSITE DETAIL -->
            <div class="header-card {{ $isPaused ? 'is-paused' : '' }}">
                <div class="header-info">
                    <h2>
                        {{ $website->website_name }}
                        @if($isPaused)
                            <span class="badge badge-paused">
                                <i class="bi bi-pause-circle"></i> PAUSED
                            </span>
                        @else
                            <span class="badge badge-online">
                                <span class="status-dot pulse"></span> ACTIVE
                            </span>
                        @endif
                    </h2>
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
                        <span class="badge {{ $isPaused ? 'badge-paused' : 'badge-online' }}">
                            <span class="status-dot {{ $isPaused ? '' : 'pulse' }}"></span>
                            Status Monitoring: {{ $isPaused ? 'Paused' : 'Active' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- LIVE PREVIEW WEBSITE -->
            <div class="card">
                <div class="card-title" style="justify-content: space-between;">
                    <span>
                        <i class="bi bi-display" style="color: var(--green-vibrant);"></i>
                        Live Preview
                    </span>
                    <button type="button" class="preview-refresh-btn" onclick="refreshInlinePreview()">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                </div>
                <div class="preview-card-body" id="inlinePreviewBody" onclick="openPreviewModal()">
                    <div class="preview-card-loading" id="inlinePreviewLoading">
                        <i class="bi bi-arrow-repeat"></i>
                        <span>Mengambil tampilan terbaru...</span>
                    </div>
                    <img id="inlinePreviewImage" src="" alt="Live preview {{ $website->website_name }}" style="display:none;">
                    <div class="preview-hint"><i class="bi bi-arrows-fullscreen me-1"></i> Klik untuk perbesar</div>
                </div>
            </div>

            <!-- RIWAYAT LOG PENGECEKAN -->
            <div class="card">
                <div class="card-title">
                    <i class="bi bi-clock-history" style="color: var(--green-vibrant);"></i>
                    <span>Riwayat Log Pengecekan</span>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 20%;">Waktu Cek</th>
                                <th style="width: 13%;">Status</th>
                                <th style="width: 12%;">HTTP Code</th>
                                <th style="width: 15%;">Latency</th>
                                <th style="width: 28%;">Detail Error</th>
                                <th style="width: 12%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                @php
                                    // Untuk tampilan ringkas di tabel (boleh singkat/terpotong)
                                    $errorMessageShort = $log->display_error ?? $log->error_message ?? '-';
                                    // Untuk modal detail: SELALU pakai error_message MENTAH dari DB, jangan pakai display_error
                                    // supaya tidak ikut kepotong oleh Str::limit() di accessor display_error.
                                    $errorMessageFull = $log->error_message ?? $log->display_error ?? '-';
                                    $statusLabel = strtoupper($log->status_label ?? $log->status);
                                    $httpCode = $log->formatted_http_code ?? $log->http_code ?? '-';
                                    $latencyLabel = $log->response_time_ms ? number_format($log->response_time_ms) . ' ms' : '-';
                                    $checkedAtFull = $log->checked_at->format('d/m/Y H:i:s');
                                @endphp
                                <tr>
                                    <td style="color:var(--muted); font-size:12px;">
                                        {{ $checkedAtFull }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $log->status === 'online' ? 'badge-online' : ($log->status === 'warning' ? 'badge-warning' : 'badge-down') }}">
                                            ● {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong style="color:var(--ink);">{{ $httpCode }}</strong>
                                    </td>
                                    <td>
                                        @if($log->response_time_ms)
                                            <span
                                                style="color: {{ $log->response_time_ms > 3000 ? 'var(--amber)' : '#137a48' }}; font-weight:700;">
                                                {{ $latencyLabel }}
                                            </span>
                                        @else
                                            <span style="color:var(--muted);">-</span>
                                        @endif
                                    </td>
                                    <td class="text-error" title="{{ $errorMessageFull }}">
                                        {{ $errorMessageShort }}
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn-detail"
                                            onclick='openLogDetail({{ json_encode([
                                                "waktu" => $checkedAtFull,
                                                "status" => $statusLabel,
                                                "http" => (string) $httpCode,
                                                "latency" => $latencyLabel,
                                                "error" => (string) $errorMessageFull,
                                            ]) }})'
                                        >
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align:center; padding: 24px; color:var(--muted);">
                                        @if($isPaused)
                                            Monitoring website ini sedang dijeda dan belum memiliki riwayat log.
                                        @else
                                            Belum ada riwayat log untuk website ini.
                                        @endif
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

                            {{-- Nomor Halaman Ringkas --}}
                            <div class="page-numbers">
                                @php
                                    $currentPage = $logs->currentPage();
                                    $lastPage = $logs->lastPage();
                                    $side = 1;

                                    $start = max(1, $currentPage - $side);
                                    $end = min($lastPage, $currentPage + $side);
                                @endphp

                                @if ($start > 1)
                                    <a href="{{ $logs->url(1) }}" class="page-num">1</a>
                                    @if ($start > 2)
                                        <span class="page-dots">...</span>
                                    @endif
                                @endif

                                @for ($p = $start; $p <= $end; $p++)
                                    @if ($p == $currentPage)
                                        <span class="page-num active">{{ $p }}</span>
                                    @else
                                        <a href="{{ $logs->url($p) }}" class="page-num">{{ $p }}</a>
                                    @endif
                                @endfor

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

    <!-- MODAL LIVE PREVIEW BESAR -->
    <div id="previewModalOverlay" class="preview-modal-overlay">
        <div class="preview-modal-box">
            <div class="preview-modal-head">
                <h4 style="margin:0; font-size:14px; font-weight:800; color:var(--ink);">
                    {{ $website->website_name }}
                </h4>
                <div style="display:flex; align-items:center; gap:14px;">
                    <button type="button" class="preview-refresh-btn" onclick="refreshInlinePreview(true)">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                    <button type="button" class="preview-modal-close" onclick="closePreviewModal()">&times;</button>
                </div>
            </div>
            <div class="preview-modal-body">
                <img id="previewModalImage" src="" alt="Live preview besar {{ $website->website_name }}" style="display:none;">
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL LOG (ERROR PENUH) -->
    <div id="logModalOverlay" class="preview-modal-overlay">
        <div class="preview-modal-box log-modal-box">
            <div class="preview-modal-head">
                <h4 style="margin:0; font-size:14px; font-weight:800; color:var(--ink);">
                    <i class="bi bi-file-text me-1"></i> Detail Log Pengecekan
                </h4>
                <button type="button" class="preview-modal-close" onclick="closeLogDetail()">&times;</button>
            </div>
            <div class="preview-modal-body log-modal-body">
                <div class="log-detail-row">
                    <span class="log-detail-label">Waktu Cek</span>
                    <span class="log-detail-value" id="logDetailWaktu">-</span>
                </div>
                <div class="log-detail-row">
                    <span class="log-detail-label">Status</span>
                    <span class="log-detail-value" id="logDetailStatus">-</span>
                </div>
                <div class="log-detail-row">
                    <span class="log-detail-label">HTTP Code</span>
                    <span class="log-detail-value" id="logDetailHttp">-</span>
                </div>
                <div class="log-detail-row">
                    <span class="log-detail-label">Latency</span>
                    <span class="log-detail-value" id="logDetailLatency">-</span>
                </div>
                <span class="log-detail-error-label">Pesan Error Lengkap</span>
                <div class="log-detail-error-box" id="logDetailError">-</div>
            </div>
        </div>
    </div>

    <script>
        const previewWebsiteUrl = @json($website->url);

        function buildPreviewUrl(bust = false) {
            const params = new URLSearchParams({
                url: previewWebsiteUrl,
                screenshot: 'true',
                meta: 'false',
                embed: 'screenshot.url',
            });
            if (bust) params.set('refresh', Date.now());
            return `https://api.microlink.io/?${params.toString()}`;
        }

        function loadInlinePreview(bust = false) {
            const img = document.getElementById('inlinePreviewImage');
            const loading = document.getElementById('inlinePreviewLoading');

            img.style.display = 'none';
            loading.style.display = 'flex';

            img.onload = () => {
                loading.style.display = 'none';
                img.style.display = 'block';
            };
            img.onerror = () => {
                loading.innerHTML = '<i class="bi bi-exclamation-triangle"></i><span>Gagal memuat preview website ini.</span>';
            };

            img.src = buildPreviewUrl(bust);
        }

        function refreshInlinePreview(alsoModal = false) {
            loadInlinePreview(true);

            if (alsoModal) {
                const modalImg = document.getElementById('previewModalImage');
                modalImg.src = buildPreviewUrl(true);
            }
        }

        function openPreviewModal() {
            const modalImg = document.getElementById('previewModalImage');
            modalImg.src = buildPreviewUrl();
            document.getElementById('previewModalOverlay').style.display = 'flex';
        }

        function closePreviewModal() {
            document.getElementById('previewModalOverlay').style.display = 'none';
        }

        document.getElementById('previewModalOverlay').addEventListener('click', (e) => {
            if (e.target.id === 'previewModalOverlay') closePreviewModal();
        });

        loadInlinePreview();

        // ==== MODAL DETAIL LOG ====
        function openLogDetail(data) {
            document.getElementById('logDetailWaktu').textContent = data.waktu || '-';
            document.getElementById('logDetailStatus').textContent = data.status || '-';
            document.getElementById('logDetailHttp').textContent = data.http || '-';
            document.getElementById('logDetailLatency').textContent = data.latency || '-';
            document.getElementById('logDetailError').textContent = data.error || '-';
            document.getElementById('logModalOverlay').style.display = 'flex';
        }

        function closeLogDetail() {
            document.getElementById('logModalOverlay').style.display = 'none';
        }

        document.getElementById('logModalOverlay').addEventListener('click', (e) => {
            if (e.target.id === 'logModalOverlay') closeLogDetail();
        });
    </script>

</body>

</html>