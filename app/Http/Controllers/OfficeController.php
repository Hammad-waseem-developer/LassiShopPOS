<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
{
    public function index()
    {
        if (auth()->user()->can('office_view_all')) {
            $offices = Office::get()->all();
            return view('hrm.office.index', compact('offices'));
        }
        return abort('403', __('You are not authorized'));
    }
    public function create()
    {
        if (auth()->user()->can('office_create')) {
            $companies = DB::table('company')->get();
            return view('hrm.office.create', compact('companies'));
        }
        return abort('403', __('You are not authorized'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->can('office_create')) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'clock_in' => 'required|string',
                'clock_out' => 'required|string',
                'company' => 'required|exists:company,id',
            ]);
            $office = new Office();
            $office->name = $validatedData['name'];
            $office->clock_in = $validatedData['clock_in'];
            $office->clock_out = $validatedData['clock_out'];
            $office->company_id = $validatedData['company'];
            $office->save();
            return redirect(route('office.index'))->with('success', 'Office created successfully!');
        }
        return abort('403', __('You are not authorized'));
    }
    public function printData()
    {
        $leaveTypes = Office::all();
        return response()->json(['data' => $leaveTypes]);
    }
    public function delete(Request $request)
    {
        if (auth()->user()->can('office_delete')) {
            $office = Office::findOrFail($request->id);
            if ($office) {
                $office->delete();
                return response()->json(['message' => 'Office Shift deleted successfully'], 200);
            } else {
                return response()->json(['message' => 'Office Shift not found'], 404);
            }
        }
        return abort('403', __('You are not authorized'));
    }

    public function edit($id)
    {
        if (auth()->user()->can('office_edit')) {
            $companies = DB::table('company')->get();
            $office = Office::findOrFail($id);
            return view('hrm.office.edit', compact('office', 'companies'));
        }
        return abort('403', __('You are not authorized'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->can('office_edit')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'clock_in' => 'required|date_format:H:i',
                'clock_out' => 'required',
                'company' => 'required|exists:company,id',
            ]);
            $office = Office::findOrFail($id);
            $office->update($request->all());

            return redirect()->route('office.index')->with('success', 'Office updated successfully');
        }
        return abort('403', __('You are not authorized'));
    }
}
