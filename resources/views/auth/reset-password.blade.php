@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')

<div class="auth-header">
  <h2 class="auth-title">Set new password</h2>
  <p class="auth-sub">Choose a strong new password for your account.</p>
</div>

@if($errors->any())
  <div class="alert-error">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('password.update') }}">
  @csrf
  <input type="hidden" name="token" value="{{ $token }}">

  <div class="form-group">
    <label class="form-label">Email address</label>
    <input class="form-input" type="email" name="email"
      value="{{ old('email', request('email')) }}"
      placeholder="you@email.com"
      required autofocus>
  </div>

  <div class="form-group">
    <label class="form-label">New password</label>
    <input class="form-input" type="password" name="password"
      placeholder="Minimum 8 characters" required>
  </div>

  <div class="form-group">
    <label class="form-label">Confirm new password</label>
    <input class="form-input" type="password" name="password_confirmation"
      placeholder="Repeat your new password" required>
  </div>

  <button type="submit" class="btn-submit">Reset Password</button>
</form>

<div class="auth-switch">
  <a href="{{ route('login') }}">Back to sign in</a>
</div>

@endsection