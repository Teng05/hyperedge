@extends('layouts.auth')
@section('title', 'Create Account')
@section('content')

<style>
  /* ── BIRTHDAY PICKER ─────────────────────── */
  .bday-row {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 8px;
  }
  .bday-select-wrap {
    position: relative;
  }
  .bday-select-wrap select {
    width: 100%;
    background: var(--white);
    border: 1px solid var(--border2);
    border-radius: 8px;
    padding: 10px 30px 10px 13px;
    color: var(--ink);
    font-size: 13px;
    outline: none;
    appearance: none;
    font-family: 'DM Sans', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s;
    cursor: pointer;
  }
  .bday-select-wrap select:focus {
    border-color: var(--blue2);
    box-shadow: 0 0 0 3px rgba(36,86,224,0.08);
  }
  .bday-select-wrap select option:first-child { color: var(--muted2); }
  .bday-chevron {
    position: absolute; right: 10px; top: 50%;
    transform: translateY(-50%);
    pointer-events: none; color: var(--muted);
    font-size: 10px;
  }

  /* ── SCHOOL AUTOCOMPLETE ─────────────────── */
  .autocomplete-wrap {
    position: relative;
  }
  .autocomplete-wrap .form-input {
    padding-right: 34px;
  }
  .ac-clear {
    position: absolute; right: 11px; top: 50%;
    transform: translateY(-50%);
    background: none; border: none;
    color: var(--muted2); cursor: pointer;
    font-size: 14px; line-height: 1;
    display: none; padding: 2px 4px;
    transition: color 0.2s;
  }
  .ac-clear:hover { color: var(--ink); }
  .ac-dropdown {
    position: absolute; top: calc(100% + 4px); left: 0; right: 0;
    background: var(--white);
    border: 1px solid var(--border2);
    border-radius: 10px;
    box-shadow: 0 8px 32px rgba(9,12,26,0.10);
    z-index: 999;
    max-height: 220px; overflow-y: auto;
    display: none;
    scrollbar-width: thin;
    scrollbar-color: var(--muted2) transparent;
  }
  .ac-dropdown.open { display: block; }
  .ac-item {
    padding: 9px 14px;
    font-size: 12.5px; color: var(--ink3);
    cursor: pointer; border-bottom: 1px solid var(--border);
    transition: background 0.15s;
    line-height: 1.4;
  }
  .ac-item:last-child { border-bottom: none; }
  .ac-item:hover, .ac-item.ac-active {
    background: var(--blue-soft);
    color: var(--blue2);
  }
  .ac-item mark {
    background: none; color: var(--blue2);
    font-weight: 700;
  }
  .ac-empty {
    padding: 14px; font-size: 12px;
    color: var(--muted); text-align: center;
  }
  .ac-type-badge {
    display: inline-block;
    font-size: 9px; font-weight: 700;
    letter-spacing: 0.5px; text-transform: uppercase;
    padding: 1px 5px; border-radius: 3px;
    background: var(--off2); color: var(--muted);
    margin-left: 6px; vertical-align: middle;
  }

  /* ── HIDDEN DATE INPUT ───────────────────── */
  #birthday-hidden { display: none; }
</style>

<div class="auth-header">
  <h2 class="auth-title">Create your account</h2>
  <p class="auth-sub">Join the HTML Developer Program</p>
</div>

@if($errors->any())
  <div class="alert-error">{{ $errors->first() }}</div>
@endif

<div class="otp-notice">
  A 6-digit OTP will be sent to your Gmail to verify your account.
</div>

<form method="POST" action="{{ route('register.otp') }}" id="reg-form">
  @csrf

  {{-- Name --}}
  <div class="form-row-2">
    <div class="form-group">
      <label class="form-label">First name</label>
      <input class="form-input" name="first_name"
        value="{{ old('first_name') }}" placeholder="Juan" required>
    </div>
    <div class="form-group">
      <label class="form-label">Last name</label>
      <input class="form-input" name="last_name"
        value="{{ old('last_name') }}" placeholder="dela Cruz" required>
    </div>
  </div>

  {{-- Email --}}
  <div class="form-group">
    <label class="form-label">Email address</label>
    <input class="form-input" type="email" name="email"
      value="{{ old('email') }}" placeholder="you@gmail.com" required>
  </div>

  {{-- Birthday — custom dropdowns --}}
  <div class="form-group">
    <label class="form-label">Birthday</label>
    <div class="bday-row">
      <div class="bday-select-wrap">
        <select id="bday-month" aria-label="Month">
          <option value="">Month</option>
          <option value="01">January</option>
          <option value="02">February</option>
          <option value="03">March</option>
          <option value="04">April</option>
          <option value="05">May</option>
          <option value="06">June</option>
          <option value="07">July</option>
          <option value="08">August</option>
          <option value="09">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>
        </select>
        <span class="bday-chevron">▾</span>
      </div>
      <div class="bday-select-wrap">
        <select id="bday-day" aria-label="Day">
          <option value="">Day</option>
        </select>
        <span class="bday-chevron">▾</span>
      </div>
      <div class="bday-select-wrap">
        <select id="bday-year" aria-label="Year">
          <option value="">Year</option>
        </select>
        <span class="bday-chevron">▾</span>
      </div>
    </div>
    <input type="hidden" name="birthday" id="birthday-hidden" value="{{ old('birthday') }}" required>
  </div>

  {{-- Contact --}}
  <div class="form-group">
    <label class="form-label">Contact number</label>
    <input class="form-input" name="contact_number"
      value="{{ old('contact_number') }}" placeholder="+63 9XX XXX XXXX" required>
  </div>

  {{-- Affiliation type --}}
  <div class="form-group">
    <label class="form-label">Affiliation type</label>
    <div class="bday-select-wrap">
      <select class="form-select" name="affiliation_type" id="aff-type" required style="padding-right:30px;">
        <option value="">Select type...</option>
        <option value="School"      {{ old('affiliation_type')==='School'      ? 'selected':'' }}>School / University</option>
        <option value="Company"     {{ old('affiliation_type')==='Company'     ? 'selected':'' }}>Company / Organization</option>
        <option value="Independent" {{ old('affiliation_type')==='Independent' ? 'selected':'' }}>Independent</option>
      </select>
      <span class="bday-chevron">▾</span>
    </div>
  </div>

  {{-- School / Company name with autocomplete --}}
  <div class="form-group" id="aff-name-group">
    <label class="form-label" id="aff-name-label">School / Company name</label>
    <div class="autocomplete-wrap" id="ac-wrap">
      <input class="form-input" name="affiliation_name" id="aff-name-input"
        value="{{ old('affiliation_name') }}"
        placeholder="e.g. University of the Philippines" required
        autocomplete="off">
      <button type="button" class="ac-clear" id="ac-clear-btn" title="Clear">✕</button>
      <div class="ac-dropdown" id="ac-dropdown" role="listbox"></div>
    </div>
  </div>

  {{-- Password --}}
  <div class="form-group">
    <label class="form-label">Password</label>
    <input class="form-input" type="password" name="password"
      placeholder="Minimum 8 characters" required>
  </div>
  <div class="form-group">
    <label class="form-label">Confirm password</label>
    <input class="form-input" type="password" name="password_confirmation"
      placeholder="Repeat your password" required>
  </div>

  <button type="submit" class="btn-submit">Send OTP to Gmail</button>
</form>

<div class="auth-switch">
  Already have an account? <a href="{{ route('login') }}">Sign in</a>
</div>

<script>
/* ══════════════════════════════════════════
   BIRTHDAY DROPDOWNS
══════════════════════════════════════════ */
(function () {
  const mSel = document.getElementById('bday-month');
  const dSel = document.getElementById('bday-day');
  const ySel = document.getElementById('bday-year');
  const hid  = document.getElementById('birthday-hidden');

  // Populate years (current year - 5) down to 1940
  const curYear = new Date().getFullYear() - 5;
  for (let y = curYear; y >= 1940; y--) {
    const o = document.createElement('option');
    o.value = y; o.textContent = y;
    ySel.appendChild(o);
  }

  function daysInMonth(m, y) {
    if (!m) return 31;
    return new Date(y || 2000, m, 0).getDate();
  }

  function populateDays() {
    const m = parseInt(mSel.value) || 0;
    const y = parseInt(ySel.value) || 2000;
    const prev = dSel.value;
    const max  = daysInMonth(m, y);
    dSel.innerHTML = '<option value="">Day</option>';
    for (let d = 1; d <= max; d++) {
      const o = document.createElement('option');
      o.value = String(d).padStart(2,'0');
      o.textContent = d;
      if (o.value === prev) o.selected = true;
      dSel.appendChild(o);
    }
  }

  function syncHidden() {
    const m = mSel.value, d = dSel.value, y = ySel.value;
    hid.value = (m && d && y) ? `${y}-${m}-${d}` : '';
  }

  // Pre-fill from old value
  const old = hid.value; // e.g. "2000-03-15"
  if (old) {
    const [oy, om, od] = old.split('-');
    mSel.value = om;
    populateDays();
    ySel.value = oy;
    dSel.value = od;
  } else {
    populateDays();
  }

  [mSel, dSel, ySel].forEach(el => {
    el.addEventListener('change', () => { populateDays(); syncHidden(); });
  });
})();

/* ══════════════════════════════════════════
   PHILIPPINE SCHOOLS AUTOCOMPLETE
══════════════════════════════════════════ */
(function () {
  // Comprehensive list of Philippine schools
  const PH_SCHOOLS = [
    // State Universities / SUCs
    { name: 'University of the Philippines Diliman', type: 'SUC' },
    { name: 'University of the Philippines Manila', type: 'SUC' },
    { name: 'University of the Philippines Los Baños', type: 'SUC' },
    { name: 'University of the Philippines Visayas', type: 'SUC' },
    { name: 'University of the Philippines Cebu', type: 'SUC' },
    { name: 'University of the Philippines Mindanao', type: 'SUC' },
    { name: 'University of the Philippines Baguio', type: 'SUC' },
    { name: 'University of the Philippines Open University', type: 'SUC' },
    { name: 'Polytechnic University of the Philippines', type: 'SUC' },
    { name: 'Polytechnic University of the Philippines – Sta. Mesa', type: 'SUC' },
    { name: 'Polytechnic University of the Philippines – Taguig', type: 'SUC' },
    { name: 'Polytechnic University of the Philippines – Bataan', type: 'SUC' },
    { name: 'Polytechnic University of the Philippines – Biñan', type: 'SUC' },
    { name: 'Polytechnic University of the Philippines – Cavite', type: 'SUC' },
    { name: 'Polytechnic University of the Philippines – Parañaque', type: 'SUC' },
    { name: 'Polytechnic University of the Philippines – San Pedro', type: 'SUC' },
    { name: 'Polytechnic University of the Philippines – Quezon City', type: 'SUC' },
    { name: 'Philippine Normal University', type: 'SUC' },
    { name: 'Philippine Normal University – Agusan', type: 'SUC' },
    { name: 'Philippine Normal University – Isabela', type: 'SUC' },
    { name: 'Philippine Normal University – Mindanao', type: 'SUC' },
    { name: 'Technological University of the Philippines', type: 'SUC' },
    { name: 'Technological University of the Philippines – Taguig', type: 'SUC' },
    { name: 'Technological University of the Philippines – Visayas', type: 'SUC' },
    { name: 'Technological University of the Philippines – Cavite', type: 'SUC' },
    { name: 'Mindanao State University', type: 'SUC' },
    { name: 'Mindanao State University – Iligan Institute of Technology', type: 'SUC' },
    { name: 'Mindanao State University – General Santos', type: 'SUC' },
    { name: 'Mindanao State University – Marawi', type: 'SUC' },
    { name: 'Mindanao State University – Naawan', type: 'SUC' },
    { name: 'Mindanao State University – Tawi-Tawi', type: 'SUC' },
    { name: 'Mindanao State University – Buug', type: 'SUC' },
    { name: 'Batangas State University', type: 'SUC' },
    { name: 'Batangas State University – Lipa', type: 'SUC' },
    { name: 'Batangas State University – Nasugbu', type: 'SUC' },
    { name: 'Batangas State University – Balayan', type: 'SUC' },
    { name: 'Cavite State University', type: 'SUC' },
    { name: 'Cavite State University – Imus', type: 'SUC' },
    { name: 'Cavite State University – Carmona', type: 'SUC' },
    { name: 'Cavite State University – Naic', type: 'SUC' },
    { name: 'Cavite State University – Rosario', type: 'SUC' },
    { name: 'Cavite State University – Silang', type: 'SUC' },
    { name: 'Laguna State Polytechnic University', type: 'SUC' },
    { name: 'Laguna State Polytechnic University – Siniloan', type: 'SUC' },
    { name: 'Laguna State Polytechnic University – San Pablo', type: 'SUC' },
    { name: 'Southern Luzon State University', type: 'SUC' },
    { name: 'Rizal Technological University', type: 'SUC' },
    { name: 'Nueva Vizcaya State University', type: 'SUC' },
    { name: 'Isabela State University', type: 'SUC' },
    { name: 'Mariano Marcos State University', type: 'SUC' },
    { name: 'Don Mariano Marcos Memorial State University', type: 'SUC' },
    { name: 'Cagayan State University', type: 'SUC' },
    { name: 'Quirino State University', type: 'SUC' },
    { name: 'Ifugao State University', type: 'SUC' },
    { name: 'Mountain Province State Polytechnic College', type: 'SUC' },
    { name: 'Benguet State University', type: 'SUC' },
    { name: 'Nueva Ecija University of Science and Technology', type: 'SUC' },
    { name: 'Bulacan State University', type: 'SUC' },
    { name: 'Pampanga State Agricultural University', type: 'SUC' },
    { name: 'Central Luzon State University', type: 'SUC' },
    { name: 'Tarlac State University', type: 'SUC' },
    { name: 'Tarlac Agricultural University', type: 'SUC' },
    { name: 'Bataan Peninsula State University', type: 'SUC' },
    { name: 'Ramon Magsaysay Technological University', type: 'SUC' },
    { name: 'Aurora State College of Technology', type: 'SUC' },
    { name: 'Western Philippines University', type: 'SUC' },
    { name: 'Palawan State University', type: 'SUC' },
    { name: 'Occidental Mindoro State College', type: 'SUC' },
    { name: 'Oriental Mindoro State College', type: 'SUC' },
    { name: 'Marinduque State College', type: 'SUC' },
    { name: 'Romblon State University', type: 'SUC' },
    { name: 'Camarines Norte State College', type: 'SUC' },
    { name: 'Camarines Sur Polytechnic Colleges', type: 'SUC' },
    { name: 'Partido State University', type: 'SUC' },
    { name: 'Bicol University', type: 'SUC' },
    { name: 'Bicol State College of Applied Sciences and Technology', type: 'SUC' },
    { name: 'Sorsogon State University', type: 'SUC' },
    { name: 'Catanduanes State University', type: 'SUC' },
    { name: 'Aklan State University', type: 'SUC' },
    { name: 'Capiz State University', type: 'SUC' },
    { name: 'West Visayas State University', type: 'SUC' },
    { name: 'University of Antique', type: 'SUC' },
    { name: 'Central Philippine State University', type: 'SUC' },
    { name: 'Iloilo Science and Technology University', type: 'SUC' },
    { name: 'University of Iloilo – PHINMA', type: 'Private' },
    { name: 'Carlos Hilado Memorial State University', type: 'SUC' },
    { name: 'University of Negros Occidental – Recoletos', type: 'Private' },
    { name: 'Negros Oriental State University', type: 'SUC' },
    { name: 'Siquijor State College', type: 'SUC' },
    { name: 'Cebu Normal University', type: 'SUC' },
    { name: 'Cebu Technological University', type: 'SUC' },
    { name: 'University of Cebu', type: 'Private' },
    { name: 'University of Cebu – Banilad', type: 'Private' },
    { name: 'University of Cebu – Lapu-Lapu and Mandaue', type: 'Private' },
    { name: 'Bohol Island State University', type: 'SUC' },
    { name: 'Eastern Visayas State University', type: 'SUC' },
    { name: 'Northwest Samar State University', type: 'SUC' },
    { name: 'Samar State University', type: 'SUC' },
    { name: 'Eastern Samar State University', type: 'SUC' },
    { name: 'Leyte Normal University', type: 'SUC' },
    { name: 'Visayas State University', type: 'SUC' },
    { name: 'Southern Leyte State University', type: 'SUC' },
    { name: 'Biliran Province State University', type: 'SUC' },
    { name: 'Zamboanga State College of Marine Sciences and Technology', type: 'SUC' },
    { name: 'Jose Rizal Memorial State University', type: 'SUC' },
    { name: 'Western Mindanao State University', type: 'SUC' },
    { name: 'Basilan State College', type: 'SUC' },
    { name: 'Misamis Oriental State University', type: 'SUC' },
    { name: 'Misamis University', type: 'Private' },
    { name: 'Xavier University – Ateneo de Cagayan', type: 'Private' },
    { name: 'Bukidnon State University', type: 'SUC' },
    { name: 'Central Mindanao University', type: 'SUC' },
    { name: 'Camiguin Polytechnic State College', type: 'SUC' },
    { name: 'Lanao del Norte Agricultural College', type: 'SUC' },
    { name: 'Cotabato City State Polytechnic College', type: 'SUC' },
    { name: 'Davao Oriental State University', type: 'SUC' },
    { name: 'Davao del Norte State College', type: 'SUC' },
    { name: 'Compostela Valley State College', type: 'SUC' },
    { name: 'Southeastern Philippines University', type: 'SUC' },
    { name: 'University of Southern Mindanao', type: 'SUC' },
    { name: 'Sultan Kudarat State University', type: 'SUC' },
    { name: 'Sarangani Agricultural and Polytechnic State College', type: 'SUC' },
    { name: 'South Cotabato State College', type: 'SUC' },
    { name: 'Surigao del Norte State University', type: 'SUC' },
    { name: 'Surigao State College of Technology', type: 'SUC' },
    { name: 'Agusan del Sur State College of Agriculture and Technology', type: 'SUC' },
    { name: 'Caraga State University', type: 'SUC' },
    { name: 'Dinagat Islands State College of Agriculture and Technology', type: 'SUC' },

    // National University campuses
    { name: 'National University – Manila', type: 'Private' },
    { name: 'National University – Baliwag', type: 'Private' },
    { name: 'National University – Fairview', type: 'Private' },
    { name: 'National University – Lipa', type: 'Private' },
    { name: 'National University – Dasmarinas', type: 'Private' },
    { name: 'National University – Laguna', type: 'Private' },
    { name: 'National University – MOA', type: 'Private' },
    { name: 'National University – Caloocan', type: 'Private' },
    { name: 'National University – Pampanga', type: 'Private' },

    // Ateneo network
    { name: 'Ateneo de Manila University', type: 'Private' },
    { name: 'Ateneo de Davao University', type: 'Private' },
    { name: 'Ateneo de Naga University', type: 'Private' },
    { name: 'Ateneo de Zamboanga University', type: 'Private' },
    { name: 'Ateneo de Cagayan – Xavier University', type: 'Private' },
    { name: 'Ateneo de Iloilo', type: 'Private' },

    // De La Salle network
    { name: 'De La Salle University – Manila', type: 'Private' },
    { name: 'De La Salle University – Dasmariñas', type: 'Private' },
    { name: 'De La Salle Araneta University', type: 'Private' },
    { name: 'De La Salle Lipa', type: 'Private' },
    { name: 'De La Salle John Bosco College', type: 'Private' },
    { name: 'De La Salle Santiago Zobel School', type: 'Private' },
    { name: 'La Salle Green Hills', type: 'Private' },
    { name: 'La Salle Academy', type: 'Private' },
    { name: 'La Salle Greenhills', type: 'Private' },
    { name: 'La Salle College Antipolo', type: 'Private' },

    // San Beda
    { name: 'San Beda University', type: 'Private' },
    { name: 'San Beda College Alabang', type: 'Private' },

    // UST
    { name: 'University of Santo Tomas', type: 'Private' },
    { name: 'Colegio de Santo Tomas – Recoletos', type: 'Private' },

    // FEU
    { name: 'Far Eastern University', type: 'Private' },
    { name: 'Far Eastern University – East Asia College', type: 'Private' },
    { name: 'Far Eastern University – Cavite', type: 'Private' },
    { name: 'Far Eastern University – Diliman', type: 'Private' },
    { name: 'Far Eastern University – Makati', type: 'Private' },
    { name: 'Far Eastern University – Nicanor Reyes Medical Foundation', type: 'Private' },

    // Mapua
    { name: 'Mapúa University', type: 'Private' },
    { name: 'Mapúa Malayan Colleges Laguna', type: 'Private' },
    { name: 'Mapúa Malayan Colleges Mindanao', type: 'Private' },

    // AMA
    { name: 'AMA University', type: 'Private' },
    { name: 'AMA Computer University', type: 'Private' },
    { name: 'AMA Computer College – Quezon City', type: 'Private' },
    { name: 'AMA Computer College – Parañaque', type: 'Private' },
    { name: 'AMA Computer College – Legazpi', type: 'Private' },
    { name: 'AMA Computer College – Davao', type: 'Private' },
    { name: 'AMA Computer College – Cebu', type: 'Private' },

    // STI
    { name: 'STI College – Cubao', type: 'Private' },
    { name: 'STI College – Caloocan', type: 'Private' },
    { name: 'STI College – Global City', type: 'Private' },
    { name: 'STI College – Las Piñas', type: 'Private' },
    { name: 'STI College – Makati', type: 'Private' },
    { name: 'STI College – Marikina', type: 'Private' },
    { name: 'STI College – Muñoz-EDSA', type: 'Private' },
    { name: 'STI College – Novaliches', type: 'Private' },
    { name: 'STI College – Pasay', type: 'Private' },
    { name: 'STI College – Pasig', type: 'Private' },
    { name: 'STI College – Quezon Avenue', type: 'Private' },
    { name: 'STI College – San Jose del Monte', type: 'Private' },
    { name: 'STI College – Batangas', type: 'Private' },
    { name: 'STI College – Lipa', type: 'Private' },
    { name: 'STI College – Lucena', type: 'Private' },
    { name: 'STI College – Antipolo', type: 'Private' },
    { name: 'STI College – Cainta', type: 'Private' },
    { name: 'STI College – Dasmariñas', type: 'Private' },
    { name: 'STI College – Imus', type: 'Private' },
    { name: 'STI College – Baguio', type: 'Private' },
    { name: 'STI College – Angeles', type: 'Private' },
    { name: 'STI College – Balagtas', type: 'Private' },
    { name: 'STI College – Cebu', type: 'Private' },
    { name: 'STI College – Cagayan de Oro', type: 'Private' },
    { name: 'STI College – Davao', type: 'Private' },
    { name: 'STI College – Iloilo', type: 'Private' },
    { name: 'STI College – General Santos', type: 'Private' },

    // Other major private universities
    { name: 'Adamson University', type: 'Private' },
    { name: 'Arellano University', type: 'Private' },
    { name: 'Assumption College', type: 'Private' },
    { name: 'Colegio de San Juan de Letran', type: 'Private' },
    { name: 'Colegio de San Juan de Letran – Calamba', type: 'Private' },
    { name: 'Colegio de San Juan de Letran – Intramuros', type: 'Private' },
    { name: 'Centro Escolar University', type: 'Private' },
    { name: 'Emilio Aguinaldo College', type: 'Private' },
    { name: 'Eulogio "Amang" Rodriguez Institute of Science and Technology', type: 'Private' },
    { name: 'Holy Angel University', type: 'Private' },
    { name: 'John B. Lacson Foundation Maritime University', type: 'Private' },
    { name: 'Jose Rizal University', type: 'Private' },
    { name: 'Lyceum of the Philippines University', type: 'Private' },
    { name: 'Lyceum of the Philippines University – Cavite', type: 'Private' },
    { name: 'Lyceum of the Philippines University – Batangas', type: 'Private' },
    { name: 'Lyceum of the Philippines University – Laguna', type: 'Private' },
    { name: 'Manuel L. Quezon University', type: 'Private' },
    { name: 'Our Lady of Fatima University', type: 'Private' },
    { name: 'Our Lady of Fatima University – Antipolo', type: 'Private' },
    { name: 'Our Lady of Fatima University – Pampanga', type: 'Private' },
    { name: 'Our Lady of Fatima University – Valenzuela', type: 'Private' },
    { name: 'Philippine Christian University', type: 'Private' },
    { name: 'Philippine Women\'s University', type: 'Private' },
    { name: 'Saint Louis University', type: 'Private' },
    { name: 'San Sebastian College – Recoletos', type: 'Private' },
    { name: 'St. Paul University Manila', type: 'Private' },
    { name: 'St. Scholastica\'s College', type: 'Private' },
    { name: 'Trinity University of Asia', type: 'Private' },
    { name: 'University of the East', type: 'Private' },
    { name: 'University of the East – Caloocan', type: 'Private' },
    { name: 'University of the East – Manila', type: 'Private' },
    { name: 'University of Manila', type: 'Private' },
    { name: 'Pamantasan ng Lungsod ng Maynila', type: 'LGU' },
    { name: 'Pamantasan ng Lungsod ng Marikina', type: 'LGU' },
    { name: 'Pamantasan ng Lungsod ng Pasig', type: 'LGU' },
    { name: 'Pamantasan ng Lungsod ng Valenzuela', type: 'LGU' },
    { name: 'Pamantasan ng Lungsod ng Muntinlupa', type: 'LGU' },
    { name: 'Pamantasan ng Lungsod ng Las Piñas', type: 'LGU' },
    { name: 'Pamantasan ng Lungsod ng San Pablo', type: 'LGU' },
    { name: 'University of Makati', type: 'LGU' },

    // CALABARZON focus
    { name: 'Lyceum of the Philippines University – Laguna', type: 'Private' },
    { name: 'Laguna College', type: 'Private' },
    { name: 'Laguna College of Business and Arts', type: 'Private' },
    { name: 'San Pablo Colleges', type: 'Private' },
    { name: 'University of Perpetual Help System DALTA – Las Piñas', type: 'Private' },
    { name: 'University of Perpetual Help System DALTA – Molino', type: 'Private' },
    { name: 'University of Perpetual Help System Laguna', type: 'Private' },
    { name: 'University of Perpetual Help System GMA', type: 'Private' },
    { name: 'De La Salle University – Dasmariñas', type: 'Private' },
    { name: 'Philippine Missionary Institute', type: 'Private' },
    { name: 'Emilio Aguinaldo College – Cavite', type: 'Private' },
    { name: 'Trece Martires City College', type: 'LGU' },
    { name: 'Asian Institute of Maritime Studies', type: 'Private' },
    { name: 'Kolehiyo ng Lungsod ng Lipa', type: 'LGU' },
    { name: 'Colegio de San Agustin – Bacolod', type: 'Private' },
    { name: 'Lipa City Colleges', type: 'Private' },
    { name: 'First Asia Institute of Technology and Humanities', type: 'Private' },
    { name: 'Quezon City University', type: 'LGU' },
    { name: 'Marikina Polytechnic College', type: 'LGU' },

    // More Visayas / Mindanao
    { name: 'University of San Carlos', type: 'Private' },
    { name: 'University of San Jose – Recoletos', type: 'Private' },
    { name: 'Southwestern University PHINMA', type: 'Private' },
    { name: 'University of the Visayas', type: 'Private' },
    { name: 'University of Southern Philippines Foundation', type: 'Private' },
    { name: 'Holy Name University', type: 'Private' },
    { name: 'University of Bohol', type: 'Private' },
    { name: 'Divine Word College of Legazpi', type: 'Private' },
    { name: 'Ateneo de Naga University', type: 'Private' },
    { name: 'Saint Mary\'s University', type: 'Private' },
    { name: 'Notre Dame of Dadiangas University', type: 'Private' },
    { name: 'Notre Dame University', type: 'Private' },
    { name: 'University of Mindanao', type: 'Private' },
    { name: 'Ateneo de Davao University', type: 'Private' },
    { name: 'Holy Cross of Davao College', type: 'Private' },
    { name: 'San Pedro College', type: 'Private' },
    { name: 'Davao Medical School Foundation', type: 'Private' },
    { name: 'University of the Immaculate Conception', type: 'Private' },
    { name: 'Cor Jesu College', type: 'Private' },
  ];

  const input     = document.getElementById('aff-name-input');
  const dropdown  = document.getElementById('ac-dropdown');
  const clearBtn  = document.getElementById('ac-clear-btn');
  const affType   = document.getElementById('aff-type');
  let activeIdx   = -1;
  let results     = [];

  function escRe(s) {
    return s.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  }

  function highlight(text, query) {
    if (!query) return text;
    const re = new RegExp(`(${escRe(query)})`, 'gi');
    return text.replace(re, '<mark>$1</mark>');
  }

  function render(query) {
    const q = query.trim().toLowerCase();
    if (!q || q.length < 2) {
      dropdown.classList.remove('open');
      dropdown.innerHTML = '';
      return;
    }

    // Score each school
    results = PH_SCHOOLS
      .map(s => {
        const low = s.name.toLowerCase();
        let score = 0;
        if (low.startsWith(q))           score = 100;
        else if (low.includes(' ' + q))  score = 80;
        else if (low.includes(q))        score = 60;
        return { ...s, score };
      })
      .filter(s => s.score > 0)
      .sort((a, b) => b.score - a.score)
      .slice(0, 12);

    if (!results.length) {
      dropdown.innerHTML = '<div class="ac-empty">No schools found. You can still type your school name.</div>';
      dropdown.classList.add('open');
      return;
    }

    dropdown.innerHTML = results.map((s, i) =>
      `<div class="ac-item" data-idx="${i}" role="option">
        ${highlight(s.name, query.trim())}
        <span class="ac-type-badge">${s.type}</span>
      </div>`
    ).join('');

    dropdown.querySelectorAll('.ac-item').forEach(el => {
      el.addEventListener('mousedown', e => {
        e.preventDefault();
        select(parseInt(el.dataset.idx));
      });
    });

    activeIdx = -1;
    dropdown.classList.add('open');
  }

  function select(idx) {
    if (results[idx]) {
      input.value = results[idx].name;
      clearBtn.style.display = 'block';
    }
    close();
  }

  function close() {
    dropdown.classList.remove('open');
    dropdown.innerHTML = '';
    activeIdx = -1;
  }

  function setActive(i) {
    const items = dropdown.querySelectorAll('.ac-item');
    items.forEach(el => el.classList.remove('ac-active'));
    if (i >= 0 && i < items.length) {
      items[i].classList.add('ac-active');
      items[i].scrollIntoView({ block: 'nearest' });
    }
    activeIdx = i;
  }

  input.addEventListener('input', () => {
    clearBtn.style.display = input.value ? 'block' : 'none';
    render(input.value);
  });

  input.addEventListener('keydown', e => {
    const items = dropdown.querySelectorAll('.ac-item');
    if (e.key === 'ArrowDown') {
      e.preventDefault();
      setActive(Math.min(activeIdx + 1, items.length - 1));
    } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      setActive(Math.max(activeIdx - 1, 0));
    } else if (e.key === 'Enter' && activeIdx >= 0) {
      e.preventDefault();
      select(activeIdx);
    } else if (e.key === 'Escape') {
      close();
    }
  });

  input.addEventListener('blur', () => setTimeout(close, 150));

  clearBtn.addEventListener('click', () => {
    input.value = '';
    clearBtn.style.display = 'none';
    input.focus();
    close();
  });

  // Show/hide label changes based on affiliation type
  affType.addEventListener('change', () => {
    const label = document.getElementById('aff-name-label');
    const ph    = input;
    if (affType.value === 'Company') {
      label.textContent = 'Company / Organization name';
      ph.placeholder = 'e.g. Accenture Philippines';
    } else if (affType.value === 'Independent') {
      label.textContent = 'Description (optional)';
      ph.placeholder = 'e.g. Freelancer, Self-employed';
    } else {
      label.textContent = 'School / University name';
      ph.placeholder = 'e.g. University of the Philippines';
    }
  });

  // Trigger if old value present
  if (input.value) clearBtn.style.display = 'block';
})();
</script>

@endsection