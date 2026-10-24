<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AuthController extends Controller
{   
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->intended(match (Auth::user()->role) {
                'admin' => route('admindashboard'),
                'lab_technician' => route('labtechniciandashboard'),
                'staff', 'student' => route('studentdashboard'),
                default => route('home'),
            });
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'registration_no' => 'required|string',
            'password' => 'required|string',
            'remember' => 'sometimes|boolean',
        ]);
        if (Auth::attempt(['registration_no' => $data['registration_no'], 'password' => $data['password']], $request->filled('remember'))) {
            $request->session()->regenerate();
            $dashboardRoute = match (Auth::user()->role) {
                'admin' => route('admindashboard'),
                'lab_technician' => route('labtechniciandashboard'),
                'staff', 'student' => route('studentdashboard'),
                default => url('/'),
            };
            return redirect()->intended($dashboardRoute);
        }
        return back()->withErrors([
            'registration_no' => 'The provided credentials do not match our records.',
        ])->onlyInput('registration_no');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
