@extends('layouts.master')

@section('main-content')
    @section('page-css')
    @endsection

    <div class="breadcrumb">
        <h1>{{ __('Office Create') }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row" id="section_create_client">
        <div class="col-lg-12 mb-3">
            <div class="card">
                <form method="POST" action="{{ route('office.store') }}" @submit.prevent="Create_Client()">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="designation">{{ __('Shift Name') }} <span
                                        class="field_required">*</span></label>
                                <input type="text" class="form-control" name="name"
                                       placeholder="{{ __('Shift Name') }}" value="{{ old('name') }}">
                                @error('name')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="designation">{{ __('Shift Time') }} <span
                                        class="field_required">*</span></label>
                                <input type="time" class="form-control" name="clock_in"
                                       value="{{ old('clock_in') }}">
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
                                       value="{{ old('clock_out') }}">
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
                                                {{ old('company') == $company->id ? 'selected' : '' }}>
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
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
