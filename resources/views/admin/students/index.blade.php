@extends('layouts.admin')
@section('title', 'Students')
@section('content')

<style>
  .dash-wrap {
    max-width: 1140px;
    margin: 0 auto;
    padding-bottom: 64px;
  }

  .dash-header {
    padding: 30px 0 20px;
    border-bottom: 2px solid var(--ink);
    margin-bottom: 24px;
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: end;
    gap: 20px;
    opacity: 0;
    transform: translateY(12px);
  }

  .dash-headline {
    font-family: 'DM Sans', sans-serif;
    font-size: 32px;
    font-weight: 800;
    letter-spacing: -0.03em;
    color: var(--ink);
    line-height: 1;
  }
  .dash-headline span { color: var(--gold); }
  .dash-sub { font-size: 13px; color: var(--muted); margin-top: 4px; }

  /* KPI Grid */
  .kpi-strip {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
    margin-bottom: 24px;
    background: var(--surface);
    opacity: 0;
    transform: translateY(12px);
  }
  .kpi {
    padding: 20px 22px;
    border-right: 1px solid var(--border);
    transition: background 0.2s;
  }
  .kpi:last-child { border-right: none; }
  .kpi:hover { background: var(--bg); }
  .kpi-label {
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 8px;
  }
  .kpi-value {
    font-family: 'DM Sans', sans-serif;
    font-size: 36px;
    font-weight: 900;
    letter-spacing: -0.02em;
    color: var(--ink);
    line-height: 1;
  }
  .kpi-value.accent-navy  { color: var(--navy2); }
  .kpi-value.accent-gold  { color: var(--gold); }
  .kpi-value.accent-green { color: #1a6b42; }

  /* Filter Panel */
  .filter-panel {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    padding: 20px;
    margin-bottom: 24px;
    opacity: 0;
    transform: translateY(12px);
  }
  .filter-row {
    display: grid;
    grid-template-columns: 1fr 180px 180px auto;
    gap: 12px;
    align-items: end;
  }
  .form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }
  .form-label {
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--ink3);
  }
  .form-input {
    padding: 9px 12px;
    border: 1px solid var(--border2);
    background: var(--surface2);
    border-radius: var(--r);
    color: var(--ink);
    font-size: 13px;
    outline: none;
    font-family: inherit;
    transition: border-color 0.2s;
  }
  .form-input:focus { border-color: var(--navy); }

  /* Table styles */
  .table-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
    opacity: 0;
    transform: translateY(12px);
  }

  .prog-bar {
    width: 100px;
    height: 4px;
    background: var(--surface2);
    border-radius: 20px;
    overflow: hidden;
    display: inline-block;
    vertical-align: middle;
    margin-right: 8px;
    border: 0.5px solid var(--border);
  }
  .prog-fill {
    height: 100%;
    background: var(--navy);
    border-radius: 20px;
  }
  .prog-fill.complete { background: var(--green); }
</style>

<div class="dash-wrap">
  
  {{-- Header --}}
  <div class="dash-header" id="dh">
    <div>
      <div class="dash-headline">Students<span>.</span></div>
      <div class="dash-sub">View and manage registered student accounts and course timeline metrics</div>
    </div>
  </div>

  {{-- Metrics --}}
  <div class="kpi-strip" id="ks">
    <div class="kpi">
      <div class="kpi-label">Total Students</div>
      <div class="kpi-value accent-navy">{{ $totalStudents }}</div>
    </div>
    <div class="kpi">
      <div class="kpi-label">Active Pathways</div>
      <div class="kpi-value accent-gold">{{ $activeVouchersCount }}</div>
    </div>
    <div class="kpi">
      <div class="kpi-label">Avg. Completion Rate</div>
      <div class="kpi-value accent-green">{{ $avgCompletionRate }}%</div>
    </div>
    <div class="kpi">
      <div class="kpi-label">Quiz Pass Rate</div>
      <div class="kpi-value">{{ $quizPassRate }}%</div>
    </div>
  </div>

  {{-- Filters --}}
  <div class="filter-panel" id="fp">
    <form method="GET" action="{{ route('admin.students.index') }}">
      <div class="filter-row">
        <div class="form-group">
          <label class="form-label">Search Student</label>
          <input type="text" name="search" class="form-input" placeholder="Search by name or email..." value="{{ request('search') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Joined From Date</label>
          <input type="date" name="start_date" class="form-input" value="{{ request('start_date') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Joined To Date</label>
          <input type="date" name="end_date" class="form-input" value="{{ request('end_date') }}">
        </div>
        <div style="display:flex; gap:6px;">
          <button type="submit" class="btn btn-primary" style="height:38px;">Apply Filters</button>
          <a href="{{ route('admin.students.index') }}" class="btn btn-ghost" style="height:38px; display:inline-flex; align-items:center; justify-content:center;">Clear</a>
        </div>
      </div>
    </form>
  </div>

  {{-- Table Card --}}
  <div class="table-card" id="tc">
    <table>
      <thead>
        <tr>
          <th>Name / Email</th>
          <th>Contact & Birthday</th>
          <th>Affiliation</th>
          <th>Voucher Access</th>
          <th>LMS Progress</th>
          <th>Joined</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($students as $s)
        <tr class="student-row">
          <td>
            <div style="font-weight:600; color:var(--ink);">{{ $s->full_name }}</div>
            <div style="font-size:11px; color:var(--muted);">{{ $s->email }}</div>
            @if(!$s->is_active)
              <span class="badge badge-inactive" style="font-size:8px; padding: 1px 5px; margin-top:2px;">Suspended</span>
            @endif
          </td>
          <td>
            <div style="font-size:12px; color:var(--ink2);">{{ $s->contact_number }}</div>
            <div style="font-size:11px; color:var(--muted);">{{ $s->birthday ? $s->birthday->format('M j, Y') : '—' }}</div>
          </td>
          <td style="font-size:12px;">
            <div style="font-weight:500; color:var(--ink3);">{{ $s->affiliation_name }}</div>
            <div style="font-size:10px; color:var(--muted); text-transform:uppercase;">{{ $s->affiliation_type }}</div>
          </td>
          <td>
            @if($s->voucher)
              @if($s->voucher->is_approved)
                <span class="badge badge-active">Approved</span>
              @elseif($s->voucher->is_paid)
                <span class="badge badge-pending">Paid (Review)</span>
              @else
                <span class="badge badge-pending">Assigned</span>
              @endif
              <div style="font-family:monospace; font-size:10px; color:var(--muted); margin-top:4px;">{{ $s->voucher->code }}</div>
            @else
              <span class="badge badge-inactive">No Voucher</span>
            @endif
          </td>
          <td>
            <div style="display:flex; align-items:center;">
              <div class="prog-bar">
                <div class="prog-fill {{ $s->progress_percent == 100 ? 'complete' : '' }}" style="width: {{ $s->progress_percent }}%"></div>
              </div>
              <span style="font-family:'JetBrains Mono', monospace; font-size:11px; font-weight:600;">{{ $s->progress_percent }}%</span>
            </div>
            <div style="font-size:11px; color:var(--muted); margin-top:3px;">{{ $s->completed_modules_count }} / {{ $s->total_modules_count }} Modules</div>
          </td>
          <td style="color:var(--muted); font-size:12px;">
            {{ $s->created_at->format('M j, Y') }}
          </td>
          <td class="td-actions">
            <a href="{{ route('admin.students.edit', $s->id) }}" class="btn btn-ghost btn-sm">Edit</a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="text-align:center; color:var(--muted); padding:36px;">No student records match the filters.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
  tl.to('#dh', { opacity: 1, y: 0, duration: 0.5 })
    .to('#ks', { opacity: 1, y: 0, duration: 0.4 }, '-=0.2')
    .to('#fp', { opacity: 1, y: 0, duration: 0.4 }, '-=0.2')
    .to('#tc', { opacity: 1, y: 0, duration: 0.5 }, '-=0.2');
});
</script>

@endsection
