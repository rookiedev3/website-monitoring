<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen User - Website Monitoring IT Solution</title>

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
    
    /* USER PROFILE & POPUP MENU (Sesuai Standar Halaman Lain) */
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
    
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px; }
    .page-header h2 { font-size: 24px; margin: 0 0 4px; color: #fff; }
    .page-header p { margin: 0; color: var(--muted); font-size: 13px; }

    .card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 20px; box-shadow: var(--shadow); }
    table { width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; }
    th { color: var(--muted); font-size: 11px; text-transform: uppercase; padding: 10px 12px; border-bottom: 1px solid var(--line); }
    td { padding: 14px 12px; border-bottom: 1px solid var(--line); color: var(--ink); vertical-align: middle; }
    tr:last-child td { border-bottom: none; }

    .btn-primary { background: var(--green); color: #fff; border: none; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
    .btn-primary:hover { opacity: 0.9; }

    /* MODAL POPUP */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); display: none; place-items: center; z-index: 1000; }
    .modal-overlay.active { display: grid; }
    .modal-card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 24px; width: 100%; max-width: 460px; box-shadow: var(--shadow); }
    .modal-header { font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; }
    .modal-close { background: transparent; border: none; color: var(--muted); font-size: 18px; cursor: pointer; }
    .modal-close:hover { color: #fff; }
    .form-group { margin-bottom: 14px; }
    .form-group label { display: block; font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 6px; }
    .form-control { width: 100%; background: var(--bg); border: 1px solid var(--line); color: var(--ink); padding: 10px 14px; border-radius: 10px; font-size: 13px; outline: none; }
    .form-control:focus { border-color: var(--green); }
    .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
    .btn-action { background: var(--line); border: none; color: #fff; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 600; cursor: pointer; }
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
          <h2>Manajemen User</h2>
          <p>Kelola data akun programmer, PIC, atau admin yang dapat mengakses sistem.</p>
        </div>
        <button class="btn-primary" onclick="openModal()">+ Tambah User Baru</button>
      </div>

      <!-- TABEL USER -->
      <div class="card">
        <table>
          <thead>
            <tr>
              <th>Nama Lengkap</th>
              <th>Email</th>
              <th>Role / Jabatan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><b>Budi Santoso</b></td>
              <td>budi@itsolution.id</td>
              <td><span style="color: var(--green);">DevOps / PIC</span></td>
              <td>
                <button class="btn-action">Edit</button>
                <button class="btn-action" style="background: var(--red);">Hapus</button>
              </td>
            </tr>
            <tr>
              <td><b>Andi Pratama</b></td>
              <td>andi@itsolution.id</td>
              <td><span style="color: var(--amber);">Backend Engineer</span></td>
              <td>
                <button class="btn-action">Edit</button>
                <button class="btn-action" style="background: var(--red);">Hapus</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </main>

  <!-- MODAL TAMBAH USER -->
  <div class="modal-overlay" id="userModal">
    <div class="modal-card">
      <div class="modal-header">
        <span>Tambah User Baru</span>
        <button class="modal-close" onclick="closeModal()">&times;</button>
      </div>
      <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" class="form-control" placeholder="Contoh: Siti Rahma" required>
        </div>
        <div class="form-group">
          <label>Email Akses</label>
          <input type="email" name="email" class="form-control" placeholder="email@itsolution.id" required>
        </div>
        <div class="form-group">
          <label>Password Awal</label>
          <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <div class="form-group">
          <label>Role / Hak Akses</label>
          <select name="role" class="form-control" required>
            <option value="" disabled selected>Pilih Role...</option>
            <option value="super_admin">Super Admin</option>
            <option value="pic">PIC / Programmer</option>
            <option value="pic">QC / Management</option>

          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-action" style="background: transparent; border: 1px solid var(--line);" onclick="closeModal()">Batal</button>
          <button type="submit" class="btn-primary" style="padding: 6px 14px; font-size: 11px;">Simpan User</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const userModal = document.getElementById('userModal');

    function openModal() {
      userModal.classList.add('active');
    }

    function closeModal() {
      userModal.classList.remove('active');
    }

    window.addEventListener('click', (e) => {
      if (e.target === userModal) {
        closeModal();
      }
    });
  </script>

</body>
</html>