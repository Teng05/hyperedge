@extends('layouts.teacher')
@section('title', 'Create Module')
@section('content')

<div style="max-width: 800px; margin: 0 auto;">
    <div class="flex items-center gap-3 mb-6" style="border-bottom: 1px solid var(--border); padding-bottom: 20px;">
        <a href="{{ route('teacher.modules.index') }}" class="btn btn-ghost btn-sm">
            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            <span>Back</span>
        </a>
        <div class="section-title" style="margin-bottom:0;">✨ Create Coursework Module</div>
    </div>
    
    <div class="card">
        <form method="POST" action="{{ route('teacher.modules.store') }}">
            @csrf
            <div class="grid-3 mb-4">
                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label">Module Title</label>
                    <input class="form-input" name="title" value="{{ old('title') }}" placeholder="e.g. Introduction to CSS Grid" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Sequence Order (1 = first)</label>
                    <input class="form-input" type="number" name="order" value="{{ old('order', 1) }}" min="1" required>
                </div>
            </div>
            
            <div class="form-group mb-6">
                <label class="form-label">Description</label>
                <textarea class="form-textarea" name="description" placeholder="What core concepts will students learn in this module?" style="min-height: 120px;">{{ old('description') }}</textarea>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid var(--border); padding-top: 20px;">
                <a href="{{ route('teacher.modules.index') }}" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary" style="padding: 11px 24px;">
                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Create Module</span>
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
