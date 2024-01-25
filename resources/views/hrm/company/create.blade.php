@extends('layouts.master')

@section('main-content')
    @section('page-css')
    @endsection

    <div class="breadcrumb">
        <h1>{{ __('Create Company') }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row" id="section_create_client">
        <div class="col-lg-12 mb-3">
            <div class="card">
                <form method="POST" action="{{ route('company.store') }}" @submit.prevent="Create_Client()">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">{{ __('Company Name') }} <span class="field_required">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="{{ __('Company Name') }}" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6 {{ $errors->has('phone') ? 'has-error' : '' }}">
                                <label for="phone">{{ __('Phone') }} <span class="field_required">*</span></label>
                                <input type="tel" id="phone" name="phone"  class="form-control" 
                                pattern="[0-9]{4,20}" title="Please enter a valid phone number in 4/20 digit (numeric only)"
                                name="phone" placeholder="{{ __('Phone') }}" value="{{ old('phone') }}">
                                @if ($errors->has('phone'))
                                    <span class="help-block text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>             
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label for="email">{{ __('Email') }} <span class="field_required">*</span></label>
                                <input type="email" class="form-control" name="email" placeholder="{{ __('Enter Email') }}" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>         
                            <div class="form-group col-md-6 {{ $errors->has('country') ? 'has-error' : '' }}">
                                <label for="country">{{ __('Country') }} <span class="field_required">*</span></label>
                                <input type="text" class="form-control" name="country" placeholder="{{ __('Enter Country') }}" value="{{ old('country') }}">
                                @if ($errors->has('country'))
                                    <span class="help-block text-danger">{{ $errors->first('country') }}</span>
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
