@extends('layouts.master')

@section('main-content')
@section('page-css')
@endsection

<div class="breadcrumb">
    <h1>{{ __('Edit Holiday') }}</h1>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row" id="section_edit_holiday">
    <div class="col-lg-12 mb-3">
        <div class="card">
            <form method="POST"  action="" @submit.prevent="Update_Holiday()">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="company">{{ __('Company') }} <span class="field_required">*</span></label>
                            <select class="form-control" name="company_id" id="company">
                                <option value="" selected disabled>{{ __('Select Company') }}</option>
                                @foreach ($holiday->company as $comp)
                                    <option value="{{ $comp->id }}" {{ old('company_id', $holiday->company_id) == $comp->id ? 'selected' : '' }}>
                                        {{ $comp->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="start_date">{{ __('Start Date') }} <span class="field_required">*</span></label>
                            <input type="date" class="form-control" name="start_date" id="start_date" value="{{ old('start_date', $holiday->start_date) }}">
                            @error('start_date')
                                <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="end_date">{{ __('End Date') }} <span class="field_required">*</span></label>
                            <input type="date" class="form-control" name="end_date" id="end_date" value="{{ old('end_date', $holiday->end_date) }}">
                            @error('end_date')
                                <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="title">{{ __('Title') }} <span class="field_required">*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $holiday->name) }}">
                            @error('title')
                                <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="status">{{ __('Status') }} <span class="field_required">*</span></label>
                            <select class="form-control" name="status" id="status">
                                <option value="" selected disabled>{{ __('Select Status') }}</option>
                                <option value="0" {{ old('status', $holiday->status) == '0' ? 'selected' : '' }}>
                                    {{ __('Pending') }}
                                </option>
                                <option value="1" {{ old('status', $holiday->status) == '1' ? 'selected' : '' }}>
                                    {{ __('Approved') }}
                                </option>
                                <option value="2" {{ old('status', $holiday->status) == '2' ? 'selected' : '' }}>
                                    {{ __('Rejected') }}
                                </option>
                            </select>
                            @error('status')
                                <span class="help-block text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="details">{{ __('Please provide any details') }} <span class="field_required">*</span></label>
                            <textarea class="form-control" name="details" id="details" rows="3">{{ old('details', $holiday->details) }}</textarea>
                            @error('details')
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
