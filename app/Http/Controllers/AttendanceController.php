<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Office;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->can('attendance_view_all') || auth()->user()->can('attendance_view_own')) {
            return view('hrm.attendance.index');
        }
    }

    public function create()
    {
        if (auth()->user()->can('attendance_create')) {
            if( auth()->id() == 1){
                $employee = Employee::all();        
                $office = Office::all();
                $company = Company::all();
            }else{
            $userId = auth()->id();    
            $employee = Employee::where('user_id', $userId)->with('office')->first();        
            $office = $employee->office;
            $company = $employee->company; 
        }       
            return view('hrm.attendance.create', compact('employee', 'office', 'company'));
        }
        return abort('403', __('You are not authorized'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->can('attendance_create')) {
            $request->validate([
                'company' => 'required|exists:company,id',
                'employee' => 'required|exists:employee_shift,id',
                'shift_name' => 'required|exists:office_shift,id',
                'date' => 'required|date',
                'clock_in' => 'required|date_format:H:i',
                'clock_out' => 'date_format:H:i|after:clock_in',
            ]);
    
            // Create a new Attendance model and fill it with the form data
            $attendance = new Attendance();
            $attendance->company_id = $request->input('company');
            $attendance->emp_id = $request->input('employee');
            $attendance->office_id = $request->input('shift_name');
            $attendance->date = $request->input('date');
            $attendance->clock_in = $request->input('clock_in');
            $attendance->clock_out = $request->input('clock_out');
    
            // Save the attendance record
            $attendance->save();
    
            // Redirect to the index page or do any other necessary actions
            return redirect()->route('attendance.index')->with('success', 'Attendance record created successfully');
        }
        return abort('403', __('You are not authorized'));
    }

    public function getData()
    {
        if (auth()->user()->can('attendance_view_all')) {
            $att = Attendance::all();
            foreach ($att as $value) {
                $clockIn = Carbon::parse($value->clock_in);
                $clockOut = Carbon::parse($value->clock_out);

                if ($clockOut->lessThan($clockIn)) {
                    $clockOut->addDay();
                }

                $workDuration = $clockOut->diffInHours($clockIn);
                $value->work_duration = $workDuration;
                $value->save();
            }
            $attendance = Attendance::with(['company', 'employee', 'office'])->get();
            return response()->json(['data' => $attendance]);
        }
        if (auth()->user()->can('attendance_view_own')) {
            $att = Attendance::where('emp_id', auth()->user()->id)->get();
            foreach ($att as $value) {
                $clockIn = Carbon::parse($value->clock_in);
                $clockOut = Carbon::parse($value->clock_out);

                if ($clockOut->lessThan($clockIn)) {
                    $clockOut->addDay();
                }

                $workDuration = $clockOut->diffInHours($clockIn);
                $value->work_duration = $workDuration;
                $value->save();
            }
            $attendance = Attendance::whereHas('employee', function ($query) {
                // Add your condition on the employee table here
                $query->where('user_id', auth()->user()->id);
            })
                ->with(['company', 'employee', 'office'])->get();
            return response()->json(['data' => $attendance]);
        }
        return abort('403', __('You are not authorized'));
    }


    public function edit($id)
    {
        if (auth()->user()->can('attendance_edit') && auth()->user()->can('attendance_view_all')) {
            $company = Company::all();
            $employees = Employee::all();
            $offices = Office::all();
            $attendance = Attendance::with(['employee', 'company', 'office'])->findOrFail($id);
            return view('hrm.attendance.edit', compact('attendance', 'company', 'employees', 'offices'));
        }
        if (auth()->user()->can('attendance_edit') && auth()->user()->can('attendance_view_own')) {
            $company = Company::all();
            $employees = Employee::all();
            $offices = Office::all();
            $attendance = Attendance::with(['employee', 'company', 'office'])->findOrFail($id);
            if($attendance->employee->user_id != auth()->user()->id){
                return abort('403', __('You are not authorized'));
            }
            return view('hrm.attendance.edit', compact('attendance', 'company', 'employees', 'offices'));
        }

        return abort('403', __('You are not authorized'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->can('attendance_edit')) {
            $request->validate([
                'company' => 'exists:company,id',
                'employee' => 'exists:employee_shift,id',
                'shift_name' => 'exists:office_shift,id',
                'date' => 'required|date',
                'clock_in' => 'required|date_format:H:i',
                'clock_out' => 'date_format:H:i|after:clock_in',
            ]);

            $attendance = Attendance::findOrFail($id);
            $attendance->company_id = $request->input('company');
            $attendance->emp_id = $request->input('employee');
            $attendance->office_id = $request->input('shift_name');
            $attendance->date = $request->input('date');
            $attendance->clock_in = $request->input('clock_in');
            $attendance->clock_out = $request->input('clock_out');

            $attendance->save();

            return redirect()->route('attendance.index')->with('success', 'Attendance record updated successfully');
        }
        return abort('403', __('You are not authorized'));
    }
    public function delete(Request $request)
    {
        if (auth()->user()->can('attendance_delete')) {

            $attendance = Attendance::findOrFail($request->id);

            if ($attendance) {
                $attendance->delete();
                return response()->json(['message' => 'Attendance deleted successfully'], 200);
            } else {
                return response()->json(['message' => 'Attendance not found'], 404);
            }
        }
        return abort('403', __('You are not authorized'));
    }
}
