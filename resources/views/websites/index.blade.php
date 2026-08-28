<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Website Management - Website Monitoring IT Solution</title>
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
      --blue: #2563eb;
      --blue-soft: rgba(37, 99, 235, 0.12);
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
    .container { max-width: 1180px; margin: 0 auto; }
    
    /* Header & Actions Bar */
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px; }
    .page-header h2 { font-size: 24px; margin: 0 0 4px; color: #fff; }
    .page-header p { margin: 0; color: var(--muted); font-size: 13px; }
    
    .btn-primary { background: var(--green); color: #fff; border: none; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
    .btn-primary:hover { opacity: 0.9; }

    /* Filter & Search Bar */
    .filter-bar { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
    .search-input, .filter-select { background: var(--card); border: 1px solid var(--line); color: var(--ink); padding: 10px 14px; border-radius: 10px; font-size: 13px; outline: none; }
    .search-input { flex: 1; min-width: 200px; }
    .search-input::placeholder { color: var(--muted); }

    .btn-filter { background: #1b2a22; border: 1px solid var(--line); color: #fff; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; }
    .btn-filter:hover { background: var(--card-hover); }
    .btn-reset { background: transparent; border: 1px solid var(--line); color: var(--muted); padding: 10px 14px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; }
    .btn-reset:hover { color: #fff; background: var(--card-hover); }

    /* Table Card */
    .card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 20px; box-shadow: var(--shadow); }
    table { width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; }
    th { color: var(--muted); font-size: 11px; text-transform: uppercase; padding: 10px 12px; border-bottom: 1px solid var(--line); }
    td { padding: 14px 12px; border-bottom: 1px solid var(--line); color: var(--ink); vertical-align: middle; }
    tr:last-child td { border-bottom: none; }

    .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; }
    .badge.active { background: var(--green-soft); color: var(--green); }
    .badge.paused { background: var(--blue-soft); color: var(--blue); }

    .action-btns { display: flex; gap: 6px; }
    .btn-icon { background: var(--line); border: none; color: var(--ink); padding: 6px 10px; border-radius: 8px; font-size: 11px; font-weight: 600; cursor: pointer; }
    .btn-icon:hover { background: var(--card-hover); color: #fff; }
    .btn-icon.danger { color: var(--red); background: var(--red-soft); }
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
        <div>
          <h2>Website Management</h2>
          <p>Kelola daftar master website customer yang dipantau oleh sistem.</p>
        </div>
       <a href="{{ route('websites.create') }}" class="btn-primary">
  + Tambah Website Baru
</a>
      </div>

      <!-- FILTER, SEARCH, & BUTTON FILTER/RESET -->
      <div class="filter-bar">
        <input type="text" class="search-input" placeholder="Cari berdasarkan domain atau nama customer...">
        <select class="filter-select">
          <option value="">Semua Kategori</option>
          <option value="ecommerce">E-Commerce</option>
          <option value="company">Company Profile</option>
          <option value="portal">Portal Berita</option>
        </select>
        <select class="filter-select">
          <option value="">Status: Semua</option>
          <option value="active">Active</option>
          <option value="paused">Paused</option>
        </select>
        <button class="btn-filter">Filter</button>
        <button class="btn-reset">Reset</button>
      </div>

      <!-- TABEL WEBSITE MANAGEMENT -->
      <div class="card">
        <table>
          <thead>
            <tr>
              <th>Customer & Website</th>
              <th>Domain / URL</th>
              <th>Kategori</th>
              <th>Interval Check</th>
              <th>Status Monitoring</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <b>PT Maju Jaya</b><br>
                <small style="color:var(--muted)">Client One Portal</small>
              </td>
              <td><code>client-one.com</code></td>
              <td>E-Commerce</td>
              <td>5 Menit</td>
              <td><span class="badge active">● Active</span></td>
              <td>
                <div class="action-btns">
                  <button class="btn-icon">Check</button>
                  <button class="btn-icon">Edit</button>
                  <button class="btn-icon danger">Hapus</button>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <b>CV Berkah Abadi</b><br>
                <small style="color:var(--muted)">Store Front</small>
              </td>
              <td><code>portal-store.id</code></td>
              <td>Company Profile</td>
              <td>10 Menit</td>
              <td><span class="badge active">● Active</span></td>
              <td>
                <div class="action-btns">
                  <button class="btn-icon">Check</button>
                  <button class="btn-icon">Edit</button>
                  <button class="btn-icon danger">Hapus</button>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <b>Global Express</b><br>
                <small style="color:var(--muted)">Logistics Hub</small>
              </td>
              <td><code>logistics-hub.co</code></td>
              <td>Portal Berita</td>
              <td>5 Menit</td>
              <td><span class="badge paused">⏸ Paused</span></td>
              <td>
                <div class="action-btns">
                  <button class="btn-icon">Check</button>
                  <button class="btn-icon">Edit</button>
                  <button class="btn-icon danger">Hapus</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </main>

</body>
</html>