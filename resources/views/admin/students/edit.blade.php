@extends('layouts.admin')
@section('title', 'Edit Student')
@section('content')

<style>
  .dash-wrap {
    max-width: 800px;
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

  /* Form Card */
  .form-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    padding: 32px;
    opacity: 0;
    transform: translateY(12px);
  }

  .form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 24px;
  }

  @media(max-width: 768px) {
    .form-grid {
      grid-template-columns: 1fr;
    }
  }

  .form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .form-group.full-width {
    grid-column: span 2;
  }

  @media(max-width: 768px) {
    .form-group.full-width {
      grid-column: span 1;
    }
  }

  .form-label {
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--ink3);
  }

  .form-input {
    padding: 11px 14px;
    border: 1px solid var(--border2);
    background: var(--surface2);
    border-radius: var(--r);
    color: var(--ink);
    font-size: 13px;
    outline: none;
    font-family: inherit;
    transition: all 0.2s;
  }
  .form-input:focus {
    border-color: var(--navy);
    background: var(--surface);
    box-shadow: 0 0 0 3px rgba(13,31,60,0.05);
  }

  .form-select {
    appearance: none;
    background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234a5568' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    background-size: 14px;
    padding-right: 40px;
  }

  .form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding-top: 20px;
    border-top: 1px solid var(--border);
  }
</style>

<div class="dash-wrap">
  
  {{-- Header --}}
  <div class="dash-header" id="dh">
    <div>
      <div class="dash-headline">Edit Student<span>.</span></div>
      <div class="dash-sub">Modify student account and profile properties</div>
    </div>
    <div>
      <a href="{{ route('admin.students.index') }}" class="btn btn-ghost">↩ Back to Students</a>
    </div>
  </div>

  {{-- Form --}}
  <div class="form-card" id="fc">
    <form method="POST" action="{{ route('admin.students.update', $student->id) }}">
      @csrf
      @method('PUT')

      <div class="form-grid">
        <div class="form-group">
          <label class="form-label" for="first_name">First Name</label>
          <input type="text" name="first_name" id="first_name" class="form-input" value="{{ old('first_name', $student->first_name) }}" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="last_name">Last Name</label>
          <input type="text" name="last_name" id="last_name" class="form-input" value="{{ old('last_name', $student->last_name) }}" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="email">Email Address</label>
          <input type="email" name="email" id="email" class="form-input" value="{{ old('email', $student->email) }}" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="contact_number">Contact Number</label>
          <input type="text" name="contact_number" id="contact_number" class="form-input" value="{{ old('contact_number', $student->contact_number) }}" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="birthday">Birthday</label>
          <input type="date" name="birthday" id="birthday" class="form-input" value="{{ old('birthday', $student->birthday ? $student->birthday->format('Y-m-d') : '') }}" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="is_active">Account Status</label>
          <select name="is_active" id="is_active" class="form-input form-select" required>
            <option value="1" {{ old('is_active', $student->is_active) ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('is_active', $student->is_active) ? '' : 'selected' }}>Suspended</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="affiliation_type">Affiliation Type</label>
          <select name="affiliation_type" id="affiliation_type" class="form-input form-select" required>
            <option value="student" {{ old('affiliation_type', $student->affiliation_type) == 'student' ? 'selected' : '' }}>Student</option>
            <option value="professional" {{ old('affiliation_type', $student->affiliation_type) == 'professional' ? 'selected' : '' }}>Professional</option>
            <option value="academic" {{ old('affiliation_type', $student->affiliation_type) == 'academic' ? 'selected' : '' }}>Academic</option>
            <option value="other" {{ old('affiliation_type', $student->affiliation_type) == 'other' ? 'selected' : '' }}>Other</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="affiliation_name">Affiliation Institution Name</label>
          <input type="text" name="affiliation_name" id="affiliation_name" class="form-input" value="{{ old('affiliation_name', $student->affiliation_name) }}" required>
        </div>
      </div>

      <div class="form-actions">
        <a href="{{ route('admin.students.index') }}" class="btn btn-ghost">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </div>
    </form>
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
  tl.to('#dh', { opacity: 1, y: 0, duration: 0.5 })
    .to('#fc', { opacity: 1, y: 0, duration: 0.5 }, '-=0.25');
});
</script>

@endsection
