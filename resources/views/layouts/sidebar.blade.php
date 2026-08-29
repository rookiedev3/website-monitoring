<!-- SIDEBAR -->
<style>
  :root {
    /* PENYESUAIAN UKURAN SIDEBAR */
    --sidebar-width: 215px;      /* Sebelumnya 260px (Lebih ramping) */
    --sidebar-collapsed: 62px;   /* Sebelumnya 76px */
  }

  aside#sidebar {
    position: fixed; top: 0; left: 0; height: 100vh;
    width: var(--sidebar-width); background: var(--card);
    border-right: 1px solid var(--line); display: flex;
    flex-direction: column; z-index: 100; box-shadow: var(--shadow);
  }
  aside#sidebar.collapsed { width: var(--sidebar-collapsed); }

  /* Brand Area (Header Sidebar) */
  .brand-area { 
    padding: 12px 14px; 
    display: flex; 
    align-items: center; 
    gap: 10px; 
    border-bottom: 1px solid var(--line); 
    overflow: hidden; 
    white-space: nowrap; 
  }
  .logo { 
    width: 32px; 
    height: 32px; 
    border-radius: 8px; 
    background: linear-gradient(135deg, #17231d, #24372d); 
    border: 1px solid var(--line); 
    display: grid; 
    place-items: center; 
    font-weight: 800; 
    font-size: 13px;
    color: var(--green); 
    flex-shrink: 0; 
  }
  .brand-text h1 { font-size: 13px; margin: 0; color: #fff; font-weight: 700; }
  .brand-text small { font-size: 10px; color: var(--muted); display: block; }

  /* Menu List */
  .menu-list { 
    flex: 1; 
    padding: 12px 8px; 
    overflow-y: auto; 
    overflow-x: hidden; 
    display: flex; 
    flex-direction: column; 
    gap: 3px; 
  }
  .menu-title { 
    font-size: 9px; 
    font-weight: 800; 
    letter-spacing: .08em; 
    color: var(--muted); 
    padding: 8px 10px 4px; 
    text-transform: uppercase; 
    white-space: nowrap; 
  }
  aside#sidebar.collapsed .menu-title { display: none; }

  /* Nav Item */
  .nav-item { 
    display: flex; 
    align-items: center; 
    gap: 10px; 
    padding: 8px 10px; 
    border-radius: 8px; 
    color: var(--muted); 
    font-size: 12px; 
    font-weight: 600; 
    white-space: nowrap; 
    cursor: pointer; 
  }
  .nav-item:hover, .nav-item.active { background: var(--card-hover); color: #fff; }
  .nav-item svg { width: 17px; height: 17px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }
  aside#sidebar.collapsed .nav-item span { display: none; }

  /* User Profile Section */
  .user-profile-container { position: relative; border-top: 1px solid var(--line); padding: 8px; }
  .user-profile-btn { 
    width: 100%; 
    background: transparent; 
    border: none; 
    display: flex; 
    align-items: center; 
    gap: 8px; 
    padding: 6px; 
    border-radius: 8px; 
    cursor: pointer; 
    color: var(--ink); 
    text-align: left; 
    white-space: nowrap; 
    overflow: hidden; 
  }
  .user-profile-btn:hover { background: var(--card-hover); }
  .user-avatar { 
    width: 28px; 
    height: 28px; 
    border-radius: 50%; 
    background: #24372d; 
    color: #fff; 
    display: grid; 
    place-items: center; 
    font-weight: 700; 
    font-size: 11px; 
    flex-shrink: 0; 
  }
  .user-info flex: 1; overflow: hidden;
  .user-info h4 { font-size: 11px; margin: 0; color: #fff; text-overflow: ellipsis; overflow: hidden; }
  .user-info p { font-size: 9px; margin: 0; color: var(--muted); text-overflow: ellipsis; overflow: hidden; }
  aside#sidebar.collapsed .user-info { display: none; }

  .user-popup-menu { 
    position: absolute; bottom: 60px; left: 8px; right: 8px; 
    background: #16241d; border: 1px solid var(--line); 
    border-radius: 10px; box-shadow: var(--shadow); 
    display: none; flex-direction: column; overflow: hidden; z-index: 10; 
  }
  .user-popup-menu.show { display: flex; }
  .popup-item { padding: 8px 12px; font-size: 11px; color: var(--ink); display: flex; align-items: center; gap: 8px; background: transparent; border: none; cursor: pointer; text-align: left; width: 100%; }

  /* Toggle Bar */
  .sidebar-toggle-bar { 
    border-top: 1px solid var(--line); 
    padding: 8px 10px; 
    display: flex; 
    align-items: center; 
    justify-content: space-between; 
    cursor: pointer; 
    background: rgba(0,0,0,0.1); 
    font-size: 10px; 
    color: var(--muted); 
  }
  .sidebar-toggle-bar:hover { background: var(--card-hover); color: #fff; }
  aside#sidebar.collapsed .sidebar-toggle-text { display: none; }
  aside#sidebar.collapsed .sidebar-toggle-bar { justify-content: center; }
</style>

<aside id="sidebar">
  <div class="brand-area">
    <div class="logo">WM</div>
    <div class="brand-text">
      <h1>IT Solution</h1>
      <small>Monitoring System</small>
    </div>
  </div>

  <div class="menu-list">
    <div class="menu-title">Menu Utama</div>
    
    <a href="{{ route('dashboard.index') }}" class="nav-item active menu-link">
      <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      <span>Dashboard</span>
    </a>
    <a href="{{ route('websites.index') }}" class="nav-item menu-link">
      <svg viewBox="0 0 24 24"><path d="M21 12a9 9 0 0 1-9 9m9-9a9 9 0 0 0-9-9m9 9H3m9 9a9 9 0 0 1-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 0 1 9-9"/></svg>
      <span>Websites</span>
    </a>
    <a href="#" class="nav-item menu-link">
      <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      <span>Incidents</span>
    </a>
    <a href="#" class="nav-item menu-link">
      <svg viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
      <span>Analytics</span>
    </a>
    <a href="#" class="nav-item menu-link">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
      <span>Settings</span>
    </a>
  </div>

  <div class="user-profile-container">
    <div class="user-popup-menu" id="userPopupMenu">
      <button class="popup-item">Profil User</button>
      <button class="popup-item danger">Logout</button>
    </div>

    <button class="user-profile-btn" id="userProfileBtn" title="Akun">
      <div class="user-avatar">SA</div>
      <div class="user-info">
        <h4>Super Admin</h4>
        <p>admin@itsolution.com</p>
      </div>
    </button>
  </div>

  <div class="sidebar-toggle-bar" id="sidebarToggle">
    <span class="sidebar-toggle-text">Perkecil</span>
    <svg id="toggleIcon" style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
  </div>
</aside>

<script>
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  const toggleIcon = document.getElementById('toggleIcon');
  const userProfileBtn = document.getElementById('userProfileBtn');
  const userPopupMenu = document.getElementById('userPopupMenu');

  sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    userPopupMenu.classList.remove('show');
    toggleIcon.innerHTML = sidebar.classList.contains('collapsed') 
      ? '<polyline points="9 18 15 12 9 6"/>' 
      : '<polyline points="15 18 9 12 15 6"/>';
  });

  userProfileBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    userPopupMenu.classList.toggle('show');
  });

  window.addEventListener('click', () => {
    userPopupMenu.classList.remove('show');
  });
</script>