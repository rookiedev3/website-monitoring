<!-- SIDEBAR -->
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
    
    <a href="#" class="nav-item active menu-link">
      <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      <span>Dashboard</span>
    </a>
    <a href="#" class="nav-item menu-link">
      <svg viewBox="0 0 24 24"><path d="M21 12a9 9 0 0 1-9 9m9-9a9 9 0 0 0-9-9m9 9H3m9 9a9 9 0 0 1-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 0 1 9-9"/></svg>
      <span>Website Management</span>
    </a>
    <a href="#" class="nav-item menu-link">
      <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      <span>Incidents & Errors</span>
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

  <!-- USER PROFILE SECTION (POPUP) -->
  <div class="user-profile-container">
    <div class="user-popup-menu" id="userPopupMenu">
      <button class="popup-item">
        <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Profil User
      </button>
      <button class="popup-item danger">
        <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Logout
      </button>
    </div>

    <button class="user-profile-btn" id="userProfileBtn" title="Akun">
      <div class="user-avatar">SA</div>
      <div class="user-info">
        <h4>Super Admin</h4>
        <p>admin@itsolution.com</p>
      </div>
    </button>
  </div>

  <!-- SIDEBAR TOGGLE BAR -->
  <div class="sidebar-toggle-bar" id="sidebarToggle">
    <span class="sidebar-toggle-text">Perkecil Sidebar</span>
    <svg id="toggleIcon" style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
  </div>
</aside>

<script>
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  const toggleIcon = document.getElementById('toggleIcon');
  const userProfileBtn = document.getElementById('userProfileBtn');
  const userPopupMenu = document.getElementById('userPopupMenu');
  const menuLinks = document.querySelectorAll('.menu-link');

  sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    userPopupMenu.classList.remove('show');
    if (sidebar.classList.contains('collapsed')) {
      toggleIcon.innerHTML = '<polyline points="9 18 15 12 9 6"/>';
    } else {
      toggleIcon.innerHTML = '<polyline points="15 18 9 12 15 6"/>';
    }
  });

  menuLinks.forEach(link => {
    link.addEventListener('click', () => {
      menuLinks.forEach(item => item.classList.remove('active'));
      link.classList.add('active');
      sidebar.classList.add('collapsed');
      userPopupMenu.classList.remove('show');
      toggleIcon.innerHTML = '<polyline points="9 18 15 12 9 6"/>';
    });
  });

  userProfileBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    userPopupMenu.classList.toggle('show');
  });

  window.addEventListener('click', () => {
    userPopupMenu.classList.remove('show');
  });
</script>