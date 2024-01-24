    @extends('layouts.master')

    @section('main-content')
        @section('page-css')
        @endsection
        <div class="breadcrumb">
            <h1>{{ __('Leave Create') }}</h1>
        </div>

        <div class="separator-breadcrumb border-top"></div>

        <div class="row" id="section_create_client">
            <div class="col-lg-12 mb-3">
                <div class="card">
                    <form method="POST" action="{{ route('leaveType.store') }}" @submit.prevent="Create_Client()">
                        @csrf
                        <div class="card-body">
                            <div class="row">           
                            <div class="form-group col-md-4">
                                <label for="type">{{ __('Leave Title') }} <span
                                        class="field_required">*</span></label>
                                <input type="text" class="form-control" name="type"
                                    value="{{ old('type') }}">
                                @error('type')
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
