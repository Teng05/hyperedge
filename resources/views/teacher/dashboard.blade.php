@extends('layouts.teacher')
@section('title', 'Dashboard')
@section('topbar-title', 'Facilitator Dashboard')
@section('content')

<style>
  .dash-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding-bottom: 64px;
  }

  /* ── PAGE HEADER ───────────────────────── */
  .dash-header {
    padding: 30px 0 20px;
    border-bottom: 2px solid var(--ink);
    margin-bottom: 32px;
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: flex-end;
    gap: 20px;
    opacity: 0;
    transform: translateY(16px);
  }
  .dash-headline {
    font-family: 'DM Sans', sans-serif;
    font-size: 36px;
    font-weight: 800;
    letter-spacing: -0.03em;
    color: var(--ink);
    line-height: 1.1;
    margin-bottom: 6px;
  }
  .dash-headline span { color: var(--teal); }
  .dash-sub { font-size: 13.5px; color: var(--muted); }

  /* ── KPI STRIP ──────────────────────────── */
  .kpi-strip {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 32px;
    opacity: 0;
    transform: translateY(12px);
  }
  .kpi-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    padding: 24px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
  }
  .kpi-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
  .kpi-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 12px;
  }
  .kpi-value {
    font-family: 'DM Sans', sans-serif;
    font-size: 48px;
    font-weight: 900;
    letter-spacing: -0.02em;
    color: var(--ink);
    line-height: 1;
  }
  .kpi-value.accent { color: var(--teal); }
  .kpi-value.blue { color: var(--blue); }
  .kpi-border {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3.5px;
    background: var(--teal);
  }
  .kpi-card:nth-child(2) .kpi-border { background: var(--blue); }
  .kpi-card:nth-child(3) .kpi-border { background: var(--slate); }

  /* ── MAIN LAYOUT ────────────────────────── */
  .dash-grid {
    display: grid;
    grid-template-columns: 1fr 280px;
    gap: 28px;
    align-items: start;
  }

  /* ── SECTION HEADING ────────────────────── */
  .section-label {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border);
    opacity: 0;
  }
  .section-label-text {
    font-family: 'DM Sans', sans-serif;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--ink);
  }
  .section-count {
    font-size: 11px;
    color: var(--muted);
    font-weight: 500;
    margin-left: 6px;
    background: var(--surface2);
    padding: 2px 8px;
    border-radius: 20px;
  }
  .section-label-link {
    font-size: 12px;
    color: var(--muted);
    font-weight: 600;
    text-decoration: none;
    transition: color 0.18s;
  }
  .section-label-link:hover { color: var(--teal); }

  /* ── MODULE ROWS ────────────────────────── */
  .module-row {
    display: grid;
    grid-template-columns: 50px 1fr auto;
    align-items: center;
    gap: 20px;
    padding: 16px;
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    background: var(--surface);
    margin-bottom: 12px;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.02);
    transition: all 0.2s ease;
    opacity: 0;
    transform: translateX(-12px);
  }
  .module-row:hover { transform: translateX(2px); border-color: var(--border2); box-shadow: 0 4px 12px rgba(15,23,42,0.03); }

  .mod-num {
    width: 50px;
    height: 50px;
    border-radius: var(--r);
    background: var(--teal-light);
    border: 1px solid var(--teal-border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'DM Sans', sans-serif;
    font-size: 16px;
    font-weight: 800;
    color: var(--teal);
    letter-spacing: -0.01em;
    flex-shrink: 0;
  }
  .mod-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 4px;
    letter-spacing: -0.01em;
  }
  .mod-meta { font-size: 12.5px; color: var(--muted); }
  .mod-meta .dot { color: var(--muted2); margin: 0 6px; }

  .mod-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border: 1px solid var(--border);
    border-radius: var(--r);
    font-size: 12px;
    font-weight: 600;
    color: var(--ink2);
    text-decoration: none;
    background: var(--surface);
    transition: all 0.2s;
    white-space: nowrap;
  }
  .mod-btn:hover {
    border-color: var(--teal);
    background: var(--teal-light);
    color: var(--teal);
    transform: translateY(-1px);
  }

  .empty-state {
    padding: 40px;
    text-align: center;
    border: 1px dashed var(--border2);
    border-radius: var(--r-lg);
    color: var(--muted);
    font-size: 13.5px;
    background: var(--surface);
  }
  .empty-state a {
    color: var(--teal);
    text-decoration: none;
    font-weight: 700;
  }
  .empty-state a:hover { text-decoration: underline; }

  /* ── QUICK ACTIONS ──────────────────────── */
  .actions-panel { opacity: 0; transform: translateX(12px); }
  .actions-head {
    font-family: 'DM Sans', sans-serif;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--ink);
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border);
  }
  .action-list { display: flex; flex-direction: column; gap: 10px; }
  .action-link {
    display: block;
    padding: 14px 18px;
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    text-decoration: none;
    background: var(--surface);
    box-shadow: 0 1px 2px rgba(0,0,0,0.01);
    transition: all 0.2s ease;
  }
  .action-link:hover { border-color: var(--border2); background: var(--surface2); transform: translateY(-1.5px); box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
  .action-link.primary {
    background: var(--teal);
    border-color: var(--teal);
  }
  .action-link.primary:hover { background: var(--teal2); border-color: var(--teal2); box-shadow: 0 4px 12px rgba(13,148,136,0.2); }
  .action-eyebrow {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 3px;
  }
  .action-link.primary .action-eyebrow { color: rgba(255,255,255,0.6); }
  .action-text {
    font-size: 13px;
    font-weight: 700;
    color: var(--ink2);
  }
  .action-link.primary .action-text { color: #fff; }

  /* Filters styling */
  .filter-select {
    width:100%;
    padding:10px 12px;
    border:1px solid var(--border);
    border-radius:var(--r);
    background:var(--surface);
    font-size:13.5px;
    color:var(--ink2);
    outline: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
  }
  .filter-select:focus {
    border-color: var(--teal);
    box-shadow: 0 0 0 3px rgba(13,148,136,0.1);
  }
</style>

<div class="dash-wrap">

  {{-- Header --}}
  <div class="dash-header" id="dh">
    <div>
      <div class="dash-headline">{{ $teacher->first_name }}'s Classroom<span>.</span></div>
      <div class="dash-sub">Manage your coursework modules, track learning paths, and audit quizzes.</div>
    </div>
    <a href="{{ route('teacher.modules.create') }}" class="btn btn-primary">
      <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
      </svg>
      <span>New Module</span>
    </a>
  </div>

  {{-- KPIs --}}
  <div class="kpi-strip" id="ks">
    <div class="kpi-card">
      <div class="kpi-border"></div>
      <div class="kpi-label">Active Modules</div>
      <div class="kpi-value accent">{{ $modules->count() }}</div>
    </div>
    <div class="kpi-card">
      <div class="kpi-border"></div>
      <div class="kpi-label">Assessments & Exams</div>
      <div class="kpi-value blue">{{ $totalQuizzes }}</div>
    </div>
    <div class="kpi-card">
      <div class="kpi-border"></div>
      <div class="kpi-label">Total Classroom Students</div>
      <div class="kpi-value">{{ $totalStudents }}</div>
    </div>
  </div>

  {{-- Advanced Analytics Panel --}}
  <div class="card mb-6" style="opacity:0; transform:translateY(12px);" id="analytics-section">
      <!-- Title -->
      <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--border); padding-bottom:16px; margin-bottom:20px;">
          <h2 style="font-family:'DM Sans',sans-serif; font-size:16px; font-weight:800; text-transform:uppercase; letter-spacing:1px; display:inline-flex; align-items:center; gap:8px; color:var(--ink);">
              📊 Student Performance & Quiz Audit
          </h2>
          <span style="font-size:11px; color:var(--muted); font-weight:600; font-family:'JetBrains Mono',monospace; background: var(--surface2); padding: 4px 10px; border-radius: 20px;">
            {{ $attempts->total() }} records
          </span>
      </div>

      <!-- Filters Panel -->
      <form method="GET" action="{{ url()->current() }}" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)) auto; gap:16px; align-items:end; margin-bottom:24px; background:var(--surface2); padding:20px; border-radius:var(--r); border:1px solid var(--border);">
          <div>
              <label style="display:block; font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--ink3); margin-bottom:8px;">Date Range</label>
              <select name="date_range" class="filter-select">
                  <option value="">All Time</option>
                  <option value="7_days" {{ request('date_range') == '7_days' ? 'selected' : '' }}>Last 7 Days</option>
                  <option value="30_days" {{ request('date_range') == '30_days' ? 'selected' : '' }}>Last 30 Days</option>
              </select>
          </div>
          <div>
              <label style="display:block; font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--ink3); margin-bottom:8px;">Quiz Target</label>
              <select name="quiz_id" class="filter-select">
                  <option value="">All Quizzes & Exams</option>
                  @foreach($teacherQuizzes as $q)
                      <option value="{{ $q->id }}" {{ request('quiz_id') == $q->id ? 'selected' : '' }}>{{ $q->title }}</option>
                  @endforeach
              </select>
          </div>
          <div>
              <label style="display:block; font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--ink3); margin-bottom:8px;">Score Sort / Threshold</label>
              <select name="score_filter" class="filter-select">
                  <option value="">All Scores</option>
                  <option value="passed" {{ request('score_filter') == 'passed' ? 'selected' : '' }}>Passed Attempts Only</option>
                  <option value="failed" {{ request('score_filter') == 'failed' ? 'selected' : '' }}>Failed Attempts Only</option>
                  <option value="high_score" {{ request('score_filter') == 'high_score' ? 'selected' : '' }}>Highest Scores First</option>
                  <option value="low_score" {{ request('score_filter') == 'low_score' ? 'selected' : '' }}>Lowest Scores First</option>
              </select>
          </div>
          <div style="display:flex; gap:8px;">
              <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">
                <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <span>Filter</span>
              </button>
              @if(request()->anyFilled(['date_range', 'quiz_id', 'score_filter']))
                  <a href="{{ request()->url() }}" class="btn btn-ghost" style="padding: 10px 16px;">
                    <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18.5"></path>
                    </svg>
                  </a>
              @endif
          </div>
      </form>

      <!-- Aggregated Analytics Cards -->
      <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-bottom:28px;">
          <div style="background:var(--bg); border:1px solid var(--border); border-radius:var(--r); padding:20px; text-align:center; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--border2)'" onmouseout="this.style.borderColor='var(--border)'">
              <div style="font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--muted); margin-bottom:8px;">Attempts Count</div>
              <div style="font-family:'DM Sans',sans-serif; font-size:40px; font-weight:900; color:var(--ink); letter-spacing:-0.02em; line-height:1;">{{ $filteredCount }}</div>
          </div>
          <div style="background:var(--bg); border:1px solid var(--border); border-radius:var(--r); padding:20px; text-align:center; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--border2)'" onmouseout="this.style.borderColor='var(--border)'">
              <div style="font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--muted); margin-bottom:8px;">Average score</div>
              <div style="font-family:'DM Sans',sans-serif; font-size:40px; font-weight:900; color:var(--teal); letter-spacing:-0.02em; line-height:1;">{{ $averagePct }}%</div>
          </div>
          <div style="background:var(--bg); border:1px solid var(--border); border-radius:var(--r); padding:20px; text-align:center; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--border2)'" onmouseout="this.style.borderColor='var(--border)'">
              <div style="font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--muted); margin-bottom:8px;">Classroom Success rate</div>
              <div style="font-family:'DM Sans',sans-serif; font-size:40px; font-weight:900; color:var(--green); letter-spacing:-0.02em; line-height:1;">{{ $passingRate }}%</div>
          </div>
      </div>

      <!-- Attempts List Table -->
      <div class="card-table-wrapper">
          <table class="student-table">
              <thead>
                  <tr>
                      <th>Student</th>
                      <th>Quiz Module</th>
                      <th>Date Taken</th>
                      <th style="text-align:center;">Attempt</th>
                      <th style="text-align:center;">Score</th>
                      <th style="text-align:center;">Status</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse($attempts as $att)
                      <tr>
                          <td>
                              <div style="font-weight:700; color:var(--ink); font-size:13.5px;">{{ $att->user->full_name }}</div>
                              <div style="font-size:11.5px; color:var(--muted); margin-top:2px;">{{ $att->user->email }}</div>
                          </td>
                          <td>
                              <div style="font-weight:700; color:var(--ink2); font-size:13.5px;">{{ $att->quiz->title }}</div>
                              <div style="font-size:10px; color:var(--teal); text-transform:uppercase; letter-spacing:0.5px; font-weight:700; margin-top:3px;">
                                  {{ $att->quiz->type === 'final_exam' ? '🎓 Final Exam' : '📚 Module ' . ($att->quiz->module ? $att->quiz->module->order : 'Assessment') }}
                              </div>
                          </td>
                          <td style="font-size:12.5px; color:var(--ink3);">
                              {{ $att->created_at->format('M j, Y · g:i A') }}
                          </td>
                          <td style="text-align:center; font-family:'JetBrains Mono',monospace; font-size:13px; font-weight:700; color:var(--ink2);">
                              #{{ $att->attempt_number }}
                          </td>
                          <td style="text-align:center;">
                              <span style="font-family:'JetBrains Mono',monospace; font-size:14px; font-weight:800; color:{{ $att->passed ? 'var(--green)' : 'var(--red)' }};">
                                  {{ $att->score }}<small style="color:var(--muted); font-weight:600; font-size:11px;">/{{ $att->total_points }}</small>
                              </span>
                          </td>
                          <td style="text-align:center;">
                              <span class="badge {{ $att->passed ? 'badge-done' : 'badge-no' }}" style="{{ $att->passed ? '' : 'background:var(--red-light); color:var(--red); border-color:var(--red-border);' }}">
                                  {{ $att->passed ? 'PASSED' : 'FAILED' }}
                              </span>
                          </td>
                      </tr>
                  @empty
                      <tr>
                          <td colspan="6" style="padding:32px; text-align:center; color:var(--muted); font-size:13.5px;">No classroom quiz attempts logged matching the selected filters.</td>
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

    {{-- Modules --}}
    <div>
      <div class="section-label" id="sl-mods">
        <div class="section-label-text">
          📚 Coursework Modules
          <span class="section-count">{{ $modules->count() }}</span>
        </div>
        <a href="{{ route('teacher.modules.index') }}" class="section-label-link">View all →</a>
      </div>

      @forelse($modules as $module)
        <div class="module-row mod-row">
          <div class="mod-num">{{ str_pad($module->order, 2, '0', STR_PAD_LEFT) }}</div>
          <div>
            <div class="mod-title">{{ $module->title }}</div>
            <div class="mod-meta">
              {{ $module->lessons_count }} {{ Str::plural('lesson', $module->lessons_count) }}
              @if($module->quiz)
                <span class="dot">·</span> Quiz attached
              @endif
            </div>
          </div>
          <a href="{{ route('teacher.modules.show', $module->id) }}" class="mod-btn">
            <span>Manage</span>
            <svg style="width:12px; height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      @empty
        <div class="empty-state">
          No modules yet.<br>
          <a href="{{ route('teacher.modules.create') }}" style="margin-top: 8px; display: inline-block;">Create your first module →</a>
        </div>
      @endforelse
    </div>

    {{-- Quick Actions --}}
    <div class="actions-panel" id="ap">
      <div class="actions-head">Quick Actions</div>
      <div class="action-list">
        <a href="{{ route('teacher.modules.create') }}" class="action-link primary">
          <div class="action-eyebrow">Modules</div>
          <div class="action-text">Create New Module</div>
        </a>
        <a href="{{ route('teacher.modules.index') }}" class="action-link">
          <div class="action-eyebrow">Modules</div>
          <div class="action-text">View All Modules</div>
        </a>
      </div>
    </div>

  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
  tl.to('#dh',      { opacity: 1, y: 0, duration: 0.6 })
    .to('#ks',      { opacity: 1, y: 0, duration: 0.5 }, '-=0.25')
    .to('#analytics-section', { opacity: 1, y: 0, duration: 0.5 }, '-=0.2')
    .to('#sl-mods', { opacity: 1, duration: 0.3 }, '-=0.1')
    .to('.mod-row', { opacity: 1, x: 0, duration: 0.35, stagger: 0.07 }, '-=0.1')
    .to('#ap',      { opacity: 1, x: 0, duration: 0.4 }, '-=0.45');
});
</script>

@endsection