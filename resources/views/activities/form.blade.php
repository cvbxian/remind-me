@extends('layouts.app')
@section('title', $activity->exists ? 'Edit Activity' : 'New Activity')

@section('content')
<div class="panel">
    <div class="panel-head">
        <span class="dot r"></span><span class="dot y"></span><span class="dot g"></span>
        <span class="ttl">{{ $activity->exists ? 'nano activity_' . $activity->id : 'touch new_activity' }}</span>
    </div>
    <div class="panel-body">
        <form method="POST"
              action="{{ $activity->exists ? route('activities.update', $activity) : route('activities.store') }}">
            @csrf
            @if ($activity->exists) @method('PUT') @endif

            <label>title
                <input type="text" name="title" value="{{ old('title', $activity->title) }}" placeholder="e.g. Submit lab report" required>
            </label>

            <label>description
                <textarea name="description" rows="3" placeholder="optional details...">{{ old('description', $activity->description) }}</textarea>
            </label>

            <div class="grid2">
                <label>date
                    <input type="date" name="activity_date"
                           value="{{ old('activity_date', optional($activity->activity_date)->format('Y-m-d')) }}" required>
                </label>
                <label>time
                    <input type="time" name="activity_time"
                           value="{{ old('activity_time', $activity->activity_time ? substr($activity->activity_time, 0, 5) : '') }}" required>
                </label>
            </div>

            <label>remind me
                <select name="remind_before">
                    @foreach ([0 => 'On time', 5 => '5 minutes before', 10 => '10 minutes before', 30 => '30 minutes before', 60 => '1 hour before', 1440 => '1 day before'] as $v => $text)
                        <option value="{{ $v }}" @selected(old('remind_before', $activity->remind_before ?? 10) == $v)>{{ $text }}</option>
                    @endforeach
                </select>
            </label>

            <button type="submit" class="btn btn-green">save</button>
            <a class="btn btn-ghost" href="{{ route('activities.index') }}">cancel</a>
        </form>
    </div>
</div>
@endsection