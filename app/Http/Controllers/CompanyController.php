<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Session;

class CompanyController extends Controller
{
    public function index()
    {
        if (auth()->user()->can('company_view_all')) {
            return view('hrm.company.index');
        }
        return abort('403', __('You are not authorized'));
    }

    public function create()
    {
        if (auth()->user()->can('company_create')) {
            return view('hrm.company.create');
        }
        return abort('403', __('You are not authorized'));
    }
    public function store(Request $request)
    {
        if (auth()->user()->can('company_create')) {
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
        return abort('403', __('You are not authorized'));
    }

    public function edit($id)
    {
        if (auth()->user()->can('company_edit')) {
            $company = Company::findOrFail($id);
            return view('hrm.company.edit', compact('company'));
        }
        return abort('403', __('You are not authorized'));
    }
    public function update(Request $request, $id)
    {
        if (auth()->user()->can('company_edit')) {
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
        return abort('403', __('You are not authorized'));
    }
    public function getData()
    {
        $company = Company::get()->all();

        return response()->json($company);
    }
    public function delete(Request $request)
    {
        if (auth()->user()->can('company_delete')) {
            $company = Company::findOrFail($request->id);

            if ($company) {
                $company->delete();
                return response()->json(['message' => 'Company deleted successfully'], 200);
            } else {
                return response()->json(['message' => 'Company not found'], 404);
            }
        }
        return abort('403', __('You are not authorized'));
    }
}
