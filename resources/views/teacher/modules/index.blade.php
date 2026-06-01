@extends('layouts.teacher')
@section('title', 'Modules')
@section('content')

<div class="flex items-center justify-between mb-6" style="border-bottom: 1px solid var(--border); padding-bottom: 20px;">
    <div class="section-title" style="margin-bottom:0;">📚 Coursework Modules</div>
    <a href="{{ route('teacher.modules.create') }}" class="btn btn-primary">
        <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>New Module</span>
    </a>
</div>

<div class="card">
    <div class="card-table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">Order</th>
                    <th>Module Title</th>
                    <th style="width: 140px;">Subtopic Lessons</th>
                    <th style="width: 140px;">Status</th>
                    <th style="width: 280px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($modules as $module)
                <tr>
                    <td style="color:var(--teal); font-weight:700; font-family:'JetBrains Mono',monospace; font-size:14px;">
                        #{{ str_pad($module->order, 2, '0', STR_PAD_LEFT) }}
                    </td>
                    <td style="font-weight:700; color:var(--ink); font-size:14px;">{{ $module->title }}</td>
                    <td style="color:var(--ink3); font-weight:600; font-family:'JetBrains Mono',monospace;">
                        {{ $module->lessons->count() }} lesson(s)
                    </td>
                    <td>
                        <span class="badge {{ $module->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $module->is_active ? 'Active' : 'Draft' }}
                        </span>
                    </td>
                    <td class="td-actions" style="justify-content: flex-end;">
                        <a href="{{ route('teacher.modules.show', $module->id) }}" class="btn btn-ghost btn-sm">
                            <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.43l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0Z" />
                            </svg>
                            <span>Manage</span>
                        </a>
                        <a href="{{ route('teacher.modules.edit', $module->id) }}" class="btn btn-ghost btn-sm">
                            <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            <span>Edit</span>
                        </a>
                        <form method="POST" action="{{ route('teacher.modules.destroy', $module->id) }}" onsubmit="return confirm('Are you sure you want to delete this module and all of its content?')">
                            @csrf @method('DELETE')
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
                    <td colspan="5" style="text-align:center; color:var(--muted); padding:32px;">No coursework modules uploaded yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
