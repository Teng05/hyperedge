@extends('layouts.student')
@section('title', $quiz->title)
@section('content')

<style>
  /* Premium Midnight Tech theme overrides specifically for Quiz interface */
  body.quiz-page {
    background-color: #090d16 !important;
    background-image: 
      radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.1) 0px, transparent 50%), 
      radial-gradient(at 100% 0%, rgba(139, 92, 246, 0.1) 0px, transparent 50%),
      radial-gradient(at 50% 100%, rgba(59, 130, 246, 0.08) 0px, transparent 50%) !important;
    background-attachment: fixed !important;
    color: #e2e8f0 !important;
  }
  
  .quiz-page .main {
    background: transparent !important;
  }
  
  .quiz-page .topbar {
    background: rgba(9, 13, 22, 0.8) !important;
    backdrop-filter: blur(12px) !important;
    -webkit-backdrop-filter: blur(12px) !important;
    border-bottom: 1px solid #1f2937 !important;
    color: #e2e8f0 !important;
  }
 
  .quiz-page .topbar-crumb, .quiz-page .topbar-crumb span {
    color: #94a3b8 !important;
  }
 
  .quiz-container {
    max-width: 720px;
    margin: 40px auto;
    padding: 0 16px;
  }
 
  .quiz-wizard-card {
    background: #111827;
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid #334155;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 
      0 4px 6px -1px rgba(0, 0, 0, 0.2), 
      0 20px 40px -10px rgba(0, 0, 0, 0.4), 
      0 0 0 1px rgba(99, 102, 241, 0.05);
    position: relative;
    overflow: hidden;
  }

  /* Premium Highlight Top Edge */
  .quiz-wizard-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, #6366f1, #8b5cf6, #3b82f6);
    z-index: 5;
  }

  /* Pulse warning for critical timer */
  @keyframes timer-pulse {
    0%, 100% {
      box-shadow: 0 0 4px rgba(239, 68, 68, 0.15);
      border-color: rgba(239, 68, 68, 0.25);
      background: rgba(239, 68, 68, 0.02);
    }
    50% {
      box-shadow: 0 0 12px rgba(239, 68, 68, 0.3);
      border-color: rgba(239, 68, 68, 0.5);
      background: rgba(239, 68, 68, 0.06);
    }
  }

  /* Timer bar layout styling */
  .timer-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #1f2937;
    border: 1px solid #374151;
    padding: 12px 24px;
    border-radius: 9999px;
    margin-bottom: 28px;
    transition: all 0.3s ease;
  }
 
  .timer-wrapper.warning {
    animation: timer-pulse 1s infinite alternate;
  }
 
  .timer-clock {
    font-family: var(--font-mono);
    font-size: 14px;
    font-weight: 700;
    color: #94a3b8;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    transition: color 0.3s ease;
  }
 
  .timer-wrapper.warning .timer-clock {
    color: #ef4444 !important;
  }
 
  .timer-bar-container {
    flex: 1;
    height: 6px;
    background: #374151;
    border-radius: 3px;
    margin-left: 20px;
    overflow: hidden;
    position: relative;
  }
 
  .timer-bar-fill {
    height: 100%;
    width: 100%;
    background: linear-gradient(90deg, #6366f1, #4f46e5);
    box-shadow: 0 0 6px rgba(99, 102, 241, 0.2);
    transition: width 1s linear;
  }
 
  /* Progress indicators */
  .quiz-progress-steps {
    display: flex;
    gap: 8px;
    margin-bottom: 32px;
  }
 
  .progress-step {
    flex: 1;
    height: 6px;
    background: #374151;
    border-radius: 3px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }
 
  .progress-step.active, .progress-step.completed {
    background: linear-gradient(90deg, #6366f1, #8b5cf6);
    box-shadow: 0 0 12px rgba(99, 102, 241, 0.35);
  }
 
  /* Questions & Selection locks */
  .question-container {
    display: none;
    opacity: 0;
  }
 
  .question-container.active {
    display: block;
    opacity: 1;
  }
 
  .quiz-question-container {
    -webkit-user-select: none !important; /* Safari */
    -moz-user-select: none !important;    /* Firefox */
    -ms-user-select: none !important;     /* IE10+ */
    user-select: none !important;         /* Standard */
  }
 
  .question-num {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    color: #6366f1;
    letter-spacing: 1px;
    margin-bottom: 10px;
  }
 
  .question-title {
    font-size: 20px;
    font-weight: 800;
    color: #ffffff;
    line-height: 1.5;
    margin-bottom: 28px;
    letter-spacing: -0.02em;
  }

  /* Spring Bounce keyframe for rewarding click feel */
  @keyframes option-bounce {
    0% { transform: scale(1); }
    30% { transform: scale(1.02); }
    50% { transform: scale(0.99); }
    100% { transform: scale(1); }
  }

  /* Option buttons cards */
  .option-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 18px 22px;
    border-radius: 14px;
    border: 1px solid #1e293b;
    background: #0f172a;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    margin-bottom: 14px;
    position: relative;
    user-select: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  }
 
  .option-card:hover {
    background: #1e293b;
    border-color: #4f46e5;
    box-shadow: 0 0 20px rgba(99, 102, 241, 0.25);
    transform: translateY(-2.5px) scale(1.02);
  }
 
  .option-card.selected {
    animation: option-bounce 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    background: rgba(79, 70, 229, 0.2);
    border-color: #6366f1;
    box-shadow: 0 0 25px rgba(99, 102, 241, 0.45);
    transform: scale(1.03);
  }
 
  .option-badge {
    width: 30px; height: 30px;
    border-radius: 50%;
    background: #111827;
    border: 1.5px solid #1e293b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12.5px;
    font-weight: 800;
    color: #94a3b8;
    transition: all 0.25s ease;
    flex-shrink: 0;
  }
 
  .option-card:hover .option-badge {
    border-color: #818cf8;
    color: #818cf8;
    background: #0f172a;
  }
 
  .option-card.selected .option-badge {
    background: linear-gradient(135deg, #4f46e5, #8b5cf6);
    border-color: #6366f1;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
  }
 
  .option-tick-icon {
    display: none;
    opacity: 0;
    transform: scale(0.6);
    transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
  }
 
  .option-card.selected .option-letter {
    display: none;
  }
 
  .option-card.selected .option-tick-icon {
    display: block !important;
    opacity: 1;
    transform: scale(1);
  }
 
  .option-text {
    font-size: 14.5px;
    color: #cbd5e1;
    line-height: 1.5;
    transition: color 0.2s ease;
  }
 
  .option-card:hover .option-text {
    color: #ffffff;
  }
 
  .option-card.selected .option-text {
    color: #ffffff;
    font-weight: 600;
  }
 
  /* Footer Controls */
  .wizard-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 36px;
    padding-top: 24px;
    border-top: 1px solid #374151;
  }
 
  /* Back Button transitions and overrides */
  #btnPrev {
    transition: all 0.2s ease;
    background: #1f2937 !important;
    color: #cbd5e1 !important;
    border: 1px solid #374151 !important;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
  }
  #btnPrev:hover {
    background: #374151 !important;
    color: #ffffff !important;
    border-color: #4b5563 !important;
  }
 
  /* Next Button transitions and overrides */
  #btnNext {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    border: none !important;
    color: #ffffff !important;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  }
  #btnNext:hover {
    transform: scale(1.03);
    box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
  }

  /* Score Summary Panel */
  .score-summary-panel {
    display: none;
    opacity: 0;
    transform: scale(0.95);
    text-align: center;
  }

  .score-emoji {
    font-size: 72px;
    margin-bottom: 16px;
    animation: floatEmoji 3s ease-in-out infinite;
  }

  @keyframes floatEmoji {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
  }

  /* Keyframe for security warning icon */
  @keyframes pulseAlert {
    0% { transform: scale(1); filter: drop-shadow(0 0 2px rgba(239, 68, 68, 0.2)); }
    100% { transform: scale(1.08); filter: drop-shadow(0 0 12px rgba(239, 68, 68, 0.6)); }
  }

  .score-title {
    font-family: var(--font-display);
    font-size: 32px;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.04em;
    margin-bottom: 12px;
  }
 
  .score-desc {
    color: #94a3b8;
    font-size: 15px;
    line-height: 1.6;
    max-width: 500px;
    margin: 0 auto 32px;
  }
 
  .score-card {
    background: #1f2937;
    border: 1px solid #374151;
    border-radius: 18px;
    padding: 28px;
    max-width: 360px;
    margin: 0 auto 36px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
  }
 
  .score-label {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    color: #818cf8;
    letter-spacing: 1.2px;
    margin-bottom: 10px;
  }
 
  .score-points {
    font-family: var(--font-display);
    font-size: 64px;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 10px;
    color: #ffffff;
  }
 
  .score-points span {
    font-size: 28px;
    color: #94a3b8;
  }
 
  .score-threshold {
    font-size: 13px;
    color: #94a3b8;
  }
 
  .result-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
  }
 
  /* Overlay Spinner */
  .analyzing-overlay {
    display: none;
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(9, 13, 22, 0.95);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 10;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    border-radius: 20px;
  }
</style>

<div class="quiz-container">
  
  {{-- Hidden SVG Defs for Premium Gradients --}}
  <svg style="width:0; height:0; position:absolute;" aria-hidden="true" focusable="false">
    <defs>
      <linearGradient id="grad-tab" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#ef4444" />
        <stop offset="100%" stop-color="#f97316" />
      </linearGradient>
      <linearGradient id="grad-inspect" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#8b5cf6" />
        <stop offset="100%" stop-color="#ec4899" />
      </linearGradient>
      <linearGradient id="grad-clipboard" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#f97316" />
        <stop offset="100%" stop-color="#f59e0b" />
      </linearGradient>
      <linearGradient id="grad-select" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#f43f5e" />
        <stop offset="100%" stop-color="#8b5cf6" />
      </linearGradient>
      <linearGradient id="grad-fullscreen" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#3b82f6" />
        <stop offset="100%" stop-color="#06b6d4" />
      </linearGradient>
      <linearGradient id="grad-bounds" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#f59e0b" />
        <stop offset="100%" stop-color="#ef4444" />
      </linearGradient>
      <linearGradient id="grad-navigation" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#0d9488" />
        <stop offset="100%" stop-color="#10b981" />
      </linearGradient>
      <linearGradient id="grad-pass" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#10b981" />
        <stop offset="100%" stop-color="#059669" />
      </linearGradient>
      <linearGradient id="grad-cert" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#fbbf24" />
        <stop offset="100%" stop-color="#d97706" />
      </linearGradient>
      <linearGradient id="grad-fail" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#f43f5e" />
        <stop offset="100%" stop-color="#e11d48" />
      </linearGradient>
    </defs>
  </svg>

  {{-- Header Crumb --}}
  <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
    <a href="{{ route('student.dashboard') }}" class="btn btn-ghost btn-sm" style="background:#1e293b; border:1px solid #334155; color:#cbd5e1; font-weight:600; padding:6px 14px; border-radius:8px; transition:all 0.2s ease; display: inline-flex; align-items: center; gap: 6px;" onmouseover="this.style.background='#334155'; this.style.color='#ffffff'; this.style.borderColor='#4b5563';" onmouseout="this.style.background='#1e293b'; this.style.color='#cbd5e1'; this.style.borderColor='#334155';">
      <svg style="width: 12px; height: 12px; color: #cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
      </svg>
      Exit
    </a>
    <div>
      <h1 style="font-family:var(--font-display); font-size:18px; font-weight:800; color:#ffffff; letter-spacing:-0.03em;">{{ $quiz->title }}</h1>
      <p style="color:#64748b; font-size:12px; margin-top:2px;">
        Passing score: {{ $quiz->passing_score }}/{{ $quiz->total_points }}
        @if($attemptCount > 0) &middot; Attempt #{{ $attemptCount + 1 }} @endif
      </p>
    </div>
  </div>

  {{-- Wizard Card Container --}}
  <div class="quiz-wizard-card">
    
    {{-- Analyzing answers loader --}}
    <div class="analyzing-overlay" id="analyzingOverlay">
      <svg class="w-8 h-8 animate-spin" fill="none" viewBox="0 0 24 24" style="width:32px; height:32px; color:#6366f1; margin-bottom:16px;">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
      <div style="font-size:14px; font-weight:700; letter-spacing:0.5px; color:#ffffff;">ANALYZING ASSESSMENT BUILDS...</div>
      <div style="font-size:12px; color:#94a3b8; margin-top:4px;">Evaluating option matches and commits.</div>
    </div>

    {{-- Pre-Exam Gateway --}}
    <div id="gatewayScreen" style="text-align: center; padding: 20px 10px;">
      <div style="display: flex; justify-content: center; margin-bottom: 24px;">
        <div style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1)); padding: 18px; border-radius: 18px; border: 1.5px solid rgba(99, 102, 241, 0.2); display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.05);">
          <svg style="width: 48px; height: 48px; color: #8b5cf6; filter: drop-shadow(0 0 10px rgba(139, 92, 246, 0.4));" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
          </svg>
        </div>
      </div>
      <h2 style="font-family:var(--font-display); font-size: 26px; font-weight: 800; color: #ffffff; margin-bottom: 12px; letter-spacing: -0.03em;">Assessment Rules & Disclaimer</h2>
      <p style="color: #94a3b8; font-size: 14.5px; line-height: 1.6; max-width: 540px; margin: 0 auto 32px;">
        This assessment is strictly monitored in real-time. Please review the security guidelines below. Starting the assessment confirms your agreement to these terms.
      </p>

      <div style="background: rgba(9, 13, 22, 0.6); border: 1px solid #1e293b; border-radius: 16px; padding: 24px; text-align: left; max-width: 560px; margin: 0 auto 36px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);">
        <div style="display: flex; align-items: flex-start; gap: 14px; margin-bottom: 18px;">
          <div style="position: relative; flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 8px;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="url(#grad-tab)" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span style="position: absolute; top: -2px; right: -2px; width: 8px; height: 8px; background: linear-gradient(135deg, #ef4444, #f97316); border: 1.5px solid #111827; border-radius: 50%; box-shadow: 0 0 6px rgba(239, 68, 68, 0.6);"></span>
          </div>
          <div>
            <h4 style="font-weight: 700; color: #ffffff; font-size: 13.5px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">TAB SWITCH ALERT</h4>
            <p style="color: #94a3b8; font-size: 13px; line-height: 1.5; margin: 0;">Switching tabs, minimizing the browser, or pressing Alt+Tab will result in an AUTOMATIC SYSTEM SUBMISSION of your current assessment.</p>
          </div>
        </div>
        
        <div style="display: flex; align-items: flex-start; gap: 14px; margin-bottom: 18px;">
          <div style="position: relative; flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: rgba(139, 92, 246, 0.1); border: 1px solid rgba(139, 92, 246, 0.2); border-radius: 8px;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="url(#grad-inspect)" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span style="position: absolute; font-size: 8px; font-weight: 800; bottom: 2px; right: 2px; color: #8b5cf6; background: #111827; padding: 0px 2px; border-radius: 3px; border: 1px solid rgba(139, 92, 246, 0.4); line-height: 1; font-family: monospace;">&lt;/&gt;</span>
          </div>
          <div>
            <h4 style="font-weight: 700; color: #ffffff; font-size: 13.5px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">ANTI-INSPECT LOCK</h4>
            <p style="color: #94a3b8; font-size: 13px; line-height: 1.5; margin: 0;">Right-click and developer tools keyboard shortcuts have been disabled for security.</p>
          </div>
        </div>

        <div style="display: flex; align-items: flex-start; gap: 14px; margin-bottom: 18px;">
          <div style="position: relative; flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: rgba(249, 115, 22, 0.1); border: 1px solid rgba(249, 115, 22, 0.2); border-radius: 8px;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="url(#grad-clipboard)" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l6 6m0-6l-6 6" />
            </svg>
          </div>
          <div>
            <h4 style="font-weight: 700; color: #ffffff; font-size: 13.5px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">CLIPBOARD RESTRICTIONS</h4>
            <p style="color: #94a3b8; font-size: 13px; line-height: 1.5; margin: 0;">Copying, cutting, or pasting text inside the examination terminal is strictly blocked.</p>
          </div>
        </div>

        <div style="display: flex; align-items: flex-start; gap: 14px; margin-bottom: 18px;">
          <div style="position: relative; flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.2); border-radius: 8px;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="url(#grad-select)" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.24 9.05a4.75 4.75 0 010 5.9M12 4v16M8.76 9.05a4.75 4.75 0 000 5.9" />
            </svg>
            <span style="position: absolute; top: -1px; right: -1px; width: 12px; height: 12px; background: #111827; border: 1px solid #f43f5e; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
              <svg style="width: 8px; height: 8px;" fill="none" stroke="url(#grad-select)" viewBox="0 0 24 24" stroke-width="3">
                <circle cx="12" cy="12" r="10" />
                <path d="M4.93 4.93l14.14 14.14" />
              </svg>
            </span>
          </div>
          <div>
            <h4 style="font-weight: 700; color: #ffffff; font-size: 13.5px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">TEXT SELECTION LOCKED</h4>
            <p style="color: #94a3b8; font-size: 13px; line-height: 1.5; margin: 0;">Highlighting or selecting question text for external distribution is prohibited.</p>
          </div>
        </div>

        <div style="display: flex; align-items: flex-start; gap: 14px; margin-bottom: 18px;">
          <div style="position: relative; flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 8px;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="url(#grad-fullscreen)" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4h4M20 8V4h-4M4 16v4h4M20 16v4h-4M12 9v6m-3-3h6" />
            </svg>
          </div>
          <div>
            <h4 style="font-weight: 700; color: #ffffff; font-size: 13.5px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">FULLSCREEN MANDATORY</h4>
            <p style="color: #94a3b8; font-size: 13px; line-height: 1.5; margin: 0;">Leaving fullscreen mode at any point during the assessment will trigger an immediate auto-submission.</p>
          </div>
        </div>

        <div style="display: flex; align-items: flex-start; gap: 14px; margin-bottom: 18px;">
          <div style="position: relative; flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 8px;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="url(#grad-bounds)" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </div>
          <div>
            <h4 style="font-weight: 700; color: #ffffff; font-size: 13.5px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">BOUNDS MONITOR</h4>
            <p style="color: #94a3b8; font-size: 13px; line-height: 1.5; margin: 0;">Dragging the cursor off-screen, using dual monitor setups, or losing active window focus is restricted.</p>
          </div>
        </div>

        <div style="display: flex; align-items: flex-start; gap: 14px;">
          <div style="position: relative; flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: rgba(13, 148, 136, 0.1); border: 1px solid rgba(13, 148, 136, 0.2); border-radius: 8px;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="url(#grad-navigation)" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
          </div>
          <div>
            <h4 style="font-weight: 700; color: #ffffff; font-size: 13.5px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">NAVIGATION LOCKED</h4>
            <p style="color: #94a3b8; font-size: 13px; line-height: 1.5; margin: 0;">Browser back and forward button navigation is locked to prevent page peeking.</p>
          </div>
        </div>
      </div>

      {{-- Interactive Consent Checkbox --}}
      <div style="margin: 0 auto 28px; max-width: 560px; display: flex; align-items: flex-start; gap: 12px; padding: 16px; background: rgba(9, 13, 22, 0.4); border: 1px solid #1e293b; border-radius: 12px; text-align: left; transition: all 0.2s ease;" id="consentContainer">
        <label style="position: relative; display: inline-flex; align-items: center; cursor: pointer; user-select: none; margin: 0; flex-shrink: 0; top: 2px;">
          <input type="checkbox" id="consentCheckbox" style="position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0;">
          <span style="height: 18px; width: 18px; background-color: #0f172a; border: 1.5px solid #334155; border-radius: 4px; display: inline-block; position: relative; transition: all 0.2s ease; box-shadow: inset 0 1px 2px rgba(0,0,0,0.2);" id="customCheckboxVisual">
            <svg style="position: absolute; display: none; width: 12px; height: 12px; color: #fff; top: 2px; left: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
          </span>
        </label>
        <span style="color: #94a3b8; font-size: 12.5px; line-height: 1.5; font-weight: 500;">I explicitly understand that any attempt to switch tabs, press Alt+Tab, minimize the browser, right-click, or manipulate text will result in an IMMEDIATE, AUTOMATIC system submission of my current assessment with no re-take options.</span>
      </div>

      <button type="button" id="btnStartQuiz" class="btn btn-primary" disabled style="padding: 14px 36px; font-weight: 700; font-size: 15px; background: #1e293b !important; border: 1px solid #334155 !important; color: #64748b !important; opacity: 0.65; border-radius: 10px; transition: all 0.2s ease; box-shadow: none; cursor: not-allowed;">
        I Understand, Start Assessment
      </button>
    </div>

    {{-- Main Wizard Panel --}}
    <div id="quizWizard" style="display: none;">
      
      {{-- Animated Timer Countdown --}}
      <div class="timer-wrapper">
        <div class="timer-clock" id="timerClock" style="display: flex; align-items: center; gap: 6px;">
          <svg style="width: 18px; height: 18px; color: #06b6d4; filter: drop-shadow(0 0 6px rgba(6, 182, 212, 0.7)); display: inline-block; vertical-align: middle; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span id="timerClockText">10:00</span>
        </div>
        <div class="timer-bar-container">
          <div class="timer-bar-fill" id="timerFill"></div>
        </div>
      </div>

      {{-- Steps Indicator Dots --}}
      <div class="quiz-progress-steps">
        @foreach($questions as $i => $q)
          <div class="progress-step @if($i === 0) active @endif" id="stepDot-{{ $i }}"></div>
        @endforeach
      </div>

      {{-- Quiz Form --}}
      <form id="quizForm" method="POST" action="{{ route('student.quiz.submit', $quiz->id) }}">
        @csrf
        
        @foreach($questions as $i => $question)
          <div class="question-container quiz-question-container @if($i === 0) active @endif" data-index="{{ $i }}">
            <div class="question-num">Question {{ $i + 1 }} of {{ $questions->count() }}</div>
            <div class="question-title">{{ $question->question_text }}</div>
            
            @foreach(['a','b','c','d'] as $letter)
               <div class="option-card" data-question-id="{{ $question->id }}" data-letter="{{ $letter }}">
                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $letter }}" style="display:none;" required>
                <div class="option-badge">
                  <span class="option-letter">{{ strtoupper($letter) }}</span>
                  <svg class="option-tick-icon" style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                  </svg>
                </div>
                <div class="option-text">{{ $question->{'choice_'.$letter} }}</div>
              </div>
            @endforeach
          </div>
        @endforeach

        {{-- Footer Controls --}}
        <div class="wizard-footer">
          <button type="button" class="btn btn-ghost" id="btnPrev" style="display:none; align-items:center; gap:6px;">
            <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            Back
          </button>
          <div style="flex:1;"></div>
          <button type="button" class="btn btn-primary" id="btnNext" style="padding:10px 24px; display:inline-flex; align-items:center; gap:6px;">
            Next Question
            <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
          </button>
        </div>
      </form>
    </div>

    {{-- Score Summary Panel (Dynamic overlay via GSAP) --}}
    <div class="score-summary-panel" id="scoreSummaryPanel">
      <div class="score-emoji" id="resEmoji" style="display: inline-flex; align-items: center; justify-content: center; padding: 20px; border-radius: 9999px; background: rgba(9, 13, 22, 0.6); border: 1px solid #1e293b; width: 88px; height: 88px; box-shadow: 0 4px 12px rgba(0,0,0,0.3); margin-bottom: 24px;">
        <svg style="width: 48px; height: 48px; filter: drop-shadow(0 0 8px rgba(16, 185, 129, 0.5));" fill="none" stroke="url(#grad-pass)" viewBox="0 0 24 24" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
        </svg>
      </div>
      <h1 class="score-title" id="resTitle">Assessment Passed!</h1>
      <p class="score-desc" id="resDesc">Good job! You have cleared this challenge.</p>
      
      <div class="score-card">
        <div class="score-label">Graded Score</div>
        <div class="score-points"><span id="resScoreVal">8</span><span id="resTotalVal">/10</span></div>
        <div class="score-threshold">Passing threshold: {{ $quiz->passing_score }}/{{ $quiz->total_points }} pts</div>
      </div>

      <div class="result-actions" id="resActionRow">
        <!-- Injected dynamically -->
      </div>
    </div>

    {{-- Integrity Violation Panel --}}
    <div class="score-summary-panel" id="integrityViolationPanel" style="display: none; opacity: 0; text-align: center;">
      <div class="score-emoji" style="display: inline-flex; align-items: center; justify-content: center; padding: 20px; border-radius: 9999px; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); width: 88px; height: 88px; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.05); margin-bottom: 24px; animation: pulseAlert 2s infinite alternate;">
        <svg style="width: 48px; height: 48px; filter: drop-shadow(0 0 8px rgba(239, 68, 68, 0.5));" fill="none" stroke="url(#grad-fail)" viewBox="0 0 24 24" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
      </div>
      <h1 class="score-title" style="color: #ef4444 !important; font-size: 30px; font-weight: 800; letter-spacing: -0.04em; margin-bottom: 12px;">Assessment Terminated</h1>
      <p class="score-desc" style="color: #94a3b8; font-size: 15px; line-height: 1.6; max-width: 500px; margin: 0 auto 32px;">
        A security integrity violation (window blur, tab switch, or focus loss) was detected. This examination has been terminated and auto-submitted.
      </p>
      
      <div class="score-card" style="background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.2); box-shadow: 0 4px 20px rgba(239, 68, 68, 0.1);">
        <div class="score-label" style="color: #ef4444; letter-spacing: 1px;">Graded Score (Submitted State)</div>
        <div class="score-points" style="color: #ef4444;"><span id="violScoreVal">0</span><span id="violTotalVal">/10</span></div>
        <div class="score-threshold" style="color: #ef4444;">Passing threshold: {{ $quiz->passing_score }}/{{ $quiz->total_points }} pts</div>
      </div>

      <div class="result-actions" id="violActionRow">
        <!-- Injected dynamically -->
      </div>
    </div>

  </div>

  {{-- Custom Confirmation Modal --}}
  <div id="confirmModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(9, 13, 22, 0.8); backdrop-filter: blur(8px); z-index: 10000; align-items: center; justify-content: center; opacity: 0;">
    <div style="background: #111827; border-radius: 16px; padding: 32px; max-width: 420px; width: 90%; text-align: center; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3), 0 10px 10px -6px rgba(0,0,0,0.3); border: 1px solid #334155; color: #ffffff;">
      <div style="display:flex; justify-content:center; margin-bottom:20px;">
        <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1)); padding: 16px; border-radius: 50%; border: 1.5px solid rgba(16, 185, 129, 0.2); width: 64px; height: 64px; display:flex; align-items:center; justify-content:center;">
          <svg style="width: 32px; height: 32px; color: #10b981; filter: drop-shadow(0 2px 6px rgba(16, 185, 129, 0.3));" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
      </div>
      <h3 style="font-family: var(--font-display); font-size: 20px; font-weight: 800; color: #ffffff; margin-bottom: 10px;">Submit Assessment?</h3>
      <p style="color: #94a3b8; font-size: 14px; line-height: 1.5; margin-bottom: 24px;">Are you sure you want to submit your answers? This action cannot be undone.</p>
      <div style="display: flex; gap: 12px; justify-content: center;">
        <button type="button" id="btnCancelSubmit" class="btn btn-ghost" style="padding: 10px 20px; background: #1f2937; border: 1px solid #374151; color: #cbd5e1; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#374151'; this.style.color='#ffffff';" onmouseout="this.style.background='#1f2937'; this.style.color='#cbd5e1';">
          Cancel
        </button>
        <button type="button" id="btnConfirmSubmit" class="btn btn-primary" style="padding: 10px 20px; background: linear-gradient(135deg, #10b981, #059669); border: none; color: #ffffff; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);" onmouseover="this.style.transform='scale(1.02)';" onmouseout="this.style.transform='scale(1)';">
          Yes, Submit
        </button>
      </div>
    </div>
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Apply quiz layout configurations
  document.body.classList.add('quiz-page');

  // Freeze history state to intercept browser back navigation
  history.pushState(null, null, location.href);
  window.onpopstate = function () {
    history.go(1);
  };

  const totalQuestions = {{ $questions->count() }};
  const quizType = "{{ $quiz->type }}";
  let timeLimit = quizType === 'final_exam' ? 1800 : 600; // 30 minutes or 10 minutes
  let timerInterval;
  let hasExamStarted = false;

  // Initialize Timer countdown
  const timerClockText = document.getElementById('timerClockText');
  const timerFill = document.getElementById('timerFill');
  const startLimit = timeLimit;

  // Pre-Exam Gateway Screen Transition
  const btnStartQuiz = document.getElementById('btnStartQuiz');
  const gatewayScreen = document.getElementById('gatewayScreen');
  const quizWizard = document.getElementById('quizWizard');

  // Consent checkbox enforcement logic
  const consentCheckbox = document.getElementById('consentCheckbox');
  const customCheckboxVisual = document.getElementById('customCheckboxVisual');
  const checkboxSvg = customCheckboxVisual.querySelector('svg');
  const consentContainer = document.getElementById('consentContainer');

  consentCheckbox.addEventListener('change', function() {
    if (this.checked) {
      customCheckboxVisual.style.backgroundColor = '#4f46e5';
      customCheckboxVisual.style.borderColor = '#4f46e5';
      customCheckboxVisual.style.boxShadow = '0 0 8px rgba(79, 70, 229, 0.35)';
      checkboxSvg.style.display = 'block';
      consentContainer.style.borderColor = 'rgba(99, 102, 241, 0.4)';
      consentContainer.style.background = 'rgba(17, 24, 39, 0.8)';
      
      // Enable button
      btnStartQuiz.removeAttribute('disabled');
      btnStartQuiz.style.background = 'linear-gradient(135deg, #4f46e5, #6366f1)';
      btnStartQuiz.style.color = '#ffffff';
      btnStartQuiz.style.opacity = '1';
      btnStartQuiz.style.cursor = 'pointer';
      btnStartQuiz.style.boxShadow = '0 4px 15px rgba(79, 70, 229, 0.35)';
    } else {
      customCheckboxVisual.style.backgroundColor = '#0f172a';
      customCheckboxVisual.style.borderColor = '#334155';
      customCheckboxVisual.style.boxShadow = 'inset 0 1px 2px rgba(0,0,0,0.2)';
      checkboxSvg.style.display = 'none';
      consentContainer.style.borderColor = '#1e293b';
      consentContainer.style.background = 'rgba(9, 13, 22, 0.4)';
      
      // Disable button
      btnStartQuiz.setAttribute('disabled', 'true');
      btnStartQuiz.style.background = '#1e293b';
      btnStartQuiz.style.color = '#64748b';
      btnStartQuiz.style.opacity = '0.65';
      btnStartQuiz.style.cursor = 'not-allowed';
      btnStartQuiz.style.boxShadow = 'none';
    }
  });

  // Custom Premium Toast Alert
  function showPremiumAlert(title, message, type = 'info') {
    const existing = document.getElementById('premium-alert-toast');
    if (existing) {
      existing.remove();
    }

    const toast = document.createElement('div');
    toast.id = 'premium-alert-toast';
    toast.style.position = 'fixed';
    toast.style.top = '24px';
    toast.style.right = '24px';
    toast.style.zIndex = '99999';
    toast.style.background = '#111827';
    toast.style.border = '1px solid #1e293b';
    toast.style.backdropFilter = 'blur(12px)';
    toast.style.webkitBackdropFilter = 'blur(12px)';
    toast.style.borderLeft = type === 'error' ? '4px solid #ef4444' : '4px solid #6366f1';
    toast.style.boxShadow = '0 10px 30px -5px rgba(0,0,0,0.4), 0 8px 15px -6px rgba(0,0,0,0.3)';
    toast.style.borderRadius = '12px';
    toast.style.padding = '16px 24px';
    toast.style.maxWidth = '380px';
    toast.style.display = 'flex';
    toast.style.alignItems = 'center';
    toast.style.gap = '16px';
    toast.style.transform = 'translateX(120%)';
    toast.style.transition = 'transform 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
    toast.style.fontFamily = 'system-ui, -apple-system, sans-serif';

    const icon = document.createElement('div');
    icon.style.flexShrink = '0';
    icon.style.display = 'flex';
    icon.style.alignItems = 'center';
    if (type === 'error') {
      icon.innerHTML = `
        <svg style="width: 24px; height: 24px; color: #ef4444; filter: drop-shadow(0 0 6px rgba(239, 68, 68, 0.45));" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
      `;
    } else {
      icon.innerHTML = `
        <svg style="width: 24px; height: 24px; color: #6366f1; filter: drop-shadow(0 0 6px rgba(99, 102, 241, 0.45));" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      `;
    }

    const textContainer = document.createElement('div');
    const titleEl = document.createElement('div');
    titleEl.style.fontWeight = '800';
    titleEl.style.color = '#ffffff';
    titleEl.style.fontSize = '14px';
    titleEl.style.letterSpacing = '-0.01em';
    titleEl.textContent = title;

    const msgEl = document.createElement('div');
    msgEl.style.color = '#cbd5e1';
    msgEl.style.fontSize = '13px';
    msgEl.style.marginTop = '4px';
    msgEl.style.lineHeight = '1.5';
    msgEl.textContent = message;

    textContainer.appendChild(titleEl);
    textContainer.appendChild(msgEl);
    toast.appendChild(icon);
    toast.appendChild(textContainer);

    document.body.appendChild(toast);

    setTimeout(() => {
      toast.style.transform = 'translateX(0)';
    }, 50);

    setTimeout(() => {
      toast.style.transform = 'translateX(120%)';
      setTimeout(() => {
        toast.remove();
      }, 400);
    }, 4500);
  }

  btnStartQuiz.addEventListener('click', () => {
    if (btnStartQuiz.hasAttribute('disabled') || !consentCheckbox.checked) {
      return;
    }

    if (document.documentElement.requestFullscreen) {
      document.documentElement.requestFullscreen().catch(err => {
        console.error("Fullscreen request failed", err);
      });
    }

    gsap.to(gatewayScreen, {
      opacity: 0,
      scale: 0.95,
      duration: 0.3,
      onComplete: () => {
        gatewayScreen.style.display = 'none';
        quizWizard.style.display = 'block';
        gsap.fromTo(quizWizard,
          { opacity: 0, scale: 0.95 },
          { opacity: 1, scale: 1, duration: 0.35, onComplete: () => {
             hasExamStarted = true;
             startTimerCountdown();
          }}
        );
      }
    });
  });

  function startTimerCountdown() {
    timerInterval = setInterval(() => {
      timeLimit--;
      const mins = Math.floor(timeLimit / 60).toString().padStart(2, '0');
      const secs = (timeLimit % 60).toString().padStart(2, '0');
      timerClockText.textContent = `${mins}:${secs}`;

      const pct = (timeLimit / startLimit) * 100;
      timerFill.style.width = `${pct}%`;

      if (timeLimit <= 60) {
        timerClockText.style.color = '#ef4444';
        const timerWrapper = document.querySelector('.timer-wrapper');
        if (timerWrapper && !timerWrapper.classList.contains('warning')) {
          timerWrapper.classList.add('warning');
        }
      }

      if (timeLimit <= 0) {
        clearInterval(timerInterval);
        hasExamStarted = false;
        if (document.fullscreenElement) {
          document.exitFullscreen().catch(()=>{});
        }
        showPremiumAlert('Time Expired', 'Time has expired! Submitting your quiz answers automatically.', 'error');
        submitQuizAnswers();
      }
    }, 1000);
  }

  // 1. Source Code Protection: Disable Context Menu
  document.addEventListener('contextmenu', (e) => {
    e.preventDefault();
    showPremiumAlert('Security Lock', 'Right-click context menu has been disabled for security.', 'error');
  });

  // 2. Source Code Protection: Disable Keyboard Shortcuts (F12, View Source, DevTools)
  document.addEventListener('keydown', (e) => {
    if (e.key === 'F12' || e.keyCode === 123) {
      e.preventDefault();
      showPremiumAlert('Security Lock', 'Developer tools keyboard shortcuts have been disabled for security.', 'error');
      return;
    }
    if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i' || e.key === 'J' || e.key === 'j' || e.key === 'C' || e.key === 'c' || e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 67)) {
      e.preventDefault();
      showPremiumAlert('Security Lock', 'Developer tools keyboard shortcuts have been disabled for security.', 'error');
      return;
    }
    if (e.ctrlKey && (e.key === 'U' || e.key === 'u' || e.keyCode === 85)) {
      e.preventDefault();
      showPremiumAlert('Security Lock', 'View source shortcuts have been disabled for security.', 'error');
      return;
    }
  });

  // 3. Plagiarism Shield: Block selectstart & copy-cut-paste events
  document.querySelectorAll('.quiz-question-container').forEach(container => {
    container.addEventListener('selectstart', (e) => e.preventDefault());
  });

  const cardContainer = document.querySelector('.quiz-wizard-card');
  if (cardContainer) {
    ['copy', 'cut', 'paste'].forEach(evtName => {
      cardContainer.addEventListener(evtName, (e) => {
        e.preventDefault();
        showPremiumAlert('Security Lock', 'Copying, cutting, or pasting text inside the examination terminal is strictly blocked.', 'error');
      });
    });
  }

  // 4. Tab-Switch & Blur Detection (The Auto-Submit Engine)
  function handleIntegrityViolation() {
    if (!hasExamStarted) return;
    
    // Stop the session so it doesn't double-trigger
    hasExamStarted = false;
    clearInterval(timerInterval);

    if (document.fullscreenElement) {
      document.exitFullscreen().catch(()=>{});
    }

    submitQuizAnswers(true);
  }

  document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'hidden') {
      handleIntegrityViolation();
    }
  });

  window.addEventListener('blur', () => {
    handleIntegrityViolation();
  });

  // 5. Environmental Constraint: Fullscreen Exit detection
  document.addEventListener('fullscreenchange', () => {
    if (hasExamStarted && !document.fullscreenElement) {
      showPremiumAlert('Security Lock', 'Fullscreen exited prematurely. Terminating assessment...', 'error');
      setTimeout(() => {
        handleIntegrityViolation();
      }, 800);
    }
  });

  // 6. Environmental Constraint: Off-screen cursor bounds tracker
  document.addEventListener('mouseleave', (e) => {
    if (hasExamStarted) {
      showPremiumAlert('Security Watch', 'Please keep your cursor within the active assessment area to prevent focus loss.', 'error');
    }
  });

  // Wizard state management
  let currentStep = 0;
  const btnPrev = document.getElementById('btnPrev');
  const btnNext = document.getElementById('btnNext');

  // Option selections listener
  document.querySelectorAll('.option-card').forEach(card => {
    card.addEventListener('click', function() {
      const qId = this.dataset.questionId;
      document.querySelectorAll(`.option-card[data-question-id="${qId}"]`).forEach(c => {
        c.classList.remove('selected');
      });
      this.classList.add('selected');
      const radio = this.querySelector('input[type="radio"]');
      if (radio) {
        radio.checked = true;
      }
    });
  });

  // Next / Previous buttons trigger
  btnNext.addEventListener('click', () => {
    // Validation: Enforce answer selection
    const currentContainer = document.querySelector(`.question-container[data-index="${currentStep}"]`);
    const selectedInput = currentContainer.querySelector('input[type="radio"]:checked');
    if (!selectedInput) {
      showPremiumAlert("Selection Required", "Please select one of the choices before proceeding.", "error");
      return;
    }

    if (currentStep < totalQuestions - 1) {
      // Transition to next question
      gsap.to(currentContainer, {
        opacity: 0,
        x: -24,
        duration: 0.2,
        onComplete: () => {
          currentContainer.classList.remove('active');
          document.getElementById(`stepDot-${currentStep}`).className = 'progress-step completed';
          
          currentStep++;
          
          const nextContainer = document.querySelector(`.question-container[data-index="${currentStep}"]`);
          nextContainer.classList.add('active');
          document.getElementById(`stepDot-${currentStep}`).className = 'progress-step active';
          
          gsap.fromTo(nextContainer, 
             { opacity: 0, x: 24 },
             { opacity: 1, x: 0, duration: 0.25 }
          );

          updateFooterButtons();
        }
      });
    } else {
      // Final submission triggered (via custom confirm modal)
      const confirmModal = document.getElementById('confirmModal');
      confirmModal.style.display = 'flex';
      gsap.fromTo(confirmModal, { opacity: 0 }, { opacity: 1, duration: 0.25 });
    }
  });

  // Confirm Modal Action Handlers
  document.getElementById('btnCancelSubmit').addEventListener('click', () => {
    const confirmModal = document.getElementById('confirmModal');
    gsap.to(confirmModal, {
      opacity: 0,
      duration: 0.2,
      onComplete: () => { confirmModal.style.display = 'none'; }
    });
  });

  document.getElementById('btnConfirmSubmit').addEventListener('click', () => {
    const confirmModal = document.getElementById('confirmModal');
    gsap.to(confirmModal, {
      opacity: 0,
      duration: 0.2,
      onComplete: () => {
        confirmModal.style.display = 'none';
        hasExamStarted = false; // Disable integrity monitor on exit
        if (document.fullscreenElement) {
          document.exitFullscreen().catch(()=>{});
        }
        submitQuizAnswers(false);
      }
    });
  });

  // Disable focus tracking when clicking internal links or leaving
  document.querySelectorAll('a').forEach(lnk => {
    lnk.addEventListener('click', () => {
      hasExamStarted = false;
      if (document.fullscreenElement) {
        document.exitFullscreen().catch(()=>{});
      }
    });
  });

  btnPrev.addEventListener('click', () => {
    if (currentStep > 0) {
      const currentContainer = document.querySelector(`.question-container[data-index="${currentStep}"]`);
      
      gsap.to(currentContainer, {
        opacity: 0,
        x: 24,
        duration: 0.2,
        onComplete: () => {
          currentContainer.classList.remove('active');
          document.getElementById(`stepDot-${currentStep}`).className = 'progress-step';
          
          currentStep--;
          
          const prevContainer = document.querySelector(`.question-container[data-index="${currentStep}"]`);
          prevContainer.classList.add('active');
          document.getElementById(`stepDot-${currentStep}`).className = 'progress-step active';
          
          gsap.fromTo(prevContainer, 
             { opacity: 0, x: -24 },
             { opacity: 1, x: 0, duration: 0.25 }
          );

          updateFooterButtons();
        }
      });
    }
  });

  function updateFooterButtons() {
    // Back button visibility
    if (currentStep > 0) {
      btnPrev.style.display = 'inline-flex';
    } else {
      btnPrev.style.display = 'none';
    }

    // Next / Submit button text
    if (currentStep === totalQuestions - 1) {
      btnNext.innerHTML = `
        <span style="display: inline-flex; align-items: center; gap: 6px;">
          Submit Assessment
          <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
          </svg>
        </span>
      `;
      btnNext.style.background = '#10b981';
      btnNext.style.borderColor = '#10b981';
    } else {
      btnNext.innerHTML = `
        <span style="display: inline-flex; align-items: center; gap: 6px;">
          Next Question
          <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
          </svg>
        </span>
      `;
      btnNext.style.background = 'linear-gradient(135deg, #4f46e5, #6366f1)';
      btnNext.style.borderColor = 'transparent';
    }
  }

  function submitQuizAnswers(isViolation = false) {
    const overlay = document.getElementById('analyzingOverlay');
    overlay.style.display = 'flex';
    gsap.fromTo(overlay, { opacity: 0 }, { opacity: 1, duration: 0.3 });

    const form = document.getElementById('quizForm');
    const formData = new FormData(form);
    if (isViolation) {
      formData.append('is_violation', '1');
    }

    axios.post(form.action, formData, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
      }
    })
    .then(res => {
      const data = res.data;
      if (data.success) {
        clearInterval(timerInterval);
        
        gsap.to(overlay, {
          opacity: 0,
          duration: 0.25,
          onComplete: () => {
            overlay.style.display = 'none';
            
            const wizard = document.getElementById('quizWizard');
            gsap.to(wizard, {
              opacity: 0,
              scale: 0.95,
              duration: 0.35,
              onComplete: () => {
                wizard.style.display = 'none';
                if (isViolation) {
                  showIntegrityViolationPanel(data);
                } else {
                  showResultPanel(data);
                }
              }
            });
          }
        });
      } else {
        showPremiumAlert("Submission Error", "An error occurred during submission. Please try again.", "error");
        overlay.style.display = 'none';
      }
    })
    .catch(err => {
      console.error(err);
      showPremiumAlert("Network Error", "Network connection error. Please try again.", "error");
      overlay.style.display = 'none';
    });
  }

  function showIntegrityViolationPanel(data) {
    const violationPanel = document.getElementById('integrityViolationPanel');
    const scoreVal = document.getElementById('violScoreVal');
    const totalVal = document.getElementById('violTotalVal');
    const actionRow = document.getElementById('violActionRow');

    scoreVal.textContent = data.score;
    totalVal.textContent = '/' + data.total;

    actionRow.innerHTML = `
      <a href="${data.dashboard_url}" class="btn btn-ghost" style="padding:12px 24px; background:#1e293b; border: 1px solid #ef4444; color:#ef4444; text-decoration:none; border-radius:8px; transition:all 0.2s ease;" onmouseover="this.style.background='rgba(239, 68, 68, 0.1)';" onmouseout="this.style.background='#1e293b';">
        Return to Dashboard
      </a>
    `;

    violationPanel.style.display = 'block';
    
    gsap.fromTo(violationPanel, 
      { opacity: 0, scale: 0.9 }, 
      { opacity: 1, scale: 1, duration: 0.6, ease: 'power3.out' }
    );
  }

  function showResultPanel(data) {
    const resultPanel = document.getElementById('scoreSummaryPanel');
    const emoji = document.getElementById('resEmoji');
    const title = document.getElementById('resTitle');
    const desc = document.getElementById('resDesc');
    const scoreVal = document.getElementById('resScoreVal');
    const totalVal = document.getElementById('resTotalVal');
    const actionRow = document.getElementById('resActionRow');

    if (data.passed) {
      if (data.type === 'final_exam') {
        emoji.innerHTML = `
          <svg style="width: 48px; height: 48px; filter: drop-shadow(0 0 8px rgba(251, 191, 36, 0.5));" fill="none" stroke="url(#grad-cert)" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84a50.578 50.578 0 00-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"></path>
          </svg>
        `;
      } else {
        emoji.innerHTML = `
          <svg style="width: 48px; height: 48px; filter: drop-shadow(0 0 8px rgba(16, 185, 129, 0.5));" fill="none" stroke="url(#grad-pass)" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
          </svg>
        `;
      }
      title.textContent = data.type === 'final_exam' ? 'Certified Developer!' : 'You Passed!';
      scoreVal.style.color = '#10b981';
      
      if (data.type === 'final_exam') {
        desc.textContent = "Congratulations! You have passed the Final Comprehensive Certification Quiz. Your official HTML Developer Certificate is ready!";
        actionRow.innerHTML = `
          <a href="${data.certificate_url}" class="btn" style="padding:12px 24px; background:linear-gradient(135deg, #fbbf24 0%, #d97706 100%); color:#fff; border:none; font-weight:700; border-radius:8px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:transform 0.2s ease;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5M12 15v6m-4.5 0h9" />
            </svg>
            View Certificate
          </a>
          <a href="${data.dashboard_url}" class="btn btn-ghost" style="padding:12px 24px; background:#1e293b; border: 1px solid #334155; color:#cbd5e1; text-decoration:none; border-radius:8px; transition:all 0.2s ease;" onmouseover="this.style.background='#334155'; this.style.color='#ffffff'; this.style.borderColor='#4b5563';" onmouseout="this.style.background='#1e293b'; this.style.color='#cbd5e1'; this.style.borderColor='#334155';">
            Go to Dashboard
          </a>
        `;
      } else {
        desc.textContent = "Great job! The next module is now unlocked.";
        actionRow.innerHTML = `
          <a href="${data.dashboard_url}" class="btn btn-primary" style="padding:12px 24px; color:#fff; text-decoration:none; background:linear-gradient(135deg, #4f46e5, #6366f1); border:none; border-radius:8px; font-weight:600; transition:all 0.2s ease;" onmouseover="this.style.transform='scale(1.03)';" onmouseout="this.style.transform='scale(1)';">
            Continue →
          </a>
        `;
      }
    } else {
      emoji.innerHTML = `
        <svg style="width: 48px; height: 48px; filter: drop-shadow(0 0 8px rgba(244, 63, 94, 0.5));" fill="none" stroke="url(#grad-fail)" viewBox="0 0 24 24" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
      `;
      title.textContent = 'Not Quite Yet';
      scoreVal.style.color = '#ef4444';
      desc.textContent = "You can retake this quiz. Keep studying!";
      actionRow.innerHTML = `
        <a href="${data.retake_url}" class="btn btn-primary" style="padding:12px 24px; color:#fff; text-decoration:none; background:linear-gradient(135deg, #4f46e5, #6366f1); border:none; border-radius:8px; font-weight:600; transition:all 0.2s ease;" onmouseover="this.style.transform='scale(1.03)';" onmouseout="this.style.transform='scale(1)';">Retake Quiz</a>
        <a href="${data.dashboard_url}" class="btn btn-ghost" style="padding:12px 24px; background:#1e293b; border: 1px solid #334155; color:#cbd5e1; text-decoration:none; border-radius:8px; transition:all 0.2s ease;" onmouseover="this.style.background='#334155'; this.style.color='#ffffff'; this.style.borderColor='#4b5563';" onmouseout="this.style.background='#1e293b'; this.style.color='#cbd5e1'; this.style.borderColor='#334155';">← Back to Dashboard</a>
      `;
    }

    scoreVal.textContent = data.score;
    totalVal.textContent = '/' + data.total;

    resultPanel.style.display = 'block';
    
    // Smooth GSAP fade/scale transitions for the results summary panel
    gsap.fromTo(resultPanel, 
      { opacity: 0, scale: 0.9 }, 
      { opacity: 1, scale: 1, duration: 0.6, ease: 'power3.out' }
    );

    gsap.fromTo(emoji,
      { scale: 0, rotation: -30 },
      { scale: 1, rotation: 0, duration: 0.8, delay: 0.15, ease: 'back.out(1.7)' }
    );

    gsap.fromTo([title, desc, '.score-card', actionRow],
      { opacity: 0, y: 15 },
      { opacity: 1, y: 0, duration: 0.45, stagger: 0.12, delay: 0.25, ease: 'power2.out' }
    );
  }
});
</script>

@endsection
