@extends('layouts.app')
@section('title', 'Request #' . $serviceRequest->id)

@section('content')
<div class="panel">
    <div class="panel-head">
        <span class="dot r"></span><span class="dot y"></span><span class="dot g"></span>
        <span class="ttl">cat request_{{ $serviceRequest->id }}</span>
    </div>
    <div class="panel-body">
        <p><b style="color:var(--cyan)">ID:</b> {{ $serviceRequest->id }}</p>
        <p><b style="color:var(--cyan)">Requester:</b> {{ $serviceRequest->requester_name }} ({{ $serviceRequest->requester_email }})</p>
        <p><b style="color:var(--cyan)">Item:</b> {{ $serviceRequest->item_name }}</p>
        <p><b style="color:var(--cyan)">Quantity:</b> {{ $serviceRequest->quantity }}</p>
        <p><b style="color:var(--cyan)">Purpose:</b> {{ $serviceRequest->purpose }}</p>
        <p><b style="color:var(--cyan)">Status:</b>
            <span class="tag {{ $serviceRequest->status === 'approved' ? 'done' : 'pending' }}">
                {{ strtoupper($serviceRequest->status) }}
            </span>
        </p>
        <p><b style="color:var(--cyan)">Created:</b> {{ $serviceRequest->created_at }}</p>

        @can('updateStatus', $serviceRequest)
            <form method="POST" action="{{ route('requests.updateStatus', $serviceRequest) }}" style="margin-top:18px">
                @csrf
                @method('PATCH')
                <label>update status
                    <select name="status">
                        @foreach (['pending', 'approved', 'rejected'] as $s)
                            <option value="{{ $s }}" @selected($serviceRequest->status === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </label>
                <button type="submit" class="btn btn-green">save status</button>
            </form>
        @endcan

        <a class="btn btn-ghost" href="{{ route('requests.index') }}" style="margin-top:14px">back to list</a>
    </div>
</div>
@endsection