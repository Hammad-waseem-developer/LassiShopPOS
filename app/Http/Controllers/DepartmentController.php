<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
   
    public function getData()
    {
        $department = Department::get()->all();
     
        return response()->json($department);
        
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


    public function edit($id)
    { 
        $department = Department::where('id', $id)->find($id);
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

    public function delete(Request $request)
    {
        $department = Department::findOrFail($request->id);
    
        if ($department) {
            $department->delete();
            return response()->json(['message' => 'Department deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Department not found'], 404);
        }
    }

    // public function show($id)
    // {
    //     $department = Department::findOrFail($id);
    //     return view('hrm.departments.show', compact('department'));

    // }

}
