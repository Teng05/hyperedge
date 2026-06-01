@extends('layouts.admin')
@section('title', 'Facilitators')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div class="section-title">All Facilitators</div>
    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">+ Add Facilitator</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Status</th><th>Joined</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teachers as $teacher)
            <tr>
                <td style="font-weight:500;">{{ $teacher->full_name }}</td>
                <td style="color:var(--muted);">{{ $teacher->email }}</td>
                <td>
                    <span class="badge {{ $teacher->is_active ? 'badge-active' : 'badge-inactive' }}">
                        {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td style="color:var(--muted);">{{ $teacher->created_at->format('M j, Y') }}</td>
                <td>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('admin.teachers.toggle', $teacher->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-ghost btn-sm">
                                {{ $teacher->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.teachers.destroy', $teacher->id) }}" onsubmit="return confirm('Delete this facilitator?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:32px;">No facilitators yet. Add one!</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
