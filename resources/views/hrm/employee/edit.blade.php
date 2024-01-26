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
                            <input type="text" class="form-control" name="first_name"
                                placeholder="{{ __('First Name') }}" value="{{ $employee->first_name }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="last_name">{{ __('Last Name') }} <span class="field_required">*</span></label>
                            <input type="text" class="form-control" name="last_name"
                                placeholder="{{ __('Last Name') }}" value="{{ $employee->last_name }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="phone">{{ __('Phone') }} <span class="field_required">*</span></label>
                            <input type="number" class="form-control" name="phone"
                                placeholder="{{ __('Phone Number') }}" value="{{ $employee->phone }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="office">{{ __('Office') }} <span class="field_required">*</span></label>
                            <select class="form-control" name="office">
                                <option value="" selected disabled>{{ __('Select office') }}</option>
                                @foreach ($offices as $office)
                                    <option value="{{ $office->id }}"
                                        {{ $employee->office_id == $office->id ? 'selected' : '' }}>
                                        {{ $office->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="designation">{{ __('Designation') }} <span
                                    class="field_required">*</span></label>
                            <select class="form-control" name="designation">
                                <option value="" selected disabled>{{ __('Select Designation') }}</option>
                                @foreach ($designations as $designation)
                                    <option value="{{ $designation->id }}"
                                        {{ $employee->designation_id == $designation->id ? 'selected' : '' }}>
                                        {{ $designation->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="department">{{ __('Department') }} <span
                                    class="field_required">*</span></label>
                            <select class="form-control" name="department">
                                <option value="" selected disabled>{{ __('Select Department') }}</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ $employee->department_id == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4 {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email">{{ __('Email Address') }} <span
                                    class="field_required">*</span></label>
                            <input type="email" class="form-control" name="email"
                                placeholder="{{ __('Email Address') }}" value="{{ $employee->email }}">

                            @if ($errors->has('email'))
                                <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('address') ? 'has-error' : '' }}">
                            <label for="address">{{ __('Address') }} <span class="field_required">*</span></label>
                            <input type="text" class="form-control" name="address" placeholder="{{ __('Address') }}"
                                value="{{ $employee->address }}">
                            @if ($errors->has('address'))
                                <span class="help-block text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('country') ? 'has-error' : '' }}">
                            <label for="country">{{ __('Country') }} <span class="field_required">*</span></label>
                            <input type="text" class="form-control" name="country" placeholder="{{ __('Country') }}"
                                value="{{ $employee->country }}">
                            @if ($errors->has('country'))
                                <span class="help-block text-danger">{{ $errors->first('country') }}</span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 {{ $errors->has('city') ? 'has-error' : '' }}">
                                <label for="City">{{ __('City') }} <span class="field_required">*</span></label>
                                <input type="text" class="form-control" name="city"
                                    placeholder="{{ __('City') }}" value="{{ $employee->city }}">
                                @if ($errors->has('city'))
                                    <span class="help-block text-danger">{{ $errors->first('city') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('province') ? 'has-error' : '' }}">
                                <label for="province">{{ __('Province') }} <span
                                        class="field_required">*</span></label>
                                <input type="text" class="form-control" name="province"
                                    placeholder="{{ __('province') }}" value="{{ $employee->province }}">
                                @if ($errors->has('province'))
                                    <span class="help-block text-danger">{{ $errors->first('province') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('zip') ? 'has-error' : '' }}">
                                <label for="zip">{{ __('Zip') }} <span
                                        class="field_required">*</span></label>
                                <input type="number" class="form-control" name="zip"
                                    placeholder="{{ __('Zip') }}" value="{{ $employee->zip }}">
                                @if ($errors->has('zip'))
                                    <span class="help-block text-danger">{{ $errors->first('zip') }}</span>
                                @endif
                            </div>
                        </div>
             
                        <div class="row">
                            <div class="form-group col-md-4 {{ $errors->has('family_status') ? 'has-error' : '' }}">
                                <label for="family_status">{{ __('Family Status') }} <span
                                        class="field_required">*</span></label>

                                <!-- Use a select element for the dropdown -->
                                <select class="form-control" name="family_status" id="family_status">
                                    <!-- Add options for the family status -->
                                    <option value="" {{ $employee->family_status == '1' ? 'selected' : '' }}>
                                        {{ __('Married') }}

                                    </option>
                                    <option value="2" {{ $employee->family_status == '2' ? 'selected' : '' }}>
                                        {{ __('Divorced') }}
                                    </option>
                                    <option value="0" {{ $employee->family_status == '0' ? 'selected' : '' }}>
                                        {{ __('Single') }}
                                    </option>
                                </select>

                                @if ($errors->has('family_status'))
                                    <span class="help-block text-danger">{{ $errors->first('family_status') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-4 {{ $errors->has('gender') ? 'has-error' : '' }}">
                                <label for="gender">{{ __('Gender') }} <span
                                        class="field_required">*</span></label>

                                <!-- Use a select element for the dropdown -->
                                <select class="form-control" name="gender" id="gender">
                                    <!-- Add options for gender -->
                                    <option value="male" {{ $employee->gender == 'male' ? 'selected' : '' }}>
                                        {{ __('Male') }}
                                    </option>
                                    <option value="female" {{ $employee->gender == 'female' ? 'selected' : '' }}>
                                        {{ __('Female') }}
                                    </option>
                                </select>

                                @if ($errors->has('gender'))
                                    <span class="help-block text-danger">{{ $errors->first('gender') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('employment_type') ? 'has-error' : '' }}">
                                <label for="employment_type">{{ __('Employment Type') }} <span
                                        class="field_required">*</span></label>

                                <!-- Use a select element for the dropdown -->
                                <select class="form-control" name="employment_type" id="employment_type">
                                    <!-- Add options for employment type -->
                                    <option value="full_time"
                                    {{ $employee->employment_type == 'full_time' ? 'selected' : '' }}>
                                        {{ __('Full Time') }}
                                    </option>
                                    <option value="part_time"
                                    {{ $employee->employment_type == 'part_time' ? 'selected' : '' }}>
                                        {{ __('Part Time') }}
                                    </option>
                                    <option value="self_employed"
                                    {{ $employee->employment_type == 'self_employed' ? 'selected' : '' }}>
                                        {{ __('Self Employed') }}
                                    </option>
                                    <option value="contract"
                                    {{ $employee->employment_type == 'contract' ? 'selected' : '' }}>
                                        {{ __('Contract') }}
                                    </option>
                                    <option value="internship"
                                    {{ $employee->employment_type == 'internship' ? 'selected' : '' }}>
                                        {{ __('Internship') }}
                                    </option>
                                    <option value="seasonal"
                                    {{ $employee->employment_type == 'seasonal' ? 'selected' : '' }}>
                                        {{ __('Seasonal') }}
                                    </option>
                                </select>

                                @if ($errors->has('employment_type'))
                                    <span
                                        class="help-block text-danger">{{ $errors->first('employment_type') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 {{ $errors->has('birth_date') ? 'has-error' : '' }}">
                                <label for="birth_date">{{ __('Birth Date') }} <span
                                        class="field_required">*</span></label>
                                <input type="date" class="form-control" name="birth_date"
                                    placeholder="{{ __('Birth Date') }}" value="{{ $employee->birth_date}}">
                                @if ($errors->has('birth_date'))
                                    <span class="help-block text-danger">{{ $errors->first('birth_date') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('join_date') ? 'has-error' : '' }}">
                                <label for="join_date">{{ __('Joining Date') }} <span
                                        class="field_required">*</span></label>
                                <input type="date" class="form-control" name="join_date"
                                    placeholder="{{ __('Joining Date') }}" value="{{ $employee->join_date}}">
                                @if ($errors->has('join_date'))
                                    <span class="help-block text-danger">{{ $errors->first('join_date') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('leaving_date') ? 'has-error' : '' }}">
                                <label for="leaving_date">{{ __('Leaving Date') }} <span
                                        class="field_required">*</span></label>
                                <input type="date" class="form-control" name="leaving_date"
                                    placeholder="{{ __('Leaving Date') }}" value="{{ $employee->leaving_date}}">
                                @if ($errors->has('leaving_date'))
                                    <span class="help-block text-danger">{{ $errors->first('leaving_date') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4 {{ $errors->has('annual_leave') ? 'has-error' : '' }}">
                                <label for="annual_leave">{{ __('Annual Leave') }} <span
                                        class="field_required">*</span></label>
                                <input type="number" class="form-control" name="annual_leave"
                                    placeholder="{{ __('annual_leave') }}" value="{{ $employee->annual_leave}}">
                                @if ($errors->has('annual_leave'))
                                    <span class="help-block text-danger">{{ $errors->first('annual_leave') }}</span>
                                @endif
                            </div>
                            <div
                                class="form-group col-md-4 {{ $errors->has('remaining_leave') ? 'has-error' : '' }}">
                                <label for="remaining_leave">{{ __('Remaining Leave') }} <span
                                        class="field_required">*</span></label>
                                <input type="number" class="form-control" name="remaining_leave"
                                    placeholder="{{ __('remaining_leave') }}"
                                    value="{{ $employee->remaining_leave}}">
                                @if ($errors->has('remaining_leave'))
                                    <span
                                        class="help-block text-danger">{{ $errors->first('remaining_leave') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('hourly_late') ? 'has-error' : '' }}">
                                <label for="hourly_late">{{ __('Hourly Late') }} <span
                                        class="field_required">*</span></label>
                                <input type="number" class="form-control" name="hourly_late"
                                    placeholder="{{ __('hourly_late') }}" value="{{ $employee->hourly_late}}">
                                @if ($errors->has('hourly_late'))
                                    <span class="help-block text-danger">{{ $errors->first('hourly_late') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 {{ $errors->has('salaray') ? 'has-error' : '' }}">
                                <label for="salaray">{{ __('Salaray') }} <span
                                        class="field_required">*</span></label>
                                <input type="number" class="form-control" name="salaray"
                                    placeholder="{{ __('salaray') }}" value="{{ $employee->salary}}">
                                @if ($errors->has('salaray'))
                                    <span class="help-block text-danger">{{ $errors->first('salaray') }}</span>
                                @endif
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
