@extends('layouts.auth')

@section('title','Report Registration')

@section('content')
    <h1>Report Registration</h1>

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

    <form method="POST" action="{{ route('reportreg') }}">
        @csrf

        <div class="field">
            <select id="device_reg_no" name="device_reg_no" required>
                <option value="">-- Select Device --</option>
                @foreach($devices as $device)
                    <option value="{{ $device->reg_no }}" {{ old('device_reg_no') == $device->reg_no ? 'selected' : '' }}>{{ $device->device_name }} ({{ $device->reg_no }})</option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <select id="user_id" name="user_id" required>
                <option value="">-- Select User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->registration_no }}" {{ old('user_id') == $user->registration_no ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }} ({{ $user->registration_no }})</option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <textarea id="description" name="description" rows="5" placeholder="Description" required>{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn-submit">Register Report</button>
    </form>
@endsection
