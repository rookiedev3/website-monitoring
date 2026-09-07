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

      const csrfToken = "{{ csrf_token() }}";
      const notifBody = document.getElementById('notifBody');
      const notifMarkAllWrapper = document.getElementById('notifMarkAllWrapper');
      let lastNotifSignature = '';

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
        } else if (badge) {
          badge.style.display = 'none';
        }
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

      // AJAX Hapus Notifikasi
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

      // AJAX Tandai Semua Dibaca
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

      // Polling setiap 5 detik
      setInterval(fetchNotifications, 5000);
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