<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Monitoring Status Website</title>
  <link rel="icon" type="image/png" href="{{ asset('img/logo.jpeg') }}">

  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

  <style>
    :root {
      --bg: #0b120f;
      --card: #111b16;
      --card-hover: #17231d;
      --ink: #dce9e1;
      --muted: #82988c;
      --line: #2e4a3b;
      --green: #0f9f6e;
      --green-soft: rgba(15, 159, 110, 0.12);
      --red: #d94c4c;
      --red-soft: rgba(217, 76, 76, 0.12);
      --amber: #d98b1d;
      --amber-soft: rgba(217, 139, 29, 0.12);
      --blue: #2563eb;
      --blue-soft: rgba(37, 99, 235, 0.12);
      --shadow: 0 10px 30px rgba(0, 0, 0, .3);
      --sidebar-width: 215px;
      --sidebar-collapsed: 62px;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif;
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

    /* STYLE SIDEBAR & NAVBAR INTEGRATION */
    aside {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: var(--sidebar-width);
      background: var(--card);
      border-right: 1px solid var(--line);
      display: flex;
      flex-direction: column;
      z-index: 100;
      box-shadow: var(--shadow);
    }

    aside.collapsed {
      width: var(--sidebar-collapsed);
    }

    /* MAIN CONTENT & PERGESERAN SIDEBAR */
    main {
      margin-left: var(--sidebar-width);
      flex: 1;
      padding: 24px;
      min-width: 0;
      transition: margin-left 0.3s ease, width 0.3s ease;
      width: calc(100% - var(--sidebar-width));
      margin-top: var(--navbar-height, 60px);
    }

    aside#sidebar.collapsed~main {
      margin-left: var(--sidebar-collapsed);
      width: calc(100% - var(--sidebar-collapsed));
    }

    .container {
      max-width: 1180px;
      margin: 0 auto;
      width: 100%;
    }

    /* Header Actions Bar */
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
      font-weight: 700;
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
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: background 0.2s ease, color 0.2s ease;
    }

    .btn-refresh:hover {
      background: var(--card-hover);
      color: #fff;
    }

    /* Metrics Cards Grid */
    .metrics-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }

    .metric-card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 14px;
      padding: 18px;
      box-shadow: var(--shadow);
      min-width: 0;
    }

    .metric-card span {
      font-size: 11px;
      color: var(--muted);
      font-weight: 700;
      text-transform: uppercase;
    }

    .metric-card h3 {
      font-size: 26px;
      margin: 6px 0;
      color: #fff;
      font-weight: 800;
      white-space: nowrap;
    }

    .metric-card p {
      font-size: 11px;
      margin: 0;
      color: var(--muted);
    }

    /* Filter & Search Bar */
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
      transition: border-color 0.2s ease;
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
      transition: border-color 0.2s ease;
    }

    .filter-dropdown select:focus {
      border-color: var(--green);
    }

    /* Stacked Cards & Tables */
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
      flex-wrap: wrap;
      gap: 8px;
    }

    .card-title.danger-header {
      color: var(--red);
    }

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
      min-width: 650px;
    }

    th {
      color: var(--muted);
      font-size: 11px;
      text-transform: uppercase;
      padding: 10px 12px;
      border-bottom: 1px solid var(--line);
      white-space: nowrap;
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

    tr.row-paused {
      opacity: 0.55;
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

    .badge-ssl {
      background: var(--blue-soft);
      color: #60a5fa;
      border: 1px solid rgba(37, 99, 235, 0.3);
    }

    .badge-muted {
      background: rgba(255, 255, 255, 0.05);
      color: var(--muted);
    }

    .badge-paused {
      background: rgba(130, 152, 140, 0.12);
      color: var(--muted);
      border: 1px solid rgba(130, 152, 140, 0.3);
    }

    /* Action Buttons */
    .btn-detail {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 6px 14px;
      border-radius: 8px;
      border: 1px solid var(--line);
      background: rgba(255, 255, 255, 0.04);
      color: var(--ink);
      font-size: 12px;
      font-weight: 600;
      text-decoration: none;
      white-space: nowrap;
      line-height: 1;
      transition: all 0.2s ease;
    }

    .btn-detail:hover {
      background: var(--card-hover);
      color: #fff;
      border-color: var(--muted);
    }

    /* Pagination Controls */
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
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    /* RESPONSIF: KHUSUS LAYAR HP & TABLET */
    @media (max-width: 1024px) {
      .metrics-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media (max-width: 768px) {
      main {
        margin-left: 0 !important;
        width: 100% !important;
        padding: 14px;
        padding-top: 60px;
      }

      .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
      }

      .metrics-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .filter-grid {
        flex-direction: column;
      }

      .search-box {
        width: 100%;
      }

      .filter-dropdown select {
        width: 100%;
      }
    }

    @media (max-width: 460px) {
      .metrics-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>

  <!-- MEMANGGIL NAVBAR & SIDEBAR (SAMA SEPERTI INDEX 1) -->
  @include('layouts.navigation')

  <!-- MAIN CONTENT DASHBOARD -->
  <main>
    <div class="container">

      <!-- HEADER & REFRESH ACTION -->
      <div class="dashboard-header">
        <div>
          <h2>Dashboard Uptime Monitoring</h2>
          <p>Pantauan kondisi teknis dan ketersediaan website secara real-time.</p>
        </div>
        <a href="{{ route('dashboard.index') }}" class="btn-refresh">
          <i class="bi bi-arrow-clockwise"></i> Refresh Data
        </a>
      </div>

      <!-- 5 METRIK STATISTIK -->
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
        <div class="metric-card">
          <span>Paused</span>
          <h3 style="color:var(--muted)" id="stat-paused">{{ $stats['paused'] }}</h3>
          <p>Monitoring website dijeda</p>
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
              <option value="paused">Paused (Monitoring Off)</option>
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
            <span style="font-size:11px; color:var(--muted); font-weight:normal;">Pengecekan otomatis berkala</span>
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
                  <tr class="{{ $web->monitoring_status === 'paused' ? 'row-paused' : '' }}">
                    <td>
                      <strong style="color:#fff;">{{ $web->website_name }}</strong>
                      <small style="display:block; color:var(--muted);">{{ $web->url }}</small>
                    </td>
                    <td>
                      @if($web->monitoring_status === 'paused')
                        <span class="badge badge-paused">
                          <i class="bi bi-pause-circle"></i> PAUSED
                        </span>
                      @elseif($log)
                        <span class="badge {{ $log->status === 'online' ? 'badge-online' : ($log->status === 'warning' ? 'badge-warning' : 'badge-down') }}">
                          ● {{ strtoupper($log->status) }}
                        </span>
                      @else
                        <span class="badge badge-muted">Belum Dicek</span>
                      @endif
                    </td>
                    <td>
                      @if($web->monitoring_status === 'paused')
                        <span style="color:var(--muted);">-</span>
                      @else
                        <span style="font-weight:700; color:#fff;">
                          {{ $log ? ($log->http_code ?? 'N/A') : '-' }}
                        </span>
                      @endif
                    </td>
                    <td>
                      @if($web->monitoring_status !== 'paused' && $log && $log->response_time_ms)
                        <span style="color: {{ $log->response_time_ms > 3000 ? 'var(--amber)' : 'var(--green)' }}; font-weight:700;">
                          {{ number_format($log->response_time_ms) }} ms
                        </span>
                      @else
                        <span style="color:var(--muted);">-</span>
                      @endif
                    </td>
                    <td>
                      @if($web->monitoring_status === 'paused')
                        <span style="color:var(--muted);">-</span>
                      @elseif($log && $log->ssl_valid)
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
                      @if($web->monitoring_status === 'paused')
                        Monitoring dijeda
                      @else
                        {{ $log ? $log->checked_at->diffForHumans() : '-' }}
                      @endif
                    </td>
                    <td style="text-align:center;">
                      <a href="{{ route('dashboard.show', $web->id) }}" class="btn-detail">
                        <i class="bi bi-eye"></i> Detail
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" style="text-align:center; padding: 24px; color:var(--muted);">
                      Belum ada data website. Silakan jalankan Seeder.</td>
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

        <!-- 2. Tabel Insiden Aktif -->
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
                    @php
                      $rawType = strtolower($incident->incident_type);
                      if (str_contains($rawType, 'warning') || str_contains($rawType, 'slow') || str_contains($rawType, 'lambat')) {
                        $typeName = 'SLOW';
                        $badgeClass = 'badge-warning';
                      } elseif (str_contains($rawType, 'ssl')) {
                        $typeName = 'SSL WARNING';
                        $badgeClass = 'badge-ssl';
                      } elseif (str_contains($rawType, 'normal') || str_contains($rawType, 'online')) {
                        $typeName = 'NORMAL';
                        $badgeClass = 'badge-online';
                      } else {
                        $typeName = 'DOWN';
                        $badgeClass = 'badge-down';
                      }

                      $jobStatus = strtolower(trim($incident->status));
                      if (str_contains($jobStatus, 'progress') || str_contains($jobStatus, 'proses')) {
                        $jobStyle = 'background: rgba(217, 139, 29, 0.12); color: #d98b1d; border: 1px solid rgba(217, 139, 29, 0.3);';
                        $jobStatusText = 'ON PROGRESS';
                      } else {
                        $jobStyle = 'background: rgba(217, 76, 76, 0.12); color: #d94c4c; border: 1px solid rgba(217, 76, 76, 0.3);';
                        $jobStatusText = strtoupper($incident->status);
                      }
                    @endphp
                    <tr class="incident-row">
                      <td><strong style="color:#fff;">{{ $incident->website->website_name }}</strong></td>
                      <td>
                        <span class="badge {{ $badgeClass }}">
                          {{ $typeName }}
                        </span>
                      </td>
                      <td>
                        <span class="badge" style="{{ $jobStyle }}">{{ $jobStatusText }}</span>
                      </td>
                      <td>{{ $incident->assignedUser?->name ?? 'Belum Ditugaskan' }}</td>
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

  <!-- JAVASCRIPT SYSTEM & REAL-TIME DATA -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      renderIncidentPagination();
    });

    // REAL-TIME AJAX, SEARCH & FILTER STATUS
    let rawWebsitesData = [];
    let currentPage = 1;
    const perPage = 5;

    function fetchRealtimeData() {
      fetch("{{ route('api.dashboard.status') }}")
        .then(response => response.json())
        .then(data => {
          if (data && data.stats) {
            document.getElementById('stat-total').innerText = data.stats.total ?? 0;
            document.getElementById('stat-online').innerText = data.stats.online ?? 0;
            document.getElementById('stat-warning').innerText = data.stats.warning ?? 0;
            document.getElementById('stat-down').innerText = data.stats.down ?? 0;
            document.getElementById('stat-paused').innerText = data.stats.paused ?? 0;
          }

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

      const filteredWebsites = rawWebsitesData.filter(web => {
        const log = web.latest_log || web.latestLog;
        const currentStatus = log ? log.status : 'none';
        const isPaused = web.monitoring_status === 'paused';

        const matchesSearch = web.website_name.toLowerCase().includes(searchQuery) ||
          web.url.toLowerCase().includes(searchQuery);

        let matchesStatus = true;
        if (statusFilter === 'online') matchesStatus = !isPaused && currentStatus === 'online';
        else if (statusFilter === 'warning') matchesStatus = !isPaused && currentStatus === 'warning';
        else if (statusFilter === 'down') matchesStatus = !isPaused && ['down', 'ssl_error'].includes(currentStatus);
        else if (statusFilter === 'paused') matchesStatus = isPaused;

        return matchesSearch && matchesStatus;
      });

      const totalItems = filteredWebsites.length;
      const totalPages = Math.ceil(totalItems / perPage) || 1;

      if (currentPage > totalPages) {
        currentPage = totalPages;
      }

      if (totalItems === 0) {
        tbody.innerHTML = `<tr><td colspan="7" style="text-align:center; padding: 24px; color:var(--muted);">Tidak ada website yang sesuai pencarian/filter.</td></tr>`;
        renderPaginationControls(0, 1);
        return;
      }

      const startIndex = (currentPage - 1) * perPage;
      const endIndex = startIndex + perPage;
      const paginatedItems = filteredWebsites.slice(startIndex, endIndex);

      let html = '';
      const baseUrl = "{{ route('dashboard.show', ':id') }}";

      paginatedItems.forEach(web => {
        const log = web.latest_log || web.latestLog;
        const isPaused = web.monitoring_status === 'paused';

        let statusBadge = '<span class="badge badge-muted">Belum Dicek</span>';
        let httpCode = '<span style="color:var(--muted);">-</span>';
        let responseTime = '<span style="color:var(--muted);">-</span>';
        let sslBadge = '<span style="color:var(--muted);">-</span>';
        let checkedAt = '-';

        if (isPaused) {
          statusBadge = '<span class="badge badge-paused"><i class="bi bi-pause-circle"></i> PAUSED</span>';
          checkedAt = '<span style="color:var(--muted);">Monitoring dijeda</span>';
        } else if (log) {
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
        const rowClass = isPaused ? 'row-paused' : '';

        html += `
          <tr class="${rowClass}">
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

      if (!pageNumbersEl) return;

      let pagesHtml = '';
      const side = 1;
      const start = Math.max(1, currentPage - side);
      const end = Math.min(totalPages, currentPage + side);

      if (start > 1) {
        pagesHtml += `<button class="page-num" onclick="goToPage(1)">1</button>`;
        if (start > 2) pagesHtml += `<span class="page-dots">...</span>`;
      }

      for (let p = start; p <= end; p++) {
        if (p === currentPage) {
          pagesHtml += `<span class="page-num active">${p}</span>`;
        } else {
          pagesHtml += `<button class="page-num" onclick="goToPage(${p})">${p}</button>`;
        }
      }

      if (end < totalPages) {
        if (end < totalPages - 1) pagesHtml += `<span class="page-dots">...</span>`;
        pagesHtml += `<button class="page-num" onclick="goToPage(${totalPages})">${totalPages}</button>`;
      }

      pageNumbersEl.innerHTML = pagesHtml;
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
      currentPage = 1;
      renderTable();
    });

    document.getElementById('status-filter').addEventListener('change', () => {
      currentPage = 1;
      renderTable();
    });

    fetchRealtimeData();
    setInterval(fetchRealtimeData, 5000);

    let currentIncidentPage = 1;
    const incidentPerPage = 5;

    function renderIncidentPagination() {
      const rows = document.querySelectorAll('#incident-table-body .incident-row');
      const totalItems = rows.length;

      if (totalItems === 0) return;

      const totalPages = Math.ceil(totalItems / incidentPerPage) || 1;

      if (currentIncidentPage > totalPages) {
        currentIncidentPage = totalPages;
      }

      const startIndex = (currentIncidentPage - 1) * incidentPerPage;
      const endIndex = startIndex + incidentPerPage;

      rows.forEach((row, index) => {
        row.style.display = (index >= startIndex && index < endIndex) ? '' : 'none';
      });

      const infoEl = document.getElementById('incident-pagination-info');
      if (infoEl) {
        infoEl.innerText = `Menampilkan ${startIndex + 1} - ${Math.min(endIndex, totalItems)} dari ${totalItems} data`;
      }

      const prevBtn = document.getElementById('btn-incident-prev');
      const nextBtn = document.getElementById('btn-incident-next');
      if (prevBtn) prevBtn.disabled = currentIncidentPage <= 1;
      if (nextBtn) nextBtn.disabled = currentIncidentPage >= totalPages;

      const pageNumbersEl = document.getElementById('incident-page-numbers');
      if (!pageNumbersEl) return;

      let pagesHtml = '';
      const side = 1;
      const start = Math.max(1, currentIncidentPage - side);
      const end = Math.min(totalPages, currentIncidentPage + side);

      if (start > 1) {
        pagesHtml += `<button class="page-num" onclick="goToIncidentPage(1)">1</button>`;
        if (start > 2) pagesHtml += `<span class="page-dots">...</span>`;
      }

      for (let p = start; p <= end; p++) {
        if (p === currentIncidentPage) {
          pagesHtml += `<span class="page-num active">${p}</span>`;
        } else {
          pagesHtml += `<button class="page-num" onclick="goToIncidentPage(${p})">${p}</button>`;
        }
      }

      if (end < totalPages) {
        if (end < totalPages - 1) pagesHtml += `<span class="page-dots">...</span>`;
        pagesHtml += `<button class="page-num" onclick="goToIncidentPage(${totalPages})">${totalPages}</button>`;
      }

      pageNumbersEl.innerHTML = pagesHtml;
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
  </script>
</body>

</html>