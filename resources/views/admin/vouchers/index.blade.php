@extends('layouts.admin')
@section('title', 'Vouchers')
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

  /* Grid Layout */
  .grid-split {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 24px;
  }

  @media(max-width: 768px) {
    .grid-split {
      grid-template-columns: 1fr;
    }
  }

  /* Cards */
  .card-premium {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    padding: 24px;
    opacity: 0;
    transform: translateY(12px);
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .card-head {
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 700;
    color: var(--ink);
    letter-spacing: -0.02em;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border);
    margin-bottom: 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 16px;
  }

  .form-label {
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--ink3);
  }

  .form-input, .form-select {
    padding: 10px 12px;
    border: 1px solid var(--border2);
    background: var(--surface2);
    border-radius: var(--r);
    color: var(--ink);
    font-size: 13px;
    outline: none;
    font-family: inherit;
    transition: all 0.2s;
  }
  .form-input:focus, .form-select:focus {
    border-color: var(--navy);
    background: var(--surface);
  }

  .btn-full {
    width: 100%;
    background: var(--navy);
    color: #fff;
    border: 1px solid var(--navy);
    padding: 10px;
    border-radius: var(--r);
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.18s;
  }
  .btn-full:hover {
    background: var(--navy2);
    border-color: var(--navy2);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(13,31,60,0.18);
  }

  /* Table styling */
  .table-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
    opacity: 0;
    transform: translateY(12px);
    margin-top: 24px;
  }

  .pending-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 12px 14px;
    border: 1px solid var(--border);
    background: var(--surface2);
    border-radius: var(--r);
    margin-bottom: 10px;
    transition: border-color 0.2s;
  }
  .pending-item:hover {
    border-color: var(--border2);
  }

  .badge-approved {
    background: var(--green-light);
    color: var(--green);
    border-color: var(--green-border);
  }

  /* Modal Styles */
  .modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(13,31,60,0.6);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 200;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
  }

  .modal-overlay.active {
    opacity: 1;
    pointer-events: auto;
  }

  .modal-container {
    background: var(--bg);
    border: 2px solid var(--ink);
    border-radius: var(--r-lg);
    width: 90%;
    max-width: 550px;
    max-height: 85vh;
    overflow-y: auto;
    box-shadow: 0 20px 45px rgba(0,0,0,0.15);
    transform: scale(0.95) translateY(12px);
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
  }

  .modal-overlay.active .modal-container {
    transform: scale(1) translateY(0);
  }

  .modal-head {
    padding: 20px;
    border-bottom: 2px solid var(--ink);
    background: var(--surface);
    display: flex;
    justify-content: space-between;
    align-items: center;
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
    font-size: 20px;
    cursor: pointer;
    color: var(--muted);
    transition: color 0.2s;
  }
  .modal-close:hover { color: var(--red); }

  .modal-body {
    padding: 20px;
  }

  .modal-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 18px;
  }

  .info-block {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r);
    padding: 12px;
  }

  .info-label {
    font-size: 8px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 4px;
  }

  .info-val {
    font-size: 13px;
    font-weight: 600;
    color: var(--ink);
  }

  .notes-box {
    background: var(--gold-light);
    border: 1px solid var(--gold-border);
    border-radius: var(--r);
    padding: 12px 14px;
    margin-bottom: 18px;
  }

  .notes-box-title {
    font-size: 8px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 4px;
  }

  .notes-box-text {
    font-size: 12px;
    font-style: italic;
    color: var(--amber);
  }

  .proof-preview-container {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r);
    padding: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    max-height: 250px;
    overflow: hidden;
    margin-bottom: 20px;
    cursor: zoom-in;
  }

  .proof-preview-container img {
    max-width: 100%;
    max-height: 230px;
    object-fit: contain;
    border-radius: 4px;
  }

  .modal-foot {
    padding: 16px 20px;
    background: var(--surface);
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: flex-end;
    gap: 12px;
  }
</style>

<div class="dash-wrap">

  {{-- Header --}}
  <div class="dash-header" id="dh">
    <div>
      <div class="dash-headline">Vouchers<span>.</span></div>
      <div class="dash-sub">Generate numeric keys and verify manual student bank payments</div>
    </div>
  </div>

  <div class="grid-split">
    
    {{-- Generate Card --}}
    <div class="card-premium" id="gc">
      <div class="card-head">
        <span>Generate Vouchers</span>
        <span class="badge badge-valid">Keys</span>
      </div>
      <form method="POST" action="{{ route('admin.vouchers.generate') }}" style="flex:1; display:flex; flex-direction:column; justify-content:space-between;">
        @csrf
        <div>
          <div class="form-group">
            <label class="form-label">Assign to Student (optional)</label>
            <select class="form-select" name="assigned_to">
              <option value="">— Unassigned / Open Code —</option>
              @foreach($students as $student)
              <option value="{{ $student->id }}">{{ $student->full_name }} ({{ $student->email }})</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Quantity</label>
            <input class="form-input" type="number" name="quantity" value="1" min="1" max="50" required>
          </div>
        </div>
        <button type="submit" class="btn-full" style="margin-top:20px;">Generate Voucher Codes</button>
      </form>
    </div>

    {{-- Pending Approvals Card --}}
    <div class="card-premium" id="pc">
      <div class="card-head">
        <span>Pending Reviews</span>
        @php $pending = $vouchers->where('is_paid', true)->where('is_approved', false); @endphp
        <span class="badge badge-pending">{{ $pending->count() }} Waiting</span>
      </div>
      <div style="flex:1; overflow-y:auto; max-height:260px;">
        @forelse($pending as $v)
        <div class="pending-item">
          <div style="flex:1;">
            <div style="font-family:'JetBrains Mono', monospace; font-size:13px; font-weight:700; color:var(--gold);">{{ $v->code }}</div>
            <div style="font-size:12px; font-weight:600; color:var(--ink2); margin-top:2px;">{{ $v->assignedTo?->full_name ?? 'Unassigned' }}</div>
            <div style="font-size:10px; color:var(--muted); margin-top:1px;">{{ $v->assignedTo?->email }}</div>
          </div>
          <div style="display:flex; gap:6px;">
            <button class="btn btn-ghost btn-sm btn-review" 
                    data-id="{{ $v->id }}"
                    data-code="{{ $v->code }}"
                    data-name="{{ $v->assignedTo?->full_name }}"
                    data-email="{{ $v->assignedTo?->email }}"
                    data-notes="{{ $v->notes }}"
                    data-proof="{{ $v->payment_proof ? asset('storage/' . $v->payment_proof) : '' }}"
                    data-action="{{ route('admin.vouchers.approve', $v->id) }}">
              Review
            </button>
            <form method="POST" action="{{ route('admin.vouchers.approve', $v->id) }}">
              @csrf @method('PATCH')
              <button type="submit" class="btn btn-primary btn-sm">Quick Approve</button>
            </form>
          </div>
        </div>
        @empty
        <div style="text-align:center; color:var(--muted); font-size:12px; padding:48px 0; font-style:italic;">
          No bank payments pending review.
        </div>
        @endforelse
      </div>
    </div>

  </div>

  {{-- Table Card --}}
  <div class="table-card" id="tc">
    <div class="card-head" style="border-bottom:none; padding:18px 22px 6px;">
      <span>Active Registry</span>
      <span class="badge badge-valid">Totals: {{ $vouchers->count() }}</span>
    </div>
    <table>
      <thead>
        <tr>
          <th>Code</th>
          <th>Assigned To</th>
          <th>Proof Paid</th>
          <th>Approved Status</th>
          <th>Redemption</th>
          <th>Generated</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($vouchers as $v)
        <tr>
          <td>
            <code style="font-family:'JetBrains Mono', monospace; font-size:12.5px; font-weight:700; color:var(--navy3);">{{ $v->code }}</code>
          </td>
          <td>
            @if($v->assignedTo)
              <div style="font-weight:600; color:var(--ink2);">{{ $v->assignedTo->full_name }}</div>
              <div style="font-size:10px; color:var(--muted);">{{ $v->assignedTo->email }}</div>
            @else
              <span style="color:var(--muted); font-style:italic;">Open Pool</span>
            @endif
          </td>
          <td>
            @if($v->payment_proof)
              <button class="btn btn-ghost btn-sm btn-review" 
                      style="padding: 2px 8px; font-size:10px;"
                      data-id="{{ $v->id }}"
                      data-code="{{ $v->code }}"
                      data-name="{{ $v->assignedTo?->full_name }}"
                      data-email="{{ $v->assignedTo?->email }}"
                      data-notes="{{ $v->notes }}"
                      data-proof="{{ asset('storage/' . $v->payment_proof) }}"
                      data-action="{{ route('admin.vouchers.approve', $v->id) }}">
                🔍 View Proof
              </button>
            @else
              <span style="color:var(--muted); font-size:11px;">—</span>
            @endif
          </td>
          <td>
            <span class="badge {{ $v->is_approved ? 'badge-approved' : 'badge-pending' }}">
              {{ $v->is_approved ? 'Approved' : 'Pending' }}
            </span>
          </td>
          <td>
            <span class="badge {{ $v->is_used ? 'badge-inactive' : 'badge-active' }}">
              {{ $v->is_used ? 'Redeemed' : 'Available' }}
            </span>
          </td>
          <td style="color:var(--muted); font-size:11.5px;">
            {{ $v->created_at->format('M j, Y') }}
          </td>
          <td>
            <form method="POST" action="{{ route('admin.vouchers.destroy', $v->id) }}" onsubmit="return confirm('Permanently delete this voucher code?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="text-align:center; color:var(--muted); padding:36px; font-style:italic;">
            No vouchers have been registered in the system database.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>

{{-- Custom Payment Proof Modal --}}
<div class="modal-overlay" id="proofModalOverlay">
  <div class="modal-container">
    <div class="modal-head">
      <div class="modal-title">Payment Verification</div>
      <button class="modal-close" id="closeModalBtn">&times;</button>
    </div>
    <div class="modal-body">
      
      <div class="modal-info-grid">
        <div class="info-block">
          <div class="info-label">Voucher Code</div>
          <div class="info-val" id="modalVoucherCode" style="font-family:'JetBrains Mono', monospace; color:var(--gold);">XXXX-XXXX</div>
        </div>
        <div class="info-block">
          <div class="info-label">Student Name</div>
          <div class="info-val" id="modalStudentName">—</div>
        </div>
        <div class="info-block" style="grid-column: span 2;">
          <div class="info-label">Student Email</div>
          <div class="info-val" id="modalStudentEmail">—</div>
        </div>
      </div>

      <div class="notes-box" id="modalNotesBox" style="display:none;">
        <div class="notes-box-title">Student Notes / Message</div>
        <div class="notes-box-text" id="modalNotesText">—</div>
      </div>

      <div class="info-label" style="margin-bottom:6px;">Submitted Payment Proof</div>
      <div class="proof-preview-container" id="modalProofContainer">
        <img id="modalProofImg" src="" alt="Proof of Payment">
      </div>

    </div>
    <div class="modal-foot">
      <button class="btn btn-ghost" id="modalCloseBtn">Close</button>
      <form method="POST" id="modalApproveForm" action="">
        @csrf @method('PATCH')
        <button type="submit" class="btn btn-primary" id="modalApproveBtn">Verify & Approve Access</button>
      </form>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Entrance Animations
  const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
  tl.to('#dh', { opacity: 1, y: 0, duration: 0.5 })
    .to('#gc', { opacity: 1, y: 0, duration: 0.4 }, '-=0.2')
    .to('#pc', { opacity: 1, y: 0, duration: 0.4 }, '-=0.25')
    .to('#tc', { opacity: 1, y: 0, duration: 0.5 }, '-=0.2');

  // Modal Handlers
  const overlay = document.getElementById('proofModalOverlay');
  const closeModalBtn = document.getElementById('closeModalBtn');
  const modalCloseBtn = document.getElementById('modalCloseBtn');
  const modalVoucherCode = document.getElementById('modalVoucherCode');
  const modalStudentName = document.getElementById('modalStudentName');
  const modalStudentEmail = document.getElementById('modalStudentEmail');
  const modalNotesBox = document.getElementById('modalNotesBox');
  const modalNotesText = document.getElementById('modalNotesText');
  const modalProofImg = document.getElementById('modalProofImg');
  const modalApproveForm = document.getElementById('modalApproveForm');
  const modalApproveBtn = document.getElementById('modalApproveBtn');

  function openModal(data) {
    modalVoucherCode.textContent = data.code;
    modalStudentName.textContent = data.name || 'Unassigned';
    modalStudentEmail.textContent = data.email || '—';
    
    if (data.notes && data.notes.trim() !== '') {
      modalNotesText.textContent = data.notes;
      modalNotesBox.style.display = 'block';
    } else {
      modalNotesBox.style.display = 'none';
    }

    if (data.proof) {
      modalProofImg.src = data.proof;
      modalProofImg.style.display = 'block';
    } else {
      modalProofImg.src = '';
      modalProofImg.style.display = 'none';
    }

    modalApproveForm.action = data.action;

    // Show/hide approve form button in modal depending on whether it is already approved
    // In our case, the button triggers review. In case they review already approved, we handle it:
    // If there is no action or if they just view proof, we hide the approve button
    if (data.action) {
      modalApproveForm.style.display = 'block';
    } else {
      modalApproveForm.style.display = 'none';
    }

    overlay.classList.add('active');
  }

  function closeModal() {
    overlay.classList.remove('active');
  }

  // Bind click handlers to review buttons
  document.querySelectorAll('.btn-review').forEach(btn => {
    btn.addEventListener('click', () => {
      const isPending = btn.closest('.pending-item') !== null;
      openModal({
        id: btn.getAttribute('data-id'),
        code: btn.getAttribute('data-code'),
        name: btn.getAttribute('data-name'),
        email: btn.getAttribute('data-email'),
        notes: btn.getAttribute('data-notes'),
        proof: btn.getAttribute('data-proof'),
        action: isPending ? btn.getAttribute('data-action') : null
      });
    });
  });

  closeModalBtn.addEventListener('click', closeModal);
  modalCloseBtn.addEventListener('click', closeModal);
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) closeModal();
  });
});
</script>

@endsection
