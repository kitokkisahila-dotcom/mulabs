<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laboratory;
use App\Models\Device;
use App\Models\Report;
class StudentStaffController extends Controller
{
    public function dashboard()
    {       
        $this->checklogin();
        $labs = Laboratory::with('device')->orderBy('block_name')->get();
        $computerLabs = Laboratory::where('block_name', 'like', '%computer%')
            ->orWhere('block_name', 'like', '%Computer%')
            ->with('device')
            ->orderBy('block_name')
            ->get();
        if ($computerLabs->isEmpty()) {
            $computerLabs = $labs;
        }
        $devices = Device::with('laboratory')->orderBy('device_name')->paginate(20, ['*'], 'devices_page');
        $deviceOptions = Device::with('laboratory')->orderBy('device_name')->get();
        $reports = Report::with('device.laboratory')->where('user_id', Auth::user()->registration_no)->orderByDesc('created_at')->paginate(20, ['*'], 'reports_page');
        $laboratoryReports = Report::with('device.laboratory')->orderByDesc('created_at')->get();
        return response()->view('studentstaffdashboard.dashboard', compact(
            'labs',
            'computerLabs',
            'devices',
            'deviceOptions',
            'reports',
            'laboratoryReports'
        ))

             ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
             ->header('Pragma', 'no-cache')
             ->header('Expires', '0');
        
    }
    public function storeReport(Request $request)
    {
        $data = $request->validate([
            'device_reg_no' => 'required|exists:devices,reg_no',
            'description' => 'required|string|min:10',
        ]);
        $report = Report::create([
            'device_reg_no' => $data['device_reg_no'],
            'user_id' => Auth::user()->registration_no,
            'description' => $data['description'],
        ]);
        $report->device->syncStatusFromReports();
        return redirect()->route('studentdashboard')->with('success', 'Report submitted successfully.');
    }
    public function showReport($id)
    {
        $report = Report::with('device')->findOrFail($id);
        return view('studentstaffdashboard.show_report', compact('report'));
    }
}
