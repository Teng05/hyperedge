@extends('layouts.admin')
@section('title', 'Add Facilitator')
@section('content')

<style>
    .facilitator-wrap {
        max-width: 920px;
        margin: 0 auto;
        padding-bottom: 56px;
    }

    .facilitator-header {
        padding: 30px 0 20px;
        border-bottom: 2px solid var(--ink);
        margin-bottom: 24px;
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 20px;
    }

    .facilitator-eyebrow {
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 8px;
    }

    .facilitator-title {
        font-family: 'DM Sans', sans-serif;
        font-size: 32px;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--ink);
        line-height: 1;
    }

    .facilitator-title span { color: var(--gold); }

    .facilitator-sub {
        font-size: 13px;
        color: var(--muted);
        margin-top: 6px;
        line-height: 1.5;
        max-width: 560px;
    }

    .facilitator-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 260px;
        gap: 22px;
        align-items: start;
    }

    .form-card,
    .note-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        overflow: hidden;
    }

    .form-card-head {
        padding: 18px 22px;
        border-bottom: 1px solid var(--border);
    }

    .form-card-title {
        font-size: 13px;
        font-weight: 800;
        color: var(--ink);
        letter-spacing: -0.01em;
    }

    .form-card-sub {
        font-size: 11px;
        color: var(--muted);
        margin-top: 3px;
        line-height: 1.5;
    }

    .facilitator-form {
        padding: 22px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin-bottom: 16px;
    }

    .form-label {
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 1.3px;
        text-transform: uppercase;
        color: var(--ink3);
    }

    .form-input {
        width: 100%;
        min-height: 40px;
        padding: 10px 12px;
        border: 1px solid var(--border2);
        background: var(--surface2);
        border-radius: var(--r);
        color: var(--ink);
        font-size: 13px;
        outline: none;
        font-family: inherit;
        transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    }

    .form-input:focus {
        border-color: var(--navy);
        background: var(--surface);
        box-shadow: 0 0 0 3px rgba(13, 31, 60, 0.08);
    }

    .form-input::placeholder { color: var(--muted); }

    .field-error {
        font-size: 11px;
        color: var(--red);
    }

    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 4px;
    }

    .note-card {
        padding: 18px;
    }

    .note-chip {
        display: inline-flex;
        align-items: center;
        padding: 4px 9px;
        background: var(--gold-light);
        color: var(--gold);
        border: 1px solid var(--gold-border);
        border-radius: 20px;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 12px;
    }

    .note-title {
        font-size: 13px;
        font-weight: 800;
        color: var(--ink);
        margin-bottom: 8px;
    }

    .note-copy {
        font-size: 12px;
        color: var(--ink3);
        line-height: 1.6;
    }

    @media (max-width: 820px) {
        .facilitator-header {
            display: grid;
            align-items: start;
        }

        .facilitator-grid,
        .form-row {
            grid-template-columns: 1fr;
        }

        .form-row {
            gap: 0;
        }

        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .form-actions .btn {
            justify-content: center;
        }
    }
</style>

<div class="facilitator-wrap">
    <div class="facilitator-header">
        <div>
            <div class="facilitator-eyebrow">Facilitator Access</div>
            <div class="facilitator-title">New Facilitator<span>.</span></div>
            <div class="facilitator-sub">
                Create a facilitator account and send the first-login credentials to their email address.
            </div>
        </div>
        <a href="{{ route('admin.teachers.index') }}" class="btn btn-ghost btn-sm">Back to Facilitators</a>
    </div>

    <div class="facilitator-grid">
        <div class="form-card">
            <div class="form-card-head">
                <div class="form-card-title">Account details</div>
                <div class="form-card-sub">Use the facilitator's official name and active email address.</div>
            </div>

            <form method="POST" action="{{ route('admin.teachers.store') }}" class="facilitator-form">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="first_name">First name</label>
                        <input
                            class="form-input"
                            id="first_name"
                            name="first_name"
                            value="{{ old('first_name') }}"
                            placeholder="Juan"
                            autocomplete="given-name"
                            required
                        >
                        @error('first_name')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="last_name">Last name</label>
                        <input
                            class="form-input"
                            id="last_name"
                            name="last_name"
                            value="{{ old('last_name') }}"
                            placeholder="Dela Cruz"
                            autocomplete="family-name"
                            required
                        >
                        @error('last_name')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email address</label>
                    <input
                        class="form-input"
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="facilitator@school.edu"
                        autocomplete="email"
                        required
                    >
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create & Send Credentials</button>
                </div>
            </form>
        </div>

        <aside class="note-card">
            <div class="note-chip">Credentials</div>
            <div class="note-title">Temporary access is sent automatically.</div>
            <div class="note-copy">
                After the account is created, the facilitator receives a temporary password by email and can change it after their first login.
            </div>
        </aside>
    </div>
</div>

@endsection
