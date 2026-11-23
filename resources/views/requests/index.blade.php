@extends('layouts.app')
@section('title', 'Requests')

@section('content')
<div class="row" style="align-items:center; margin-bottom:14px">
    <h2 style="margin:0; color:#fff">{{ auth()->user()->isAdmin() ? 'All Requests' : 'My Requests' }}</h2>
    @can('create', \App\Models\ServiceRequest::class)
        <a class="btn btn-green" href="{{ route('requests.create') }}">+ new request</a>
    @endcan
</div>

<form method="GET" action="{{ route('requests.index') }}" style="display:flex; gap:8px; margin-bottom:16px">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="search item..." style="margin-top:0">
    <button type="submit" class="btn">search</button>
</form>

@forelse ($requests as $r)
    <div class="item">
        <div class="row" style="align-items:center">
            <div>
                <span class="title">#{{ $r->id }} {{ $r->item_name }}</span>
                <span class="tag {{ $r->status === 'approved' ? 'done' : 'pending' }}">
                    {{ strtoupper($r->status) }}
                </span>
                <div class="meta">
                    qty {{ $r->quantity }}
                    @if (auth()->user()->isAdmin()) · owner ID {{ $r->user_id }} @endif
                </div>
            </div>
            <a class="btn btn-ghost" href="{{ route('requests.show', $r) }}">view</a>
        </div>
    </div>
@empty
    <div class="empty">// no requests found</div>
@endforelse

{{ $requests->links('pagination::simple-default') }}
@endsection