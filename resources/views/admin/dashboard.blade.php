@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

<style>
  /* ── PAGE TOKENS ── */
  :root {
    --gold:        #c9972a;
    --gold2:       #dba94b;
    --gold-light:  #fdf6e3;
    --gold-border: rgba(201,151,42,0.22);
    --navy:        #0d1f3c;
    --navy2:       #162d52;
    --navy3:       #1e3a69;
    --navy-light:  #eef2f9;
    --navy-border: rgba(13,31,60,0.15);
  }

  .dash-wrap {
    max-width: 1140px;
    margin: 0 auto;
    padding-bottom: 64px;
  }

  /* ── PAGE HEADER ───────────────────────── */
  .dash-header {
    padding: 40px 0 28px;
    border-bottom: 2px solid var(--ink);
    margin-bottom: 36px;
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: end;
    gap: 20px;
    opacity: 0;
    transform: translateY(16px);
  }
  .dash-headline {
    font-family: 'DM Sans', sans-serif;
    font-size: 38px;
    font-weight: 800;
    letter-spacing: -0.03em;
    color: var(--ink);
    line-height: 1;
    margin-bottom: 6px;
  }
  .dash-headline span { color: var(--gold); }
  .dash-sub { font-size: 13px; color: var(--muted); }
  .dash-date {
    font-family: 'JetBrains Mono', monospace;
    font-size: 10px;
    color: var(--muted);
    letter-spacing: 2px;
    text-transform: uppercase;
    text-align: right;
    background: var(--gold-light);
    border: 1px solid var(--gold-border);
    padding: 8px 16px;
    border-radius: 6px;
  }

  /* ── KPI STRIP ──────────────────────────── */
  .kpi-strip {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
    margin-bottom: 36px;
    background: var(--surface);
    opacity: 0;
    transform: translateY(12px);
  }
  .kpi {
    padding: 28px 24px;
    border-right: 1px solid var(--border);
    position: relative;
    overflow: hidden;
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
    font-family: 'DM Sans', sans-serif;
    font-size: 46px;
    font-weight: 900;
    letter-spacing: -0.02em;
    color: var(--ink);
    line-height: 1;
  }
  .kpi-value.accent-navy  { color: var(--navy2); }
  .kpi-value.accent-gold  { color: var(--gold); }
  .kpi-value.accent-green { color: #1a6b42; }
  .kpi-value.accent-red   { color: #c0392b; }
  .kpi-alert::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: var(--gold);
  }
  .kpi-badge {
    display: inline-block;
    margin-top: 8px;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 2px 8px;
    border-radius: 20px;
    background: var(--gold-light);
    color: var(--gold);
    border: 1px solid var(--gold-border);
  }

  /* ── MAIN GRID ──────────────────────────── */
  .dash-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 220px;
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
    font-family: 'DM Sans', sans-serif;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--ink);
  }
  .section-label-link {
    font-size: 11px;
    color: var(--muted);
    text-decoration: none;
    transition: color 0.2s;
  }
  .section-label-link:hover { color: var(--gold); }

  /* ── STUDENT TABLE ──────────────────────── */
  .student-table { width:100%; border-collapse:collapse; }
  .student-table th {
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--muted2);
    padding: 0 0 10px;
    text-align: left;
    border-bottom: 1px solid var(--border);
  }
  .student-table td {
    padding: 11px 0;
    border-bottom: 1px solid var(--border);
    font-size: 13px;
    color: var(--ink2);
    vertical-align: middle;
  }
  .student-table tr:last-child td { border-bottom: none; }
  .student-table tr { opacity: 0; transform: translateX(-10px); }
  .s-name { font-weight: 600; color: var(--ink); letter-spacing: -0.01em; }
  .s-email { color: var(--muted); font-size: 11px; }
  .s-date  { color: var(--muted); font-size: 11px; white-space: nowrap; }

  /* ── VOUCHER ROWS ───────────────────────── */
  .voucher-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 11px 0;
    border-bottom: 1px solid var(--border);
    opacity: 0;
    transform: translateX(-10px);
  }
  .voucher-row:last-child { border-bottom: none; }
  .v-name { font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 2px; letter-spacing: -0.01em; }
  .v-code { font-family: 'JetBrains Mono', monospace; font-size: 10px; color: var(--muted); letter-spacing: 1px; }
  .v-badge {
    display: inline-block;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 3px 9px;
    border-radius: 4px;
    white-space: nowrap;
    border: 1px solid;
  }
  .v-badge.unassigned { background: var(--surface2); color: var(--muted); border-color: var(--border); }
  .v-badge.approved   { background: #ecfdf5; color: #1a6b42; border-color: rgba(26,107,66,0.2); }
  .v-badge.pending    { background: var(--gold-light); color: var(--gold); border-color: var(--gold-border); }

  .empty-state {
    padding: 28px;
    text-align: center;
    border: 1px dashed var(--border2);
    border-radius: var(--r);
    color: var(--muted);
    font-size: 12px;
  }

  /* ── QUICK ACTIONS PANEL ────────────────── */
  .actions-panel { opacity: 0; transform: translateX(12px); }
  .actions-head {
    font-family: 'DM Sans', sans-serif;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--ink);
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--border);
  }
  .action-list { display: flex; flex-direction: column; gap: 6px; }
  .action-link {
    display: block;
    padding: 12px 14px;
    border: 1px solid var(--border);
    border-radius: var(--r);
    text-decoration: none;
    transition: all 0.18s;
  }
  .action-link:hover { border-color: var(--border2); background: var(--surface2); }
  .action-link.primary {
    background: var(--navy);
    border-color: var(--navy);
    color: #fff;
  }
  .action-link.primary:hover { background: var(--navy2); border-color: var(--navy2); }
  .action-link.gold {
    background: var(--gold-light);
    border-color: var(--gold-border);
  }
  .action-link.gold:hover { background: #fdeec4; }
  .action-eyebrow {
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 2px;
  }
  .action-link.primary .action-eyebrow { color: rgba(255,255,255,0.4); }
  .action-text {
    font-size: 12px;
    font-weight: 600;
    color: var(--ink2);
    letter-spacing: -0.01em;
  }
  .action-link.primary .action-text { color: #fff; }
  .action-link.gold .action-text { color: var(--gold); }
</style>

<div class="dash-wrap">

  {{-- Header --}}
  <div class="dash-header" id="dh">
    <div>
      <div class="dash-headline">Administration<span>.</span></div>
      <div class="dash-sub">HyperEdge Academy — System Overview</div>
    </div>
    <div class="dash-date">{{ now()->format('M j, Y') }}</div>
  </div>

  {{-- KPIs --}}
  <div class="kpi-strip" id="ks">
    <div class="kpi">
      <div class="kpi-label">Students</div>
      <div class="kpi-value accent-navy">{{ $totalStudents }}</div>
    </div>
    <div class="kpi">
      <div class="kpi-label">Facilitators</div>
      <div class="kpi-value">{{ $totalTeachers }}</div>
    </div>
    <div class="kpi {{ $pendingVouchers > 0 ? 'kpi-alert' : '' }}">
      <div class="kpi-label">Pending Approvals</div>
      <div class="kpi-value {{ $pendingVouchers > 0 ? 'accent-gold' : '' }}">{{ $pendingVouchers }}</div>
      @if($pendingVouchers > 0)
        <div class="kpi-badge">Needs attention</div>
      @endif
    </div>
    <div class="kpi">
      <div class="kpi-label">Certificates Issued</div>
      <div class="kpi-value accent-green">{{ $totalCerts }}</div>
    </div>
  </div>

  {{-- Advanced Analytics Panel --}}
  <div style="background:var(--surface); border:1px solid var(--border); border-radius:var(--r-lg); padding:28px 24px; margin-bottom:36px; opacity:0; transform:translateY(12px);" id="analytics-section">
      <!-- Title -->
      <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--border); padding-bottom:14px; margin-bottom:20px;">
          <h2 style="font-family:'DM Sans',sans-serif; font-size:16px; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; display:inline-flex; align-items:center; gap:8px; color:var(--navy);">
              📊 Advanced Analytics Dashboard
          </h2>
          <span style="font-size:11px; color:var(--muted); font-weight:600; font-family:'JetBrains Mono',monospace;">{{ $attempts->total() }} attempts filtered</span>
      </div>

      <!-- Filters Panel -->
      <form method="GET" action="{{ url()->current() }}" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)) auto; gap:16px; align-items:end; margin-bottom:24px; background:var(--bg); padding:16px; border-radius:var(--r); border:1px solid var(--border);">
          <div>
              <label style="display:block; font-size:9px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:var(--muted); margin-bottom:6px;">Date Range</label>
              <select name="date_range" style="width:100%; padding:10px; border:1px solid var(--border); border-radius:var(--r); background:var(--surface); font-size:13px; color:var(--ink2);">
                  <option value="">All Time</option>
                  <option value="7_days" {{ request('date_range') == '7_days' ? 'selected' : '' }}>Last 7 Days</option>
                  <option value="30_days" {{ request('date_range') == '30_days' ? 'selected' : '' }}>Last 30 Days</option>
              </select>
          </div>
          <div>
              <label style="display:block; font-size:9px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:var(--muted); margin-bottom:6px;">Quiz Target</label>
              <select name="quiz_id" style="width:100%; padding:10px; border:1px solid var(--border); border-radius:var(--r); background:var(--surface); font-size:13px; color:var(--ink2);">
                  <option value="">All Quizzes & Exams</option>
                  @foreach($quizzes as $q)
                      <option value="{{ $q->id }}" {{ request('quiz_id') == $q->id ? 'selected' : '' }}>{{ $q->title }}</option>
                  @endforeach
              </select>
          </div>
          <div>
              <label style="display:block; font-size:9px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:var(--muted); margin-bottom:6px;">Score Sort / Threshold</label>
              <select name="score_filter" style="width:100%; padding:10px; border:1px solid var(--border); border-radius:var(--r); background:var(--surface); font-size:13px; color:var(--ink2);">
                  <option value="">All Scores</option>
                  <option value="passed" {{ request('score_filter') == 'passed' ? 'selected' : '' }}>Passed Attempts Only</option>
                  <option value="failed" {{ request('score_filter') == 'failed' ? 'selected' : '' }}>Failed Attempts Only</option>
                  <option value="high_score" {{ request('score_filter') == 'high_score' ? 'selected' : '' }}>Highest Scores First</option>
                  <option value="low_score" {{ request('score_filter') == 'low_score' ? 'selected' : '' }}>Lowest Scores First</option>
              </select>
          </div>
          <div style="display:flex; gap:8px;">
              <button type="submit" class="btn btn-primary" style="padding:11px 20px; border:none; background:var(--navy); color:#fff;">Filter 🔍</button>
              @if(request()->anyFilled(['date_range', 'quiz_id', 'score_filter']))
                  <a href="{{ request()->url() }}" class="btn btn-ghost" style="padding:11px 20px; display:inline-flex; align-items:center; text-decoration:none; color:var(--ink3);">Reset ↩</a>
              @endif
          </div>
      </form>

      <!-- Aggregated Analytics Cards -->
      <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-bottom:28px;">
          <div style="background:var(--bg); border:1px solid var(--border); border-radius:var(--r); padding:18px; text-align:center; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
              <div style="font-size:9px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--muted); margin-bottom:8px;">Attempts Count</div>
              <div style="font-family:'DM Sans',sans-serif; font-size:36px; font-weight:900; color:var(--navy); letter-spacing:-0.02em;">{{ $filteredCount }}</div>
          </div>
          <div style="background:var(--bg); border:1px solid var(--border); border-radius:var(--r); padding:18px; text-align:center; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
              <div style="font-size:9px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--muted); margin-bottom:8px;">Average Score</div>
              <div style="font-family:'DM Sans',sans-serif; font-size:36px; font-weight:900; color:var(--gold); letter-spacing:-0.02em;">{{ $averagePct }}%</div>
          </div>
          <div style="background:var(--bg); border:1px solid var(--border); border-radius:var(--r); padding:18px; text-align:center; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
              <div style="font-size:9px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--muted); margin-bottom:8px;">Course Passing Rate</div>
              <div style="font-family:'DM Sans',sans-serif; font-size:36px; font-weight:900; color:#1a6b42; letter-spacing:-0.02em;">{{ $passingRate }}%</div>
          </div>
      </div>

      <!-- attempts List Table -->
      <div style="overflow-x:auto;">
          <table class="student-table" style="width:100%; border-collapse:collapse; min-width:700px;">
              <thead>
                  <tr>
                      <th style="padding:12px 10px; border-bottom:2px solid var(--border); font-size:9px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--muted2); text-align:left;">Student</th>
                      <th style="padding:12px 10px; border-bottom:2px solid var(--border); font-size:9px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--muted2); text-align:left;">Quiz Module</th>
                      <th style="padding:12px 10px; border-bottom:2px solid var(--border); font-size:9px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--muted2); text-align:left;">Date Taken</th>
                      <th style="padding:12px 10px; border-bottom:2px solid var(--border); font-size:9px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--muted2); text-align:center;">Attempt</th>
                      <th style="padding:12px 10px; border-bottom:2px solid var(--border); font-size:9px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--muted2); text-align:center;">Score</th>
                      <th style="padding:12px 10px; border-bottom:2px solid var(--border); font-size:9px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--muted2); text-align:center;">Status</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse($attempts as $att)
                      <tr style="border-bottom:1px solid var(--border); opacity: 1 !important; transform: none !important;">
                          <td style="padding:12px 10px;">
                              <div style="font-weight:600; color:var(--ink); font-size:13.5px;">{{ $att->user->full_name }}</div>
                              <div style="font-size:11px; color:var(--muted);">{{ $att->user->email }}</div>
                          </td>
                          <td style="padding:12px 10px;">
                              <div style="font-weight:600; color:var(--ink2); font-size:13.5px;">{{ $att->quiz->title }}</div>
                              <div style="font-size:10px; color:var(--gold); text-transform:uppercase; letter-spacing:0.5px; font-weight:700; margin-top:2px;">
                                  {{ $att->quiz->type === 'final_exam' ? '🎓 Final Exam' : '📚 Module ' . ($att->quiz->module ? $att->quiz->module->order : 'Assessment') }}
                              </div>
                          </td>
                          <td style="padding:12px 10px; font-size:12px; color:var(--muted);">
                              {{ $att->created_at->format('M j, Y · g:i A') }}
                          </td>
                          <td style="padding:12px 10px; text-align:center; font-family:'JetBrains Mono',monospace; font-size:12px; font-weight:700; color:var(--ink3);">
                              #{{ $att->attempt_number }}
                          </td>
                          <td style="padding:12px 10px; text-align:center;">
                              <span style="font-family:'JetBrains Mono',monospace; font-size:14px; font-weight:800; color:{{ $att->passed ? '#1a6b42' : '#c0392b' }};">
                                  {{ $att->score }}<small style="color:var(--muted); font-weight:500; font-size:11px;">/{{ $att->total_points }}</small>
                              </span>
                          </td>
                          <td style="padding:12px 10px; text-align:center;">
                              <span class="v-badge {{ $att->passed ? 'approved' : 'pending' }}" style="font-size:9px; letter-spacing:1px; font-weight:700; border-radius:12px;">
                                  {{ $att->passed ? 'PASSED' : 'FAILED' }}
                              </span>
                          </td>
                      </tr>
                  @empty
                      <tr>
                          <td colspan="6" style="padding:32px; text-align:center; color:var(--muted); font-size:13px;">No quiz attempts logged matching the selected filters.</td>
                      </tr>
                  @endforelse
              </tbody>
          </table>
      </div>

      <!-- Pagination -->
      <div style="margin-top:20px; display:flex; justify-content:center;">
          {{ $attempts->links() }}
      </div>
  </div>

  {{-- Main Grid --}}
  <div class="dash-grid">

    {{-- Recent Students --}}
    <div>
      <div class="section-label" id="sl-students">
        <div class="section-label-text">Recent Students</div>
        <a href="{{ route('admin.students.index') }}" class="section-label-link">View all →</a>
      </div>

      @if($recentStudents->count())
        <table class="student-table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Joined</th>
            </tr>
          </thead>
          <tbody>
            @foreach($recentStudents as $student)
            <tr class="student-row">
              <td>
                <div class="s-name">{{ $student->full_name }}</div>
                <div class="s-email">{{ $student->email }}</div>
              </td>
              <td class="s-date">{{ $student->created_at->format('M j') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="empty-state">No students registered yet.</div>
      @endif
    </div>

    {{-- Voucher Activity --}}
    <div>
      <div class="section-label" id="sl-vouchers">
        <div class="section-label-text">Voucher Activity</div>
        <a href="{{ route('admin.vouchers.index') }}" class="section-label-link">Manage →</a>
      </div>

      @if($recentVouchers->count())
        @foreach($recentVouchers as $v)
        <div class="voucher-row">
          <div>
            <div class="v-name">{{ $v->assignedTo?->full_name ?? 'Unassigned' }}</div>
            <div class="v-code">{{ $v->code }}</div>
          </div>
          @if(!$v->assigned_to)
            <span class="v-badge unassigned">Unassigned</span>
          @elseif($v->is_approved)
            <span class="v-badge approved">Approved</span>
          @else
            <span class="v-badge pending">Pending</span>
          @endif
        </div>
        @endforeach
      @else
        <div class="empty-state">No vouchers generated yet.</div>
      @endif
    </div>

    {{-- Quick Actions --}}
    <div class="actions-panel" id="ap">
      <div class="actions-head">Actions</div>
      <div class="action-list">
        <a href="{{ route('admin.teachers.create') }}" class="action-link primary">
          <div class="action-eyebrow">Facilitators</div>
          <div class="action-text">Add Facilitator Account</div>
        </a>
        <a href="{{ route('admin.vouchers.index') }}" class="action-link gold">
          <div class="action-eyebrow">Vouchers</div>
          <div class="action-text">Manage Vouchers</div>
        </a>
        <a href="{{ route('admin.students.index') }}" class="action-link">
          <div class="action-eyebrow">Students</div>
          <div class="action-text">Manage Students</div>
        </a>
      </div>
    </div>

  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
  tl.to('#dh',         { opacity: 1, y: 0, duration: 0.6 })
    .to('#ks',         { opacity: 1, y: 0, duration: 0.5 }, '-=0.25')
    .to('#analytics-section', { opacity: 1, y: 0, duration: 0.5 }, '-=0.2')
    .to('#sl-students, #sl-vouchers', { opacity: 1, duration: 0.3, stagger: 0.05 }, '-=0.1')
    .to('.student-row',  { opacity: 1, x: 0, duration: 0.3, stagger: 0.07 }, '-=0.1')
    .to('.voucher-row',  { opacity: 1, x: 0, duration: 0.3, stagger: 0.07 }, '-=0.45')
    .to('#ap',           { opacity: 1, x: 0, duration: 0.4 }, '-=0.45');
});
</script>

@endsection