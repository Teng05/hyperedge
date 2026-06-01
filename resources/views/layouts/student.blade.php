<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Student') — HyperEdge Academy</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Inter:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<style>
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}

:root {
  --bg:           #f8f7f4;
  --surface:      #ffffff;
  --surface2:     #f2f1ed;
  --surface3:     #e9e8e2;

  --ink:          #111318;
  --ink2:         #1f2430;
  --ink3:         #475569;
  --muted:        #8b99af;
  --muted2:       #c4cdd8;

  --border:       #e3e1d9;
  --border2:      #cac8b8;

  --charcoal:     #1a2233;
  --charcoal2:    #243049;

  --indigo:       #4f46e5;
  --indigo2:      #4338ca;
  --indigo3:      #818cf8;
  --indigo-light: #eef2ff;
  --indigo-border:rgba(79,70,229,0.18);

  --green:        #16a34a;
  --green-light:  #f0fdf4;
  --green-border: rgba(22,163,74,0.18);

  --amber:        #d97706;
  --amber-light:  #fffbeb;
  --amber-border: rgba(217,119,6,0.18);

  --red:          #dc2626;
  --red-light:    #fef2f2;
  --red-border:   rgba(220,38,38,0.18);

  --sidebar-w:    252px;
  --r:            8px;
  --r-lg:         12px;

  --font-display: 'Plus Jakarta Sans', sans-serif;
  --font-body:    'Inter', sans-serif;
  --font-mono:    'JetBrains Mono', monospace;
}

html, body {
  height: 100%;
  background: var(--bg);
  color: var(--ink);
  font-family: var(--font-body);
  -webkit-font-smoothing: antialiased;
}
body { display:flex; min-height:100vh; }

/* ── SIDEBAR ──────────────────────────────── */
.sidebar {
  width: var(--sidebar-w);
  background: var(--charcoal);
  display: flex;
  flex-direction: column;
  position: fixed;
  top: 0; left: 0; bottom: 0;
  z-index: 100;
}

.sidebar-logo {
  padding: 22px 18px 18px;
  border-bottom: 1px solid rgba(255,255,255,0.06);
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
}
.logo-icon {
  width: 30px; height: 30px;
  border-radius: 7px;
  overflow: hidden;
  flex-shrink: 0;
}
.logo-icon img { width:100%; height:100%; object-fit:cover; }
.logo-text {
  font-family: var(--font-display);
  font-size: 14px;
  font-weight: 700;
  color: #fff;
  letter-spacing: -0.02em;
  flex: 1;
}
.student-chip {
  font-family: var(--font-body);
  font-size: 8px;
  font-weight: 600;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--indigo3);
  background: rgba(79,70,229,0.12);
  border: 1px solid rgba(79,70,229,0.2);
  padding: 3px 7px;
  border-radius: 4px;
}

.sidebar-user {
  padding: 14px;
  border-bottom: 1px solid rgba(255,255,255,0.06);
}
.user-row { display:flex; align-items:center; gap:10px; }
.user-av {
  width: 36px; height: 36px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--indigo), var(--indigo3));
  display: flex; align-items: center; justify-content: center;
  font-family: var(--font-display);
  font-size: 12px;
  font-weight: 700;
  color: #fff;
  flex-shrink: 0;
}
.user-name {
  font-family: var(--font-display);
  font-size: 13px;
  font-weight: 600;
  color: #fff;
  letter-spacing: -0.01em;
}
.user-role {
  font-size: 9px;
  color: var(--indigo3);
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
  margin-top: 2px;
}

.sidebar-progress {
  padding: 12px 14px;
  border-bottom: 1px solid rgba(255,255,255,0.06);
}
.sp-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 6px;
}
.sp-label {
  font-size: 9px;
  font-weight: 600;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: rgba(255,255,255,0.25);
}
.sp-pct {
  font-family: var(--font-mono);
  font-size: 10px;
  color: var(--indigo3);
  font-weight: 600;
}
.sp-track {
  height: 3px;
  background: rgba(255,255,255,0.08);
  border-radius: 2px;
  overflow: hidden;
}
.sp-fill {
  height: 100%;
  background: var(--indigo3);
  border-radius: 2px;
  transition: width 1.2s cubic-bezier(0.4,0,0.2,1);
}

.sidebar-nav { flex:1; padding:10px; overflow-y:auto; }
.sidebar-nav::-webkit-scrollbar { display:none; }

.nav-section {
  font-size: 8px;
  font-weight: 600;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: rgba(255,255,255,0.18);
  padding: 0 8px;
  margin: 16px 0 4px;
}
.nav-section:first-child { margin-top: 4px; }

.nav-item {
  display: flex;
  align-items: center;
  gap: 9px;
  padding: 8px 10px;
  border-radius: var(--r);
  margin-bottom: 1px;
  color: rgba(255,255,255,0.38);
  font-size: 13px;
  font-weight: 400;
  text-decoration: none;
  transition: all 0.15s;
  font-family: var(--font-body);
}
.nav-item:hover { background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.75); }
.nav-item.active {
  background: rgba(79,70,229,0.14);
  color: var(--indigo3);
  border: 1px solid rgba(79,70,229,0.18);
}

.sidebar-footer {
  padding: 12px;
  border-top: 1px solid rgba(255,255,255,0.06);
}
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
  font-family: var(--font-body);
  transition: all 0.2s;
}
.logout-btn:hover { border-color: rgba(220,38,38,0.35); color: #f87171; }

/* ── MAIN ─────────────────────────────────── */
.main { margin-left: var(--sidebar-w); flex:1; display:flex; flex-direction:column; min-height:100vh; }

.topbar {
  padding: 0 32px;
  height: 54px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: var(--surface);
  position: sticky;
  top: 0;
  z-index: 40;
  animation: slideDown 0.4s ease;
}
@keyframes slideDown { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:none} }

.topbar-crumb {
  font-size: 12px;
  color: var(--muted);
  font-family: var(--font-body);
}
.topbar-crumb span { color: var(--ink); font-weight: 500; }

.topbar-right { display:flex; align-items:center; gap:8px; }
.tbar-date {
  font-family: var(--font-mono);
  font-size: 10px;
  color: var(--muted);
  background: var(--surface2);
  border: 1px solid var(--border);
  padding: 5px 12px;
  border-radius: 20px;
}

/* ── BUTTONS ──────────────────────────────── */
.btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  border-radius: var(--r);
  font-size: 12px;
  font-weight: 600;
  font-family: var(--font-body);
  text-decoration: none;
  cursor: pointer;
  transition: all 0.18s;
  border: 1px solid;
  white-space: nowrap;
}
.btn-primary {
  background: var(--indigo);
  color: #fff;
  border-color: var(--indigo);
}
.btn-primary:hover { background: var(--indigo2); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(79,70,229,0.22); }
.btn-ghost {
  background: var(--surface2);
  color: var(--ink3);
  border-color: var(--border);
}
.btn-ghost:hover { background: var(--surface3); border-color: var(--border2); }
.btn-sm { padding: 5px 11px; font-size: 11px; }

.page { padding: 32px; animation: fadeUp 0.5s ease; }
@keyframes fadeUp { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:none} }

/* ── REUSABLE ─────────────────────────────── */
.badge {
  display: inline-block;
  padding: 2px 9px;
  border-radius: 20px;
  font-size: 10px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.3px;
  border: 1px solid;
  font-family: var(--font-body);
}
.badge-done    { background:var(--green-light);  color:var(--green);  border-color:var(--green-border); }
.badge-open    { background:var(--indigo-light); color:var(--indigo); border-color:var(--indigo-border); }
.badge-locked  { background:var(--surface2);     color:var(--muted);  border-color:var(--border); }
.badge-voucher { background:var(--amber-light);  color:var(--amber);  border-color:var(--amber-border); }

.alert { padding:11px 16px; border-radius:var(--r); font-size:13px; margin-bottom:16px; border:1px solid; }
.alert-success { background:var(--green-light); border-color:var(--green-border); color:var(--green); }
.alert-error   { background:var(--red-light);   border-color:var(--red-border);   color:var(--red); }
</style>
</head>
<body>

<aside class="sidebar">
  <a href="{{ route('student.dashboard') }}" class="sidebar-logo">
    <div class="logo-icon"><img src="{{ asset('logo/hyperlogo.jpg') }}" alt="HyperEdge"></div>
    <div class="logo-text">HyperEdge</div>
    <span class="student-chip">Student</span>
  </a>

  <div class="sidebar-user">
    <div class="user-row">
      <div class="user-av">{{ strtoupper(substr(Auth::user()->first_name, 0, 1) . substr(Auth::user()->last_name, 0, 1)) }}</div>
      <div>
        <div class="user-name">{{ Auth::user()->full_name }}</div>
        <div class="user-role">HTML Track</div>
      </div>
    </div>
  </div>

  @php $progressPct = session('student_progress_pct', 0); @endphp
  <div class="sidebar-progress">
    <div class="sp-row">
      <span class="sp-label">Progress</span>
      <span class="sp-pct">{{ $progressPct }}%</span>
    </div>
    <div class="sp-track">
      <div class="sp-fill" style="width:{{ $progressPct }}%"></div>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section">Main</div>
    <a href="{{ route('student.dashboard') }}" class="nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
      ⊞ Dashboard
    </a>
    <a href="{{ route('student.voucher') }}" class="nav-item {{ request()->routeIs('student.voucher') ? 'active' : '' }}">
      🎟️ Voucher & Payment
    </a>
    <div class="nav-section">Modules</div>
    <a href="{{ route('student.dashboard') }}" class="nav-item">
      📚 My Modules
    </a>
  </nav>

  <div class="sidebar-footer">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout-btn">↩ Sign out</button>
    </form>
  </div>
</aside>

<main class="main">
  <div class="topbar">
    <div class="topbar-crumb">HyperEdge / <span>@yield('title', 'Dashboard')</span></div>
    <div class="topbar-right">
      <div class="tbar-date">{{ now()->format('D · M j · Y') }}</div>
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

</body>
</html>