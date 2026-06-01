@extends('layouts.teacher')
@section('title', 'Edit Subtopic')
@section('content')

<style>
  .dash-wrap {
    max-width: 900px;
    margin: 0 auto;
    padding-bottom: 64px;
  }

  .flex-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid var(--ink);
    padding: 30px 0 20px;
    margin-bottom: 28px;
  }

  .page-title {
    font-family: 'DM Sans', sans-serif;
    font-size: 28px;
    font-weight: 800;
    letter-spacing: -0.025em;
    color: var(--ink);
  }
  .page-title span { color: var(--teal); }

  .subtopic-sub {
    font-size: 13px;
    color: var(--muted);
    margin-top: 4px;
  }

  /* Form Cards */
  .edit-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    padding: 28px;
    margin-bottom: 24px;
  }

  .card-section-title {
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: var(--ink);
    letter-spacing: -0.01em;
    text-transform: uppercase;
    margin-bottom: 18px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }

  @media(max-width: 768px) {
    .grid-2 {
      grid-template-columns: 1fr;
    }
  }

  .form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 16px;
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
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--ink3);
  }

  .form-input, .form-textarea, .form-select {
    padding: 10px 12px;
    border: 1px solid var(--border);
    background: var(--bg);
    border-radius: var(--r);
    color: var(--ink);
    font-size: 13px;
    outline: none;
    font-family: inherit;
    transition: all 0.2s;
  }

  .form-input:focus, .form-textarea:focus, .form-select:focus {
    border-color: var(--teal);
    background: var(--surface);
  }

  /* Slide Builder Card styles */
  .slide-row {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--r);
    padding: 16px;
    margin-bottom: 12px;
    position: relative;
  }

  .slide-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
  }

  .slide-num {
    font-size: 10px;
    font-weight: 700;
    color: var(--teal);
    letter-spacing: 1px;
    text-transform: uppercase;
  }

  .btn-remove-slide {
    background: none;
    border: none;
    color: var(--red);
    cursor: pointer;
    font-size: 11px;
    font-weight: 600;
  }
  .btn-remove-slide:hover {
    text-decoration: underline;
  }

  .form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid var(--border);
  }

  /* Code snippet code-like style */
  .textarea-code {
    font-family: 'JetBrains Mono', monospace;
    font-size: 12.5px;
    background: #0f172a;
    color: #f8fafc;
    border-color: #334155;
  }
  .textarea-code:focus {
    background: #020617;
    border-color: var(--teal3);
    box-shadow: 0 0 0 3px rgba(20,184,166,0.1);
  }

  .thumbnail-preview {
    width: 120px;
    height: 70px;
    border-radius: var(--r);
    border: 1px solid var(--border);
    object-fit: cover;
    margin-top: 8px;
  }
</style>

<div class="dash-wrap">

  <div class="flex-header">
    <div class="flex items-center gap-3">
      <a href="{{ route('teacher.modules.show', $module->id) }}" class="btn btn-ghost btn-sm">
        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
        <span>Back</span>
      </a>
      <div>
        <div class="page-title" style="line-height: 1;">Edit Subtopic<span>.</span></div>
        <div class="subtopic-sub">Module {{ $module->order }}: {{ $module->title }} / {{ $lesson->title }}</div>
      </div>
    </div>
  </div>

  <form method="POST" action="{{ route('teacher.lessons.update', $lesson->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- 1. General Info --}}
    <div class="edit-card">
      <div class="card-section-title">General Information</div>
      <div class="grid-2">
        <div class="form-group">
          <label class="form-label" for="title">Title / Name</label>
          <input type="text" name="title" id="title" class="form-input" value="{{ old('title', $lesson->title) }}" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="lesson_type">Type</label>
          <select name="type" id="lesson_type" class="form-select" required>
            <option value="video" {{ old('type', $lesson->type) == 'video' ? 'selected' : '' }}>Video Lesson</option>
            <option value="ppt" {{ old('type', $lesson->type) == 'ppt' ? 'selected' : '' }}>PowerPoint Slides</option>
            <option value="pdf" {{ old('type', $lesson->type) == 'pdf' ? 'selected' : '' }}>PDF File</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="order">Sequence Order</label>
          <input type="number" name="order" id="order" class="form-input" value="{{ old('order', $lesson->order) }}" min="1" required>
        </div>

        <div class="form-group" id="file_upload_group" style="display: none;">
          <label class="form-label" for="lesson_file">Lesson File (PDF or PPTX)</label>
          <input type="file" name="file" id="lesson_file" class="form-input" accept=".pdf,.ppt,.pptx">
          @if($lesson->file_path)
            <div style="font-size: 11px; margin-top: 6px;">
              Current file: <a href="{{ asset('storage/' . $lesson->file_path) }}" target="_blank" style="color:var(--teal); font-weight:600;">View File</a>
            </div>
          @endif
        </div>

        <div class="form-group" id="video_url_group">
          <label class="form-label" for="video_url">Lesson Video Embed Link</label>
          <input type="url" name="video_url" id="video_url" class="form-input" value="{{ old('video_url', $lesson->video_url) }}" placeholder="e.g. https://www.youtube.com/embed/...">
        </div>
      </div>
    </div>

    {{-- 2. Enhanced Explanation --}}
    <div class="edit-card">
      <div class="card-section-title">Visual Explanation details</div>
      
      <div class="form-group">
        <label class="form-label" for="video_explanation">Subtopic Text Explanation</label>
        <textarea name="video_explanation" id="video_explanation" class="form-textarea" placeholder="Explain the subtopic concepts in depth for students..." style="min-height: 120px;">{{ old('video_explanation', $lesson->video_explanation) }}</textarea>
      </div>

      <div class="grid-2">
        <div class="form-group">
          <label class="form-label" for="video_thumbnail_file">Screenshot / Visual Thumbnail</label>
          <input type="file" name="video_thumbnail_file" id="video_thumbnail_file" class="form-input" accept="image/*">
          @if($lesson->video_thumbnail)
            <div>
              <img src="{{ asset('storage/' . $lesson->video_thumbnail) }}" class="thumbnail-preview" alt="Thumbnail">
            </div>
          @else
            <div style="font-size: 11px; color: var(--muted); margin-top: 6px;">No subtopic image uploaded yet.</div>
          @endif
        </div>
      </div>
    </div>

    {{-- 3. Dynamic Slide Builder --}}
    <div class="edit-card" id="slides_card">
      <div class="card-section-title">
        <span>Interactive PPT Slides Builder (Up to 5-6 slides)</span>
        <button type="button" class="btn btn-primary btn-sm" id="btn-add-slide" style="padding: 4px 10px;">
          <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
          </svg>
          <span>Add Slide</span>
        </button>
      </div>
      <div id="slides-container">
        {{-- Filled by JS --}}
      </div>
      <div id="no-slides-msg" style="text-align:center; color:var(--muted); font-size:12px; padding:20px; border:1px dashed var(--border); border-radius:var(--r); display:none;">
        No custom slides built yet. Click "+ Add Slide" to build structural content.
      </div>
    </div>

    {{-- 4. Sandbox Playground Setup --}}
    <div class="edit-card">
      <div class="card-section-title">Live Code Example & Playground Setup</div>
      
      <div class="form-group">
        <label class="form-label" for="code_snippet">Code Sandbox Snippet Placeholder (HTML/CSS)</label>
        <textarea name="code_snippet" id="code_snippet" class="form-textarea textarea-code" placeholder="<!-- Place start code here -->&#10;<h1>Hello world</h1>&#10;<style>&#10;  h1 { color: red; }&#10;</style>" style="min-height: 160px;">{{ old('code_snippet', $lesson->code_snippet) }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="code_explanation_video">Walkthrough Video Link (optional)</label>
        <input type="url" name="code_explanation_video" id="code_explanation_video" class="form-input" value="{{ old('code_explanation_video', $lesson->code_explanation_video) }}" placeholder="URL to tutorial video explaining this code sandbox task...">
      </div>
    </div>

    <div class="form-actions">
      <a href="{{ route('teacher.modules.show', $module->id) }}" class="btn btn-ghost">Cancel</a>
      <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">
        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        <span>Save Changes</span>
      </button>
    </div>

  </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Sync general fields (video vs files)
  const lessonType = document.getElementById('lesson_type');
  const fileGroup = document.getElementById('file_upload_group');
  const videoGroup = document.getElementById('video_url_group');
  const videoInput = document.getElementById('video_url');
  const fileInput = document.getElementById('lesson_file');

  function syncFields() {
    const type = lessonType.value;
    if (type === 'video') {
      videoGroup.style.display = 'block';
      fileGroup.style.display = 'none';
      fileInput.value = '';
    } else {
      videoGroup.style.display = 'none';
      fileGroup.style.display = 'block';
      videoInput.value = '';
    }
  }

  lessonType.addEventListener('change', syncFields);
  syncFields();

  // Slides Builder JS
  const container = document.getElementById('slides-container');
  const noSlidesMsg = document.getElementById('no-slides-msg');
  const addBtn = document.getElementById('btn-add-slide');
  
  // Parse existing slides
  let slides = @json($lesson->ppt_slides ?? []);
  if (!Array.isArray(slides)) {
    slides = [];
  }

  function renderSlides() {
    container.innerHTML = '';
    if (slides.length === 0) {
      noSlidesMsg.style.display = 'block';
    } else {
      noSlidesMsg.style.display = 'none';
      slides.forEach((slide, index) => {
        createSlideRow(index, slide.title, slide.content);
      });
    }
  }

  function createSlideRow(index, title = '', content = '') {
    const row = document.createElement('div');
    row.className = 'slide-row';
    row.innerHTML = `
      <div class="slide-header">
        <span class="slide-num">Slide #${index + 1}</span>
        <button type="button" class="btn-remove-slide" data-index="${index}">Delete Slide</button>
      </div>
      <div class="grid-2">
        <div class="form-group" style="margin-bottom: 8px;">
          <label class="form-label">Slide Headline</label>
          <input type="text" name="ppt_slides[${index}][title]" class="form-input" value="${title}" required placeholder="Slide header title...">
        </div>
        <div class="form-group" style="margin-bottom: 8px;">
          <label class="form-label">Slide Paragraph</label>
          <textarea name="ppt_slides[${index}][content]" class="form-textarea" required placeholder="Detailed slide text contents..." style="min-height: 52px; padding: 6px 10px;">${content}</textarea>
        </div>
      </div>
    `;
    container.appendChild(row);
  }

  addBtn.addEventListener('click', () => {
    if (slides.length >= 6) {
      alert('Maximum of 6 slides allowed per subtopic presentation.');
      return;
    }
    // Read current form values first to not lose them on re-render
    gatherFormSlides();
    slides.push({ title: '', content: '' });
    renderSlides();
  });

  container.addEventListener('click', (e) => {
    if (e.target.classList.contains('btn-remove-slide')) {
      const idx = parseInt(e.target.getAttribute('data-index'), 10);
      gatherFormSlides();
      slides.splice(idx, 1);
      renderSlides();
    }
  });

  function gatherFormSlides() {
    const rows = container.querySelectorAll('.slide-row');
    slides = [];
    rows.forEach(row => {
      const titleInput = row.querySelector('input[type="text"]');
      const contentText = row.querySelector('textarea');
      slides.push({
        title: titleInput ? titleInput.value : '',
        content: contentText ? contentText.value : ''
      });
    });
  }

  // Initial Render
  renderSlides();
});
</script>

@endsection
