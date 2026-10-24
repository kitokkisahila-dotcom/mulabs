@extends('layouts.auth')

@section('title', 'Edit Department')

@section('content')
<h1>Edit Department</h1>

@if($errors->any())
    <div class="error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.departments.update', $department->id) }}">
    @csrf
    @method('PUT')
    <div><label for="department_id">Department ID</label><input id="department_id" name="department_id" value="{{ old('department_id', $department->department_id) }}" required></div>
    <div><label for="department_name">Department name</label><input id="department_name" name="department_name" value="{{ old('department_name', $department->department_name) }}" required></div>
    <div><label for="faculty_id">Faculty</label><select id="faculty_id" name="faculty_id" required>@foreach($faculties as $faculty)<option value="{{ $faculty->faculty_id }}" @selected(old('faculty_id', $department->faculty_id) === $faculty->faculty_id)>{{ $faculty->faculty_name }}</option>@endforeach</select></div>
    <button type="submit">Save</button>
</form>
@endsection
