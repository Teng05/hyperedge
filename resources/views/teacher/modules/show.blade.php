@extends('layouts.teacher')
@section('title', $module->title)
@section('content')

<div class="flex items-center justify-between mb-6" style="border-bottom: 1px solid var(--border); padding-bottom: 20px;">
    <div class="flex items-center gap-3">
        <a href="{{ route('teacher.modules.index') }}" class="btn btn-ghost btn-sm">
            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            <span>Back</span>
        </a>
        <div>
            <div class="section-title" style="margin-bottom:4px;">{{ $module->title }}</div>
            <div style="font-size:13px; color:var(--muted);">Module {{ $module->order }} • {{ $module->lessons->count() }} subtopic lesson(s)</div>
        </div>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('teacher.modules.edit', $module->id) }}" class="btn btn-ghost">
            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
            <span>Edit Module</span>
        </a>
        @if($module->quiz)
            <a href="{{ route('teacher.quiz.questions', $module->quiz->id) }}" class="btn btn-primary">
                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Manage Quiz</span>
            </a>
        @else
            <a href="{{ route('teacher.quiz.create', $module->id) }}" class="btn btn-primary">
                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Create Quiz</span>
            </a>
        @endif
    </div>
</div>

<div class="grid-3 mb-6">
    <div class="card">
        <div class="stat-num">{{ $module->lessons->count() }}</div>
        <div class="stat-label">Subtopic Lessons</div>
    </div>
    <div class="card">
        <div class="stat-num">{{ $module->quiz ? $module->quiz->questions->count() : 0 }}</div>
        <div class="stat-label">Quiz Questions</div>
    </div>
    <div class="card">
        <div class="stat-num">
            <span class="badge {{ $module->is_active ? 'badge-active' : 'badge-inactive' }}">
                {{ $module->is_active ? 'Live' : 'Draft' }}
            </span>
        </div>
        <div class="stat-label" style="margin-top: 6px;">Module Status</div>
    </div>
</div>

<div class="card mb-6">
    <div class="section-title">Module Description</div>
    <p style="font-size:14px; color:var(--ink2); line-height:1.6;">
        {{ $module->description ?: 'No description added yet.' }}
    </p>
</div>

<div class="card">
    <div class="flex justify-between items-center mb-6">
        <div class="section-title" style="margin-bottom:0;">Timeline Subtopics</div>
        <button type="button" class="btn btn-primary btn-sm" id="openAddLessonModalBtn">
            <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Add Lesson</span>
        </button>
    </div>
    <div class="card-table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">Order</th>
                    <th>Subtopic Title</th>
                    <th>Type</th>
                    <th>Content Resource</th>
                    <th style="width: 260px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($module->lessons as $lesson)
                    <tr>
                        <td style="color:var(--teal); font-weight:700; font-family:'JetBrains Mono',monospace; font-size: 14px;">
                            #{{ str_pad($lesson->order, 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td style="font-weight:600; color: var(--ink);">{{ $lesson->title }}</td>
                        <td>
                            <span class="badge badge-prog" style="font-size: 10px;">{{ strtoupper($lesson->type) }}</span>
                        </td>
                        <td>
                            @if($lesson->video_url)
                                <a href="{{ $lesson->video_url }}" target="_blank" class="section-label-link" style="display:inline-flex; align-items:center; gap:4px;">
                                    <span>Open video URL</span>
                                    <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                </a>
                            @elseif($lesson->file_path)
                                <a href="{{ asset('storage/'.$lesson->file_path) }}" target="_blank" class="section-label-link" style="display:inline-flex; align-items:center; gap:4px;">
                                    <span>Open PDF/PPT file</span>
                                    <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                </a>
                            @else
                                <span style="color: var(--muted2);">No Content Attachment</span>
                            @endif
                        </td>
                        <td class="td-actions" style="justify-content: flex-end;">
                            <a href="{{ route('teacher.lessons.edit', $lesson->id) }}" class="btn btn-ghost btn-sm">
                                <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                                <span>Edit Subtopic</span>
                            </a>
                            <form method="POST" action="{{ route('teacher.lessons.delete', $lesson->id) }}" onsubmit="return confirm('Are you sure you want to delete this subtopic?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <svg style="width:13px; height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; color:var(--muted); padding:32px;">No lessons uploaded for this timeline module yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Lesson Modal Dialog (XL Visual Width) -->
<div class="modal-overlay" id="addLessonModal">
    <div class="modal-container">
        <div class="modal-header">
            <div class="modal-title">✨ Add New Subtopic Lesson</div>
            <button class="modal-close" id="closeAddLessonModalBtn">&times;</button>
        </div>
        <form method="POST" action="{{ route('teacher.modules.addLesson', $module->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Lesson Title</label>
                        <input class="form-input" name="title" value="{{ old('title') }}" required placeholder="e.g. Flexbox Container Properties">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="type" id="lesson-type" required>
                            <option value="video" @selected(old('type') === 'video')>Video URL Link</option>
                            <option value="pdf" @selected(old('type') === 'pdf')>PDF Slide Document</option>
                            <option value="ppt" @selected(old('type') === 'ppt')>PowerPoint Presentation</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Sequence Order</label>
                        <input class="form-input" type="number" name="order" value="{{ old('order', $module->lessons->count() + 1) }}" min="1" required>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
                    <div class="form-group" id="video-url-group" style="margin-bottom:0;">
                        <label class="form-label">Walkthrough Video URL (YouTube embed or source link)</label>
                        <input class="form-input" type="url" name="video_url" id="video-url" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/embed/...">
                    </div>
                    <div class="form-group" id="upload-file-group" style="margin-bottom:0; display:none;">
                        <label class="form-label">Upload File Attachment (.pdf, .ppt, .pptx)</label>
                        <input class="form-input" type="file" name="file" id="lesson-file" accept=".pdf,.ppt,.pptx">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" id="cancelAddLessonModalBtn">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Create Lesson</span>
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const lessonType = document.getElementById('lesson-type');
        const videoGroup = document.getElementById('video-url-group');
        const fileGroup = document.getElementById('upload-file-group');
        const videoInput = document.getElementById('video-url');
        const fileInput = document.getElementById('lesson-file');

        function syncLessonFields() {
            const isVideo = lessonType.value === 'video';

            videoGroup.style.display = isVideo ? 'block' : 'none';
            fileGroup.style.display = isVideo ? 'none' : 'block';

            videoInput.required = isVideo;
            fileInput.required = !isVideo;

            if (isVideo) {
                fileInput.value = '';
            } else {
                videoInput.value = '';
            }
        }

        lessonType.addEventListener('change', syncLessonFields);
        syncLessonFields();

        // Modal triggers
        const modal = document.getElementById('addLessonModal');
        const openBtn = document.getElementById('openAddLessonModalBtn');
        const closeBtn = document.getElementById('closeAddLessonModalBtn');
        const cancelBtn = document.getElementById('cancelAddLessonModalBtn');

        if (openBtn) {
            openBtn.addEventListener('click', () => {
                modal.classList.add('active');
            });
        }
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                modal.classList.remove('active');
            });
        }
        if (cancelBtn) {
            cancelBtn.addEventListener('click', () => {
                modal.classList.remove('active');
            });
        }
        
        // Close modal when clicking overlay
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
    });
</script>
@endsection
