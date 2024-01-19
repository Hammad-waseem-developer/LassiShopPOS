@extends('layouts.master')

@section('main-content')
    @section('page-css')
    @endsection

    <div class="breadcrumb">
        <h1>{{ __('Add Departments') }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row" id="section_create_client">
        <div class="col-lg-12 mb-3">
            <div class="card">
                <form method="POST" action="{{ route('department.store') }}" @submit.prevent="Create_Client()">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4 {{ $errors->has('department_name') ? 'has-error' : '' }}">
                                <label for="department_name">{{ __('Department Name') }} <span class="field_required">*</span></label>
                                <input type="text" class="form-control" name="department_name" placeholder="{{ __('Department Name') }}" value="{{ old('department_name') }}">
                                @if ($errors->has('department_name'))
                                    <span class="help-block text-danger">{{ $errors->first('department_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('dept_head') ? 'has-error' : '' }}">
                                <label for="dept_head">{{ __('Department Head') }} <span class="field_required">*</span></label>
                                <input type="text" class="form-control" name="dept_head" placeholder="{{ __('Department Head') }}" value="{{ old('dept_head') }}">
                                @if ($errors->has('dept_head'))
                                    <span class="help-block text-danger">{{ $errors->first('dept_head') }}</span>
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
