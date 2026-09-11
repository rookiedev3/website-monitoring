<!-- NAV LAYOUT SCOPE WRAPPER -->
<div class="nav-layout-scope">

  <style>
    /* 1. LOCAL CSS RESET & VARIABLES (SIDEBAR GELAP ELEGANT, NAVBAR CLEAN WHITE & SOFT NEUTRAL) */
    .nav-layout-scope {
      --sidebar-width: 260px;
      --sidebar-collapsed: 80px;
      --navbar-height: 60px;
      
      --sidebar-bg: #0d1712;
      --navbar-bg: #ffffff;
      --card-hover: #f1f5f9;
      
      --nav-border: #e2e8f0;
      --line: #22382c;
      --text-color: #0f172a;
      --muted-color: #64748b;
      
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

    /* 2. TOP NAVBAR STYLES (CLEAN WHITE, MODERN, TIDAK KAKU) */
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
      box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }

    /* NOTIFICATION DROPDOWN STYLES */
    .nav-layout-scope .notification-wrapper {
      position: relative;
    }

    .nav-layout-scope .notification-btn {
      background: #013220;
      border: 1px solid #013220;
      color: #ffffff;
      width: 38px;
      height: 38px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      position: relative;
      transition: all 0.2s ease;
    }

    .nav-layout-scope .notification-btn:hover {
      background: #006B3F;
      border-color: #006B3F;
      color: #ffffff;
    }

    .nav-layout-scope .notification-badge {
      position: absolute;
      top: -4px;
      right: -4px;
      background: #dc2626;
      color: #fff;
      font-size: 10px;
      font-weight: 700;
      padding: 2px 6px;
      border-radius: 10px;
      border: 2px solid var(--navbar-bg);
      line-height: 1;
      transition: transform 0.2s ease;
    }

    @keyframes notifPulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.3); }
    }

    .nav-layout-scope .notification-badge.pulse {
      animation: notifPulse 0.4s ease 3;
    }

    .nav-layout-scope .notification-dropdown {
      position: absolute;
      top: 48px;
      right: 0;
      width: 340px;
      max-height: 420px;
      background: #ffffff;
      border: 1px solid var(--nav-border);
      border-radius: 12px;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
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
      background: #f8fafc;
    }

    .nav-layout-scope .notif-header h3 {
      font-size: 13px;
      margin: 0;
      color: var(--text-color);
      font-weight: 700;
    }

    .nav-layout-scope .mark-all-btn {
      font-size: 11px;
      color: #059669;
      background: none;
      border: none;
      cursor: pointer;
      text-decoration: none;
      font-weight: 700;
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
      border-bottom: 1px solid #f1f5f9;
      transition: background 0.2s ease;
    }

    .nav-layout-scope .notif-item-wrapper:hover {
      background: #f8fafc;
    }

    .nav-layout-scope .notif-item-wrapper.unread {
      background: #f0fdf4;
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
      background: #dc2626;
      box-shadow: 0 0 8px rgba(220, 38, 38, 0.3);
    }

    .nav-layout-scope .notif-icon-dot.success {
      background: #16a34a;
      box-shadow: 0 0 8px rgba(22, 163, 74, 0.3);
    }

    .nav-layout-scope .notif-content {
      flex: 1;
      overflow: hidden;
    }

    .nav-layout-scope .notif-title {
      font-size: 12px;
      font-weight: 700;
      color: var(--text-color);
      margin: 0 0 2px 0;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .nav-layout-scope .notif-desc {
      font-size: 11px;
      color: var(--muted-color);
      margin: 0 0 4px 0;
      line-height: 1.3;
    }

    .nav-layout-scope .notif-time {
      font-size: 9px;
      color: #94a3b8;
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
      color: #94a3b8;
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
      background: rgba(220, 38, 38, 0.1);
      color: #dc2626;
    }

    .nav-layout-scope .notif-empty {
      padding: 24px;
      text-align: center;
      color: var(--muted-color);
      font-size: 12px;
    }

    /* 3. SIDEBAR STYLES (TETAP HIJAU GELAP KESAYANGAN) */
    .nav-layout-scope aside#sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: var(--sidebar-width);
      background: var(--sidebar-bg);
      border-right: 1px solid var(--line);
      display: flex;
      flex-direction: column;
      z-index: 100;
      box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2);
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
      background: #1b2e25;
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
      background: rgba(0, 0, 0, 0.15);
    }

    .nav-layout-scope .brand-left {
      display: flex;
      align-items: center;
      gap: 12px;
      overflow: hidden;
    }

    .nav-layout-scope .brand-logo {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      overflow: hidden;
      border: 1px solid var(--line);
    }

    .nav-layout-scope .brand-logo img {
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
      line-height: 1.2;
    }

    .nav-layout-scope .brand-text small {
      font-size: 10px;
      color: #8fa394;
      display: block;
      line-height: 1.2;
      margin-top: 0px;
    }

    .nav-layout-scope .menu-list {
      flex: 1;
      padding: 12px 8px;
      overflow-y: auto;
      overflow-x: hidden;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .nav-layout-scope .menu-title {
      font-size: 9px;
      font-weight: 800;
      letter-spacing: .08em;
      color: #8fa394;
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
      padding: 9px 10px;
      border-radius: 8px;
      color: #8fa394;
      font-size: 12px;
      font-weight: 600;
      white-space: nowrap;
      cursor: pointer;
      text-decoration: none;
      transition: background 0.2s ease, color 0.2s ease;
    }

    .nav-layout-scope .nav-item:hover {
      background: #1b2e25;
      color: #fff;
    }

    .nav-layout-scope .nav-item.active {
      background: #143625;
      color: #4ade80;
      font-weight: 700;
      box-shadow: inset 3px 0 0 #4ade80;
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

    .nav-layout-scope aside#sidebar.collapsed .nav-item {
      justify-content: center;
    }

    .nav-layout-scope aside#sidebar.collapsed .nav-item span {
      display: none;
    }

    .nav-layout-scope .user-profile-container {
      position: relative;
      border-top: 1px solid var(--line);
      padding: 8px;
      background: rgba(0, 0, 0, 0.1);
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
      transition: background 0.2s ease;
    }

    .nav-layout-scope .user-profile-btn:hover {
      background: #1b2e25;
    }

    .nav-layout-scope .user-avatar {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: #1b3327;
      color: #4ade80;
      display: grid;
      place-items: center;
      font-weight: 700;
      font-size: 11px;
      flex-shrink: 0;
      border: 1px solid var(--line);
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
      color: #8fa394;
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

    .nav-layout-scope .user-popup-menu {
      position: absolute;
      bottom: 60px;
      left: 8px;
      right: 8px;
      background: #0d1712;
      border: 1px solid var(--line);
      border-radius: 10px;
      box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.4);
      display: none;
      flex-direction: column;
      overflow: hidden;
      z-index: 10;
    }

    .nav-layout-scope .user-popup-menu.show {
      display: flex;
    }

    .nav-layout-scope .popup-item {
      padding: 9px 12px;
      font-size: 11px;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 8px;
      background: transparent;
      border: none;
      cursor: pointer;
      text-align: left;
      width: 100%;
      text-decoration: none;
    }

    .nav-layout-scope .popup-item.danger {
      color: #ef4444;
    }

    .nav-layout-scope .popup-item:hover {
      background: #1b2e25;
      color: #fff;
    }

    /* COLLAPSED POPUP HANDLER */
    .nav-layout-scope aside#sidebar.collapsed .user-popup-menu {
      position: fixed !important;
      left: 88px !important;
      bottom: 60px !important;
      width: 52px !important;
      border-radius: 8px !important;
      padding: 4px 0 !important;
    }

    .nav-layout-scope aside#sidebar.collapsed .user-popup-menu span.popup-text {
      display: none !important;
    }

    .nav-layout-scope aside#sidebar.collapsed .user-popup-menu .popup-item {
      justify-content: center !important;
      padding: 10px 0 !important;
      width: 100% !important;
      gap: 0 !important;
    }

    .nav-layout-scope .sidebar-toggle-bar {
      border-top: 1px solid var(--line);
      padding: 8px 10px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
      background: rgba(0, 0, 0, 0.2);
      font-size: 10px;
      color: #8fa394;
      transition: background 0.2s ease, color 0.2s ease;
    }

    .nav-layout-scope .sidebar-toggle-bar:hover {
      background: #1b2e25;
      color: #fff;
    }

    .nav-layout-scope aside#sidebar.collapsed .sidebar-toggle-text {
      display: none;
    }

    .nav-layout-scope aside#sidebar.collapsed .sidebar-toggle-bar {
      justify-content: center;
    }

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

    /* MEDIA QUERIES */
    @media (max-width: 768px) {
      .nav-layout-scope .top-navbar {
        left: 0 !important;
        width: 100% !important;
        padding-left: 55px;
      }

      .nav-layout-scope .mobile-menu-btn {
        display: block;
        color: var(--text-color);
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
    @if(auth()->check() && in_array(auth()->user()->role, ['super_admin', 'programmer', 'viewer']))
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
            <span class="notification-badge" id="notifBadge">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
          @endif
        </button>

        <div class="notification-dropdown" id="notifDropdownMenu">
          <div class="notif-header">
            <h3>Notifikasi Gangguan</h3>
            <div id="notifMarkAllWrapper">
              @if($unreadCount > 0)
                <form action="{{ route('notifications.markAllRead') }}" method="POST" id="notifMarkAllForm" style="margin:0;">
                  @csrf
                  <button type="submit" class="mark-all-btn">Tandai Dibaca</button>
                </form>
              @endif
            </div>
          </div>

          <div class="notif-body" id="notifBody">
            @forelse($notifications as $notif)
              @php
                $data = $notif->data;
                $isUnread = is_null($notif->read_at);
                $colorClass = $data['color'] ?? (($data['type'] ?? '') === 'website_down' ? 'danger' : 'success');
                $targetUrl = !empty($data['incident_id'])
                  ? route('incidents.show', $data['incident_id'])
                  : ($data['action_url'] ?? route('incidents.index'));
              @endphp

              <div class="notif-item-wrapper {{ $isUnread ? 'unread' : '' }}" data-id="{{ $notif->id }}">
                <a href="{{ route('notifications.readAndRedirect', [$notif->id, 'redirect' => $targetUrl]) }}"
                  class="notif-item">
                  <span class="notif-icon-dot {{ $colorClass }}"></span>
                  <div class="notif-content">
                    <h4 class="notif-title">{{ $data['website_name'] ?? 'Pemberitahuan System' }}</h4>
                    <p class="notif-desc">{{ $data['message'] ?? 'Status website telah diperbarui.' }}</p>
                    <span class="notif-time">{{ $notif->created_at->diffForHumans() }}</span>
                  </div>
                </a>

                <form action="{{ route('notifications.destroy', $notif->id) }}" method="POST" class="notif-delete-form" data-id="{{ $notif->id }}">
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
    style="position: fixed; top: 12px; left: 12px; z-index: 98; background: #ffffff; border: 1px solid var(--nav-border); color: var(--text-color); padding: 8px; border-radius: 8px; display: none; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05);"
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
        <div class="brand-logo">
          <img src="{{ asset('img/logo.jpeg') }}" alt="Logo">
        </div>
        <div class="brand-text" style="transition: opacity 0.2s ease;">
          <h1 style="font-size: 13px; margin: 0; color: #ffffff; font-weight: 700; line-height: 1.2;">IT Solution</h1>
          <small style="font-size: 10px; color: #8fa394; display: block; line-height: 1.2; margin-top: 0px;">Monitoring
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
      <div class="user-profile-container">
        <div class="user-popup-menu" id="userPopupMenu">
          <a href="{{ route('profile.index') }}" class="popup-item" title="Profil User">
            <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
              <circle cx="12" cy="7" r="4" />
            </svg>
            <span class="popup-text">Profil User</span>
          </a>
          <form action="{{ route('logout') }}" method="POST" style="margin:0; padding:0;">
            @csrf
            <button type="submit" class="popup-item danger" title="Logout"
              style="border:none; background:transparent; font-family:inherit; cursor:pointer;">
              <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                <polyline points="16 17 21 12 16 7" />
                <line x1="21" y1="12" x2="9" y2="12" />
              </svg>
              <span class="popup-text">Logout</span>
            </button>
          </form>
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
      <svg id="toggleIcon" style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;"
        viewBox="0 0 24 24">
        <polyline points="15 18 9 12 15 6" />
      </svg>
    </div>
  </aside>

  <!-- SCRIPT PENGENDALI INTERAKSI NAVIGASI & KONTEN MAIN -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const notifBtn = document.getElementById('notifDropdownBtn');
      const notifMenu = document.getElementById('notifDropdownMenu');
      const mainContent = document.querySelector('main');

      // Mengatur transisi dan langsung memberikan padding kiri yang lebih lega sejak halaman dimuat
      if (mainContent) {
        mainContent.style.transition = 'margin-left 0.3s ease, width 0.3s ease, padding-left 0.3s ease, padding-right 0.3s ease';
        mainContent.style.paddingLeft = '24px'; // Jarak lebih lega dari sidebar
        mainContent.style.paddingRight = '24px';
      }

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

        const csrfToken = "{{ csrf_token() }}";
        const notifBody = document.getElementById('notifBody');
        const notifMarkAllWrapper = document.getElementById('notifMarkAllWrapper');
        let lastNotifSignature = '';
        let currentUnreadCount = {{ $unreadCount ?? 0 }};

        function escapeHtml(text) {
          if (!text) return '';
          return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
        }

        function updateBadge(count) {
          let badge = document.getElementById('notifBadge');
          if (count > 0) {
            const text = count > 99 ? '99+' : String(count);
            if (!badge) {
              badge = document.createElement('span');
              badge.className = 'notification-badge';
              badge.id = 'notifBadge';
              notifBtn.appendChild(badge);
            }
            badge.textContent = text;
            badge.style.display = '';

            if (count > currentUnreadCount) {
              badge.classList.remove('pulse');
              void badge.offsetWidth;
              badge.classList.add('pulse');
            }
          } else if (badge) {
            badge.style.display = 'none';
          }
          currentUnreadCount = count;
        }

        function updateMarkAllButton(count) {
          if (!notifMarkAllWrapper) return;
          if (count > 0) {
            if (!document.getElementById('notifMarkAllForm')) {
              notifMarkAllWrapper.innerHTML = `
                <form action="{{ route('notifications.markAllRead') }}" method="POST" id="notifMarkAllForm" style="margin:0;">
                  <input type="hidden" name="_token" value="${csrfToken}">
                  <button type="submit" class="mark-all-btn">Tandai Dibaca</button>
                </form>
              `;
            }
          } else {
            notifMarkAllWrapper.innerHTML = '';
          }
        }

        function renderNotifications(items) {
          if (!notifBody) return;
          if (!items || items.length === 0) {
            notifBody.innerHTML = '<div class="notif-empty">Tidak ada notifikasi saat ini.</div>';
            return;
          }

          let html = '';
          items.forEach(notif => {
            html += `
              <div class="notif-item-wrapper ${notif.is_unread ? 'unread' : ''}" data-id="${escapeHtml(notif.id)}">
                <a href="${notif.read_url}" class="notif-item">
                  <span class="notif-icon-dot ${escapeHtml(notif.color)}"></span>
                  <div class="notif-content">
                    <h4 class="notif-title">${escapeHtml(notif.title)}</h4>
                    <p class="notif-desc">${escapeHtml(notif.message)}</p>
                    <span class="notif-time">${escapeHtml(notif.time_ago)}</span>
                  </div>
                </a>
                <form action="${notif.delete_url}" method="POST" class="notif-delete-form" data-id="${escapeHtml(notif.id)}">
                  <input type="hidden" name="_token" value="${csrfToken}">
                  <input type="hidden" name="_method" value="DELETE">
                  <button type="submit" class="notif-delete-btn" title="Hapus Notifikasi" onclick="event.stopPropagation();">
                    <svg viewBox="0 0 24 24">
                      <line x1="18" y1="6" x2="6" y2="18" />
                      <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                  </button>
                </form>
              </div>
            `;
          });
          notifBody.innerHTML = html;
        }

        function fetchNotifications() {
          fetch("{{ route('api.notifications.index') }}", {
            headers: {
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(res => {
            if (!res.ok) return null;
            return res.json();
          })
          .then(data => {
            if (!data) return;
            updateBadge(data.unread_count);
            updateMarkAllButton(data.unread_count);

            const signature = (data.unread_count || 0) + '_' + (data.notifications || []).map(n => n.id).join('-');
            if (signature !== lastNotifSignature) {
              lastNotifSignature = signature;
              renderNotifications(data.notifications);
            }
          })
          .catch(err => {
            console.warn('Gagal memuat notifikasi real-time:', err);
          });
        }

        if (notifBody) {
          notifBody.addEventListener('submit', function(e) {
            const form = e.target.closest('.notif-delete-form');
            if (!form) return;

            e.preventDefault();
            e.stopPropagation();

            const itemWrapper = form.closest('.notif-item-wrapper');
            const deleteUrl = form.action;

            fetch(deleteUrl, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
              }
            })
            .then(res => res.json())
            .then(result => {
              if (result.status === 'success') {
                if (itemWrapper) {
                  itemWrapper.style.transition = 'all 0.2s ease';
                  itemWrapper.style.opacity = '0';
                  itemWrapper.style.transform = 'translateX(20px)';
                  setTimeout(() => {
                    itemWrapper.remove();
                    const remaining = notifBody.querySelectorAll('.notif-item-wrapper');
                    if (remaining.length === 0) {
                      notifBody.innerHTML = '<div class="notif-empty">Tidak ada notifikasi saat ini.</div>';
                      updateMarkAllButton(0);
                      updateBadge(0);
                    } else {
                      const badge = document.getElementById('notifBadge');
                      if (badge && badge.style.display !== 'none') {
                        let count = parseInt(badge.textContent, 10);
                        if (!isNaN(count) && count > 0) {
                          updateBadge(count - 1);
                        }
                      }
                    }
                    lastNotifSignature = '';
                  }, 200);
                }
              }
            })
            .catch(err => console.error('Error saat menghapus notifikasi:', err));
          });
        }

        if (notifMarkAllWrapper) {
          notifMarkAllWrapper.addEventListener('submit', function(e) {
            const form = e.target.closest('#notifMarkAllForm');
            if (!form) return;

            e.preventDefault();
            e.stopPropagation();

            fetch(form.action, {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
              }
            })
            .then(res => res.json())
            .then(result => {
              if (result.status === 'success') {
                updateBadge(0);
                updateMarkAllButton(0);
                if (notifBody) {
                  notifBody.innerHTML = '<div class="notif-empty">Tidak ada notifikasi saat ini.</div>';
                }
                lastNotifSignature = '';
              }
            })
            .catch(err => console.error('Error tandai semua dibaca:', err));
          });
        }

        setInterval(fetchNotifications, 5000);
      }

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
          const isCollapsed = sidebar.classList.contains('collapsed');

          if (topNavbar) {
            topNavbar.style.left = isCollapsed ? '80px' : '260px';
            topNavbar.style.width = isCollapsed ? 'calc(100% - 80px)' : 'calc(100% - 260px)';
          }

          if (mainContent) {
            mainContent.style.marginLeft = isCollapsed ? '80px' : '260px';
            mainContent.style.width = isCollapsed ? 'calc(100% - 80px)' : 'calc(100% - 260px)';
            mainContent.style.paddingLeft = '24px';
            mainContent.style.paddingRight = '24px';
          }

          if (userPopupMenu) userPopupMenu.classList.remove('show');
          
          toggleIcon.innerHTML = isCollapsed
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