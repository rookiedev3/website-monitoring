<!-- NAV LAYOUT SCOPE WRAPPER -->
<div class="nav-layout-scope">

  <style>
    /* 1. LOCAL CSS RESET & VARIABLES */
    .nav-layout-scope {
      --sidebar-width: 215px;
      --sidebar-collapsed: 62px;
      --navbar-height: 60px;
      --navbar-bg: #16241d;
      --nav-border: #2e4a3b;
      --line: #2e4a3b;
      --card: #111b16;
      --card-hover: #17231d;
      --muted: #82988c;
      --text-color: #ffffff;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      font-size: 14px;
      line-height: 1.5;
      box-sizing: border-box;
    }

    .nav-layout-scope *,
    .nav-layout-scope *::before,
    .nav-layout-scope *::after {
      box-sizing: border-box !important;
      margin: 0;
      padding: 0;
    }

    /* 2. TOP NAVBAR STYLES */
    .nav-layout-scope .top-navbar {
      position: fixed;
      top: 0;
      right: 0;
      left: var(--sidebar-width);
      width: calc(100% - var(--sidebar-width));
      height: var(--navbar-height);
      background: var(--navbar-bg);
      border-bottom: 1px solid var(--nav-border);
      display: flex;
      align-items: center;
      justify-content: flex-end;
      padding: 0 24px;
      z-index: 90;
      transition: left 0.3s ease, width 0.3s ease;
    }

    /* NOTIFICATION DROPDOWN STYLES */
    .nav-layout-scope .notification-wrapper {
      position: relative;
    }

    .nav-layout-scope .notification-btn {
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

    .nav-layout-scope .notification-btn:hover {
      background: var(--card-hover);
    }

    .nav-layout-scope .notification-badge {
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

    .nav-layout-scope .notification-dropdown {
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

    .nav-layout-scope .notification-dropdown.show {
      display: flex;
    }

    .nav-layout-scope .notif-header {
      padding: 12px 16px;
      border-bottom: 1px solid var(--nav-border);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .nav-layout-scope .notif-header h3 {
      font-size: 13px;
      margin: 0;
      color: #fff;
      font-weight: 700;
    }

    .nav-layout-scope .mark-all-btn {
      font-size: 11px;
      color: #4ade80;
      background: none;
      border: none;
      cursor: pointer;
      text-decoration: none;
    }

    .nav-layout-scope .mark-all-btn:hover {
      text-decoration: underline;
    }

    .nav-layout-scope .notif-body {
      overflow-y: auto;
      flex: 1;
    }

    .nav-layout-scope .notif-item-wrapper {
      position: relative;
      display: flex;
      align-items: center;
      border-bottom: 1px solid rgba(46, 74, 59, 0.5);
      transition: background 0.2s ease;
    }

    .nav-layout-scope .notif-item-wrapper:hover {
      background: var(--card-hover);
    }

    .nav-layout-scope .notif-item-wrapper.unread {
      background: rgba(24, 56, 40, 0.4);
    }

    .nav-layout-scope .notif-item-wrapper .notif-item {
      flex: 1;
      border-bottom: none;
      padding: 12px 36px 12px 16px;
      display: flex;
      gap: 12px;
      text-decoration: none;
    }

    .nav-layout-scope .notif-icon-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      margin-top: 4px;
      flex-shrink: 0;
    }

    .nav-layout-scope .notif-icon-dot.danger {
      background: #ef4444;
      box-shadow: 0 0 8px #ef4444;
    }

    .nav-layout-scope .notif-icon-dot.success {
      background: #22c55e;
      box-shadow: 0 0 8px #22c55e;
    }

    .nav-layout-scope .notif-content {
      flex: 1;
      overflow: hidden;
    }

    .nav-layout-scope .notif-title {
      font-size: 12px;
      font-weight: 700;
      color: #fff;
      margin: 0 0 2px 0;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .nav-layout-scope .notif-desc {
      font-size: 11px;
      color: var(--muted);
      margin: 0 0 4px 0;
      line-height: 1.3;
    }

    .nav-layout-scope .notif-time {
      font-size: 9px;
      color: #6b7280;
    }

    .nav-layout-scope .notif-delete-form {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      margin: 0;
      z-index: 2;
    }

    .nav-layout-scope .notif-delete-btn {
      background: transparent;
      border: none;
      color: #6b7280;
      width: 24px;
      height: 24px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      padding: 0;
      transition: all 0.2s ease;
    }

    .nav-layout-scope .notif-delete-btn svg {
      width: 14px;
      height: 14px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    .nav-layout-scope .notif-delete-btn:hover {
      background: rgba(239, 68, 68, 0.2);
      color: #ef4444;
    }

    .nav-layout-scope .notif-empty {
      padding: 24px;
      text-align: center;
      color: var(--muted);
      font-size: 12px;
    }

    /* 3. SIDEBAR STYLES */
    .nav-layout-scope aside#sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: var(--sidebar-width);
      background: var(--card);
      border-right: 1px solid var(--line);
      display: flex;
      flex-direction: column;
      z-index: 100;
      box-shadow: 0 10px 30px rgba(0, 0, 0, .3);
      transition: transform 0.3s ease, width 0.3s ease;
    }

    .nav-layout-scope aside#sidebar.collapsed {
      width: var(--sidebar-collapsed);
    }

    .nav-layout-scope .mobile-menu-btn {
      display: none;
      background: transparent;
      border: none;
      color: #fff;
      cursor: pointer;
      padding: 4px;
      border-radius: 6px;
    }

    .nav-layout-scope .mobile-menu-btn:hover {
      background: var(--card-hover);
    }

    .nav-layout-scope .brand-area {
      padding: 12px 14px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      border-bottom: 1px solid var(--line);
      overflow: hidden;
      white-space: nowrap;
    }

    .nav-layout-scope .brand-left {
      display: flex;
      align-items: center;
      gap: 12px;
      overflow: hidden;
    }

    .nav-layout-scope .logo {
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

    .nav-layout-scope .logo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .nav-layout-scope .brand-text {
      transition: opacity 0.2s ease;
    }

    .nav-layout-scope aside#sidebar.collapsed .brand-text {
      display: none;
    }

    .nav-layout-scope .brand-text h1 {
      font-size: 13px;
      margin: 0;
      color: #fff;
      font-weight: 700;
    }

    .nav-layout-scope .brand-text small {
      font-size: 10px;
      color: var(--muted);
      display: block;
    }

    .nav-layout-scope .menu-list {
      flex: 1;
      padding: 12px 8px;
      overflow-y: auto;
      overflow-x: hidden;
      display: flex;
      flex-direction: column;
      gap: 3px;
    }

    .nav-layout-scope .menu-title {
      font-size: 9px;
      font-weight: 800;
      letter-spacing: .08em;
      color: var(--muted);
      padding: 8px 10px 4px;
      text-transform: uppercase;
      white-space: nowrap;
    }

    .nav-layout-scope aside#sidebar.collapsed .menu-title {
      display: none;
    }

    .nav-layout-scope .nav-item {
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
      transition: background 0.2s ease, color 0.2s ease;
    }

    .nav-layout-scope .nav-item:hover {
      background: #1f3328;
      color: #fff;
    }

    .nav-layout-scope .nav-item.active {
      background: #183828;
      color: #4ade80;
      font-weight: 700;
    }

    .nav-layout-scope .nav-item svg {
      width: 17px;
      height: 17px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
      flex-shrink: 0;
    }

    .nav-layout-scope aside#sidebar.collapsed .nav-item span {
      display: none;
    }

    /* 4. KARTU AKUN DI BAWAH SIDEBAR */
    .nav-layout-scope .user-profile-container {
      position: relative;
      border-top: 1px solid var(--line);
      padding: 8px;
    }

    .nav-layout-scope .user-profile-btn {
      width: 100%;
      background: transparent;
      border: none;
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 6px;
      border-radius: 8px;
      cursor: pointer;
      color: #fff;
      text-align: left;
      white-space: nowrap;
      overflow: hidden;
    }

    .nav-layout-scope .user-profile-btn:hover {
      background: var(--card-hover);
    }

    .nav-layout-scope .user-avatar {
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

    .nav-layout-scope .user-info {
      flex: 1;
      overflow: hidden;
    }

    .nav-layout-scope .user-info h4 {
      font-size: 11px;
      margin: 0;
      color: #fff;
      text-overflow: ellipsis;
      overflow: hidden;
    }

    .nav-layout-scope .user-info p {
      font-size: 9px;
      margin: 0;
      color: var(--muted);
      text-overflow: ellipsis;
      overflow: hidden;
    }

    .nav-layout-scope aside#sidebar.collapsed .user-info {
      display: none;
    }

    .nav-layout-scope aside#sidebar.collapsed .user-profile-btn {
      justify-content: center !important;
      padding: 6px 0 !important;
    }

    /* POPUP MENU PROFIL & LOGOUT */
    .nav-layout-scope .user-popup-menu {
      position: fixed;
      background: #16241d;
      border: 1px solid var(--line);
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, .5);
      display: none;
      flex-direction: column;
      overflow: hidden;
      z-index: 1000;
    }

    .nav-layout-scope .user-popup-menu.show {
      display: flex;
    }

    .nav-layout-scope .popup-item {
      padding: 10px 14px;
      font-size: 12px;
      color: #dce9e1;
      display: flex;
      align-items: center;
      gap: 10px;
      background: transparent;
      border: none;
      cursor: pointer;
      text-align: left;
      width: 100%;
      text-decoration: none;
      white-space: nowrap;
      font-family: inherit;
    }

    .nav-layout-scope .popup-item.danger {
      color: #d94c4c;
    }

    .nav-layout-scope .popup-item:hover {
      background: #1f3328;
      color: #fff;
    }

    .nav-layout-scope .logout-form {
      margin: 0;
      padding: 0;
    }

    .nav-layout-scope .logout-form button.popup-item {
      width: 100%;
    }

    /* TOGGLE BAR */
    .nav-layout-scope .sidebar-toggle-bar {
      border-top: 1px solid var(--line);
      padding: 8px 10px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
      background: rgba(0, 0, 0, 0.1);
      font-size: 10px;
      color: var(--muted);
    }

    .nav-layout-scope .sidebar-toggle-bar:hover {
      background: var(--card-hover);
      color: #fff;
    }

    .nav-layout-scope aside#sidebar.collapsed .sidebar-toggle-text {
      display: none;
    }

    .nav-layout-scope aside#sidebar.collapsed .sidebar-toggle-bar {
      justify-content: center;
    }

    /* RESPONSIVE OVERLAY */
    .nav-layout-scope .sidebar-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.5);
      z-index: 99;
    }

    .nav-layout-scope .sidebar-overlay.show {
      display: block;
    }

    @media (max-width: 768px) {
      .nav-layout-scope .top-navbar {
        left: 0 !important;
        width: 100% !important;
        padding-left: 55px;
      }

      .nav-layout-scope .mobile-menu-btn {
        display: block;
      }

      .nav-layout-scope aside#sidebar {
        transform: translateX(-100%);
        width: var(--sidebar-width) !important;
      }

      .nav-layout-scope aside#sidebar.mobile-open {
        transform: translateX(0);
      }

      .nav-layout-scope .sidebar-toggle-bar {
        display: none;
      }
    }
  </style>

  <!-- TOP NAVBAR UTAMA & NOTIFIKASI -->
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

              <div class="notif-item-wrapper {{ $isUnread ? 'unread' : '' }}">
                <a href="{{ route('notifications.readAndRedirect', [$notif->id, 'redirect' => $targetUrl]) }}"
                  class="notif-item">
                  <span class="notif-icon-dot {{ $colorClass }}"></span>
                  <div class="notif-content">
                    <h4 class="notif-title">{{ $data['website_name'] ?? 'Pemberitahuan System' }}</h4>
                    <p class="notif-desc">{{ $data['message'] ?? 'Status website telah diperbarui.' }}</p>
                    <span class="notif-time">{{ $notif->created_at->diffForHumans() }}</span>
                  </div>
                </a>

                <form action="{{ route('notifications.destroy', $notif->id) }}" method="POST" class="notif-delete-form">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="notif-delete-btn" title="Hapus Notifikasi"
                    onclick="event.stopPropagation();">
                    <svg viewBox="0 0 24 24">
                      <line x1="18" y1="6" x2="6" y2="18" />
                      <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                  </button>
                </form>
              </div>
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
  <button onclick="toggleMobileSidebar()"
    style="position: fixed; top: 12px; left: 12px; z-index: 98; background: #17231d; border: 1px solid var(--line); color: #fff; padding: 8px; border-radius: 8px; display: none; align-items: center; justify-content: center;"
    id="floatingMenuBtn">
    <svg style="width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24">
      <line x1="3" y1="12" x2="21" y2="12" />
      <line x1="3" y1="6" x2="21" y2="6" />
      <line x1="3" y1="18" x2="21" y2="18" />
    </svg>
  </button>

  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <!-- SIDEBAR NAVIGATION -->
  <aside id="sidebar">
    <div class="brand-area">
      <div class="brand-left">
        <div class="logo">
          <img src="{{ asset('img/logo.jpeg') }}" alt="Logo">
        </div>
        <div class="brand-text" style="transition: opacity 0.2s ease;">
          <h1 style="font-size: 13px; margin: 0; color: #ffffff; font-weight: 700; line-height: 1.2;">IT Solution</h1>
          <small style="font-size: 10px; color: #9ca3af; display: block; line-height: 1.2; margin-top: 0px;">Monitoring
            System</small>
        </div>
      </div>
      <button class="mobile-menu-btn" onclick="toggleMobileSidebar()">
        <svg style="width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24">
          <line x1="18" y1="6" x2="6" y2="18" />
          <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
      </button>
    </div>

    <div class="menu-list">
      <div class="menu-title">Menu Utama</div>

      <a href="{{ route('dashboard.index') }}"
        class="nav-item {{ request()->routeIs('dashboard.*') ? 'active' : '' }} menu-link">
        <svg viewBox="0 0 24 24">
          <rect x="3" y="3" width="7" height="7" />
          <rect x="14" y="3" width="7" height="7" />
          <rect x="14" y="14" width="7" height="7" />
          <rect x="3" y="14" width="7" height="7" />
        </svg>
        <span>Dashboard</span>
      </a>

      <a href="{{ route('websites.index') }}"
        class="nav-item {{ request()->routeIs('websites.*') ? 'active' : '' }} menu-link">
        <svg viewBox="0 0 24 24">
          <path
            d="M21 12a9 9 0 0 1-9 9m9-9a9 9 0 0 0-9-9m9 9H3m9 9a9 9 0 0 1-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 0 1 9-9" />
        </svg>
        <span>Websites</span>
      </a>

      <a href="{{ route('incidents.index') }}"
        class="nav-item {{ request()->routeIs('incidents.*') ? 'active' : '' }} menu-link">
        <svg viewBox="0 0 24 24">
          <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
          <line x1="12" y1="9" x2="12" y2="13" />
          <line x1="12" y1="17" x2="12.01" y2="17" />
        </svg>
        <span>Incidents & Errors</span>
      </a>

      @if(auth()->check() && in_array(auth()->user()->role, ['super_admin', 'viewer']))
        <a href="{{ route('analytics.index') }}"
          class="nav-item {{ request()->routeIs('analytics.*') ? 'active' : '' }} menu-link">
          <svg viewBox="0 0 24 24">
            <path d="M18 20V10M12 20V4M6 20v-6" />
          </svg>
          <span>Analytics</span>
        </a>
      @endif

      @if(auth()->check() && auth()->user()->role == 'super_admin')
        <a href="{{ route('settings.index') }}"
          class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }} menu-link">
          <svg viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="3" />
            <path
              d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l-.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06-.06a1.65 1.65 0 0 0-.33 1.82V9c.69 0 1.31.4 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09c-.2.6-.82 1-1.51 1z" />
          </svg>
          <span>Settings</span>
        </a>
      @endif

      @if(auth()->check() && auth()->user()->role == 'super_admin')
        <a href="{{ route('users.index') }}"
          class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }} menu-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
          </svg>
          <span>Manajemen User</span>
        </a>
      @endif
    </div>

    @if(auth()->check())
      <div class="user-profile-container" id="userProfileContainer">
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
      <svg id="toggleIcon" style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;"
        viewBox="0 0 24 24">
        <polyline points="15 18 9 12 15 6" />
      </svg>
    </div>
  </aside>

  <!-- POPUP MENU AKUN (DIPISAH KELUAR AGAR POSISI FIXED AMAN SAAT COLLAPSED) -->
  @if(auth()->check())
    <div class="user-popup-menu" id="userPopupMenu">
      <a href="{{ route('profile.index') }}" class="popup-item">
        <svg style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
          <circle cx="12" cy="7" r="4" />
        </svg>
        <span>Profil User</span>
      </a>

      <form action="{{ route('logout') }}" method="POST" class="logout-form">
        @csrf
        <button type="submit" class="popup-item danger">
          <svg style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            <polyline points="16 17 21 12 16 7" />
            <line x1="21" y1="12" x2="9" y2="12" />
          </svg>
          <span>Logout</span>
        </button>
      </form>
    </div>
  @endif

  <!-- SCRIPT PENGENDALI INTERAKSI NAVIGASI -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // 1. Notification Dropdown Logic
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

      // 2. Sidebar & Navigation Responsive Logic
      const sidebar = document.getElementById('sidebar');
      const sidebarToggle = document.getElementById('sidebarToggle');
      const toggleIcon = document.getElementById('toggleIcon');
      const userProfileBtn = document.getElementById('userProfileBtn');
      const userPopupMenu = document.getElementById('userPopupMenu');
      const sidebarOverlay = document.getElementById('sidebarOverlay');
      const floatingMenuBtn = document.getElementById('floatingMenuBtn');
      const topNavbar = document.querySelector('.top-navbar');

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
          document.body.classList.toggle('sidebar-is-collapsed');

          if (topNavbar) {
            if (sidebar.classList.contains('collapsed')) {
              topNavbar.style.left = '62px';
              topNavbar.style.width = 'calc(100% - 62px)';
            } else {
              topNavbar.style.left = '215px';
              topNavbar.style.width = 'calc(100% - 215px)';
            }
          }

          if (userPopupMenu) userPopupMenu.classList.remove('show');
          toggleIcon.innerHTML = sidebar.classList.contains('collapsed')
            ? '<polyline points="9 18 15 12 9 6"/>'
            : '<polyline points="15 18 9 12 15 6"/>';
        });
      }

      // 3. Dynamic User Profile Popup Menu Logic
      if (userProfileBtn && userPopupMenu) {
        userProfileBtn.addEventListener('click', (e) => {
          e.stopPropagation();

          const rect = userProfileBtn.getBoundingClientRect();

          if (sidebar.classList.contains('collapsed')) {
            userPopupMenu.style.position = 'fixed';
            userPopupMenu.style.left = '68px';
            userPopupMenu.style.bottom = '60px';
            userPopupMenu.style.width = '170px';
          } else {
            userPopupMenu.style.position = 'fixed';
            userPopupMenu.style.left = '12px';
            userPopupMenu.style.bottom = `${window.innerHeight - rect.top + 8}px`;
            userPopupMenu.style.width = '190px';
          }

          userPopupMenu.classList.toggle('show');
        });

        userPopupMenu.addEventListener('click', (e) => {
          e.stopPropagation();
        });

        window.addEventListener('click', () => {
          userPopupMenu.classList.remove('show');
        });
      }

      // 4. Mobile Drawer Handlers
      window.toggleMobileSidebar = function () {
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

</div>