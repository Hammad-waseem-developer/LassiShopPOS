<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::get()->all();
        // return response()->json($offices);
        return view('hrm.office.index', compact('offices'));
    }
    public function create()
    {
        $companies = DB::table('company')->get();
        return view('hrm.office.create', compact('companies'));
    }

    public function store(Request $request)
    {
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
    public function printData()
    {
        $leaveTypes = Office::all();
        return response()->json(['data' => $leaveTypes]);
    }
    public function delete(Request $request)
    {
        $office = Office::findOrFail($request->id);
    
        if ($office) {
            $office->delete();
            return response()->json(['message' => 'Office Shift deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Office Shift not found'], 404);
        }
    }

    public function edit($id)
    {
        $companies = DB::table('company')->get();
        $office = Office::findOrFail($id);
        return view('hrm.office.edit', compact('office', 'companies'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'clock_in' => 'required|date_format:H:i',
        'clock_out' => 'required|date_format:H:i|after:clock_in',
        'company' => 'required|exists:company,id',
    ]);

    $office = Office::findOrFail($id);
    $office->update($request->all());

    return redirect()->route('office.index')->with('success', 'Office updated successfully');
}


}
