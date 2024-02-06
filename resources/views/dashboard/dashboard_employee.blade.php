@extends('layouts.master')
@section('main-content')

@section('page-css')
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/styles/vendor/nprogress.css') }}">

@endsection

<div class="breadcrumb">
  <h1>{{ __('translate.dashboard') }}</h1>
</div>

<div class="separator-breadcrumb border-top"></div>

@if (auth()->user()->can('dashboard'))
  <div id="section_Dashboard">
    <div class="row">
      <div class="col-lg-6 col-md-12 mb-4">
        <div class="card p-4 d-flex flex-row align-items-center justify-content-between">
          <div>
            <p class="text-primary fw-semibold mb-1 font_17">
            {{ __('translate.Good_Morning') }}, {{Auth::user()->username}}!
            </p>
           

          </div>
          <img class="pe-lg-3" width="194" height="170" src="{{asset('images/overview.png')}}" alt="">
        </div>
      </div>

    </div>



  </div>
@else
  <h4>{{ __('translate.Welcome_to_your_Dashboard') }} , {{ Auth::user()->username }}</h4>
@endif
@endsection

@section('page-js')
<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/nprogress.js') }}"></script>
<script src="{{ asset('assets/js/vendor/echarts.min.js') }}"></script>
<script src="{{ asset('assets/js/echart.options.min.js') }}"></script>

@endsection