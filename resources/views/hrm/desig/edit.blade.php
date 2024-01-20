@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ __('Edit Designation') }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row" id="section_edit_designation">
        <div class="col-lg-12 mb-3">
            <div class="card">
                <form method="POST" action="{{ route('designations.update', $designations->id) }}">
                    @csrf
                    @method('PUT') <!-- Use PUT method for update -->
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="designation_name">{{ __('Designation Name') }} <span
                                        class="field_required">*</span></label>
                                <input type="text" class="form-control" name="designation_name"
                                    placeholder="{{ __('Designation Name') }}"
                                    value="{{ old('designation_name', $designations->name) }}">
                                @error('designation_name')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="department">{{ __('Department') }} <span class="field_required">*</span></label>
                                <!-- Add dropdown for selecting department -->
                                <select class="form-control" name="department" id="department">
                                    <!-- Add an option for the default or empty value -->
                                    <option value="" selected disabled>{{ __('Select Department') }}</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department', $designations->dept_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department')
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
