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
                    @if (Auth::user()->can('attendance_create') || auth()->user()->id == 1)
                        <a class="btn btn-outline-primary btn-md m-1" href="{{ route('attendance.create') }}"><i
                                class="i-Add me-2 font-weight-bold"></i>
                            {{ __('Attendance ') }}</a>
                    @endif
                    @if (auth()->user()->can('employee_view_all'))
                        <a class="btn btn-outline-success btn-md m-1" id="Show_Modal_Filter"><i
                                class="i-Filter-2 me-2 font-weight-bold"></i>
                            {{ __('translate.Filter') }}</a>
                        <button id="printButton" class="btn btn-outline-primary fw-bolder btn-md m-1"><i
                                class="i-Add me-2 font-weight-bold"></i>Print</button>
                    @endif
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

    <!-- Modal Filter -->
    <div class="modal fade" id="filter_purchase_modal" tabindex="-1" role="dialog"
        aria-labelledby="filter_purchase_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('translate.Filter') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="start_date">{{ __('translate.From_Date') }}
                            </label>
                            <input type="date" class="form-control date" name="start_date" id="start_date"
                                placeholder="{{ __('translate.From_Date') }}" value="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="end_date">{{ __('translate.To_Date') }} </label>
                            <input type="date" class="form-control date" name="end_date" id="end_date"
                                placeholder="{{ __('translate.To_Date') }}" value="">
                        </div>

                    </div>

                    <div class="row mt-3">

                        <div class="col-md-6">
                            <button type="button" id="filter" class="btn btn-primary">
                                <i class="i-Filter-2 me-2 font-weight-bold"></i> {{ __('translate.Filter') }}
                            </button>
                            <button id="Clear_Form" class="btn btn-danger">
                                <i class="i-Power-2 me-2 font-weight-bold"></i> {{ __('translate.Clear') }}
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    {{-- filter modal end --}}
</div>
@if (Session::has('success'))
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/dist/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            toastr.success("{{ Session::get('success') }}");
        });
    </script>
@endif
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

        $('#Clear_Form').on('click', function() {
        // Reset the values of filter inputs
        $('#start_date').val('');
        $('#end_date').val('');
        $('#filter').trigger('click');
        getData();
    });


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
                        data: 'work_duration'
                    },
                    {
                        targets: -1,
                        render: function(data, type, full, meta) {
                            var dynamicEditRoute = editRoute.replace(':id', full.id);

                            return `
                            <div class="dropdown">
                                @if (Auth::user()->can('attendance_edit') || auth()->user()->id == 1)
                                <button class="btn btn-outline-info btn-rounded dropdown-toggle"
                                    id="dropdownMenuButton" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="${dynamicEditRoute}">
                                        <i class="nav-icon i-Edit font-weight-bold mr-2"></i> Edit Attendance
                                    </a>
                                    @endif
                                    @if (Auth::user()->can('attendance_delete') || auth()->user()->id == 1)
                                    <a class="dropdown-item delete cursor-pointer"
                                    data-id="${full.id}" id="delete">
                                        <i class="nav-icon i-Close-Window font-weight-bold mr-2"></i>Delete Attendance
                                    </a>
                                    @endif
                                </div>
                            </div>
                        `;
                        }
                    }
                ]
            });
        }

        // Show Modal Filter
        $('#Show_Modal_Filter').on('click', function(e) {
            $('#filter_purchase_modal').modal('show');
        });


        $('body').on('click', '#filter', function() {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var editRoute = '{{ route('attendance.edit', ['id' => ':id']) }}';

        $('#client_list_table').DataTable().destroy();
        $('#filter_purchase_modal').modal('hide');
        $('#client_list_table').DataTable().destroy();
            $('#client_list_table').DataTable({
                ajax: {
                url: '{{ route('attendance.getData') }}',
                type: "GET",
                data: {
                    start_date: start_date,
                    end_date: end_date
                }
            },
                
                processing: true,
                serverSide: true,
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
                        data: 'work_duration'
                    },
                    {
                        targets: -1,
                        render: function(data, type, full, meta) {
                            var dynamicEditRoute = editRoute.replace(':id', full.id);

                            return `
                            <div class="dropdown">
                                @if (Auth::user()->can('attendance_edit') || auth()->user()->id == 1)
                                <button class="btn btn-outline-info btn-rounded dropdown-toggle"
                                    id="dropdownMenuButton" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="${dynamicEditRoute}">
                                        <i class="nav-icon i-Edit font-weight-bold mr-2"></i> Edit Attendance
                                    </a>
                                    @endif
                                    @if (Auth::user()->can('attendance_delete') || auth()->user()->id == 1)
                                    <a class="dropdown-item delete cursor-pointer"
                                    data-id="${full.id}" id="delete">
                                        <i class="nav-icon i-Close-Window font-weight-bold mr-2"></i>Delete Attendance
                                    </a>
                                    @endif
                                </div>
                            </div>
                        `;
                        }
                    }
                ]
            });
        })

    });
</script>
<script>
    document.getElementById("printButton").addEventListener("click", function() {
        var table = document.getElementById("client_list_table");
        if (table) {
            // Clone the table
            var tableClone = table.cloneNode(true);

            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write(`<html><head><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
                </head><body>
                <center class="mt-5">
                <h1>Attendance Report</h1>
                </center> ` + tableClone.outerHTML + `</body></html>`);
            newWin.document.close();
            setTimeout(function() {
                newWin.print();
                newWin.close();
            }, 10);
        }
    });
</script>
@endsection
