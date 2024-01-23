<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = Employee::all();
        return view('hrm.employee.index', compact('employee'));
    }

    public function create()
    {
        $company = DB::table('company')->get()->all();
        $departments = Department::get()->all();
        $designations = Designation::get()->all();
        $offices = Office::get()->all();

        return view('hrm.employee.create', compact('company', 'departments', 'designations', 'offices'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'office' => 'required|exists:office_shift,id',
            'designation' => 'required|exists:designation,id',
            'department' => 'required|exists:departments,id',
        ]);

        $employee = new Employee();

        $employee->first_name = $validatedData['first_name'];
        $employee->last_name = $validatedData['last_name'];
        $employee->phone = $validatedData['phone'];
        $employee->office_id = $validatedData['office'];
        $employee->designation_id = $validatedData['designation'];
        $employee->department_id = $validatedData['department'];
        $employee->save();
        return redirect()->back()->with('success', 'Employee created successfully!');
    }

    public function getData()
    {
        $employees = Employee::with(['office', 'designation', 'department'])->get();
        return response()->json(['data' => $employees]);
    }

 /**
     * Show the form for editing the specified employee.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = DB::table('company')->get()->all();
        $departments = Department::get()->all();
        $designations = Designation::get()->all();
        $offices = Office::get()->all();
        $employee = Employee::findOrFail($id);

        // You can pass the $employee data to the view or perform any other actions here
        return view('hrm.employee.edit', compact('employee', 'company', 'departments', 'designations', 'offices'));
    }
    public function update(Request $request, Employee $employee)
{
   
    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone' => 'required|numeric',
        'office' => 'required|exists:office_shift,id',
        'designation' => 'required|exists:designation,id',
        'department' => 'required|exists:departments,id',
    ]);

    $employee->update($validatedData);
    return redirect()->back()->with('success', 'Employee updated successfully');
}

public function deleteEmployee($id)
{
    try {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(['success' => true, 'message' => 'Employee deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error deleting employee']);
    }
}
}

