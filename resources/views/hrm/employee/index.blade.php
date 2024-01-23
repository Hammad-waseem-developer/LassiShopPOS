@extends('layouts.master')
@section('main-content')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/nprogress.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/flatpickr.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<<div class="breadcrumb">

    <h1>{{ __('translate.Designations') }}</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row" id="section_Client_list">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-end mb-3">
                        @can('client_add')
                            <a class="btn btn-outline-primary btn-md m-1" href="{{ route('designations.create') }}"><i
                                    class="i-Add me-2 font-weight-bold"></i>
                                {{ __('translate.Create') }}</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table id="client_list_table" class="display table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class="not_show">{{ __('Designation Name') }}</th>
                                    <th>{{ __('Department Name') }}</th>
                                    <th>{{ __('Department Head') }}</th>
                                    <th>{{ __('translate.Action') }}</th>
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
            $('#client_list_table').DataTable({
                ajax: '{{ route('employees.getData') }}',
                processing: true,
                columns: [
                    // Define your columns based on the database fields
                    {
                        data: 'id'
                    },
                    {
                        data: 'first_name'
                    },
                    {
                        data: 'department.name'
                    },
                    {
                        data: 'department.dept_head'
                    },
                    {
                        // Define an action column with buttons
                        targets: -1,
                        render: function(data, type, full, meta) {
                            console.log(full.id);
                            
                            return `
                            <div class="dropdown">
                                            <button class="btn btn-outline-info btn-rounded dropdown-toggle"
                                                id="dropdownMenuButton" type="button" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">Action</button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                                x-placement="top-start"
                                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -88px, 0px);">
                                                <a class="dropdown-item"
                                                    href="{{ route('designations.edit', ['id' => full.id])}"><i
                                                        class="nav-icon i-Edit font-weight-bold mr-2"></i> Edit
                                                    Designation</a>
                                                <a data-toggle="modal" data-target="#deleteModal"
                                                    class="dropdown-item delete cursor-pointer"
                                                    onclick="deleteDesignation(${full.id})">
                                                    <i class="nav-icon i-Close-Window font-weight-bold mr-2"></i>Delete
                                                    Designation
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
@endsection
