@extends('layouts.master')

@section('main-content')
@section('page-css')
@endsection

<div class="breadcrumb">
    <h1>{{ __('Add Employees') }}</h1>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row" id="section_create_client">
    <div class="col-lg-12 mb-3">
        <div class="card">
            <form method="POST" action="{{ route('employees.store') }}" @submit.prevent="Create_Client()">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4 {{ $errors->has('first_name') ? 'has-error' : '' }}">
                            <label for="designation">{{ __('First Name') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" class="form-control" name="first_name"
                                placeholder="{{ __('First Name') }}" value="{{ old('first_name') }}">
                            @if ($errors->has('first_name'))
                                <span class="help-block text-danger">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('designation') ? 'has-error' : '' }}">
                            <label for="designation">{{ __('Last Name') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" class="form-control" name="last_name"
                                placeholder="{{ __('Last Name') }}" value="{{ old('last_name') }}">
                            @if ($errors->has('last_name'))
                                <span class="help-block text-danger">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('phone') ? 'has-error' : '' }}">
                            <label for="designation">{{ __('Phone') }} <span
                                    class="field_required">*</span></label>
                            <input type="number" class="form-control" name="phone"
                                placeholder="{{ __('Phone Number') }}" value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                                <span class="help-block text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('office') ? 'has-error' : '' }}">
                            <label for="office">{{ __('office') }} <span class="field_required">*</span></label>

                            <!-- Use a select element for the dropdown -->
                            <select class="form-control" name="office" id="office">
                                <!-- Add an option for the default or empty value -->
                                <option value="" selected disabled>{{ __('Select office') }}</option>
                                @foreach ($offices as $office)
                                    <option value="{{ $office->id }}"
                                        {{ old('office') == $office->id ? 'selected' : '' }}>
                                        {{ $office->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('office'))
                                <span class="help-block text-danger">{{ $errors->first('office') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('designation') ? 'has-error' : '' }}">
                            <label for="office">{{ __('Designation') }} <span class="field_required">*</span></label>

                            <!-- Use a select element for the dropdown -->
                            <select class="form-control" name="designation" id="office">
                                <!-- Add an option for the default or empty value -->
                                <option value="" selected disabled>{{ __('Select Designation') }}</option>
                                @foreach ($designations as $designations)
                                    <option value="{{ $designations->id }}"
                                        {{ old('office') == $designations->id ? 'selected' : '' }}>
                                        {{ $designations->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('office'))
                                <span class="help-block text-danger">{{ $errors->first('office') }}</span>
                            @endif
                        </div>

                        <div class="form-group col-md-4 {{ $errors->has('department') ? 'has-error' : '' }}">
                            <label for="office">{{ __('Office Shift') }} <span class="field_required">*</span></label>

                            <!-- Use a select element for the dropdown -->
                            <select class="form-control" name="department" id="office">
                                <!-- Add an option for the default or empty value -->
                                <option value="" selected disabled>{{ __('Select Department') }}</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ old('office') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('office'))
                                <span class="help-block text-danger">{{ $errors->first('office') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
