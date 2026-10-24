@extends('layouts.app')

@section('title', 'Edit Contact Information')

@section('content')
<div class="mx-auto max-w-xl">
    <a href="{{ route('profile.index') }}" class="text-sm font-medium">← Back to profile</a>
    <h1 class="mt-4 text-2xl font-bold text-slate-900">Edit contact information</h1>
    <p class="mt-1 text-slate-500">You can update only your email address and phone number.</p>

    <form action="{{ route('profile.update') }}" method="POST" class="mt-6 space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="phone" class="block text-sm font-semibold text-slate-700">Phone number</label>
            <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" required class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm">
            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">Save contact details</button>
            <a href="{{ route('profile.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 font-semibold text-slate-700">Cancel</a>
        </div>
    </form>
</div>
@endsection
