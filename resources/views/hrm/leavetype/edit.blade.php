<!-- resources/views/your-view-folder/edit.blade.php -->

@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <h1>Edit Leave Type</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row" id="section_edit_leave_type">
        <div class="col-lg-12 mb-3">
            <div class="card">
                <form method="POST" action="{{ route('leaveType.update', $leaveType->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- Add your edit form fields here -->
                        <div class="form-group">
                            <label for="title">Leave Title</label>
                            <input type="text" class="form-control" name="type" value="{{ $leaveType->type }}">
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
