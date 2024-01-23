@extends('layouts.master')

@section('main-content')
    @section('page-css')
    @endsection
    <div class="breadcrumb">
        <h1>{{ __('Attendance Edit') }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row" id="section_create_client">
        <div class="col-lg-12 mb-3">
            <div class="card">
                <form method="POST" action="{{ route('attendance.store') }}" @submit.prevent="Create_Client()">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="company">{{ __('Company') }} <span class="field_required">*</span></label>
                                <!-- Use a select element for the dropdown -->
                                <select class="form-control" name="company" id="company">
                                    <!-- Add an option for the default or empty value -->
                                    <option value="" selected disabled>{{ __('Select Company') }}</option>
                                    @foreach ($company as $company)
                                        <option value="{{$company->id}}"
                                        {{ $company->id == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="employee">{{ __('Employee') }} <span class="field_required">*</span></label>
                                <!-- Use a select element for the dropdown -->
                                <select class="form-control" name="employee" id="employee">
                                    <!-- Add an option for the default or empty value -->
                                    <option value="" selected disabled>{{ __('Select Employee') }}</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ $employee->id == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->first_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="shift_name">{{ __('Shift Name') }} <span class="field_required">*</span></label>
                                <!-- Use a select element for the dropdown -->
                                <select class="form-control" name="shift_name" id="shift_name">
                                    <!-- Add an option for the default or empty value -->
                                    <option value="" selected disabled>{{ __('Select Shift Name') }}</option>
                                    @foreach ($offices as $office)
                                    <option value="{{ $office->id }}" {{ $employee->office_id == $office->id ? 'selected' : '' }}>
                                        {{ $office->name }}
                                    </option>
                                @endforeach
                                </select>
                                @error('office')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>                      
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="designation">{{ __('Date') }} <span
                                        class="field_required">*</span></label>
                                <input type="date" class="form-control" name="date"
                                       value="{{ $attendance->date }}">
                                @error('date')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        <div class="form-group col-md-4">
                            <label for="clock_in">{{ __('Clock In') }} <span
                                    class="field_required">*</span></label>
                            <input type="time" class="form-control" name="clock_in"
                                   value="{{ $attendance->clock_in }}">
                            @error('clock_in')
                                <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                            <div class="form-group col-md-4">
                                <label for="clock_out">{{ __('Clock Out') }} <span
                                        class="field_required">*</span></label>
                                <input type="time" class="form-control" name="clock_out"
                                       value="{{ $attendance->clock_out }}">
                                @error('clock_out')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
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
