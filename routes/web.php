<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProgrameController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentStaffController;
use App\Http\Controllers\LabtechnicianController;
use App\Http\Controllers\ProfileController;
Route::get('/', function () {
    return view('home');
})->name('home');
Route::redirect('/mulabs', '/');

//laboratory technician registration
Route::get('/technician/register',[UserController::class, 'technicianView'])->name('technician.form');
Route::post('/technician/register',[UserController::class, 'storeTechnician'])->name('technician.store');
//login 
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
//faculty registration route
Route::post('/faculty',[FacultyController::class,'Faculty'])->name('faculty.store');   
Route::get('/faculty',[FacultyController::class,'facultyview'])->name('facultyreg');
//department registration route
Route::post('/department',[DepartmentController::class,'department'])->name('department.store');   
Route::get('/department',[DepartmentController::class,'departmentview'])->name('departmentreg');
//program registration route
Route::post('/program',[ProgrameController::class,'program'])->name('program.store');   
Route::get('/program',[ProgrameController::class,'programview'])->name('programreg');
//device registration route
Route::post('/device',[DeviceController::class,'Device'])->name('device.store');   
Route::get('/device',[DeviceController::class,'deviceview'])->name('devicereg');
Route::get('/devices/statuses', [DeviceController::class, 'statuses'])->name('devices.statuses');
//laboratory registration route
Route::post('/laboratory',[LaboratoryController::class,'Laboratory'])->name('laboratory.store');   
Route::get('/laboratory',[LaboratoryController::class,'laboratoryview'])->name('laboratoryreg');
//user registration route
Route::post('/user',[UserController::class,'user'])->name('userreg');   
Route::get('/user',[UserController::class,'userview'])->name('user');
//report registration route
Route::post('/report',[ReportController::class,'report'])->name('report.store');   
Route::get('/report',[ReportController::class,'reportview'])->name('reportreg');
//student and staff dashboard route
Route::get('/student',[StudentStaffController::class,'dashboard'])->name('studentdashboard');
Route::post('/student/reports',[StudentStaffController::class,'storeReport'])->name('student.reports.store');
Route::get('/student/reports/{id}',[StudentStaffController::class,'showReport'])->name('student.reports.show');
//admin dashboard route
Route::get('/admin',[AdminController::class,'dashboard'])->name('admindashboard');
// Admin management routes
Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

Route::get('/admin/programs/{id}/edit', [AdminController::class, 'editProgram'])->name('admin.programs.edit');
Route::put('/admin/programs/{id}', [AdminController::class, 'updateProgram'])->name('admin.programs.update');
Route::delete('/admin/programs/{id}', [AdminController::class, 'destroyProgram'])->name('admin.programs.destroy');

Route::get('/admin/departments/{id}/edit', [AdminController::class, 'editDepartment'])->name('admin.departments.edit');
Route::put('/admin/departments/{id}', [AdminController::class, 'updateDepartment'])->name('admin.departments.update');
Route::delete('/admin/departments/{id}', [AdminController::class, 'destroyDepartment'])->name('admin.departments.destroy');

Route::get('/admin/labs', [AdminController::class, 'laboratories'])->name('admin.labs');
Route::get('/admin/devices/{id}/edit', [AdminController::class, 'editDevice'])->name('admin.devices.edit');
Route::put('/admin/devices/{id}', [AdminController::class, 'updateDevice'])->name('admin.devices.update');
Route::delete('/admin/devices/{id}', [AdminController::class, 'destroyDevice'])->name('admin.devices.destroy');

Route::get('/admin/labs/{block_code}/edit', [AdminController::class, 'editLab'])->name('admin.labs.edit');
Route::put('/admin/labs/{block_code}', [AdminController::class, 'updateLab'])->name('admin.labs.update');
Route::delete('/admin/labs/{block_code}', [AdminController::class, 'destroyLab'])->name('admin.labs.destroy');

Route::get('/admin/faculties/{id}/edit', [AdminController::class, 'editFaculty'])->name('admin.faculties.edit');
Route::put('/admin/faculties/{id}', [AdminController::class, 'updateFaculty'])->name('admin.faculties.update');
Route::delete('/admin/faculties/{id}', [AdminController::class, 'destroyFaculty'])->name('admin.faculties.destroy');
Route::post('/admin/reports', [AdminController::class, 'storeReport'])->name('admin.reports.store');
Route::post('/admin/reports/{id}/toggle-status', [AdminController::class, 'toggleReportStatus'])->name('admin.reports.toggleStatus');
// lab technician dashboard route
Route::get('/labtechnician',[LabtechnicianController::class,'dashboard'])->name('labtechniciandashboard');
Route::get('/labtechnician/devices/{id}/edit', [LabtechnicianController::class, 'editDevice'])->name('technician.devices.edit');
Route::put('/labtechnician/devices/{id}', [LabtechnicianController::class, 'updateDevice'])->name('technician.devices.update');
Route::delete('/labtechnician/devices/{id}', [LabtechnicianController::class, 'destroyDevice'])->name('technician.devices.destroy');
Route::post('/labtechnician/reports', [LabtechnicianController::class, 'storeReport'])->name('technician.reports.store');
Route::get('/labtechnician/reports/{id}', [LabtechnicianController::class, 'showReport'])->name('technician.reports.show');
Route::post('/labtechnician/reports/{id}/toggle-status', [LabtechnicianController::class, 'toggleReportStatus'])->name('technician.reports.toggleStatus');
Route::get('/labtechnician/reported-devices/download', [LabtechnicianController::class, 'downloadReportedDevices'])->name('technician.reported-devices.download');

// Laboratories
Route::get('/laboratories', [LaboratoryController::class, 'index'])
    ->name('laboratories.index');

Route::get('/laboratories/{block_code}', [LaboratoryController::class, 'show'])
    ->name('laboratories.show');

//profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::get('/profile/image', [ProfileController::class, 'image'])->name('profile.image');
    Route::post('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.image.update');

    Route::get('/profile/account', [ProfileController::class, 'account'])->name('profile.account');
});
