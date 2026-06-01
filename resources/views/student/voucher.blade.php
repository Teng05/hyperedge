@extends('layouts.student')
@section('title', 'Voucher & Payment')
@section('content')

<div class="page">

  {{-- Page heading --}}
  <div class="greeting" style="margin-bottom:28px;padding-bottom:24px;">
    <div class="greeting-text">
      <div class="greeting-sub">Access</div>
      <div class="greeting-title">Exam <em>Voucher</em></div>
      <div class="greeting-copy">Use your voucher code to unlock module access.</div>
    </div>
  </div>

  @if(session('success'))
    <div style="background:var(--green-bg);border:1px solid rgba(24,121,78,0.2);border-radius:8px;padding:11px 16px;font-size:13px;color:var(--green);margin-bottom:20px;max-width:560px;">
      {{ session('success') }}
    </div>
  @endif

  {{-- ── STATE 1: Voucher approved ── --}}
  @if($voucher && $voucher->is_approved)
    <div class="section-card" style="max-width:540px;text-align:center;padding:48px 36px;">
      <div style="font-size:52px;margin-bottom:16px;">✅</div>
      <div style="font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--green);margin-bottom:8px;">Voucher Active</div>
      <div style="font-size:22px;font-weight:800;letter-spacing:-0.03em;color:var(--ink);margin-bottom:10px;">You have full access</div>
      <div style="font-size:13px;color:var(--ink3);line-height:1.6;margin-bottom:6px;">
        Voucher code
        <code style="font-family:'JetBrains Mono',monospace;font-size:13px;background:var(--green-bg);color:var(--green);padding:2px 8px;border-radius:4px;">{{ $voucher->code }}</code>
        is approved.
      </div>
      <div style="font-size:12px;color:var(--muted);margin-bottom:24px;">
        Approved {{ $voucher->approved_at?->format('F j, Y') }}
      </div>
      <a href="{{ route('student.dashboard') }}"
        style="display:inline-block;padding:10px 24px;background:var(--accent);color:#fff;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;">
        Go to Dashboard →
      </a>
    </div>

  {{-- ── STATE 2: Voucher assigned but not yet paid ── --}}
  @elseif($voucher && !$voucher->is_paid && !$voucher->is_approved)
    <div class="section-card" style="max-width:540px;">
      <div class="section-header">
        <div class="section-title">Payment Required</div>
      </div>

      <div style="background:var(--amber-bg);border:1px solid rgba(201,123,0,0.2);border-radius:8px;padding:14px 16px;margin-bottom:20px;">
        <div style="font-size:13px;font-weight:700;color:var(--amber);margin-bottom:3px;">Voucher Assigned</div>
        <div style="font-size:12px;color:rgba(201,123,0,0.8);line-height:1.6;">
          A voucher has been assigned to you. Please complete payment and click the button below to notify the admin.
        </div>
      </div>

      <div style="margin-bottom:20px;">
        <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted);margin-bottom:4px;">Your Voucher Code</div>
        <div style="font-family:'JetBrains Mono',monospace;font-size:20px;font-weight:700;letter-spacing:0.12em;color:var(--ink);background:var(--surface2);border:1px solid var(--border);border-radius:8px;padding:12px 16px;display:inline-block;">
          {{ $voucher->code }}
        </div>
      </div>

      <form method="POST" action="{{ route('student.voucher.paid') }}" enctype="multipart/form-data">
        @csrf
        
        <div style="margin-bottom:16px;">
          <label style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--ink3);display:block;margin-bottom:7px;">Upload Payment Proof (Receipt Screenshot)</label>
          <input type="file" name="payment_proof" accept="image/*"
            style="width:100%;padding:10px;background:var(--surface2);border:1px dashed var(--border2);border-radius:8px;color:var(--ink);font-size:13px;outline:none;"
            required>
        </div>

        <div style="margin-bottom:20px;">
          <label style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--ink3);display:block;margin-bottom:7px;">Reference Notes / Details (Optional)</label>
          <textarea name="notes" placeholder="e.g., GCash ref#, date of payment..."
            style="width:100%;height:70px;padding:12px;background:var(--surface2);border:1px solid var(--border);border-radius:8px;color:var(--ink);font-size:13px;font-family:inherit;resize:none;outline:none;transition:border-color 0.2s;"
            onfocus="this.style.borderColor='var(--indigo)'"
            onblur="this.style.borderColor='var(--border)'"></textarea>
        </div>

        <button type="submit"
          style="width:100%;padding:12px;background:var(--indigo);color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;letter-spacing:-0.01em;transition:all 0.2s;"
          onmouseover="this.style.background='var(--indigo2)'"
          onmouseout="this.style.background='var(--indigo)'"
          onclick="return confirm('Confirm that you have completed payment and uploaded the correct proof?')">
          ✓ Submit Payment Proof — Notify Admin
        </button>
      </form>
    </div>

  {{-- ── STATE 3: Marked paid, waiting for admin approval ── --}}
  @elseif($voucher && $voucher->is_paid && !$voucher->is_approved)
    <div class="section-card" style="max-width:540px;text-align:center;padding:48px 36px;">
      <div style="font-size:52px;margin-bottom:16px;">⏳</div>
      <div style="font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--amber);margin-bottom:8px;">Pending Approval</div>
      <div style="font-size:22px;font-weight:800;letter-spacing:-0.03em;color:var(--ink);margin-bottom:10px;">Waiting for admin review</div>
      <div style="font-size:13px;color:var(--ink3);line-height:1.6;">
        Your payment has been flagged for review. An admin will approve your access — usually within 24 hours.
        You'll receive an email once approved.
      </div>
    </div>

  {{-- ── STATE 4: No voucher — enter a code ── --}}
  @else
    <div style="max-width:560px;">

      <div class="section-card" style="margin-bottom:14px;">
        <div class="section-header">
          <div class="section-title">Enter Voucher Code</div>
        </div>

        <p style="font-size:13px;color:var(--ink3);margin-bottom:20px;line-height:1.6;">
          Your facilitator or admin will provide a voucher code after payment is confirmed.
          Enter it below to unlock your modules instantly.
        </p>

        <form method="POST" action="{{ route('student.voucher.redeem') }}">
          @csrf
          @error('code')
            <div style="background:var(--red-bg);border:1px solid rgba(201,48,48,0.2);border-radius:8px;padding:10px 14px;font-size:13px;color:var(--red);margin-bottom:14px;">
              {{ $message }}
            </div>
          @enderror

          <div style="margin-bottom:16px;">
            <label style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--ink3);display:block;margin-bottom:7px;">Voucher Code</label>
            <input type="text" name="code"
              style="width:100%;padding:13px 16px;background:var(--surface2);border:1px solid var(--border2);border-radius:8px;color:var(--ink);font-size:16px;font-family:'JetBrains Mono',monospace;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;outline:none;transition:border-color 0.2s;"
              placeholder="XXXX-XXXX"
              value="{{ old('code') }}"
              onfocus="this.style.borderColor='var(--accent)'"
              onblur="this.style.borderColor='var(--border2)'"
              required>
          </div>

          <button type="submit"
            style="width:100%;padding:12px;background:var(--accent);color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:700;font-family:'Bricolage Grotesque',sans-serif;cursor:pointer;letter-spacing:-0.01em;transition:background 0.2s;"
            onmouseover="this.style.background='var(--accent2)'"
            onmouseout="this.style.background='var(--accent)'">
            Redeem Voucher →
          </button>
        </form>
      </div>

      {{-- Info note --}}
      <div style="background:var(--surface2);border:1px solid var(--border);border-radius:10px;padding:16px 18px;font-size:12.5px;color:var(--ink3);line-height:1.65;">
        <strong style="display:block;margin-bottom:4px;color:var(--ink);">Don't have a code yet?</strong>
        Contact your facilitator or admin. They will assign a voucher to your account after verifying your payment.
        Once assigned, you'll receive an email with your code and instructions.
      </div>
    </div>
  @endif

</div>
@endsection