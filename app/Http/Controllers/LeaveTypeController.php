<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{

    public function index()
    {
        $leaveTypes = LeaveType::all();
        return view('hrm.leavetype.index1', compact('leaveTypes'));
    }


    public function create()
    {
        return view('hrm.leavetype.create');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|string|max:200',
        ]);
        LeaveType::create($validatedData);
        return redirect()->route('leaveType.index')->with('success', 'Leave type created successfully');
    }

    // LeaveTypeController.php

    public function edit($id)
    {
        $leaveType = LeaveType::find($id);

        return view('hrm.leavetype.edit', compact('leaveType'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|max:150',
            // Add validation rules for other fields as needed
        ]);

        $leaveType = LeaveType::find($id);
        $leaveType->update($request->all());

        return redirect()->route('leaveType.index')->with('success', 'Leave type updated successfully');
    }
    public function deleteLeaveType(Request $request)
    {
        $leaveType = LeaveType::findOrFail($request->id);
        if($leaveType){
            $leaveType->delete();
            return response()->json(['message' => 'Leave type deleted successfully'], 200);
        }else{
            return response()->json(['message' => 'Leave type not found'], 404);
        }

    }

    public function getData()
    {
        $leaveTypes = LeaveType::all();
        return response()->json(['data' => $leaveTypes]);
    }
    
}
