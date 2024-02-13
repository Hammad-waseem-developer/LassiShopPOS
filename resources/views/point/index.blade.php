@extends('layouts.master')
@section('main-content')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/nprogress.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/flatpickr.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<div class="breadcrumb">
    <h1>Customer Points</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row" id="section_Client_list">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="client_list_point" class="display table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>{{ __('Total Points') }}</th>
                                <th>{{ __('Remaining Points') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')
<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/nprogress.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
    $.ajax({
        url: '{{ route('clients.getPoints') }}',
        type: 'GET',
        success: function(data) {
            $('#client_list_point').DataTable({
                data: data,
                columns: [
                    { data: 'id' },
                    { 
                        data: null,
                        render: function(data, type, row) {
                            if (data.clients && data.clients.username) {
                                return data.clients.username;
                            } else {
                                return ''; 
                            }
                        }
                    },
                    { data: 'total_user_point' },
                    { data: 'remaining_user_point' }
                ]
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
});

</script>
@endsection
