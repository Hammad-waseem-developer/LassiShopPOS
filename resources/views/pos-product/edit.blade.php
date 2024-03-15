@extends('layouts.master')

@section('main-content')
@section('page-css')
@endsection

<div class="breadcrumb">
    <h1>{{ __('Update Pos Product') }}</h1>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row" id="section_update_product">
    <div class="col-lg-12 mb-3">
        {{-- @if (session('errors'))
            <div class="alert alert-danger">
                <ul>
                    @foreach (session('errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}


        <div class="card">
            <form method="POST" action="{{ route('pos-product.update', $product->id) }}" class="needs-validation"
                enctype="multipart/form-data" id="update_form">
                @csrf
                @method('PUT') {{-- Add this line to specify the HTTP method for update --}}
                <div class="card-body">
                    <div class="row">
                        {{-- Similar form fields as in the create page --}}
                        <div class="form-group col-md-4">
                            <label for="name">{{ __('Product Name') }} <span class="field_required">*</span></label>
                            <input type="text" class="form-control" name="name"
                                placeholder="{{ __('Enter Product Name') }}" value="{{ $product->name }}">
                            <div class="error-message" id="name-error"></div>

                        </div>
                        <div class="form-group col-md-4">
                            <label for="category">{{ __('Product Category') }}
                                <span class="field_required">*</span>
                            </label>
                            <select class="form-control" name="category">
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="error-message" id="category-error"></div>

                        </div>
                        <div class="form-group col-md-4">
                            <label for="warehouse">{{ __('Product Warehouse') }}
                                <span class="field_required">*</span>
                            </label>
                            <select class="form-control" name="warehouse">
                                <option value="">{{ __('Select Warehouse') }}</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}"
                                        {{ $product->warehouse_id == $warehouse->id ? 'selected' : '' }}>
                                        {{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                            <div class="error-message" id="warehouse-error"></div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="image">{{ __('Product image') }}
                                {{-- <span class="field_required">*</span> --}}
                            </label>
                            <input type="file" class="form-control" name="image" id="image" value="">
                            <div class="error-message" id="image-error"></div>
                            <a @if(File::exists(public_path('/images/products/' . $product->img_path))) href="{{ asset('/images/products/' . $product->img_path) }}" target="_blank" @else href="#" @endif>
                                @if(File::exists(public_path('/images/products/' . $product->img_path)))
                                View Image
                                @else
                                No Image
                                @endif
                            </a>
                            <input type="hidden" name="old_image" value="{{ $product->img_path }}">
                            <input type="hidden" name="new_image" id="new_image" value="">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="price">{{ __('Product Price') }}
                                <span class="field_required">*</span>
                            </label>
                            <input type="text" class="form-control" id="price" value="{{ $product->price }}"
                                name="price" value="{{ old('price') }}">
                            <div class="error-message" id="price-error"></div>

                        </div>
                        <div class="form-group col-md-4">
                            <label for="online_product_price">{{ __('Online Product Price') }}
                                <span class="field_required">*</span>
                            </label>
                            <input type="text" class="form-control" id="online_product_price" value="{{ $product->online_product_price }}"
                                name="online_product_price" value="{{ old('online_product_price') }}">
                            <div class="error-message" id="price-error"></div>

                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                            <h2>Product Ingredients</h2>
                            <button class="btn btn-primary" id="add_ingredient" type="button">Add Ingredient</button>
                        </div>
                    </div>

                    <div class="row mt-4">
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
                                <tbody id="product_ingredient_table_body">
                                    {{-- @dd(count($product->Product_Deatils)) --}}
                                    @if (count($product->Product_Deatils) == 0)
                                        <tr>
                                            <td id="no_ingredient" colspan="12" class="text-center">No ingredients
                                            </td>
                                        </tr>
                                    @endif
                                    @foreach ($product->Product_Deatils as $ingredient)
                                        <tr>
                                            <td>
                                                <select name="ingredient_id[]" class="form-control ingredient-select">
                                                    @foreach ($baseProduct as $base)
                                                        <option data-unitSaleid="{{ $base->unit_sale_id }}" value="{{ $base->id }}"
                                                            {{ $ingredient->base_product_id == $base->id ? 'selected' : '' }}>
                                                            {{ $base->name }}</option>
                                                    @endforeach
                                                </select>

                                                <div class="error-message" id="ingredient_id-error"></div>
                                            </td>
                                            <td>
                                                <select name="unit_id[]" class="form-control unit-select">
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->id }}"
                                                            {{ $ingredient->unit_id == $unit->id ? 'selected' : '' }}>
                                                            {{ $unit->name }}</option>
                                                    @endforeach
                                                </select>

                                                <div class="error-message" id="unit_id-error"></div>
                                            </td>
                                            <td>
                                                <input type="text" name="quantity[]" class="form-control"
                                                    value="{{ $ingredient->qty }}">

                                                <div class="error-message" id="quantity-error"></div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="Remove_Ingredient(this)">Remove</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@if (session('errors'))
    <script>
        $(document).ready(function() {
            @foreach (session('errors') as $error)
                toastr.error('{{ $error }}', 'Validation Error');
            @endforeach
        });
    </script>
@endif


<script>
    function Remove_Ingredient(element) {
        $(element).parent().parent().remove();
    }

    $(document).ready(function() {

        $('body').on('change', '#image', function() {
            var input = this;
            $('#new_image').val(input.files[0].name);
            console.log($("#image").val());
        });

        // $('body').on('submit', '#update_form', function(e) {
        //     e.preventDefault();
        //     var form = $(this);
        //     $.ajax({
        //         url: '{{ route('pos-product.update', $product->id) }}',
        //         type: 'POST',
        //         data: form.serialize(),
        //         success: function(response) {
        //             if (response.status == 'success') {
        //                 toastr.success(response.message);
        //                 window.location.href = "{{ route('pos-product.index') }}";
        //             } else if (response.status == 'error') {
        //                 // Handle errors and display them on the same page
        //                 // console.log("Error " + response.errors);
        //                 toastr.error(response.message);
        //                 // handleErrors(response.errors);
        //                 // Handle errors and display them on the same page
        //             }
        //         },
        //         error: function(xhr) {
        //             console.log(xhr.responseText);
        //             // Handle errors and display them on the same page
        //             toastr.error('Something went wrong. Please try again later.');
        //             // Handle errors and display them on the same page
        //         }
        //     })
        // });

        $('body').on('click', '#add_ingredient', function() {
            Add_Ingredient();
        });

        function Add_Ingredient() {
            if ($('#no_ingredient').length > 0) {
                $('#no_ingredient').remove();
            }
            $('#product_ingredient_table_body').append(`
            <tr>
                <td>
                    <select name="ingredient_id[]" class="form-control ingredient-select">
                        @foreach ($baseProduct as $ingredient)
                            <option data-unitSaleid="{{ $ingredient->unit_sale_id }}" value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                        @endforeach
                    </select>
                    <div class="error-message" id="ingredient_id-error"></div>
                   
                </td>
                <td>
                    <select name="unit_id[]" class="form-control unit-select">
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                    <div class="error-message" id="unit_id-error"></div>
                    
                </td>
                <td>
                    <input type="text" name="quantity[]" class="form-control">
                    <div class="error-message" id="quantity-error"></div>
                    
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


    });
</script>
@endsection
