<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;
class DepartmentController extends Controller
{
    // Show department registration form
    public function departmentview(){
        $this->checkLogin();
        $faculties = Faculty::all();
        return view('registration.department', compact('faculties'));
    }
     // Store department
      public function department(Request $request){
       $data=$request->validate([
            'department_id' => 'required|unique:departments,department_id',
            'department_name' => 'required|string',
            'faculty_id' => 'required|exists:faculties,faculty_id',
        ]);

        try {
            Department::create($data);

            return $this->redirectAfterRegistration($request, 'Department registered successfully!');
        } 
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to register department: ' . $e->getMessage());
        }
    }
}
