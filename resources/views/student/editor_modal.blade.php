{{-- Maximized split-screen Online Editor Modal --}}
<div class="editor-overlay" id="editorModal">
  <div class="editor-workspace">
    
    {{-- Header Bar --}}
    <div class="editor-header">
      <div class="editor-title-wrap">
        <div class="editor-icon-chip" style="background: rgba(129, 140, 248, 0.1); border: 1px solid rgba(129, 140, 248, 0.25);">
          <svg style="width: 18px; height: 18px; color: #818cf8; filter: drop-shadow(0 0 4px rgba(129, 140, 248, 0.5));" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
        <div>
          <div class="editor-lesson-title" id="editorLessonTitle">HTML & CSS Sandbox</div>
          <div class="editor-lesson-subtitle">Interactive Playground & Compiler</div>
        </div>
      </div>
      
      <div class="editor-top-actions">
        <button class="editor-btn-secondary" id="editorResetBtn">Reset Code</button>
        <button class="editor-btn-primary" id="editorSubmitBtn">Submit Challenge</button>
        <button class="editor-btn-close" id="editorCloseBtn">&times;</button>
      </div>
    </div>

    {{-- Main Split View --}}
    <div class="editor-split-view">
      
      {{-- Left Panel: Code & Challenges --}}
      <div class="editor-panel-left">
        
        {{-- Challenges Section --}}
        <div class="challenges-section">
          <div class="panel-section-title">Interactive Challenge Checklist</div>
          <div class="challenge-list" id="challengeList">
            {{-- Injected dynamically --}}
          </div>
        </div>

        {{-- Code Editor Section --}}
        <div class="code-editor-section">
          <div class="editor-panel-bar">
            <span>index.html</span>
            <span class="editor-lang-indicator">HTML5 / CSS3</span>
          </div>
          <div class="textarea-container">
            <div class="line-numbers" id="editorLineNumbers">
              1<br>2<br>3<br>4<br>5<br>6<br>7<br>8<br>9<br>10<br>11<br>12<br>13<br>14<br>15
            </div>
            <textarea class="editor-textarea" id="editorCodeInput" spellcheck="false" autocomplete="off" placeholder="<!-- Write your HTML/CSS code here -->"></textarea>
          </div>
        </div>

      </div>

      {{-- Right Panel: Live Output & Terminal --}}
      <div class="editor-panel-right">
        
        {{-- Live Preview Section --}}
        <div class="live-preview-section">
          <div class="editor-panel-bar">
            <span>Live Output Browser</span>
            <span class="live-status-dot green" id="liveStatusText">Live Rendering</span>
          </div>
          <div class="iframe-wrapper">
            <iframe id="livePreviewIframe" sandbox="allow-scripts"></iframe>
          </div>
        </div>

        {{-- Terminal / Test Runner Section --}}
        <div class="terminal-section">
          <div class="editor-panel-bar">
            <span>Test Runner Console</span>
          </div>
          <div class="terminal-log-output" id="terminalLog">
            [System] Compiler initialized.<br>
            [System] Ready to parse inputs. Write code to execute test cases.
          </div>
        </div>

      </div>

    </div>

  </div>
</div>

<style>
  /* Maximized Editor Overlay */
  .editor-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: #090d16;
    z-index: 500;
    display: none;
    opacity: 0;
    transition: opacity 0.25s ease;
  }

  .editor-overlay.active {
    display: block;
    opacity: 1;
  }

  .editor-workspace {
    display: flex;
    flex-direction: column;
    height: 100vh;
    width: 100vw;
    color: #cbd5e1;
    font-family: var(--font-body);
  }

  /* Header Bar */
  .editor-header {
    background: #0f172a;
    border-bottom: 1.5px solid #1e293b;
    height: 60px;
    padding: 0 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
  }

  .editor-title-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .editor-icon-chip {
    font-size: 20px;
    background: #1e293b;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
  }

  .editor-lesson-title {
    font-family: var(--font-display);
    font-size: 14px;
    font-weight: 700;
    color: #fff;
    letter-spacing: -0.01em;
  }

  .editor-lesson-subtitle {
    font-size: 11px;
    color: #64748b;
  }

  .editor-top-actions {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .editor-btn-primary {
    background: var(--indigo);
    color: #fff;
    border: 1px solid var(--indigo);
    padding: 8px 16px;
    border-radius: var(--r);
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
  }
  .editor-btn-primary:hover {
    background: var(--indigo2);
  }

  .editor-btn-secondary {
    background: #1e293b;
    color: #94a3b8;
    border: 1px solid #334155;
    padding: 8px 16px;
    border-radius: var(--r);
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
  }
  .editor-btn-secondary:hover {
    background: #2d3748;
    color: #fff;
  }

  .editor-btn-close {
    background: none;
    border: none;
    font-size: 28px;
    color: #64748b;
    cursor: pointer;
    transition: color 0.15s;
    padding-left: 10px;
  }
  .editor-btn-close:hover {
    color: var(--red);
  }

  /* Split View Layout */
  .editor-split-view {
    display: grid;
    grid-template-columns: 1fr 1fr;
    flex: 1;
    overflow: hidden;
  }

  @media(max-width: 1024px) {
    .editor-split-view {
      grid-template-columns: 1fr;
      grid-template-rows: 1fr 1fr;
    }
  }

  /* Panels */
  .editor-panel-left {
    border-right: 1.5px solid #1e293b;
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }

  .editor-panel-right {
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #020617;
  }

  .panel-section-title {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #64748b;
    padding: 14px 20px 8px;
    background: #0f172a;
    border-bottom: 1px solid #1e293b;
  }

  .editor-panel-bar {
    background: #090d16;
    border-bottom: 1px solid #1e293b;
    border-top: 1px solid #1e293b;
    height: 34px;
    padding: 0 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 11px;
    font-weight: 600;
    color: #64748b;
    font-family: var(--font-mono);
  }

  .editor-lang-indicator {
    color: var(--indigo3);
    font-size: 10px;
  }

  /* Challenges Area */
  .challenges-section {
    background: #0f172a;
    border-bottom: 1px solid #1e293b;
    flex-shrink: 0;
  }

  .challenge-list {
    padding: 12px 20px;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .challenge-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12.5px;
    color: #94a3b8;
  }

  .challenge-item.passed {
    color: #4ade80;
  }

  .challenge-checkbox {
    width: 16px; height: 16px;
    border-radius: 4px;
    border: 1.5px solid #475569;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: bold;
    color: transparent;
    transition: all 0.2s;
  }

  .challenge-item.passed .challenge-checkbox {
    background: #15803d;
    border-color: #22c55e;
    color: #4ade80;
  }

  /* Textarea Editor Area */
  .code-editor-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #090d16;
  }

  .textarea-container {
    display: flex;
    flex: 1;
    overflow: hidden;
    position: relative;
  }

  .line-numbers {
    width: 48px;
    background: #05070c;
    border-right: 1px solid #1e293b;
    padding: 16px 0;
    text-align: right;
    padding-right: 12px;
    font-family: var(--font-mono);
    font-size: 12.5px;
    line-height: 1.6;
    color: #334155;
    user-select: none;
    overflow: hidden;
  }

  .editor-textarea {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    color: #f8fafc;
    font-family: var(--font-mono);
    font-size: 13px;
    line-height: 1.6;
    padding: 16px;
    resize: none;
    overflow-y: auto;
  }

  /* Live Preview Frame */
  .live-preview-section {
    flex: 2;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border-bottom: 1.5px solid #1e293b;
  }

  .iframe-wrapper {
    flex: 1;
    background: #fff;
    position: relative;
  }

  #livePreviewIframe {
    width: 100%;
    height: 100%;
    border: none;
    background: #fff;
  }

  .live-status-dot {
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .live-status-dot::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #22c55e;
    box-shadow: 0 0 5px #22c55e;
  }

  /* Terminal Area */
  .terminal-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #020617;
  }

  .terminal-log-output {
    flex: 1;
    padding: 12px 16px;
    font-family: var(--font-mono);
    font-size: 11.5px;
    line-height: 1.6;
    color: #a7f3d0;
    overflow-y: auto;
  }
</style>
