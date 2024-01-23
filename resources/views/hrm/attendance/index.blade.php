@extends('layouts.master')
@section('main-content')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/nprogress.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/flatpickr.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<div class="breadcrumb">

    <h1>{{ __('Attendance') }}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row" id="section_Client_list">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="text-end mb-3">
                    @can('client_add')
                        <a class="btn btn-outline-primary btn-md m-1" href="{{ route('attendance.create') }}"><i
                                class="i-Add me-2 font-weight-bold"></i>
                            {{ __('Attendance ') }}</a>
                    @endcan
                </div>
                <div class="table-responsive">
                    <table id="client_list_table" class="display table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="not_show">{{ __('Employee Name') }}</th>
                                <th class="not_show">{{ __('Company') }}</th>
                                <th class="not_show">{{ __('Shift Name') }}</th>
                                <th>{{ __('Clock In') }}</th>
                                <th>{{ __('Clock Out') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Work Duration') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Delete Modal --}}
    {{-- @component('hrm.deletemodal.delete') 
    @endcomponent --}}
</div>
@endsection
@section('page-js')
<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/nprogress.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Add these lines to include DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>


<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var editRoute = '{{ route('attendance.edit', ['id' => ':id']) }}';

        $('#client_list_table').DataTable({
            ajax: '{{ route('attendance.getData') }}',
            processing: true,
            columns: [{
                    data: 'id'
                },
                {
                    data: null,
                    render: function(data, type, full, meta) {
                        // Assuming 'employee' is the relationship
                        return full.employee.first_name + ' ' + full.employee.last_name;
                    }
                },
                {
                    data: 'company.name'
                },
                {
                    data: 'office.name'
                },
                {
                    data: 'clock_in'
                },
                {
                    data: 'clock_out'
                }, 
                {
                    data: 'date'
                },

                {
                    data: 'work_duration',
                    render: function(data) {
                        return data !== null ? data : '0';
                    }
                },
                {
                    targets: -1,
                    render: function(data, type, full, meta) {
                        var dynamicEditRoute = editRoute.replace(':id', full.id);

                        return `
                            <div class="dropdown">
                                <button class="btn btn-outline-info btn-rounded dropdown-toggle"
                                    id="dropdownMenuButton" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="${dynamicEditRoute}">
                                        <i class="nav-icon i-Edit font-weight-bold mr-2"></i> Edit Employee
                                    </a>
                                    <a class="dropdown-item delete cursor-pointer"
                                        onclick="deleteEmployeeConfirmation(${full.id})">
                                        <i class="nav-icon i-Close-Window font-weight-bold mr-2"></i>Delete Employee
                                    </a>
                                </div>
                            </div>
                        `;
                    }
                }
            ]
        });
    });
</script>
{{-- <script>
    $(document).ready(function () {
        getData();

        function getData() {
            $.ajax({
                type: "GET",
                url: "{{ route('office.getData') }}",
                dataType: "json",
                success: function (response) {
                    console.log('Data received from server:', response);
                    if (response && response.length > 0) {
                        // Clear the existing table data
                        $('#tbody').empty();

                        response.forEach(element => {
                            $("#tbody").append(`
                                <tr>
                                    <td>${element.id}</td>
                                    <td>${element.name}</td>
                                    <td>${element.clock_in}</td>
                                    <td>${element.clock_out}</td>
                                </tr>
                            `);
                        });

                        console.log('Data appended to table:', response);
                    } else {
                        console.error('Empty or invalid response:', response);
                    }
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    });
</script> --}}
@endsection
