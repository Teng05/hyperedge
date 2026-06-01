<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HyperEdge Academy — @yield('title')</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
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
      --border:     rgba(9,12,26,0.08);
      --border2:    rgba(9,12,26,0.12);
      --danger:     #dc2626;
      --danger-bg:  #fef2f2;
      --danger-bdr: rgba(220,38,38,0.2);
      --success:    #16a34a;
      --success-bg: #f0fdf4;
      --success-bdr:rgba(22,163,74,0.2);
    }

    html, body { height: 100%; }

    body {
      background: var(--white);
      color: var(--ink);
      font-family: 'DM Sans', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ── TOP NAV ──────────────────────────── */
    .auth-nav {
      padding: 18px 48px;
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
      flex-shrink: 0;
    }
    .auth-nav-logo {
      display: flex; align-items: center; gap: 9px;
      text-decoration: none;
    }
    .auth-nav-logo img {
      height: 28px; width: auto; object-fit: contain;
    }
    .auth-nav-logo span {
      font-family: 'Syne', sans-serif;
      font-size: 14px; font-weight: 800;
      color: var(--ink); letter-spacing: -0.02em;
    }
    .auth-nav-back {
      font-size: 12px; color: var(--muted);
      text-decoration: none; display: flex;
      align-items: center; gap: 6px;
      transition: color 0.2s;
    }
    .auth-nav-back:hover { color: var(--ink); }
    .auth-nav-back::before { content: '←'; }

    /* ── MAIN LAYOUT ──────────────────────── */
    .auth-main {
      flex: 1;
      display: flex;
    }

    /* Left panel — decorative */
    .auth-panel {
      width: 380px; flex-shrink: 0;
      background: var(--off);
      border-right: 1px solid var(--border);
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      padding: 48px 40px;
      position: relative; overflow: hidden;
    }

    /* subtle dot grid on panel */
    .auth-panel::before {
      content: '';
      position: absolute; inset: 0;
      background-image:
        radial-gradient(circle, rgba(36,86,224,0.12) 1px, transparent 1px);
      background-size: 28px 28px;
      mask-image: radial-gradient(ellipse 70% 70% at center, black, transparent);
    }

    .panel-inner {
      position: relative; z-index: 1;
      display: flex; flex-direction: column;
      align-items: flex-start; gap: 32px;
    }

    .panel-logo {
      display: flex; align-items: center; gap: 9px;
    }
    .panel-logo img {
      height: 36px; width: auto; object-fit: contain;
    }
    .panel-logo span {
      font-family: 'Syne', sans-serif;
      font-size: 16px; font-weight: 800;
      color: var(--ink); letter-spacing: -0.02em;
    }

    .panel-tagline {
      font-family: 'Syne', sans-serif;
      font-size: 26px; font-weight: 800;
      color: var(--ink); line-height: 1.2;
      letter-spacing: -0.03em;
    }
    .panel-tagline em {
      font-style: normal; color: var(--blue2);
    }

    .panel-features {
      display: flex; flex-direction: column; gap: 14px;
    }
    .panel-feature {
      display: flex; align-items: flex-start; gap: 12px;
    }
    .panel-feature-dot {
      width: 6px; height: 6px; border-radius: 50%;
      background: var(--blue3); flex-shrink: 0;
      margin-top: 6px;
    }
    .panel-feature-text {
      font-size: 13px; color: var(--ink3); line-height: 1.5;
    }
    .panel-feature-text strong {
      display: block; font-weight: 600; color: var(--ink);
      font-size: 12.5px;
    }

    .panel-footer {
      font-size: 11px; color: var(--muted2);
      line-height: 1.6;
    }

    /* Right panel — form */
    .auth-form-wrap {
      flex: 1;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      padding: 48px 40px;
      overflow-y: auto;
    }

    .auth-card {
      width: 100%; max-width: 440px;
    }

    /* ── HEADER ───────────────────────────── */
    .auth-header {
      margin-bottom: 28px;
    }
    .auth-title {
      font-family: 'Syne', sans-serif;
      font-size: 26px; font-weight: 800;
      color: var(--ink); letter-spacing: -0.03em;
      margin-bottom: 5px;
    }
    .auth-sub {
      font-size: 13.5px; color: var(--muted); line-height: 1.5;
    }
    .otp-email {
      font-size: 14px; font-weight: 600;
      color: var(--blue2); margin-top: 4px;
    }

    /* ── ALERTS ───────────────────────────── */
    .alert-error {
      background: var(--danger-bg);
      border: 1px solid var(--danger-bdr);
      border-radius: 8px; padding: 11px 14px;
      font-size: 13px; color: var(--danger);
      margin-bottom: 18px; line-height: 1.5;
    }
    .alert-success {
      background: var(--success-bg);
      border: 1px solid var(--success-bdr);
      border-radius: 8px; padding: 11px 14px;
      font-size: 13px; color: var(--success);
      margin-bottom: 18px; line-height: 1.5;
    }

    /* ── OTP NOTICE ───────────────────────── */
    .otp-notice {
      background: var(--blue-soft);
      border: 1px solid rgba(36,86,224,0.15);
      border-radius: 8px; padding: 11px 14px;
      font-size: 12.5px; color: var(--blue3);
      margin-bottom: 20px; line-height: 1.55;
    }
    .otp-expire {
      text-align: center; font-size: 11.5px;
      color: var(--muted2); margin-top: 12px;
    }

    /* ── FORM ELEMENTS ────────────────────── */
    .form-group { margin-bottom: 14px; }
    .form-row-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }
    .form-label {
      font-size: 11.5px; font-weight: 600;
      color: var(--ink3); margin-bottom: 6px;
      display: block; letter-spacing: 0.2px;
    }
    .form-input,
    .form-select {
      width: 100%;
      background: var(--white);
      border: 1px solid var(--border2);
      border-radius: 8px;
      padding: 10px 13px;
      color: var(--ink); font-size: 13.5px;
      outline: none; transition: border-color 0.2s, box-shadow 0.2s;
      font-family: 'DM Sans', sans-serif;
      appearance: none;
    }
    .form-input:focus,
    .form-select:focus {
      border-color: var(--blue2);
      box-shadow: 0 0 0 3px rgba(36,86,224,0.08);
    }
    .form-input::placeholder { color: var(--muted2); }
    .form-select option { background: var(--white); color: var(--ink); }

    /* OTP big input */
    .otp-input {
      width: 100%;
      background: var(--off);
      border: 1px solid var(--border2);
      border-radius: 10px;
      padding: 18px;
      color: var(--ink);
      font-size: 32px; font-weight: 700;
      text-align: center; letter-spacing: 14px;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
      font-family: 'DM Sans', sans-serif;
    }
    .otp-input:focus {
      border-color: var(--blue2);
      box-shadow: 0 0 0 3px rgba(36,86,224,0.08);
      background: var(--white);
    }

    /* Checkbox */
    .form-row-inline { margin-bottom: 18px; }
    .checkbox-label {
      display: flex; align-items: center; gap: 9px;
      font-size: 12.5px; color: var(--ink3); cursor: pointer;
      user-select: none;
    }
    .checkbox-input { display: none; }
    .checkbox-box {
      width: 16px; height: 16px; border-radius: 4px;
      border: 1.5px solid var(--border2);
      background: var(--white); flex-shrink: 0;
      display: flex; align-items: center; justify-content: center;
      transition: border-color 0.2s, background 0.2s;
    }
    .checkbox-input:checked + .checkbox-box {
      background: var(--blue2); border-color: var(--blue2);
    }
    .checkbox-input:checked + .checkbox-box::after {
      content: '';
      width: 9px; height: 5px;
      border-left: 1.5px solid white;
      border-bottom: 1.5px solid white;
      transform: rotate(-45deg) translateY(-1px);
      display: block;
    }

    /* Submit button */
    .btn-submit {
      width: 100%; padding: 12px;
      background: var(--ink); color: var(--white);
      border: 1px solid var(--ink);
      border-radius: 8px; font-size: 14px; font-weight: 500;
      cursor: pointer; font-family: 'DM Sans', sans-serif;
      letter-spacing: -0.01em;
      transition: background 0.2s;
      margin-top: 4px;
    }
    .btn-submit:hover { background: var(--ink2); }

    /* Auth switch */
    .auth-switch {
      text-align: center; font-size: 13px;
      color: var(--muted); margin-top: 20px;
    }
    .auth-switch a {
      color: var(--blue2); text-decoration: none; font-weight: 500;
    }
    .auth-switch a:hover { text-decoration: underline; }

    /* ── BOTTOM NAV ───────────────────────── */
    .auth-bottom {
      border-top: 1px solid var(--border);
      padding: 14px 48px;
      display: flex; align-items: center; justify-content: space-between;
      flex-shrink: 0;
    }
    .auth-bottom-links {
      display: flex; gap: 20px;
    }
    .auth-bottom-link {
      font-size: 11px; color: var(--muted2);
      text-decoration: none; transition: color 0.2s;
    }
    .auth-bottom-link:hover { color: var(--ink); }
    .auth-bottom-copy {
      font-size: 11px; color: var(--muted2);
    }

    /* ── RESPONSIVE ───────────────────────── */
    @media (max-width: 760px) {
      .auth-panel { display: none; }
      .auth-nav { padding: 16px 24px; }
      .auth-form-wrap { padding: 32px 24px; }
      .auth-bottom { padding: 14px 24px; flex-direction: column; gap: 8px; }
    }
  </style>
</head>
<body>

  <!-- Top nav -->
  <header class="auth-nav">
    <a href="{{ url('/') }}" class="auth-nav-logo">
      <img src="{{ asset('logo/hyperlogo.jpg') }}" alt="HyperEdge">
      <span>HyperEdge Academy</span>
    </a>
    <a href="{{ url('/') }}" class="auth-nav-back">Back to home</a>
  </header>

  <!-- Main -->
  <div class="auth-main">

    <!-- Left decorative panel -->
    <div class="auth-panel">
      <div class="panel-inner">

        <div class="panel-logo">
          <img src="{{ asset('logo/hyperlogo.jpg') }}" alt="HyperEdge">
          <span>HyperEdge</span>
        </div>

        <div class="panel-tagline">
          From zero<br>to <em>certified.</em>
        </div>

        <div class="panel-features">
          <div class="panel-feature">
            <div class="panel-feature-dot"></div>
            <div class="panel-feature-text">
              <strong>12 Structured Modules</strong>
              Step-by-step HTML curriculum designed for real skill-building.
            </div>
          </div>
          <div class="panel-feature">
            <div class="panel-feature-dot"></div>
            <div class="panel-feature-text">
              <strong>Quiz per Module</strong>
              Reinforce every concept before moving on.
            </div>
          </div>
          <div class="panel-feature">
            <div class="panel-feature-dot"></div>
            <div class="panel-feature-text">
              <strong>Official Certificate</strong>
              Complete all modules and earn your certification.
            </div>
          </div>
          <div class="panel-feature">
            <div class="panel-feature-dot"></div>
            <div class="panel-feature-text">
              <strong>Facilitator-guided</strong>
              Real facilitators manage content and track your progress.
            </div>
          </div>
        </div>

        <div class="panel-footer">
          © {{ date('Y') }} HyperEdge Academy.<br>All rights reserved.
        </div>

      </div>
    </div>

    <!-- Right form area -->
    <div class="auth-form-wrap">
      <div class="auth-card">
        @yield('content')
      </div>
    </div>

  </div>

  <!-- Bottom bar -->
  <footer class="auth-bottom">
    <div class="auth-bottom-links">
      <a href="#" class="auth-bottom-link">Terms of Service</a>
      <a href="#" class="auth-bottom-link">Privacy Policy</a>
      <a href="#" class="auth-bottom-link">Help Center</a>
    </div>
    <div class="auth-bottom-copy">© {{ date('Y') }} HyperEdge Academy</div>
  </footer>

</body>
</html>