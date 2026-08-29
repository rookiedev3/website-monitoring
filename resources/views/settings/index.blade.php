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
      --line: #1b2a22;
      --green: #0f9f6e;
      --green-soft: rgba(15, 159, 110, 0.12);
      --red: #d94c4c;
      --amber: #d98b1d;
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

    /* STYLE SIDEBAR (Konsisten) */
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
    
    /* USER PROFILE & POPUP LOGOUT (Sesuai Standar Halaman Lain) */
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

    /* STYLE MAIN CONTENT */
    main { margin-left: var(--sidebar-width); flex: 1; padding: 30px; min-width: 0; }
    aside.collapsed ~ main { margin-left: var(--sidebar-collapsed); }
    .container { max-width: 900px; margin: 0 auto; }
    
    .page-header { margin-bottom: 24px; }
    .page-header h2 { font-size: 24px; margin: 0 0 4px; color: #fff; }
    .page-header p { margin: 0; color: var(--muted); font-size: 13px; }

    .card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 24px; box-shadow: var(--shadow); margin-bottom: 20px; }
    .card-title { font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 6px; }
    .card-desc { font-size: 12px; color: var(--muted); margin-bottom: 20px; }

    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 6px; }
    .form-control { width: 100%; background: var(--bg); border: 1px solid var(--line); color: var(--ink); padding: 10px 14px; border-radius: 10px; font-size: 13px; outline: none; }
    .form-control:focus { border-color: var(--green); }

    /* SLIDER & INTERVAL STYLE */
    .slider-container { margin: 20px 0 30px; }
    .range-slider { width: 100%; accent-color: var(--green); cursor: pointer; height: 6px; background: var(--line); border-radius: 3px; }
    .slider-marks { display: flex; justify-content: space-between; font-size: 12px; color: var(--muted); margin-top: 10px; padding: 0 4px; }
    .slider-marks span.active { color: var(--green); font-weight: bold; }

    /* LOCATION BOX */
    .location-box { display: flex; align-items: center; justify-content: space-between; background: var(--bg); border: 1px solid var(--line); padding: 12px 16px; border-radius: 12px; margin-top: 8px; }
    .location-left { display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 500; color: #fff; }
    .btn-add-loc { background: var(--green-soft); border: 1px solid rgba(15, 159, 110, 0.3); color: var(--green); padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; }
    .btn-add-loc:hover { background: rgba(15, 159, 110, 0.25); }

    /* ACCORDION / COLLAPSIBLE MENU */
    .accordion-item { display: flex; align-items: center; justify-content: space-between; padding: 16px 0; border-bottom: 1px solid var(--line); font-size: 13px; font-weight: 600; color: #fff; cursor: pointer; }
    .accordion-item:last-child { border-bottom: none; padding-bottom: 0; }
    .accordion-item:first-of-type { padding-top: 0; }
    .accordion-item:hover { color: var(--green); }

    .toggle-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid var(--line); font-size: 13px; }
    .toggle-row:last-child { border-bottom: none; }

    .btn-primary { background: var(--green); color: #fff; border: none; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; }
    .btn-primary:hover { opacity: 0.9; }
  </style>
</head>
<body>

  <!-- MEMANGGIL SIDEBAR -->
  @include('layouts.sidebar')

  <!-- MAIN CONTENT -->
  <main>
    <div class="container">
      
      <!-- PAGE HEADER -->
      <div class="page-header">
        <h2>System Settings</h2>
        <p>Kelola parameter interval monitoring, notifikasi WhatsApp, dan preferensi pelacakan server.</p>
      </div>

      <!-- FORM SETTINGS -->
      <form action="{{ route('settings.update') }}" method="POST">
        @csrf

        <!-- PENGATURAN MONITORING -->
        <div class="card">
          <div class="card-title" style="border-bottom: 1px solid var(--line); padding-bottom: 10px; margin-bottom: 16px;">Konfigurasi Umum & Monitoring</div>
          
          <div class="form-group">
            <label>Nama Aplikasi / Instance</label>
            <input type="text" name="app_name" class="form-control" value="IT Solution Monitoring System">
          </div>

          <div style="margin-top: 20px;">
            <div style="font-size: 13px; font-weight: 700; color: #fff; margin-bottom: 4px;">Monitor interval</div>
            <div class="card-desc">
              Your monitor will be checked every <b>5 minutes</b>.
            </div>

            <div class="slider-container">
              <input type="range" min="1" max="5" value="2" class="range-slider">
              <div class="slider-marks">
                <span>1m</span>
                <span class="active">5m</span>
                <span>15m</span>
                <span>30m</span>
                <span>1h</span>
              </div>
            </div>
          </div>

          <!-- Location to Monitor From -->
          <div style="margin-top: 28px;">
            <div style="font-size: 13px; font-weight: 700; color: #fff; margin-bottom: 4px;">Location to monitor from</div>
            <div class="location-box">
              <div class="location-left">
                <span>🌐</span> Default Server Node (Local Network)
              </div>
              <button type="button" class="btn-add-loc">+ Add location</button>
            </div>
          </div>

          <!-- SSL & Advanced Settings Accordion -->
          <div style="margin-top: 28px; border-top: 1px solid var(--line); padding-top: 20px;">
            <div class="accordion-item">
              <span>🔒 SSL certificate and Domain checks</span>
              <span>&rsaquo;</span>
            </div>
            <div class="accordion-item" style="margin-top: 12px;">
              <span>⚙️ Advanced settings</span>
              <span>&rsaquo;</span>
            </div>
          </div>
        </div>

        <!-- PENGATURAN NOTIFIKASI WHATSAPP & URL -->
        <div class="card">
          <div class="card-title" style="border-bottom: 1px solid var(--line); padding-bottom: 10px; margin-bottom: 16px;">Notifikasi & Alert WhatsApp</div>
          
          <div class="form-group">
            <label>Webhook / API Endpoint URL</label>
            <input type="url" name="webhook_url" class="form-control" placeholder="https://your-domain.com/api/v1/webhook" required>
          </div>

          <div class="form-group">
            <label>WhatsApp API Gateway URL / Endpoint</label>
            <input type="url" name="wa_endpoint" class="form-control" placeholder="https://api.whatsapp-gateway.id/send" required>
          </div>

          <div class="form-group">
            <label>WhatsApp API Token / Key</label>
            <input type="text" name="wa_token" class="form-control" placeholder="Bearer token_secret_xyz...">
          </div>

          <div class="form-group">
            <label>Nomor WhatsApp / Group ID Penerima Alert</label>
            <input type="text" name="wa_target" class="form-control" placeholder="6281234567890 atau ID Grup">
          </div>

          <div style="margin-top: 14px;">
            <div class="toggle-row">
              <span>Kirim WhatsApp saat Website DOWN</span>
              <input type="checkbox" checked style="accent-color: var(--green); width: 16px; height: 16px;">
            </div>
            <div class="toggle-row">
              <span>Kirim WhatsApp saat Website kembali ONLINE (Recovered)</span>
              <input type="checkbox" checked style="accent-color: var(--green); width: 16px; height: 16px;">
            </div>
          </div>
        </div>

        <!-- Tombol Simpan -->
        <div style="display: flex; justify-content: flex-end;">
          <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </div>

      </form>

    </div>
  </main>

</body>
</html>