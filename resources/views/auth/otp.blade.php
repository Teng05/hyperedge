@extends('layouts.auth')
@section('title', 'Verify Email')
@section('content')

<div class="auth-header">
  <h2 class="auth-title">Check your email</h2>
  <p class="auth-sub">We sent a 6-digit code to</p>
  <p class="otp-email">{{ session('register_data.email') ?? session('email') ?? 'your email' }}</p>
</div>

@if($errors->any())
  <div class="alert-error">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('otp.verify') }}">
  @csrf
  <div class="form-group">
    <label class="form-label" style="text-align:center;display:block;">Enter OTP Code</label>
    <input class="otp-input" type="text" name="otp_code"
      maxlength="6" placeholder="000000"
      autofocus autocomplete="off" required>
  </div>
  <button type="submit" class="btn-submit" style="margin-top:20px;">Verify &amp; Create Account</button>
</form>

<p class="otp-expire">OTP expires in 10 minutes</p>

<div class="auth-switch">
  Didn't receive it? Check spam or <a href="{{ route('register') }}">go back</a>
</div>

@endsection