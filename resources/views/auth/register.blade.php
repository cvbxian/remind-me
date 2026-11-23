@extends('layouts.app')
@section('title', 'Sign Up - Remind Me')

@section('content')
<div class="login-wrap">
    <div class="panel">
        <div class="panel-head">
            <span class="dot r"></span><span class="dot y"></span><span class="dot g"></span>
            <span class="ttl">remind-me — create account</span>
        </div>
        <div class="panel-body">
            <h2 style="margin:0 0 4px; color:var(--green)">&gt; SIGN UP</h2>
            <p class="hint">Create an account to start tracking your activities.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <label>full name
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Juan Dela Cruz" required autofocus>
                </label>
                <label>email
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="user@example.com" required>
                </label>
                <label>password (min. 8 characters)
                    <input type="password" name="password" placeholder="••••••••" required>
                </label>
                <label>confirm password
                    <input type="password" name="password_confirmation" placeholder="••••••••" required>
                </label>
                <button type="submit" class="btn btn-block">./create-account</button>
            </form>

            <p class="hint" style="margin:16px 0 0; text-align:center">
                Already have an account? <a href="{{ route('login') }}">Log in</a>
            </p>
        </div>
    </div>
</div>
@endsection