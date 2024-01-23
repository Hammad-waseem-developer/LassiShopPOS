@extends('layouts.master')

@section('main-content')
@section('page-css')
@endsection

<div class="breadcrumb">
    <h1>{{ __('Edit Employee') }}</h1>
    {{-- <div><a href="{{ route('employee.index') }}">{{ __('Employees') }}</a></div> --}}
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row" id="section_edit_employee">
    <div class="col-lg-12 mb-3">
        <div class="card">
            <form method="POST" action="{{ route('employees.update', ['employee' => $employee->id]) }}">
                @csrf
                @method('PUT') <!-- Add this line to use the PUT method for updating -->

                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="first_name">{{ __('First Name') }} <span class="field_required">*</span></label>
                            <input type="text" class="form-control" name="first_name" placeholder="{{ __('First Name') }}" value="{{ $employee->first_name }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="last_name">{{ __('Last Name') }} <span class="field_required">*</span></label>
                            <input type="text" class="form-control" name="last_name" placeholder="{{ __('Last Name') }}" value="{{ $employee->last_name }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="phone">{{ __('Phone') }} <span class="field_required">*</span></label>
                            <input type="number" class="form-control" name="phone" placeholder="{{ __('Phone Number') }}" value="{{ $employee->phone }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="office">{{ __('Office') }} <span class="field_required">*</span></label>
                            <select class="form-control" name="office">
                                <option value="" selected disabled>{{ __('Select office') }}</option>
                                @foreach ($offices as $office)
                                    <option value="{{ $office->id }}" {{ $employee->office_id == $office->id ? 'selected' : '' }}>
                                        {{ $office->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="designation">{{ __('Designation') }} <span class="field_required">*</span></label>
                            <select class="form-control" name="designation">
                                <option value="" selected disabled>{{ __('Select Designation') }}</option>
                                @foreach ($designations as $designation)
                                    <option value="{{ $designation->id }}" {{ $employee->designation_id == $designation->id ? 'selected' : '' }}>
                                        {{ $designation->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="department">{{ __('Department') }} <span class="field_required">*</span></label>
                            <select class="form-control" name="department">
                                <option value="" selected disabled>{{ __('Select Department') }}</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" {{ $employee->department_id == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
