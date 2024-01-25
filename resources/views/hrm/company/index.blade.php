@extends('layouts.master')
@section('main-content')
@section('page-css')

    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/nprogress.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/flatpickr.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection


<div class="breadcrumb">

    <h1>{{ __('Companies') }}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row" id="section_Client_list">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="text-end mb-3">
                    @can('client_add')
                        <a class="btn btn-outline-primary btn-md m-1" href="{{ route('company.create') }}"><i
                                class="i-Add me-2 font-weight-bold"></i>
                            {{ __('translate.Create') }}</a>
                    @endcan
                </div>
                <div class="table-responsive">
                    <table id="client_list_table" class="display table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="not_show">{{ __('Company Name') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Country') }}</th>
                                <th>{{ __('Email') }}</th>
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

<script>
    $(document).ready(function() {
        getData();

        $('body').on('click', '#delete', function() {
            var id = $(this).data('id');
            $('#deleteDepartmentId').val(id);
            $('#deleteModal').modal('show');
        });

        $('body').on('click', '#cancelBtn', function() {
            $('#deleteModal').modal('hide');
        })

        $('body').on('click', '#deleteBtn', function() {
            var id = $('#deleteDepartmentId').val();
            var departmentId = $('#deleteDepartmentId').val();

            $.ajax({
                url: '{{ route('company.delete') }}', // Corrected the route name
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
                    $('#deleteModal').modal('hide');
                    getData();
                },
                error: function(error) {
                    // Handle error, show error message
                    console.error('Error deleting department:', error);
                }
            });
        });


        function getData() {
            $.ajax({
                type: "GET",
                url: "{{ route('company.getData') }}",
                dataType: "json",
                success: function(response) {
                    $("#tbody").empty();
                    if (response && response.length > 0) {
                        response.forEach(element => {
                         
                            $('#tbody').append(`
                                <tr>
                                    <td>${element.id}</td>
                                    <td>${element.name}</td>
                                    <td>${element.phone}</td>
                                    <td>${element.country}</td>
                                    <td>${element.email}</td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-info btn-rounded dropdown-toggle"
                                                id="dropdownMenuButton" type="button" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">Action</button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                                x-placement="top-start"
                                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -88px, 0px);">
                                                <a class="dropdown-item"
                                                    href="{{ url('hrm/company/edit') }}/${element.id}"
                                                    data-id="${element.id}">
                                                    <i class="nav-icon i-Edit font-weight-bold mr-2"></i>Edit Department
                                                </a>

                                                <a class="dropdown-item delete cursor-pointer"
                                                data-id="${element.id}" id="delete">
                                                    <i class="nav-icon i-Close-Window font-weight-bold mr-2"></i>Delete Department
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        $('#tbody').append(`
                        <tr>
                            <td style="text-align: center;" colspan="12">No data available</td>
                        </tr>
                    `);

                    }
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    });
</script>
@endsection
