<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Facilitator') — HyperEdge Academy</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800;900&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;0,9..40,900;1,9..40,300;1,9..40,400;1,9..40,500;1,9..40,600;1,9..40,700;1,9..40,800;1,9..40,900&family=JetBrains+Mono:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
strong, b { font-weight: 700 !important; }

:root {
  --bg:           #f8fafc;
  --surface:      #ffffff;
  --surface2:     #f1f5f9;
  --surface3:     #e2e8f0;

  --ink:          #0f172a;
  --ink2:         #1e293b;
  --ink3:         #334155;
  --muted:        #64748b;
  --muted2:       #94a3b8;

  --border:       #e2e8f0;
  --border2:      #cbd5e1;

  --slate:        #0f172a;
  --slate2:       #1e293b;
  --slate-light:  #f8fafc;

  --teal:         #0d9488;
  --teal2:        #0f766e;
  --teal3:        #14b8a6;
  --teal-light:   #f0fdfa;
  --teal-border:  rgba(13,148,136,0.15);

  --blue:         #3b82f6;
  --blue-light:   #eff6ff;
  --blue-border:  rgba(59,130,246,0.15);

  --green:        #10b981;
  --green-light:  #ecfdf5;
  --green-border: rgba(16,185,129,0.15);

  --amber:        #f59e0b;
  --amber-light:  #fef3c7;
  --amber-border: rgba(245,158,11,0.15);

  --red:          #ef4444;
  --red-light:    #fef2f2;
  --red-border:   rgba(239,68,68,0.15);

  --sidebar-w:    260px;
  --r:            10px;
  --r-lg:         14px;
}

html, body { height:100%; background:var(--bg); color:var(--ink); font-family:'DM Sans',sans-serif; -webkit-font-smoothing: antialiased; }
body { display:flex; min-height:100vh; }

/* ── SIDEBAR ──────────────────────────────── */
.sidebar {
  width: var(--sidebar-w);
  background: var(--slate);
  display: flex;
  flex-direction: column;
  position: fixed;
  top: 0; left: 0; bottom: 0;
  z-index: 100;
  box-shadow: 4px 0 24px rgba(15,23,42,0.15);
}

.sidebar-logo {
  padding: 24px 20px 20px;
  border-bottom: 1px solid rgba(255,255,255,0.06);
  display: flex;
  align-items: center;
  gap: 12px;
  text-decoration: none;
}
.logo-icon {
  width: 32px; height: 32px;
  border-radius: 7px;
  overflow: hidden;
  flex-shrink: 0;
}
.logo-icon img { width:100%; height:100%; object-fit:cover; }
.logo-text {
  font-family: 'DM Sans', sans-serif;
  font-size: 15px;
  font-weight: 800;
  color: #fff;
  letter-spacing: -0.03em;
  flex: 1;
}
.teacher-chip {
  font-size: 9px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--teal3);
  background: rgba(20,184,166,0.12);
  border: 1px solid rgba(20,184,166,0.2);
  padding: 3px 8px;
  border-radius: 5px;
}

.sidebar-user {
  padding: 18px 20px;
  border-bottom: 1px solid rgba(255,255,255,0.06);
}
.user-row { display:flex; align-items:center; gap:12px; }
.user-av {
  width: 38px; height: 38px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--teal), #3b82f6);
  display: flex; align-items: center; justify-content: center;
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
  font-weight: 700;
  color: #fff;
  flex-shrink: 0;
  box-shadow: 0 4px 10px rgba(13,148,136,0.2);
}
.user-name { font-size: 14px; font-weight: 600; color: #fff; letter-spacing: -0.01em; }
.user-role { font-size: 9px; color: var(--teal3); font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-top: 2px; }

.sidebar-nav { flex:1; padding:16px 12px; overflow-y:auto; }
.sidebar-nav::-webkit-scrollbar { display:none; }

.nav-section {
  font-size: 9px;
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: rgba(255,255,255,0.25);
  padding: 0 10px;
  margin: 20px 0 6px;
}
.nav-section:first-child { margin-top: 4px; }

.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 12px;
  border-radius: var(--r);
  margin-bottom: 2px;
  color: rgba(255,255,255,0.45);
  font-size: 13.5px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.2s ease;
}
.nav-item:hover { background: rgba(255,255,255,0.04); color: rgba(255,255,255,0.85); }
.nav-item.active {
  background: rgba(20,184,166,0.1);
  color: var(--teal3);
  border: 1px solid rgba(20,184,166,0.15);
  font-weight: 700;
}

.sidebar-footer {
  padding: 16px 12px;
  border-top: 1px solid rgba(255,255,255,0.06);
}
.logout-btn {
  display: flex; align-items: center; justify-content: center; gap: 8px;
  width: 100%;
  padding: 10px;
  background: transparent;
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: var(--r);
  cursor: pointer;
  font-size: 13px;
  font-weight: 600;
  color: rgba(255,255,255,0.4);
  font-family: inherit;
  transition: all 0.2s;
}
.logout-btn:hover { border-color: rgba(239,68,68,0.4); color: #f87171; background: rgba(239,68,68,0.05); }

/* ── MAIN ─────────────────────────────────── */
.main {
  margin-left: 260px; /* Absolute explicit pixel fallback */
  margin-left: var(--sidebar-w);
  width: calc(100% - 260px);
  width: calc(100% - var(--sidebar-w));
  flex: 1;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background: var(--bg);
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
  height: 64px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: var(--surface);
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.02);
  animation: slideDown 0.4s ease;
}
@keyframes slideDown { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:none} }

.topbar-title {
  font-family: 'DM Sans', sans-serif;
  font-size: 18px;
  font-weight: 800;
  color: var(--ink);
  letter-spacing: -0.025em;
}
.topbar-right { display:flex; align-items:center; gap:12px; }
.tbar-date {
  font-family: 'JetBrains Mono', monospace;
  font-size: 11px;
  font-weight: 500;
  color: var(--muted);
  background: var(--surface2);
  border: 1px solid var(--border);
  padding: 6px 14px;
  border-radius: 20px;
}

/* ── BUTTONS ──────────────────────────────── */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 10px 18px;
  border-radius: var(--r);
  font-size: 13px;
  font-weight: 700;
  font-family: inherit;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  border: 1px solid transparent;
  letter-spacing: -0.01em;
  white-space: nowrap;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}
.btn-primary {
  background: var(--teal);
  color: #fff;
  border-color: var(--teal);
}
.btn-primary:hover { background: var(--teal2); transform: translateY(-1.5px); box-shadow: 0 4px 12px rgba(13,148,136,0.25); }
.btn-ghost {
  background: var(--surface);
  color: var(--ink3);
  border-color: var(--border);
}
.btn-ghost:hover { background: var(--surface2); border-color: var(--border2); color: var(--ink); }
.btn-slate {
  background: var(--slate);
  color: #fff;
  border-color: var(--slate);
}
.btn-slate:hover { background: var(--slate2); transform: translateY(-1.5px); box-shadow: 0 4px 12px rgba(15,23,42,0.15); }
.btn-danger {
  background: var(--red-light);
  color: var(--red);
  border-color: var(--red-border);
  box-shadow: none;
}
.btn-danger:hover { background: var(--red); color: #fff; border-color: var(--red); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239,68,68,0.15); }
.btn-sm { padding: 6px 12px; font-size: 12px; }

/* Full-width submit button */
.btn-full {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  width: 100%;
  padding: 12px 20px;
  background: var(--teal);
  color: #fff;
  border: none;
  border-radius: var(--r);
  font-size: 14px;
  font-weight: 700;
  font-family: inherit;
  cursor: pointer;
  text-align: center;
  transition: all 0.2s ease;
  letter-spacing: -0.01em;
  margin-top: 4px;
}
.btn-full:hover { background: var(--teal2); transform: translateY(-1.5px); box-shadow: 0 4px 14px rgba(13,148,136,0.22); }

/* ── PAGE ─────────────────────────────────── */
.page { padding: 40px; animation: fadeUp 0.5s ease; }
@keyframes fadeUp { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:none} }

/* ── LAYOUT UTILITIES ─────────────────────── */
.flex { display: flex; }
.flex-col { flex-direction: column; }
.items-center { align-items: center; }
.justify-between { justify-content: space-between; }
.gap-2 { gap: 8px; }
.gap-3 { gap: 12px; }
.mb-4 { margin-bottom: 16px; }
.mb-6 { margin-bottom: 24px; }

/* 3-column grid */
.grid-3 {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

/* ── SECTION TITLE ───────────────────────── */
.section-title {
  font-family: 'DM Sans', sans-serif;
  font-size: 18px;
  font-weight: 800;
  color: var(--ink);
  letter-spacing: -0.02em;
  margin-bottom: 20px;
}

/* ── CARD ─────────────────────────────────── */
.card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--r-lg);
  overflow: hidden;
  padding: 24px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
}
.card-head {
  padding: 18px 24px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.card-title {
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
  font-weight: 700;
  color: var(--ink);
  letter-spacing: -0.02em;
}
.card-sub { font-size: 12px; color: var(--muted); margin-top: 2px; }

/* ── STAT CARDS ───────────────────────────── */
.stat-num {
  font-family: 'DM Sans', sans-serif;
  font-size: 32px;
  font-weight: 800;
  color: var(--ink);
  letter-spacing: -0.02em;
  line-height: 1;
  margin-bottom: 6px;
}
.stat-label {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--muted);
}

/* ── FORMS ────────────────────────────────── */
.form-group { margin-bottom: 18px; }
.form-group:last-of-type { margin-bottom: 20px; }

.form-label {
  display: block;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  color: var(--ink3);
  margin-bottom: 8px;
}

.form-input,
.form-textarea,
.form-select {
  width: 100%;
  padding: 10px 14px;
  background: var(--bg);
  border: 1px solid var(--border);
  border-radius: var(--r);
  font-size: 14px;
  font-family: inherit;
  font-weight: 600;
  color: var(--ink);
  outline: none;
  transition: all 0.2s ease;
}
.form-input:focus,
.form-textarea:focus,
.form-select:focus {
  border-color: var(--teal);
  box-shadow: 0 0 0 3px rgba(13,148,136,0.1);
  background: var(--surface);
}
.form-input::placeholder,
.form-textarea::placeholder {
  color: var(--muted2);
}

.form-textarea {
  min-height: 100px;
  resize: vertical;
  line-height: 1.6;
}

.form-select {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 14px center;
  padding-right: 36px;
  cursor: pointer;
}

/* File input styling */
.form-input[type="file"] {
  padding: 8px 14px;
  cursor: pointer;
  color: var(--ink3);
  font-size: 13px;
}
.form-input[type="file"]::-webkit-file-upload-button {
  padding: 5px 12px;
  background: var(--surface3);
  border: 1px solid var(--border);
  border-radius: 5px;
  font-size: 12px;
  font-family: inherit;
  font-weight: 600;
  color: var(--ink3);
  cursor: pointer;
  margin-right: 12px;
  transition: background 0.15s;
}
.form-input[type="file"]::-webkit-file-upload-button:hover {
  background: var(--border2);
}

/* ── TABLE ────────────────────────────────── */
table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  font-size: 13px;
}
th {
  padding: 14px 20px;
  text-align: left;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--muted);
  border-bottom: 1px solid var(--border);
  background: var(--surface2);
  user-select: none;
}
td {
  padding: 16px 20px;
  color: var(--ink3);
  border-bottom: 1px solid var(--border);
  vertical-align: middle;
  transition: background 0.15s ease;
}
tr:last-child td { border-bottom: none; }
tr:hover td { background: var(--bg); }
.td-actions { display:flex; gap:8px; align-items: center; }

/* Wrapper card to overflow tables cleanly */
.card-table-wrapper {
  margin: -24px;
  overflow-x: auto;
}

/* ── BADGES ───────────────────────────────── */
.badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  border: 1px solid;
  line-height: 1;
}
.badge-active  { background:var(--teal-light);   color:var(--teal2);  border-color:var(--teal-border); }
.badge-inactive{ background:var(--surface2);     color:var(--muted);  border-color:var(--border); }
.badge-done    { background:var(--green-light);  color:var(--green);  border-color:var(--green-border); }
.badge-prog    { background:var(--blue-light);   color:var(--blue);   border-color:var(--blue-border); }
.badge-wait    { background:var(--amber-light);  color:var(--amber);  border-color:var(--amber-border); }
.badge-no      { background:var(--surface2);     color:var(--muted);  border-color:var(--border); }

/* ── ALERTS ───────────────────────────────── */
.alert { padding:14px 20px; border-radius:var(--r); font-size:14px; margin-bottom:20px; border:1px solid; }
.alert-success { background:var(--green-light); border-color:var(--green-border); color:var(--green); }
.alert-error   { background:var(--red-light);   border-color:var(--red-border);   color:var(--red); }

/* ── MODALS (PREMIUM SYSTEM) ──────────────── */
.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(15, 23, 42, 0.7);
  backdrop-filter: blur(6px);
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.25s ease;
}

.modal-overlay.active {
  opacity: 1;
  pointer-events: auto;
}

.modal-container {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--r-lg);
  width: 90%;
  max-width: 900px; /* Spacious width */
  max-height: 85vh;
  overflow-y: auto;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  transform: scale(0.96);
  transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
  display: flex;
  flex-direction: column;
}

.modal-overlay.active .modal-container {
  transform: scale(1);
}

.modal-header {
  padding: 20px 24px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.modal-title {
  font-family: 'DM Sans', sans-serif;
  font-size: 16px;
  font-weight: 800;
  color: var(--ink);
  letter-spacing: -0.02em;
}

.modal-close {
  background: none;
  border: none;
  font-size: 26px;
  color: var(--muted);
  cursor: pointer;
  line-height: 1;
  transition: color 0.15s;
}

.modal-close:hover {
  color: var(--red);
}

.modal-body {
  padding: 24px;
  overflow-y: auto;
}

.modal-footer {
  padding: 16px 24px;
  border-top: 1px solid var(--border);
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  background: var(--bg);
}
</style>
</head>
<body>

<aside class="sidebar">
  <a href="{{ route('teacher.dashboard') }}" class="sidebar-logo">
    <div class="logo-icon"><img src="{{ asset('logo/hyperlogo.jpg') }}" alt="HyperEdge"></div>
    <div class="logo-text">HyperEdge</div>
    <span class="teacher-chip">Facilitator</span>
  </a>

  <div class="sidebar-user">
    <div class="user-row">
      <div class="user-av">{{ Auth::user()->initials }}</div>
      <div>
        <div class="user-name">{{ Auth::user()->full_name }}</div>
        <div class="user-role">Instructor</div>
      </div>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section">Overview</div>
    <a href="{{ route('teacher.dashboard') }}" class="nav-item {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
      <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
      </svg>
      <span>Dashboard</span>
    </a>

    <div class="nav-section">Content</div>
    <a href="{{ route('teacher.modules.index') }}" class="nav-item {{ request()->routeIs('teacher.modules.*') ? 'active' : '' }}">
      <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
      </svg>
      <span>Modules</span>
    </a>
    <a href="{{ route('teacher.modules.create') }}" class="nav-item {{ request()->routeIs('teacher.modules.create') ? 'active' : '' }}">
      <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
      </svg>
      <span>New Module</span>
    </a>
  </nav>

  <div class="sidebar-footer">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout-btn">
        <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        <span>Sign out</span>
      </button>
    </form>
  </div>
</aside>

<main class="main">
  <div class="topbar-wrapper">
    <div class="topbar">
      <div class="topbar-title">@yield('topbar-title', 'Facilitator Dashboard')</div>
      <div class="topbar-right">
        <div class="tbar-date">{{ now()->format('D · M j · Y') }}</div>
        <a href="{{ route('teacher.modules.create') }}" class="btn btn-primary">
          <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
          </svg>
          <span>New Module</span>
        </a>
      </div>
    </div>
  </div>

  <div class="page">
    @if(session('success'))
      <div class="alert alert-success">
        <div style="display:flex; align-items:center; gap:8px;">
          <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>{{ session('success') }}</span>
        </div>
      </div>
    @endif
    @if(session('error') || $errors->any())
      <div class="alert alert-error">
        <div style="display:flex; align-items:center; gap:8px;">
          <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>{{ session('error') ?? $errors->first() }}</span>
        </div>
      </div>
    @endif
    @yield('content')
  </div>
</main>

@yield('scripts')
@stack('scripts')

<script>
document.addEventListener('DOMContentLoaded', () => {
  let lastScrollTop = 0;
  const topbarWrapper = document.querySelector('.topbar-wrapper');
  if (topbarWrapper) {
    window.addEventListener('scroll', () => {
      let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      if (scrollTop > lastScrollTop && scrollTop > 64) {
        // Scrolling DOWN
        topbarWrapper.style.transition = 'transform 0.3s ease-in-out';
        topbarWrapper.style.transform = 'translateY(-100%)';
      } else if (scrollTop < lastScrollTop) {
        // Scrolling UP
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