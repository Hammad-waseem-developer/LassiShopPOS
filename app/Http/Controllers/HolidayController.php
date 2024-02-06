<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Holiday;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->can('holiday_view_all')) {
            return view('hrm.holiday.index');
        }
        return abort('403', __('You are not authorized'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->can('holiday_create')) {
            $company = Company::get()->all();
            return view('hrm.holiday.create', compact('company'));
        }
        return abort('403', __('You are not authorized'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->can('holiday_create')) {
            $validator = Validator::make($request->all(), [
                'company_id' => 'required|exists:company,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'title' => 'required|string|max:255',
                'status' => 'required|in:0,1,2',
                'details' => 'required|string|max:500',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            Holiday::create([
                'company_id' => $request->input('company_id'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'name' => $request->input('title'),
                'status' => $request->input('status'),
                'details' => $request->input('details'),
            ]);
            return redirect()->route('holiday.index')->with('success', 'Holiday created successfully');
        }
        return abort('403', __('You are not authorized'));
    }

    public function getData()
    {
        if (auth()->user()->can('holiday_view_all')) {
            $leaveRequest = Holiday::with(['company'])->get();
            return response()->json(['data' => $leaveRequest]);
        }
        return abort('403', __('You are not authorized'));
    }


    public function edit($id)
    {
        if (auth()->user()->can('holiday_edit')) {
            $holiday = Holiday::get()->find($id);
            $company = Company::get()->all();
            if (!$holiday) {
                // Handle the case where the holiday is not found, for example, redirect to index page
                return redirect()->route('holiday.index')->with('error', 'Holiday not found');
            }
            return view('hrm.holiday.edit', compact('holiday', 'company'));
        }
        return abort('403', __('You are not authorized'));
    }


    public function update(Request $request, $id)
    {
        if (auth()->user()->can('holiday_edit')) {
            $holiday = Holiday::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'company_id' => 'required|exists:company,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'title' => 'required|string|max:255',
                'status' => 'required|in:0,1,2',
                'details' => 'required|string|max:500',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors([$validator->errors()->first()])->withInput();
            }

            $holiday->update([
                'company_id' => $request->input('company_id'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'name' => $request->input('title'),
                'status' => $request->input('status'),
                'details' => $request->input('details'),
            ]);

            return redirect()->route('holiday.index')->with('success', 'Holiday updated successfully');
        }
        return abort('403', __('You are not authorized'));
    }

    public function deleteholiday(Request $request)
    {
        if (auth()->user()->can('holiday_delete')) {
            $holiday = Holiday::findOrFail($request->id);

            if ($holiday) {
                $holiday->delete();
                return response()->json(['message' => 'Holiday deleted successfully'], 200);
            } else {
                return response()->json(['message' => 'Holiday not found'], 404);
            }
        }
        return abort('403', __('You are not authorized'));
    }
}
