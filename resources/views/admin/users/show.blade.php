@extends('layouts.app')
@section('title', $user->name . ' - Activities')

@section('content')
<div class="row" style="align-items:center; margin-bottom:18px">
    <div>
        <h2 style="margin:0; color:#fff">{{ $user->name }}</h2>
        <div class="hint" style="margin:4px 0 0">
            {{ $user->email }} · {{ $activities->count() }} activities
        </div>
    </div>
    <div class="actions">
        <a class="btn btn-ghost" href="{{ route('admin.users.index') }}">&lt; all users</a>
        <a class="btn btn-green" href="{{ route('admin.users.activities.create', $user) }}">+ add activity</a>
    </div>
</div>

@forelse ($activities as $a)
    <div class="item {{ $a->status === 'done' ? 'done' : '' }}">
        <div class="row">
            <div>
                <span class="title">{{ $a->title }}</span>
                <span class="tag {{ $a->status }}">{{ strtoupper($a->status) }}</span>
                <div class="meta">
                    📅 {{ $a->activity_date->format('M d, Y') }}
                    &nbsp;⏰ {{ \Carbon\Carbon::parse($a->activity_time)->format('h:i A') }}
                    &nbsp;🔔 {{ $a->remindLabel() }}
                </div>
                @if ($a->description) <div class="desc">{{ $a->description }}</div> @endif
            </div>

            <div class="actions">
                <form method="POST" action="{{ route('admin.activities.done', $a) }}">
                    @csrf @method('PATCH')
                    <button class="btn btn-green" type="submit">{{ $a->status === 'done' ? 'undo' : 'done' }}</button>
                </form>
                <a class="btn btn-ghost" href="{{ route('admin.activities.edit', $a) }}">edit</a>
                <form method="POST" action="{{ route('admin.activities.destroy', $a) }}"
                      onsubmit="return confirm('Delete this activity?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-red" type="submit">delete</button>
                </form>
            </div>
        </div>
    </div>
@empty
    <div class="empty">// this user has no activities yet</div>
@endforelse
@endsection