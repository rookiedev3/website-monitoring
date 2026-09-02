<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Incident - Website Monitoring IT Solution</title>
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

    .brand-area {
      padding: 20px 16px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 1px solid var(--line);
      overflow: hidden;
      white-space: nowrap;
    }

    .logo {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: linear-gradient(135deg, #17231d, #24372d);
      border: 1px solid var(--line);
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
      color: var(--muted);
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
      color: var(--muted);
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
      color: var(--muted);
      font-size: 13px;
      font-weight: 600;
      white-space: nowrap;
      cursor: pointer;
    }

    .nav-item:hover,
    .nav-item.active {
      background: var(--card-hover);
      color: #fff;
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
      padding: 24px;
      min-width: 0;
      transition: margin-left 0.3s ease, width 0.3s ease;
      width: calc(100% - var(--sidebar-width));
    }

    aside#sidebar.collapsed~main {
      margin-left: var(--sidebar-collapsed);
      width: calc(100% - var(--sidebar-collapsed));
    }

    .container {
      max-width: 1000px;
      margin: 0 auto;
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
      font-size: 24px;
      margin: 0 0 4px;
      color: #fff;
    }

    .page-header p {
      margin: 0;
      color: var(--muted);
      font-size: 13px;
    }

    .btn-secondary {
      background: transparent;
      border: 1px solid var(--line);
      color: var(--muted);
      padding: 8px 14px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      white-space: nowrap;
    }

    .btn-secondary:hover {
      color: #fff;
      background: var(--card-hover);
    }

    .card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 16px;
      padding: 20px;
      box-shadow: var(--shadow);
      overflow: hidden;
    }

    .card-title {
      font-size: 14px;
      font-weight: 700;
      color: #fff;
      margin-bottom: 16px;
      text-transform: uppercase;
      letter-spacing: .05em;
      border-bottom: 1px solid var(--line);
      padding-bottom: 10px;
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
    }

    .info-value {
      color: #fff;
      font-weight: 600;
      text-align: right;
    }

    .form-group {
      margin-bottom: 16px;
    }

    .form-group label {
      display: block;
      font-size: 12px;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      margin-bottom: 6px;
    }

    .form-control {
      width: 100%;
      background: var(--bg);
      border: 1px solid var(--line);
      color: var(--ink);
      padding: 10px 14px;
      border-radius: 10px;
      font-size: 13px;
      outline: none;
      transition: border-color 0.2s ease;
    }

    .form-control:focus {
      border-color: var(--green);
    }

    textarea.form-control {
      resize: vertical;
      min-height: 90px;
    }

    .btn-primary {
      background: var(--green);
      color: #fff;
      border: none;
      padding: 10px 18px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      width: 100%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: all 0.2s ease;
    }

    .btn-primary:hover {
      opacity: 0.9;
    }

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
      color: var(--green);
    }

    .timeline {
      display: flex;
      flex-direction: column;
      gap: 14px;
      margin-top: 10px;
    }

    .timeline-item {
      background: var(--bg);
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
      font-weight: 600;
      flex-wrap: wrap;
      gap: 6px;
    }

    .timeline-body {
      color: var(--ink);
    }

    /* ==========================================================
       STYLE MODAL KONFIRMASI KUSTOM & ANIMASI
       ========================================================== */
    .modal-backdrop {
      position: fixed;
      inset: 0;
      background: rgba(5, 10, 8, 0.75);
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
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
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
      border: 1px solid rgba(217, 139, 29, 0.3);
      color: var(--amber);
      display: grid;
      place-items: center;
      margin: 0 auto 16px;
      font-size: 28px;
      animation: pulse-amber 2s infinite ease-in-out;
    }

    @keyframes pulse-amber {
      0%, 100% { box-shadow: 0 0 0 0 rgba(217, 139, 29, 0.2); }
      50% { box-shadow: 0 0 0 10px rgba(217, 139, 29, 0); }
    }

    .modal-title {
      font-size: 18px;
      font-weight: 700;
      color: #fff;
      margin: 0 0 8px;
    }

    .modal-subtitle {
      font-size: 13px;
      color: var(--muted);
      margin: 0 0 24px;
      line-height: 1.5;
    }

    .modal-actions {
      display: flex;
      gap: 10px;
      justify-content: center;
    }

    .btn-cancel {
      flex: 1;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--line);
      color: var(--ink);
      padding: 10px 16px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .btn-cancel:hover {
      background: var(--card-hover);
      color: #fff;
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
      box-shadow: 0 4px 14px rgba(15, 159, 110, 0.35);
      transition: all 0.2s ease;
    }

    .btn-confirm:hover {
      opacity: 0.9;
      transform: translateY(-1px);
    }

    /* ==========================================================
       KODE RESPONSIF: KHUSUS LAYAR HP & TABLET (Max-width: 768px)
       ========================================================== */
    @media (max-width: 768px) {
      main {
        margin-left: 0 !important;
        width: 100% !important;
        padding: 14px;
        padding-top: 60px;
      }
    }

    .main-content,
    main {
      margin-top: var(--navbar-height, 60px);
    }
  </style>
</head>

<body>

  @include('layouts.sidebar')

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
        <p style="color: var(--green); margin-bottom: 16px; font-size: 13px;">{{ session('success') }}</p>
      @endif
      @if(session('error'))
        <p style="color: var(--red); margin-bottom: 16px; font-size: 13px;">{{ session('error') }}</p>
      @endif
      @if($errors->any())
        <p style="color: var(--red); margin-bottom: 16px; font-size: 13px;">{{ $errors->first() }}</p>
      @endif

      @php $user = Auth::user(); @endphp

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
            <span class="info-value">{{ $incident->started_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
              WIB</span>
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
              @if($incident->assignedUser)
                {{ $incident->assignedUser->name }}
              @elseif($incident->status === 'solved')
                Auto-resolved (sistem)
              @else
                Belum ditugaskan
              @endif
            </span>
          </div>
          <div class="info-item">
            <span class="info-label">Status Pekerjaan</span>
            <span class="info-value">
              <span
                class="badge {{ $incident->badge_class }}">{{ ucfirst(str_replace('_', ' ', $incident->status)) }}</span>
            </span>
          </div>
        </div>

        @if($incident->root_cause || $incident->resolution)
          <div style="margin-top: 14px; padding-top: 14px; border-top: 1px dashed var(--line);">
            <p
              style="font-size: 10px; font-weight: 800; letter-spacing: .05em; color: var(--amber); text-transform: uppercase; margin: 0 0 10px;">
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

      {{-- Update Penanganan — HANYA untuk programmer --}}
      @if($user->role === 'programmer')
        <div class="card" style="margin-bottom: 24px;">
          <div class="card-title">Update Penanganan</div>

          @if($incident->status === 'solved')
            <p style="font-size: 13px; color: var(--muted);">
              Root Cause & Resolution sudah dikirim dan ditampilkan di kolom "Hasil Investigasi" di atas.
            </p>
            <p style="font-size: 12px; color: var(--green); text-align: center; margin-top: 12px;">
              ✓ Incident sudah selesai {{ $incident->assignedUser ? ' ditangani oleh ' . $incident->assignedUser->name : ' Auto-resolved' }}.
            </p>

          @elseif($incident->status === 'open')
            <p style="font-size: 13px; color: var(--muted); margin-bottom: 12px;">
              Incident ini belum ditangani siapa pun.
            </p>
            <form action="{{ route('incidents.take', $incident->id) }}" method="POST">
              @csrf
              <button type="submit" class="btn-primary">Ambil Incident Ini</button>
            </form>

          @elseif($incident->assigned_to !== $user->id)
            <p style="font-size: 13px; color: var(--muted);">
              Incident ini sedang ditangani oleh <b style="color: #fff;">{{ $incident->assignedUser?->name ?? 'Pengguna lain' }}</b>.
            </p>

          @else
            <!-- Form Update Incident -->
            <form id="solve-incident-form" action="{{ route('incidents.update', $incident->id) }}" method="POST">
              @csrf
              @method('PATCH')

              <div class="form-group">
                <label>Akar Masalah</label>
                <textarea name="root_cause" class="form-control" placeholder="Contoh: Plugin conflict setelah update"
                  required>{{ old('root_cause') }}</textarea>
              </div>

              <div class="form-group">
                <label>Penyelesaian</label>
                <textarea name="resolution" class="form-control"
                  placeholder="Contoh: Rollback plugin dan update versi stabil"
                  required>{{ old('resolution') }}</textarea>
              </div>

              <div class="form-group">
                <label>Catatan</label>
                <textarea name="note" class="form-control"
                  placeholder="Contoh: Website kembali normal pukul 10:22">{{ old('note') }}</textarea>
              </div>

              <p style="font-size: 11px; color: var(--amber); margin-bottom: 12px;">
                ⚠ Data ini hanya bisa dikirim SEKALI. Setelah dikirim, incident langsung ditandai Solved.
              </p>

              <button type="button" class="btn-primary" onclick="openSolveModal()">
                <i class="bi bi-check-circle-fill"></i> Simpan & Selesaikan
              </button>
            </form>
          @endif
        </div>
      @endif

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
            <p style="color: var(--muted); font-size: 12px;">Belum ada catatan tambahan.</p>
          @endforelse
          <div class="timeline-item" style="border-style: dashed; opacity: 0.7;">
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

  <!-- MODAL KONFIRMASI SIMPAN & SELESAIKAN -->
  <div id="solve-modal" class="modal-backdrop" onclick="closeSolveModalOnBackdrop(event)">
    <div class="modal-card">
      <div class="modal-icon-wrapper">
        <i class="bi bi-exclamation-triangle-fill"></i>
      </div>
      <h3 class="modal-title">Konfirmasi Selesaikan Incident</h3>
      <p class="modal-subtitle">
        Setelah dikirim, data hasil investigasi tidak dapat diubah lagi dan status incident akan langsung ditandai sebagai <strong>Solved</strong>.<br><br>
        Apakah Anda yakin ingin menyelesaikan penanganan ini?
      </p>
      <div class="modal-actions">
        <button type="button" class="btn-cancel" onclick="closeSolveModal()">Batal</button>
        <button type="button" class="btn-confirm" onclick="submitSolveForm()">
          <i class="bi bi-check-lg"></i> Ya, Selesaikan
        </button>
      </div>
    </div>
  </div>

  <!-- JAVASCRIPT HANDLER UNTUK MODAL -->
  <script>
    function openSolveModal() {
      const form = document.getElementById('solve-incident-form');
      if (form) {
        // Melakukan validasi browser (required fields) sebelum membuka modal
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

    // Menutup modal dengan tombol ESC
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        closeSolveModal();
      }
    });
  </script>

</body>

</html>