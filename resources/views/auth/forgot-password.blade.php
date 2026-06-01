@extends('layouts.auth')
@section('title', 'Forgot Password')
@section('content')

<div class="auth-header">
  <h2 class="auth-title">Forgot password?</h2>
  <p class="auth-sub">Enter your registered email and we'll send you a reset link.</p>
</div>

@if(session('success'))
  <div class="alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
  <div class="alert-error">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
  @csrf

  <div class="form-group">
    <label class="form-label">Email address</label>
    <input class="form-input" type="email" name="email"
      value="{{ old('email') }}"
      placeholder="you@email.com"
      required autofocus>
  </div>

  <button type="submit" class="btn-submit">Send Reset Link</button>
</form>

<div class="auth-switch">
  Remembered it? <a href="{{ route('login') }}">Back to sign in</a>
</div>

@endsection