@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Change Password</h2>

    <form method="POST" action="{{ route('profile.password.update') }}">
        @csrf

        <input type="password" name="current_password" placeholder="Current Password">
        <input type="password" name="new_password" placeholder="New Password">
        <input type="password" name="new_password_confirmation" placeholder="Confirm Password">

        <button type="submit">Change Password</button>
    </form>
</div>
@endsection