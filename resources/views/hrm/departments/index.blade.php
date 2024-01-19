@extends('layouts.master')
@section('main-content')
@section('page-css')

    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/nprogress.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/flatpickr.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection


<div class="breadcrumb">

    <h1>{{ __('translate.Departments') }}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row" id="section_Client_list">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="text-end mb-3">
                    @can('client_add')
                        <a class="btn btn-outline-primary btn-md m-1" href="{{ route('department.create') }}"><i
                                class="i-Add me-2 font-weight-bold"></i>
                            {{ __('translate.Create') }}</a>
                    @endcan
                </div>
                <div class="table-responsive">
                    <table id="client_list_table" class="display table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="not_show">{{ __('Department Name') }}</th>
                                <th>{{ __('Department Head') }}</th>
                                <th>{{ __('translate.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @if (count($departments) > 0)
                                @foreach ($departments as $department)
                                    <tr>
                                        <td>{{ $department->id }}</td>
                                        <td>{{ $department->name }}</td>
                                        <td>{{ $department->dept_head }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-info btn-rounded dropdown-toggle"
                                                    id="dropdownMenuButton" type="button" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false"
                                                    fdprocessedid="d4xzwx">Action</button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                                    x-placement="top-start"
                                                    style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -88px, 0px);">
                                                    <a class="dropdown-item"
                                                        href="{{ route('department.edit', $department) }}"><i
                                                            class="nav-icon i-Edit font-weight-bold mr-2"></i> Edit
                                                        Departments</a>

                                                    {{-- <a data-toggle="modal" data-target="#deleteModal"
                                                    class="dropdown-item delete cursor-pointer" data-id="{{ $department->id }}"> <i
                                                        class="nav-icon i-Close-Window font-weight-bold mr-2"></i>
                                                        Delete Departments</a> --}}

                                                    <a data-toggle="modal" data-target="#deleteModal"
                                                        class="dropdown-item delete cursor-pointer"
                                                        onclick="deleteDepartment({{ $department->id }})"
                                                        data-id="{{ $department->id }}">
                                                        <i
                                                            class="nav-icon i-Close-Window font-weight-bold mr-2"></i>Delete
                                                        Departments
                                                    </a>



                                                    {{-- <a data-toggle="modal" data-target="#deleteModal" class="dropdown-item delete cursor-pointer"
                                                    data-id="{{ $department->id }}"> <i
                                                        class="nav-icon i-Close-Window font-weight-bold mr-2"></i>
                                                    Delete Departments</a> --}}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Delete Modal --}}
    {{-- @component('hrm.deletemodal.delete') 
    @endcomponent --}}
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div style="background-color: white; border:0px;" class="modal-content">

                <div style="display: flex;
        flex-direction: column;
        align-items: center; padding-top: 20px;"
                    class="modal-body">
                    <div class="swal2-icon swal2-warning pulse-warning" style="display: block;">!</div>
                    <h2
                        style="color: #595959;
            font-size: 30px;
            font-weight: 600;
            text-transform: none;
            margin: 0;
            padding: 0;
            line-height: 60px;
            display: block;">
                        Are you sure ?</h2>
                    <div class="swal2-content"
                        style="font-size: 18px;
            text-align: center;
            font-weight: 300;
            position: relative;
            float: none;
            margin: 0;
            padding: 0;
            line-height: normal;
            color: #545454;">
                        You wont be able to revert this !</div>

                </div>
                <div style="justify-content: center; border-top: 0px; padding: 40px 0px 20px 0px;" class="modal-footer">
                    @if ($departments->count() == 0)
                    @else
                        <button type="button" onclick="Delete()" class="swal2-confirm btn btn-primary me-5 btn-ok"
                            id="{{ $department->id }}">Yes, delete
                            it</button>
                        <button data-dismiss="modal" aria-label="Close" type="button"
                            class="swal2-cancel btn btn-danger" @endif
                            style="display: inline-block;">No, cancel!</button>
                </div>
                <input type="hidden" id="deleteDepartmentId" value="">
            </div>
        </div>
    </div>
    <!-- Modal End-->
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



<script type="text/javascript">
    $(function() {
        "use strict";
        $(document).ready(function() {
            flatpickr("#datetimepicker", {
                enableTime: true,
                dateFormat: "Y-m-d H:i"
            });

        });
    });
</script>
<script>
    $(document).ready(function() {
        // Initialize DataTable with AJAX
        $('#client_list_table').DataTable({
            "ajax": {
                "url": '{{ route('department.getData') }}',
                "type": "GET",
                "dataSrc": "data"
            },
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "name"
                },
                {
                    "data": "dept_head"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        // Render the action dropdown
                        return '<div class="dropdown">' +
                            '<button class="btn btn-outline-info btn-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>' +
                            '<div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform;">' +
                            '<a class="dropdown-item" href="{{ url('/departments') }}/' + row
                            .id +
                            '/edit"><i class="nav-icon i-Edit font-weight-bold mr-2"></i> Edit Departments</a>' +
                            '<a class="dropdown-item delete cursor-pointer" data-toggle="modal" data-target="#deleteModal" data-id="' +
                            row.id + '" onclick="deleteDepartment(' + row.id +
                            ')"><i class="nav-icon i-Close-Window font-weight-bold mr-2"></i> Delete Departments</a>' +
                            '</div>' +
                            '</div>';
                    }
                }
            ]
        });
    });

    function deleteDepartment(id) {
        console.log(id);
        $("#deleteDepartmentId").val(id);
    }
    // deete js code
    function Delete() {
        var id = $("#deleteDepartmentId").val();
        console.log(id);
        $.ajax({
            url: '{{ route('department.delete', ['department' => ':id']) }}'.replace(':id', id),
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
              // Trigger the modal hide event
              $('#deleteModal').trigger('hidden.bs.modal');

// Optionally reset modal content after the modal is fully hidden
$("#deleteModal .modal-body").empty();
            },
            error: function(error) {
                // Handle errors
                console.log(error);
                // Display an error message to the user

            }

        });
    }
    $('#deleteModal').on('hidden.bs.modal', function (e) {
    // Hide the modal using jQuery
    $('#deleteModal').hide();
    // Optionally reset modal content after the modal is fully hidden
    $("#deleteModal .modal-body").empty();
});
</script>
