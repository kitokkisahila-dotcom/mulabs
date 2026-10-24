@extends('layouts.auth')

@section('title','Program Registration')

@section('content')
    @php $isEdit = isset($program); @endphp
    <h1>{{ $isEdit ? 'Update Program' : 'Program Registration' }}</h1>

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

    <form method="POST" action="{{ $isEdit ? route('admin.programs.update', $program->id) : route('programreg') }}">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="field">
            <input id="program_id" name="program_id" value="{{ old('program_id', $program->program_id ?? '') }}" placeholder="Program ID" required>
        </div>

        <div class="field">
            <input id="program_name" name="program_name" value="{{ old('program_name', $program->program_name ?? '') }}" placeholder="Program Name" required>
        </div>

        <div class="field">
            <select id="faculty_id" name="faculty_id" required>
                <option value="">-- Select Faculty --</option>
                @foreach($faculties as $faculty)
                    <option value="{{ $faculty->faculty_id }}" {{ old('faculty_id', $program->faculty_id ?? '') == $faculty->faculty_id ? 'selected' : '' }}>{{ $faculty->faculty_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-submit">{{ $isEdit ? 'Update Program' : 'Register Program' }}</button>
    </form>
@endsection
