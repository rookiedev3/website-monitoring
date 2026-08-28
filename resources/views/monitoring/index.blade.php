<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Monitoring Status Website</title>

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

        /* MAIN CONTENT */
        main {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 30px;
            min-width: 0;
        }

        aside.collapsed~main {
            margin-left: var(--sidebar-collapsed);
        }

        .container {
            max-width: 1180px;
            margin: 0 auto;
        }

        /* Header & Action */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 14px;
        }

        .dashboard-header h2 {
            font-size: 24px;
            margin: 0 0 4px;
            color: #fff;
            font-weight: 800;
        }

        .dashboard-header p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
        }

        .btn-refresh {
            background: var(--card);
            border: 1px solid var(--line);
            color: var(--ink);
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-refresh:hover {
            background: var(--card-hover);
            color: #fff;
        }

        /* Metrics Grid */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .metric-card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 18px;
            box-shadow: var(--shadow);
        }

        .metric-card span {
            font-size: 11px;
            color: var(--muted);
            font-weight: 700;
            text-transform: uppercase;
        }

        .metric-card h3 {
            font-size: 26px;
            margin: 6px 0 6px;
            color: #fff;
            font-weight: 800;
        }

        .metric-card p {
            font-size: 11px;
            margin: 0;
            color: var(--muted);
        }

        /* Filter Bar */
        .filter-card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 16px;
            margin-bottom: 20px;
            box-shadow: var(--shadow);
        }

        .filter-grid {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 250px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            background: var(--bg);
            border: 1px solid var(--line);
            color: var(--ink);
            padding: 10px 12px 10px 36px;
            border-radius: 10px;
            font-size: 13px;
            outline: none;
        }

        .search-box input:focus {
            border-color: var(--green);
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
        }

        .filter-dropdown select {
            background: var(--bg);
            border: 1px solid var(--line);
            color: var(--ink);
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            outline: none;
            cursor: pointer;
        }

        .filter-dropdown select:focus {
            border-color: var(--green);
        }

        /* Stacked Sections */
        .dashboard-stack {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--shadow);
        }

        .card-title {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title.danger-header {
            color: var(--red);
        }

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
            padding: 10px 12px;
            border-bottom: 1px solid var(--line);
        }

        td {
            padding: 12px;
            border-bottom: 1px solid var(--line);
            color: var(--ink);
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

        .badge-ssl {
            background: var(--blue-soft);
            color: var(--blue);
        }

        .badge-muted {
            background: rgba(255, 255, 255, 0.05);
            color: var(--muted);
        }

        .btn-detail {
            border: 1px solid var(--line);
            color: var(--ink);
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            background: transparent;
        }

        .btn-detail:hover {
            background: var(--card-hover);
            color: #fff;
            border-color: var(--muted);
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .metrics-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            main {
                margin-left: 0 !important;
            }
        }

        /* Perbaikan Perataan Tabel & Tombol Aksi */
        .table-responsive table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-responsive th,
        .table-responsive td {
            padding: 14px 12px;
            vertical-align: middle;
            /* Memastikan semua elemen sejajar vertikal */
        }

        /* Redesign Tombol Detail agar icon & teks menyatu sempurna */
        .btn-detail {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.03);
            color: var(--ink);
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            line-height: 1;
        }

        .btn-detail:hover {
            background: var(--card-hover);
            color: #fff;
            border-color: var(--muted);
        }

        .btn-detail i {
            font-size: 14px;
            line-height: 1;
        }

        /* Custom Styling Tabel Monitoring */
        .table-responsive table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Memaksa semua sel tabel sejajar tengah secara vertikal */
        .table-responsive th,
        .table-responsive td {
            padding: 14px 12px !important;
            vertical-align: middle !important;
        }

        /* Perbaikan Warna Badge SSL Valid (Agar teks kontras & tidak jenuh) */
        .badge-ssl {
            background: rgba(59, 130, 246, 0.15) !important;
            color: #60a5fa !important;
            border: 1px solid rgba(59, 130, 246, 0.3);
            padding: 4px 10px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* Redesign Tombol Detail (Sejajar sempurna & presisi) */
        .btn-detail {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            padding: 6px 14px !important;
            border-radius: 8px !important;
            border: 1px solid var(--line) !important;
            background: rgba(255, 255, 255, 0.04) !important;
            color: var(--ink) !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            white-space: nowrap !important;
            line-height: 1 !important;
            transition: all 0.2s ease !important;
        }

        .btn-detail:hover {
            background: var(--card-hover) !important;
            color: #fff !important;
            border-color: var(--muted) !important;
        }

        .btn-detail i {
            font-size: 13px !important;
            line-height: 1 !important;
        }

        /* Styling UI Pagination */
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
    </style>
</head>

<body>

    <!-- MEMANGGIL SIDEBAR LARAVEL LAYOUT -->
    @include('layouts.sidebar')

    <!-- MAIN CONTENT -->
    <main>
        <div class="container">

            <!-- HEADER & REFRESH ACTION -->
            <div class="dashboard-header">
                <div>
                    <h2>Dashboard Uptime Monitoring</h2>
                    <p>Pantauan kondisi teknis dan ketersediaan website secara real-time.</p>
                </div>
                <a href="{{ route('monitoring.index') }}" class="btn-refresh">
                    <i class="bi bi-arrow-clockwise"></i> Refresh Data
                </a>
            </div>

            <!-- 4 METRIK STATISTIK -->
            <div class="metrics-grid">
                <div class="metric-card">
                    <span>Total Monitored</span>
                    <h3 id="stat-total">{{ $stats['total'] }}</h3>
                    <p>Total website yang terdaftar</p>
                </div>
                <div class="metric-card">
                    <span>Online (Normal)</span>
                    <h3 style="color:var(--green)" id="stat-online">{{ $stats['online'] }}</h3>
                    <p>Website berjalan optimal</p>
                </div>
                <div class="metric-card">
                    <span>Warning (Slow)</span>
                    <h3 style="color:var(--amber)" id="stat-warning">{{ $stats['warning'] }}</h3>
                    <p>Respons lambat (&gt; 3 detik)</p>
                </div>
                <div class="metric-card">
                    <span>Down / Error</span>
                    <h3 style="color:var(--red)" id="stat-down">{{ $stats['down'] }}</h3>
                    <p>Koneksi terputus / SSL error</p>
                </div>
            </div>

            <!-- CARDS FILTER STATUS & SEARCH -->
            <div class="filter-card">
                <div class="filter-grid">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" id="search-input" placeholder="Cari nama website atau URL domain...">
                    </div>
                    <div class="filter-dropdown">
                        <select id="status-filter">
                            <option value="all">Semua Status Website</option>
                            <option value="online">Online (Normal)</option>
                            <option value="warning">Warning (Slow Response)</option>
                            <option value="down">Down / Error / SSL Invalid</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- STACKED SECTIONS -->
            <div class="dashboard-stack">

                <!-- 1. Daftar Status Website -->
                <div class="card">
                    <div class="card-title">
                        <span><i class="bi bi-globe me-2"></i> Daftar Status Website</span>
                        <span style="font-size:11px; color:var(--muted); font-weight:normal;">Pengecekan otomatis
                            berkala</span>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 30%;">Website / Domain</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 12%;">HTTP Response</th>
                                    <th style="width: 12%;">Latency</th>
                                    <th style="width: 14%;">Masa SSL</th>
                                    <th style="width: 12%;">Dicek Terakhir</th>
                                    <th style="width: 10%; text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="website-table-body">
                                @forelse($websites as $web)
                                    @php $log = $web->latestLog; @endphp
                                    <tr>
                                        <td>
                                            <strong style="color:#fff;">{{ $web->website_name }}</strong>
                                            <small style="display:block; color:var(--muted);">{{ $web->url }}</small>
                                        </td>
                                        <td>
                                            @if($log)
                                                <span
                                                    class="badge {{ $log->status === 'online' ? 'badge-online' : ($log->status === 'warning' ? 'badge-warning' : 'badge-down') }}">
                                                    ● {{ strtoupper($log->status) }}
                                                </span>
                                            @else
                                                <span class="badge badge-muted">Belum Dicek</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span style="font-weight:700; color:#fff;">
                                                {{ $log ? ($log->http_code ?? 'N/A') : '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($log && $log->response_time_ms)
                                                <span
                                                    style="color: {{ $log->response_time_ms > 3000 ? 'var(--amber)' : 'var(--green)' }}; font-weight:700;">
                                                    {{ number_format($log->response_time_ms) }} ms
                                                </span>
                                            @else
                                                <span style="color:var(--muted);">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($log && $log->ssl_valid)
                                                <span class="badge badge-ssl">
                                                    Valid ({{ $log->ssl_days_left }} Hari)
                                                </span>
                                            @elseif($log && $log->ssl_valid === false)
                                                <span class="badge badge-down">SSL Expired</span>
                                            @else
                                                <span style="color:var(--muted);">-</span>
                                            @endif
                                        </td>
                                        <td style="color:var(--muted); font-size:12px;">
                                            {{ $log ? $log->checked_at->diffForHumans() : '-' }}
                                        </td>
                                        <td style="text-align:center;">
                                            <a href="{{ route('monitoring.show', $web->id) }}" class="btn-detail">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align:center; padding: 24px; color:var(--muted);">
                                            Belum
                                            ada data website. Silakan jalankan Seeder.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- UI Pagination Navigator -->
                    <div class="pagination-container">
                        <div class="pagination-info" id="pagination-info">
                            Menampilkan 0 - 0 dari 0 data
                        </div>
                        <div class="pagination-buttons">
                            <button id="btn-prev" class="btn-page" disabled>
                                <i class="bi bi-chevron-left"></i> Prev
                            </button>
                            <div id="page-numbers" class="page-numbers"></div>
                            <button id="btn-next" class="btn-page" disabled>
                                Next <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 2. Tabel Insiden Aktif (Full Width Bawah) -->
                @if($activeIncidents->count() > 0)
                    <div class="card" style="border-color: rgba(217,76,76,0.3);">
                        <div class="card-title danger-header">
                            <span><i class="bi bi-exclamation-triangle-fill me-2"></i> Insiden Gangguan Aktif</span>
                            <span class="badge badge-down">{{ $activeIncidents->count() }} Insiden Perlu Penanganan</span>
                        </div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Website</th>
                                        <th>Tipe Gangguan</th>
                                        <th>Status Pekerjaan</th>
                                        <th>PIC Assigned</th>
                                        <th>Mulai Gangguan</th>
                                    </tr>
                                </thead>
                                <tbody id="incident-table-body">
                                    @foreach($activeIncidents as $incident)
                                        <tr class="incident-row">
                                            <td><strong style="color:#fff;">{{ $incident->website->website_name }}</strong></td>
                                            <td><span class="badge badge-down">{{ strtoupper($incident->incident_type) }}</span>
                                            </td>
                                            <td><span class="badge badge-warning">{{ strtoupper($incident->status) }}</span>
                                            </td>
                                            <td>{{ $incident->assignedUser->name ?? 'Belum Ditugaskan' }}</td>
                                            <td style="color:var(--muted); font-size:12px;">
                                                {{ $incident->started_at->locale('id')->diffForHumans() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- UI Pagination Navigator Insiden -->
                        <div class="pagination-container">
                            <div class="pagination-info" id="incident-pagination-info">
                                Menampilkan 0 - 0 dari 0 data
                            </div>
                            <div class="pagination-buttons">
                                <button id="btn-incident-prev" class="btn-page" disabled>
                                    <i class="bi bi-chevron-left"></i> Prev
                                </button>
                                <div id="incident-page-numbers" class="page-numbers"></div>
                                <button id="btn-incident-next" class="btn-page" disabled>
                                    Next <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

            </div> <!-- End of Dashboard Stack -->

        </div>
    </main>

    <!-- JAVASCRIPT: REAL-TIME AJAX, SEARCH & FILTER STATUS -->
    <script>
        let rawWebsitesData = [];
        let currentPage = 1;
        const perPage = 5; // Jumlah data per halaman

        function fetchRealtimeData() {
            fetch("{{ route('api.monitoring.status') }}")
                .then(response => response.json())
                .then(data => {
                    // 1. Update Kartu Angka Statistik
                    if (data && data.stats) {
                        document.getElementById('stat-total').innerText = data.stats.total ?? 0;
                        document.getElementById('stat-online').innerText = data.stats.online ?? 0;
                        document.getElementById('stat-warning').innerText = data.stats.warning ?? 0;
                        document.getElementById('stat-down').innerText = data.stats.down ?? 0;
                    }

                    // 2. Simpan Data & Render Tabel
                    if (data && data.websites) {
                        rawWebsitesData = data.websites;
                        renderTable();
                    }
                })
                .catch(error => console.error('Error fetching monitoring data:', error));
        }

        function renderTable() {
            const tbody = document.getElementById('website-table-body');
            const searchQuery = document.getElementById('search-input').value.toLowerCase().trim();
            const statusFilter = document.getElementById('status-filter').value;

            if (!tbody) return;

            // 1. Filtering Data
            const filteredWebsites = rawWebsitesData.filter(web => {
                const log = web.latest_log || web.latestLog;
                const currentStatus = log ? log.status : 'none';

                const matchesSearch = web.website_name.toLowerCase().includes(searchQuery) ||
                    web.url.toLowerCase().includes(searchQuery);

                let matchesStatus = true;
                if (statusFilter === 'online') matchesStatus = currentStatus === 'online';
                else if (statusFilter === 'warning') matchesStatus = currentStatus === 'warning';
                else if (statusFilter === 'down') matchesStatus = ['down', 'ssl_error'].includes(currentStatus);

                return matchesSearch && matchesStatus;
            });

            const totalItems = filteredWebsites.length;
            const totalPages = Math.ceil(totalItems / perPage) || 1;

            // Reset Halaman jika pencarian membuat halaman aktif melebihi total halaman
            if (currentPage > totalPages) {
                currentPage = totalPages;
            }

            // Tampilan Data Kosong
            if (totalItems === 0) {
                tbody.innerHTML = `<tr><td colspan="7" style="text-align:center; padding: 24px; color:var(--muted);">Tidak ada website yang sesuai pencarian/filter.</td></tr>`;
                renderPaginationControls(0, 1);
                return;
            }

            // 2. Slicing Data untuk Pagination
            const startIndex = (currentPage - 1) * perPage;
            const endIndex = startIndex + perPage;
            const paginatedItems = filteredWebsites.slice(startIndex, endIndex);

            // 3. Render Baris Tabel
            let html = '';
            const baseUrl = "{{ route('monitoring.show', ':id') }}";

            paginatedItems.forEach(web => {
                const log = web.latest_log || web.latestLog;

                let statusBadge = '<span class="badge badge-muted">Belum Dicek</span>';
                let httpCode = '<span style="color:var(--muted);">N/A</span>';
                let responseTime = '<span style="color:var(--muted);">-</span>';
                let sslBadge = '<span style="color:var(--muted);">-</span>';
                let checkedAt = '-';

                if (log) {
                    if (log.status === 'online') {
                        statusBadge = '<span class="badge badge-online">● ONLINE</span>';
                    } else if (log.status === 'warning') {
                        statusBadge = '<span class="badge badge-warning">● WARNING</span>';
                    } else {
                        statusBadge = '<span class="badge badge-down">● DOWN</span>';
                    }

                    httpCode = log.http_code
                        ? `<span style="font-weight:700; color:#fff;">${log.http_code}</span>`
                        : '<span style="color:var(--muted);">N/A</span>';

                    if (log.status !== 'down' && log.response_time_ms) {
                        const latencyColor = log.response_time_ms > 3000 ? 'var(--amber)' : 'var(--green)';
                        responseTime = `<span style="color:${latencyColor}; font-weight:700;">${Number(log.response_time_ms).toLocaleString()} ms</span>`;
                    } else if (log.response_time_ms) {
                        responseTime = `<span style="color:var(--muted);">${Number(log.response_time_ms).toLocaleString()} ms</span>`;
                    }

                    if (log.ssl_valid) {
                        sslBadge = `<span class="badge badge-ssl">Valid (${log.ssl_days_left} Hari)</span>`;
                    } else if (log.ssl_valid === false && log.status !== 'down') {
                        sslBadge = `<span class="badge badge-down">SSL Expired</span>`;
                    } else {
                        sslBadge = `<span class="badge badge-muted">N/A</span>`;
                    }

                    checkedAt = timeAgo(log.checked_at);
                }

                const detailUrl = baseUrl.replace(':id', web.id);

                html += `
                <tr>
                    <td>
                        <strong style="color:#fff; display:block;">${web.website_name}</strong>
                        <small style="color:var(--muted);">${web.url}</small>
                    </td>
                    <td>${statusBadge}</td>
                    <td>${httpCode}</td>
                    <td>${responseTime}</td>
                    <td>${sslBadge}</td>
                    <td style="color:var(--muted); font-size:12px;">${checkedAt}</td>
                    <td style="text-align:center;">
                        <a href="${detailUrl}" class="btn-detail">
                            <i class="bi bi-eye"></i>
                            <span>Detail</span>
                        </a>
                    </td>
                </tr>
            `;
            });

            tbody.innerHTML = html;

            // 4. Update Kontrol Pagination
            renderPaginationControls(totalItems, totalPages, startIndex + 1, Math.min(endIndex, totalItems));
        }

        function renderPaginationControls(totalItems, totalPages, from = 0, to = 0) {
            const infoEl = document.getElementById('pagination-info');
            const prevBtn = document.getElementById('btn-prev');
            const nextBtn = document.getElementById('btn-next');
            const pageNumbersEl = document.getElementById('page-numbers');

            if (infoEl) {
                infoEl.innerText = totalItems > 0
                    ? `Menampilkan ${from} - ${to} dari ${totalItems} data`
                    : 'Menampilkan 0 - 0 dari 0 data';
            }

            if (prevBtn) prevBtn.disabled = currentPage <= 1;
            if (nextBtn) nextBtn.disabled = currentPage >= totalPages;

            if (pageNumbersEl) {
                let pagesHtml = '';
                for (let i = 1; i <= totalPages; i++) {
                    pagesHtml += `
                    <button class="page-num ${i === currentPage ? 'active' : ''}" onclick="goToPage(${i})">
                        ${i}
                    </button>
                `;
                }
                pageNumbersEl.innerHTML = pagesHtml;
            }
        }

        function goToPage(page) {
            currentPage = page;
            renderTable();
        }

        function timeAgo(dateString) {
            if (!dateString) return '-';

            const now = new Date();
            const past = new Date(dateString);
            const seconds = Math.floor((now - past) / 1000);

            if (seconds < 5) return 'Baru saja';
            if (seconds < 60) return `${seconds} detik lalu`;

            const minutes = Math.floor(seconds / 60);
            if (minutes < 60) return `${minutes}m lalu`;

            const hours = Math.floor(minutes / 60);
            if (hours < 24) return `${hours}j lalu`;

            return past.toLocaleDateString('id-ID');
        }

        // Event Listeners
        document.getElementById('btn-prev').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });

        document.getElementById('btn-next').addEventListener('click', () => {
            currentPage++;
            renderTable();
        });

        document.getElementById('search-input').addEventListener('input', () => {
            currentPage = 1; // Reset ke halaman 1 saat mengetik kata kunci
            renderTable();
        });

        document.getElementById('status-filter').addEventListener('change', () => {
            currentPage = 1; // Reset ke halaman 1 saat mengubah filter status
            renderTable();
        });

        // Initial Fetch & Real-time Interval 5 Detik
        fetchRealtimeData();
        setInterval(fetchRealtimeData, 5000);

        // --- PAGINASI CLIENT-SIDE UNTUK TABEL INSIDEN ---
        let currentIncidentPage = 1;
        const incidentPerPage = 5;

        function renderIncidentPagination() {
            const rows = document.querySelectorAll('#incident-table-body .incident-row');
            const totalItems = rows.length;

            if (totalItems === 0) return;

            const totalPages = Math.ceil(totalItems / incidentPerPage);
            const startIndex = (currentIncidentPage - 1) * incidentPerPage;
            const endIndex = startIndex + incidentPerPage;

            // Sembunyikan atau tampilkan baris sesuai halaman aktif
            rows.forEach((row, index) => {
                if (index >= startIndex && index < endIndex) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Update Text Informasi
            const infoEl = document.getElementById('incident-pagination-info');
            if (infoEl) {
                infoEl.innerText = `Menampilkan ${startIndex + 1} - ${Math.min(endIndex, totalItems)} dari ${totalItems} insiden`;
            }

            // Update Tombol Status
            const prevBtn = document.getElementById('btn-incident-prev');
            const nextBtn = document.getElementById('btn-incident-next');
            if (prevBtn) prevBtn.disabled = currentIncidentPage <= 1;
            if (nextBtn) nextBtn.disabled = currentIncidentPage >= totalPages;

            // Render Angka Halaman
            const pageNumbersEl = document.getElementById('incident-page-numbers');
            if (pageNumbersEl) {
                let pagesHtml = '';
                for (let i = 1; i <= totalPages; i++) {
                    pagesHtml += `
                <button class="page-num ${i === currentIncidentPage ? 'active' : ''}" onclick="goToIncidentPage(${i})">
                    ${i}
                </button>
            `;
                }
                pageNumbersEl.innerHTML = pagesHtml;
            }
        }

        function goToIncidentPage(page) {
            currentIncidentPage = page;
            renderIncidentPagination();
        }

        document.getElementById('btn-incident-prev')?.addEventListener('click', () => {
            if (currentIncidentPage > 1) {
                currentIncidentPage--;
                renderIncidentPagination();
            }
        });

        document.getElementById('btn-incident-next')?.addEventListener('click', () => {
            currentIncidentPage++;
            renderIncidentPagination();
        });

        // Jalankan pagination insiden saat halaman pertama dibuka
        document.addEventListener('DOMContentLoaded', renderIncidentPagination);
    </script>
</body>

</html>