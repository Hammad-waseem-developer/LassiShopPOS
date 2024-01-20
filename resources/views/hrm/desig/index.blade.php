@extends('layouts.master')
@section('main-content')
@section('page-css')

    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/nprogress.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/flatpickr.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
<div class="breadcrumb">

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
                            @if (count($designations) > 0)
                                @foreach ($designations as $designation)
                                    <tr>
                                        <td>{{ $designation->id }}</td>
                                        <td>{{ $designation->name }}</td>
                                        <td>{{ $designation->department->name }}</td>
                                        <td>{{ $designation->department->dept_head }}</td>
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
                                                        href="{{ route('designations.edit', $designation) }}"><i
                                                            class="nav-icon i-Edit font-weight-bold mr-2"></i> Edit
                                                        Designation</a>
                                                    <a data-toggle="modal" data-target="#deleteModal"
                                                        class="dropdown-item delete cursor-pointer">
                                                        <i
                                                            class="nav-icon i-Close-Window font-weight-bold mr-2"></i>Delete
                                                        Designation
                                                    </a>
                                                    {{-- <a data-toggle="modal" data-target="#deleteModal"
                                            class="dropdown-item delete cursor-pointer"
                                            onclick="deleteDepartment({{ $department->id }})"
                                            data-id="{{ $department->id }}">
                                            <i
                                                class="nav-icon i-Close-Window font-weight-bold mr-2"></i>Delete
                                            Departments
                                        </a> --}}
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
    //     function deleteDepartment(id) {
    //         console.log(id);
    //         $("#deleteDepartmentId").val(id);
    //     }
    //     // deete js code
    //     function Delete() {
    //     var id = $("#deleteDepartmentId").val();
    //     console.log(id);

    //     $.ajax({
    //         url: '{{ route('department.delete', ['department' => ':id']) }}'.replace(':id', id),
    //         type: 'DELETE',
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(response) {
    //             // Hide the modal using Bootstrap's modal('hide') method
    //             $('#deleteModal').modal('hide');
    //             $('#deleteModal').remove();
    //         },
    //         error: function(error) {
    //             // Handle errors
    //             console.log(error);
    //             // Display an error message to the user
    //         }
    //     });
    // }
</script>
