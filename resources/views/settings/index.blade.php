<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Settings - Website Monitoring IT Solution</title>
  <link rel="icon" type="image/png" href="{{ asset('img/logo.jpeg') }}">
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

    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: var(--ink);
      background: var(--bg);
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }
    a { color: inherit; text-decoration: none; }

    /* SIDEBAR STYLE */
    aside {
      position: fixed; top: 0; left: 0; height: 100vh;
      width: var(--sidebar-width); background: #013220;
      border-right: 1px solid #04472d; display: flex;
      flex-direction: column; z-index: 100; box-shadow: var(--shadow);
    }
    aside.collapsed { width: var(--sidebar-collapsed); }

    main { 
      margin-left: var(--sidebar-width); 
      flex: 1; 
      /* Disesuaikan: Atas 85px agar tidak tertutup navbar, Kiri-Kanan 12px agar melebar konsisten */
      padding: 85px 12px 16px 12px; 
      min-width: 0; 
      transition: margin-left 0.3s ease, width 0.3s ease;
      width: calc(100% - var(--sidebar-width));
    }
    aside#sidebar.collapsed ~ main { 
      margin-left: var(--sidebar-collapsed); 
      width: calc(100% - var(--sidebar-collapsed));
    }
    .container { max-width: none; margin: 0; width: 100%; }

    .page-header { margin-bottom: 24px; }
    .page-header h2 { font-size: 22px; margin: 0 0 4px; color: #172033; font-weight: 800; }
    .page-header p { margin: 0; color: var(--muted); font-size: 12px; font-weight: 600; }

    .card { background: var(--card); border: 1px solid var(--line); border-radius: 18px; padding: 24px; box-shadow: var(--shadow); margin-bottom: 20px; }
    .card-title { font-size: 15px; font-weight: 800; color: #172033; margin-bottom: 6px; }
    .card-desc { font-size: 12px; color: var(--muted); margin-bottom: 20px; word-break: break-word; font-weight: 600; }
    
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px; }
    .form-group small { display: block; color: var(--muted); font-size: 11px; margin-top: 4px; font-weight: 600; }
    .form-control { width: 100%; background: #fbfcfe; border: 1px solid var(--line); color: var(--ink); padding: 10px 14px; border-radius: 10px; font-size: 13px; font-weight: 600; outline: none; transition: border-color 0.2s ease, box-shadow 0.2s ease; }
    .form-control:focus { border-color: var(--green-vibrant); background: #ffffff; box-shadow: 0 0 0 3px rgba(0, 107, 63, 0.1); }
    .form-control:disabled { opacity: 0.5; cursor: not-allowed; background: #f1f5f9; }
    .error-text { color: var(--red); font-size: 12px; margin-top: 4px; font-weight: 600; }

    .slider-container { margin: 20px 0 30px; }
    .range-slider { width: 100%; accent-color: var(--green-vibrant); cursor: pointer; height: 6px; background: var(--line); border-radius: 3px; }
    .slider-marks { display: flex; justify-content: space-between; font-size: 12px; color: var(--muted); margin-top: 10px; padding: 0 4px; font-weight: 600; }
    .slider-marks span.active { color: var(--green-vibrant); font-weight: bold; }

    .grid-2col { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
    
    .coming-soon-badge { display: inline-block; background: var(--amber-soft); color: var(--amber); border: 1px solid rgba(217, 119, 6, 0.2); font-size: 10px; font-weight: 800; padding: 3px 10px; border-radius: 20px; margin-left: 8px; text-transform: uppercase; }
    .btn-primary { background: var(--green); color: #fff; border: none; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(1, 50, 32, 0.2); transition: opacity 0.2s ease; }
    .btn-primary:hover { opacity: 0.9; }

    @media (max-width: 768px) {
      main { 
        margin-left: 0 !important; 
        width: 100% !important; 
        padding: 85px 16px 16px 16px;
      }
      .grid-2col { 
        grid-template-columns: 1fr; 
      }
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
        <p style="color: #137a48; margin-bottom: 16px; font-size: 13px; font-weight: 700;">✓ {{ session('success') }}</p>
      @endif

      @php $isAdmin = Auth::user()->role === 'super_admin'; @endphp

      <form action="{{ route('settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- PENGATURAN MONITORING -->
        <div class="card">
          <div class="card-title" style="border-bottom: 1px solid var(--line); padding-bottom: 12px; margin-bottom: 16px;">Konfigurasi Monitoring</div>

          <!-- Monitor Interval -->
          <div>
            <div style="font-size: 13px; font-weight: 800; color: #172033; margin-bottom: 4px;">Default Monitor Interval</div>
            <div class="card-desc">
              Setiap website akan dicek setiap <b id="intervalLabel" style="color:#172033;">{{ $setting->default_interval_minutes }} menit</b> secara default.
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
          <div class="card-title" style="border-bottom: 1px solid var(--line); padding-bottom: 12px; margin-bottom: 16px;">
            Notifikasi & Alert WhatsApp
            <span class="coming-soon-badge">Belum Aktif</span>
          </div>
          <p style="font-size: 12px; color: var(--muted); margin-bottom: 16px; font-weight: 600;">
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
          <p style="color: var(--muted); font-size: 12px; text-align: right; font-weight: 600;">Hanya Super Admin yang dapat mengubah pengaturan ini.</p>
        @endif

      </form>

    </div>
  </main>

</body>
</html>