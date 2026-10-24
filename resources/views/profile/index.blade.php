@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
@php
    $fullName = collect([$user->first_name, $user->second_name, $user->last_name])->filter()->implode(' ');
    $profileDetails = [
        'Registration number' => $user->registration_no,
        'Role' => $user->role ? str($user->role)->replace('_', ' ')->title() : null,
        'Programme' => $user->program?->program_name,
        'Department' => $user->department?->department_name,
        'Gender' => $user->sex,
    ];
    $contactDetails = [
        'Email address' => $user->email,
        'Phone number' => $user->phone,
    ];
@endphp

<div class="max-w-4xl mx-auto space-y-6">
    @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
    @endif

    <section class="rounded-2xl bg-slate-900 p-6 text-white shadow-sm md:flex md:items-center md:justify-between">
        <div class="flex items-center gap-5">
            <img src="{{ $user->image ? asset('storage/'.$user->image) : asset('default-avatar.png') }}" alt="{{ $fullName }}'s profile image" class="h-10 w-10 rounded-full border-4 border-white/30 object-cover">
            <div>
                
                <h3 class="mt-1 text-1xl font-bold">{{ $fullName ?: 'User profile' }}</h3>
            </div>
        </div>
        <a href="{{ route('profile.image') }}" class="mt-5 inline-block rounded-lg bg-white px-4 py-2 font-semibold text-slate-900 hover:bg-slate-100 md:mt-0">Change image</a>
    </section>

    <section class="rounded-2xl bg-white p-6 shadow-sm">
        <h3 class="text-lg font-bold text-slate-900">Profile details</h3>
        <div class="mt-5 overflow-x-auto">
        <table class="w-full text-left">
            <tbody>
            @foreach($profileDetails as $label => $value)
                @if(filled($value))
                    <tr class="odd:bg-slate-50">
                        <th scope="row" class="w-1/3 px-4 py-3 text-sm font-semibold text-slate-600">{{ $label }}</th>
                        <td class="px-4 py-3 text-slate-900">{{ $value }}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
        </div>
    </section>

    <section class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Contact information</h3>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('profile.edit') }}" class="rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">Edit contact</a>
                <a href="{{ route('profile.password') }}" class="rounded-lg bg-slate-100 px-4 py-2 font-semibold text-slate-700 hover:bg-slate-200">Change password</a>
            </div>
        </div>
        <div class="mt-5 overflow-x-auto">
        <table class="w-full text-left">
            <tbody>
            @foreach($contactDetails as $label => $value)
                @if(filled($value))
                    <tr class="odd:bg-slate-50">
                        <th scope="row" class="w-1/3 px-4 py-3 text-sm font-semibold text-slate-600">{{ $label }}</th>
                        <td class="break-words px-4 py-3 text-slate-900">{{ $value }}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
        </div>
    </section>
</div>
@endsection
