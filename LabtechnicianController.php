<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laboratory;
use App\Models\Device;
use App\Models\Report;
class LabtechnicianController extends Controller
{ public function dashboard()
    {
        $this->checklogin();
        $labsCount = Laboratory::count();
        $devicesCount = Device::count();
        $reportsCount = Report::count();
        $labs = Laboratory::with('device')->orderBy('block_name')->get();
        $devices = Device::with('laboratory')->orderBy('device_name')->get();
        $reports = Report::with('device.laboratory')
    ->get()
    ->filter(fn($report) => $report->device !== null)
    ->values();
        return response()-> view('labtechniciandashboard.dashboard', compact(
            'labsCount',
            'devicesCount',
            'reportsCount',
            'labs',
            'devices',
            'reports'
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
        return redirect()->route('labtechniciandashboard')->with('success', 'Report created successfully.');
    }
    public function showReport($id)
    {
        $report = Report::with('device', 'user')->findOrFail($id);
        return view('labtechniciandashboard.show_report', compact('report'));
    }

    public function downloadReportedDevices()
    {
        $this->checklogin();

        return response()->streamDownload(function () {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Device registration no.', 'Device', 'Laboratory', 'Description', 'Reported on', 'Status']);

            Report::with('device.laboratory')->orderByDesc('created_at')->cursor()->each(function (Report $report) use ($output) {
                fputcsv($output, [
                    $report->device_reg_no,
                    $report->device->device_name ?? 'N/A',
                    $report->device->laboratory->block_name ?? 'N/A',
                    $report->description,
                    $report->created_at->format('Y-m-d H:i'),
                    $report->status,
                ]);
            });

            fclose($output);
        }, 'reported-devices.csv', ['Content-Type' => 'text/csv']);
    }

    public function toggleReportStatus($id)
    {
        $this->checklogin();

        $report = Report::findOrFail($id);
        $report->status = $report->status === 'Resolved' ? 'Faulty' : 'Resolved';
        $report->save();
        $report->device->syncStatusFromReports();

        return redirect()->back()->with('success', 'Report status updated successfully.');
    }

    public function destroyDevice($id)
    {
        $this->ensureTechnician();
        $device = Device::findOrFail($id);
        $device->delete();
        return redirect()->route('labtechniciandashboard')->with('success', 'Device deleted successfully.');
    }

    public function editDevice($id)
    {
        $this->ensureTechnician();
        $device = Device::findOrFail($id);

        return view('labtechniciandashboard.edit_device', compact('device'));
    }

    public function updateDevice(Request $request, $id)
    {
        $this->ensureTechnician();
        $device = Device::findOrFail($id);
        $data = $request->validate([
            'device_name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'block_code' => 'required|string|exists:laboratories,block_code',
        ]);
        $device->update($data);

        return redirect()->route('labtechniciandashboard')->with('success', 'Device updated successfully.');
    }

    private function ensureTechnician(): void
    {
        abort_unless(Auth::user()?->role === 'lab_technician', 403);
    }
}
