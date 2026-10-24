@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Account Information</h2>

    <p><b>Role:</b> {{ $user->role }}</p>
    <p><b>Program ID:</b> {{ $user->program_id }}</p>
    <p><b>Department ID:</b> {{ $user->department_id }}</p>
    <p><b>Registered At:</b> {{ $user->created_at }}</p>
</div>
@endsection