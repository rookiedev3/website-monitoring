<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Settings - Website Monitoring IT Solution</title>
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
      --amber: #d98b1d;
      --shadow: 0 10px 30px rgba(0,0,0,.3);
      --sidebar-width: 215px;
      --sidebar-collapsed: 62px;
    }
    * { box-sizing: border-box; }
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
    aside#sidebar.collapsed ~ main { 
      margin-left: var(--sidebar-collapsed); 
      width: calc(100% - var(--sidebar-collapsed));
    }
    .container { max-width: 900px; margin: 0 auto; width: 100%; }

    .page-header { margin-bottom: 24px; }
    .page-header h2 { font-size: 24px; margin: 0 0 4px; color: #fff; }
    .page-header p { margin: 0; color: var(--muted); font-size: 13px; }

    .card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 24px; box-shadow: var(--shadow); margin-bottom: 20px; }
    .card-title { font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 6px; }
    .card-desc { font-size: 12px; color: var(--muted); margin-bottom: 20px; word-break: break-word; }
    
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 6px; }
    .form-group small { display: block; color: var(--muted); font-size: 11px; margin-top: 4px; }
    .form-control { width: 100%; background: var(--bg); border: 1px solid var(--line); color: var(--ink); padding: 10px 14px; border-radius: 10px; font-size: 13px; outline: none; transition: border-color 0.2s ease; }
    .form-control:focus { border-color: var(--green); }
    .form-control:disabled { opacity: 0.5; cursor: not-allowed; }
    .error-text { color: var(--red); font-size: 12px; margin-top: 4px; }

    .slider-container { margin: 20px 0 30px; }
    .range-slider { width: 100%; accent-color: var(--green); cursor: pointer; height: 6px; background: var(--line); border-radius: 3px; }
    .slider-marks { display: flex; justify-content: space-between; font-size: 12px; color: var(--muted); margin-top: 10px; padding: 0 4px; }
    .slider-marks span.active { color: var(--green); font-weight: bold; }

    /* ==========================================================
       KODE RESPONSIF: GRID 2 KOLOM
       ========================================================== */
    .grid-2col { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
    
    .coming-soon-badge { display: inline-block; background: var(--amber); color: #1a1006; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 99px; margin-left: 8px; text-transform: uppercase; }
    .btn-primary { background: var(--green); color: #fff; border: none; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; }
    .btn-primary:hover { opacity: 0.9; }

    /* ==========================================================
       KODE RESPONSIF: KHUSUS LAYAR HP & TABLET (Max-width: 768px)
       ========================================================== */
    @media (max-width: 768px) {
      main { 
        margin-left: 0 !important; 
        width: 100% !important; 
        padding: 14px;
        padding-top: 60px; /* Ruang untuk tombol navigasi toggle sidebar */
      }
      .grid-2col { 
        grid-template-columns: 1fr; /* Mengubah form 2 kolom sejajar menjadi 1 kolom bertumpuk ke bawah di HP */
      }
    }

    .main-content,
    main {
      margin-top: var(--navbar-height, 60px);
    }
  </style>
</head>
<body>

  @include('layouts.navigation')

  <main>
    <div class="container">

      <div class="page-header">
        <h2>System Settings</h2>
        <p>Kelola parameter default monitoring: interval pengecekan, timeout, threshold, dan peringatan SSL.</p>
      </div>

      @if(session('success'))
        <p style="color: var(--green); margin-bottom: 16px; font-size: 13px;">{{ session('success') }}</p>
      @endif

      @php $isAdmin = Auth::user()->role === 'super_admin'; @endphp

      <form action="{{ route('settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- PENGATURAN MONITORING -->
        <div class="card">
          <div class="card-title" style="border-bottom: 1px solid var(--line); padding-bottom: 10px; margin-bottom: 16px;">Konfigurasi Monitoring</div>

          <!-- Monitor Interval -->
          <div>
            <div style="font-size: 13px; font-weight: 700; color: #fff; margin-bottom: 4px;">Default Monitor Interval</div>
            <div class="card-desc">
              Setiap website akan dicek setiap <b id="intervalLabel">{{ $setting->default_interval_minutes }} menit</b> secara default.
            </div>

            <div class="slider-container">
              <input
                type="range"
                name="default_interval_minutes"
                min="1" max="60" step="1"
                value="{{ old('default_interval_minutes', $setting->default_interval_minutes) }}"
                class="range-slider"
                oninput="document.getElementById('intervalLabel').innerText = this.value + ' menit'"
                @unless($isAdmin) disabled @endunless
              >
              <div class="slider-marks">
                <span>1m</span>
                <span>15m</span>
                <span>30m</span>
                <span>45m</span>
                <span>60m</span>
              </div>
            </div>
            @error('default_interval_minutes') <span class="error-text">{{ $message }}</span> @enderror
          </div>

          <!-- Field lain dari tabel monitoring_settings -->
          <div class="grid-2col" style="margin-top: 24px;">
            <div class="form-group">
              <label>Timeout (detik)</label>
              <input
                type="number"
                name="timeout_seconds"
                value="{{ old('timeout_seconds', $setting->timeout_seconds) }}"
                class="form-control"
                min="1" max="120"
                @unless($isAdmin) disabled @endunless
                required
              >
              <small>Batas waktu tunggu sebelum request dianggap gagal.</small>
              @error('timeout_seconds') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label>Slow Threshold (ms)</label>
              <input
                type="number"
                name="slow_threshold_ms"
                value="{{ old('slow_threshold_ms', $setting->slow_threshold_ms) }}"
                class="form-control"
                min="100" max="60000"
                @unless($isAdmin) disabled @endunless
                required
              >
              <small>Response time di atas ini dianggap "warning".</small>
              @error('slow_threshold_ms') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label>Max Parallel Jobs</label>
              <input
                type="number"
                name="max_parallel_jobs"
                value="{{ old('max_parallel_jobs', $setting->max_parallel_jobs) }}"
                class="form-control"
                min="1" max="50"
                @unless($isAdmin) disabled @endunless
                required
              >
              <small>Jumlah pengecekan paralel maksimal.</small>
              @error('max_parallel_jobs') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label>SSL Warning (hari)</label>
              <input
                type="number"
                name="ssl_warning_days"
                value="{{ old('ssl_warning_days', $setting->ssl_warning_days) }}"
                class="form-control"
                min="1" max="90"
                @unless($isAdmin) disabled @endunless
                required
              >
              <small>Peringatan jika SSL akan expired dalam sekian hari.</small>
              @error('ssl_warning_days') <span class="error-text">{{ $message }}</span> @enderror
            </div>
          </div>
        </div>

        <!-- NOTIFIKASI WHATSAPP -->
        <div class="card">
          <div class="card-title" style="border-bottom: 1px solid var(--line); padding-bottom: 10px; margin-bottom: 16px;">
            Notifikasi & Alert WhatsApp
            <span class="coming-soon-badge">Belum Aktif</span>
          </div>
          <p style="font-size: 12px; color: var(--muted); margin-bottom: 16px;">
            Fitur ini masih dalam tahap desain — tabel penyimpanan untuk pengaturan WhatsApp belum tersedia di database, jadi input di bawah belum bisa disimpan.
          </p>

          <div class="form-group">
            <label>WhatsApp API Gateway URL</label>
            <input type="url" class="form-control" placeholder="https://api.whatsapp-gateway.id/send" disabled>
          </div>
          <div class="form-group">
            <label>Nomor WhatsApp / Group ID Penerima Alert</label>
            <input type="text" class="form-control" placeholder="6281234567890 atau ID Grup" disabled>
          </div>
        </div>

        @if($isAdmin)
          <div style="display: flex; justify-content: flex-end;">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
          </div>
        @else
          <p style="color: var(--muted); font-size: 12px; text-align: right;">Hanya Super Admin yang dapat mengubah pengaturan ini.</p>
        @endif

      </form>

    </div>
  </main>

</body>
</html>