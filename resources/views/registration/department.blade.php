@extends('layouts.auth')

@section('title','Department Registration')

@section('content')
    <h1>Department Registration</h1>

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

    <form method="POST" action="{{ route('departmentreg') }}">
        @csrf

        <div class="field">
            <input id="department_id" name="department_id" value="{{ old('department_id') }}" placeholder="Department ID" required>
        </div>

        <div class="field">
            <input id="department_name" name="department_name" value="{{ old('department_name') }}" placeholder="Department Name" required>
        </div>

        <div class="field">
            <select id="faculty_id" name="faculty_id" required>
                <option value="">-- Select Faculty --</option>
                @foreach($faculties as $faculty)
                    <option value="{{ $faculty->faculty_id }}" {{ old('faculty_id') == $faculty->faculty_id ? 'selected' : '' }}>{{ $faculty->faculty_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-submit">Register Department</button>
    </form>
@endsection
