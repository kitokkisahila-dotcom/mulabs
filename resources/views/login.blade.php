@extends('layouts.auth')
@section('title','Login')
@section('content')
    <h1>Log in</h1>
    @if(session('success'))
        <div class="success" role="status">{{ session('success') }}</div>
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
    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="field">
            <input id="registration_no" name="registration_no" value="{{ old('registration_no') }}" placeholder="Registration No" required autofocus>
        </div>

        
        <div class="field">
            <input id="password" name="password" type="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn-submit">Log in</button>
       
    </form>
@endsection
