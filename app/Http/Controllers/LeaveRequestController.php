<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\Department;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LeaveRequestController extends Controller
{

    public function index()
    {
        return view('hrm.leaverequest.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Company::get()->all();
        $departments = Department::get()->all();
        $employees = Employee::get()->all();
        $leaveTypes = LeaveType::get()->all();
        // $leaveRequest = LeaveRequest::all();
        return view('hrm.leaverequest.create', compact('company', 'departments', 'employees', 'leaveTypes'));

    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'company' => 'required|exists:company,id',
            'employee' => 'required|exists:employee_shift,id',
            'department' => 'required|exists:departments,id',
            'leaveType' => 'required|exists:leave_type,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:0,1,2',
            'file' => 'nullable', // Assuming a maximum file size of 10MB
            'reason' => 'required|string|max:500',
        ]);

        // If validation fails, return with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle file upload if provided

        $file = $request->file;
        if ($file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move('leave_requests', $fileName, 'public');
            $filePath = $fileName;
        } else {
            $filePath = null;
        }

        // Create LeaveRequest instance and store in the database
        $leaveRequest = LeaveRequest::create([
            'company_id' => $request->input('company'),
            'emp_id' => $request->input('employee'),
            'dept_id' => $request->input('department'),
            'leave_id' => $request->input('leaveType'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'status' => $request->input('status'),
            'file_path' => $filePath,
            'reason' => $request->input('reason'),
        ]);

        // Redirect with success message or perform additional actions as needed
        return redirect()->route('leaveRequest.index')->with('success', 'Leave request created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeaveRequest  $leaveRequest
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveRequest $leaveRequest)
    {

    }

    public function edit($id)
    {
        $leaveRequest = LeaveRequest::find($id);
        $companies = Company::all();
        $employees = Employee::all();
        $departments = Department::all();
        $leaveTypes = LeaveType::all();
        return view('hrm.leaverequest.edit', compact('leaveRequest', 'companies', 'employees', 'departments', 'leaveTypes'));
    }

    public function update(Request $request, $id)
    {
        $leaveRequest = LeaveRequest::find($id);
        
        $validator = Validator::make($request->all(), [
            'company' => 'required|exists:company,id',
            'employee' => 'required|exists:employee_shift,id',
            'department' => 'required|exists:departments,id',
            'leaveType' => 'required|exists:leave_type,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:0,1,2',
            'file' => 'nullable|mimes:jpeg,png,jpg,pdf|max:10240', // Assuming a maximum file size of 10MB
            'reason' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        if ($request->new_file) {
            $file = $request->new_file;
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move('leave_requests', $fileName, 'public');
            $filePath = $fileName;
            if(!empty($request->old_file)) {
                unlink('leave_requests/' . $request->old_file);
            }
            $leaveRequest->file_path = $filePath;
        } else {
            $filePath = $request->old_file;
            $leaveRequest->file_path = $filePath;
        }

        $leaveRequest->company_id = $request->company;
        $leaveRequest->emp_id = $request->employee;
        $leaveRequest->dept_id = $request->department;
        $leaveRequest->leave_id = $request->leaveType;
        $leaveRequest->start_date = $request->start_date;
        $leaveRequest->end_date = $request->end_date;
        $leaveRequest->status = $request->status;
        
        $leaveRequest->reason = $request->reason;
        $leaveRequest->save();

        // $leaveRequest->update([
        //     'company_id' => $request->input('company'),
        //     'emp_id' => $request->input('employee'),
        //     'dept_id' => $request->input('department'),
        //     'leave_id' => $request->input('leaveType'),
        //     'start_date' => $request->input('start_date'),
        //     'end_date' => $request->input('end_date'),
        //     'status' => $request->input('status'),
        //     'file_path' => $filePath,
        //     'reason' => $request->input('reason'),
        // ]);

        return redirect()->route('leaveRequest.index')->with('success', 'Leave request updated successfully');
    }

    public function getData()
    {
        $leaveRequest = LeaveRequest::with(['employee', 'company', 'department', 'leave'])->get();
        return response()->json(['data' => $leaveRequest]);
    }


    public function deleteRequest(Request $request)
    {
        // dd($request->all());
        $leaveRequest = LeaveRequest::findOrFail($request->id);
    
        if ($leaveRequest) {
            $leaveRequest->delete();
            return response()->json(['message' => 'Holiday deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Holiday not found'], 404);
        }
    }
}
