<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{

    public function index()
    {
        if (auth()->user()->can('leavetype_view-all')) {
            $leaveTypes = LeaveType::all();
            return view('hrm.leavetype.index1', compact('leaveTypes'));
        }
        return abort('403', __('You are not authorized'));
    }


    public function create()
    {
        if (auth()->user()->can('leavetype_create')) {
            return view('hrm.leavetype.create');
        }
        return abort('403', __('You are not authorized'));
    }


    public function store(Request $request)
    {
        if (auth()->user()->can('leavetype_create')) {
            $validatedData = $request->validate([
                'type' => 'required|string|max:200',
            ]);
            LeaveType::create($validatedData);
            return redirect()->route('leaveType.index')->with('success', 'Leave type created successfully');
        }
        return abort('403', __('You are not authorized'));
    }

    // LeaveTypeController.php

    public function edit($id)
    {
        if (auth()->user()->can('leavetype_edit')) {
            $leaveType = LeaveType::find($id);
            return view('hrm.leavetype.edit', compact('leaveType'));
        }
        return abort('403', __('You are not authorized'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->can('leavetype_edit')) {

            $request->validate([
                'type' => 'required|string|max:150',
                // Add validation rules for other fields as needed
            ]);

            $leaveType = LeaveType::find($id);
            $leaveType->update($request->all());

            return redirect()->route('leaveType.index')->with('success', 'Leave type updated successfully');
        }
        return abort('403', __('You are not authorized'));
    }
    public function deleteLeaveType(Request $request)
    {
        if (auth()->user()->can('leavetype_delete')) {
            $leaveType = LeaveType::findOrFail($request->id);
            if ($leaveType) {
                $leaveType->delete();
                return response()->json(['message' => 'Leave Type deleted successfully'], 200);
            } else {
                return response()->json(['message' => 'Leave Type not found'], 404);
            }
        }
        return abort('403', __('You are not authorized'));
    }

    public function getData()
    {
        if (auth()->user()->can('leavetype_view-all')) {
            $leaveTypes = LeaveType::all();
            return response()->json(['data' => $leaveTypes]);
        }
        return abort('403', __('You are not authorized'));
    }
}
