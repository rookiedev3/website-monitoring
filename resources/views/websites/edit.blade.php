<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Website - Website Monitoring IT Solution</title>
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

    /* STYLE SIDEBAR */
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
       KODE RESPONSIF: STYLE MAIN CONTENT & PERGESERAN SIDEBAR
       ========================================================== */
    main { 
      margin-left: var(--sidebar-width); 
      flex: 1; 
      padding: 24px; 
      min-width: 0; 
      transition: margin-left 0.3s ease, width 0.3s ease;
      width: calc(100% - var(--sidebar-width));
    }
    
    /* Jika sidebar diperkecil (collapsed) di laptop */
    aside#sidebar.collapsed ~ main { 
      margin-left: var(--sidebar-collapsed); 
      width: calc(100% - var(--sidebar-collapsed));
    }

    .container { 
      max-width: 800px; 
      margin: 0 auto; 
      width: 100%;
    }
    
    .page-header { margin-bottom: 24px; }
    .page-header h2 { font-size: 24px; margin: 0 0 4px; color: #fff; }
    .page-header p { margin: 0; color: var(--muted); font-size: 13px; }

    /* Form Card Styling */
    .card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 24px; box-shadow: var(--shadow); }
    
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 8px; letter-spacing: .05em; }
    
    .form-control { width: 100%; background: var(--bg); border: 1px solid var(--line); color: var(--ink); padding: 12px 14px; border-radius: 10px; font-size: 13px; outline: none; transition: border-color 0.2s ease; }
    .form-control:focus { border-color: var(--green); }
    
    /* ==========================================================
       KODE RESPONSIF: FORM ROW 2 KOLOM
       ========================================================== */
    .form-row { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }

    .form-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px; border-top: 1px solid var(--line); padding-top: 20px; flex-wrap: wrap; }
    
    .btn-secondary { background: transparent; border: 1px solid var(--line); color: var(--muted); padding: 10px 18px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; }
    .btn-secondary:hover { color: #fff; background: var(--card-hover); }

    .btn-primary { background: var(--green); color: #fff; border: none; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
    .btn-primary:hover { opacity: 0.9; }

    /* ==========================================================
       KODE RESPONSIF: KHUSUS LAYAR HP & TABLET (Max-width: 768px)
       ========================================================== */
    @media (max-width: 768px) {
      main { 
        margin-left: 0 !important; 
        width: 100% !important; 
        padding: 14px;
        padding-top: 60px; /* Memberi ruang untuk navigasi toggle sidebar di layar kecil */
      }
      .form-row { 
        grid-template-columns: 1fr; /* Mengubah form 2 kolom sejajar menjadi 1 kolom bertumpuk ke bawah di HP */
      }
      .form-actions {
        flex-direction: column-reverse; /* Mengatur tombol aksi agar menumpuk rapi di layar HP */
        width: 100%;
      }
      .btn-primary, .btn-secondary {
        width: 100%;
        justify-content: center;
      }
    }
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
        <h2>Edit Website</h2>
        <p>Perbarui informasi atau konfigurasi pemantauan website customer.</p>
      </div>

      <!-- FORM CARD -->
      <div class="card">
        <form action="#" method="POST">
          @csrf
          @method('PUT')

          <div class="form-row">
            <div class="form-group">
              <label>Nama Customer / Perusahaan</label>
              <input type="text" class="form-control" value="PT Maju Jaya" required>
            </div>
            <div class="form-group">
              <label>Nama / Label Project</label>
              <input type="text" class="form-control" value="Client One Portal" required>
            </div>
          </div>

          <div class="form-group">
            <label>Domain / URL Website</label>
            <input type="url" class="form-control" value="https://client-one.com" required>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Kategori Website</label>
              <select class="form-control" required>
                <option value="ecommerce" selected>E-Commerce</option>
                <option value="company">Company Profile</option>
                <option value="portal">Portal Berita / Blog</option>
                <option value="webapp">Web Application</option>
              </select>
            </div>
            <div class="form-group">
              <label>Interval Pengecekan</label>
              <select class="form-control" required>
                <option value="5" selected>Setiap 5 Menit</option>
                <option value="10">Setiap 10 Menit</option>
                <option value="15">Setiap 15 Menit</option>
                <option value="30">Setiap 30 Menit</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Penanggung Jawab (PIC Internal)</label>
              <input type="text" class="form-control" value="Budi (DevOps)" required>
            </div>
            <div class="form-group">
              <label>Status Monitoring</label>
              <select class="form-control" required>
                <option value="active" selected>Active (Dipantau)</option>
                <option value="paused">Paused (Ditunda)</option>
              </select>
            </div>
          </div>

          <div class="form-actions">
            <a href="{{ route('websites.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">Perbarui Website</button>
          </div>

        </form>
      </div>

    </div>
  </main>

</body>
</html>