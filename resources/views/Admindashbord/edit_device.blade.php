@extends('layouts.auth')

@section('title','Edit Device')

@section('content')
<h1>Edit Device</h1>

@if($errors->any())
    <div class="error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.devices.update', $device->id) }}">
    @csrf
    @method('PUT')

    <div>
        <label>Device name</label>
        <input name="device_name" value="{{ old('device_name', $device->device_name) }}" required>
    </div>
    <div>
        <label>Brand</label>
        <input name="brand" value="{{ old('brand', $device->brand) }}">
    </div>
    <div>
        <label>Block code</label>
        <input name="block_code" value="{{ old('block_code', $device->block_code) }}" required>
    </div>

    <button type="submit">Save</button>
</form>

@endsection
