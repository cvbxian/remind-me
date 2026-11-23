@extends('layouts.app')
@section('title', 'New Request')

@section('content')
<div class="panel">
    <div class="panel-head">
        <span class="dot r"></span><span class="dot y"></span><span class="dot g"></span>
        <span class="ttl">touch new_request</span>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{ route('requests.store') }}">
            @csrf
            <label>item name
                <input type="text" name="item_name" value="{{ old('item_name') }}">
            </label>
            <label>quantity
                <input type="text" name="quantity" value="{{ old('quantity') }}">
            </label>
            <label>purpose
                <textarea name="purpose" rows="4">{{ old('purpose') }}</textarea>
            </label>
            <button type="submit" class="btn btn-green">submit request</button>
            <a class="btn btn-ghost" href="{{ route('requests.index') }}">cancel</a>
        </form>
    </div>
</div>
@endsection