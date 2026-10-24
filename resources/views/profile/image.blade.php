@extends('layouts.app')

@section('title', 'Change Profile Image')

@section('content')
<div class="mx-auto max-w-xl">
    <a href="{{ route('profile.index') }}" class="text-sm font-medium">← Back to profile</a>
    <h1 class="mt-4 text-2xl font-bold text-slate-900">Change profile image</h1>
    <p class="mt-1 text-slate-500">Use a JPG, PNG, or WebP image up to 2 MB.</p>

    <form action="{{ route('profile.image.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        <img src="{{ $user->image ? asset('storage/'.$user->image) : asset('default-avatar.png') }}" alt="Current profile image" class="mx-auto h-28 w-28 rounded-full object-cover">
        <label for="image" class="mt-6 block text-sm font-semibold text-slate-700">New profile image</label>
        <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp" required class="mt-1 block w-full text-sm">
        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        <div class="mt-6 flex gap-3">
            <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">Upload image</button>
            <a href="{{ route('profile.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 font-semibold text-slate-700">Cancel</a>
        </div>
    </form>
</div>
@endsection
