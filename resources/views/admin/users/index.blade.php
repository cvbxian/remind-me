@extends('layouts.app')
@section('title', 'Users')

@section('content')
<h2 style="margin:0 0 4px; color:#fff">Users</h2>
<div class="hint">Click a user to see and manage their activities.</div>

@forelse ($users as $u)
    <a href="{{ route('admin.users.show', $u) }}" style="display:block">
        <div class="item">
            <div class="row" style="align-items:center">
                <div>
                    <span class="title">{{ $u->name }}</span>
                    <span class="tag {{ $u->role === 'admin' ? 'done' : 'pending' }}">
                        {{ strtoupper($u->role ?? 'user') }}
                    </span>
                    <div class="meta">{{ $u->email }}</div>
                </div>
                <div style="color:var(--muted)">{{ $u->activities_count }} activities &gt;</div>
            </div>
        </div>
    </a>
@empty
    <div class="empty">// no users found</div>
@endforelse
@endsection