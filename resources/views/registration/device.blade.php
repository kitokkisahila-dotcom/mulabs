@extends('layouts.auth')
@section('title','Device Registration')
@section('content')
    <h1>Device Registration</h1>
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="error">
            <ul style="margin:0;padding-left:18px">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('devicereg') }}">
        @csrf
        <div class="field">
            <input id="reg_no" name="reg_no" value="{{ old('reg_no') }}" placeholder="Device Registration No" required>
        </div>
        <div class="field">
            <input id="device_name" name="device_name" value="{{ old('device_name') }}" placeholder="Device Name" required>
        </div>
        <div class="field">
            <input id="brand" name="brand" value="{{ old('brand') }}" placeholder="Brand" required>
        </div>
        <div class="field">
            <select id="block_code" name="block_code" required>
                <option value="">-- Select Laboratory --</option>
                @foreach($laboratories as $laboratory)
                    <option value="{{ $laboratory->block_code }}" {{ old('block_code') == $laboratory->block_code ? 'selected' : '' }}>{{ $laboratory->block_name }} ({{ $laboratory->block_code }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-submit">Register Device</button>
    </form>
@endsection
