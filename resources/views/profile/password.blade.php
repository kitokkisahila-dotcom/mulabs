@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="mx-auto max-w-xl">
    <a href="{{ route('profile.index') }}" class="text-sm font-medium">← Back to profile</a>
    <h1 class="mt-4 text-2xl font-bold text-slate-900">Change password</h1>
    <p class="mt-1 text-slate-500">Choose a new password with at least eight characters.</p>

    <form action="{{ route('profile.password.update') }}" method="POST" class="mt-6 space-y-5 rounded-2xl bg-white p-6 shadow-sm">
        @csrf
        <div>
            <label for="current_password" class="block text-sm font-semibold text-slate-700">Current password</label>
            <input id="current_password" type="password" name="current_password" required autocomplete="current-password" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm">
            @error('current_password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password" class="block text-sm font-semibold text-slate-700">New password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm">
            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Confirm new password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">Change password</button>
            <a href="{{ route('profile.index') }}" class="rounded-lg bg-slate-100 px-4 py-2 font-semibold text-slate-700">Cancel</a>
        </div>
    </form>
</div>
@endsection
