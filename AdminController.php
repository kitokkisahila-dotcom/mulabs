<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Laboratory;
use App\Models\Device;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Department;
use App\Models\Report;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
 public function dashboard(){
    $this->checkLogin();
    $user = User::all();
    $usersCount = User::count();
    $labsCount = Laboratory::count();
    $devicesCount = Device::count();
    $facultiesCount = Faculty::count();
    $programsCount = Program::count();
    $departmentsCount = Department::count();
    $programs = Program::with('faculty')->orderBy('program_name')->get();
    $departments = Department::with('faculty')->orderBy('department_name')->get();
    $technicians = User::with('department')->where('role', 'lab_technician')->get();
    $labs = Laboratory::with('device')->orderBy('block_name')->get();
    $devices = Device::with('laboratory')->orderBy('device_name')->get();
    $faculties = Faculty::orderBy('faculty_name')->get();
    $reports = Report::with('device.laboratory')->orderBy('created_at', 'desc')->get();
   
    return response()->view('Admindashbord.dashboard', compact(
        'user',
        'usersCount',
        'labsCount',
        'devicesCount',
        'facultiesCount',
        'programsCount',
        'departmentsCount',
        'programs',
        'departments',
        'technicians',
        'labs',
        'devices',
        'faculties',
        'reports'
    ))
    ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
    ->header('Pragma', 'no-cache')
    ->header('Expires', '0');
  }
          
  public function users()
  {
    $users = User::orderBy('first_name')->paginate(20);
    return view('Admindashbord.users', compact('users'));
  }
  public function editUser($id)
  {
    $user = User::findOrFail($id);
    $programs = Program::orderBy('program_name')->get();
    $departments = Department::orderBy('department_name')->get();
    return view('Admindashbord.edit_user', compact('user', 'programs', 'departments'));
  }
  public function editProgram($id)
  {
    $program = Program::findOrFail($id);
    $faculties = Faculty::orderBy('faculty_name')->get();
    return view('registration.programe', compact('program', 'faculties'));
  }
  public function updateProgram(Request $request, $id)
  {
    $program = Program::findOrFail($id);
    $data = $request->validate([
      'program_id' => 'required|string|unique:programs,program_id,'.$program->id,
      'program_name' => 'required|string|max:255',
      'faculty_id' => 'required|exists:faculties,faculty_id',
    ]);
    $program->update($data);
    return redirect()->route('admindashboard')->with('success', 'Program updated successfully');
  }
  public function destroyProgram($id)
  {
    $program = Program::findOrFail($id);
    $program->delete();
    return redirect()->route('admindashboard')->with('success', 'Program deleted successfully');
  }

  public function editDepartment($id)
  {
    abort_unless(Auth::user() && Auth::user()->role === 'admin', 403);
    $department = Department::findOrFail($id);
    $faculties = Faculty::orderBy('faculty_name')->get();
    return view('Admindashbord.edit_department', compact('department', 'faculties'));
  }

  public function updateDepartment(Request $request, $id)
  {
    abort_unless(Auth::user() && Auth::user()->role === 'admin', 403);
    $department = Department::findOrFail($id);
    $data = $request->validate([
      'department_id' => 'required|string|unique:departments,department_id,'.$department->id,
      'department_name' => 'required|string|max:255',
      'faculty_id' => 'required|exists:faculties,faculty_id',
    ]);
    $department->update($data);
    return redirect()->route('admindashboard')->with('success', 'Department updated successfully');
  }

  public function destroyDepartment($id)
  {
    abort_unless(Auth::user() && Auth::user()->role === 'admin', 403);
    $department = Department::findOrFail($id);
    $department->delete();
    return redirect()->route('admindashboard')->with('success', 'Department deleted successfully');
  }

  public function storeReport(Request $request)
  {
    $data = $request->validate([
      'device_reg_no' => 'required|exists:devices,reg_no',
      'description' => 'required|string|min:10|max:1000',
    ]);

    $report = Report::create([
      'device_reg_no' => $data['device_reg_no'],
      'user_id' => Auth::user()->registration_no,
      'description' => $data['description'],
    ]);
    $report->device->syncStatusFromReports();

    return redirect()->route('admindashboard')->with('success', 'Report created successfully.');
  }

  public function toggleReportStatus($id)
  {
    $report = Report::findOrFail($id);
    $report->status = $report->status === 'Resolved' ? 'Faulty' : 'Resolved';
    $report->save();
    $report->device->syncStatusFromReports();

    return redirect()->route('admindashboard')->with('success', 'Report status updated successfully.');
  }

  public function updateUser(Request $request, $id)
  {
    $user = User::findOrFail($id);
    $data = $request->validate([
      'first_name' => 'required|string|max:255',
      'second_name' => 'nullable|string|max:255',
      'last_name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email,'.$user->id,
      'phone' => 'required|unique:users,phone,'.$user->id,
      'sex' => 'required|in:Male,Female',
      'role' => 'required|in:student,staff,lab_technician,admin',
      'password' => 'nullable|min:6',
      'program_id' => 'nullable|exists:programs,program_id',
      'department_id' => 'nullable|exists:departments,department_id',
    ]);

    if (!empty($data['password'])) {
      $data['password'] = Hash::make($data['password']);
    } else {
      unset($data['password']);
    }
    $user->update($data);

    if ($request->expectsJson()) {
      return response()->json(['message' => 'User updated successfully']);
    }

    return redirect()->route('admin.users.edit', $user->id)->with('success', 'User updated successfully');
  }
  public function destroyUser(Request $request, $id)
  {
    $user = User::findOrFail($id);
    $user->delete();

    if ($request->expectsJson()) {
      return response()->json(['message' => 'User deleted successfully']);
    }

    return redirect()->route('admindashboard')->with('success', 'User deleted successfully');
  }
  public function laboratories()
  {
    $this->checkLogin();
    $user = User::all();
    $usersCount = User::count();
    $labsCount = Laboratory::count();
    $devicesCount = Device::count();
    $facultiesCount = Faculty::count();
    $programsCount = Program::count();
    $departmentsCount = Department::count();
    $programs = Program::with('faculty')->orderBy('program_name')->get();
    $departments = Department::with('faculty')->orderBy('department_name')->get();
    $labs = Laboratory::with('device')->orderBy('block_name')->get();
    $devices = Device::with('laboratory')->orderBy('device_name')->get();
    $faculties = Faculty::orderBy('faculty_name')->get();
    $reports = Report::with('device.laboratory')->orderBy('created_at', 'desc')->get();
    return view('Admindashbord.dashboard', compact('user','usersCount','labsCount','devicesCount','facultiesCount','programsCount','departmentsCount','programs','departments','labs','devices','faculties','reports'));
  }
  public function editLab($block_code)
  {
    abort_unless(Auth::user() && Auth::user()->role === 'admin', 403);
    $lab = Laboratory::where('block_code', $block_code)->firstOrFail();
    return view('Admindashbord.edit_lab', compact('lab'));
  }
  public function updateLab(Request $request, $block_code)
  {
    abort_unless(Auth::user() && Auth::user()->role === 'admin', 403);
    $lab = Laboratory::where('block_code', $block_code)->firstOrFail();

    $data = $request->validate([
      'block_name' => 'required|string|max:255',
      'capacity' => 'nullable|integer',
    ]);
    $lab->update($data);
    return redirect()->route('admindashboard')->with('success', 'Laboratory updated');
  }
  public function destroyLab($block_code)
  {
    abort_unless(Auth::user() && Auth::user()->role === 'admin', 403);
    $lab = Laboratory::where('block_code', $block_code)->firstOrFail();
    $lab->delete();
    return redirect()->route('admindashboard')->with('success', 'Laboratory deleted');
  }
  public function destroyDevice($id)
  {
    abort_unless(Auth::user() && Auth::user()->role === 'admin', 403);
    $device = Device::findOrFail($id);
    $device->delete();
    return redirect()->route('admindashboard')->with('success', 'Device deleted');
  }
  public function editFaculty($id)
  {
    abort_unless(Auth::user() && Auth::user()->role === 'admin', 403);
    $faculty = Faculty::findOrFail($id);
    return view('Admindashbord.edit_faculty', compact('faculty'));
  }
  public function updateFaculty(Request $request, $id)
  {
    abort_unless(Auth::user() && Auth::user()->role === 'admin', 403);
    $faculty = Faculty::findOrFail($id);
    $data = $request->validate([
      'faculty_name' => 'required|string|max:255',
    ]);
    $faculty->update($data);
    return redirect()->route('admindashboard')->with('success', 'Faculty updated');
  }
  public function destroyFaculty($id)
  {
    abort_unless(Auth::user() && Auth::user()->role === 'admin', 403);
    $faculty = Faculty::findOrFail($id);
    $faculty->delete();
    return redirect()->route('admindashboard')->with('success', 'Faculty deleted');
  }
  public function editDevice($id)
  {
    $device = Device::findOrFail($id);
    return view('Admindashbord.edit_device', compact('device'));
  }
  public function updateDevice(Request $request, $id)
  {
    $device = Device::findOrFail($id);
    $data = $request->validate([
      'device_name' => 'required|string|max:255',
      'brand' => 'nullable|string|max:255',
      'block_code' => 'required|string|exists:laboratories,block_code',
    ]);
    $device->update($data);
    return redirect()->route('admin.labs')->with('success', 'Device updated');
  }

}
