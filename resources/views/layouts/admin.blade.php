<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Admin') — HyperEdge Academy</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800;900&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;0,9..40,900;1,9..40,300;1,9..40,400;1,9..40,500;1,9..40,600;1,9..40,700;1,9..40,800;1,9..40,900&family=JetBrains+Mono:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
strong, b { font-weight: 700 !important; }

:root {
  /* Palette: Ivory + Deep Navy + Gold */
  --bg:          #f9f8f5;
  --surface:     #ffffff;
  --surface2:    #f3f2ee;
  --surface3:    #eae9e3;

  --ink:         #0d1117;
  --ink2:        #1e2530;
  --ink3:        #4a5568;
  --muted:       #8896a7;
  --muted2:      #c8d0da;

  --border:      #e2e0d8;
  --border2:     #cccab8;

  --navy:        #0d1f3c;
  --navy2:       #162d52;
  --navy3:       #1e3a69;
  --navy-light:  #eef2f9;

  --gold:        #c9972a;
  --gold2:       #dba94b;
  --gold-light:  #fdf6e3;
  --gold-border: rgba(201,151,42,0.25);

  --red:         #c0392b;
  --red-light:   #fdf0ee;
  --red-border:  rgba(192,57,43,0.2);

  --green:       #1a6b42;
  --green-light: #ecfdf5;
  --green-border:rgba(26,107,66,0.2);

  --amber:       #92560a;
  --amber-light: #fffbeb;
  --amber-border:rgba(146,86,10,0.2);

  --sidebar-w:   252px;
  --r:           8px;
  --r-lg:        12px;
}

html, body { height:100%; background:var(--bg); color:var(--ink); font-family:'DM Sans',sans-serif; }
body { display:flex; min-height:100vh; }

/* ── SIDEBAR ──────────────────────────────── */
.sidebar {
  width: var(--sidebar-w);
  background: var(--navy);
  display: flex;
  flex-direction: column;
  position: fixed;
  top: 0; left: 0; bottom: 0;
  z-index: 100;
}

.sidebar-logo {
  padding: 24px 20px 20px;
  border-bottom: 1px solid rgba(255,255,255,0.06);
  display: flex;
  align-items: center;
  gap: 12px;
  text-decoration: none;
}
.logo-sq {
  width: 32px; height: 32px;
  border-radius: 7px;
  overflow: hidden;
  flex-shrink: 0;
}
.logo-sq img { width:100%; height:100%; object-fit:cover; }
.logo-text {
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
  font-weight: 800;
  color: #fff;
  letter-spacing: -0.03em;
  flex: 1;
}
.admin-chip {
  font-size: 8px;
  font-weight: 700;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--gold2);
  background: rgba(201,151,42,0.12);
  border: 1px solid rgba(201,151,42,0.2);
  padding: 3px 7px;
  border-radius: 4px;
}

.sys-bar {
  padding: 10px 20px;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  display: flex;
  align-items: center;
  gap: 8px;
}
.sys-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: #22c55e;
  box-shadow: 0 0 5px rgba(34,197,94,0.5);
  animation: pulse 2.5s infinite;
}
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }
.sys-label {
  font-size: 10px;
  font-weight: 500;
  letter-spacing: 0.5px;
  color: rgba(255,255,255,0.25);
}
.sys-label span { color: rgba(255,255,255,0.5); }

.sidebar-nav { flex:1; padding:12px; overflow-y:auto; }
.sidebar-nav::-webkit-scrollbar { display:none; }

.nav-section {
  font-size: 8px;
  font-weight: 700;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  color: rgba(255,255,255,0.18);
  padding: 0 8px;
  margin: 18px 0 5px;
}
.nav-section:first-child { margin-top: 4px; }

.nav-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 8px 10px;
  border-radius: var(--r);
  margin-bottom: 1px;
  color: rgba(255,255,255,0.38);
  font-size: 13px;
  font-weight: 400;
  text-decoration: none;
  transition: all 0.15s;
  position: relative;
}
.nav-item:hover { background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.75); }
.nav-item.active {
  background: rgba(201,151,42,0.1);
  color: var(--gold2);
  border: 1px solid rgba(201,151,42,0.15);
}
.nav-icon {
  width: 24px; height: 24px;
  display: flex; align-items: center; justify-content: center;
  font-size: 13px;
  flex-shrink: 0;
  opacity: 0.7;
}
.nav-item.active .nav-icon { opacity: 1; }
.nav-count {
  margin-left: auto;
  font-family: 'JetBrains Mono', monospace;
  font-size: 10px;
  color: rgba(255,255,255,0.18);
  background: rgba(255,255,255,0.05);
  padding: 1px 7px;
  border-radius: 20px;
}
.nav-item.active .nav-count { color: var(--gold2); opacity: 0.6; }

.sidebar-user {
  padding: 12px;
  border-top: 1px solid rgba(255,255,255,0.06);
}
.user-card {
  padding: 10px 12px;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: var(--r);
  margin-bottom: 8px;
}
.u-name { font-size: 13px; font-weight: 600; color: #fff; letter-spacing: -0.01em; margin-bottom: 2px; }
.u-role { font-size: 9px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--gold2); }
.logout-btn {
  display: flex; align-items: center; gap: 8px;
  width: 100%;
  padding: 8px 10px;
  background: none;
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: var(--r);
  cursor: pointer;
  font-size: 12px;
  font-weight: 500;
  color: rgba(255,255,255,0.22);
  font-family: 'DM Sans', sans-serif;
  transition: all 0.2s;
  letter-spacing: 0.1px;
}
.logout-btn:hover { border-color: rgba(192,57,43,0.35); color: #f87171; }

/* ── MAIN ─────────────────────────────────── */
.main {
  margin-left: 252px; /* Absolute explicit pixel fallback */
  margin-left: var(--sidebar-w);
  width: calc(100% - 252px);
  width: calc(100% - var(--sidebar-w));
  flex:1;
  display:flex;
  flex-direction:column;
  min-height:100vh;
  min-width: 0;
}

.topbar-wrapper {
  position: sticky;
  top: 0;
  z-index: 40;
  width: 100%;
  transition: transform 0.3s ease-in-out;
}

.topbar {
  padding: 0 32px;
  height: 54px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: var(--surface);
  animation: slideDown 0.4s ease;
}
@keyframes slideDown { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:none} }

.topbar-left { display:flex; align-items:center; gap:14px; }
.topbar-eyebrow {
  font-size: 9px;
  font-weight: 700;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  color: var(--gold);
  padding-right: 14px;
  border-right: 1px solid var(--border2);
}
.topbar-title {
  font-size: 13px;
  font-weight: 600;
  color: var(--ink);
  letter-spacing: -0.01em;
}
.topbar-right { display:flex; align-items:center; gap:8px; }
.tbar-date {
  font-family: 'JetBrains Mono', monospace;
  font-size: 10px;
  color: var(--muted);
  background: var(--surface2);
  border: 1px solid var(--border);
  padding: 5px 12px;
  border-radius: 20px;
}

/* Buttons */
.btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  border-radius: var(--r);
  font-size: 12px;
  font-weight: 600;
  font-family: 'DM Sans', sans-serif;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.18s;
  border: 1px solid;
  letter-spacing: -0.01em;
  white-space: nowrap;
}
.btn-primary {
  background: var(--navy);
  color: #fff;
  border-color: var(--navy);
}
.btn-primary:hover { background: var(--navy2); border-color: var(--navy2); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(13,31,60,0.18); }
.btn-ghost {
  background: var(--surface2);
  color: var(--ink3);
  border-color: var(--border);
}
.btn-ghost:hover { background: var(--surface3); border-color: var(--border2); }
.btn-gold {
  background: var(--gold);
  color: #fff;
  border-color: var(--gold);
}
.btn-gold:hover { background: var(--gold2); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(201,151,42,0.25); }
.btn-danger {
  background: var(--red-light);
  color: var(--red);
  border-color: var(--red-border);
}
.btn-danger:hover { background: #f8d7d3; }
.btn-sm { padding: 5px 11px; font-size: 11px; }
.btn-icon { padding: 7px 10px; }

/* Page */
.page { padding: 32px; animation: fadeUp 0.5s ease; }
@keyframes fadeUp { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:none} }

/* ── REUSABLE COMPONENTS ──────────────────── */

/* Badges */
.badge {
  display: inline-block;
  padding: 2px 9px;
  border-radius: 20px;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.3px;
  text-transform: uppercase;
  border: 1px solid;
}
.badge-active   { background:var(--green-light);  color:var(--green);  border-color:var(--green-border); }
.badge-inactive { background:var(--red-light);    color:var(--red);    border-color:var(--red-border); }
.badge-pending  { background:var(--amber-light);  color:var(--amber);  border-color:var(--amber-border); }
.badge-valid    { background:var(--navy-light);   color:var(--navy3);  border-color:rgba(13,31,60,0.15); }
.badge-used     { background:var(--surface2);     color:var(--muted);  border-color:var(--border); }

/* Card */
.card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--r-lg);
  overflow: hidden;
}
.card-head {
  padding: 18px 22px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.card-title {
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  font-weight: 700;
  color: var(--ink);
  letter-spacing: -0.02em;
}
.card-sub { font-size: 11px; color: var(--muted); margin-top: 2px; }

/* ── SECTION TITLE ───────────────────────── */
.section-title {
  font-family: 'DM Sans', sans-serif;
  font-size: 18px;
  font-weight: 800;
  color: var(--ink);
  letter-spacing: -0.02em;
  margin-bottom: 20px;
}

/* Table */
table { width:100%; border-collapse:collapse; font-size:12.5px; }
th {
  padding: 10px 22px;
  text-align: left;
  font-size: 9px;
  font-weight: 700;
  letter-spacing: 1.8px;
  text-transform: uppercase;
  color: var(--muted2);
  border-bottom: 1px solid var(--border);
}
td {
  padding: 12px 22px;
  color: var(--ink3);
  border-bottom: 1px solid var(--border);
  vertical-align: middle;
}
tr:last-child td { border-bottom: none; }
tr:hover td { background: var(--bg); }
.td-actions { display:flex; gap:6px; }

/* Alerts */
.alert { padding:11px 16px; border-radius:var(--r); font-size:13px; margin-bottom:16px; border:1px solid; }
.alert-success { background:var(--green-light); border-color:var(--green-border); color:var(--green); }
.alert-error   { background:var(--red-light);   border-color:var(--red-border);   color:var(--red); }
</style>
</head>
<body>

<aside class="sidebar">
  <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
    <div class="logo-sq"><img src="{{ asset('logo/hyperlogo.jpg') }}" alt="HyperEdge"></div>
    <div class="logo-text">HyperEdge</div>
    <span class="admin-chip">Admin</span>
  </a>

  <div class="sys-bar">
    <div class="sys-dot"></div>
    <div class="sys-label">System <span>Operational</span></div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section">Overview</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <div class="nav-icon">⊞</div> Dashboard
    </a>

    <div class="nav-section">Manage</div>
    <a href="{{ route('admin.teachers.index') }}" class="nav-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
      <div class="nav-icon">👨‍🏫</div> Facilitators
    </a>
    <a href="{{ route('admin.students.index') }}" class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
      <div class="nav-icon">🎓</div> Students
    </a>
    <a href="{{ route('admin.vouchers.index') }}" class="nav-item {{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}">
      <div class="nav-icon">🎟️</div> Vouchers
    </a>
  </nav>

  <div class="sidebar-user">
    <div class="user-card">
      <div class="u-name">{{ Auth::user()->full_name }}</div>
      <div class="u-role">Super Admin</div>
    </div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout-btn">↩ Sign out</button>
    </form>
  </div>
</aside>

<main class="main">
  <div class="topbar-wrapper">
    <div class="topbar">
      <div class="topbar-left">
        <div class="topbar-eyebrow">Admin Panel</div>
        <div class="topbar-title">HyperEdge Academy — Control Center</div>
      </div>
      <div class="topbar-right">
        <div class="tbar-date">{{ now()->format('D · M j · Y') }}</div>
        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-ghost">🎟️ Vouchers</a>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">+ Add Facilitator</a>
      </div>
    </div>
  </div>

  <div class="page">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error') || $errors->any())
      <div class="alert alert-error">{{ session('error') ?? $errors->first() }}</div>
    @endif
    @yield('content')
  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
  let lastScrollTop = 0;
  const topbarWrapper = document.querySelector('.topbar-wrapper');
  if (topbarWrapper) {
    window.addEventListener('scroll', () => {
      let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      if (scrollTop > lastScrollTop && scrollTop > 54) {
        // Scrolling DOWN -> Hide Topbar smoothly
        topbarWrapper.style.transition = 'transform 0.3s ease-in-out';
        topbarWrapper.style.transform = 'translateY(-100%)';
      } else if (scrollTop < lastScrollTop) {
        // Scrolling UP -> Reveal Topbar snappily
        topbarWrapper.style.transition = 'transform 0.15s ease-out';
        topbarWrapper.style.transform = 'translateY(0)';
      }
      lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    }, { passive: true });
  }
});
</script>

</body>
</html>