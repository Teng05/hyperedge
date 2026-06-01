<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HyperEdge Academy</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --white:      #ffffff;
      --off:        #f6f7fb;
      --off2:       #eef0f7;
      --ink:        #090c1a;
      --ink2:       #1c2040;
      --ink3:       #353c62;
      --muted:      #8890ae;
      --muted2:     #b8bdd0;
      --blue:       #1847c8;
      --blue2:      #2456e0;
      --blue3:      #3d6ef5;
      --blue-soft:  #eaf0ff;
      --border:     rgba(9,12,26,0.07);
      --border2:    rgba(9,12,26,0.11);
    }

    html { scroll-behavior: smooth; }

    body {
      background: var(--white);
      color: var(--ink);
      font-family: 'DM Sans', sans-serif;
      min-height: 100vh;
      overflow-x: hidden;
      cursor: none;
    }

    /* ── CURSOR ─────────────────────────────── */
    #cur-dot {
      position: fixed; top: 0; left: 0; z-index: 9999;
      width: 5px; height: 5px; border-radius: 50%;
      background: var(--blue2);
      pointer-events: none;
      transform: translate(-50%,-50%);
      transition: transform 0.15s, background 0.2s, width 0.2s, height 0.2s;
    }
    #cur-trail {
      position: fixed; top: 0; left: 0; z-index: 9998;
      width: 26px; height: 26px; border-radius: 50%;
      border: 1px solid rgba(36,86,224,0.3);
      pointer-events: none;
      transform: translate(-50%,-50%);
      transition: border-color 0.25s, width 0.25s, height 0.25s;
    }
    body.on-zone #cur-dot {
      background: var(--blue2);
      width: 8px; height: 8px;
    }
    body.on-zone #cur-trail {
      border-color: rgba(36,86,224,0.55);
      width: 38px; height: 38px;
    }

    /* ── CANVAS ─────────────────────────────── */
    #bg-canvas {
      position: fixed; inset: 0; z-index: 0;
      pointer-events: none; opacity: 0.7;
    }

    /* ── GRID ───────────────────────────────── */
    .grid-tex {
      position: fixed; inset: 0; z-index: 0; pointer-events: none;
      background-image:
        linear-gradient(var(--border) 1px, transparent 1px),
        linear-gradient(90deg, var(--border) 1px, transparent 1px);
      background-size: 54px 54px;
      mask-image: radial-gradient(ellipse 80% 80% at center, rgba(0,0,0,0.15), transparent);
    }

    /* ── SCROLL WRAP ────────────────────────── */
    #scroll-wrap { position: relative; height: 300vh; }

    /* ── STICKY STAGE ───────────────────────── */
    #stage {
      position: sticky; top: 0;
      width: 100%; height: 100vh;
      overflow: hidden; z-index: 1;
    }

    /* ═══════════════════════════════════════════
       PHASE 0 — HERO
    ═══════════════════════════════════════════ */
    #phase-0 {
      position: absolute; inset: 0;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      z-index: 10; pointer-events: none;
    }

    .p0-nav {
      position: absolute; top: 0; left: 0; right: 0;
      padding: 20px 48px;
      display: flex; align-items: center; justify-content: space-between;
      border-bottom: 1px solid var(--border);
      pointer-events: auto;
    }
    .p0-nav-logo {
      display: flex; align-items: center; gap: 9px;
      text-decoration: none;
    }
    .p0-nav-logo img {
      height: 30px; width: auto; object-fit: contain;
    }
    .p0-nav-logo span {
      font-family: 'Syne', sans-serif;
      font-size: 14px; font-weight: 800;
      color: var(--ink); letter-spacing: -0.02em;
    }
    .p0-nav-right {
      display: flex; gap: 6px; align-items: center;
    }
    .p0-nav-tag {
      font-size: 10.5px; font-weight: 600; letter-spacing: 1.5px;
      text-transform: uppercase; color: var(--muted);
      margin-right: 10px;
    }

    /* Hero center */
    .p0-eyebrow {
      font-size: 10px; font-weight: 700; letter-spacing: 4px;
      text-transform: uppercase; color: var(--blue3);
      margin-bottom: 20px;
      opacity: 0; transform: translateY(12px);
      display: flex; align-items: center; gap: 12px;
    }
    .p0-eyebrow::before, .p0-eyebrow::after {
      content: ''; display: block;
      width: 24px; height: 1px; background: var(--blue3); opacity: 0.4;
    }

    .p0-title {
      font-family: 'Syne', sans-serif;
      font-size: clamp(54px, 9vw, 108px);
      font-weight: 800; line-height: 0.92;
      letter-spacing: -0.04em;
      text-align: center; color: var(--ink);
      opacity: 0; transform: translateY(22px);
    }
    .p0-title em { font-style: normal; color: var(--blue2); }

    .p0-sub {
      margin-top: 26px;
      font-size: 15.5px; font-weight: 400;
      color: var(--muted); text-align: center;
      max-width: 380px; line-height: 1.7;
      opacity: 0; transform: translateY(12px);
    }

    .p0-scroll {
      margin-top: 50px;
      display: flex; flex-direction: column;
      align-items: center; gap: 7px;
      opacity: 0;
    }
    .p0-scroll span {
      font-size: 9.5px; letter-spacing: 3px;
      text-transform: uppercase; color: var(--muted2);
    }
    .p0-scroll-line {
      width: 1px; height: 38px;
      background: linear-gradient(to bottom, var(--blue3), transparent);
      animation: spulse 2.2s ease-in-out infinite;
    }
    @keyframes spulse {
      0%,100%{opacity:0.2} 50%{opacity:0.8}
    }

    /* Stats bottom */
    .p0-stats {
      position: absolute; bottom: 0; left: 0; right: 0;
      border-top: 1px solid var(--border);
      display: flex; justify-content: center;
      opacity: 0;
    }
    .p0-stat {
      padding: 18px 44px;
      border-right: 1px solid var(--border);
      text-align: center;
    }
    .p0-stat:last-child { border-right: none; }
    .p0-stat-n {
      font-family: 'Syne', sans-serif;
      font-size: 24px; font-weight: 800;
      color: var(--ink); letter-spacing: -0.03em;
    }
    .p0-stat-l {
      font-size: 10.5px; color: var(--muted);
      margin-top: 1px; letter-spacing: 0.5px;
    }

    /* ═══════════════════════════════════════════
       PHASE 1 — ABOUT / MODULES
    ═══════════════════════════════════════════ */
    #phase-1 {
      position: absolute; inset: 0;
      display: flex; flex-direction: column;
      z-index: 9; opacity: 0; pointer-events: none;
      overflow: hidden;
    }

    /* Top bar with logo */
    .p1-topbar {
      padding: 16px 48px;
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
      flex-shrink: 0;
    }
    .p1-logo {
      display: flex; align-items: center; gap: 9px;
    }
    .p1-logo img {
      height: 28px; width: auto; object-fit: contain;
    }
    .p1-logo span {
      font-family: 'Syne', sans-serif;
      font-size: 13.5px; font-weight: 800;
      color: var(--ink); letter-spacing: -0.02em;
    }
    .p1-motto {
      font-size: 11px; color: var(--muted);
      font-style: italic; letter-spacing: 0.2px;
    }

    /* Body */
    .p1-body {
      flex: 1; display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      padding: 20px 48px 0;
      gap: 20px;
    }

    .p1-head {
      text-align: center;
    }
    .p1-head h2 {
      font-family: 'Syne', sans-serif;
      font-size: clamp(20px, 2.8vw, 30px); font-weight: 800;
      letter-spacing: -0.03em; color: var(--ink);
    }
    .p1-head p {
      margin-top: 5px; font-size: 13px; color: var(--muted);
    }

    .modules-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 9px;
      width: 100%; max-width: 1060px;
    }

    .mod-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 14px 13px 12px;
      display: flex; flex-direction: column; gap: 7px;
      opacity: 0; transform: translateY(16px);
      cursor: none;
      transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
      position: relative; overflow: hidden;
    }
    .mod-card::after {
      content: '';
      position: absolute; inset: 0;
      background: radial-gradient(circle at var(--mx,50%) var(--my,50%), rgba(36,86,224,0.05), transparent 55%);
      opacity: 0; transition: opacity 0.3s; pointer-events: none;
    }
    .mod-card:hover::after { opacity: 1; }
    .mod-card:hover {
      border-color: rgba(36,86,224,0.2);
      box-shadow: 0 3px 16px rgba(36,86,224,0.06);
      transform: translateY(-2px);
    }
    .mod-card.is-locked {
      background: var(--off);
    }
    .mod-card.is-locked:hover { transform: none; box-shadow: none; border-color: var(--border); }

    .mod-top {
      display: flex; align-items: center; justify-content: space-between;
    }
    .mod-num {
      font-size: 9.5px; font-weight: 700; letter-spacing: 2px;
      text-transform: uppercase; color: var(--blue3);
    }
    .mod-badge {
      font-size: 9px; font-weight: 700; letter-spacing: 0.5px;
      text-transform: uppercase;
      padding: 2px 7px; border-radius: 3px;
    }
    .mod-badge.done   { background: #edf8ee; color: #2a7a35; }
    .mod-badge.prog   { background: var(--blue-soft); color: var(--blue2); }
    .mod-badge.lock   { background: var(--off2); color: var(--muted2); }

    .mod-title {
      font-family: 'Syne', sans-serif;
      font-size: 12px; font-weight: 700;
      color: var(--ink); line-height: 1.3;
    }
    .mod-card.is-locked .mod-title { color: var(--muted2); }

    .mod-meta { font-size: 10.5px; color: var(--muted); }

    .mod-bar {
      height: 2px; background: var(--off2);
      border-radius: 2px; overflow: hidden; margin-top: auto;
    }
    .mod-bar-fill {
      height: 100%; border-radius: 2px;
      background: var(--blue2);
    }
    .mod-card.is-locked .mod-bar-fill { background: var(--muted2); }

    /* Footer */
    .p1-footer {
      border-top: 1px solid var(--border);
      padding: 13px 48px;
      display: flex; align-items: center; justify-content: space-between;
      flex-shrink: 0;
    }
    .p1-footer-left {
      display: flex; gap: 20px; align-items: center;
    }
    .p1-footer-link {
      font-size: 11px; color: var(--muted);
      text-decoration: none; letter-spacing: 0.2px;
      transition: color 0.2s;
    }
    .p1-footer-link:hover { color: var(--ink); }
    .p1-footer-right {
      font-size: 11px; color: var(--muted2);
    }

    /* ═══════════════════════════════════════════
       PHASE 2 — LOGIN / REGISTER ZONES
    ═══════════════════════════════════════════ */
    #phase-2 {
      position: absolute; inset: 0;
      display: flex;
      z-index: 8; opacity: 0; pointer-events: none;
    }

    .auth-zone {
      flex: 1; height: 100%;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      position: relative; overflow: hidden;
      transition: flex 0.55s cubic-bezier(0.4,0,0.2,1);
      cursor: none;
    }

    /* backgrounds */
    #zone-login  { background: var(--white); }
    #zone-register { background: var(--off); }

    /* divider */
    .zone-sep {
      width: 1px; flex-shrink: 0;
      background: var(--border2); z-index: 2;
      position: relative;
    }
    .zone-sep::after {
      content: 'or';
      position: absolute; top: 50%; left: 50%;
      transform: translate(-50%,-50%);
      background: var(--white);
      border: 1px solid var(--border2);
      color: var(--muted2);
      font-size: 10px; font-weight: 600;
      letter-spacing: 1px; text-transform: uppercase;
      padding: 5px 8px; border-radius: 4px;
    }

    /* expand active zone */
    .auth-zone.z-active { flex: 1.65; }

    /* blob */
    .z-blob {
      position: absolute; z-index: 0;
      width: 320px; height: 320px; border-radius: 50%;
      pointer-events: none; filter: blur(80px);
      opacity: 0; transition: opacity 0.4s;
    }
    #zone-login .z-blob   { background: rgba(36,86,224,0.12); }
    #zone-register .z-blob { background: rgba(36,86,224,0.09); }
    .auth-zone.z-active .z-blob { opacity: 1; }

    /* zone top watermark */
    .p2-topbar {
      position: absolute; top: 0; left: 0; right: 0;
      padding: 18px 40px;
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center; justify-content: center;
      z-index: 5; pointer-events: none;
    }
    .p2-topbar-logo {
      display: flex; align-items: center; gap: 8px;
    }
    .p2-topbar-logo img {
      height: 26px; width: auto; object-fit: contain;
    }
    .p2-topbar-logo span {
      font-family: 'Syne', sans-serif;
      font-size: 13px; font-weight: 800;
      color: var(--ink); letter-spacing: -0.02em;
    }

    /* zone content */
    .z-content {
      position: relative; z-index: 2;
      display: flex; flex-direction: column;
      align-items: center; text-align: center;
      padding: 32px 48px;
      pointer-events: none;
      width: 100%; max-width: 460px;
    }

    .z-tag {
      font-size: 9.5px; font-weight: 700; letter-spacing: 3px;
      text-transform: uppercase; color: var(--muted);
      margin-bottom: 16px;
      transition: color 0.3s;
    }
    .auth-zone.z-active .z-tag { color: var(--blue3); }

    .z-title {
      font-family: 'Syne', sans-serif;
      font-size: clamp(30px, 4vw, 50px); font-weight: 800;
      letter-spacing: -0.04em; color: var(--ink);
      line-height: 1.0; margin-bottom: 10px;
      transition: color 0.3s;
    }

    .z-desc {
      font-size: 13.5px; color: var(--muted);
      line-height: 1.65; max-width: 260px;
      margin-bottom: 28px; transition: color 0.3s;
    }

    .z-btn {
      padding: 12px 40px; border-radius: 8px;
      font-size: 13.5px; font-weight: 600;
      font-family: 'DM Sans', sans-serif;
      text-decoration: none; letter-spacing: -0.01em;
      pointer-events: auto; cursor: none;
      transition: all 0.25s; display: inline-block;
      border: 1px solid var(--border2);
      background: var(--white); color: var(--ink2);
    }
    .auth-zone.z-active .z-btn {
      background: var(--ink); color: var(--white);
      border-color: var(--ink);
      box-shadow: 0 4px 20px rgba(9,12,26,0.15);
    }

    /* hover hint text */
    .z-hint {
      margin-top: 20px; font-size: 10px;
      letter-spacing: 2px; text-transform: uppercase;
      color: var(--muted2); transition: color 0.3s;
      pointer-events: none;
    }
    .auth-zone.z-active .z-hint { color: var(--blue3); }

    /* features list */
    .z-features {
      margin-top: 24px; display: flex;
      flex-direction: column; gap: 7px;
      pointer-events: none;
    }
    .z-feature {
      font-size: 12px; color: var(--muted);
      display: flex; align-items: center; gap: 8px;
      transition: color 0.3s;
    }
    .z-feature::before {
      content: ''; width: 14px; height: 1px;
      background: var(--muted2); flex-shrink: 0;
      transition: background 0.3s, width 0.3s;
    }
    .auth-zone.z-active .z-feature { color: var(--ink3); }
    .auth-zone.z-active .z-feature::before { background: var(--blue3); width: 18px; }

    /* bottom back hint */
    .p2-back {
      position: absolute; bottom: 20px; left: 50%;
      transform: translateX(-50%);
      font-size: 10px; letter-spacing: 2px;
      text-transform: uppercase; color: var(--muted2);
      z-index: 10; pointer-events: none; white-space: nowrap;
    }
  </style>
</head>
<body>

<div id="cur-dot"></div>
<div id="cur-trail"></div>
<canvas id="bg-canvas"></canvas>
<div class="grid-tex"></div>

<div id="scroll-wrap">
  <div id="stage">

    <!-- ══════ PHASE 0 — HERO ══════ -->
    <div id="phase-0">
      <nav class="p0-nav">
        <a href="/" class="p0-nav-logo">
          <img src="{{ asset('logo/hyperlogo.jpg') }}" alt="HyperEdge">
          <span>HyperEdge</span>
        </a>
        <div style="display:flex;align-items:center;gap:16px;">
          <span class="p0-nav-tag">HTML Developer Program</span>
        </div>
      </nav>

      <div class="p0-eyebrow">Structured Learning Path</div>

      <h1 class="p0-title">Learn. Build.<br><em>Graduate.</em></h1>

      <p class="p0-sub">A structured 12-module journey from zero to certified HTML developer — guided by real facilitators.</p>

      <div class="p0-scroll">
        <span>Scroll to explore</span>
        <div class="p0-scroll-line"></div>
      </div>

      <div class="p0-stats">
        <div class="p0-stat">
          <div class="p0-stat-n">12</div>
          <div class="p0-stat-l">Modules</div>
        </div>
        <div class="p0-stat">
          <div class="p0-stat-n">80+</div>
          <div class="p0-stat-l">Lessons</div>
        </div>
        <div class="p0-stat">
          <div class="p0-stat-n">Quiz</div>
          <div class="p0-stat-l">Per Module</div>
        </div>
        <div class="p0-stat">
          <div class="p0-stat-n">1</div>
          <div class="p0-stat-l">Certificate</div>
        </div>
      </div>
    </div>

    <!-- ══════ PHASE 1 — MODULES ══════ -->
    <div id="phase-1">

      <div class="p1-topbar">
        <div class="p1-logo">
          <img src="{{ asset('logo/hyperlogo.jpg') }}" alt="HyperEdge">
          <span>HyperEdge Academy</span>
        </div>
        <div class="p1-motto">"From zero to certified — one module at a time."</div>
      </div>

      <div class="p1-body">
        <div class="p1-head">
          <h2>What you'll learn</h2>
          <p>12 modules, each unlocking after you complete the previous one.</p>
        </div>
        <div class="modules-grid" id="modules-grid"></div>
      </div>

      <footer class="p1-footer">
        <div class="p1-footer-left">
          <a href="#" class="p1-footer-link">Terms of Service</a>
          <a href="#" class="p1-footer-link">Privacy Policy</a>
          <a href="#" class="p1-footer-link">Help Center</a>
          <a href="#" class="p1-footer-link">Contact</a>
        </div>
        <div class="p1-footer-right">© {{ date('Y') }} HyperEdge Academy. All rights reserved.</div>
      </footer>
    </div>

    <!-- ══════ PHASE 2 — AUTH ZONES ══════ -->
    <div id="phase-2">

      <div class="p2-topbar">
        <div class="p2-topbar-logo">
          <img src="{{ asset('logo/hyperlogo.jpg') }}" alt="HyperEdge">
          <span>HyperEdge Academy</span>
        </div>
      </div>

      <!-- LOGIN ZONE -->
      <div class="auth-zone" id="zone-login">
        <div class="z-blob" id="blob-login"></div>
        <div class="z-content">
          <div class="z-tag">Already enrolled</div>
          <div class="z-title">Sign in</div>
          <div class="z-desc">Welcome back. Pick up right where you left off and keep building.</div>
          <a href="{{ route('login') }}" class="z-btn">Login to account</a>
          <div class="z-features">
            <div class="z-feature">Continue your modules</div>
            <div class="z-feature">Track your progress</div>
            <div class="z-feature">Access your certificate</div>
          </div>
        </div>
        <div class="z-hint">Hover to select</div>
      </div>

      <div class="zone-sep"></div>

      <!-- REGISTER ZONE -->
      <div class="auth-zone" id="zone-register">
        <div class="z-blob" id="blob-register"></div>
        <div class="z-content">
          <div class="z-tag">New here</div>
          <div class="z-title">Get started</div>
          <div class="z-desc">Create your free account and begin your journey to HTML certification.</div>
          <a href="{{ route('register') }}" class="z-btn">Create account</a>
          <div class="z-features">
            <div class="z-feature">Free to join</div>
            <div class="z-feature">12 structured modules</div>
            <div class="z-feature">Earn your certificate</div>
          </div>
        </div>
        <div class="z-hint">Hover to select</div>
      </div>

      <div class="p2-back">Scroll up to go back</div>
    </div>

  </div><!-- /stage -->
</div><!-- /scroll-wrap -->

<script>
// ── MODULE DATA ──────────────────────────────
const MODS = [
  { n:'01', title:'HTML Foundations',    meta:'8 lessons · 45 min', pct:100, s:'done'   },
  { n:'02', title:'Document Structure',  meta:'6 lessons · 35 min', pct:100, s:'done'   },
  { n:'03', title:'Text & Typography',   meta:'7 lessons · 40 min', pct:60,  s:'prog'   },
  { n:'04', title:'Links & Navigation',  meta:'5 lessons · 30 min', pct:0,   s:'prog'   },
  { n:'05', title:'Images & Media',      meta:'6 lessons · 38 min', pct:0,   s:'lock'   },
  { n:'06', title:'Tables & Data',       meta:'5 lessons · 32 min', pct:0,   s:'lock'   },
  { n:'07', title:'HTML Forms',          meta:'9 lessons · 55 min', pct:0,   s:'lock'   },
  { n:'08', title:'Semantic HTML5',      meta:'7 lessons · 42 min', pct:0,   s:'lock'   },
  { n:'09', title:'Accessibility',       meta:'6 lessons · 36 min', pct:0,   s:'lock'   },
  { n:'10', title:'SEO Fundamentals',    meta:'5 lessons · 28 min', pct:0,   s:'lock'   },
  { n:'11', title:'HTML & CSS Intro',    meta:'8 lessons · 50 min', pct:0,   s:'lock'   },
  { n:'12', title:'Final Project',       meta:'Capstone · Certified',pct:0,  s:'lock'   },
];
const BADGE = { done:'Complete', prog:'In progress', lock:'Locked' };

const grid = document.getElementById('modules-grid');
MODS.forEach(m => {
  const c = document.createElement('div');
  c.className = 'mod-card' + (m.s === 'lock' ? ' is-locked' : '');
  c.innerHTML = `
    <div class="mod-top">
      <div class="mod-num">Module ${m.n}</div>
      <div class="mod-badge ${m.s}">${BADGE[m.s]}</div>
    </div>
    <div class="mod-title">${m.title}</div>
    <div class="mod-meta">${m.meta}</div>
    <div class="mod-bar"><div class="mod-bar-fill" style="width:${m.pct}%"></div></div>
  `;
  c.addEventListener('mousemove', e => {
    const r = c.getBoundingClientRect();
    c.style.setProperty('--mx', ((e.clientX-r.left)/r.width*100).toFixed(1)+'%');
    c.style.setProperty('--my', ((e.clientY-r.top)/r.height*100).toFixed(1)+'%');
  });
  grid.appendChild(c);
});

// ── CURSOR ───────────────────────────────────
const dot   = document.getElementById('cur-dot');
const trail = document.getElementById('cur-trail');
let mx=innerWidth/2, my=innerHeight/2;
let sx=mx, sy=my, tx=mx, ty=my;

document.addEventListener('mousemove', e => { mx=e.clientX; my=e.clientY; });

(function cl(){
  sx+=(mx-sx)*.45; sy+=(my-sy)*.45;
  dot.style.left=sx+'px'; dot.style.top=sy+'px';
  tx+=(mx-tx)*.1;  ty+=(my-ty)*.1;
  trail.style.left=tx+'px'; trail.style.top=ty+'px';
  requestAnimationFrame(cl);
})();

// ── CANVAS DOTS ──────────────────────────────
const cv  = document.getElementById('bg-canvas');
const ctx = cv.getContext('2d');
let W, H, dots=[];
function resize(){ W=cv.width=innerWidth; H=cv.height=innerHeight; }
resize(); window.addEventListener('resize',()=>{ resize(); makeDots(); });

function makeDots(){
  dots=[];
  const n=Math.floor(W*H/15000);
  for(let i=0;i<n;i++) dots.push({
    x:Math.random()*W, y:Math.random()*H,
    vx:(Math.random()-.5)*.2, vy:(Math.random()-.5)*.2,
    r:Math.random()*1.2+.4, op:Math.random()*.18+.05
  });
}
makeDots();

let cmx=W/2, cmy=H/2;
document.addEventListener('mousemove', e=>{ cmx=e.clientX; cmy=e.clientY; });

(function dl(){
  ctx.clearRect(0,0,W,H);
  const ddx=(cmx-W/2)/W*.03, ddy=(cmy-H/2)/H*.03;
  for(const d of dots){
    d.x+=d.vx+ddx; d.y+=d.vy+ddy;
    if(d.x<0)d.x=W; if(d.x>W)d.x=0;
    if(d.y<0)d.y=H; if(d.y>H)d.y=0;
    ctx.beginPath();
    ctx.arc(d.x,d.y,d.r,0,Math.PI*2);
    ctx.fillStyle=`rgba(36,86,224,${d.op})`;
    ctx.fill();
  }
  for(let i=0;i<dots.length;i++){
    for(let j=i+1;j<dots.length;j++){
      const a=dots[i],b=dots[j];
      const dist=Math.hypot(a.x-b.x,a.y-b.y);
      if(dist<100){
        ctx.beginPath();
        ctx.moveTo(a.x,a.y); ctx.lineTo(b.x,b.y);
        ctx.strokeStyle=`rgba(36,86,224,${(1-dist/100)*.07})`;
        ctx.lineWidth=.6; ctx.stroke();
      }
    }
  }
  requestAnimationFrame(dl);
})();

// ── PHASES ───────────────────────────────────
const p0    = document.getElementById('phase-0');
const p1    = document.getElementById('phase-1');
const p2    = document.getElementById('phase-2');
const cards = document.querySelectorAll('.mod-card');
let phase   = 0;

window.addEventListener('load', () => {
  gsap.to('.p0-eyebrow',      {opacity:1,y:0,duration:.65,delay:.15,ease:'power2.out'});
  gsap.to('.p0-title',        {opacity:1,y:0,duration:.75,delay:.32,ease:'power2.out'});
  gsap.to('.p0-sub',          {opacity:1,y:0,duration:.6, delay:.52,ease:'power2.out'});
  gsap.to('.p0-scroll',       {opacity:1,    duration:.5, delay:.95,ease:'power2.out'});
  gsap.to('.p0-stats',        {opacity:1,    duration:.5, delay:1.1,ease:'power2.out'});
});

function toPhase1(){
  if(phase===1) return; phase=1;
  gsap.to(p0,{opacity:0,scale:1.1,duration:.6,ease:'power2.in',
    onComplete(){ p0.style.pointerEvents='none'; }});
  p1.style.pointerEvents='auto';
  gsap.to(p1,{opacity:1,duration:.45,delay:.12});
  cards.forEach((c,i)=>
    gsap.to(c,{
      opacity: c.classList.contains('is-locked') ? .5 : 1,
      y:0, duration:.4, delay:.18+i*.045, ease:'power2.out'
    })
  );
}

function toPhase2(){
  if(phase===2) return; phase=2;
  gsap.to(p1,{opacity:0,y:-8,duration:.38,
    onComplete(){ p1.style.pointerEvents='none'; }});
  p2.style.pointerEvents='auto';
  gsap.fromTo(p2,{opacity:0,y:18},{opacity:1,y:0,duration:.55,delay:.08});
}

function backTo1(){
  if(phase===1) return; phase=1;
  // Reset zones
  document.getElementById('zone-login').classList.remove('z-active');
  document.getElementById('zone-register').classList.remove('z-active');
  document.body.classList.remove('on-zone');
  gsap.to(p2,{opacity:0,duration:.35,
    onComplete(){ p2.style.pointerEvents='none'; }});
  p1.style.pointerEvents='auto';
  gsap.to(p1,{opacity:1,y:0,duration:.45});
}

function backTo0(){
  if(phase===0) return; phase=0;
  gsap.to(p1,{opacity:0,duration:.38,
    onComplete(){ p1.style.pointerEvents='none'; }});
  cards.forEach(c=>gsap.set(c,{opacity:0,y:16}));
  p0.style.pointerEvents='auto';
  gsap.to(p0,{opacity:1,scale:1,duration:.6,ease:'power2.out'});
  gsap.set(['.p0-eyebrow','.p0-title','.p0-sub','.p0-scroll','.p0-stats'],{opacity:1,y:0});
}

window.addEventListener('scroll',()=>{
  const total = document.documentElement.scrollHeight - innerHeight;
  if(total<=0) return;
  const p = scrollY / total;
  if     (p>.03  && phase===0) toPhase1();
  else if(p<.02  && phase===1) backTo0();
  else if(p>.55  && phase===1) toPhase2();
  else if(p<.45  && phase===2) backTo1();
});

// ── ZONE HOVER (cursor-based) ────────────────
const zLogin = document.getElementById('zone-login');
const zReg   = document.getElementById('zone-register');
const bLogin = document.getElementById('blob-login');
const bReg   = document.getElementById('blob-register');

(function zoneLoop(){
  if(phase===2){
    const smx = tx, smy = ty;
    [
      { zone: zLogin, blob: bLogin },
      { zone: zReg,   blob: bReg   }
    ].forEach(({zone, blob}) => {
      const r = zone.getBoundingClientRect();
      const inside = smx>r.left && smx<r.right && smy>r.top && smy<r.bottom;
      if(inside){
        zone.classList.add('z-active');
        blob.style.left = (smx - r.left - 160) + 'px';
        blob.style.top  = (smy - r.top  - 160) + 'px';
      } else {
        zone.classList.remove('z-active');
      }
    });
    const anyActive = zLogin.classList.contains('z-active') || zReg.classList.contains('z-active');
    document.body.classList.toggle('on-zone', anyActive);
  }
  requestAnimationFrame(zoneLoop);
})();
</script>
</body>
</html>