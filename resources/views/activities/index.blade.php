@extends('layouts.app')
@section('title', 'My Activities')

@section('content')
<div class="row" style="align-items:center; margin-bottom:18px">
    <div>
        <h2 style="margin:0; color:#fff">Dashboard</h2>
        <div class="hint" style="margin:4px 0 0">{{ now()->format('l, F d, Y') }}</div>
    </div>
    <a class="btn btn-green" href="{{ route('activities.create') }}">+ new activity</a>
</div>

<div class="stats">
    <div class="stat"><div class="num c-cyan">{{ $today->count() }}</div><div class="lbl">Today</div></div>
    <div class="stat"><div class="num c-amber">{{ $upcoming->count() }}</div><div class="lbl">Upcoming</div></div>
    <div class="stat"><div class="num c-green">{{ $today->where('status', 'done')->count() }}</div><div class="lbl">Done today</div></div>
</div>

<div class="section-title">ls ./today</div>
@forelse ($today as $a)
    @include('activities._item', ['a' => $a])
@empty
    <div class="empty">// nothing scheduled for today</div>
@endforelse

<div class="section-title">ls ./upcoming</div>
@forelse ($upcoming as $a)
    @include('activities._item', ['a' => $a])
@empty
    <div class="empty">// no upcoming activities</div>
@endforelse
@endsection

@push('scripts')
<script>
// Reminder engine: every 30 seconds, check which activities are inside their reminder window.
const notified = new Set();

function showToast(title) {
    const box = document.getElementById('toasts');
    const t = document.createElement('div');
    t.className = 'toast';
    t.innerHTML = '<b>[REMINDER]</b> ' + title.replace(/</g, '&lt;') + ' is due soon.';
    box.appendChild(t);
    setTimeout(() => t.remove(), 12000);
}

function checkReminders() {
    document.querySelectorAll('[data-due]').forEach(el => {
        if (el.dataset.status === 'done') return;
        const diffMin = (new Date(el.dataset.due) - new Date()) / 60000;
        const window = parseInt(el.dataset.remind, 10);
        if (diffMin <= window && diffMin > -1 && !notified.has(el.dataset.id)) {
            notified.add(el.dataset.id);
            showToast(el.dataset.title);
        }
    });
}

checkReminders();
setInterval(checkReminders, 30000);
</script>
@endpush