<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Session;
class CompanyController extends Controller
{
    public function index()
    {
        return view('hrm.company.index');
    }
    
    public function create()
    {
        return view('hrm.company.create');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|max:200',
            'country' => 'required|string|max:200',
        ]);
        $userId = auth()->id();
        Company::create([
            'user_id' => $userId,
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'country' => $validatedData['country'],
        ]);
        return redirect()->route('company.index')->with('success', 'Company created successfully!');
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('hrm.company.edit', compact('company'));
    }
    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'country' => 'required|string|max:255',
    ]);

    $company = Company::findOrFail($id);
    $company->update($validatedData);
    return redirect()->route('company.index')->with('success', 'Company updated successfully!');
}
public function getData()
{
    $company = Company::get()->all();
 
    return response()->json($company);
    
}
public function delete(Request $request)
    {
        $company = Company::findOrFail($request->id);
    
        if ($company) {
            $company->delete();
            return response()->json(['message' => 'Company deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Company not found'], 404);
        }
    }

}
