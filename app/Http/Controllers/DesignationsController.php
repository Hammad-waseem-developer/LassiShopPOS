<?php

namespace App\Http\Controllers;

use Log;
use DataTables;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;


class DesignationsController extends Controller
{
    public function index()
    {
        if (auth()->user()->can('designation_view_all')) {
            $designations = Designation::with('department')->first();
            return view('hrm.desig.index1', compact('designations'));
        }
        return abort('403', __('You are not authorized'));
    }
    public function create()
    {
        if (auth()->user()->can('designation_create')) {
            $departments = Department::all();
            return view("hrm.desig.create", compact("departments"));
        }
        return abort('403', __('You are not authorized'));
    }
    public function store(Request $request)
    {
        if (auth()->user()->can('designation_create')) {
            $validatedData = $request->validate([
                'designation' => 'required|string|max:255',
                'department' => 'required|string|max:255', // Corrected field name
            ]);

            $userId = auth()->id();
            Designation::create([
                'user_id' => $userId,
                'name' => $validatedData['designation'],
                'dept_id' => $validatedData['department'], // Corrected field name
            ]);

            return redirect()->route('designations.index')->with('success', 'Designation created successfully!');
        }
        return abort('403', __('You are not authorized'));
    }

    public function edit($id)
    {
        if (auth()->user()->can('designation_edit')) {
            $designations = Designation::with('department')->find($id);
            $departments = Department::all();
            return view("hrm.desig.edit", compact("designations", "departments"));
        }
        return abort('403', __('You are not authorized'));
    }

    public function update(Request $request, Designation $designation)
    {
        if (auth()->user()->can('designation_edit')) {
            $validatedData = $request->validate([
                'designation_name' => 'required|string|max:255',
                'department' => 'required|exists:departments,id', // Ensure the selected department exists
            ]);

            // Update the designation with the validated data
            $designation->update([
                'name' => $validatedData['designation_name'],
                'dept_id' => $validatedData['department'],
            ]);

            return redirect()->route('designations.index')->with('success', 'Designation updated successfully!');
        }
        return abort('403', __('You are not authorized'));
    }

    public function getData()
    {
        if (auth()->user()->can('designation_view_all')) {
            $designations = Designation::with('department')->get();
            return response()->json($designations);
        }
        return abort('403', __('You are not authorized'));
    }

    public function delete(Request $request)
    {
        if (auth()->user()->can('designation_delete')) {
            $office = Designation::findOrFail($request->id);

            if ($office) {
                $office->delete();
                return response()->json(['message' => 'Designation deleted successfully'], 200);
            } else {
                return response()->json(['message' => 'Designation not found'], 404);
            }
        }
        return abort('403', __('You are not authorized'));
    }
}
