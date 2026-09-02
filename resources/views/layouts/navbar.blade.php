<!-- TOP NAVBAR KHUSUS NOTIFIKASI -->
<style>
  /* KUNCI UTAMA: Memaksa navbar menyesuaikan diri secara instan */
  header.top-navbar {
    position: fixed !important;
    top: 0 !important;
    right: 0 !important;
    left: 215px !important; /* Default saat sidebar lebar */
    width: calc(100% - 215px) !important;
    height: 60px !important;
    background: #16241d !important;
    border-bottom: 1px solid #2e4a3b !important;
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    padding: 0 24px !important;
    z-index: 90 !important;
    transition: left 0.3s ease, width 0.3s ease !important;
  }

  /* Jika body mendeteksi sidebar diperkecil, navbar otomatis melebar penuh */
  body.sidebar-is-collapsed header.top-navbar {
    left: 62px !important;
    width: calc(100% - 62px) !important;
  }

  /* Responsive Mobile Navbar */
  @media (max-width: 768px) {
    header.top-navbar {
      left: 0 !important;
      width: 100% !important;
      padding-left: 55px !important;
      padding-right: 16px !important;
    }
  }

  /* Dropdown & Komponen Pendukung */
  .notification-wrapper { position: relative; }
  .notification-btn {
    background: transparent; border: 1px solid #2e4a3b; color: #fff;
    width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center;
    justify-content: center; cursor: pointer; position: relative; transition: background 0.2s ease;
  }
  .notification-btn:hover { background: #1f3328; }
  .notification-badge {
    position: absolute; top: -4px; right: -4px; background: #ef4444; color: #fff;
    font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 10px; border: 2px solid #16241d; line-height: 1;
  }
  .notification-dropdown {
    position: absolute; top: 48px; right: 0; width: 340px; max-height: 420px;
    background: #17231d; border: 1px solid #2e4a3b; border-radius: 12px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5); display: none; flex-direction: column; overflow: hidden; z-index: 100;
  }
  .notification-dropdown.show { display: flex; }
  .notif-header { padding: 12px 16px; border-bottom: 1px solid #2e4a3b; display: flex; align-items: center; justify-content: space-between; }
  .notif-header h3 { font-size: 13px; margin: 0; color: #fff; font-weight: 700; }
  .mark-all-btn { font-size: 11px; color: #4ade80; background: none; border: none; cursor: pointer; text-decoration: none; }
  .mark-all-btn:hover { text-decoration: underline; }
  .notif-body { overflow-y: auto; flex: 1; }
  .notif-item-wrapper { position: relative; display: flex; align-items: center; border-bottom: 1px solid rgba(46, 74, 59, 0.5); transition: background 0.2s ease; }
  .notif-item-wrapper:hover { background: #1f3328; }
  .notif-item-wrapper.unread { background: rgba(24, 56, 40, 0.4); }
  .notif-item-wrapper .notif-item { flex: 1; border-bottom: none; padding-right: 36px; text-decoration: none; display: flex; gap: 12px; padding: 12px 16px 12px 12px; }
  .notif-icon-dot { width: 10px; height: 10px; border-radius: 50%; margin-top: 4px; flex-shrink: 0; }
  .notif-icon-dot.danger { background: #ef4444; box-shadow: 0 0 8px #ef4444; }
  .notif-icon-dot.success { background: #22c55e; box-shadow: 0 0 8px #22c55e; }
  .notif-content { flex: 1; overflow: hidden; }
  .notif-title { font-size: 12px; font-weight: 700; color: #fff; margin: 0 0 2px 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .notif-desc { font-size: 11px; color: #9ca3af; margin: 0 0 4px 0; line-height: 1.3; }
  .notif-time { font-size: 9px; color: #6b7280; }
  .notif-delete-form { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); margin: 0; z-index: 2; }
  .notif-delete-btn { background: transparent; border: none; color: #6b7280; width: 24px; height: 24px; border-radius: 6px; display: flex; align-items: center; justify-content: center; cursor: pointer; padding: 0; transition: all 0.2s ease; }
  .notif-delete-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
  .notif-delete-btn:hover { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
  .notif-empty { padding: 24px; text-align: center; color: #9ca3af; font-size: 12px; }
  @media (max-width: 480px) { .notification-dropdown { width: 290px; right: -10px; } }
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
                <button type="submit" class="notif-delete-btn" title="Hapus Notifikasi" onclick="event.stopPropagation();">
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

    // Tambahan pengaman script agar langsung mengupdate navbar secara real-time
    const sidebar = document.getElementById('sidebar');
    const topNavbar = document.querySelector('.top-navbar');
    const sidebarToggle = document.getElementById('sidebarToggle');

    if (sidebarToggle && topNavbar) {
      sidebarToggle.addEventListener('click', () => {
        setTimeout(() => {
          if (sidebar.classList.contains('collapsed')) {
            topNavbar.style.left = '62px';
            topNavbar.style.width = 'calc(100% - 62px)';
          } else {
            topNavbar.style.left = '215px';
            topNavbar.style.width = 'calc(100% - 215px)';
          }
        }, 10);
      });
    }
  });
</script>