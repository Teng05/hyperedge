@extends('layouts.teacher')
@section('title', 'Edit Module')
@section('content')

<div style="max-width: 800px; margin: 0 auto;">
    <div class="flex items-center gap-3 mb-6" style="border-bottom: 1px solid var(--border); padding-bottom: 20px;">
        <a href="{{ route('teacher.modules.show', $module->id) }}" class="btn btn-ghost btn-sm">
            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            <span>Back</span>
        </a>
        <div class="section-title" style="margin-bottom:0;">✏️ Edit Module Details</div>
    </div>
    
    <div class="card">
        <form method="POST" action="{{ route('teacher.modules.update', $module->id) }}">
            @csrf
            @method('PUT')
            
            <div class="grid-3 mb-4">
                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label">Module Title</label>
                    <input class="form-input" name="title" value="{{ old('title', $module->title) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Module Order</label>
                    <input class="form-input" type="number" name="order" value="{{ old('order', $module->order) }}" min="1" required>
                </div>
            </div>
            
            <div class="grid-3 mb-4">
                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label">Description</label>
                    <textarea class="form-textarea" name="description" style="min-height: 120px;">{{ old('description', $module->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="is_active">
                        <option value="1" @selected(old('is_active', $module->is_active) == 1)>Active</option>
                        <option value="0" @selected(old('is_active', $module->is_active) == 0)>Draft</option>
                    </select>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid var(--border); padding-top: 20px;">
                <a href="{{ route('teacher.modules.show', $module->id) }}" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary" style="padding: 11px 24px;">
                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
