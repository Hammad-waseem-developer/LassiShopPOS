<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function getData()
    {
        if (auth()->user()->can('department_view_all')) {
            $department = Department::get()->all();
            return response()->json($department);
        }
        return abort('403', __('You are not authorized'));
    }

    public function index()
    {
        if (auth()->user()->can('department_view_all')) {
            $departments = Department::all();
            return view('hrm.departments.index', compact('departments'));
        }
        return abort('403', __('You are not authorized'));
    }
    public function create()
    {
        if (auth()->user()->can('department_create')) {
            return view('hrm.departments.create');
        }
        return abort('403', __('You are not authorized'));
    }
    public function store(Request $request)
    {
        if (auth()->user()->can('department_create')) {
            $validatedData = $request->validate([
                'department_name' => 'required|string|max:255',
                'dept_head' => 'required|string|max:255',
            ]);
            $userId = auth()->id();
            Department::create([
                'user_id' => $userId,
                'name' => $validatedData['department_name'],
                'dept_head' => $validatedData['dept_head'],
            ]);
            return redirect()->route('department.index')->with('success', 'Department created successfully!');
        }
        return abort('403', __('You are not authorized'));
    }


    public function edit($id)
    {
        if (auth()->user()->can('department_edit')) {
            $department = Department::where('id', $id)->find($id);
            return view('hrm.departments.edit', compact('department'));
        }
        return abort('403', __('You are not authorized'));
    }

    public function update(Request $request, Department $department)
    {
        if (auth()->user()->can('department_edit')) {
            $validatedData = $request->validate([
                'department_name' => 'required|string|max:255',
                'dept_head' => 'required|string|max:255',
            ]);

            $department->update([
                'name' => $validatedData['department_name'],
                'dept_head' => $validatedData['dept_head'],
            ]);

            return redirect()->route('department.index')->with('success', 'Department updated successfully!');
        }
        return abort('403', __('You are not authorized'));
    }

    public function delete(Request $request)
    {
        if (auth()->user()->can('department_delete')) {
            $department = Department::findOrFail($request->id);

            if ($department) {
                $department->delete();
                return response()->json(['message' => 'Department deleted successfully'], 200);
            } else {
                return response()->json(['message' => 'Department not found'], 404);
            }
        }
        return abort('403', __('You are not authorized'));
    }
}
