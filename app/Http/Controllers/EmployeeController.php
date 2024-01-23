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

        return view('hrm.employee.index');
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
}

