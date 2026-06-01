@extends('layouts.student')
@section('title', 'My Certificate')
@section('content')

<style>
  /* Screen styling updates for high fidelity */
  .no-print {
    display: flex;
    gap: 12px;
    margin-bottom: 24px;
  }
  
  /* Print-only CSS style rules */
  @media print {
    @page {
      size: A4 landscape;
      margin: 0;
    }
    
    /* Completely hide any trace of standard application UI */
    .sidebar, .topbar, .greeting, .section-card, .btn, button, .no-print, .alert,
    header, nav, footer, aside, [style*="max-width:620px"], .main > .topbar {
      display: none !important;
    }
    
    /* Reset main layout wrappers */
    .main {
      margin-left: 0 !important;
      padding: 0 !important;
      background: #fafaf7 !important;
    }
    
    .page {
      padding: 0 !important;
      margin: 0 !important;
    }
    
    body {
      background: #fafaf7 !important;
    }
    
    /* Make print-only certificate container full landscape page */
    .print-only-certificate {
      display: block !important;
      width: 297mm !important;
      height: 210mm !important;
      box-sizing: border-box !important;
      padding: 18mm !important;
      background: #fafaf7 !important;
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      z-index: 9999999 !important;
    }
  }
</style>

<div class="page">

  {{-- Heading --}}
  <div class="greeting no-print" style="margin-bottom:32px;padding-bottom:24px;display:flex;justify-content:space-between;align-items:end;border-bottom:1px solid var(--border)">
    <div class="greeting-text">
      <div class="greeting-sub" style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--indigo)">Achievement</div>
      <div class="greeting-title" style="font-family:'Syne',sans-serif;font-size:36px;font-weight:800;letter-spacing:-0.05em;color:var(--ink);margin-top:4px;">My <em>Certificate</em></div>
      <div class="greeting-copy" style="font-size:13px;color:var(--muted);margin-top:6px;">Your official HyperEdge HTML Certification credential.</div>
    </div>
    
    @if($certificate)
      <div class="no-print">
        <button onclick="window.print()" class="btn btn-primary" style="background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); border: none; padding: 11px 22px; font-weight: 700; color: #fff; box-shadow: 0 4px 12px rgba(217, 119, 6, 0.2); display: inline-flex; align-items: center; gap: 8px;">
          🖨️ Print / Save as PDF
        </button>
      </div>
    @endif
  </div>

  @if($certificate)
    <div style="max-width:620px;">

      {{-- Certificate card (dark, like the cert-card in dashboard) --}}
      <div style="background:linear-gradient(135deg,var(--ink) 0%,#1e1c16 100%);border-radius:16px;padding:40px;position:relative;overflow:hidden;margin-bottom:20px;">
        {{-- Decorative glow --}}
        <div style="position:absolute;top:-60px;right:-60px;width:220px;height:220px;border-radius:50%;background:radial-gradient(circle,rgba(79,70,229,0.25),transparent 70%);pointer-events:none;"></div>
        <div style="position:absolute;bottom:-50px;left:-30px;width:160px;height:160px;border-radius:50%;background:radial-gradient(circle,rgba(79,70,229,0.1),transparent 70%);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;">
          <div style="font-size:9px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:rgba(255,255,255,0.35);margin-bottom:24px;">
            Certificate of Completion
          </div>

          <div style="font-size:13px;color:rgba(255,255,255,0.4);margin-bottom:6px;">This certifies that</div>
          <div style="font-family:'Syne',sans-serif;font-size:32px;font-weight:800;letter-spacing:-0.04em;color:#fff;margin-bottom:6px;">
            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
          </div>
          <div style="font-size:13px;color:rgba(255,255,255,0.4);margin-bottom:24px;">has successfully completed the</div>

          <div style="font-size:18px;font-weight:700;color:#fbbf24;letter-spacing:-0.02em;margin-bottom:28px;">
            HyperEdge Academy — HTML Developer Certification
          </div>

          {{-- Certificate code box --}}
          <div style="display:inline-block;background:rgba(251,191,36,0.1);border:1px solid rgba(251,191,36,0.2);border-radius:10px;padding:14px 28px;margin-bottom:24px;">
            <div style="font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,0.35);margin-bottom:6px;">Certificate Code</div>
            <div style="font-family:'JetBrains Mono',monospace;font-size:22px;font-weight:700;letter-spacing:0.15em;color:#fff;">
              {{ $certificate->certificate_code }}
            </div>
          </div>

          <div style="font-size:12px;color:rgba(255,255,255,0.35);">
            Issued {{ $certificate->issued_at->format('F j, Y') }}
            &nbsp;·&nbsp;
            📧 Sent to {{ Auth::user()->email }}
          </div>
        </div>
      </div>

      {{-- Info card --}}
      <div class="section-card no-print" style="background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:24px;">
        <div class="section-header" style="margin-bottom:18px;">
          <div class="section-title" style="font-family:'Syne',sans-serif; font-size:14px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">Certificate Details</div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
          <div>
            <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted);margin-bottom:4px;">Recipient</div>
            <div style="font-size:14px;font-weight:600;color:var(--ink);">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
          </div>
          <div>
            <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted);margin-bottom:4px;">Program</div>
            <div style="font-size:14px;font-weight:600;color:var(--ink);">HTML Developer Certification</div>
          </div>
          <div>
            <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted);margin-bottom:4px;">Date Issued</div>
            <div style="font-size:14px;font-weight:600;color:var(--ink);">{{ $certificate->issued_at->format('F j, Y') }}</div>
          </div>
          <div>
            <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted);margin-bottom:4px;">Certificate Code</div>
            <div style="font-family:'JetBrains Mono',monospace;font-size:14px;font-weight:700;color:var(--amber);">{{ $certificate->certificate_code }}</div>
          </div>
        </div>
      </div>
    </div>

    {{-- BREATHTAKING LANDSCAPE PRINT ONLY VIEW --}}
    <div class="print-only-certificate" style="display: none;">
      <div style="border: 12px double #b45309; padding: 45px; text-align: center; background: #fafaf7; width: 100%; height: 100%; box-sizing: border-box; display: flex; flex-direction: column; justify-content: space-between; border-radius: 4px; position: relative;">
        <!-- Top border accent -->
        <div style="font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 800; letter-spacing: 5px; text-transform: uppercase; color: #b45309; margin-top: 15px;">
          HYPEREDGE ACADEMY
        </div>
        <div style="margin: 12px auto 20px; width: 80px; height: 2px; background: #b45309;"></div>
        
        <div>
          <div style="font-size: 15px; font-style: italic; font-family: 'Inter', sans-serif; color: #475569; margin-bottom: 12px;">
            This certifies that
          </div>
          <h1 style="font-family: 'Syne', sans-serif; font-size: 42px; font-weight: 800; color: #0f172a; margin: 15px 0; letter-spacing: -0.03em;">
            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
          </h1>
          <div style="font-size: 14px; color: #475569; font-style: italic; max-width: 600px; margin: 15px auto; line-height: 1.6;">
            has successfully completed all modules, sandboxed code challenges, and passed the final comprehensive evaluation to be officially credentialed as an
          </div>
          <h2 style="font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 800; color: #b45309; margin: 20px 0; letter-spacing: -0.01em; text-transform: uppercase;">
            HTML Certified Developer
          </h2>
        </div>

        <div>
          <div style="display: inline-block; border: 1px dashed #b45309; background: #fdfdfb; border-radius: 8px; padding: 10px 28px; margin-bottom: 20px;">
            <span style="font-size: 9px; text-transform: uppercase; letter-spacing: 2px; color: #64748b; font-weight: 700; display: block; margin-bottom: 4px;">Credential Verification Code</span>
            <span style="font-family: 'JetBrains Mono', monospace; font-size: 18px; font-weight: 700; color: #0f172a; letter-spacing: 2.5px;">
              {{ $certificate->certificate_code }}
            </span>
          </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: flex-end; padding: 0 50px 10px;">
          <div style="text-align: left; width: 220px;">
            <div style="font-family: 'JetBrains Mono', monospace; font-size: 12px; color: #334155; margin-bottom: 8px; font-weight: 600;">
              {{ $certificate->issued_at->format('F j, Y') }}
            </div>
            <div style="border-top: 1px solid #94a3b8; padding-top: 8px; font-size: 9px; font-weight: 700; color: #64748b; letter-spacing: 1.5px; text-transform: uppercase;">
              Date Issued
            </div>
          </div>
          
          <!-- Golden Seal Badge -->
          <div style="width: 84px; height: 84px; border-radius: 50%; border: 2px dashed #b45309; display: flex; align-items: center; justify-content: center;">
            <div style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); border: 1px solid #b45309; display: flex; align-items: center; justify-content: center; font-size: 28px; color: #fff; box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25);">
              🏅
            </div>
          </div>

          <div style="text-align: right; width: 220px;">
            <div style="font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 800; color: #0f172a; margin-bottom: 8px; font-style: italic;">
              HyperEdge Board
            </div>
            <div style="border-top: 1px solid #94a3b8; padding-top: 8px; font-size: 9px; font-weight: 700; color: #64748b; letter-spacing: 1.5px; text-transform: uppercase;">
              Authorized Signatory
            </div>
          </div>
        </div>

      </div>
    </div>

  @else
    {{-- Not yet earned --}}
    <div class="section-card no-print" style="max-width:540px;text-align:center;padding:56px 36px;background:var(--surface); border:1px solid var(--border); border-radius:12px;">
      <div style="width:64px;height:64px;border-radius:16px;background:var(--surface2);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 20px;">🏅</div>
      <div style="font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--muted);margin-bottom:8px;">Not Yet Earned</div>
      <div style="font-size:22px;font-weight:800;letter-spacing:-0.03em;color:var(--ink);margin-bottom:10px;">Certificate Pending</div>
      <div style="font-size:13px;color:var(--ink3);line-height:1.7;margin-bottom:28px;">
        Complete all modules and pass the final exam to earn your official
        HTML Developer Certificate.
      </div>
      <a href="{{ route('student.dashboard') }}"
        style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;background:var(--indigo);color:#fff;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;letter-spacing:0.1px;transition:background 0.2s;"
        onmouseover="this.style.background='var(--indigo2)'"
        onmouseout="this.style.background='var(--indigo)'">
        Continue Learning →
      </a>
    </div>
  @endif

</div>

@endsection