<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Incident - Website Monitoring IT Solution</title>
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
      --shadow: 0 10px 30px rgba(0,0,0,.3);
      --sidebar-width: 260px;
      --sidebar-collapsed: 76px;
    }
    * { box-sizing: border-box; transition: width 0.3s ease, padding 0.3s ease; }
    body {
      margin: 0;
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif;
      color: var(--ink);
      background: var(--bg);
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }
    a { color: inherit; text-decoration: none; }
    aside {
      position: fixed; top: 0; left: 0; height: 100vh;
      width: var(--sidebar-width); background: var(--card);
      border-right: 1px solid var(--line); display: flex;
      flex-direction: column; z-index: 100; box-shadow: var(--shadow);
    }
    aside.collapsed { width: var(--sidebar-collapsed); }
    .brand-area { padding: 20px 16px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid var(--line); overflow: hidden; white-space: nowrap; }
    .logo { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #17231d, #24372d); border: 1px solid var(--line); display: grid; place-items: center; font-weight: 900; color: var(--green); flex-shrink: 0; }
    .brand-text h1 { font-size: 14px; margin: 0; color: #fff; font-weight: 700; }
    .brand-text small { font-size: 11px; color: var(--muted); }
    .menu-list { flex: 1; padding: 16px 10px; overflow-y: auto; overflow-x: hidden; display: flex; flex-direction: column; gap: 4px; }
    .menu-title { font-size: 10px; font-weight: 800; letter-spacing: .1em; color: var(--muted); padding: 10px 10px 4px; text-transform: uppercase; white-space: nowrap; }
    aside.collapsed .menu-title { display: none; }
    .nav-item { display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 10px; color: var(--muted); font-size: 13px; font-weight: 600; white-space: nowrap; cursor: pointer; }
    .nav-item:hover, .nav-item.active { background: var(--card-hover); color: #fff; }
    .nav-item svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }
    aside.collapsed .nav-item span { display: none; }
    .user-profile-container { position: relative; border-top: 1px solid var(--line); padding: 12px; }
    .user-profile-btn { width: 100%; background: transparent; border: none; display: flex; align-items: center; gap: 10px; padding: 8px; border-radius: 10px; cursor: pointer; color: var(--ink); text-align: left; white-space: nowrap; overflow: hidden; }
    .user-profile-btn:hover { background: var(--card-hover); }
    .user-avatar { width: 34px; height: 34px; border-radius: 50%; background: #24372d; color: #fff; display: grid; place-items: center; font-weight: 700; font-size: 12px; flex-shrink: 0; }
    .user-info { flex: 1; overflow: hidden; }
    .user-info h4 { font-size: 12px; margin: 0; color: #fff; text-overflow: ellipsis; overflow: hidden; }
    .user-info p { font-size: 10px; margin: 0; color: var(--muted); text-overflow: ellipsis; overflow: hidden; }
    aside.collapsed .user-info { display: none; }
    .user-popup-menu { position: absolute; bottom: 70px; left: 12px; right: 12px; background: #16241d; border: 1px solid var(--line); border-radius: 12px; box-shadow: var(--shadow); display: none; flex-direction: column; overflow: hidden; z-index: 10; }
    .user-popup-menu.show { display: flex; }
    .popup-item { padding: 10px 14px; font-size: 12px; color: var(--ink); display: flex; align-items: center; gap: 8px; background: transparent; border: none; cursor: pointer; text-align: left; width: 100%; }
    .popup-item:hover { background: #1f3328; color: #fff; }
    .popup-item.danger { color: var(--red); }
    .sidebar-toggle-bar { border-top: 1px solid var(--line); padding: 10px 14px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; background: rgba(0,0,0,0.1); font-size: 11px; color: var(--muted); }
    .sidebar-toggle-bar:hover { background: var(--card-hover); color: #fff; }
    aside.collapsed .sidebar-toggle-text { display: none; }
    aside.collapsed .sidebar-toggle-bar { justify-content: center; }
    main { margin-left: var(--sidebar-width); flex: 1; padding: 30px; min-width: 0; }
    aside.collapsed ~ main { margin-left: var(--sidebar-collapsed); }
    .container { max-width: 1000px; margin: 0 auto; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px; }
    .page-header h2 { font-size: 24px; margin: 0 0 4px; color: #fff; }
    .page-header p { margin: 0; color: var(--muted); font-size: 13px; }
    .btn-secondary { background: transparent; border: 1px solid var(--line); color: var(--muted); padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
    .btn-secondary:hover { color: #fff; background: var(--card-hover); }
    .grid-2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; margin-bottom: 24px; }
    .card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 20px; box-shadow: var(--shadow); }
    .card-title { font-size: 14px; font-weight: 700; color: #fff; margin-bottom: 16px; text-transform: uppercase; letter-spacing: .05em; border-bottom: 1px solid var(--line); padding-bottom: 10px; }
    .info-list { display: flex; flex-direction: column; gap: 12px; font-size: 13px; }
    .info-item { display: flex; justify-content: space-between; gap: 12px; }
    .info-label { color: var(--muted); flex-shrink: 0; }
    .info-value { color: #fff; font-weight: 600; text-align: right; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 6px; }
    .form-control { width: 100%; background: var(--bg); border: 1px solid var(--line); color: var(--ink); padding: 10px 14px; border-radius: 10px; font-size: 13px; outline: none; }
    .form-control:focus { border-color: var(--green); }
    textarea.form-control { resize: vertical; min-height: 90px; }
    .btn-primary { background: var(--green); color: #fff; border: none; padding: 10px 18px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; width: 100%; }
    .btn-primary:hover { opacity: 0.9; }
    .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; }
    .badge.open { background: var(--red-soft); color: var(--red); }
    .badge.progress { background: var(--amber-soft); color: var(--amber); }
    .badge.solved { background: var(--green-soft); color: var(--green); }
    .timeline { display: flex; flex-direction: column; gap: 14px; margin-top: 10px; }
    .timeline-item { background: var(--bg); border: 1px solid var(--line); padding: 12px 14px; border-radius: 10px; font-size: 12px; }
    .timeline-header { display: flex; justify-content: space-between; margin-bottom: 4px; color: var(--muted); font-weight: 600; }
    .timeline-body { color: var(--ink); }
    @media (max-width: 768px) {
      .grid-2 { grid-template-columns: 1fr; }
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

      <div class="grid-2" @if($user->role !== 'programmer') style="grid-template-columns: 1fr; max-width: 520px;" @endif>

        <!-- Kolom 1: Informasi Gangguan (semua role lihat, read-only) -->
        <div class="card">
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
              <span class="info-value">{{ $latestLog->http_code ?? '-' }}</span>
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
                @if($incident->status === 'solved')
                  {{ gmdate('H \j\a\m i \m\e\n\i\t', $incident->duration_seconds) }}
                @else
                  {{ gmdate('H \j\a\m i \m\e\n\i\t', now()->diffInSeconds($incident->started_at)) }} (berjalan)
                @endif
              </span>
            </div>
            <div class="info-item">
              <span class="info-label">PIC</span>
              <span class="info-value">{{ $incident->assignedUser->name ?? 'Belum ditugaskan' }}</span>
            </div>
            <div class="info-item">
              <span class="info-label">Status Pekerjaan</span>
              <span class="info-value">
                <span class="badge {{ $incident->badge_class }}">{{ ucfirst(str_replace('_', ' ', $incident->status)) }}</span>
              </span>
            </div>
          </div>

          @if($incident->root_cause || $incident->resolution)
          <div style="margin-top: 8px; padding-top: 14px; border-top: 1px dashed var(--line);">
            <p style="font-size: 10px; font-weight: 800; letter-spacing: .05em; color: var(--amber); text-transform: uppercase; margin: 0 0 10px;">
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

        {{-- Kolom 2: Update Penanganan — HANYA untuk programmer --}}
        @if($user->role === 'programmer')
        <div class="card">
          <div class="card-title">Update Penanganan</div>

          @if($incident->status === 'open')
            <p style="font-size: 13px; color: var(--muted); margin-bottom: 12px;">
              Incident ini belum ditangani siapa pun.
            </p>
            <form action="{{ route('incidents.take', $incident->id) }}" method="POST">
              @csrf
              <button type="submit" class="btn-primary">Ambil Incident Ini</button>
            </form>

          @elseif($incident->assigned_to !== $user->id)
            <p style="font-size: 13px; color: var(--muted);">
              Incident ini sedang ditangani oleh <b style="color: #fff;">{{ $incident->assignedUser->name }}</b>.
            </p>

          @elseif($incident->status === 'solved')
            {{-- TERKUNCI TOTAL: sudah selesai, tidak ada input/tombol apapun --}}
            <p style="font-size: 13px; color: var(--muted);">
              Root Cause & Resolution sudah dikirim dan ditampilkan di kolom "Hasil Investigasi" sebelah kiri.
            </p>
            <p style="font-size: 12px; color: var(--green); text-align: center; margin-top: 12px;">✓ Incident sudah selesai ditangani.</p>

          @else
            {{-- SATU-SATUNYA form aktif: Root Cause + Resolution + Catatan, SATU tombol --}}
            <form
              action="{{ route('incidents.update', $incident->id) }}"
              method="POST"
              onsubmit="return confirm('Setelah dikirim, data ini tidak bisa diubah lagi dan incident akan ditandai Solved. Lanjutkan?');"
            >
              @csrf
              @method('PATCH')

              <div class="form-group">
                <label>Akar Masalah</label>
                <textarea name="root_cause" class="form-control" placeholder="Contoh: Plugin conflict setelah update" required>{{ old('root_cause') }}</textarea>
              </div>

              <div class="form-group">
                <label>Penyelesaian</label>
                <textarea name="resolution" class="form-control" placeholder="Contoh: Rollback plugin dan update versi stabil">{{ old('resolution') }}</textarea>
              </div>

              <div class="form-group">
                <label>Catatan</label>
                <textarea name="note" class="form-control" placeholder="Contoh: Website kembali normal pukul 10:22">{{ old('note') }}</textarea>
              </div>

              <p style="font-size: 11px; color: var(--amber); margin-bottom: 12px;">
                ⚠ Data ini hanya bisa dikirim SEKALI. Setelah dikirim, incident langsung ditandai Solved.
              </p>

              <button type="submit" class="btn-primary">Simpan & Selesaikan</button>
            </form>
          @endif
        </div>
        @endif

      </div>

      <!-- Riwayat Catatan Penanganan — read-only untuk SEMUA role, tanpa form input -->
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

</body>
</html>