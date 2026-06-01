@extends('layouts.auth')
@section('title', 'Sign In')
@section('content')

<div class="auth-header">
  <h2 class="auth-title">Welcome back</h2>
  <p class="auth-sub">Sign in to continue your learning journey</p>
</div>

@if($errors->any())
  <div class="alert-error">{{ $errors->first() }}</div>
@endif
@if(session('success'))
  <div class="alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
  @csrf
  <div class="form-group">
    <label class="form-label">Email address</label>
    <input class="form-input" type="email" name="email"
      value="{{ old('email') }}" placeholder="you@email.com" required autofocus>
  </div>
  <div class="form-group">
    <label class="form-label">Password</label>
    <input class="form-input" type="password" name="password"
      placeholder="Enter your password" required>
  </div>
  <div class="form-row-inline">
    <label class="checkbox-label">
      <input type="checkbox" name="remember" class="checkbox-input">
      <span class="checkbox-box"></span>
      Remember me
    </label>
  </div>
  <button type="submit" class="btn-submit">Sign in</button>
</form>

<div class="auth-switch">
  Don't have an account? <a href="{{ route('register') }}">Create one</a>
</div>

@endsection