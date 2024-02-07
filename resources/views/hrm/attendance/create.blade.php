@extends('layouts.master')

@section('main-content')
    @section('page-css')
    @endsection
    <div class="breadcrumb">
        <h1>{{ __('Attendance Create') }}</h1>
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
                                <input type="text" class="form-control" value="{{ $office->company->name }}" readonly>
                                <input type="hidden" name="company" value="{{ $office->company->id }}">
                                @error('company')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="employee">{{ __('Employee') }} <span class="field_required">*</span></label>
                                <input type="text" class="form-control" value="{{ $employee->first_name }}" readonly>
                                <input type="hidden" name="employee" value="{{ $employee->id }}">
                                @error('employee')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>         
                            <div class="form-group col-md-4">
                                <label for="office">{{ __('Office') }} <span class="field_required">*</span></label>
                                <input type="text" class="form-control" value="{{ $employee->office->name }}" readonly>
                                <input type="hidden" name="shift_name" value="{{ $employee->office->id }}">
                                @error('office')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>                                                   
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="designation">{{ __('Date') }} <span class="field_required">*</span></label>
                                <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" readonly>
                                @error('date')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            

                        <div class="form-group col-md-4">
                            <label for="clock_in">{{ __('Clock In') }} <span
                                    class="field_required">*</span></label>
                            <input type="time" class="form-control" name="clock_in"
                                   value="{{ old('clock_in') }}">
                            @error('clock_in')
                                <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                            <div class="form-group col-md-4">
                                <label for="clock_out">{{ __('Clock Out') }} <span
                                        class="field_required">*</span></label>
                                <input type="time" class="form-control" name="clock_out"
                                       value="{{ old('clock_out') }}">
                                @error('clock_out')
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
