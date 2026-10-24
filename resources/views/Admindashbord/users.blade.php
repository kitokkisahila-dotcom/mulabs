@extends('layouts.auth')

@section('title','Users')

@section('content')
<h1>All Users</h1>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table border="1" cellpadding="8" cellspacing="0" style="width:100%">
    <thead>
        <tr>
            <th>Registration No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->registration_no }}</td>
            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>
                <a href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this user?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>



@endsection
