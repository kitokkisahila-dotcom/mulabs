
@extends('layouts.auth')

@section('title','User Registration')

@section('content')
    <h1>User Registration</h1>

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
    <form method="POST" action="{{ route('userreg') }}" enctype="multipart/form-data">
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
            <select id="role" name="role" required>
                <option value="">REGISTER AS</option>
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
            </select>
        </div>
        <div id="programDiv" class="field" style="display:none">
            <select id="program_id" name="program_id">
                <option value="">-- Select Program --</option>
                @foreach($programs as $program)
                    <option value="{{ $program->program_id }}" {{ old('program_id') == $program->program_id ? 'selected' : '' }}>{{ $program->program_name }}</option>
                @endforeach
            </select>
        </div>
        <div id="departmentDiv" class="field" style="display:none">
            <select id="department_id" name="department_id">
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
        <button type="submit" class="btn-submit">Register User</button>
    </form>
    <script>
        (function(){
            const role = document.getElementById('role');
            const programDiv = document.getElementById('programDiv');
            const departmentDiv = document.getElementById('departmentDiv');
            function toggleFields(){
                if(!role) return;
                if(role.value === 'student'){
                    programDiv.style.display = 'block';
                    departmentDiv.style.display = 'none';
                } else if(role.value === 'staff'){
                    departmentDiv.style.display = 'block';
                    programDiv.style.display = 'none';
                } else {
                    programDiv.style.display = 'none';
                    departmentDiv.style.display = 'none';
                }
            }

            role.addEventListener('change', toggleFields);
            toggleFields();
        })();


        const phone = document.getElementById('phone');
        const email = document.getElementById('email');

         phone.addEventListener('input', function () {
         const regex = /^(06|07)\d{8}$/;

        if (!regex.test(this.value)) {
           this.setCustomValidity(
            'Enter a valid Tanzanian phone number (e.g. 0712345678).'
        );
       } else {
        this.setCustomValidity('');
    }
     });

      email.addEventListener('input', function () {
       const regex = /^[A-Za-z0-9._%+-]+@gmail\.com$/;
   
      if (!regex.test(this.value)) {
        this.setCustomValidity(
            'Enter a valid Gmail address.'
        );
     } else {
        this.setCustomValidity('');
    }
   });
       </script>
@endsection

