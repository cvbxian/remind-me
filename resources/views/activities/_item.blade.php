<div class="item {{ $a->status === 'done' ? 'done' : '' }}"
     data-id="{{ $a->id }}" data-title="{{ $a->title }}" data-status="{{ $a->status }}"
     data-remind="{{ $a->remind_before }}"
     data-due="{{ $a->activity_date->format('Y-m-d') }}T{{ substr($a->activity_time, 0, 5) }}">
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
            <form method="POST" action="{{ route('activities.done', $a) }}">
                @csrf @method('PATCH')
                <button class="btn btn-green" type="submit">{{ $a->status === 'done' ? 'undo' : 'done' }}</button>
            </form>
            <a class="btn btn-ghost" href="{{ route('activities.edit', $a) }}">edit</a>
            <form method="POST" action="{{ route('activities.destroy', $a) }}" onsubmit="return confirm('Delete this activity?')">
                @csrf @method('DELETE')
                <button class="btn btn-red" type="submit">delete</button>
            </form>
        </div>
    </div>
</div>