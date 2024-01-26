<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Models\EmployeeShift;
use Illuminate\Validation\Rule;
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
    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'first_name' => 'required|string|max:255',
    //         'last_name' => 'required|string|max:255',
    //         'phone' => 'required|numeric',
    //         'office' => 'required|exists:office_shift,id',
    //         'designation' => 'required|exists:designation,id',
    //         'department' => 'required|exists:departments,id',
    //     ]);

    //     $employee = new Employee();

    //     $employee->first_name = $validatedData['first_name'];
    //     $employee->last_name = $validatedData['last_name'];
    //     $employee->phone = $validatedData['phone'];
    //     $employee->office_id = $validatedData['office'];
    //     $employee->designation_id = $validatedData['designation'];
    //     $employee->department_id = $validatedData['department'];
    //     $employee->save();
    //     return redirect()->back()->with('success', 'Employee created successfully!');
    // }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required',
            'office' => 'required|exists:office_shift,id',
            'designation' => 'required|exists:designation,id',
            'department' => 'required|exists:departments,id',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:20',
            'family_status' => 'required',
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'employment_type' => ['nullable', Rule::in(['full_time', 'part_time', 'self_employed', 'contract', 'internship', 'seasonal'])],
            'birth_date' => 'nullable|date',
            'join_date' => 'nullable|date',
            'leaving_date' => 'nullable|date',
            'annual_leave' => 'nullable|numeric',
            'remaining_leave' => 'nullable|numeric',
            'hourly_late' => 'nullable|numeric',
            'salaray' => 'nullable|numeric',
        ]);
    
        $employee = new Employee();
    
        $employee->fill($validatedData);
        // $employee->first_name = $validatedData['first_name'];
        // $employee->last_name = $validatedData['last_name'];
        // $employee->phone = $validatedData['phone'];
        // $employee->office_id = $validatedData['office'];
        // $employee->designation_id = $validatedData['designation'];
        // $employee->department_id = $validatedData['department'];
        // $employee->email = $validatedData['email'];
        // $employee->address = $validatedData['address'];
        // $employee->country = $validatedData['country'];
        // $employee->city = $validatedData['city'];
        // $employee->province = $validatedData['province'];
        // $employee->zip = $validatedData['zip'];
        // $employee->family_status = $validatedData['family_status'];
        // $employee->gender = $validatedData['gender'];
        // $employee->employment_type = $validatedData['employment_type'];
        // $employee->birth_date = $validatedData['birth_date'];
        // $employee->join_date = $validatedData['join_date'];
        // $employee->leaving_date = $validatedData['leaving_date'];
        // $employee->annual_leave = $validatedData['annual_leave'];
        // $employee->remaining_leave = $validatedData['remaining_leave'];
        // $employee->hourly_late = $validatedData['hourly_late'];
        // $employee->salary = $validatedData['salary'];

        // Save other fields to $employee as needed

        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->phone = $request->phone;
        $employee->office_id = $request->office;
        $employee->designation_id = $request->designation;
        $employee->department_id = $request->department;
        $employee->email = $request->email;
        $employee->address = $request->address;
        $employee->country = $request->country;
        $employee->city = $request->city;
        $employee->province = $request->province;
        $employee->zip = $request->zip;
        $employee->family_status = $request->family_status;
        $employee->gender = $request->gender;
        $employee->employment_type = $request->employment_type;
        $employee->birth_date = $request->birth_date;
        $employee->join_date = $request->join_date;
        $employee->leaving_date = $request->leaving_date;
        $employee->annual_leave = $request->annual_leave;
        $employee->remaining_leave = $request->remaining_leave;
        $employee->hourly_late = $request->hourly_late;
        $employee->salary = $request->salaray;
        $employee->save();

        return redirect(route('employee.index'))->with('success', 'Employee created successfully!');
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
        return redirect(route('employee.index'))->with('success', 'Employee updated successfully');
    }

    public function deleteEmployee(Request $request)
    {
        $employee = Employee::findOrFail($request->id);

        if ($employee) {
            $employee->delete();
            return response()->json(['message' => 'Employee deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Employee not found'], 404);
        }
    }
}

