<?php

namespace App\Http\Controllers;
use App\Models\Device;
use App\Models\Report;
use App\Models\User;
use App\Models\Program;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function userview()
    {   

        $programs = Program::all();
        $departments = Department::all();
        return view('registration.user', compact('programs', 'departments'));
    }
    public function user(Request $request)
    {
      $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'registration_no' => 'required|unique:users,registration_no',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'sex' => 'required|in:Male,Female',
            'role' => 'required|in:student,staff,lab_technician,admin',
            'password' => 'required|min:6',
            'program_id' => 'nullable|exists:programs,program_id',
            'department_id' => 'nullable|exists:departments,department_id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => [
            'required',
             'email:rfc,email',
             'regex:/^[A-Za-z0-9._%+-]+@gmail\.com$/',
             'unique:users,email',
    ],

        'phone' => [
         'required',
         'regex:/^(06|07)[0-9]{8}$/',
        'unique:users,phone',
    ],

       'password' => 'required|min:8',
]);
     

        $data['image'] = $request->file('image')->store('user_images', 'public');

        $data['password'] = Hash::make($data['password']);

        User::create($data);
        return redirect()->route('login')->with('success', 'Registration successful. You can now log in.');
    }
   public function technicianView()
       {    $this->checklogin();
          $departments = Department::all();
          return view( 'registration.technician',compact('departments')
    );
}
  public function storeTechnician(Request $request)
{
    $user = $request->validate([
        'first_name' => 'required|string|max:255',
        'second_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'registration_no' => 'required|unique:users,registration_no',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|unique:users,phone',
        'sex' => 'required|in:Male,Female',
        'password' => 'required|min:6',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'department_id' => 'required|exists:departments,department_id',
    ]);

    // Set role automatically
    $user['role'] = 'lab_technician';
    // Hash password
    $user['password'] = Hash::make($request->password);
    User::create($user);
    return $this->redirectAfterRegistration($request, 'Laboratory Technician registered successfully!');
}
    }
