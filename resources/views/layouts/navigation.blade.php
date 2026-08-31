<style>
  :root {
    --sidebar-width: 215px;      
    --sidebar-collapsed: 62px;   
    --navbar-height: 60px;
    --navbar-bg: #16241d;
    --nav-border: #2e4a3b;
    --line: #2e4a3b;
    --text-color: #fff;
    --muted-color: #9ca3af;
  }

  /* TOP NAVBAR STYLES */
  .top-navbar {
    position: fixed;
    top: 0;
    right: 0;
    left: var(--sidebar-width);
    height: var(--navbar-height);
    background: var(--navbar-bg);
    border-bottom: 1px solid var(--nav-border);
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 0 24px;
    z-index: 90;
    transition: left 0.3s ease;
  }

  aside#sidebar.collapsed ~ .top-navbar {
    left: var(--sidebar-collapsed);
  }

  /* NOTIFICATION DROPDOWN STYLES */
  .notification-wrapper {
    position: relative;
  }

  .notification-btn {
    background: transparent;
    border: 1px solid var(--nav-border);
    color: var(--text-color);
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
    transition: background 0.2s ease;
  }

  .notification-btn:hover {
    background: #1f3328;
  }

  .notification-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background: #ef4444;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 10px;
    border: 2px solid var(--navbar-bg);
    line-height: 1;
  }

  .notification-dropdown {
    position: absolute;
    top: 48px;
    right: 0;
    width: 340px;
    max-height: 420px;
    background: #17231d;
    border: 1px solid var(--nav-border);
    border-radius: 12px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
    display: none;
    flex-direction: column;
    overflow: hidden;
    z-index: 100;
  }

  .notification-dropdown.show {
    display: flex;
  }

  .notif-header {
    padding: 12px 16px;
    border-bottom: 1px solid var(--nav-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .notif-header h3 {
    font-size: 13px;
    margin: 0;
    color: #fff;
    font-weight: 700;
  }

  .mark-all-btn {
    font-size: 11px;
    color: #4ade80;
    background: none;
    border: none;
    cursor: pointer;
    text-decoration: none;
  }
  .mark-all-btn:hover { text-decoration: underline; }

  .notif-body {
    overflow-y: auto;
    flex: 1;
  }

  .notif-item {
    padding: 12px 16px;
    border-bottom: 1px solid rgba(46, 74, 59, 0.5);
    display: flex;
    gap: 12px;
    text-decoration: none;
    transition: background 0.2s ease;
  }

  .notif-item:hover {
    background: #1f3328;
  }

  .notif-item.unread {
    background: rgba(24, 56, 40, 0.4);
  }

  .notif-icon-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-top: 4px;
    flex-shrink: 0;
  }
  .notif-icon-dot.danger { background: #ef4444; box-shadow: 0 0 8px #ef4444; }
  .notif-icon-dot.success { background: #22c55e; box-shadow: 0 0 8px #22c55e; }

  .notif-content {
    flex: 1;
    overflow: hidden;
  }

  .notif-title {
    font-size: 12px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 2px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .notif-desc {
    font-size: 11px;
    color: var(--muted-color);
    margin: 0 0 4px 0;
    line-height: 1.3;
  }

  .notif-time {
    font-size: 9px;
    color: #6b7280;
  }

  .notif-empty {
    padding: 24px;
    text-align: center;
    color: var(--muted-color);
    font-size: 12px;
  }

  /* SIDEBAR STYLES */
  aside#sidebar {
    position: fixed; top: 0; left: 0; height: 100vh;
    width: var(--sidebar-width); background: var(--card, #16241d);
    border-right: 1px solid var(--line); display: flex;
    flex-direction: column; z-index: 100; box-shadow: var(--shadow, 0 4px 6px -1px rgba(0,0,0,0.1));
    transition: transform 0.3s ease, width 0.3s ease;
  }
  aside#sidebar.collapsed { width: var(--sidebar-collapsed); }

  .mobile-menu-btn {
    display: none;
    background: transparent;
    border: none;
    color: #fff;
    cursor: pointer;
    padding: 4px;
    border-radius: 6px;
  }
  .mobile-menu-btn:hover { background: var(--card-hover, #1f3328); }

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
  .brand-text small { font-size: 10px; color: var(--muted-color); display: block; }

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
    color: var(--muted-color); 
    padding: 8px 10px 4px; 
    text-transform: uppercase; 
    white-space: nowrap; 
  }
  aside#sidebar.collapsed .menu-title { display: none; }

  .nav-item { 
    display: flex; 
    align-items: center; 
    gap: 10px; 
    padding: 8px 10px; 
    border-radius: 8px; 
    color: var(--muted-color); 
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

  .user-profile-container { position: relative; border-top: 1px solid var(--line); padding: 8px; }
  .user-profile-btn { 
    width: 100%; background: transparent; border: none; 
    display: flex; align-items: center; gap: 8px; padding: 6px; 
    border-radius: 8px; cursor: pointer; color: #fff; 
    text-align: left; white-space: nowrap; overflow: hidden; 
  }
  .user-profile-btn:hover { background: #1f3328; }
  .user-avatar { 
    width: 28px; height: 28px; border-radius: 50%; 
    background: #24372d; color: #fff; display: grid; 
    place-items: center; font-weight: 700; font-size: 11px; flex-shrink: 0; 
  }
  .user-info { flex: 1; overflow: hidden; }
  .user-info h4 { font-size: 11px; margin: 0; color: #fff; text-overflow: ellipsis; overflow: hidden; }
  .user-info p { font-size: 9px; margin: 0; color: var(--muted-color); text-overflow: ellipsis; overflow: hidden; }
  aside#sidebar.collapsed .user-info { display: none; }

  .user-popup-menu { 
    position: absolute; bottom: 60px; left: 8px; right: 8px; 
    background: #16241d; border: 1px solid var(--line); 
    border-radius: 10px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.3); 
    display: none; flex-direction: column; overflow: hidden; z-index: 10; 
  }
  .user-popup-menu.show { display: flex; }
  .popup-item { padding: 8px 12px; font-size: 11px; color: #fff; display: flex; align-items: center; gap: 8px; background: transparent; border: none; cursor: pointer; text-align: left; width: 100%; text-decoration: none; }
  .popup-item.danger { color: #ef4444; }
  .popup-item:hover { background: #1f3328; color: #fff; }

  .sidebar-toggle-bar { 
    border-top: 1px solid var(--line); padding: 8px 10px; 
    display: flex; align-items: center; justify-content: space-between; 
    cursor: pointer; background: rgba(0,0,0,0.1); font-size: 10px; color: var(--muted-color); 
  }
  .sidebar-toggle-bar:hover { background: #1f3328; color: #fff; }
  aside#sidebar.collapsed .sidebar-toggle-text { display: none; }
  aside#sidebar.collapsed .sidebar-toggle-bar { justify-content: center; }

  /* RESPONSIVE LAYOUT RULES */
  .sidebar-overlay {
    display: none;
    position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
    background: rgba(0, 0, 0, 0.5); z-index: 99;
  }
  .sidebar-overlay.show { display: block; }

  @media (max-width: 768px) {
    .top-navbar {
      left: 0 !important;
      padding-left: 55px;
    }
    .mobile-menu-btn { display: block; }
    aside#sidebar {
      transform: translateX(-100%);
      width: var(--sidebar-width) !important;
    }
    aside#sidebar.mobile-open {
      transform: translateX(0);
    }
    .sidebar-toggle-bar {
      display: none;
    }
  }
</style>

<!-- TOP NAVBAR KHUSUS NOTIFIKASI -->
<header class="top-navbar">
  @if(auth()->check() && in_array(auth()->user()->role, ['super_admin', 'programmer']))
    @php
      $notifications = auth()->user()->unreadNotifications()->take(10)->get();
      $unreadCount = auth()->user()->unreadNotifications->count();
    @endphp

    <div class="notification-wrapper">
      <button class="notification-btn" id="notifDropdownBtn" title="Notifikasi Status Website">
        <svg style="width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24">
          <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
          <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
        </svg>

        @if($unreadCount > 0)
          <span class="notification-badge">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
        @endif
      </button>

      <div class="notification-dropdown" id="notifDropdownMenu">
        <div class="notif-header">
          <h3>Notifikasi Gangguan</h3>
          @if($unreadCount > 0)
            <form action="{{ route('notifications.markAllRead') }}" method="POST" style="margin:0;">
              @csrf
              <button type="submit" class="mark-all-btn">Tandai Dibaca</button>
            </form>
          @endif
        </div>

        <div class="notif-body">
          @forelse($notifications as $notif)
            @php
              $data = $notif->data;
              $isUnread = is_null($notif->read_at);
              $colorClass = $data['color'] ?? (($data['type'] ?? '') === 'website_down' ? 'danger' : 'success');
              $targetUrl = !empty($data['incident_id']) 
                ? route('incidents.show', $data['incident_id']) 
                : ($data['action_url'] ?? route('incidents.index'));
            @endphp

            <a href="{{ route('notifications.readAndRedirect', [$notif->id, 'redirect' => $targetUrl]) }}" 
               class="notif-item {{ $isUnread ? 'unread' : '' }}">
              <span class="notif-icon-dot {{ $colorClass }}"></span>
              <div class="notif-content">
                <h4 class="notif-title">{{ $data['website_name'] ?? 'Pemberitahuan System' }}</h4>
                <p class="notif-desc">{{ $data['message'] ?? 'Status website telah diperbarui.' }}</p>
                <span class="notif-time">{{ $notif->created_at->diffForHumans() }}</span>
              </div>
            </a>
          @empty
            <div class="notif-empty">
              Tidak ada notifikasi saat ini.
            </div>
          @endforelse
        </div>
      </div>
    </div>
  @endif
</header>

<!-- TOMBOL HAMBURGER MOBILE & OVERLAY -->
<button onclick="toggleMobileSidebar()" style="position: fixed; top: 12px; left: 12px; z-index: 98; background: #17231d; border: 1px solid var(--line); color: #fff; padding: 8px; border-radius: 8px; display: none; align-items: center; justify-content: center;" id="floatingMenuBtn">
  <svg style="width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
</button>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- SIDEBAR NAVIGATION -->
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
    @if(auth()->check() && auth()->user()->role == 'super_admin')
    <a href="{{ route('settings.index') }}" class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }} menu-link">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l-.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9c.69 0 1.31.4 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09c-.2.6-.82 1-1.51 1z"/></svg>
      <span>Settings</span>
    </a>
    @endif

    <!-- Manajemen User -->
    @if(auth()->check() && auth()->user()->role == 'super_admin')
    <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }} menu-link">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
      <span>Manajemen User</span>
    </a>
    @endif
  </div>

  <!-- Profil User -->
  @if(auth()->check())
  <div class="user-profile-container">
    <div class="user-popup-menu" id="userPopupMenu">
      <button class="popup-item">
        <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Profil User
      </button>
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
  @endif

  <div class="sidebar-toggle-bar" id="sidebarToggle">
    <span class="sidebar-toggle-text">Perkecil</span>
    <svg id="toggleIcon" style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
  </div>
</aside>

<!-- SCRIPT PENGENDALI INTERAKSI NAVIGASI -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Handling Notifikasi Dropdown
    const notifBtn = document.getElementById('notifDropdownBtn');
    const notifMenu = document.getElementById('notifDropdownMenu');

    if (notifBtn && notifMenu) {
      notifBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        notifMenu.classList.toggle('show');
      });

      window.addEventListener('click', (e) => {
        if (!notifMenu.contains(e.target) && !notifBtn.contains(e.target)) {
          notifMenu.classList.remove('show');
        }
      });
    }

    // Handling Sidebar Layout & Responsiveness
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const toggleIcon = document.getElementById('toggleIcon');
    const userProfileBtn = document.getElementById('userProfileBtn');
    const userPopupMenu = document.getElementById('userPopupMenu');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const floatingMenuBtn = document.getElementById('floatingMenuBtn');

    function checkScreenSize() {
      if (window.innerWidth <= 768) {
        if (floatingMenuBtn) floatingMenuBtn.style.display = 'flex';
      } else {
        if (floatingMenuBtn) floatingMenuBtn.style.display = 'none';
        if (sidebar) sidebar.classList.remove('mobile-open');
        if (sidebarOverlay) sidebarOverlay.classList.remove('show');
      }
    }

    window.addEventListener('resize', checkScreenSize);
    checkScreenSize();

    if (sidebarToggle) {
      sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        if (userPopupMenu) userPopupMenu.classList.remove('show');
        toggleIcon.innerHTML = sidebar.classList.contains('collapsed') 
          ? '<polyline points="9 18 15 12 9 6"/>' 
          : '<polyline points="15 18 9 12 15 6"/>';
      });
    }

    if (userProfileBtn && userPopupMenu) {
      userProfileBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        userPopupMenu.classList.toggle('show');
      });

      window.addEventListener('click', () => {
        userPopupMenu.classList.remove('show');
      });
    }

    window.toggleMobileSidebar = function() {
      if (sidebar && sidebarOverlay) {
        sidebar.classList.toggle('mobile-open');
        sidebarOverlay.classList.toggle('show');
      }
    };

    if (sidebarOverlay) {
      sidebarOverlay.addEventListener('click', () => {
        if (sidebar) sidebar.classList.remove('mobile-open');
        sidebarOverlay.classList.remove('show');
      });
    }
  });
</script>