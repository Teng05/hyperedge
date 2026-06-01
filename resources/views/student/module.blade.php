@extends('layouts.student')
@section('title', 'Module Coursework')
@section('content')

<style>
  /* Body and main page overrides for coursework view */
  body.coursework-page {
    background: #090d16 !important;
    color: #e2e8f0 !important;
    overflow: hidden;
  }
  
  .coursework-page .main {
    background: #090d16 !important;
    height: 100vh;
    display: flex;
    flex-direction: column;
  }
  
  .coursework-page .page {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 0;
    padding: 24px 32px 32px;
  }
  
  .coursework-page .topbar {
    background: #0f172a !important;
    border-bottom: 1px solid #1e293b !important;
    color: #e2e8f0 !important;
  }
  
  .coursework-page .topbar-crumb, .coursework-page .topbar-crumb span {
    color: #94a3b8 !important;
  }
  
  .coursework-page .tbar-date {
    background: #1e293b !important;
    border-color: #334155 !important;
    color: #94a3b8 !important;
  }

  .dash-wrap {
    max-width: 1400px;
    margin: 0 auto;
    width: 100%;
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 0;
  }

  .module-header {
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #1e293b;
    padding-bottom: 16px;
    opacity: 0;
    transform: translateY(12px);
    flex-shrink: 0;
  }

  .module-title {
    font-family: var(--font-display);
    font-size: 22px;
    font-weight: 800;
    letter-spacing: -0.04em;
    color: #fff;
  }
  .module-title span { color: #818cf8; }
  .module-desc { font-size: 13px; color: #94a3b8; margin-top: 3px; }

  /* Coursework Layout Grid */
  .coursework-grid {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 28px;
    flex: 1;
    min-height: 0;
  }

  @media(max-width: 992px) {
    .coursework-grid {
      grid-template-columns: 1fr;
      height: auto;
      overflow: visible;
    }
  }

  /* Left Panel: Lessons List & Quiz */
  .panel-left {
    display: flex;
    flex-direction: column;
    gap: 16px;
    height: 100%;
    overflow-y: auto;
    padding-right: 4px;
  }
  
  .panel-left::-webkit-scrollbar {
    width: 6px;
  }
  .panel-left::-webkit-scrollbar-track {
    background: transparent;
  }
  .panel-left::-webkit-scrollbar-thumb {
    background: #1e293b;
    border-radius: 3px;
  }

  .lessons-list-card {
    background: #0f172a;
    border: 1px solid #1e293b;
    border-radius: var(--r-lg);
    padding: 20px;
    opacity: 0;
    transform: translateY(12px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  }

  .panel-section-title {
    font-family: var(--font-display);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.5px;
    color: #94a3b8;
    margin-bottom: 14px;
    padding-bottom: 8px;
    border-bottom: 1.5px solid #1e293b;
    text-transform: uppercase;
  }

  .lesson-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: var(--r);
    border: 1px solid transparent;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-bottom: 8px;
    background: rgba(30, 41, 59, 0.25);
  }
  .lesson-item:last-child { margin-bottom: 0; }
  
  .lesson-item:hover {
    background: rgba(30, 41, 59, 0.5);
    border-color: #334155;
    box-shadow: 0 0 10px rgba(99,102,241,0.1);
  }
  .lesson-item.active {
    background: rgba(99, 102, 241, 0.15);
    border-color: rgba(99, 102, 241, 0.4);
    box-shadow: 0 0 15px rgba(99, 102, 241, 0.15);
  }
  
  .lesson-item.completed {
    border-color: rgba(16, 185, 129, 0.2);
  }

  .lesson-status-icon {
    width: 28px; height: 28px;
    border-radius: 6px;
    background: #1e293b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: bold;
    flex-shrink: 0;
    transition: all 0.2s;
    color: #94a3b8;
  }
  
  .lesson-item.active .lesson-status-icon {
    background: #6366f1;
    color: #fff;
    box-shadow: 0 0 8px rgba(99, 102, 241, 0.4);
  }
  
  .lesson-item.completed .lesson-status-icon {
    background: rgba(16, 185, 129, 0.15);
    color: #34d399;
    border: 1px solid rgba(16, 185, 129, 0.3);
    box-shadow: 0 0 8px rgba(16, 185, 129, 0.2);
  }

  .lesson-info {
    flex: 1;
    overflow: hidden;
  }
  .lesson-title-text {
    font-size: 13px;
    font-weight: 600;
    color: #e2e8f0;
    white-space: nowrap;
    overflow: hidden;
    text-transform: capitalize;
    text-overflow: ellipsis;
  }
  
  .lesson-item.active .lesson-title-text {
    color: #fff;
  }
  
  .lesson-type-badge {
    font-size: 9px;
    font-weight: 700;
    color: #64748b;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-top: 1px;
  }

  /* Assessment Card */
  .quiz-card {
    background: #0f172a;
    border: 1px solid #1e293b;
    border-radius: var(--r-lg);
    padding: 24px;
    text-align: center;
    opacity: 0;
    transform: translateY(12px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  }

  /* Right Panel: Content View */
  .panel-right {
    background: #0f172a;
    border: 1px solid #1e293b;
    border-radius: var(--r-lg);
    padding: 32px;
    opacity: 0;
    transform: translateY(12px);
    height: 100%;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
  }
  
  .panel-right::-webkit-scrollbar {
    width: 8px;
  }
  .panel-right::-webkit-scrollbar-track {
    background: #090d16;
  }
  .panel-right::-webkit-scrollbar-thumb {
    background: #1e293b;
    border-radius: 4px;
  }

  /* Subtopic Content Styling */
  .subtopic-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 16px;
    border-bottom: 1.5px solid #1e293b;
    margin-bottom: 20px;
    flex-shrink: 0;
  }

  .subtopic-title {
    font-family: var(--font-display);
    font-size: 20px;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.03em;
  }

  /* PDF Viewer Container */
  .pdf-viewer-container {
    width: 100%;
    margin-bottom: 24px;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #1e293b;
    background: #020617;
  }

  /* Media Players & Captured screen */
  .media-container {
    background: #090d16;
    border: 1px solid #1e293b;
    border-radius: var(--r-lg);
    padding: 8px;
    margin-bottom: 24px;
    overflow: hidden;
  }

  .aspect-ratio-video {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
    height: 0;
    overflow: hidden;
    border-radius: var(--r);
  }

  .aspect-ratio-video iframe,
  .aspect-ratio-video video {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    border: none;
  }

  /* Premium Video Walkthrough Container styling matching PDF dimensions exactly */
  #videoWorkspaceContainer {
    height: 750px;
    background: #090d16 !important;
    border: 1px solid #1e293b !important;
    border-radius: 12px !important;
    overflow: hidden !important;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 0 !important;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.3) !important;
  }

  #videoWorkspaceContainer .video-aspect-wrapper {
    width: 100%;
    position: relative;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    height: 0;
    overflow: hidden;
    background: #090d16;
  }

  #videoWorkspaceContainer .video-aspect-wrapper iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
  }

  .explanation-card {
    background: #090d16;
    border-left: 3px solid #6366f1;
    padding: 16px 20px;
    border-radius: 0 var(--r) var(--r) 0;
    margin-bottom: 24px;
    border-top: 1px solid #1e293b;
    border-right: 1px solid #1e293b;
    border-bottom: 1px solid #1e293b;
  }
  .explanation-text {
    font-size: 13px;
    line-height: 1.6;
    color: #94a3b8;
  }

  .sandbox-cta-card {
    background: rgba(217, 119, 6, 0.05);
    border: 1px solid rgba(217, 119, 6, 0.25);
    border-radius: var(--r-lg);
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
  }

  .sandbox-cta-title {
    font-family: var(--font-display);
    font-size: 14px;
    font-weight: 700;
    color: #f59e0b;
  }

  .sandbox-cta-desc {
    font-size: 12px;
    color: #d97706;
    margin-top: 2px;
  }

  .btn-sandbox {
    background: #d97706;
    border: 1px solid #d97706;
    color: #fff;
    padding: 10px 18px;
    border-radius: var(--r);
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.18s;
  }
  .btn-sandbox:hover {
    background: #b45309;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(217,119,6,0.2);
  }

  /* Completion Tracker and Scroll Message */
  .completion-footer-tracker {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: #090d16;
    border: 1px dashed #1e293b;
    border-radius: 12px;
    margin-top: auto;
    text-align: center;
  }

  .completion-footer-text {
    font-size: 13px;
    color: #94a3b8;
    margin-bottom: 8px;
  }

  .completion-footer-badge {
    padding: 8px 24px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.5px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .completion-footer-badge.locked {
    background: #1e293b;
    color: #64748b;
    border: 1px solid #334155;
  }

  .completion-footer-badge.unlocked {
    background: rgba(16, 185, 129, 0.1);
    color: #34d399;
    border: 1px solid rgba(16, 185, 129, 0.4);
    box-shadow: 0 0 15px rgba(16, 185, 129, 0.15);
  }

  /* Workspace Layout Grid styles */
  .workspace-layout-wrapper {
    display: grid;
    gap: 24px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    min-height: 0;
  }

  .workspace-layout-wrapper.mode-split,
  .workspace-layout-wrapper.mode-pdf,
  .workspace-layout-wrapper.mode-video {
    grid-template-columns: 1fr 1.2fr;
  }

  .workspace-layout-wrapper.mode-sandbox {
    grid-template-columns: 1fr;
  }

  /* Premium active state for video tab */
  .tab-btn#tabBtnVideo.active {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.25) 0%, rgba(139, 92, 246, 0.25) 100%) !important;
    border-color: rgba(139, 92, 246, 0.4) !important;
    color: #a78bfa !important;
    box-shadow: 0 0 15px rgba(139, 92, 246, 0.25) !important;
  }

  .workspace-pdf-column,
  .workspace-sandbox-column {
    display: flex;
    flex-direction: column;
    gap: 20px;
    min-width: 0;
  }

  /* Sandbox internal layout */
  .sandbox-internal-grid {
    display: grid;
    gap: 20px;
    min-height: 0;
  }

  /* Vertically stacked when in Split View */
  .workspace-layout-wrapper.mode-split .sandbox-internal-grid {
    grid-template-columns: 1fr;
  }

  /* Horizontally split when in Sandbox Only View */
  .workspace-layout-wrapper.mode-sandbox .sandbox-internal-grid {
    grid-template-columns: 1fr 1fr;
  }

  @media(max-width: 1200px) {
    .workspace-layout-wrapper.mode-split {
      grid-template-columns: 1fr;
    }
    .workspace-layout-wrapper.mode-split .sandbox-internal-grid {
      grid-template-columns: 1fr;
    }
  }

  /* Pill Tabs Bar */
  .workspace-tabs-bar {
    display: flex;
    gap: 12px;
    border-bottom: 1px solid #1e293b;
    padding-bottom: 12px;
    margin-bottom: 24px;
  }
  
  .tab-btn {
    background: transparent;
    border: 1px solid transparent;
    color: #94a3b8;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .tab-btn:hover {
    background: rgba(30, 41, 59, 0.4);
    color: #fff;
  }
  .tab-btn.active {
    background: rgba(99, 102, 241, 0.15);
    border-color: rgba(99, 102, 241, 0.3);
    color: #818cf8;
    box-shadow: 0 0 10px rgba(99, 102, 241, 0.1);
  }

  .pulse-dot {
    width: 6px;
    height: 6px;
    background-color: #34d399;
    border-radius: 50%;
    display: inline-block;
    box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.7);
    animation: pulse 1.6s infinite;
  }

  @keyframes pulse {
    0% {
      transform: scale(0.95);
      box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.7);
    }
    70% {
      transform: scale(1);
      box-shadow: 0 0 0 6px rgba(52, 211, 153, 0);
    }
    100% {
      transform: scale(0.95);
      box-shadow: 0 0 0 0 rgba(52, 211, 153, 0);
    }
  }

  .sandbox-panel-side {
    display: flex;
    flex-direction: column;
    min-height: 0;
  }

  .sandbox-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
    color: #64748b;
    text-transform: uppercase;
    margin-bottom: 8px;
    border-bottom: 1px solid #1e293b;
    padding-bottom: 6px;
    flex-shrink: 0;
  }

  .editor-field-wrapper {
    background: #020617;
    border: 1px solid #1e293b;
    border-radius: 8px;
    padding: 12px;
    display: flex;
    gap: 12px;
    flex: 1;
    min-height: 320px;
    max-height: 480px;
    overflow: hidden;
  }

  .editor-line-numbers {
    font-family: var(--font-mono);
    font-size: 12.5px;
    color: #475569;
    text-align: right;
    user-select: none;
    line-height: 1.6;
  }

  .editor-textarea-field {
    flex: 1;
    background: transparent;
    border: none;
    color: #38bdf8;
    font-family: var(--font-mono);
    font-size: 12.5px;
    line-height: 1.6;
    resize: none;
    outline: none;
    overflow-y: auto;
  }

  .validation-checklist-card {
    background: #090d16;
    border: 1px solid #1e293b;
    border-radius: 8px;
    padding: 16px;
    margin-top: 16px;
    flex-shrink: 0;
  }

  .challenge-item-row {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12px;
    color: #94a3b8;
    margin-bottom: 8px;
    padding: 8px;
    border-radius: 4px;
    background: rgba(30, 41, 59, 0.2);
    border: 1px solid transparent;
    transition: all 0.2s;
  }

  .challenge-item-row.passed {
    background: rgba(16, 185, 129, 0.08);
    border-color: rgba(16, 185, 129, 0.2);
    color: #34d399;
  }

  .challenge-check-box {
    width: 16px; height: 16px;
    border-radius: 4px;
    border: 1px solid #334155;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: bold;
    color: transparent;
    flex-shrink: 0;
  }

  .challenge-item-row.passed .challenge-check-box {
    border-color: #34d399;
    color: #34d399;
    background: rgba(16, 185, 129, 0.15);
  }

  .preview-frame-container {
    background: #fff;
    border: 1px solid #1e293b;
    border-radius: 8px;
    flex: 1;
    min-height: 320px;
    max-height: 480px;
    overflow: hidden;
  }

  .preview-frame-element {
    width: 100%; height: 100%;
    border: none;
    background: #fff;
  }

  .compiler-terminal-box {
    background: #020617;
    border: 1px solid #1e293b;
    border-radius: 8px;
    padding: 12px;
    font-family: var(--font-mono);
    font-size: 11px;
    margin-top: 16px;
    flex-shrink: 0;
  }

  .compiler-log-lines {
    color: #64748b;
    max-height: 80px;
    overflow-y: auto;
    line-height: 1.5;
  @keyframes ping {
    75%, 100% {
      transform: scale(2.5);
      opacity: 0;
    }
  }
</style>

<div class="dash-wrap">

  {{-- Header --}}
  <div class="module-header" id="mh">
    <div>
      <div class="module-title">Module {{ $module->order }}: <span>{{ $module->title }}</span></div>
      <div class="module-desc">{{ $module->description }}</div>
    </div>
    <a href="{{ route('student.dashboard') }}" class="btn btn-ghost" style="background:#1e293b; border-color:#334155; color:#fff; display: inline-flex; align-items: center; gap: 6px;">
      <svg style="width: 14px; height: 14px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
      </svg>
      Exit Coursework
    </a>
  </div>

  {{-- Main Layout --}}
  <div class="coursework-grid">
    
    {{-- Left Sidebar --}}
    <div class="panel-left">
      
      {{-- Lessons list --}}
      <div class="lessons-list-card" id="llc">
        <div class="panel-section-title">Timeline Subtopics</div>
        <div id="lessonsListContainer">
          {{-- Injected dynamically by JS --}}
        </div>
      </div>

      {{-- Quiz Card --}}
      <div class="quiz-card" id="qc">
        @if($module->quiz)
          <div style="margin-bottom:12px; display: flex; justify-content: center; width: 100%;">
            <div style="background: rgba(139, 92, 246, 0.1); padding: 12px; border-radius: 12px; border: 1.5px solid rgba(139, 92, 246, 0.15); display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.03);">
              <svg style="width: 32px; height: 32px; color: #8b5cf6; filter: drop-shadow(0 0 6px rgba(139, 92, 246, 0.4));" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>
          </div>
          <div class="panel-section-title" style="border-bottom:none; margin-bottom:4px; padding-bottom:0; text-align:center;">Module Assessment</div>
          <div style="font-size:12px; color:#64748b; margin-bottom:16px;">
            {{ $module->quiz->questions->count() }} questions &middot; Pass {{ $module->quiz->passing_score }}/{{ $module->quiz->total_points }}
          </div>
          @if($progress->is_completed)
            <div style="color:#34d399; font-size:12.5px; font-weight:700;">✓ Module Pathway Passed!</div>
          @else
            <a href="{{ route('student.quiz.show', $module->quiz->id) }}" class="btn btn-primary" style="width:100%; justify-content:center; padding: 10px;">
              Take Assessment →
            </a>
          @endif
        @else
          <div style="font-size:12px; color:#64748b; font-style:italic;">No quiz uploaded yet.</div>
        @endif
      </div>

    </div>

    {{-- Right Detail View --}}
    <div class="panel-right" id="pr">
      
      <div class="subtopic-header">
        <div class="subtopic-title" id="activeTitle">Subtopic Name</div>
        <div id="subtopicHeaderStatus">
          <!-- Dynamically populated badge -->
        </div>
      </div>

      {{-- Details Area --}}
      <div id="subtopicContent">
        
        {{-- Workspace Mode Control Bar --}}
        <div class="workspace-tabs-bar">
          <div style="display: flex; gap: 8px; align-items: center; width: 100%; justify-content: space-between; flex-wrap: wrap;">
            <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
              <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b; letter-spacing: 0.5px; margin-right: 8px;">Workspace View:</span>
              <button class="tab-btn" id="tabBtnPdfOnly">
                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span>Study Guide (PDF)</span>
              </button>
              <button class="tab-btn active" id="tabBtnSplit">
                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
                </svg>
                <span>Split Screen</span>
              </button>
              <button class="tab-btn" id="tabBtnSandboxOnly">
                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                </svg>
                <span>Code Sandbox</span>
              </button>
              <button class="tab-btn" id="tabBtnVideo" style="display: none;">
                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <span>🎥 Video Walkthrough</span>
              </button>
            </div>
            
            {{-- Quick action indicator / status --}}
            <div id="sandboxStatusIndicator" style="font-size: 11px; font-weight: 600; color: #818cf8; display: flex; align-items: center; gap: 6px;">
              <span class="pulse-dot"></span> Sandbox Ready
            </div>
          </div>
        </div>

        {{-- Dynamic Layout Grid Wrapper --}}
        <div class="workspace-layout-wrapper mode-split" id="workspaceLayoutWrapper">
          
          {{-- Left Column: PDF Viewer and Details --}}
          <div class="workspace-pdf-column" id="workspacePdfColumn">
            {{-- Embedded PDF Viewer (Always rendered) --}}
            <div class="pdf-viewer-container" id="pdfViewerContainer" style="margin-bottom: 0;">
              <iframe id="pdfIframe" src="" width="100%" height="750px" style="border: none; border-radius: 12px; box-shadow: 0 4px 25px rgba(0,0,0,0.2);"></iframe>
            </div>

            {{-- Dedicated Video Walkthrough Workspace Container --}}
            <div id="videoWorkspaceContainer" style="display:none; margin-bottom: 0;">
              <div class="video-aspect-wrapper">
                <iframe id="videoWorkspaceIframe" src="" allowfullscreen></iframe>
              </div>
            </div>

            <div class="explanation-card" id="explanationCard" style="display:none; margin-bottom: 0;">
              <div class="explanation-text" id="explanationText">Visual explanation.</div>
            </div>

            {{-- Completion Tracker Block (Stays at the bottom of the PDF Column) --}}
            <div class="completion-footer-tracker" id="completionFooterTracker" style="margin-top: 10px;">
              <div class="completion-footer-text" id="completionFooterText">
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; border-radius: 6px; background: rgba(99, 102, 241, 0.1); color: #6366f1; margin-right: 8px; flex-shrink: 0;">
                  <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                  </svg>
                </span>
                <span>Read the material above to complete this subtopic.</span>
              </div>
              <div class="completion-footer-badge locked" id="completionFooterBadge">
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" style="width:16px; height:16px; display:none; margin-right:8px;" id="completionSpinner"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span id="completionBadgeText">Scroll to bottom to mark done</span>
              </div>
            </div>
            <div id="pdfScrollSentinel" style="height: 1px; width: 100%; margin-top: -1px; pointer-events: none;"></div>
          </div>

          {{-- Right Column: Code Sandbox Panel --}}
          <div class="workspace-sandbox-column" id="workspaceSandboxColumn">
            <div class="sandbox-internal-grid">
              
              <!-- Sandbox Left/Top: Code Editor & Challenges -->
              <div class="sandbox-panel-side">
                <div class="sandbox-panel-header">
                  <span style="display: flex; align-items: center; gap: 6px; color: #e2e8f0;">
                    <svg style="width: 14px; height: 14px; color: #818cf8; filter: drop-shadow(0 0 4px rgba(129, 140, 248, 0.4));" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                    </svg>
                    <span>Code Editor</span>
                  </span>
                  <button class="btn btn-ghost" id="btnResetSandboxCode" style="padding: 2px 8px; font-size:11px; background:#1e293b; color:#fff; border-radius: 4px; border: 1px solid #334155; display: inline-flex; align-items: center; gap: 4px;">
                    <svg style="width: 11px; height: 11px; color: #4ade80;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Reset Template
                  </button>
                </div>
                <div class="editor-field-wrapper">
                  <div class="editor-line-numbers" id="sandboxEditorLineNumbers"></div>
                  <textarea class="editor-textarea-field" id="sandboxEditorTextArea" spellcheck="false"></textarea>
                </div>
                
                <div class="validation-checklist-card">
                  <div class="sandbox-panel-header" style="border: none; padding: 0; margin-bottom: 8px; color: #e2e8f0; display: flex; align-items: center; gap: 6px;">
                    <svg style="width: 14px; height: 14px; color: #ef4444; filter: drop-shadow(0 0 4px rgba(239, 68, 68, 0.4));" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                      <circle cx="12" cy="12" r="10" />
                      <circle cx="12" cy="12" r="6" />
                      <circle cx="12" cy="12" r="2" />
                    </svg>
                    <span>Validation Checklist</span>
                  </div>
                  <div id="sandboxChallengeListContainer">
                    <!-- Checklist items -->
                  </div>
                  <div style="margin-top: 14px;">
                    <button class="btn btn-primary" id="btnSubmitSandboxChallenge" disabled style="width:100%; justify-content:center; padding:10px;">
                      Challenges Pending
                    </button>
                  </div>
                </div>
              </div>

              <!-- Sandbox Right/Bottom: Live Output Preview & Logs -->
              <div class="sandbox-panel-side">
                <div class="sandbox-panel-header" style="color: #e2e8f0;">
                  <span style="display: flex; align-items: center; gap: 6px;">
                    <svg style="width: 14px; height: 14px; color: #34d399; filter: drop-shadow(0 0 4px rgba(52, 211, 153, 0.4));" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>Live Output Preview</span>
                    <span style="position: relative; display: inline-flex; width: 6px; height: 6px; margin-left: 2px;">
                      <span style="position: absolute; display: inline-flex; width: 100%; height: 100%; border-radius: 50%; background-color: #10b981; opacity: 0.75; animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;"></span>
                      <span style="position: relative; display: inline-flex; border-radius: 50%; width: 6px; height: 6px; background-color: #10b981;"></span>
                    </span>
                  </span>
                </div>
                <div class="preview-frame-container">
                  <iframe id="sandboxPreviewFrame" src="about:blank" sandbox="allow-scripts allow-same-origin" class="preview-frame-element"></iframe>
                </div>
                
                <div class="compiler-terminal-box">
                  <div class="sandbox-panel-header" style="border: none; padding: 0; margin-bottom: 6px; color: #e2e8f0; display: flex; align-items: center; gap: 6px;">
                    <svg style="width: 14px; height: 14px; color: #3b82f6; filter: drop-shadow(0 0 4px rgba(59, 130, 246, 0.4));" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Compilation Logs</span>
                  </div>
                  <div class="compiler-log-lines" id="sandboxTerminalLogContainer">
                    Compiler initialized. Ready.
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>

      </div>

      </div>

    </div>

  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Add coursework class to body for custom styles
  document.body.classList.add('coursework-page');

  // Entrance GSAP
  const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
  tl.to('#mh', { opacity: 1, y: 0, duration: 0.5 })
    .to('#llc', { opacity: 1, y: 0, duration: 0.4 }, '-=0.2')
    .to('#qc', { opacity: 1, y: 0, duration: 0.4 }, '-=0.25')
    .to('#pr', { opacity: 1, y: 0, duration: 0.5 }, '-=0.2');

  // Lessons Data
  const lessons = @json($module->lessons);
  let completedLessons = @json($completedLessons);
  let activeLessonIndex = 0;
  let isCompleting = false;
  const assetBase = "{{ asset('') }}";

  // Elements Hook
  const listContainer = document.getElementById('lessonsListContainer');
  const activeTitle = document.getElementById('activeTitle');
  const pdfViewerContainer = document.getElementById('pdfViewerContainer');
  const pdfIframe = document.getElementById('pdfIframe');
  const videoWorkspaceContainer = document.getElementById('videoWorkspaceContainer');
  const videoWorkspaceIframe = document.getElementById('videoWorkspaceIframe');
  const explanationCard = document.getElementById('explanationCard');
  const explanationText = document.getElementById('explanationText');
  const rightPanel = document.getElementById('pr');

  // Layout tabs selectors
  const tabBtnPdfOnly = document.getElementById('tabBtnPdfOnly');
  const tabBtnSplit = document.getElementById('tabBtnSplit');
  const tabBtnSandboxOnly = document.getElementById('tabBtnSandboxOnly');
  const tabBtnVideo = document.getElementById('tabBtnVideo');
  const workspaceLayoutWrapper = document.getElementById('workspaceLayoutWrapper');

  // Layout switching listeners
  tabBtnPdfOnly.addEventListener('click', () => {
    setActiveLayoutMode('pdf');
  });

  tabBtnSplit.addEventListener('click', () => {
    setActiveLayoutMode('split');
  });

  tabBtnSandboxOnly.addEventListener('click', () => {
    setActiveLayoutMode('sandbox');
  });

  tabBtnVideo.addEventListener('click', () => {
    setActiveLayoutMode('video');
  });

  let lastActiveResource = 'pdf'; // Track last active left-side preview ('pdf' or 'video')

  function setActiveLayoutMode(mode) {
    // Remove active classes
    tabBtnPdfOnly.classList.remove('active');
    tabBtnSplit.classList.remove('active');
    tabBtnSandboxOnly.classList.remove('active');
    tabBtnVideo.classList.remove('active');

    // Remove mode classes
    workspaceLayoutWrapper.classList.remove('mode-pdf', 'mode-split', 'mode-sandbox', 'mode-video');

    // Enforce display states to avoid vertical stacking of multiple media assets
    const pdfCol = workspaceLayoutWrapper.querySelector('.workspace-pdf-column');
    const sandboxCol = workspaceLayoutWrapper.querySelector('.workspace-sandbox-column');

    if (mode === 'pdf') {
      tabBtnPdfOnly.classList.add('active');
      workspaceLayoutWrapper.classList.add('mode-pdf');
      lastActiveResource = 'pdf';

      // Show PDF fully, HIDE Video walkthrough completely, and show Sandbox Editor on the right
      pdfCol.style.display = 'flex';
      sandboxCol.style.display = 'flex';
      pdfViewerContainer.style.display = 'block';
      videoWorkspaceContainer.style.display = 'none';

      compileSandboxCode();
    } else if (mode === 'video') {
      tabBtnVideo.classList.add('active');
      workspaceLayoutWrapper.classList.add('mode-video');
      lastActiveResource = 'video';

      // Show Video walkthrough fully (as a flex container), HIDE PDF completely, and show Sandbox Editor on the right
      pdfCol.style.display = 'flex';
      sandboxCol.style.display = 'flex';
      pdfViewerContainer.style.display = 'none';
      videoWorkspaceContainer.style.display = 'flex';

      compileSandboxCode();
    } else if (mode === 'sandbox') {
      tabBtnSandboxOnly.classList.add('active');
      workspaceLayoutWrapper.classList.add('mode-sandbox');

      // Expand Code Editor to 100% full screen by hiding the Left-side preview column completely
      pdfCol.style.display = 'none';
      sandboxCol.style.display = 'flex';
      pdfViewerContainer.style.display = 'none';
      videoWorkspaceContainer.style.display = 'none';

      compileSandboxCode();
    } else if (mode === 'split') {
      tabBtnSplit.classList.add('active');
      workspaceLayoutWrapper.classList.add('mode-split');

      // Restore last active resource (PDF or Video) on the left, and keep Sandbox Editor on the right
      pdfCol.style.display = 'flex';
      sandboxCol.style.display = 'flex';
      
      if (lastActiveResource === 'video') {
        pdfViewerContainer.style.display = 'none';
        videoWorkspaceContainer.style.display = 'flex';
      } else {
        pdfViewerContainer.style.display = 'block';
        videoWorkspaceContainer.style.display = 'none';
      }

      compileSandboxCode();
    }
  }

  // Render Sidebar Subtopics
  function renderSidebar() {
    listContainer.innerHTML = '';
    lessons.forEach((l, idx) => {
      const isDone = completedLessons.includes(l.id);
      const isActive = idx === activeLessonIndex;
      
      const item = document.createElement('div');
      item.className = `lesson-item ${isActive ? 'active' : ''} ${isDone ? 'completed' : ''}`;
      
      let iconSvg = '';
      if (isDone) {
        iconSvg = `
          <svg style="width: 14px; height: 14px; color: #34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
          </svg>
        `;
      } else if (l.type === 'video') {
        iconSvg = `
          <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        `;
      } else {
        iconSvg = `
          <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        `;
      }

      item.innerHTML = `
        <div class="lesson-status-icon">${iconSvg}</div>
        <div class="lesson-info">
          <div class="lesson-title-text">${l.title}</div>
          <div class="lesson-type-badge">${l.type} subtopic</div>
        </div>
      `;
      
      item.addEventListener('click', () => {
        if (idx !== activeLessonIndex) {
          activeLessonIndex = idx;
          isCompleting = false;
          renderSidebar();
          renderActiveLesson();
        }
      });

      listContainer.appendChild(item);
    });
  }

  // Render details for selected active subtopic
  function renderActiveLesson() {
    if (lessons.length === 0) return;
    const l = lessons[activeLessonIndex];
    
    // Title
    activeTitle.textContent = l.title;

    // Check complete status
    const isDone = completedLessons.includes(l.id);
    const headerStatus = document.getElementById('subtopicHeaderStatus');
    const badgeText = document.getElementById('completionBadgeText');
    const footerBadge = document.getElementById('completionFooterBadge');
    const footerText = document.getElementById('completionFooterText');
    const spinner = document.getElementById('completionSpinner');

    if (spinner) spinner.style.display = 'none';

    if (isDone) {
      headerStatus.innerHTML = '<span class="badge badge-done" style="background: rgba(16, 185, 129, 0.15); border-color: rgba(16, 185, 129, 0.3); color: #34d399;">✓ Completed</span>';
      footerBadge.className = 'completion-footer-badge unlocked';
      badgeText.innerHTML = '✓ Completed';
      footerText.innerHTML = `
        <span style="display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; border-radius: 6px; background: rgba(16, 185, 129, 0.15); color: #10b981; margin-right: 8px; vertical-align: middle;">
          <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
          </svg>
        </span>
        <span style="vertical-align: middle;">You have completed this subtopic lesson.</span>
      `;
    } else {
      headerStatus.innerHTML = '<span class="badge badge-locked" style="background: #1e293b; border-color: #334155; color: #64748b;">In Progress</span>';
      footerBadge.className = 'completion-footer-badge locked';
      badgeText.textContent = 'Scroll to bottom to mark done';
      footerText.innerHTML = `
        <span style="display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; border-radius: 6px; background: rgba(99, 102, 241, 0.1); color: #6366f1; margin-right: 8px; vertical-align: middle;">
          <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
          </svg>
        </span>
        <span style="vertical-align: middle;">Read the material above to complete this subtopic.</span>
      `;
    }
    // PDF Viewer Setup (Strictly render PDF)
    pdfViewerContainer.style.display = 'block';
    pdfIframe.src = assetBase + (l.pdf_path || 'default.pdf') + '#toolbar=0';

    // Video Setup
    if (l.video_url) {
      tabBtnVideo.style.display = 'flex';
      let url = l.video_url;
      if (url.includes('youtube.com/watch?v=')) {
        url = url.replace('watch?v=', 'embed/');
      } else if (url.includes('youtu.be/')) {
        url = url.replace('youtu.be/', 'youtube.com/embed/');
      }
      videoWorkspaceIframe.src = url;
    } else {
      tabBtnVideo.style.display = 'none';
      videoWorkspaceIframe.src = '';

      // Fallback if the active lesson doesn't have a video walkthrough
      if (workspaceLayoutWrapper.classList.contains('mode-video')) {
        if (l.code_snippet && l.code_snippet.trim() !== '') {
          setActiveLayoutMode('split');
        } else {
          setActiveLayoutMode('pdf');
        }
      }
    }

    // Explanation Setup
    if (l.video_explanation && l.video_explanation.trim() !== '') {
      explanationCard.style.display = 'block';
      explanationText.innerHTML = l.video_explanation.replace(/\n/g, '<br>');
    } else {
      explanationCard.style.display = 'none';
    }

    // Sandbox Setup
    if (l.code_snippet && l.code_snippet.trim() !== '') {
      sandboxEditorTextArea.value = l.code_snippet;
      buildChallenges(l);
      updateLineNumbers();

      // Show challenge badge and enable submit button
      document.querySelector('.validation-checklist-card').style.display = 'block';
      document.getElementById('sandboxStatusIndicator').innerHTML = '<span class="pulse-dot" style="background-color: #f59e0b;"></span> Challenge Active';

      // Default layout mode to Split Screen
      setActiveLayoutMode('split');

      // Keep sandbox views visible
      tabBtnSandboxOnly.style.display = 'flex';
      tabBtnSplit.style.display = 'flex';
    } else {
      // Default playground template
      sandboxEditorTextArea.value = `<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      background: #11131e;
      color: #e2e8f0;
      font-family: system-ui, sans-serif;
      padding: 30px;
      text-align: center;
    }
    h1 { color: #818cf8; font-size: 2.2rem; }
    p { color: #94a3b8; line-height: 1.6; }
  </style>
</head>
<body>
  <h1>Interactive Playground</h1>
  <p>Practice writing your HTML & CSS here. The preview updates live!</p>
</body>
</html>`;
      activeChallenges = [];
      document.getElementById('sandboxChallengeListContainer').innerHTML = `
        <div style="font-size: 12px; color: #64748b; font-style: italic; padding: 10px; text-align: center;">
          No validation checklist for this topic. Feel free to use the sandbox for free-play practice!
        </div>
      `;

      const submitBtn = document.getElementById('btnSubmitSandboxChallenge');
      submitBtn.disabled = true;
      submitBtn.textContent = 'Free Play Practice';
      submitBtn.style.background = '#1e293b';
      submitBtn.style.borderColor = '#334155';
      submitBtn.style.color = '#64748b';

      document.getElementById('sandboxStatusIndicator').innerHTML = '<span class="pulse-dot"></span> Free Play';

      // Default layout mode to PDF Only
      setActiveLayoutMode('pdf');

      // Keep sandbox views visible so they can toggle if they want to play
      tabBtnSandboxOnly.style.display = 'flex';
      tabBtnSplit.style.display = 'flex';
    }
    
    // Reset scroll positions to top
    rightPanel.scrollTop = 0;

    // Force initial compile/render of the sandbox code snippet or default playground template
    compileSandboxCode();

    // Entrance animation transitions
    gsap.fromTo('#subtopicContent', { opacity: 0, y: 12 }, { opacity: 1, y: 0, duration: 0.35 });
  }

  // Scroll to complete viewport observer
  const sentinel = document.getElementById('pdfScrollSentinel');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      // Only verify completion if PDF viewer is visible (PDF Only or Split mode)
      if (workspaceLayoutWrapper.classList.contains('mode-sandbox')) return;

      if (lessons.length === 0) return;
      const l = lessons[activeLessonIndex];
      if (!l) return;

      if (completedLessons.includes(l.id) || isCompleting) return;

      if (entry.isIntersecting) {
        isCompleting = true;
        triggerAutoCompletion(l.id);
      }
    });
  }, {
    root: rightPanel,
    threshold: 0.1
  });
  observer.observe(sentinel);

  function triggerAutoCompletion(lessonId) {
    const spinner = document.getElementById('completionSpinner');
    const badgeText = document.getElementById('completionBadgeText');
    const footerBadge = document.getElementById('completionFooterBadge');
    
    if (spinner) spinner.style.display = 'inline-block';
    if (badgeText) badgeText.textContent = 'Registering progress...';

    markLessonComplete(lessonId).then(() => {
      // Animate completion state
      gsap.to(footerBadge, {
        backgroundColor: 'rgba(16, 185, 129, 0.1)',
        borderColor: 'rgba(16, 185, 129, 0.4)',
        color: '#34d399',
        scale: 1.05,
        duration: 0.3,
        yoyo: true,
        repeat: 1,
        onComplete: () => {
          gsap.set(footerBadge, { scale: 1 });
          if (spinner) spinner.style.display = 'none';
          footerBadge.className = 'completion-footer-badge unlocked';
          if (badgeText) badgeText.innerHTML = '✓ Completed';
        }
      });
    }).catch(err => {
      isCompleting = false;
      if (spinner) spinner.style.display = 'none';
      if (badgeText) badgeText.textContent = 'Connection Error - Scroll to Retry';
      console.error(err);
    });
  }

  function markLessonComplete(lessonId) {
    const url = "{{ route('student.lesson.complete', ':id') }}".replace(':id', lessonId);
    return axios.post(url, {}, {
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
      }
    }).then(res => {
      const data = res.data;
      if (data.success) {
        if (!completedLessons.includes(lessonId)) {
          completedLessons.push(lessonId);
        }
        renderSidebar();
        renderActiveLesson();
        updateOverallProgress();
      } else {
        throw new Error('Server returned failed state');
      }
    });
  }

  function updateOverallProgress() {
    const spPctText = document.querySelector('.sp-pct');
    const spFill = document.querySelector('.sp-fill');
    if (spPctText && spFill) {
      const completedCount = completedLessons.length;
      const totalCount = lessons.length;
      const newPct = totalCount > 0 ? Math.round((completedCount / totalCount) * 100) : 0;
      spPctText.textContent = `${newPct}%`;
      spFill.style.width = `${newPct}%`;
    }
  }

  // ── INLINE CODE SANDBOX WORKSPACE ────────────────────────
  const sandboxEditorTextArea = document.getElementById('sandboxEditorTextArea');
  const sandboxEditorLineNumbers = document.getElementById('sandboxEditorLineNumbers');
  const sandboxChallengeListContainer = document.getElementById('sandboxChallengeListContainer');
  const btnSubmitSandboxChallenge = document.getElementById('btnSubmitSandboxChallenge');
  const sandboxPreviewFrame = document.getElementById('sandboxPreviewFrame');
  const sandboxTerminalLogContainer = document.getElementById('sandboxTerminalLogContainer');
  const btnResetSandboxCode = document.getElementById('btnResetSandboxCode');

  let activeChallenges = [];

  function updateLineNumbers() {
    const text = sandboxEditorTextArea.value;
    const lines = text.split('\n').length;
    let html = '';
    for(let i = 1; i <= Math.max(lines, 15); i++) {
      html += i + '<br>';
    }
    sandboxEditorLineNumbers.innerHTML = html;
  }

  function logToTerminal(message) {
    const time = new Date().toLocaleTimeString();
    sandboxTerminalLogContainer.innerHTML += `<br>[${time}] ${message}`;
    sandboxTerminalLogContainer.scrollTop = sandboxTerminalLogContainer.scrollHeight;
  }

  function buildChallenges(lesson) {
    activeChallenges = [];
    const title = lesson.title.toLowerCase();

    if (title.includes('head') || title.includes('title') || title.includes('header')) {
      activeChallenges.push({
        id: 1,
        desc: 'Create an &lt;h1&gt; heading tag in your markup containing subtopic text.',
        check: (doc) => {
          const h1 = doc.querySelector('h1');
          return h1 && h1.textContent.trim().length > 0;
        }
      });
      activeChallenges.push({
        id: 2,
        desc: 'Style the header (h1) with color styling (e.g. blue, red, green).',
        check: (doc) => {
          const h1 = doc.querySelector('h1');
          if (!h1) return false;
          const color = window.getComputedStyle(h1).color;
          return color && color !== 'rgb(0, 0, 0)' && color !== 'rgb(203, 213, 225)';
        }
      });
    } else if (title.includes('paragraph') || title.includes('text') || title.includes('content')) {
      activeChallenges.push({
        id: 1,
        desc: 'Create a &lt;p&gt; paragraph tag inside your document container.',
        check: (doc) => {
          return doc.querySelector('p') !== null;
        }
      });
      activeChallenges.push({
        id: 2,
        desc: 'Center-align the text layout of the paragraph (text-align: center).',
        check: (doc) => {
          const p = doc.querySelector('p');
          if (!p) return false;
          const align = window.getComputedStyle(p).textAlign;
          return align === 'center';
        }
      });
    } else {
      activeChallenges.push({
        id: 1,
        desc: 'Create a paragraph or header element mentioning this topic.',
        check: (doc) => {
          const els = Array.from(doc.querySelectorAll('h1, h2, h3, p, div, span'));
          return els.some(el => el.textContent.trim().length > 2);
        }
      });
      activeChallenges.push({
        id: 2,
        desc: 'Implement a style ruleset setting a custom background color or border.',
        check: (doc) => {
          const styles = doc.querySelectorAll('style');
          const hasInline = Array.from(doc.querySelectorAll('*')).some(el => el.getAttribute('style') !== null);
          return styles.length > 0 || hasInline;
        }
      });
    }

    activeChallenges.push({
      id: 3,
      desc: 'Ensure no HTML tags are left unclosed or corrupted.',
      check: (doc) => {
        return doc.body !== null;
      }
    });

    renderChallenges();
  }

  function renderChallenges() {
    sandboxChallengeListContainer.innerHTML = '';
    activeChallenges.forEach(c => {
      const item = document.createElement('div');
      item.className = 'challenge-item-row';
      item.id = `inline-challenge-${c.id}`;
      item.innerHTML = `
        <div class="challenge-check-box">✓</div>
        <span>${c.desc}</span>
      `;
      sandboxChallengeListContainer.appendChild(item);
    });
  }

  function compileSandboxCode() {
    const code = sandboxEditorTextArea.value;
    updateLineNumbers();

    try {
      const doc = sandboxPreviewFrame.contentDocument || sandboxPreviewFrame.contentWindow.document;
      doc.open();
      doc.write(code);
      doc.close();

      let allPassed = true;

      if (activeChallenges.length === 0) {
        btnSubmitSandboxChallenge.disabled = true;
        btnSubmitSandboxChallenge.textContent = 'Free Play Practice';
        btnSubmitSandboxChallenge.style.background = '#1e293b';
        btnSubmitSandboxChallenge.style.borderColor = '#334155';
        btnSubmitSandboxChallenge.style.color = '#64748b';
        return;
      }

      activeChallenges.forEach(c => {
        const passed = c.check(doc);
        const el = document.getElementById(`inline-challenge-${c.id}`);
        if (el) {
          if (passed) {
            el.classList.add('passed');
          } else {
            el.classList.remove('passed');
            allPassed = false;
          }
        } else {
          allPassed = false;
        }
      });

      if (allPassed && activeChallenges.length > 0) {
        logToTerminal('✔ SUCCESS: All challenges mastered! Sandboxed builds verify correctly.');
        btnSubmitSandboxChallenge.disabled = false;
        btnSubmitSandboxChallenge.textContent = 'Submit Completed Challenge ✓';
        btnSubmitSandboxChallenge.style.background = '#10b981';
        btnSubmitSandboxChallenge.style.borderColor = '#10b981';
        btnSubmitSandboxChallenge.style.color = '#fff';
      } else {
        btnSubmitSandboxChallenge.disabled = true;
        btnSubmitSandboxChallenge.textContent = 'Challenges Pending';
        btnSubmitSandboxChallenge.style.background = 'var(--indigo)';
        btnSubmitSandboxChallenge.style.borderColor = 'var(--indigo)';
      }
    } catch (err) {
      logToTerminal('[Compiler Error]: ' + err.message);
    }
  }

  sandboxEditorTextArea.addEventListener('input', compileSandboxCode);

  sandboxEditorTextArea.addEventListener('scroll', () => {
    sandboxEditorLineNumbers.scrollTop = sandboxEditorTextArea.scrollTop;
  });

  btnResetSandboxCode.addEventListener('click', () => {
    if (confirm('Reset editor back to initial template? All local changes will be lost.')) {
      const l = lessons[activeLessonIndex];
      if (l.code_snippet && l.code_snippet.trim() !== '') {
        sandboxEditorTextArea.value = l.code_snippet;
      } else {
        sandboxEditorTextArea.value = `<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      background: #11131e;
      color: #e2e8f0;
      font-family: system-ui, sans-serif;
      padding: 30px;
      text-align: center;
    }
    h1 { color: #818cf8; font-size: 2.2rem; }
    p { color: #94a3b8; line-height: 1.6; }
  </style>
</head>
<body>
  <h1>Interactive Playground</h1>
  <p>Practice writing your HTML & CSS here. The preview updates live!</p>
</body>
</html>`;
      }
      compileSandboxCode();
      logToTerminal('Reset template successfully.');
    }
  });

  btnSubmitSandboxChallenge.addEventListener('click', () => {
    const l = lessons[activeLessonIndex];
    markLessonComplete(l.id).then(() => {
      logToTerminal('Subtopic lesson completion registered in DB!');
      alert('Awesome job! Challenge completed and progression updated successfully.');
      tabBtnPdfOnly.click(); // Go back to PDF study guide
    });
  });

  // Initial loads
  renderSidebar();
  renderActiveLesson();
});
</script>

@endsection
