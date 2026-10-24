@extends('layouts.auth')

@section('title','Edit Laboratory')

@section('content')
<h1>Edit Laboratory</h1>

@if($errors->any())
    <div class="error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.labs.update', $lab->block_code) }}">
    @csrf
    @method('PUT')
    <div>
        <label>Block code</label>
        <input name="block_code" value="{{ $lab->block_code }}" disabled>
    </div>
    <div>
        <label>Block name</label>
        <input name="block_name" value="{{ old('block_name', $lab->block_name) }}" required>
    </div>
    <div>
        <label>Capacity</label>
        <input name="capacity" value="{{ old('capacity', $lab->capacity) }}">
    </div>
    <button type="submit">Save</button>
</form>

@endsection
