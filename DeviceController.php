<?php
namespace App\Http\Controllers;
use App\Models\Device;
use App\Models\Laboratory;
use App\Models\Report;
use Illuminate\Http\Request;
class DeviceController extends Controller
{
    public function deviceview()
    {    
        $this->checklogin();
        $laboratories = Laboratory::all();
        return view('registration.device', compact('laboratories'));
    }
    public function Device(Request $request)
    {
        $request->validate([
            'reg_no' => 'required|unique:devices,reg_no',
            'device_name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'block_code' => 'required|exists:laboratories,block_code',
        ]);
        Device::create($request->only(['reg_no', 'device_name', 'brand', 'block_code']));
        return $this->redirectAfterRegistration($request, 'Device registered successfully!');
    }

    public function statuses()
    {
        $this->checklogin();

        return response()->json([
            'devices' => Device::pluck('status', 'reg_no'),
            'reports' => Report::pluck('status', 'id'),
        ])->header('Cache-Control', 'no-store');
    }
}
