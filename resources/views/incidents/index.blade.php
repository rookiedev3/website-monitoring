<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Incidents & Errors - Website Monitoring IT Solution</title>
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
    .container { max-width: 1180px; margin: 0 auto; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px; }
    .page-header h2 { font-size: 24px; margin: 0 0 4px; color: #fff; }
    .page-header p { margin: 0; color: var(--muted); font-size: 13px; }
    .filter-bar { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
    .search-input, .filter-select { background: var(--card); border: 1px solid var(--line); color: var(--ink); padding: 10px 14px; border-radius: 10px; font-size: 13px; outline: none; }
    .search-input { flex: 1; min-width: 220px; }
    .search-input::placeholder { color: var(--muted); }
    .card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 20px; box-shadow: var(--shadow); }
    table { width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; }
    th { color: var(--muted); font-size: 11px; text-transform: uppercase; padding: 10px 12px; border-bottom: 1px solid var(--line); }
    td { padding: 14px 12px; border-bottom: 1px solid var(--line); color: var(--ink); vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
    .badge.open { background: var(--red-soft); color: var(--red); }
    .badge.progress { background: var(--amber-soft); color: var(--amber); }
    .badge.solved { background: var(--green-soft); color: var(--green); }
    .btn-action { background: var(--line); border: none; color: #fff; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 600; cursor: pointer; text-align: center; display: inline-block; }
    .btn-action:hover { background: var(--card-hover); }
    .assign-btn { background: var(--bg); border: 1px solid var(--line); color: var(--ink); padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
    .assign-btn:hover { border-color: var(--green); color: #fff; background: var(--card-hover); }
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); display: none; place-items: center; z-index: 1000; }
    .modal-overlay.active { display: grid; }
    .modal-card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 24px; width: 100%; max-width: 420px; box-shadow: var(--shadow); }
    .modal-header { font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; }
    .modal-close { background: transparent; border: none; color: var(--muted); font-size: 18px; cursor: pointer; }
    .modal-close:hover { color: #fff; }
    .modal-body { margin-bottom: 20px; }
    .modal-footer { display: flex; justify-content: flex-end; gap: 10px; }
  </style>
</head>
<body>

  @include('layouts.sidebar')

  <main>
    <div class="container">

      <div class="page-header">
        <div>
          <h2>Incidents & Errors</h2>
          <p>Daftar seluruh gangguan website yang memerlukan penanganan.</p>
        </div>
      </div>

      @if(session('success'))
        <p style="color: var(--green); margin-bottom: 12px; font-size: 13px;">{{ session('success') }}</p>
      @endif
      @if(session('error'))
        <p style="color: var(--red); margin-bottom: 12px; font-size: 13px;">{{ session('error') }}</p>
      @endif

      <form method="GET" action="{{ route('incidents.index') }}" class="filter-bar">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          class="search-input"
          placeholder="Cari website atau jenis error..."
        >
        <select name="status" class="filter-select" onchange="this.form.submit()">
          <option value="">Status: Semua</option>
          <option value="open" @selected(request('status') === 'open')>Open</option>
          <option value="on_progress" @selected(request('status') === 'on_progress')>On Progress</option>
          <option value="solved" @selected(request('status') === 'solved')>Solved</option>
        </select>
        <select name="pic" class="filter-select" onchange="this.form.submit()">
          <option value="">PIC: Semua</option>
          @foreach($picOptions as $pic)
            <option value="{{ $pic->id }}" @selected((string) request('pic') === (string) $pic->id)>{{ $pic->name }}</option>
          @endforeach
        </select>
        <button type="submit" class="btn-action">Cari</button>
      </form>

      <div class="card">
        <table>
          <thead>
            <tr>
              <th>Website & Customer</th>
              <th>Jenis Error</th>
              <th>Mulai Error</th>
              <th>PIC</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($incidents as $incident)
            <tr>
              <td>
                <b>{{ $incident->website->website_name }}</b><br>
                <small style="color:var(--muted)">{{ $incident->website->customer_name }}</small>
              </td>
              <td><span style="color:var(--red)">{{ $incident->type_label }}</span></td>
              <td>{{ $incident->started_at->timezone('Asia/Jakarta')->format('d M, H:i') }} WIB</td>
              <td>
                @if($incident->assignedUser)
                  {{ $incident->assignedUser->name }}
                  @if(Auth::user()->role === 'super_admin')
                    <br>
                    <button
                      class="assign-btn"
                      style="margin-top:4px; padding:3px 8px; font-size:10px;"
                      onclick="openAssignModal({{ $incident->id }}, '{{ $incident->website->website_name }}', {{ $incident->assigned_to }})"
                    >
                      Ganti PIC
                    </button>
                  @endif
                @else
                  @if(Auth::user()->role === 'super_admin')
                    <button
                      class="assign-btn"
                      onclick="openAssignModal({{ $incident->id }}, '{{ $incident->website->website_name }}', null)"
                    >
                      + Tugaskan PIC
                    </button>
                  @else
                    <span style="color: var(--muted);">Belum ditugaskan</span>
                  @endif
                @endif
              </td>
              <td><span class="badge {{ $incident->badge_class }}">{{ ucfirst(str_replace('_', ' ', $incident->status)) }}</span></td>
              <td>
                <a href="{{ route('incidents.show', $incident->id) }}" class="btn-action">Detail & Update</a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" style="text-align:center; color: var(--muted);">Belum ada incident.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{ $incidents->links() }}

    </div>
  </main>

  @if(Auth::user()->role === 'super_admin')
  <div class="modal-overlay" id="assignModal">
    <div class="modal-card">
      <div class="modal-header">
        <span>Tugaskan PIC Incident</span>
        <button class="modal-close" onclick="closeAssignModal()">&times;</button>
      </div>
      <form id="assignForm" action="#" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-body">
          <p style="font-size: 12px; color: var(--muted); margin-bottom: 12px;">
            Pilih PIC untuk menangani gangguan pada <b id="modalWebsiteName" style="color: #fff;">-</b>:
          </p>
          <div class="form-group">
            <select name="assigned_to" id="modalPicSelect" class="filter-select" style="width: 100%; padding: 12px;" required>
              <option value="" disabled>Pilih Nama PIC...</option>
              @foreach($picOptions as $pic)
                <option value="{{ $pic->id }}">{{ $pic->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-action" style="background: transparent; border: 1px solid var(--line);" onclick="closeAssignModal()">Batal</button>
          <button type="submit" class="btn-action" style="background: var(--green);">Simpan Penugasan</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const assignModal = document.getElementById('assignModal');
    const modalWebsiteName = document.getElementById('modalWebsiteName');
    const assignForm = document.getElementById('assignForm');
    const modalPicSelect = document.getElementById('modalPicSelect');

    function openAssignModal(incidentId, websiteName, currentPicId) {
      modalWebsiteName.textContent = websiteName;
      assignForm.action = `/incidents/${incidentId}`;
      modalPicSelect.value = currentPicId ?? '';
      assignModal.classList.add('active');
    }

    function closeAssignModal() {
      assignModal.classList.remove('active');
    }

    window.addEventListener('click', (e) => {
      if (e.target === assignModal) closeAssignModal();
    });
  </script>
  @endif

</body>
</html>