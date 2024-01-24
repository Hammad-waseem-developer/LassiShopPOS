@extends('layouts.master')
@section('main-content')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/nprogress.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/flatpickr.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
<div class="breadcrumb">
    <h1>{{ __('Leave Type') }}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row" id="section_Client_list">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="text-end mb-3">
                    @can('client_add')
                        <a class="btn btn-outline-primary btn-md m-1" href="{{ route('leaveType.create') }}">
                            <i class="i-Add me-2 font-weight-bold"></i>{{ __('Create') }}
                        </a>
                    @endcan
                </div>
                <div class="table-responsive">
                    <table id="client_list_table" class="display table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="not_show">{{ __('Leave Title') }}</th>
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
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div style="background-color: white; border:0px;" class="modal-content">
            <div style="display: flex; flex-direction: column; align-items: center; padding-top: 20px;" class="modal-body">
                <div class="swal2-icon swal2-warning pulse-warning" style="display: block;">!</div>
                <h2 style="color: #595959; font-size: 30px; font-weight: 600; text-transform: none; margin: 0; padding: 0; line-height: 60px; display: block;">
                    Are you sure?
                </h2>
                <div class="swal2-content" style="font-size: 18px; text-align: center; font-weight: 300; position: relative; float: none; margin: 0; padding: 0; line-height: normal; color: #545454;">
                    You won't be able to revert this!
                </div>
            </div>
            <div style="justify-content: center; border-top: 0px; padding: 40px 0px 20px 0px;" class="modal-footer">
                <button data-dismiss="modal" aria-label="Close" type="button" onclick="deleteDepartment()" class="swal2-confirm btn btn-primary me-5 btn-ok">
                    Yes, delete it
                </button>
                <button data-dismiss="modal" aria-label="Close" type="button" class="swal2-cancel btn btn-danger" style="display: inline-block;">
                    No, cancel!
                </button>
            </div>
            <input type="hidden" id="deleteDepartmentId" value="">
        </div>
    </div>
</div>
<!-- Modal End-->

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        getData();
        function getData() {
            $.ajax({
                url: '{{ route('leaveType.getData') }}',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle success, show success message or refresh the page
                    console.log(response);
                    response.data.forEach(element => {
                        $("#tbody").append(`
                       <tr>
            <td>${element.id}</td>
            <td>${element.type}</td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-outline-info btn-rounded dropdown-toggle"
                        id="dropdownMenuButton" type="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item"
                            href="/hrm/leave-type/edit/${element.id}">
                            <i class="nav-icon i-Edit font-weight-bold mr-2"></i>Edit
                            Departments
                        </a>
                        <a data-toggle="modal" data-target="#deleteModal"
                            class="dropdown-item delete cursor-pointer"
                            onclick="setDeleteDepartmentId(${element.id})">
                            <i class="nav-icon i-Close-Window font-weight-bold mr-2"></i>Delete
                            Departments
                        </a>
                    </div>
                </div>
            </td>
        </tr>
                        `);
                    })
                },
                error: function(error) {
                    // Handle error, show error message
                    console.error('Error fetching data:', error);
                }
            })
        }
        // Set the deleteDepartmentId input field value
        function setDeleteDepartmentId(id) {
            $('#deleteDepartmentId').val(id);
        }

        function deleteDepartment() {
            var departmentId = $('#deleteDepartmentId').val();

            $.ajax({
                url: '{{ url('/hrm/leave-type/delete') }}/' + departmentId,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle success, show success message or refresh the page
                    toastr.success('Leave Type deleted successfully!');
                    getData();
                    // location.reload(); // Reload the page
                },
                error: function(error) {
                    // Handle error, show error message
                    console.error('Error deleting department:', error);
                }
            });
        }
    })
</script>
@endsection
