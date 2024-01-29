<!-- edit.blade.php -->

@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ __('Edit Leave Request') }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    {{-- @dd($leaveRequest) --}}
    <div class="row" id="section_edit_leave_request">
        <div class="col-lg-12 mb-3">
            <div class="card">
                <form method="POST" enctype="multipart/form-data" action="{{ route('leaveRequest.update', $leaveRequest->id) }}" @submit.prevent="Update_Client()">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="company">{{ __('Company') }} <span class="field_required">*</span></label>
                                <select class="form-control" name="company" id="company">
                                    <option value="" selected disabled>{{ __('Select Company') }}</option>
                                    @foreach ($companies as $comp)
                                        <option value="{{ $comp->id }}"
                                            {{ $leaveRequest->company_id == $comp->id ? 'selected' : '' }}>
                                            {{ $comp->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="employee">{{ __('Employee') }} <span class="field_required">*</span></label>
                                <select class="form-control" name="employee" id="employee">
                                    <option value="" selected disabled>{{ __('Select Employee') }}</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ $leaveRequest->emp_id == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->first_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="department">{{ __('Department') }} <span
                                        class="field_required">*</span></label>
                                <select class="form-control" name="department" id="department">
                                    <option value="" selected disabled>{{ __('Select Department') }}</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ $leaveRequest->dept_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="leaveType">{{ __('Leave Type') }} <span class="field_required">*</span></label>
                                <select class="form-control" name="leaveType" id="leaveType">
                                    <option value="" selected disabled>{{ __('Select Leave Type') }}</option>
                                    @foreach ($leaveTypes as $leaveType)
                                        <option value="{{ $leaveType->id }}"
                                            {{ $leaveRequest->leave_id == $leaveType->id ? 'selected' : '' }}>
                                            {{ $leaveType->type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('leaveType')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="start_date">{{ __('Start Date') }} <span
                                        class="field_required">*</span></label>
                                @php
                                    $startDate = new DateTime($leaveRequest->start_date);
                                @endphp
                                <input type="date" class="form-control" name="start_date" id="start_date"
                                    value="{{ $startDate->format('Y-m-d') }}">
                                @error('start_date')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>



                            <div class="form-group col-md-4">
                                <label for="end_date">{{ __('End Date') }} <span class="field_required">*</span></label>
                                @php
                                    $endDate = new DateTime($leaveRequest->end_date);
                                @endphp
                                <input type="date" class="form-control" name="end_date" id="end_date"
                                    value="{{ $endDate->format('Y-m-d') }}">
                                @error('end_date')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="status">{{ __('Status') }} <span class="field_required">*</span></label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="" selected disabled>{{ __('Select Status') }}</option>
                                        <option value="2" {{ $leaveRequest->status == '2' ? 'selected' : '' }}>
                                            {{ __('Pending') }}
                                        </option>
                                        <option value="1" {{ $leaveRequest->status == '1' ? 'selected' : '' }}>
                                            {{ __('Approved') }}
                                        </option>
                                        <option value="0" {{ $leaveRequest->status == '0' ? 'selected' : '' }}>
                                            {{ __('Rejected') }}
                                        </option>
                                    </select>
                                    @error('status')
                                        <span class="help-block text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="new_file">{{ __('Choose File') }} <span
                                            class="field_required">*</span></label>
                                            <input type="file" name="new_file" class="form-control" id="new_file">
                                    <a href="{{url('/')}}/leave_requests/{{ $leaveRequest->file_path }}" target="_blank">View File</a>
                                    @error('file')
                                        <span class="help-block text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <input type="hidden" name="old_file" value="{{ $leaveRequest->file_path }}">

                                <div class="form-group col-md-4">
                                    <label for="reason">{{ __('Reason') }} <span class="field_required">*</span></label>
                                    <textarea class="form-control" name="reason" id="reason" rows="3">{{ $leaveRequest->reason }}</textarea>
                                    @error('reason')
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
