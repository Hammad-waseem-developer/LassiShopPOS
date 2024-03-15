@extends('layouts.master')

@section('main-content')
@section('page-css')
@endsection
<style>
    .cursor {
        cursor: 'not-allowed' !important;
        pointer-events: 'none' !important;

    }
</style>

<div class="breadcrumb">
    <h1>{{ __('Add Pos Product') }}</h1>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row" id="section_create_client">
    <div class="col-lg-12 mb-3">
        <div class="card">
            <form method="POST" class="needs-validation" enctype="multipart/form-data" id="form">
                @csrf
                <div class="card-body">
                    <div class="row">
                        {{-- <div id="error-container"></div> --}}
                        <div class="form-group col-md-4 {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name">{{ __('Product Name') }} <span class="field_required">*</span></label>
                            <input type="text" class="form-control" name="name"
                                placeholder="{{ __('Enter Product Name') }}" value="{{ old('name') }}">
                            <div class="error-message" id="name-error"></div>
                            @if ($errors->has('name'))
                                <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('category') ? 'has-error' : '' }}">
                            <label for="category">{{ __('Product Category') }}
                                <span class="field_required">*</span>
                            </label>
                            <select class="form-control" name="category">
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="error-message" id="category-error"></div>
                            @if ($errors->has('category'))
                                <span class="help-block text-danger">{{ $errors->first('category') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('warehouse') ? 'has-error' : '' }}">
                            <label for="warehouse">{{ __('Product Warehouse') }}
                                <span class="field_required">*</span>
                            </label>
                            <select class="form-control" name="warehouse">
                                <option value="">{{ __('Select Warehouse') }}</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                            <div class="error-message" id="warehouse-error"></div>
                            @if ($errors->has('warehouse'))
                                <span class="help-block text-danger">{{ $errors->first('warehouse') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 {{ $errors->has('image') ? 'has-error' : '' }}">
                            <label for="image">{{ __('Product image') }}
                                {{-- <span class="field_required">*</span> --}}
                            </label>
                            <input type="file" class="form-control" name="image" value="{{ old('image') }}">
                            <div class="error-message" id="image-error"></div>
                            @if ($errors->has('image'))
                                <span class="help-block text-danger">{{ $errors->first('image') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('price') ? 'has-error' : '' }}">
                            <label for="price">{{ __('Product Price') }}
                                <span class="field_required">*</span>
                            </label>
                            <input type="text" class="form-control" name="price" value="{{ old('price') }}">
                            <div class="error-message" id="price-error"></div>
                            @if ($errors->has('price'))
                                <span class="help-block text-danger">{{ $errors->first('price') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('online_product_price') ? 'has-error' : '' }}">
                            <label for="price">{{ __('Online Product Price') }}
                                <span class="field_required">*</span>
                            </label>
                            <input type="text" class="form-control" name="online_product_price"
                                value="{{ old('online_product_price') }}">
                            <div class="error-message" id="price-error"></div>
                            @if ($errors->has('online_product_price'))
                                <span
                                    class="help-block text-danger">{{ $errors->first('online_product_price') }}</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                            <h2>Product Ingredients</h2>
                            <button class="btn btn-primary" id="add_ingredient" type="button">Add Ingredient</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <table id="product_ingredient_table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Unit</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="product_ingredient_table_body"></tbody>

                            </table>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function Remove_Ingredient(element) {
        $(element).parent().parent().remove();
    }

    $(document).ready(function() {

        $('#form').on('submit', function(e) {
            e.preventDefault();
            Create_Product();
        });

        function Create_Product() {
            $.ajax({
                type: "POST",
                url: "{{ route('pos-product.store') }}",
                data: new FormData($('#form')[0]),
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == 'success') {
                        console.log("success" + response);
                        toastr.success(response.message);
                        window.location.href = "{{ route('pos-product.index') }}";
                    } else if (response.status == 'error') {
                        console.log(response);
                        handleErrors(response.errors);
                        toastr.error(response.message);
                    }
                },
                error: function(error) {
                    toastr.error(error.message);
                }

            });
        }


        $('body').on('click', '#add_ingredient', function() {
            Add_Ingredient();
        });

        function Add_Ingredient() {
            $('#product_ingredient_table_body').append(`
            <tr>
                <td>
                    <select name="ingredient_id[]" class="form-control ingredient-select">
                        <option selected disabled>{{ __('Select') }}</option>
                        @foreach ($baseProduct as $ingredient)
                            <option data-unitSaleid="{{ $ingredient->unit_sale_id }}" value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                        @endforeach
                    </select>
                    <div class="error-message" id="ingredient_id-error"></div>
                    @if ($errors->has('ingredient_id'))
                        <span class="help-block text-danger">{{ $errors->first('ingredient_id') }}</span>
                    @endif
                </td>
                <td>
                    <select name="unit_id[]" class="form-control unit-select">
                        <option selected disabled>{{ __('Select') }}</option>
                        @foreach ($units as $unit)
                            <option class="cursor" value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                    <div class="error-message" id="unit_id-error"></div>
                    @if ($errors->has('unit_id'))
                        <span class="help-block text-danger">{{ $errors->first('unit_id') }}</span>
                    @endif
                </td>
                <td>
                    <input type="text" name="quantity[]" class="form-control">
                    <div class="error-message" id="quantity-error"></div>
                    @if ($errors->has('quantity'))
                        <span class="help-block text-danger">{{ $errors->first('quantity') }}</span>
                    @endif
                </td>
                <td>
                    <button type="button" class="btn btn-danger" onclick="Remove_Ingredient(this)">Remove</button>
                </td>
            </tr>
        `);
        }

        $('body').on('change', '.ingredient-select', function() {
            var unitSaleId = $(this).find('option:selected').data('unitsaleid');
            var unitSelect = $(this).closest('tr').find('.unit-select');

            unitSelect.val(unitSaleId);
            unitSelect.trigger('change');
        });

        function handleErrors(errors) {
            // Clear previous error messages
            $('.error-message').empty();

            if (errors && errors.length > 0) {
                // Display errors using Toastr
                $.each(errors, function(index, error) {
                    // Display error message in Toastr
                    toastr.error(error);
                });
            }
        }
    });
</script>
@endsection
