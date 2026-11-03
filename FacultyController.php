<?php

namespace App\Http\Controllers;
use App\Models\Faculty;

use Illuminate\Http\Request;

class FacultyController extends Controller
{
public function facultyview(){
  $this->checklogin();
      return view('registration.faculty');
    }
         public function Faculty(Request $request){
         $data=$request->validate([
          'faculty_id'=>'required|string|max:255|unique:faculties,faculty_id',
          'faculty_name'=>'required|string|max:255',  
          ]);
         Faculty::create($data);  
           return $this->redirectAfterRegistration($request, 'Faculty registered successfully!');
  
}
}
