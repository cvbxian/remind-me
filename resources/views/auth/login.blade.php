@extends('layouts.app')
@section('title', 'Login - Remind Me')

@section('content')
<div class="login-wrap">
    <div class="panel">
        <div class="panel-head">
            <span class="dot r"></span><span class="dot y"></span><span class="dot g"></span>
            <span class="ttl">remind-me — secure login</span>
        </div>
        <div class="panel-body">
            <h2 style="margin:0 0 4px; color:var(--green)">&gt; REMIND-ME</h2>
            <p class="hint">Authenticate to access your activity schedule.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <label>email
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="user@example.com" required autofocus>
                </label>
                <label>password
                    <input type="password" name="password" placeholder="••••••••" required>
                </label>
                <button type="submit" class="btn btn-block">./login</button>
            </form>

            <p class="hint" style="margin:16px 0 0; text-align:center">
                No account yet? <a href="{{ route('register') }}">Sign up</a>
            </p>
        </div>
    </div>
</div>
@endsection