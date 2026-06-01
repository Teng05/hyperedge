@extends('layouts.student')
@section('title', 'Dashboard')
@section('content')

<style>
  :root {
    --indigo:        #4f46e5;
    --indigo2:       #4338ca;
    --indigo3:       #6366f1;
    --indigo-light:  #eef2ff;
    --indigo-border: rgba(79,70,229,0.2);
    --charcoal:      #1c2333;
  }

  @php
    $completed = $modules->filter(fn($m) => $m->progress && $m->progress->is_completed)->count();
    $total     = $modules->count();
    $pct       = $total > 0 ? round(($completed / $total) * 100) : 0;
  @endphp

  .dash-wrap {
    max-width: 1140px;
    margin: 0 auto;
    padding-bottom: 64px;
  }

  /* ── PAGE HEADER ───────────────────────── */
  .dash-header {
    padding: 40px 0 28px;
    border-bottom: 2px solid var(--ink);
    margin-bottom: 32px;
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: end;
    gap: 20px;
    opacity: 0;
    transform: translateY(16px);
  }
  .greeting-eyebrow {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: var(--indigo);
    margin-bottom: 8px;
  }
  .dash-headline {
    font-family: 'Syne', sans-serif;
    font-size: 38px;
    font-weight: 800;
    letter-spacing: -0.05em;
    color: var(--ink);
    line-height: 1;
    margin-bottom: 7px;
  }
  .dash-headline em { font-style: normal; color: var(--indigo); }
  .dash-sub { font-size: 13px; color: var(--muted); }
  .dash-date-block { text-align: right; }
  .dash-date-num {
    font-family: 'Syne', sans-serif;
    font-size: 52px;
    font-weight: 800;
    letter-spacing: -0.06em;
    color: var(--muted2);
    line-height: 1;
  }
  .dash-date-label {
    font-size: 10px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-top: 4px;
  }

  /* ── NOTICE BANNERS ─────────────────────── */
  .notice {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 14px 18px;
    border-radius: var(--r);
    border: 1px solid;
    margin-bottom: 14px;
    font-size: 13px;
    opacity: 0;
    transform: translateX(-10px);
  }
  .notice.amber {
    background: var(--amber-light);
    border-color: var(--amber-border);
    color: var(--amber);
  }
  .notice.green {
    background: var(--green-light);
    border-color: var(--green-border);
    color: var(--green);
  }
  .notice-icon { font-size: 18px; flex-shrink: 0; margin-top: -1px; }
  .notice-title {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-bottom: 3px;
  }
  .notice-body { font-size: 12px; opacity: 0.8; line-height: 1.5; }

  /* ── KPI STRIP ──────────────────────────── */
  .kpi-strip {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
    margin-bottom: 28px;
    background: var(--surface);
    opacity: 0;
    transform: translateY(12px);
  }
  .kpi {
    padding: 26px 22px;
    border-right: 1px solid var(--border);
    transition: background 0.2s;
  }
  .kpi:last-child { border-right: none; }
  .kpi:hover { background: var(--bg); }
  .kpi-label {
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 14px;
  }
  .kpi-value {
    font-family: 'Syne', sans-serif;
    font-size: 42px;
    font-weight: 800;
    letter-spacing: -0.06em;
    color: var(--ink);
    line-height: 1;
  }
  .kpi-value.indigo { color: var(--indigo); }
  .kpi-value.green  { color: var(--green); }
  .kpi-value.muted  { color: var(--muted2); }

  /* ── OVERALL PROGRESS BAR ───────────────── */
  .progress-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    padding: 22px 24px;
    margin-bottom: 28px;
    opacity: 0;
    transform: translateY(10px);
  }
  .progress-card-head {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 12px;
  }
  .progress-card-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--muted);
  }
  .progress-card-pct {
    font-family: 'JetBrains Mono', monospace;
    font-size: 22px;
    font-weight: 700;
    color: var(--indigo);
    letter-spacing: -0.03em;
  }
  .progress-track {
    height: 8px;
    background: var(--surface2);
    border-radius: 4px;
    overflow: hidden;
    border: 1px solid var(--border);
    margin-bottom: 10px;
  }
  .progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--indigo), var(--indigo3));
    border-radius: 4px;
    width: 0%;
    transition: width 1.4s cubic-bezier(0.4,0,0.2,1);
  }
  .progress-fill.complete { background: linear-gradient(90deg, var(--green), #22c55e); }
  .progress-milestones {
    display: flex;
    justify-content: space-between;
  }
  .progress-milestone {
    font-size: 9px;
    color: var(--muted2);
    font-weight: 600;
    letter-spacing: 0.5px;
  }

  /* ── MAIN GRID ──────────────────────────── */
  .dash-grid {
    display: grid;
    grid-template-columns: 1fr 220px;
    gap: 28px;
    align-items: start;
  }

  /* ── SECTION HEADING ────────────────────── */
  .section-label {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--border);
    opacity: 0;
  }
  .section-label-text {
    font-family: 'Syne', sans-serif;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--ink);
  }
  .section-count { font-size: 10px; color: var(--muted); font-weight: 400; margin-left: 6px; }

  /* ── MODULE ROWS ────────────────────────── */
  .module-row {
    display: grid;
    grid-template-columns: 52px 1fr auto;
    align-items: center;
    gap: 18px;
    padding: 15px 0;
    border-bottom: 1px solid var(--border);
    opacity: 0;
    transform: translateX(-12px);
  }
  .module-row:last-child { border-bottom: none; }

  .mod-num {
    width: 52px; height: 52px;
    border-radius: var(--r);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif;
    font-size: 14px;
    font-weight: 800;
    flex-shrink: 0;
    letter-spacing: -0.03em;
  }
  .mod-num.done    { background: var(--green-light);  color: var(--green);  border: 1px solid var(--green-border); }
  .mod-num.open    { background: var(--indigo-light); color: var(--indigo); border: 1px solid var(--indigo-border); }
  .mod-num.voucher { background: var(--amber-light);  color: var(--amber);  border: 1px solid var(--amber-border); }
  .mod-num.locked  { background: var(--surface2);     color: var(--muted2); border: 1px solid var(--border); }

  .mod-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 3px;
    letter-spacing: -0.01em;
  }
  .module-row.is-locked .mod-title { color: var(--ink3); }
  .mod-meta { font-size: 12px; color: var(--muted); }

  .mod-bar {
    height: 3px;
    background: var(--surface2);
    border-radius: 2px;
    margin-top: 7px;
    overflow: hidden;
  }
  .mod-bar-fill {
    height: 100%;
    border-radius: 2px;
    transition: width 0.8s ease;
  }
  .mod-bar-fill.indigo { background: var(--indigo); }
  .mod-bar-fill.green  { background: var(--green); }

  /* Module action button */
  .mod-open-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 7px 16px;
    background: var(--charcoal);
    color: #fff;
    border: 1px solid var(--charcoal);
    border-radius: var(--r);
    font-size: 12px;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
    transition: all 0.18s;
    white-space: nowrap;
  }
  .mod-open-btn:hover { background: #263045; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(28,35,51,0.18); }

  /* Status badges inline */
  .mod-status {
    display: inline-block;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 20px;
    border: 1px solid;
    white-space: nowrap;
  }
  .mod-status.done    { background: var(--green-light);  color: var(--green);  border-color: var(--green-border); }
  .mod-status.voucher { background: var(--amber-light);  color: var(--amber);  border-color: var(--amber-border); }
  .mod-status.locked  { background: var(--surface2);     color: var(--muted);  border-color: var(--border); }

  .empty-state {
    padding: 40px;
    text-align: center;
    border: 1px dashed var(--border2);
    border-radius: var(--r);
    color: var(--muted);
    font-size: 13px;
  }

  /* ── SIDEBAR ACTIONS ────────────────────── */
  .actions-panel { opacity: 0; transform: translateX(12px); }
  .actions-head {
    font-family: 'Syne', sans-serif;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--ink);
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--border);
  }
  .action-list { display: flex; flex-direction: column; gap: 6px; }

  /* Certificate card */
  .cert-card {
    background: var(--charcoal);
    border-radius: var(--r-lg);
    padding: 20px;
    position: relative;
    overflow: hidden;
    margin-bottom: 6px;
  }
  .cert-card::before {
    content: '';
    position: absolute;
    top: -30px; right: -30px;
    width: 100px; height: 100px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(99,102,241,0.3), transparent 70%);
  }
  .cert-eyebrow {
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.3);
    margin-bottom: 6px;
  }
  .cert-title {
    font-family: 'Syne', sans-serif;
    font-size: 16px;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.03em;
    line-height: 1.2;
    margin-bottom: 8px;
  }
  .cert-copy {
    font-size: 11px;
    color: rgba(255,255,255,0.45);
    line-height: 1.5;
    margin-bottom: 16px;
  }
  .cert-issued-code {
    font-family: 'JetBrains Mono', monospace;
    font-size: 11px;
    color: var(--indigo3);
    margin-bottom: 12px;
    word-break: break-all;
  }
  .cert-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: var(--r);
    background: var(--indigo);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
    transition: all 0.18s;
    border: none;
    cursor: pointer;
  }
  .cert-btn:hover { background: var(--indigo2); }
  .cert-btn.disabled { opacity: 0.35; pointer-events: none; cursor: not-allowed; }
</style>

@php
  $completed = $modules->filter(fn($m) => $m->progress && $m->progress->is_completed)->count();
  $total     = $modules->count();
  $pct       = $total > 0 ? round(($completed / $total) * 100) : 0;
@endphp

<div class="dash-wrap">

  {{-- Header --}}
  <div class="dash-header" id="dh">
    <div>
      <div class="greeting-eyebrow">{{ now()->hour < 12 ? 'Good morning' : (now()->hour < 18 ? 'Good afternoon' : 'Good evening') }}</div>
      <div class="dash-headline">Welcome back, <em>{{ $user->first_name }}.</em></div>
      <div class="dash-sub">Continue your HTML certification journey.</div>
    </div>
    <div class="dash-date-block">
      <div class="dash-date-num">{{ now()->format('d') }}</div>
      <div class="dash-date-label">{{ now()->format('l, M Y') }}</div>
    </div>
  </div>

  {{-- Notices --}}
  @if(!$hasVoucher)
  <div class="notice amber" id="notice-voucher">
    <div class="notice-icon">🎟️</div>
    <div>
      <div class="notice-title">Voucher Required</div>
      <div class="notice-body">Contact your facilitator or admin to receive your exam access voucher after payment.</div>
    </div>
  </div>
  @endif

  @if($certificate)
  <div class="notice green" id="notice-cert">
    <div class="notice-icon">🏅</div>
    <div>
      <div class="notice-title">Certificate Issued</div>
      <div class="notice-body">Code: <strong>{{ $certificate->certificate_code }}</strong> — A copy has been sent to your email.</div>
    </div>
  </div>
  @endif

  {{-- KPIs --}}
  <div class="kpi-strip" id="ks">
    <div class="kpi">
      <div class="kpi-label">Completed</div>
      <div class="kpi-value indigo">{{ $completed }}</div>
    </div>
    <div class="kpi">
      <div class="kpi-label">Total Modules</div>
      <div class="kpi-value">{{ $total }}</div>
    </div>
    <div class="kpi">
      <div class="kpi-label">Progress</div>
      <div class="kpi-value {{ $pct == 100 ? 'green' : 'indigo' }}">{{ $pct }}<small style="font-size:18px;letter-spacing:0">%</small></div>
    </div>
    <div class="kpi">
      <div class="kpi-label">Certificate</div>
      <div class="kpi-value {{ $certificate ? 'green' : 'muted' }}">{{ $certificate ? '✓' : '—' }}</div>
    </div>
  </div>

  {{-- Overall Progress --}}
  <div class="progress-card" id="pc">
    <div class="progress-card-head">
      <div class="progress-card-label">Overall Progress</div>
      <div class="progress-card-pct">{{ $pct }}%</div>
    </div>
    <div class="progress-track">
      <div class="progress-fill {{ $pct == 100 ? 'complete' : '' }}" id="pf" data-width="{{ $pct }}"></div>
    </div>
    <div class="progress-milestones">
      <span class="progress-milestone">Start</span>
      <span class="progress-milestone">25%</span>
      <span class="progress-milestone">50%</span>
      <span class="progress-milestone">75%</span>
      <span class="progress-milestone">100% 🏆</span>
    </div>
  </div>

  {{-- Main Grid --}}
  <div class="dash-grid">

    {{-- Modules --}}
    <div>
      @if($allModulesCompleted && !$finalQuizPassed && $finalQuiz)
      <div class="final-exam-card" style="background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); border-radius: var(--r-lg); padding: 28px 24px; margin-bottom: 28px; position: relative; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(217, 119, 6, 0.3); border: 1px solid rgba(251, 191, 36, 0.4); opacity: 0; transform: translateY(12px);" id="fec">
        <!-- Floating shapes/icons for visual flair -->
        <div style="position: absolute; right: -20px; bottom: -20px; font-size: 120px; opacity: 0.15; pointer-events: none; transform: rotate(15deg);">🎓</div>
        <div style="position: relative; z-index: 2;">
          <div style="font-size: 10px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; color: rgba(255, 255, 255, 0.9); margin-bottom: 8px;">UNLOCKED: FINAL CERTIFICATION</div>
          <h2 style="font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 800; color: #fff; line-height: 1.1; letter-spacing: -0.04em; margin-bottom: 10px;">HTML Developer Certification Exam</h2>
          <p style="color: rgba(255, 255, 255, 0.95); font-size: 13px; line-height: 1.5; max-width: 580px; margin-bottom: 20px;">
            Outstanding achievement! You have completed all learning modules and code challenges. You are now fully eligible to take the final evaluation. Pass it to unlock and print your official credentials.
          </p>
          <div style="display: flex; flex-wrap: wrap; gap: 16px; align-items: center;">
            <a href="{{ route('student.quiz.show', $finalQuiz->id) }}" class="btn" style="background: #1c2333; color: #fff; font-size: 13px; font-weight: 700; padding: 12px 26px; border-radius: var(--r); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.2)';" onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
              Start Certification Exam →
            </a>
            <span style="font-size: 11px; font-weight: 600; color: rgba(255, 255, 255, 0.95); display: inline-flex; align-items: center; gap: 4px;">
              <span>⏱</span> 30-Point Assessment
            </span>
          </div>
        </div>
      </div>
      @endif

      <div class="section-label" id="sl-mods">
        <div class="section-label-text">
          Your Modules
          <span class="section-count">{{ $total }}</span>
        </div>
      </div>

      @forelse($modules as $module)
        @php
          $p           = $module->progress;
          $isUnlocked  = $p && $p->is_unlocked;
          $isCompleted = $p && $p->is_completed;
          $rowClass    = $isCompleted ? 'is-completed' : ($isUnlocked ? 'is-unlocked' : 'is-locked');
          $numClass    = $isCompleted ? 'done' : ($isUnlocked ? ($hasVoucher ? 'open' : 'voucher') : 'locked');
          $barPct      = $isCompleted ? 100 : 0;
          $barColor    = $isCompleted ? 'green' : 'indigo';
        @endphp
        <div class="module-row {{ $rowClass }} mod-row">
          <div class="mod-num {{ $numClass }}">{{ str_pad($module->order, 2, '0', STR_PAD_LEFT) }}</div>
          <div>
            <div class="mod-title">{{ $module->title }}</div>
            <div class="mod-meta">{{ $module->description ?? 'Module ' . $module->order }}</div>
            <div class="mod-bar">
              <div class="mod-bar-fill {{ $barColor }}" style="width:{{ $barPct }}%"></div>
            </div>
          </div>
          <div>
            @if($isCompleted)
              <span class="mod-status done">Completed</span>
            @elseif($isUnlocked && $hasVoucher)
              <a href="{{ route('student.module.show', $module->id) }}" class="mod-open-btn">Open →</a>
            @elseif($isUnlocked && !$hasVoucher)
              <span class="mod-status voucher">Needs Voucher</span>
            @else
              <span class="mod-status locked">Locked</span>
            @endif
          </div>
        </div>
      @empty
        <div class="empty-state">No modules available yet. Check back soon.</div>
      @endforelse
    </div>

    {{-- Actions / Certificate Panel --}}
    <div class="actions-panel" id="ap">
      <div class="actions-head">Certification</div>

      <div class="cert-card">
        <div class="cert-eyebrow">HTML Developer</div>
        <div class="cert-title">Certificate of Completion</div>
        @if($certificate)
          <div class="cert-issued-code">{{ $certificate->certificate_code }}</div>
          <a href="{{ route('student.certificate') }}" class="cert-btn">🏅 View Certificate</a>
        @elseif($allModulesCompleted && $finalQuizPassed)
          <div class="cert-copy" style="color:rgba(255,255,255,0.75);margin-bottom:12px;font-size:12px;line-height:1.4;">Excellent! You've passed the final certification exam. View your credential below.</div>
          <a href="{{ route('student.certificate') }}" class="cert-btn" style="background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); border: none;">🏅 View Certificate</a>
        @else
          <div class="cert-copy">Complete all modules and pass the final exam to earn your official certificate.</div>
          <button class="cert-btn disabled" disabled>🏅 Not yet earned</button>
        @endif
      </div>

      {{-- Progress summary --}}
      <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--r-lg);padding:16px;margin-top:6px">
        <div style="font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--muted);margin-bottom:12px;">Summary</div>
        <div style="display:flex;flex-direction:column;gap:9px;">
          <div style="display:flex;justify-content:space-between;align-items:center;font-size:12px;">
            <span style="color:var(--ink3);">Completed</span>
            <span style="font-family:'JetBrains Mono',monospace;font-size:11px;font-weight:600;color:var(--green);">{{ $completed }} / {{ $total }}</span>
          </div>
          <div style="display:flex;justify-content:space-between;align-items:center;font-size:12px;">
            <span style="color:var(--ink3);">Voucher</span>
            <span style="font-family:'JetBrains Mono',monospace;font-size:11px;font-weight:600;color:{{ $hasVoucher ? 'var(--green)' : 'var(--amber)' }}">{{ $hasVoucher ? 'Active' : 'Pending' }}</span>
          </div>
          <div style="display:flex;justify-content:space-between;align-items:center;font-size:12px;">
            <span style="color:var(--ink3);">Certificate</span>
            <span style="font-family:'JetBrains Mono',monospace;font-size:11px;font-weight:600;color:{{ $certificate ? 'var(--green)' : 'var(--muted)' }}">{{ $certificate ? 'Issued' : 'Pending' }}</span>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

  tl.to('#dh',      { opacity: 1, y: 0, duration: 0.6 })
    .to('#notice-voucher, #notice-cert', { opacity: 1, x: 0, duration: 0.35, stagger: 0.07 }, '-=0.3')
    .to('#ks',      { opacity: 1, y: 0, duration: 0.5 }, '-=0.2')
    .to('#pc',      { opacity: 1, y: 0, duration: 0.4 }, '-=0.2')
    .to('#fec',     { opacity: 1, y: 0, duration: 0.4 }, '-=0.2')
    .to('#sl-mods', { opacity: 1, duration: 0.3 }, '-=0.1')
    .to('.mod-row', { opacity: 1, x: 0, duration: 0.35, stagger: 0.07 }, '-=0.1')
    .to('#ap',      { opacity: 1, x: 0, duration: 0.4 }, '-=0.5');

  // Animate progress bar
  setTimeout(() => {
    const fill = document.getElementById('pf');
    if (fill) fill.style.width = fill.dataset.width + '%';
  }, 900);
});
</script>

@endsection