@extends('layouts.teacher')
@section('title', 'Create Quiz')
@section('content')

<div style="max-width: 800px; margin: 0 auto;">
    <div class="flex items-center gap-3 mb-6" style="border-bottom: 1px solid var(--border); padding-bottom: 20px;">
        <a href="{{ route('teacher.modules.show', $module->id) }}" class="btn btn-ghost btn-sm">
            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            <span>Back</span>
        </a>
        <div>
            <div class="section-title" style="margin-bottom:4px;">✨ Create Assessment Quiz</div>
            <div style="font-size:13px; color:var(--muted);">For module: {{ $module->title }}</div>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('teacher.quiz.store', $module->id) }}">
            @csrf
            <div class="grid-3 mb-4">
                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label">Quiz Title</label>
                    <input class="form-input" name="title" value="{{ old('title', $module->title.' Quiz') }}" placeholder="e.g. Flexbox Core Concepts Assessment" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Quiz Type</label>
                    <select class="form-select" name="type" required>
                        <option value="module_assessment" @selected(old('type') === 'module_assessment')>Module Assessment</option>
                        <option value="final_exam" @selected(old('type') === 'final_exam')>Final Exam</option>
                    </select>
                </div>
            </div>
            
            <div class="grid-3 mb-6">
                <div class="form-group">
                    <label class="form-label">Passing Score (pts)</label>
                    <input class="form-input" type="number" name="passing_score" value="{{ old('passing_score', 7) }}" min="1" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Total Points</label>
                    <input class="form-input" type="number" name="total_points" value="{{ old('total_points', 10) }}" min="1" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Randomize Questions</label>
                    <select class="form-select" name="randomize">
                        <option value="0">No, keep order</option>
                        <option value="1" @selected(old('randomize') == 1)>Yes, shuffle</option>
                    </select>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid var(--border); padding-top: 20px;">
                <a href="{{ route('teacher.modules.show', $module->id) }}" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary" style="padding: 11px 24px;">
                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Create Quiz</span>
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
