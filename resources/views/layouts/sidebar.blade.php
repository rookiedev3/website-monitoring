<!-- SIDEBAR RESPONSIF LENGKAP DENGAN TOMBOL MOBILE -->
<style>
  :root {
    --sidebar-width: 215px;      
    --sidebar-collapsed: 62px;   
    --line: #2e4a3b;
  }

  aside#sidebar {
    position: fixed; top: 0; left: 0; height: 100vh;
    width: var(--sidebar-width); background: var(--card);
    border-right: 1px solid var(--line); display: flex;
    flex-direction: column; z-index: 100; box-shadow: var(--shadow);
    transition: transform 0.3s ease, width 0.3s ease;
  }
  aside#sidebar.collapsed { width: var(--sidebar-collapsed); }

  /* Tombol Menu Hamburger khusus Mobile (Disembunyikan di Laptop) */
  .mobile-menu-btn {
    display: none;
    background: transparent;
    border: none;
    color: #fff;
    cursor: pointer;
    padding: 4px;
    border-radius: 6px;
  }
  .mobile-menu-btn:hover { background: var(--card-hover); }

  /* Brand Area (Header Sidebar) */
  .brand-area { 
    padding: 12px 14px; 
    display: flex; 
    align-items: center; 
    justify-content: space-between;
    gap: 10px; 
    border-bottom: 1px solid var(--line); 
    overflow: hidden; 
    white-space: nowrap; 
  }
  
  .brand-left {
    display: flex;
    align-items: center;
    gap: 12px;
    overflow: hidden;
  }

  .logo { 
    width: 32px; 
    height: 32px; 
    border-radius: 50%;   
    background: #fff; 
    display: flex; 
    align-items: center;
    justify-content: center;
    flex-shrink: 0; 
    overflow: hidden; 
    border: 1px solid var(--line); 
  }
  
  .logo img {
    width: 100%;
    height: 100%;
    object-fit: cover; 
  }

  .brand-text { transition: opacity 0.2s ease; }
  aside#sidebar.collapsed .brand-text { display: none; }
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
    text-decoration: none;
  }
  .nav-item:hover { background: #1f3328; color: #fff; }
  .nav-item.active { background: #183828; color: #4ade80; font-weight: 700; } 
  .nav-item svg { width: 17px; height: 17px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }
  aside#sidebar.collapsed .nav-item span { display: none; }

  /* User Profile Section */
  .user-profile-container { position: relative; border-top: 1px solid var(--line); padding: 8px; }
  .user-profile-btn { 
    width: 100%; background: transparent; border: none; 
    display: flex; align-items: center; gap: 8px; padding: 6px; 
    border-radius: 8px; cursor: pointer; color: var(--ink); 
    text-align: left; white-space: nowrap; overflow: hidden; 
  }
  .user-profile-btn:hover { background: var(--card-hover); }
  .user-avatar { 
    width: 28px; height: 28px; border-radius: 50%; 
    background: #24372d; color: #fff; display: grid; 
    place-items: center; font-weight: 700; font-size: 11px; flex-shrink: 0; 
  }
  .user-info { flex: 1; overflow: hidden; }
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
  .popup-item { padding: 8px 12px; font-size: 11px; color: var(--ink); display: flex; align-items: center; gap: 8px; background: transparent; border: none; cursor: pointer; text-align: left; width: 100%; text-decoration: none; }
  .popup-item.danger { color: var(--red); }
  .popup-item:hover { background: #1f3328; color: #fff; }

  /* Toggle Bar */
  .sidebar-toggle-bar { 
    border-top: 1px solid var(--line); padding: 8px 10px; 
    display: flex; align-items: center; justify-content: space-between; 
    cursor: pointer; background: rgba(0,0,0,0.1); font-size: 10px; color: var(--muted); 
  }
  .sidebar-toggle-bar:hover { background: var(--card-hover); color: #fff; }
  aside#sidebar.collapsed .sidebar-toggle-text { display: none; }
  aside#sidebar.collapsed .sidebar-toggle-bar { justify-content: center; }

  /* ========================================== */
  /* RESPONSIVE CSS UNTUK HP & TABLET           */
  /* ========================================== */
  .sidebar-overlay {
    display: none;
    position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
    background: rgba(0, 0, 0, 0.5); z-index: 99;
  }
  .sidebar-overlay.show { display: block; }

  @media (max-width: 768px) {
    /* Munculkan tombol hamburger di HP */
    .mobile-menu-btn { display: block; }

    /* Sidebar disembunyikan ke kiri secara default di HP */
    aside#sidebar {
      transform: translateX(-100%);
      width: var(--sidebar-width) !important;
    }
    
    /* Saat dibuka, sidebar bergeser ke layar */
    aside#sidebar.mobile-open {
      transform: translateX(0);
    }

    /* Sembunyikan tombol perkecil desktop di HP */
    .sidebar-toggle-bar {
      display: none;
    }
  }
</style>

<!-- Tombol Menu Mengambang (Floating Hamburger Button) khusus untuk HP di pojok kiri atas, garis 3  -->
<button onclick="toggleMobileSidebar()" style="position: fixed; top: 12px; left: 12px; z-index: 98; background: #17231d; border: 1px solid var(--line); color: #fff; padding: 8px; border-radius: 8px; display: none; align-items: center; justify-content: center; box-shadow: var(--shadow);" id="floatingMenuBtn">
  <svg style="width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
</button>

<!-- Backdrop overlay saat sidebar terbuka di HP -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside id="sidebar">
  <div class="brand-area">
    <div class="brand-left">
      <div class="logo">
        <img src="{{ asset('img/logo.jpeg') }}" alt="Logo">
      </div>
      <div class="brand-text">
        <h1>IT Solution</h1>
        <small>Monitoring System</small>
      </div>
    </div>
    <!-- Tombol close/hamburger di dalam header sidebar khusus mobile -->
    <button class="mobile-menu-btn" onclick="toggleMobileSidebar()">
      <svg style="width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
  </div>

  <div class="menu-list">
    <div class="menu-title">Menu Utama</div>
    
    <!-- Dashboard -->
    <a href="{{ route('dashboard.index') }}" class="nav-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }} menu-link">
      <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      <span>Dashboard</span>
    </a>

    <!-- Websites -->
    <a href="{{ route('websites.index') }}" class="nav-item {{ request()->routeIs('websites.*') ? 'active' : '' }} menu-link">
      <svg viewBox="0 0 24 24"><path d="M21 12a9 9 0 0 1-9 9m9-9a9 9 0 0 0-9-9m9 9H3m9 9a9 9 0 0 1-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 0 1 9-9"/></svg>
      <span>Websites</span>
    </a>

    <!-- Incidents & Errors -->
    <a href="{{ route('incidents.index') }}" class="nav-item {{ request()->routeIs('incidents.*') ? 'active' : '' }} menu-link">
      <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      <span>Incidents & Errors</span>
    </a>

    <!-- Analytics -->
    @if(auth()->check() && in_array(auth()->user()->role, ['super_admin', 'viewer']))  
    <a href="{{ route('analytics.index') }}" class="nav-item {{ request()->routeIs('analytics.*') ? 'active' : '' }} menu-link">
      <svg viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
      <span>Analytics</span>
    </a>
    @endif

    <!-- Settings -->
    @if(auth()->user()->role == 'super_admin')
    <a href="{{ route('settings.index') }}" class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }} menu-link">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l-.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9c.69 0 1.31.4 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09c-.2.6-.82 1-1.51 1z"/></svg>
      <span>Settings</span>
    </a>
    @endif

    <!-- Manajemen User -->
    @if(auth()->user()->role == 'super_admin')
    <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }} menu-link">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
      <span>Manajemen User</span>
    </a>
    @endif
  </div>

 <div class="user-popup-menu" id="userPopupMenu">
    <a href="{{ route('profile.index') }}" class="popup-item">
        <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Profil User
    </a>
      <a href="{{ route('logout') }}" class="popup-item danger">
        <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Logout
      </a>
    </div>

    <button class="user-profile-btn" id="userProfileBtn" title="Akun">
      <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
      <div class="user-info">
        <h4>{{ auth()->user()->name }}</h4>
        <p>{{ auth()->user()->email }}</p>
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
  const sidebarOverlay = document.getElementById('sidebarOverlay');
  const floatingMenuBtn = document.getElementById('floatingMenuBtn');

  // Atur kemunculan tombol menu mengambang otomatis berdasarkan ukuran layar
  function checkScreenSize() {
    if (window.innerWidth <= 768) {
      floatingMenuBtn.style.display = 'flex';
    } else {
      floatingMenuBtn.style.display = 'none';
      sidebar.classList.remove('mobile-open');
      sidebarOverlay.classList.remove('show');
    }
  }
  window.addEventListener('resize', checkScreenSize);
  window.addEventListener('load', checkScreenSize);

  // Toggle untuk mode desktop (perkecil / expand sidebar)
  sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    userPopupMenu.classList.remove('show');
    toggleIcon.innerHTML = sidebar.classList.contains('collapsed') 
      ? '<polyline points="9 18 15 12 9 6"/>' 
      : '<polyline points="15 18 9 12 15 6"/>';
  });

  // Toggle popup profil user
  userProfileBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    userPopupMenu.classList.toggle('show');
  });

  window.addEventListener('click', () => {
    userPopupMenu.classList.remove('show');
  });

  // Fungsi untuk membuka/menutup sidebar di HP
  window.toggleMobileSidebar = function() {
    sidebar.classList.toggle('mobile-open');
    sidebarOverlay.classList.toggle('show');
  };

  // Klik overlay di HP akan menutup sidebar
  sidebarOverlay.addEventListener('click', () => {
    sidebar.classList.remove('mobile-open');
    sidebarOverlay.classList.remove('show');
  });
</script>