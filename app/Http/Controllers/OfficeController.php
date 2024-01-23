<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
{
    public function index()
    {       $offices = Office::get()->all();
            // return response()->json($offices);
        return view('hrm.office.index' , compact('offices'));
    }
    public function create()
    {
        $companies = DB::table('company')->get();
        return view('hrm.office.create', compact('companies'));
    }

    // public function store()
    // {dd('dsadsad');
    //     return view('hrm.office.edit');
    // }

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
        return redirect()->back()->with('success', 'Office created successfully!');
    }
    public function getOffice()
    {
        $offices = Office::get();
        return response()->json($offices);
    }
    public function show()
    {

    }
}
