@extends('layouts.master')

@section('main-content')
@section('page-css')
@endsection

<div class="breadcrumb">
    <h1>{{ __('Add Designations') }}</h1>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row" id="section_create_client">
    <div class="col-lg-12 mb-3">
        <div class="card">
            <form method="POST" action="{{ route('designations.store') }}" @submit.prevent="Create_Client()">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4 {{ $errors->has('designation') ? 'has-error' : '' }}">
                            <label for="designation">{{ __('Designation Name') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" class="form-control" name="designation"
                                placeholder="{{ __('Designation Name') }}" value="{{ old('designation') }}">
                            @if ($errors->has('designation'))
                                <span class="help-block text-danger">{{ $errors->first('designation') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('department') ? 'has-error' : '' }}">
                            <label for="department">{{ __('Department') }} <span class="field_required">*</span></label>

                            <!-- Use a select element for the dropdown -->
                            <select class="form-control" name="department" id="department">
                                <!-- Add an option for the default or empty value -->
                                <option value="" selected disabled>{{ __('Select Department') }}</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ old('department') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('department'))
                                <span class="help-block text-danger">{{ $errors->first('department') }}</span>
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
