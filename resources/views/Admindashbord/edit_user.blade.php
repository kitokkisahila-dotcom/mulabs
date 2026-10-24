@extends('layouts.auth')

@section('title','Edit User')

@section('content')
<h1>Edit User</h1>

@if(session('success'))
    <div class="success" id="update-success-message">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.users.update', $user->id) }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="return_to" value="">

    <div>
        <label>First name</label>
        <input name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
    </div>
    <div>
        <label>Second name</label>
        <input name="second_name" value="{{ old('second_name', $user->second_name) }}">
    </div>
    <div>
        <label>Last name</label>
        <input name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
    </div>
    <div>
        <label>Email</label>
        <input name="email" value="{{ old('email', $user->email) }}" required>
    </div>
    <div>
        <label>Phone</label>
        <input name="phone" value="{{ old('phone', $user->phone) }}" required>
    </div>
    <div>
        <label>Sex</label>
        <select name="sex" required>
            <option value="Male" {{ old('sex', $user->sex) == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('sex', $user->sex) == 'Female' ? 'selected' : '' }}>Female</option>
        </select>
    </div>
    <div>
        <label>Role</label>
        <select name="role" required>
            <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Student</option>
            <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
            <option value="lab_technician" {{ old('role', $user->role) == 'lab_technician' ? 'selected' : '' }}>Lab Technician</option>
            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
    </div>
    <div>
        <label>Program</label>
        <select name="program_id">
            <option value="">-- None --</option>
            @foreach($programs as $program)
                <option value="{{ $program->program_id }}" {{ old('program_id', $user->program_id) == $program->program_id ? 'selected' : '' }}>{{ $program->program_name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Department</label>
        <select name="department_id">
            <option value="">-- None --</option>
            @foreach($departments as $department)
                <option value="{{ $department->department_id }}" {{ old('department_id', $user->department_id) == $department->department_id ? 'selected' : '' }}>{{ $department->department_name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>New password (leave blank to keep)</label>
        <input name="password" type="password">
    </div>

    <button type="submit">Save</button>
</form>

<script>
    window.setTimeout(() => document.getElementById('update-success-message')?.remove(), 3000);
</script>

@endsection
