@extends('layouts.teacher')
@section('title', 'Quiz Questions')
@section('content')

<div class="flex items-center justify-between mb-6" style="border-bottom: 1px solid var(--border); padding-bottom: 20px;">
    <div class="flex items-center gap-3">
        <a href="{{ route('teacher.modules.show', $quiz->module->id) }}" class="btn btn-ghost btn-sm">
            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            <span>Back</span>
        </a>
        <div>
            <div class="section-title" style="margin-bottom:4px;">{{ $quiz->title }}</div>
            <div style="font-size:13px;color:var(--muted);">{{ $quiz->module->title }} • {{ $quiz->questions->count() }} question(s)</div>
        </div>
    </div>
</div>

<div class="grid-3 mb-6">
    <div class="card">
        <div class="stat-num">{{ $quiz->questions->count() }}</div>
        <div class="stat-label">Questions</div>
    </div>
    <div class="card">
        <div class="stat-num">{{ $quiz->passing_score }}</div>
        <div class="stat-label">Passing Score</div>
    </div>
    <div class="card">
        <div class="stat-num">{{ $quiz->total_points }}</div>
        <div class="stat-label">Total Points</div>
    </div>
</div>

<div class="card">
    <div class="flex justify-between items-center mb-6">
        <div class="section-title" style="margin-bottom: 0;">Questions List</div>
        <button type="button" class="btn btn-primary btn-sm" id="openAddQuestionModalBtn">
            <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Add Question</span>
        </button>
    </div>
    <div class="card-table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Question Concept Text</th>
                    <th style="width: 120px; text-align: center;">Correct Answer</th>
                    <th style="width: 120px; text-align: center;">Points</th>
                    <th style="width: 150px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quiz->questions as $question)
                    <tr>
                        <td style="font-weight:600; color: var(--ink); line-height: 1.5;">{{ $question->question_text }}</td>
                        <td style="text-align:center;">
                            <span class="badge badge-prog" style="font-family:'JetBrains Mono',monospace; font-size:11px;">
                                Choice {{ strtoupper($question->correct_answer) }}
                            </span>
                        </td>
                        <td style="text-align:center; font-family:'JetBrains Mono',monospace; font-weight:700; color: var(--teal);">
                            {{ $question->points }} pts
                        </td>
                        <td class="td-actions" style="justify-content: flex-end;">
                            <form method="POST" action="{{ route('teacher.quiz.deleteQuestion', $question->id) }}" onsubmit="return confirm('Are you sure you want to delete this question?')">
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
                        <td colspan="4" style="text-align:center;color:var(--muted);padding:32px;">No assessment questions created for this quiz yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Question Modal Dialog (Spacious Form Layout) -->
<div class="modal-overlay" id="addQuestionModal">
    <div class="modal-container">
        <div class="modal-header">
            <div class="modal-title">✨ Add Assessment Question</div>
            <button class="modal-close" id="closeAddQuestionModalBtn">&times;</button>
        </div>
        <form method="POST" action="{{ route('teacher.quiz.addQuestion', $quiz->id) }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Question Text / Concept</label>
                    <textarea class="form-textarea" name="question_text" required placeholder="Write the question task details here..." style="min-height: 80px;">{{ old('question_text') }}</textarea>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Choice A</label>
                        <input class="form-input" name="choice_a" value="{{ old('choice_a') }}" required placeholder="Option A description">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Choice B</label>
                        <input class="form-input" name="choice_b" value="{{ old('choice_b') }}" required placeholder="Option B description">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Choice C</label>
                        <input class="form-input" name="choice_c" value="{{ old('choice_c') }}" required placeholder="Option C description">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Choice D</label>
                        <input class="form-input" name="choice_d" value="{{ old('choice_d') }}" required placeholder="Option D description">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Correct Option Answer</label>
                        <select class="form-select" name="correct_answer" required>
                            <option value="a">Option A</option>
                            <option value="b">Option B</option>
                            <option value="c">Option C</option>
                            <option value="d">Option D</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Points Allocation</label>
                        <input class="form-input" type="number" name="points" value="{{ old('points', 1) }}" min="1" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" id="cancelAddQuestionModalBtn">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Create Question</span>
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('addQuestionModal');
        const openBtn = document.getElementById('openAddQuestionModalBtn');
        const closeBtn = document.getElementById('closeAddQuestionModalBtn');
        const cancelBtn = document.getElementById('cancelAddQuestionModalBtn');

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
