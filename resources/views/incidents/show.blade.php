<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Incident - Website Monitoring IT Solution</title>
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

    /* STYLE SIDEBAR */
    aside {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: var(--sidebar-width);
      background: #013220;
      border-right: 1px solid #04472d;
      display: flex;
      flex-direction: column;
      z-index: 100;
      box-shadow: var(--shadow);
      transition: width 0.3s ease;
    }

    aside.collapsed {
      width: var(--sidebar-collapsed);
    }

    .brand-area {
      padding: 20px 16px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 1px solid #04472d;
      overflow: hidden;
      white-space: nowrap;
    }

    .logo {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: #ffffff;
      border: 1px solid #04472d;
      display: grid;
      place-items: center;
      font-weight: 900;
      color: var(--green);
      flex-shrink: 0;
    }

    .brand-text h1 {
      font-size: 14px;
      margin: 0;
      color: #fff;
      font-weight: 700;
    }

    .brand-text small {
      font-size: 11px;
      color: #8fa394;
    }

    .menu-list {
      flex: 1;
      padding: 16px 10px;
      overflow-y: auto;
      overflow-x: hidden;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .menu-title {
      font-size: 10px;
      font-weight: 800;
      letter-spacing: .1em;
      color: #8fa394;
      padding: 10px 10px 4px;
      text-transform: uppercase;
      white-space: nowrap;
    }

    aside.collapsed .menu-title {
      display: none;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 11px 12px;
      border-radius: 10px;
      color: #d1d5db;
      font-size: 13px;
      font-weight: 600;
      white-space: nowrap;
      cursor: pointer;
    }

    .nav-item:hover,
    .nav-item.active {
      background: #C7AB6B;
      color: #013220;
      font-weight: 700;
    }

    .nav-item svg {
      width: 20px;
      height: 20px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
      flex-shrink: 0;
    }

    aside.collapsed .nav-item span {
      display: none;
    }

    /* ==========================================================
       KODE RESPONSIF: MAIN CONTENT & PERGESERAN SIDEBAR
       ========================================================== */
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

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
      flex-wrap: wrap;
      gap: 14px;
    }

    .page-header h2 {
      font-size: 22px;
      margin: 0 0 4px;
      color: var(--ink);
      font-weight: 800;
    }

    .page-header p {
      margin: 0;
      color: var(--muted);
      font-size: 12px;
      font-weight: 600;
    }

    .btn-secondary {
      background: #f8fafc;
      border: 1px solid var(--line);
      color: var(--ink);
      padding: 10px 16px;
      border-radius: 10px;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      white-space: nowrap;
      transition: all 0.2s ease;
    }

    .btn-secondary:hover {
      background: var(--card-hover);
      color: var(--green);
      border-color: var(--muted);
    }

    .card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 18px;
      padding: 20px;
      box-shadow: var(--shadow);
      overflow: hidden;
    }

    .card-title {
      font-size: 13px;
      font-weight: 800;
      color: var(--ink);
      margin-bottom: 16px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      border-bottom: 1px solid var(--line);
      padding-bottom: 12px;
    }

    .info-list {
      display: flex;
      flex-direction: column;
      gap: 12px;
      font-size: 13px;
    }

    .info-item {
      display: flex;
      justify-content: space-between;
      gap: 12px;
      word-break: break-word;
    }

    .info-label {
      color: var(--muted);
      flex-shrink: 0;
      font-weight: 600;
    }

    .info-value {
      color: var(--ink);
      font-weight: 700;
      text-align: right;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 10px;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      margin-bottom: 8px;
      letter-spacing: 0.5px;
    }

    .form-control {
      width: 100%;
      background: #fbfcfe;
      border: 1px solid var(--line);
      color: var(--ink);
      padding: 10px 14px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 600;
      outline: none;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
      border-color: var(--green-vibrant);
      background: #ffffff;
      box-shadow: 0 0 0 3px rgba(0, 107, 63, 0.1);
    }

    .form-control::placeholder {
      color: var(--muted);
      font-weight: 500;
    }

    textarea.form-control {
      resize: vertical;
      min-height: 90px;
    }

    .btn-primary {
      background: var(--green);
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      width: 100%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 4px 12px rgba(1, 50, 32, 0.2);
      transition: opacity 0.2s ease;
    }

    .btn-primary:hover {
      opacity: 0.9;
    }

    /* ==========================================================
       STYLE MODAL KONFIRMASI KUSTOM & ANIMASI
       ========================================================== */
    .modal-backdrop {
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.6);
      backdrop-filter: blur(6px);
      -webkit-backdrop-filter: blur(6px);
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      padding: 16px;
    }

    .modal-backdrop.active {
      opacity: 1;
      pointer-events: auto;
    }

    .modal-card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 20px;
      padding: 28px 24px;
      max-width: 420px;
      width: 100%;
      text-align: center;
      box-shadow: 0 20px 40px rgba(31, 53, 97, 0.15);
      transform: scale(0.92) translateY(10px);
      transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .modal-backdrop.active .modal-card {
      transform: scale(1) translateY(0);
    }

    .modal-icon-wrapper {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      background: var(--amber-soft);
      border: 1px solid rgba(217, 119, 6, 0.25);
      color: var(--amber);
      display: grid;
      place-items: center;
      margin: 0 auto 16px;
      font-size: 28px;
      animation: pulse-amber 2s infinite ease-in-out;
    }

    @keyframes pulse-amber {
      0%, 100% { box-shadow: 0 0 0 0 rgba(217, 119, 6, 0.2); }
      50% { box-shadow: 0 0 0 10px rgba(217, 119, 6, 0); }
    }

    .modal-title {
      font-size: 18px;
      font-weight: 800;
      color: var(--ink);
      margin: 0 0 8px;
    }

    .modal-subtitle {
      font-size: 13px;
      color: var(--muted);
      margin: 0 0 24px;
      line-height: 1.5;
      font-weight: 500;
    }

    .modal-actions {
      display: flex;
      gap: 10px;
      justify-content: center;
    }

    .btn-cancel {
      flex: 1;
      background: #f8fafc;
      border: 1px solid var(--line);
      color: var(--ink);
      padding: 10px 16px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .btn-cancel:hover {
      background: var(--card-hover);
      color: var(--green);
      border-color: var(--muted);
    }

    .btn-confirm {
      flex: 1;
      background: var(--green);
      border: none;
      color: #fff;
      padding: 10px 16px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      box-shadow: 0 4px 12px rgba(1, 50, 32, 0.2);
      transition: all 0.2s ease;
    }

    .btn-confirm:hover {
      opacity: 0.9;
      transform: translateY(-1px);
    }

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

    .badge.open {
      background: var(--red-soft);
      color: var(--red);
    }

    .badge.progress {
      background: var(--amber-soft);
      color: var(--amber);
    }

    .badge.solved {
      background: var(--green-soft);
      color: #137a48;
    }

    .badge-log-online {
      background: var(--green-soft);
      color: #137a48;
    }

    .badge-log-warning {
      background: var(--amber-soft);
      color: var(--amber);
    }

    .badge-log-down {
      background: var(--red-soft);
      color: var(--red);
    }

    .text-error {
      color: var(--red);
      font-size: 12px;
      font-family: monospace;
      font-weight: 600;
    }

    .timeline {
      display: flex;
      flex-direction: column;
      gap: 14px;
      margin-top: 10px;
    }

    .timeline-item {
      background: #fbfcfe;
      border: 1px solid var(--line);
      padding: 12px 14px;
      border-radius: 10px;
      font-size: 12px;
      word-break: break-word;
    }

    .timeline-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 4px;
      color: var(--muted);
      font-weight: 700;
      flex-wrap: wrap;
      gap: 6px;
    }

    .timeline-body {
      color: var(--ink);
      font-weight: 500;
    }

    /* Tabel kustom */
    table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
      font-size: 13px;
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

    /* ==========================================================
       KODE RESPONSIF: KHUSUS LAYAR HP & TABLET (Max-width: 768px)
       ========================================================== */
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

  @include('layouts.navigation')

  <main>
    <div class="container">

      <div class="page-header">
        <div>
          <h2>Detail & Penanganan Incident</h2>
          <p>ID Gangguan: <b>#INC-{{ $incident->id }}</b></p>
        </div>
        <a href="{{ route('incidents.index') }}" class="btn-secondary">
          &larr; Kembali ke Daftar Error
        </a>
      </div>

      @if(session('success'))
        <p style="color: #137a48; margin-bottom: 16px; font-size: 13px; font-weight: 700;">{{ session('success') }}</p>
      @endif
      @if(session('error'))
        <p style="color: var(--red); margin-bottom: 16px; font-size: 13px; font-weight: 700;">{{ session('error') }}</p>
      @endif
      @if($errors->any())
        <p style="color: var(--red); margin-bottom: 16px; font-size: 13px; font-weight: 700;">{{ $errors->first() }}</p>
      @endif

      @php
        $user = Auth::user();
        $isMyIncident = $incident->assigned_to === $user->id;

        $reportDeadlineHours = 48;
        $reportDeadline = $incident->resolved_at
            ? $incident->resolved_at->copy()->addHours($reportDeadlineHours)
            : null;
        $isPastReportDeadline = $reportDeadline && now()->gt($reportDeadline);

        $resolvedByPic = $incident->status === 'solved'
            && $incident->root_cause
            && $incident->report_submitted_at
            && $reportDeadline
            && $incident->report_submitted_at->lte($reportDeadline);

        $lateReport = $incident->status === 'solved'
            && $incident->root_cause
            && ! $resolvedByPic;
      @endphp

      <!-- Informasi Gangguan -->
      <div class="card" style="margin-bottom: 20px;">
        <div class="card-title">Informasi Gangguan</div>
        <div class="info-list">
          <div class="info-item">
            <span class="info-label">Website / Domain</span>
            <span class="info-value">{{ $incident->website->domain }}</span>
          </div>
          <div class="info-item">
            <span class="info-label">Customer</span>
            <span class="info-value">{{ $incident->website->customer_name }}</span>
          </div>
          <div class="info-item">
            <span class="info-label">Jenis Error</span>
            <span class="info-value" style="color:var(--red)">{{ $incident->type_label }}</span>
          </div>
          <div class="info-item">
            <span class="info-label">HTTP Code</span>
            <span class="info-value">{{ $latestLog->http_code ?? 'N/A' }}</span>
          </div>
          <div class="info-item">
            <span class="info-label">Response Time</span>
            <span class="info-value">{{ $latestLog->response_time_ms ?? '-' }} ms</span>
          </div>
          <div class="info-item">
            <span class="info-label">Mulai Error</span>
            <span class="info-value">{{ $incident->started_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</span>
          </div>
          <div class="info-item">
            <span class="info-label">Durasi Gangguan</span>
            <span class="info-value">
              {{ $incident->formatted_duration }}
              @if($incident->status !== 'solved')
                (berjalan)
              @endif
            </span>
          </div>
          <div class="info-item">
            <span class="info-label">PIC</span>
            <span class="info-value">
              @if($resolvedByPic)
                {{ $incident->assignedUser->name }}
              @elseif($incident->assignedUser)
                {{ $incident->assignedUser->name }}
                @if($incident->status === 'solved' && $lateReport)
                  <br><small style="color: var(--muted); font-weight: 500;">(laporan post-mortem)</small>
                @elseif($incident->status === 'solved' && ! $incident->root_cause && $isPastReportDeadline)
                  <br><small style="color: var(--muted); font-weight: 500;">(auto-resolved, batas lapor {{ $reportDeadlineHours }} jam sudah lewat)</small>
                @elseif($incident->status === 'solved' && ! $incident->root_cause)
                  <br><small style="color: var(--amber); font-weight: 600;">(auto-resolved, PIC masih punya sisa waktu lapor)</small>
                @endif
              @elseif($incident->status === 'solved')
                Auto-resolved (sistem)
              @else
                Belum ditugaskan
              @endif
            </span>
          </div>
          @if($incident->status === 'solved' && ! $resolvedByPic)
            <div class="info-item">
              <span class="info-label">Diselesaikan Oleh</span>
              <span class="info-value" style="color: var(--muted);">Auto-resolved (sistem)</span>
            </div>
          @endif
          <div class="info-item">
            <span class="info-label">Status Pekerjaan</span>
            <span class="info-value">
              <span class="badge {{ $incident->badge_class }}">{{ ucfirst(str_replace('_', ' ', $incident->status)) }}</span>
            </span>
          </div>
        </div>

        @if($incident->root_cause || $incident->resolution)
          <div style="margin-top: 16px; padding-top: 16px; border-top: 1px dashed var(--line);">
            <p style="font-size: 10px; font-weight: 800; letter-spacing: 0.5px; color: var(--amber); text-transform: uppercase; margin: 0 0 10px;">
              Hasil Investigasi
            </p>
            @if($incident->root_cause)
              <div class="info-item">
                <span class="info-label">Root Cause</span>
                <span class="info-value">{{ $incident->root_cause }}</span>
              </div>
            @endif
            @if($incident->resolution)
              <div class="info-item" style="margin-top: 8px;">
                <span class="info-label">Resolution</span>
                <span class="info-value">{{ $incident->resolution }}</span>
              </div>
            @endif
          </div>
        @endif
      </div>

      @if($user->role === 'programmer')
        <div class="card" style="margin-bottom: 24px;">
          <div class="card-title">Update Penanganan</div>

          @if($resolvedByPic)
            <p style="font-size: 13px; color: var(--muted); font-weight: 500;">
              Root Cause, Penyelesaian, & Catatan sudah dikirim dan ditampilkan di kolom "Hasil Investigasi" di atas.
            </p>
            <p style="font-size: 12px; color: #137a48; text-align: center; margin-top: 12px; font-weight: 700;">
              ✓ Incident sudah selesai ditangani oleh {{ $incident->assignedUser->name }}.
            </p>

          @elseif($lateReport)
            <p style="font-size: 13px; color: var(--muted); font-weight: 500;">
              Root Cause, Penyelesaian, & Catatan sudah dikirim dan ditampilkan di kolom "Hasil Investigasi" di atas.
            </p>
            <p style="font-size: 12px; color: var(--muted); text-align: center; margin-top: 12px; font-weight: 500;">
              ✓ Website auto-resolved oleh sistem. Laporan dari {{ $incident->assignedUser->name }} dikirim setelah batas waktu {{ $reportDeadlineHours }} jam, jadi tercatat sebagai dokumentasi post-mortem — status penyelesaian tetap "Auto-resolved".
            </p>

          @elseif($incident->status === 'open')
            <p style="font-size: 13px; color: var(--muted); margin-bottom: 12px; font-weight: 500;">
              Incident ini belum ditangani siapa pun.
            </p>
            <form action="{{ route('incidents.take', $incident->id) }}" method="POST">
              @csrf
              <button type="submit" class="btn-primary">Ambil Incident Ini</button>
            </form>

          @elseif(! $isMyIncident)
            @if($incident->status === 'solved')
              <p style="font-size: 13px; color: var(--muted); font-weight: 500;">
                ✓ Website sudah auto-resolved oleh sistem.
              </p>
            @else
              <p style="font-size: 13px; color: var(--muted); font-weight: 500;">
                Incident ini sedang ditangani oleh <b style="color: var(--ink);">{{ $incident->assignedUser?->name ?? 'Pengguna lain' }}</b>.
              </p>
            @endif

          @elseif($incident->status !== 'solved')
            <p style="font-size: 13px; color: var(--muted); font-weight: 500;">
              Kamu jadi PIC incident ini. Silakan tangani dulu — form laporan (Root Cause, Penyelesaian, & Catatan) baru akan muncul di sini setelah sistem mengonfirmasi website kembali online (status berubah jadi <b style="color: var(--ink);">Solved</b>).
            </p>

          @elseif(! $incident->root_cause)
            @if($isPastReportDeadline)
              <p style="font-size: 12px; color: var(--muted); margin-bottom: 12px; font-weight: 500;">
                ✓ Website sudah auto-resolved oleh sistem. Batas waktu pelaporan {{ $reportDeadlineHours }} jam sudah lewat, jadi status tetap tercatat "Auto-resolved" — tapi kamu tetap bisa isi laporan di bawah ini sebagai dokumentasi (opsional, sifatnya post-mortem).
              </p>
            @else
              <p style="font-size: 12px; color: var(--amber); margin-bottom: 12px; font-weight: 600;">
                ⏳ Website sudah online kembali. Kamu punya waktu sampai <b>{{ $reportDeadline->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</b> ({{ $reportDeadlineHours }} jam sejak pulih) untuk isi laporan supaya tercatat sebagai kamu yang menyelesaikan. Lewat dari itu, status tetap tercantum "Auto-resolved".
              </p>
            @endif
            <form id="solve-incident-form" action="{{ route('incidents.update', $incident->id) }}" method="POST">
              @csrf
              @method('PATCH')

              <div class="form-group">
                <label>Akar Masalah</label>
                <textarea name="root_cause" class="form-control" placeholder="Contoh: Plugin conflict setelah update" required>{{ old('root_cause') }}</textarea>
              </div>

              <div class="form-group">
                <label>Penyelesaian</label>
                <textarea name="resolution" class="form-control" placeholder="Contoh: Rollback plugin dan update versi stabil" required>{{ old('resolution') }}</textarea>
              </div>

              <div class="form-group">
                <label>Catatan (opsional)</label>
                <textarea name="note" class="form-control" placeholder="Contoh: Sudah dikonfirmasi ulang jam 10:22, aman">{{ old('note') }}</textarea>
              </div>

              <p style="font-size: 11px; color: var(--amber); margin-bottom: 12px; font-weight: 700;">
                ⚠ Data ini hanya bisa dikirim SEKALI.
              </p>

              <button type="button" class="btn-primary" onclick="openSolveModal()">
                <i class="bi bi-check-circle-fill"></i> Kirim Laporan Penanganan
              </button>
            </form>
          @endif
        </div>
      @endif

      <!-- Riwayat Log Pengecekan -->
      <div class="card" style="margin-bottom: 20px;">
        <div class="card-title" style="display:flex; align-items:center; gap:8px;">
          <span>Riwayat Log Pengecekan</span>
          <span style="font-size: 10px; font-weight: 600; color: var(--muted); text-transform: none; letter-spacing: normal;">
            (mulai gangguan terjadi{{ $incident->resolved_at ? ' sampai pulih' : ' sampai sekarang' }})
          </span>
        </div>
        <div class="table-responsive" style="overflow-x:auto;">
          <table>
            <thead>
              <tr>
                <th style="width: 24%;">Waktu Cek</th>
                <th style="width: 18%;">Status</th>
                <th style="width: 14%;">HTTP Code</th>
                <th style="width: 16%;">Latency</th>
                <th style="width: 28%;">Detail Error</th>
              </tr>
            </thead>
            <tbody>
              @forelse($incidentLogs as $log)
                <tr>
                  <td style="color:var(--muted); font-size:12px;">
                    {{ $log->checked_at->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }} WIB
                  </td>
                  <td>
                    <span class="badge {{ $log->status === 'online' ? 'badge-log-online' : ($log->status === 'warning' ? 'badge-log-warning' : 'badge-log-down') }}">
                      ● {{ strtoupper($log->status_label ?? $log->status) }}
                    </span>
                  </td>
                  <td>
                    <strong style="color:var(--ink);">{{ $log->formatted_http_code ?? $log->http_code ?? '-' }}</strong>
                  </td>
                  <td>
                    @if($log->response_time_ms)
                      <span style="color: {{ $log->response_time_ms > 3000 ? 'var(--amber)' : '#137a48' }}; font-weight:700;">
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
                    Belum ada log pengecekan tercatat untuk periode insiden ini.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- Riwayat Catatan Penanganan -->
      <div class="card">
        <div class="card-title">Riwayat Catatan Penanganan</div>
        <div class="timeline">
          @forelse($incident->notes()->latest()->get() as $note)
            <div class="timeline-item">
              <div class="timeline-header">
                <span><b>{{ $note->user->name }}</b> ({{ ucfirst($note->user->role) }})</span>
                <span>{{ $note->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</span>
              </div>
              <div class="timeline-body">{{ $note->note }}</div>
            </div>
          @empty
            <p style="color: var(--muted); font-size: 12px; font-weight: 500;">Belum ada catatan tambahan.</p>
          @endforelse
          <div class="timeline-item" style="border-style: dashed; opacity: 0.8;">
            <div class="timeline-header">
              <span>Sistem Monitoring</span>
              <span>{{ $incident->started_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</span>
            </div>
            <div class="timeline-body">
              Incident otomatis dibuat oleh sistem.
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>

  @if($user->role === 'programmer' && $isMyIncident && $incident->status === 'solved' && ! $incident->root_cause && ! $isPastReportDeadline)
    @php
      $modalSubtitle = 'Setelah dikirim, laporan ini tidak dapat diubah lagi. Karena masih dalam ' . $reportDeadlineHours . ' jam sejak website pulih, incident ini akan tercatat sebagai "diselesaikan oleh kamu".';
    @endphp
  @elseif($user->role === 'programmer' && $isMyIncident && $incident->status === 'solved' && ! $incident->root_cause && $isPastReportDeadline)
    @php
      $modalSubtitle = 'Batas waktu pelaporan (' . $reportDeadlineHours . ' jam sejak website pulih) sudah lewat. Laporan ini akan tetap tersimpan sebagai dokumentasi post-mortem, namun status penyelesaian akan tetap tercantum "Auto-resolved (sistem)". Setelah dikirim, laporan tidak dapat diubah lagi.';
    @endphp
  @endif

  @if($user->role === 'programmer' && $isMyIncident && $incident->status === 'solved' && ! $incident->root_cause)
    <div id="solve-modal" class="modal-backdrop" onclick="closeSolveModalOnBackdrop(event)">
      <div class="modal-card">
        <div class="modal-icon-wrapper">
          <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <h3 class="modal-title">Konfirmasi Kirim Laporan</h3>
        <p class="modal-subtitle">
          {{ $modalSubtitle }}<br><br>
          Apakah Anda yakin ingin mengirim laporan ini?
        </p>
        <div class="modal-actions">
          <button type="button" class="btn-cancel" onclick="closeSolveModal()">Batal</button>
          <button type="button" class="btn-confirm" onclick="submitSolveForm()">
            <i class="bi bi-check-lg"></i> Ya, Kirim
          </button>
        </div>
      </div>
    </div>

    <script>
      function openSolveModal() {
        const form = document.getElementById('solve-incident-form');
        if (form) {
          if (!form.reportValidity()) {
            return;
          }
        }
        const modal = document.getElementById('solve-modal');
        if (modal) {
          modal.classList.add('active');
        }
      }

      function closeSolveModal() {
        const modal = document.getElementById('solve-modal');
        if (modal) {
          modal.classList.remove('active');
        }
      }

      function closeSolveModalOnBackdrop(event) {
        if (event.target.id === 'solve-modal') {
          closeSolveModal();
        }
      }

      function submitSolveForm() {
        const form = document.getElementById('solve-incident-form');
        if (form) {
          form.submit();
        }
      }

      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
          closeSolveModal();
        }
      });
    </script>
  @endif

</body>

</html>