<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->loadMissing(['program', 'department']);

        return view('profile.index', compact('user'));
    }

    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:255', Rule::unique('users', 'phone')->ignore($user->id)],
        ]);
  
        $user->update($validated);

        return redirect()->route('profile.index')->with('success', 'Contact information updated successfully.');
    }

    public function image()
    {
        return view('profile.image', ['user' => Auth::user()]);
    }

    public function changePassword()
    
         public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.index')->with('success', 'Password changed successfully.');
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->update([
            'image' => $request->file('image')->store('profile_images', 'public'),
        ]);

        return redirect()->route('profile.index')->with('success', 'Profile image updated successfully.');
    }

    public function account()
    {
        return redirect()->route('profile.index');
    }
}
