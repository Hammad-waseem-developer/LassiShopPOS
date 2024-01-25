@extends('layouts.master')

@section('main-content')
    @section('page-css')
    @endsection

    <div class="breadcrumb">
        <h1>{{ __('Office Edit') }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row" id="section_create_client">
        <div class="col-lg-12 mb-3">
            <div class="card">
                <form method="POST" action="{{ route('office.update', $office->id) }}" @submit.prevent="Update_Client()">
                    @csrf
                    @method('PUT') <!-- Use PUT or PATCH method for update -->
                    <div class="card-body">
                        <input type="hidden" name="id" value="{{ $office->id }}">
                        
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="designation">{{ __('Shift Name') }} <span
                                        class="field_required">*</span></label>
                                <input type="text" class="form-control" name="name"
                                       placeholder="{{ __('Shift Name') }}" value="{{ $office->name }}">
                                @error('name')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="designation">{{ __('Shift Time') }} <span
                                        class="field_required">*</span></label>
                                <input type="time" class="form-control" name="clock_in"
                                       value="{{ $office->clock_in }}">
                                @error('clock_in')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="designation">{{ __('Shift Time Out') }} <span
                                        class="field_required">*</span></label>
                                <input type="time" class="form-control" name="clock_out"
                                       value="{{ $office->clock_out }}">
                                @error('clock_out')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="company">{{ __('Company') }} <span class="field_required">*</span></label>
                                <!-- Use a select element for the dropdown -->
                                <select class="form-control" name="company" id="company">
                                    <!-- Add an option for the default or empty value -->
                                    <option value="" selected disabled>{{ __('Select Company') }}</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                                {{ $office->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company')
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
