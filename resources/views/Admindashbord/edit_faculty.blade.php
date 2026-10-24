@extends('layouts.auth')

@section('title','Edit Faculty')

@section('content')
<h1>Edit Faculty</h1>

@if($errors->any())
    <div class="error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.faculties.update', $faculty->id) }}">
    @csrf
    @method('PUT')
    <div>
        <label>Faculty name</label>
        <input name="faculty_name" value="{{ old('faculty_name', $faculty->faculty_name) }}" required>
    </div>
    <button type="submit">Save</button>
</form>

@endsection
