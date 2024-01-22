<?php

namespace App\Http\Controllers;

use Log;
use DataTables;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;


class DesignationsController extends Controller
{
    public function index()
    {
      $designations = Designation::with('department')->first();
        return view('hrm.desig.index', compact('designations'));
    }
    public function create()
    {
        $departments = Department::all();
        return view("hrm.desig.create",compact("departments"));

    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'designation' => 'required|string|max:255',
            'department' => 'required|string|max:255', // Corrected field name
        ]);
    
        $userId = auth()->id();
        Designation::create([
            'user_id' => $userId,
            'name' => $validatedData['designation'],
            'dept_id' => $validatedData['department'], // Corrected field name
        ]);
    
        return redirect()->route('designations.index')->with('success', 'Designation created successfully!');
    }

    public function edit($designations){
        $designations = Designation::with('department')->find($designations);
        $departments = Department::all();
        return view("hrm.desig.edit",compact("designations","departments"));
    }

    public function update(Request $request, Designation $designation)
{
    $validatedData = $request->validate([
        'designation_name' => 'required|string|max:255',
        'department' => 'required|exists:departments,id', // Ensure the selected department exists
    ]);

    // Update the designation with the validated data
    $designation->update([
        'name' => $validatedData['designation_name'],
        'dept_id' => $validatedData['department'],
    ]);

    return redirect()->route('designations.index')->with('success', 'Designation updated successfully!');
}
// public function show()
// {
//     $designations = Designation::with('department')->get();
//     return view('hrm.desig.index', compact('designations'));
// }

// public function getData(Request $request)
// {
//     if ($request->ajax()) {
//         $data = Designation::select(['id', 'name', 'dept_head']);

//         return DataTables::of($data)
//             ->addColumn('action', function ($row) {
//                 // You can customize the action column as needed
//                 return '<a href="' . route('designations.edit', $row->id) . '" class="btn btn-primary">Edit</a>';
//             })
//             ->make(true);
//     }

//     return abort(403, 'Unauthorized');
// }

public function getData()
{
    $designations = Designation::with('department')->get();
 
    return response()->json($designations);
    
}

public function delete($id)
{
    try {
        $designation = Designation::findOrFail($id);
        $designation->delete();

        return response()->json(['message' => 'Designation deleted successfully']);
    } catch (\Exception $e) {
        // Log the error for debugging purposes
        Log::error('Error deleting designation: ' . $e->getMessage());

        // Return an error response
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}
}
