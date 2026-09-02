<!-- TOP NAVBAR KHUSUS NOTIFIKASI -->
<style>
  :root {
    --navbar-height: 60px;
    --navbar-bg: #16241d;
    --nav-border: #2e4a3b;
    --text-color: #fff;
    --muted-color: #9ca3af;
  }

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

  /* Navbar otomatis memanjang saat body memiliki kelas sidebar-is-collapsed */
  body.sidebar-is-collapsed .top-navbar {
    left: var(--sidebar-collapsed) !important;
  }

  /* Responsive Mobile Navbar */
  @media (max-width: 768px) {
    .top-navbar {
      left: 0 !important;
      padding-left: 55px;
      padding-right: 16px;
    }
  }

  /* Dropdown Container */
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

  /* Badge Unread Indicator */
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

  /* Dropdown Menu Box */
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

  /* Individual Notification Card */
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

  /* Status Indicator Dot */
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

  @media (max-width: 480px) {
    .notification-dropdown {
      width: 290px;
      right: -10px;
    }
  }
</style>

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

<script>
  document.addEventListener('DOMContentLoaded', () => {
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
  });
</script>