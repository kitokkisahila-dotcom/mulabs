@extends('layouts.auth')

@section('title','Faculty Registration')

@section('content')
    <h1>Faculty Registration</h1>

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

    <form method="POST" action="{{ route('facultyreg') }}">
        @csrf

        <div class="field">
            <input id="faculty_id" name="faculty_id" value="{{ old('faculty_id') }}" placeholder="Faculty ID" required>
        </div>

        <div class="field">
            <input id="faculty_name" name="faculty_name" value="{{ old('faculty_name') }}" placeholder="Faculty Name" required>
        </div>

        <button type="submit" class="btn-submit">Register Faculty</button>
    </form>
@endsection