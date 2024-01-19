@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ __('Edit Department') }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row" id="section_edit_department">
        <div class="col-lg-12 mb-3">
            <div class="card">
                <form method="POST" action="{{ route('department.update', $department) }}">
                    @csrf
                    @method('PUT') <!-- Use PUT method for update -->
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="department_name">{{ __('Department Name') }} <span class="field_required">*</span></label>
                                <input type="text" class="form-control" name="department_name" placeholder="{{ __('Department Name') }}" value="{{ old('department_name', $department->name) }}">
                                @error('department_name')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="dept_head">{{ __('Department Head') }} <span class="field_required">*</span></label>
                                <input type="text" class="form-control" name="dept_head" placeholder="{{ __('Department Head') }}" value="{{ old('dept_head', $department->dept_head) }}">
                                @error('dept_head')
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
