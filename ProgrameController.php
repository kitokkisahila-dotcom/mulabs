<?php
namespace App\Http\Controllers;
use App\Models\Faculty;
use App\Models\Program;
use Illuminate\Http\Request;
class ProgrameController extends Controller
{
    public function programview()
    {
        $this->checklogin();
        $faculties = Faculty::all();
        return view('registration.programe', compact('faculties'));
    }
    public function program(Request $request)
    {
       $regist=$request->validate([
            'program_id' => 'required|unique:programs,program_id',
            'program_name' => 'required|string',
            'faculty_id' => 'required|exists:faculties,faculty_id',
        ]);
         Program::create($regist);
        return $this->redirectAfterRegistration($request, 'Program registered successfully!');
    }
}
