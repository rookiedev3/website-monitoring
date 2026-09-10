<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Monitoring Status Website</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
      --gold: #C7AB6B;
      --gold-soft: rgba(199, 171, 107, 0.15);
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
      font-size: 22px;
      margin: 0 0 4px;
      color: #172033;
      font-weight: 800;
    }

    .dashboard-header p {
      margin: 0;
      color: var(--muted);
      font-size: 12px;
      font-weight: 600;
    }

    .btn-refresh {
      background: #ffffff;
      border: 1px solid var(--line);
      color: var(--ink);
      padding: 9px 18px;
      border-radius: 10px;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.02);
      transition: all 0.2s ease;
    }

    .btn-refresh:hover {
      background: var(--green-vibrant); /* Mengubah latar belakang menjadi hijau saat di-hover */
      color: #ffffff;
      border-color: var(--green-vibrant); /* Mengubah garis pinggir menjadi hijau */
      box-shadow: 0 4px 12px rgba(0, 107, 63, 0.3); /* Menyesuaikan bayangan menjadi rona hijau */
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
      border-radius: 16px;
      padding: 18px;
      box-shadow: var(--shadow);
      min-width: 0;
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .metric-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 30px rgba(31, 53, 97, 0.08);
    }

    .metric-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
    }

    .metric-card.card-total::before { background: var(--blue); }
    .metric-card.card-online::before { background: #137a48; }
    .metric-card.card-warning::before { background: var(--amber); }
    .metric-card.card-down::before { background: var(--red); }
    .metric-card.card-paused::before { background: #64748b; }

    .metric-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 12px;
    }

    .metric-header span {
      font-size: 11px;
      color: var(--muted);
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }

    .metric-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
    }

    .card-total .metric-icon { background: var(--blue-soft); color: var(--blue); }
    .card-online .metric-icon { background: var(--green-soft); color: #137a48; }
    .card-warning .metric-icon { background: var(--amber-soft); color: var(--amber); }
    .card-down .metric-icon { background: var(--red-soft); color: var(--red); }
    .card-paused .metric-icon { background: #f1f5f9; color: #64748b; }

    .metric-card h3 {
      font-size: 24px;
      margin: 0 0 4px;
      color: #172033;
      font-weight: 800;
      white-space: nowrap;
    }

    .metric-card p {
      font-size: 11px;
      margin: 0;
      color: var(--muted);
      font-weight: 600;
    }

    /* Filter & Search Bar */
    .filter-card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 16px;
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
      background: #fbfcfe;
      border: 1px solid var(--line);
      color: var(--ink);
      padding: 10px 12px 10px 38px;
      border-radius: 10px;
      font-size: 13px;
      outline: none;
      font-weight: 600;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .search-box input:focus {
      border-color: var(--green-vibrant);
      background: #ffffff;
      box-shadow: 0 0 0 3px rgba(0, 107, 63, 0.1);
    }

    .search-box i {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--muted);
    }

    .filter-dropdown select {
      background: #fbfcfe;
      border: 1px solid var(--line);
      color: var(--ink);
      padding: 10px 14px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      outline: none;
      cursor: pointer;
      transition: border-color 0.2s ease;
    }

    .filter-dropdown select:focus {
      border-color: var(--green-vibrant);
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
      border-radius: 18px;
      padding: 20px;
      box-shadow: var(--shadow);
    }

    .card-title {
      font-size: 15px;
      font-weight: 800;
      color: #172033;
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
      min-width: 750px;
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

    tr.row-paused {
      opacity: 0.55;
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

    .badge-online { background: #e6f7ee; color: #137a48; }
    .badge-down { background: #fef2f2; color: var(--red); }
    .badge-warning { background: #fef3c7; color: var(--amber); }
    .badge-ssl { background: var(--blue-soft); color: var(--blue); border: 1px solid rgba(2, 132, 199, 0.2); }
    .badge-muted { background: #f1f5f9; color: var(--muted); }
    .badge-paused { background: rgba(119, 129, 149, 0.12); color: var(--muted); border: 1px solid rgba(119, 129, 149, 0.25); }

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

    /* Uptime Bars Component (Hetrixtools / UptimeRobot Style) */
    .uptime-container {
      display: flex;
      align-items: center;
      gap: 12px;
      min-width: 210px;
    }

    .uptime-bars {
      display: flex;
      align-items: center;
      gap: 3px;
      background: rgba(0, 0, 0, 0.02);
      padding: 4px 6px;
      border-radius: 6px;
      border: 1px solid rgba(0,0,0,0.03);
    }

    .uptime-bar {
      width: 4px;
      height: 20px;
      border-radius: 2px;
      transition: all 0.2s ease;
      position: relative;
      cursor: pointer;
    }

    .uptime-bar:hover {
      transform: scaleY(1.3);
      opacity: 0.8;
    }

    .bar-online { background-color: #10b981; }
    .bar-warning { background-color: #f59e0b; }
    .bar-down { background-color: #ef4444; }
    .bar-empty { background-color: #e2e8f0; }

    .uptime-percentage {
      font-size: 12px;
      font-weight: 800;
      color: #1e293b;
      min-width: 42px;
      text-align: right;
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
      background: #f8fafc;
      color: var(--ink);
      font-size: 12px;
      font-weight: 700;
      text-decoration: none;
      white-space: nowrap;
      line-height: 1;
      transition: all 0.2s ease;
    }

    .btn-detail:hover {
      background: #013220;
      color: #ffffff;
      border-color: #013220;
    }

    /* Live Preview Thumbnail */
    .preview-thumb-wrap {
      width: 56px;
      height: 40px;
      border-radius: 8px;
      overflow: hidden;
      border: 1px solid var(--line);
      background: #f1f5f9;
      cursor: pointer;
      display: block;
      position: relative;
      transition: box-shadow 0.2s ease, transform 0.2s ease;
    }

    .preview-thumb-wrap:hover {
      box-shadow: 0 4px 10px rgba(31, 53, 97, 0.15);
      transform: translateY(-1px);
    }

    .preview-thumb-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: top;
      display: block;
    }

    .preview-thumb-wrap i {
      position: absolute;
      bottom: 2px;
      right: 3px;
      font-size: 9px;
      color: #fff;
      background: rgba(0, 0, 0, 0.45);
      border-radius: 4px;
      padding: 1px 3px;
    }

    /* Preview Modal (Live Preview Besar) */
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
      max-width: 620px;
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

    .preview-modal-head h4 {
      margin: 0;
      font-size: 14px;
      font-weight: 800;
      color: var(--ink);
    }

    .preview-modal-head a {
      font-size: 11px;
      font-weight: 700;
      color: var(--green-vibrant);
    }

    .preview-modal-actions {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .preview-modal-close {
      background: none;
      border: none;
      font-size: 20px;
      line-height: 1;
      color: var(--muted);
      cursor: pointer;
    }

    .preview-modal-close:hover {
      color: var(--ink);
    }

    .preview-modal-body {
      background: #f1f5f9;
      min-height: 320px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .preview-modal-body img {
      width: 100%;
      display: block;
    }

    .preview-modal-loading {
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

    .preview-modal-loading i {
      font-size: 22px;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    .preview-modal-footer {
      padding: 10px 18px 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
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
      transition: all 0.2s ease;
    }

    .btn-page:hover:not(:disabled) {
      background: #013220;
      color: #ffffff;
      border-color: #013220;
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
      font-weight: 700;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .page-num:hover {
      background: #f8fafc;
      color: #013220;
    }

    .page-num.active {
      background: #013220;
      color: #fff;
      border-color: #013220;
    }

    .page-dots {
      color: var(--muted);
      font-size: 12px;
      padding: 0 4px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    @media (max-width: 1024px) {
      .metrics-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 768px) {
      main {
        margin-left: 0 !important;
        width: 100% !important;
        padding: 85px 16px 16px 16px;
      }
      .dashboard-header { flex-direction: column; align-items: flex-start; }
      .metrics-grid { grid-template-columns: repeat(2, 1fr); }
      .filter-grid { flex-direction: column; }
      .search-box, .filter-dropdown select { width: 100%; }
    }

    @media (max-width: 460px) {
      .metrics-grid { grid-template-columns: 1fr; }
    }

    .notif-toggle-wrap {
      display: flex;
      align-items: center;
      gap: 10px;
      background: #ffffff;
      border: 1px solid var(--line);
      padding: 9px 16px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }

    .notif-toggle-label {
      font-size: 12px;
      font-weight: 700;
      color: var(--ink);
      display: flex;
      align-items: center;
      gap: 6px;
      white-space: nowrap;
    }

    .switch {
      position: relative;
      display: inline-block;
      width: 40px;
      height: 22px;
      flex-shrink: 0;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0; left: 0; right: 0; bottom: 0;
      background-color: #cbd5e1;
      transition: 0.25s;
      border-radius: 34px;
    }

    .slider::before {
      position: absolute;
      content: "";
      height: 16px;
      width: 16px;
      left: 3px;
      bottom: 3px;
      background-color: white;
      transition: 0.25s;
      border-radius: 50%;
      box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    input:checked + .slider {
      background-color: #013220;
    }

    input:checked + .slider::before {
      transform: translateX(18px);
    }
  </style>
</head>

<body>

  @include('layouts.navigation')

  <main>
    <div class="container">

      <!-- HEADER & REFRESH ACTION -->
<div class="dashboard-header">
  <div>
    <h2>Dashboard Uptime Monitoring</h2>
    <p>Pantauan kondisi teknis dan ketersediaan website secara real-time.</p>
  </div>

  <div style="display:flex; align-items:center; gap:14px; flex-wrap:wrap;">
    <div class="notif-toggle-wrap">
      <span class="notif-toggle-label">
        <i class="bi bi-envelope-fill"></i> Notifikasi Email
      </span>
      <label class="switch">
        <input type="checkbox" id="email-notif-toggle"
          {{ auth()->user()->email_notifications_enabled ? 'checked' : '' }}>
        <span class="slider"></span>
      </label>
    </div>

    <a href="{{ route('dashboard.index') }}" class="btn-refresh">
      <i class="bi bi-arrow-clockwise"></i> Refresh Data
    </a>
  </div>
</div>

      <!-- METRICS CARDS -->
      <div class="metrics-grid">
        <div class="metric-card card-total">
          <div class="metric-header">
            <span>Total Monitored</span>
            <div class="metric-icon"><i class="bi bi-globe2"></i></div>
          </div>
          <h3 id="stat-total">{{ $stats['total'] }}</h3>
          <p>Total website terdaftar</p>
        </div>

        <div class="metric-card card-online">
          <div class="metric-header">
            <span>Online (Normal)</span>
            <div class="metric-icon"><i class="bi bi-check-circle-fill"></i></div>
          </div>
          <h3 style="color:#137a48" id="stat-online">{{ $stats['online'] }}</h3>
          <p>Website berjalan optimal</p>
        </div>

        <div class="metric-card card-warning">
          <div class="metric-header">
            <span>Warning (Slow)</span>
            <div class="metric-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
          </div>
          <h3 style="color:var(--amber)" id="stat-warning">{{ $stats['warning'] }}</h3>
          <p>Respons lambat (&gt; 3 detik)</p>
        </div>

        <div class="metric-card card-down">
          <div class="metric-header">
            <span>Down / Error</span>
            <div class="metric-icon"><i class="bi bi-x-circle-fill"></i></div>
          </div>
          <h3 style="color:var(--red)" id="stat-down">{{ $stats['down'] }}</h3>
          <p>Koneksi terputus / SSL error</p>
        </div>

        <div class="metric-card card-paused">
          <div class="metric-header">
            <span>Paused</span>
            <div class="metric-icon"><i class="bi bi-pause-circle-fill"></i></div>
          </div>
          <h3 style="color:#64748b" id="stat-paused">{{ $stats['paused'] }}</h3>
          <p>Monitoring website dijeda</p>
        </div>
      </div>

      <!-- FILTER & SEARCH BAR -->
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

        <!-- 1. TABEL DAFTAR STATUS WEBSITE WITH UPTIME BARS -->
        <div class="card">
          <div class="card-title">
            <span><i class="bi bi-globe me-2" style="color: #006B3F;"></i> Daftar Status Website</span>
            <span style="font-size:11px; color:var(--muted); font-weight:600;">Pengecekan otomatis berkala</span>
          </div>
          <div class="table-responsive">
            <table>
              <thead>
                <tr>
                  <th style="width: 8%;">Preview</th>
                  <th style="width: 20%;">Website / Domain</th>
                  <th style="width: 9%;">Status</th>
                  <th style="width: 21%;">Uptime History (30 Checks)</th>
                  <th style="width: 9%;">Latency</th>
                  <th style="width: 10%;">Masa SSL</th>
                  <th style="width: 9%;">Dicek Terakhir</th>
                  <th style="width: 8%; text-align: center;">Aksi</th>
                </tr>
              </thead>
              <tbody id="website-table-body">
                @forelse($websites as $web)
                  @php
                    $log = $web->latestLog;
                    $logsHistory = $web->monitoringLogs->reverse();
                    $totalLogs = $logsHistory->count();
                    $upLogs = $logsHistory->filter(fn ($l) => in_array($l->status, ['online', 'warning']))->count();
                    $uptimePct = $totalLogs > 0 ? round(($upLogs / $totalLogs) * 100, 1) : 100;
                  @endphp
                  <tr class="{{ $web->monitoring_status === 'paused' ? 'row-paused' : '' }}">
                    <td>
                      <span class="preview-thumb-wrap"
                            onclick="openPreviewModal('{{ addslashes($web->url) }}', '{{ addslashes($web->website_name) }}')"
                            title="Klik untuk lihat live preview">
                        <img src="https://api.microlink.io/?url={{ urlencode($web->url) }}&screenshot=true&meta=false&embed=screenshot.url"
                             loading="lazy" alt="Preview {{ $web->website_name }}">
                        <i class="bi bi-arrows-fullscreen"></i>
                      </span>
                    </td>
                    <td>
                      <strong style="color:#172033; display:block;">{{ $web->website_name }}</strong>
                      <small style="color:var(--muted); font-weight:600;">{{ $web->url }}</small>
                    </td>
                    <td>
                      @if($web->monitoring_status === 'paused')
                        <span class="badge badge-paused"><i class="bi bi-pause-circle"></i> PAUSED</span>
                      @elseif($log)
                        <span class="badge {{ $log->status === 'online' ? 'badge-online' : ($log->status === 'warning' ? 'badge-warning' : 'badge-down') }}">
                          <span class="status-dot {{ $log->status === 'online' ? 'pulse' : '' }}"></span> {{ strtoupper($log->status) }}
                        </span>
                      @else
                        <span class="badge badge-muted">Belum Dicek</span>
                      @endif
                    </td>
                    <td>
                      <div class="uptime-container">
                        <div class="uptime-bars">
                          @for($i = 0; $i < (30 - $logsHistory->count()); $i++)
                            <div class="uptime-bar bar-empty" title="Belum ada data"></div>
                          @endfor
                          @foreach($logsHistory as $hLog)
                            @php
                              $barClass = 'bar-online';
                              if ($hLog->status === 'warning') $barClass = 'bar-warning';
                              elseif (in_array($hLog->status, ['down', 'ssl_error'])) $barClass = 'bar-down';
                            @endphp
                            <div class="uptime-bar {{ $barClass }}"
                                 title="Dicek: {{ $hLog->checked_at->format('d/m/Y H:i:s') }}&#10;Status: {{ strtoupper($hLog->status) }} ({{ $hLog->response_time_ms ?? 0 }}ms)">
                            </div>
                          @endforeach
                        </div>
                        <span class="uptime-percentage">{{ $uptimePct }}%</span>
                      </div>
                    </td>
                    <td>
                      @if($web->monitoring_status !== 'paused' && $log && $log->response_time_ms)
                        <span style="color: {{ $log->response_time_ms > 3000 ? 'var(--amber)' : '#137a48' }}; font-weight:800;">
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
                        <span class="badge badge-ssl">Valid ({{ $log->ssl_days_left }} Hari)</span>
                      @elseif($log && $log->ssl_valid === false)
                        <span class="badge badge-down">SSL Expired</span>
                      @else
                        <span style="color:var(--muted);">-</span>
                      @endif
                    </td>
                    <td style="color:var(--muted); font-size:12px;">
                      {{ $web->monitoring_status === 'paused' ? 'Monitoring dijeda' : ($log ? $log->checked_at->diffForHumans() : '-') }}
                    </td>
                    <td style="text-align:center;">
                      <a href="{{ route('dashboard.show', $web->id) }}" class="btn-detail">
                        <i class="bi bi-eye"></i> Detail
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" style="text-align:center; padding: 24px; color:var(--muted);">Belum ada data website.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination Navigator -->
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

        <!-- 2. TABEL INSIDEN AKTIF -->
        @if($activeIncidents->count() > 0)
          <div class="card" style="border-color: rgba(220,38,38,0.25);">
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
                      if (str_contains($rawType, 'warning') || str_contains($rawType, 'slow')) {
                        $typeName = 'SLOW';
                        $badgeClass = 'badge-warning';
                      } elseif (str_contains($rawType, 'ssl')) {
                        $typeName = 'SSL WARNING';
                        $badgeClass = 'badge-ssl';
                      } else {
                        $typeName = 'DOWN';
                        $badgeClass = 'badge-down';
                      }

                      $jobStatus = strtolower(trim($incident->status));
                      if (str_contains($jobStatus, 'progress')) {
                        $jobStyle = 'background: #fef3c7; color: #d97706; border: 1px solid rgba(217, 119, 6, 0.2);';
                        $jobStatusText = 'ON PROGRESS';
                      } else {
                        $jobStyle = 'background: #fef2f2; color: var(--red); border: 1px solid rgba(220, 38, 38, 0.2);';
                        $jobStatusText = strtoupper($incident->status);
                      }
                    @endphp
                    <tr class="incident-row">
                      <td><strong style="color:#172033;">{{ $incident->website->website_name }}</strong></td>
                      <td><span class="badge {{ $badgeClass }}">{{ $typeName }}</span></td>
                      <td><span class="badge" style="{{ $jobStyle }}">{{ $jobStatusText }}</span></td>
                      <td>{{ $incident->assignedUser?->name ?? 'Belum Ditugaskan' }}</td>
                      <td style="color:var(--muted); font-size:12px;">
                        {{ $incident->started_at->locale('id')->diffForHumans() }}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <!-- Pagination Navigator Insiden -->
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

  <!-- MODAL LIVE PREVIEW WEBSITE -->
  <div id="previewModalOverlay" class="preview-modal-overlay">
    <div class="preview-modal-box">
      <div class="preview-modal-head">
        <div>
          <h4 id="previewModalTitle">Live Preview</h4>
          <a id="previewModalLink" href="#" target="_blank" rel="noopener">
            Buka website asli <i class="bi bi-box-arrow-up-right"></i>
          </a>
        </div>
        <div class="preview-modal-actions">
          <button type="button" class="preview-refresh-btn" onclick="refreshPreviewModal()">
            <i class="bi bi-arrow-clockwise"></i> Refresh
          </button>
          <button type="button" class="preview-modal-close" onclick="closePreviewModal()">&times;</button>
        </div>
      </div>
      <div class="preview-modal-body">
        <div id="previewModalLoading" class="preview-modal-loading">
          <i class="bi bi-arrow-repeat"></i>
          <span>Mengambil tampilan terbaru...</span>
        </div>
        <img id="previewModalImage" src="" alt="Live preview" style="display:none;">
      </div>
      <div class="preview-modal-footer">
        <small style="color:var(--muted); font-size:11px;">
          Preview diambil lewat API screenshot pihak ketiga (kuota gratis terbatas ±25-50x/hari), gunakan tombol Refresh secukupnya.
        </small>
      </div>
    </div>
  </div>

  <!-- JAVASCRIPT SYSTEM REAL-TIME & AJAX -->
  <script>
    document.getElementById('email-notif-toggle')?.addEventListener('change', function () {
  const isChecked = this.checked;

  fetch("{{ route('notifications.toggleEmail') }}", {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    },
    body: JSON.stringify({ enabled: isChecked }),
  })
    .then(res => res.json())
    .then(data => {
      if (data.status !== 'success') {
        alert('Gagal menyimpan preferensi notifikasi.');
        this.checked = !isChecked; // rollback kalau gagal
      }
    })
    .catch(() => {
      alert('Terjadi kesalahan jaringan.');
      this.checked = !isChecked;
    });
});

    document.addEventListener('DOMContentLoaded', () => {
      renderIncidentPagination();
    });

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

      if (currentPage > totalPages) currentPage = totalPages;

      if (totalItems === 0) {
        tbody.innerHTML = `<tr><td colspan="8" style="text-align:center; padding: 24px; color:var(--muted);">Tidak ada website yang sesuai pencarian/filter.</td></tr>`;
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
        const logsHistory = (web.monitoring_logs || web.monitoringLogs || []).slice().reverse();

        let statusBadge = '<span class="badge badge-muted">Belum Dicek</span>';
        let responseTime = '<span style="color:var(--muted);">-</span>';
        let sslBadge = '<span style="color:var(--muted);">-</span>';
        let checkedAt = '-';

        if (isPaused) {
          statusBadge = '<span class="badge badge-paused"><i class="bi bi-pause-circle"></i> PAUSED</span>';
          checkedAt = '<span style="color:var(--muted);">Monitoring dijeda</span>';
        } else if (log) {
          if (log.status === 'online') {
            statusBadge = '<span class="badge badge-online"><span class="status-dot pulse"></span> ONLINE</span>';
          } else if (log.status === 'warning') {
            statusBadge = '<span class="badge badge-warning"><span class="status-dot"></span> WARNING</span>';
          } else {
            statusBadge = '<span class="badge badge-down"><span class="status-dot"></span> DOWN</span>';
          }

          if (log.status !== 'down' && log.response_time_ms) {
            const latencyColor = log.response_time_ms > 3000 ? 'var(--amber)' : '#137a48';
            responseTime = `<span style="color:${latencyColor}; font-weight:800;">${Number(log.response_time_ms).toLocaleString()} ms</span>`;
          }

          if (log.ssl_valid) {
            sslBadge = `<span class="badge badge-ssl">Valid (${log.ssl_days_left} Hari)</span>`;
          } else if (log.ssl_valid === false) {
            sslBadge = `<span class="badge badge-down">SSL Expired</span>`;
          }

          checkedAt = timeAgo(log.checked_at);
        }

        // Render Uptime Bar Items
        let barsHtml = '';
        const maxBars = 30;
        const emptyBarsCount = maxBars - logsHistory.length;

        for (let i = 0; i < emptyBarsCount; i++) {
          barsHtml += `<div class="uptime-bar bar-empty" title="Belum ada data"></div>`;
        }

        logsHistory.forEach(hLog => {
          let barClass = 'bar-online';
          if (hLog.status === 'warning') barClass = 'bar-warning';
          else if (['down', 'ssl_error'].includes(hLog.status)) barClass = 'bar-down';

          const checkedLabel = formatCheckedAt(hLog.checked_at);
          barsHtml += `<div class="uptime-bar ${barClass}" title="Dicek: ${checkedLabel}&#10;Status: ${hLog.status.toUpperCase()} (${hLog.response_time_ms ?? 0}ms)"></div>`;
        });

        const uptimePct = web.uptime_percentage ?? 100;
        const detailUrl = baseUrl.replace(':id', web.id);
        const rowClass = isPaused ? 'row-paused' : '';

        const previewUrl = `https://api.microlink.io/?url=${encodeURIComponent(web.url)}&screenshot=true&meta=false&embed=screenshot.url`;
        const safeUrl = web.url.replace(/'/g, "\\'");
        const safeName = web.website_name.replace(/'/g, "\\'");

        html += `
          <tr class="${rowClass}">
            <td>
              <span class="preview-thumb-wrap" onclick="openPreviewModal('${safeUrl}', '${safeName}')" title="Klik untuk lihat live preview">
                <img src="${previewUrl}" loading="lazy" alt="Preview ${web.website_name}">
                <i class="bi bi-arrows-fullscreen"></i>
              </span>
            </td>
            <td>
              <strong style="color:#172033; display:block;">${web.website_name}</strong>
              <small style="color:var(--muted);">${web.url}</small>
            </td>
            <td>${statusBadge}</td>
            <td>
              <div class="uptime-container">
                <div class="uptime-bars">${barsHtml}</div>
                <span class="uptime-percentage">${uptimePct}%</span>
              </div>
            </td>
            <td>${responseTime}</td>
            <td>${sslBadge}</td>
            <td style="color:var(--muted); font-size:12px;">${checkedAt}</td>
            <td style="text-align:center;">
              <a href="${detailUrl}" class="btn-detail">
                <i class="bi bi-eye"></i> Detail
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

    function formatCheckedAt(dateString) {
      if (!dateString) return '-';
      const d = new Date(dateString);
      const pad = (n) => String(n).padStart(2, '0');
      return `${pad(d.getDate())}/${pad(d.getMonth() + 1)}/${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`;
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
    setInterval(fetchRealtimeData, 3000);

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

    // ===== LIVE PREVIEW MODAL =====
    let currentPreviewUrl = '';

    function buildPreviewUrl(targetUrl, bust = false) {
      const params = new URLSearchParams({
        url: targetUrl,
        screenshot: 'true',
        meta: 'false',
        embed: 'screenshot.url',
      });
      if (bust) params.set('refresh', Date.now());
      return `https://api.microlink.io/?${params.toString()}`;
    }

    function openPreviewModal(url, name) {
      currentPreviewUrl = url;

      document.getElementById('previewModalTitle').innerText = name || 'Live Preview';
      document.getElementById('previewModalLink').href = url;

      const img = document.getElementById('previewModalImage');
      const loading = document.getElementById('previewModalLoading');

      img.style.display = 'none';
      loading.style.display = 'flex';

      img.onload = () => {
        loading.style.display = 'none';
        img.style.display = 'block';
      };
      img.onerror = () => {
        loading.innerHTML = '<i class="bi bi-exclamation-triangle"></i><span>Gagal memuat preview website ini.</span>';
      };

      img.src = buildPreviewUrl(url);

      document.getElementById('previewModalOverlay').style.display = 'flex';
    }

    function refreshPreviewModal() {
      if (!currentPreviewUrl) return;

      const img = document.getElementById('previewModalImage');
      const loading = document.getElementById('previewModalLoading');

      img.style.display = 'none';
      loading.innerHTML = '<i class="bi bi-arrow-repeat"></i><span>Mengambil tampilan terbaru...</span>';
      loading.style.display = 'flex';

      img.src = buildPreviewUrl(currentPreviewUrl, true);
    }

    function closePreviewModal() {
      document.getElementById('previewModalOverlay').style.display = 'none';
    }

    document.getElementById('previewModalOverlay').addEventListener('click', (e) => {
      if (e.target.id === 'previewModalOverlay') closePreviewModal();
    });
  </script>
</body>

</html>