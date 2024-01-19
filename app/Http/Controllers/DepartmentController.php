<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    // DepartmentController.php



    public function getData(Request $request)
    {
        $departments = Department::all();
        if ($departments->count() > 0) {
            return response()->json(
                [
                    'departments' => $departments,
                ]
            );
        }
    }

    public function AjaxGetData(Request $request)
    {
        $departments = Department::all();
        if ($departments->count() > 0) {
            return response()->json(
                [
                    'departments' => $departments,
                ]
            );
        }
    }

    public function index()
    {
        $departments = Department::all();
        return view('hrm.departments.index', compact('departments'));

        //  return view('hrm.departments.index');
    }
    public function create()
    {
        return view('hrm.departments.create');
    }
    public function store(Request $request)
    {
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


    public function edit(Department $department)
    {
        //  dd($department);
        return view('hrm.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
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

    // In your controller method


    // DepartmentController.php

    public function delete($id)
    {
        try {
            $department = Department::findOrFail($id);
            $department->delete();

            return response()->json(['message' => 'Department deleted successfully']);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            \Log::error('Error deleting department: ' . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function show($id)
    {
        $department = Department::findOrFail($id);
        return view('hrm.departments.show', compact('department'));

    }







}
