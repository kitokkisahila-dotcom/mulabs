<?php

namespace App\Http\Controllers;
use App\Models\Report;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
class ReportController extends Controller
{
    public function reportview()
    {   
        $this->checklogin();
        $devices = Device::all();
        $users = User::all();
        return view('registration.report', compact('devices', 'users'));
    }
    public function report(Request $request)
    {
       $data=$request->validate([
            'device_reg_no' => 'required|exists:devices,reg_no',
            'user_id' => 'required|exists:users,registration_no',
            'description' => 'required|string|max:1000',
        ]);
        $report = Report::create($data);
        $report->device->syncStatusFromReports();
        return $this->redirectAfterRegistration($request, 'Report registered successfully!');
    }
}
