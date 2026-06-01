@extends('layouts.student')
@section('title', 'Quiz Result')
@section('content')

<style>
  body {
    background: #090d16 !important;
    color: #e2e8f0 !important;
  }
  
  .main {
    background: #090d16 !important;
  }
  
  .topbar {
    background: #090d16 !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    color: #e2e8f0 !important;
  }

  .topbar-crumb, .topbar-crumb span {
    color: #94a3b8 !important;
  }

  .result-card-container {
    background: rgba(15, 23, 42, 0.45);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 20px;
    padding: 40px;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05), 0 20px 50px rgba(0, 0, 0, 0.4);
    max-width: 560px;
    margin: 60px auto;
    text-align: center;
  }

  .result-emoji {
    font-size: 72px;
    margin-bottom: 16px;
    animation: floatEmoji 3s ease-in-out infinite;
  }

  @keyframes floatEmoji {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
  }

  .result-title {
    font-family: var(--font-display);
    font-size: 30px;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.04em;
    margin-bottom: 12px;
  }

  .result-desc {
    color: #94a3b8;
    font-size: 14.5px;
    line-height: 1.6;
    margin-bottom: 32px;
  }

  .result-score-card {
    background: rgba(15, 23, 42, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 32px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  }

  .result-score-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: #64748b;
    letter-spacing: 1px;
    margin-bottom: 8px;
  }

  .result-score-points {
    font-family: var(--font-display);
    font-size: 60px;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 8px;
  }

  .result-score-points span {
    font-size: 26px;
    color: #475569;
  }

  .result-score-threshold {
    font-size: 12.5px;
    color: #64748b;
  }
</style>

<div class="result-card-container">
    @php 
        $passed = $passed ?? session('passed'); 
        $score = $score ?? session('score'); 
        $total = $total ?? session('total'); 
        $isViolation = $isViolation ?? session('is_violation') ?? false;
    @endphp

    <div class="result-emoji" style="display: inline-flex; align-items: center; justify-content: center; margin-bottom: 24px;">
        @if($isViolation)
            <div style="display: inline-flex; align-items: center; justify-content: center; padding: 20px; border-radius: 9999px; background: rgba(254, 242, 242, 0.8); border: 1px solid #fecaca; width: 88px; height: 88px; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.05); animation: floatEmoji 3s ease-in-out infinite;">
              <svg style="width: 48px; height: 48px; color: #ef4444; filter: drop-shadow(0 0 8px rgba(239, 68, 68, 0.5));" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
              </svg>
            </div>
        @else
            @if($passed)
                @if($quiz->type === 'final_exam')
                    <div style="display: inline-flex; align-items: center; justify-content: center; padding: 20px; border-radius: 9999px; background: rgba(251, 191, 36, 0.1); border: 1px solid rgba(251, 191, 36, 0.2); width: 88px; height: 88px; box-shadow: 0 4px 12px rgba(251, 191, 36, 0.05); animation: floatEmoji 3s ease-in-out infinite;">
                      <svg style="width: 48px; height: 48px; color: #fbbf24; filter: drop-shadow(0 0 8px rgba(251, 191, 36, 0.5));" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84a50.578 50.578 0 00-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"></path>
                      </svg>
                    </div>
                @else
                    <div style="display: inline-flex; align-items: center; justify-content: center; padding: 20px; border-radius: 9999px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); width: 88px; height: 88px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.05); animation: floatEmoji 3s ease-in-out infinite;">
                      <svg style="width: 48px; height: 48px; color: #10b981; filter: drop-shadow(0 0 8px rgba(16, 185, 129, 0.5));" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"></path>
                      </svg>
                    </div>
                @endif
            @else
                <div style="display: inline-flex; align-items: center; justify-content: center; padding: 20px; border-radius: 9999px; background: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.2); width: 88px; height: 88px; box-shadow: 0 4px 12px rgba(244, 63, 94, 0.05); animation: floatEmoji 3s ease-in-out infinite;">
                  <svg style="width: 48px; height: 48px; color: #f43f5e; filter: drop-shadow(0 0 8px rgba(244, 63, 94, 0.5));" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                  </svg>
                </div>
            @endif
        @endif
    </div>
    <h1 class="result-title" style="{{ $isViolation ? 'color:#ef4444 !important;' : '' }}">
        @if($isViolation)
            Assessment Terminated
        @elseif($passed)
            {{ $quiz->type === 'final_exam' ? 'Certified Developer!' : 'You Passed!' }}
        @else
            Not Quite Yet
        @endif
    </h1>
    <p class="result-desc">
        @if($isViolation)
            A security integrity violation (window blur, tab switch, or focus loss) was detected. This examination has been terminated and auto-submitted.
        @elseif($passed)
            @if($quiz->type === 'final_exam')
                Congratulations! You have passed the Final Comprehensive Certification Quiz. Your official HTML Developer Certificate is ready!
            @else
                Great job! The next module is now unlocked.
            @endif
        @else
            You can retake this quiz. Keep studying!
        @endif
    </p>

    <div class="result-score-card" style="{{ $isViolation ? 'background: rgba(254, 242, 242, 0.1) !important; border-color: rgba(239, 68, 68, 0.2) !important;' : '' }}">
        <div class="result-score-label" style="{{ $isViolation ? 'color: #ef4444 !important;' : '' }}">
            {{ $isViolation ? 'Graded Score (Submitted State)' : 'Graded Score' }}
        </div>
        <div class="result-score-points" style="color: {{ $isViolation ? '#ef4444' : ($passed ? '#34d399' : '#ef4444') }};">
            {{ $score }}<span>/{{ $total }}</span>
        </div>
        <div class="result-score-threshold">
            Passing threshold: {{ $quiz->passing_score }}/{{ $total }} pts
        </div>
    </div>

    <div style="display:flex;gap:12px;justify-content:center;">
        @if($passed && $quiz->type === 'final_exam')
            <a href="{{ route('student.certificate') }}" class="btn" style="padding:12px 24px; background:linear-gradient(135deg, #fbbf24 0%, #d97706 100%); color:#fff; border:none; font-weight:700; border-radius:var(--r); text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5M12 15v6m-4.5 0h9" />
                </svg>
                View Certificate
            </a>
            <a href="{{ route('student.dashboard') }}" class="btn btn-ghost" style="padding:12px 24px; background:#1e293b; border-color:#334155; color:#fff; text-decoration:none;">
                Go to Dashboard
            </a>
        @else
            <a href="{{ route('student.dashboard') }}" class="btn btn-primary" style="padding:12px 24px; color:#fff; text-decoration:none;">
                {{ $passed ? 'Continue →' : '← Back to Dashboard' }}
            </a>
            @if(!$passed)
            <a href="{{ route('student.quiz.show', $quiz->id) }}" class="btn btn-ghost" style="padding:12px 24px; background:#1e293b; border-color:#334155; color:#fff; text-decoration:none;">Retake Quiz</a>
            @endif
        @endif
    </div>
</div>

@endsection
