<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Laboratory;
class LaboratoryController extends Controller
{
public function laboratoryview(){
    $this->checklogin();
    return view('registration.laboratory');
}
     public function Laboratory(Request $request){
        $lab=$request->validate([
            'block_code'=>'required|string|max:255|unique:laboratories,block_code',
            'block_name'=>'required|string|max:255',
            'capacity'=>'required|integer|min:1'
        ]);
        Laboratory::create($lab);
        return $this->redirectAfterRegistration($request, 'Laboratory registered successfully!');
     }

    // Display all laboratories
    public function index()
    {
        $laboratories = Laboratory::all();

        return view('laboratories.index', compact('laboratories'));
    }

    // Display devices of a specific laboratory
    public function show($block_code)
    {
        $laboratory = Laboratory::where('block_code', $block_code)
                                ->firstOrFail();

        $devices = Device::where('block_code', $block_code)->get();

        return view(
            'laboratories.show',
            compact('laboratory', 'devices')
        );

        
    }

    public function toggleReportStatus($id)
{
    $report = Report::findOrFail($id);

    if ($report->status == 'Faulty') {
        $report->status = 'Resolved';
    } else {
        $report->status = 'Faulty';
    }

    $report->save();

    return redirect()->route('admindashboard')->with('success', 'Report status updated successfully.');
}
}

     
