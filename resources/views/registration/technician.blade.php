
@extends('layouts.auth')
@section('title','Technician Registration')
@section('content')
    <h1>Laboratory Technician Registration</h1>
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
    <form method="POST" action="{{ route('technician.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="field">
            <input id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required>
        </div>
        <div class="field">
            <input id="second_name" name="second_name" value="{{ old('second_name') }}" placeholder="Second Name">
        </div>
        <div class="field">
            <input id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>
        </div>
        <div class="field">
            <input id="registration_no" name="registration_no" value="{{ old('registration_no') }}" placeholder="Registration No" required>
        </div>
        <div class="field">
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
        </div>
        <div class="field">
            <input id="phone" name="phone" value="{{ old('phone') }}" placeholder="Phone" required>
        </div>
        <div class="field">
            <select id="sex" name="sex" required>
                <option value="">-- Select Sex --</option>
                <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>
        <div class="field">
            <select id="department_id" name="department_id" required>
                <option value="">-- Select Department --</option>
                @foreach($departments as $department)
                    <option value="{{ $department->department_id }}" {{ old('department_id') == $department->department_id ? 'selected' : '' }}>{{ $department->department_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label for="image">Profile Image (passport size)</label>
            <input id="image" type="file" name="image" accept="image/*" required>
           

        </div>
        <div class="field">
            <input id="password" type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn-submit">Register Technician</button>
    </form>
@endsection

