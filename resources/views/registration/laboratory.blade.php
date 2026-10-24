@extends('layouts.auth')

@section('title','Laboratory Registration')

@section('content')
    <h1>Laboratory Registration</h1>

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

    <form method="POST" action="{{ route('laboratoryreg') }}">
        @csrf

        <div class="field">
            <input type="text" id="block_code" name="block_code" value="{{ old('block_code') }}" placeholder="Block Code" required>
        </div>

        <div class="field">
            <input type="text" id="block_name" name="block_name" value="{{ old('block_name') }}" placeholder="Block Name" required>
        </div>

        <div class="field">
            <input type="number" id="capacity" name="capacity" value="{{ old('capacity') }}" placeholder="Capacity" required>
        </div>

        <button type="submit" class="btn-submit">Register Laboratory</button>
    </form>
@endsection