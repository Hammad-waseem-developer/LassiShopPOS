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
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div style="background-color: white; border:0px;" class="modal-content">
                <div style="display: flex; flex-direction: column; align-items: center; padding-top: 20px;"
                    class="modal-body">
                    <div class="swal2-icon swal2-warning pulse-warning" style="display: block;">!</div>
                    <h2
                        style="color: #595959; font-size: 30px; font-weight: 600; text-transform: none; margin: 0; padding: 0; line-height: 60px; display: block;">
                        Are you sure?
                    </h2>
                    <div class="swal2-content"
                        style="font-size: 18px; text-align: center; font-weight: 300; position: relative; float: none; margin: 0; padding: 0; line-height: normal; color: #545454;">
                        You won't be able to revert this!
                    </div>
                </div>
                <div style="justify-content: center; border-top: 0px; padding: 40px 0px 20px 0px;" class="modal-footer">
                    <button data-dismiss="modal" aria-label="Close" type="button" id="deleteBtn"
                        class="swal2-confirm btn btn-primary me-5 btn-ok">
                        Yes, delete it
                    </button>
                    <button data-dismiss="modal" aria-label="Close" id="cancelBtn" type="button"
                        class="swal2-cancel btn btn-danger" style="display: inline-block;">
                        No, cancel!
                    </button>
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
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>


<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var editRoute = '{{ route('attendance.edit', ['id' => ':id']) }}';
        $('body').on('click', '#delete', function() {
            var id = $(this).data('id');
            console.log("Delete fun run " + id);
            $('#deleteDepartmentId').val(id);
            $('#deleteModal').modal('show');
        });

        $('body').on('click', '#cancelBtn', function() {
            $('#deleteModal').modal('hide');
        });


        $('body').on('click', '#deleteBtn', function() {
            var id = $('#deleteDepartmentId').val();
            var departmentId = $('#deleteDepartmentId').val();

            $.ajax({
                url: '{{ route('attendance.delete') }}',
                type: 'POST',
                data: {
                    id: departmentId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle success, show success message or refresh the page
                    toastr.success(response.message);
                    getData();
                    // location.reload(); // Reload the page
                    $('#deleteModal').modal('hide');

                },
                error: function(error) {
                    // Handle error, show error message
                    console.error('Error deleting department:', error);
                }
            });
        })

        getData();

        function getData() {
            $('#client_list_table').DataTable().destroy();
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
                                        <i class="nav-icon i-Edit font-weight-bold mr-2"></i> Edit Attendance
                                    </a>
                                    <a class="dropdown-item delete cursor-pointer"
                                    data-id="${full.id}" id="delete">
                                        <i class="nav-icon i-Close-Window font-weight-bold mr-2"></i>Delete Attendance
                                    </a>
                                </div>
                            </div>
                        `;
                        }
                    }
                ]
            });
        }
    });
</script>
@endsection