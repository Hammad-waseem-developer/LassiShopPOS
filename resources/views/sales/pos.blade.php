<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Posly - Ultimate Inventory Management System with POS</title>

    <!-- Favicon icon -->
    <link rel=icon href={{ asset('images/logo.svg') }}>
    <!-- Base Styling  -->

    <link rel="stylesheet" href="{{ asset('assets/pos/main/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/pos/main/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/css/themes/lite-purple.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/iconsmind/iconsmind.css') }}">

    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/bootstrap-vue.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/vue-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/nprogress.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/autocomplete.css') }}">

    <script src="{{ asset('assets/js/axios.js') }}"></script>
    <script src="{{ asset('assets/js/vue-select.js') }}"></script>
    <script src="{{ asset('assets/pos/plugins/jquery/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/flatpickr.min.css') }}">

    {{-- Alpine Js --}}
    <script defer src="{{ asset('js/plugin-core/alpine-collapse.js') }}"></script>
    <script defer src="{{ asset('js/plugin-core/alpine.js') }}"></script>
    <script src="{{ asset('js/plugin-script/alpine-data.js') }}"></script>
    <script src="{{ asset('js/plugin-script/alpine-store.js') }}"></script>

</head>

<body class="sidebar-toggled sidebar-fixed-page pos-body">

    <!-- Pre Loader Strat  -->
    <div class='loadscreen' id="preloader">
        <div class="loader spinner-border spinner-border-lg">
        </div>
    </div>

    <div class="compact-layout pos-layout">
        <div data-compact-width="100" class="layout-sidebar pos-sidebar">
            @include('layouts.new-sidebar.sidebar')
        </div>

        <div class="layout-content">
            @include('layouts.new-sidebar.header')

            <div class="content-section" id="main-pos">
                <section class="pos-content">
                    <div class="d-flex align-items-center">
                        <div class="w-100 text-gray-600 position-relative">
                            <div id="autocomplete" class="autocomplete">
                                <input type="text" class="form-control border border-gray-300 py-3 pr-3"
                                    placeholder="{{ __('translate.Scan_Search_Product_by_Code_Name') }}" />
                                <ul class="autocomplete-result-list">
                                    <li></li>
                                </ul>
                            </div>
                        </div>
                        <button class="btn btn-light p-3 rounded-circle ms-3">
                            @include('components.icons.full-screen', ['class' => 'width_20'])
                        </button>
                    </div>

                    <div class="row pos-card-left">
                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <form>

                                <!-- Customer -->
                                <div class="filter-box">
                                    <label>Warehouse <span class="field_required">*</span></label>
                                    <select name="warehouse_id" class="form-control" id="warehouse_id">
                                        <option value="">Select Warehouse</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}"
                                                {{ $warehouse->id == $settings->warehouse_id ? 'selected' : '' }}>
                                                {{ $warehouse->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="filter-box">
                                    <label>{{ __('translate.Customer') }} <span class="field_required">*</span></label>
                                    <select name="customer_id" class="form-control" id="customer_id">
                                        <option value="">Select Customer</option>
                                        @foreach ($clients as $clients)
                                            <option value="{{ $clients->id }}"
                                                {{ $clients->id == $settings->client_id ? 'selected' : '' }}>
                                                {{ $clients->username }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- warehouse -->

                                <!-- card -->
                                <div class="card m-0 card-list-products">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 class="fw-semibold m-0">{{ __('translate.Cart') }}</h6>
                                    </div>

                                    <div class="card-items" id="cart-items">
                                        {{-- Products will be displayed here using ajax --}}
                                    </div>

                                    <div class="cart-summery">

                                        <div>
                                            <div class="summery-item mb-2 row">
                                                <span
                                                    class="title mr-2 col-lg-12 col-sm-12">{{ __('translate.Shipping') }}</span>

                                                <div class="col-lg-8 col-sm-12">
                                                    <div class="input-group text-right">
                                                        <input type="text" class="no-focus form-control pos-shipping"
                                                            id="shipping">
                                                        <span class="input-group-text cursor-pointer"
                                                            id="basic-addon3">{{ $currency }}</span>
                                                    </div>
                                                    <span class="error"></span>
                                                </div>
                                            </div>

                                            <div class="summery-item mb-2 row">
                                                <span
                                                    class="title mr-2 col-lg-12 col-sm-12">{{ __('translate.Order_Tax') }}</span>
                                                <div class="col-lg-8 col-sm-12">
                                                    <div class="input-group text-right">
                                                        <input type="text" class="no-focus form-control pos-tax"
                                                            id="orderTax">
                                                        <input type="hidden" id="TaxNet" name="TaxNet">
                                                        <span class="input-group-text cursor-pointer"
                                                            id="basic-addon3">%</span>
                                                    </div>
                                                    <span class="error"></span>
                                                </div>
                                            </div>

                                            <div class="summery-item mb-3 row">
                                                <span
                                                    class="title mr-2 col-lg-12 col-sm-12">{{ __('translate.Discount') }}</span>
                                                <div class="col-lg-8 col-sm-12 summery-item-discount">

                                                    <input type="text" class="no-focus form-control pos-discount"
                                                        id="discount" />
                                                    <span class="error"></span>
                                                    <select class="input-group-text discount-select-type"
                                                        id="inputGroupSelect02">
                                                        <option value="fixed">{{ $currency }}</option>
                                                        <option value="percent">%</option>
                                                    </select>
                                                    <input type="hidden" name="discountAmount" id="discountAmount">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pt-3 border-top border-gray-300 summery-total">
                                            <h5 class="summery-item m-0">
                                                <span>{{ __('translate.Total') }}</span>
                                                <span id="GrandTotal"></span>
                                                <input type="hidden" name="GrandTotal1" id="GrandTotal1">
                                                {{-- @if ($symbol_placement == 'before')
                                                    <span></span>
                                                @else
                                                    <span></span>
                                                @endif --}}
                                            </h5>
                                        </div>
                                        <div class="half-circle half-circle-left"></div>
                                        <div class="half-circle half-circle-right"></div>
                                    </div>

                                    <button class="cart-btn btn btn-primary" id="PayNow">
                                        {{ __('translate.Pay_Now') }}
                                    </button>

                                </div>

                            </form>

                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="form_Update_Detail" tabindex="-1" role="dialog"
                            aria-labelledby="form_Update_Detail" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Create Payment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="row">

                                                <!-- Date -->
                                                <div class="form-group col-md-6">
                                                    <label for="Unit_price">Date
                                                        <span class="field_required">*</span></label>
                                                    <input type="date" name="date" id="date"
                                                        value="{{ date('Y-m-d') }}" class="form-control">
                                                    <span class="error"></span>
                                                </div>

                                                <!-- Paying Amount -->
                                                <div class="form-group col-md-6">
                                                    <label>Paying Amount <span class="field_required">*</span></label>
                                                    <input type="text" id="paying_amount" name="paying_amount"
                                                        class="form-control">
                                                    <span class="badge badge-danger mt-2"
                                                        id="paying_amount_badge">Grand Total: </span>
                                                    <span class="error"></span>
                                                </div>

                                                <!-- Payment Choice -->
                                                <div class="form-group col-md-6">
                                                    <label for="ordertax">Payment Choice
                                                        <span class="field_required">*</span></label>
                                                    <select name="payment_method_id" id="payment_method_id"
                                                        class="form-control">
                                                        <option value="">Select Payment</option>
                                                        @foreach ($payment_methods as $payment_method)
                                                            <option value="{{ $payment_method->id }}">
                                                                {{ $payment_method->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error"></span>
                                                </div>

                                                <!-- Account -->
                                                <div class="form-group col-md-6">
                                                    <label>Account <span class="field_required">*</span></label>
                                                    <select name="account_id" id="account_id" class="form-control">
                                                        @foreach ($accounts as $account)
                                                            <option value="">Select Account</option>
                                                            <option value="{{ $account->id }}">
                                                                {{ $account->account_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error"></span>
                                                </div>

                                                <!-- Payment Note -->
                                                <div class="form-group col-md-6">
                                                    <label for="note">Payment Note
                                                        <span class="field_required">*</span></label>
                                                    <textarea class="form-control" name="note" id="note" cols="30" rows="10"></textarea>
                                                    <span class="error"></span>
                                                </div>

                                                <!-- Sale note -->
                                                <div class="form-group col-md-6">
                                                    <label>Sale Note <span class="field_required">*</span></label>
                                                    <textarea class="form-control" name="note" id="note" cols="30" rows="10"></textarea>
                                                    <span class="error"></span>
                                                </div>

                                                <div class="col-lg-12">
                                                    <button type="submit" id="save_pos" class="btn btn-primary">
                                                        <i class="i-Yes me-2 font-weight-bold"></i>
                                                        {{ __('translate.Submit') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mt-3">
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="row" id="products-box">

                                        <div class="d-flex justify-content-center">
                                        </div>

                                    </div>
                                    <!-- Add this container for pagination links -->
                                    <div id="pagination-container"
                                        class="mt-4 d-flex justify-content-center align-items-center mb-5">
                                        <h4>Pagination</h4>
                                        <!-- Pagination links will be inserted here -->
                                    </div>
                                </div>

                                <div class="d-md-block col-12 col-lg-4">
                                    <div class="card category-card">
                                        <div class="category-head">
                                            <h5 class="fw-semibold m-0">{{ __('translate.All_Category') }}</h5>
                                        </div>
                                        <ul class="p-0" id="CategoryUl">
                                            {{-- Category Print Here Using Ajax --}}
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <audio id="clickSound" src="{{ asset('assets/audio/Beep.wav') }}"></audio>

    {{-- --------------------------------------------------------------------------------------------- --}}

    <script type="text/javascript">
        $(window).on('load', function() {
            jQuery("#loader").fadeOut(); // will fade out the whole DIV that covers the website.
            jQuery("#preloader").delay(800).fadeOut("slow");
            jQuery("pos-layout").show(); // will fade out the whole DIV that covers the website.

        });
    </script>

    {{-- vue js --}}
    <script src="{{ asset('assets/js/vue.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-vue.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/js/vee-validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/vee-validate-rules.min.js') }}"></script>
    <script src="{{ asset('/assets/js/moment.min.js') }}"></script>

    {{-- sweetalert2 --}}
    <script src="{{ asset('assets/js/vendor/sweetalert2.min.js') }}"></script>


    {{-- common js --}}
    <script src="{{ asset('assets/js/common-bundle-script.js') }}"></script>
    {{-- page specific javascript --}}
    @yield('page-js')

    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script src="{{ asset('assets/js/vendor/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/toastr.script.js') }}"></script>

    <script src="{{ asset('assets/js/customizer.script.js') }}"></script>
    <script src="{{ asset('assets/js/nprogress.js') }}"></script>


    <script src="{{ asset('assets/js/tooltip.script.js') }}"></script>
    <script src="{{ asset('assets/js/script_2.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/flatpickr.min.js') }}"></script>


    <script src="{{ asset('assets/js/compact-layout.js') }}"></script>

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
        var data;
        var grandTotal = 0;
        var currentPage = 1;

        // Define routes and elements
        const routes = {
            getProducts: "{{ route('get_products') }}",
            addToCart: "{{ route('add_to_cart') }}",
            deleteProductFromCart: "{{ route('delete_product_from_cart') }}",
            addQuantity: "{{ route('add_qty') }}",
            removeQuantity: "{{ route('remove_qty') }}",
        };

        const elements = {
            productsBox: $("#products-box"),
            cartItems: $("#cart-items"),
            discountInput: $("#discount"),
            discountSelect: $("#inputGroupSelect02"),
        };

        $(document).ready(function() {

            var selectedCategory = 'all';
            var selectedWarehouse = $("#warehouse_id").val();

            var isFetching = false; // Flag to track AJAX request state

            // Fetch and render products on page load
            const initialPage = getInitialPageFromUrl();
            fetchAndRenderProducts(initialPage);

            // Add event listener for popstate
            $(window).on("popstate", function(event) {
                const state = event.originalEvent.state;
                if (state) {
                    const page = state.page;
                    fetchAndRenderProducts(page);
                }
            });

            function getInitialPageFromUrl() {
                const urlParams = new URLSearchParams(window.location.search);
                const initialPage = urlParams.get("page");
                return initialPage ? parseInt(initialPage, 10) : 1; // Default to page 1 if undefined
            }


            // Searching Product
            const autocompleteInput = $("#autocomplete input");
            const autocompleteResultList = $(".autocomplete-result-list");

            // Handle input focus to show/hide the result list
            autocompleteInput.on("focus", function() {
                showSearchResults();
            });

            autocompleteInput.on("blur", function() {
                // Use a delay to allow for the click on the result list
                setTimeout(hideSearchResults, 200);
            });

            // Handle input changes for autocomplete
            autocompleteInput.on("input", function() {
                const searchTerm = $(this).val();
                $.ajax({
                    url: "{{ route('search_products') }}",
                    type: "GET",
                    data: {
                        term: searchTerm,
                        warehouse_id: $("#warehouse_id").val(),
                    },
                    success: function(data) {
                        renderSearchResults(data.products);
                        showSearchResults
                            (); // Ensure the list is visible when there are results
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

            // Handle change event for warehouse
            $("#warehouse_id").on("change", function() {
                const warehouseId = $(this).val();
                warehouse_id = warehouseId;
                const categoryId = $(".category-item.CategorySelected").data(
                    "id"); // Get the selected category ID
                ProductByCategory(categoryId, warehouseId, "Warehouse");
            });

            // Handle click events on autocomplete results
            autocompleteResultList.on("click", "li", function(event) {
                event.stopPropagation(); // Prevent the click event from bubbling up

                const id = $(this).data("id");
                const name = $(this).text();
                const price = $(this).data("price");
                const img_path = $(this).data("img_path");

                addToCart(id, price, name, img_path);
                playClickSound();
            });

            function showSearchResults() {
                autocompleteResultList.show();
            }

            function hideSearchResults() {
                autocompleteResultList.hide();
            }

            function renderSearchResults(products) {
                // Clear previous results
                autocompleteResultList.empty();
                // Render new results
                if (products.length > 0) {
                    products.forEach(function(product) {
                        autocompleteResultList.append(`
                    <li style="position: relative" class="px-3 py-2 cursor-pointer fw-semibold fs-14" data-id="${product.id}" data-price="${product.price}" data-img_path="${product.img_path}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                            ${product.name}
                    </li>
                `);
                    });
                } else {
                    autocompleteResultList.append(`
                <li>No results found</li>
            `);
                }
            }

            initialize();

            function checkCartItemsAndEnableWarehouseSelect() {
                const warehouseSelect = $("#warehouse_id");

                // Check if data is defined and has the 'cart' property
                if (data && data.cart) {
                    const isCartEmpty = $.isEmptyObject(data.cart);

                    if (isCartEmpty) {
                        // Cart is empty, enable the warehouse select box
                        warehouseSelect.prop('disabled', false);
                        warehouseSelect.css('cursor', 'pointer');
                    } else {
                        // Cart is not empty, disable the warehouse select box
                        warehouseSelect.prop('disabled', true);
                        warehouseSelect.css('cursor', 'not-allowed');
                    }
                } else {
                    // If data is undefined or doesn't have the 'cart' property, assume cart is empty
                    warehouseSelect.prop('disabled', false);
                    warehouseSelect.css('cursor', 'pointer');
                }
            }

            function initialize() {
                fetchAndRenderProducts();
                checkCartItemsAndEnableWarehouseSelect();

                // Handle click events
                elements.productsBox.on("click", ".product-card", function() {
                    const {
                        id,
                        price,
                        name,
                        img_path
                    } = $(this).data();
                    addToCart(id, price, name, img_path);
                    playClickSound();
                    $("#warehouse_id").attr("disabled", true);
                    $("#warehouse_id").css("cursor", "not-allowed");
                });

                $("body").on("click", "#DeleteProduct", function() {
                    const id = $(this).data("id");
                    deleteProductFromCart(id);
                    updateGrandTotalWithShippingAndTax();
                });

                $("body").on("click", "#addQty", function() {
                    const id = $(this).data("id");
                    updateQuantity(id, 'add');
                    updateGrandTotalWithShippingAndTax();
                });

                $("body").on("click", "#removeQty", function() {
                    const id = $(this).data("id");
                    updateQuantity(id, 'remove');
                    updateGrandTotalWithShippingAndTax();
                });

                $("#shipping, #orderTax").on("input", function() {
                    updateGrandTotalWithShippingAndTax();
                });

                $("#shipping, #orderTax, #discount, #inputGroupSelect02").on("input change", function() {
                    updateGrandTotalWithShippingAndTax();
                });
            }

            function fetchAndRenderProducts(page) {
                // If an AJAX request is already in progress, do nothing
                if (isFetching) {
                    return;
                }

                // Set the flag to indicate that a request is in progress
                isFetching = true;

                // Fetch and render products
                $.ajax({
                    url: routes.getProducts,
                    type: "GET",
                    dataType: "json",
                    data: {
                        page: page, // Pass the current page to the server
                        warehouse_id: $("#warehouse_id").val(), // Pass the selected warehouse
                        category_id: $(".category-item.CategorySelected").data(
                            "id"), // Pass the selected category
                    },
                    success: function(data) {
                        renderProducts(data);
                        renderPagination(data);
                        history.pushState({
                            page: page
                        }, null, `?page=${page}`);
                    },
                    error: function(data) {
                        console.log(data);
                    },
                    complete: function() {
                        // Reset the flag when the request is complete
                        isFetching = false;
                    },
                });
            }

            function renderPagination(productsData) {
                const totalPages = productsData.last_page;
                const paginationContainer = $("#pagination-container");
                paginationContainer.empty();

                const hasPreviousPage = currentPage > 1;
                const hasNextPage = currentPage < totalPages;

                // Render "First" button and disable it if there's no previous page
                const firstButton =
                    `<button class="btn btn-outline-primary btn-sm mx-1 pagination-link" data-page="1" ${hasPreviousPage ? '' : 'disabled'}>First</button>`;
                // Render "Previous" button and disable it if there's no previous page
                const previousButton =
                    `<button class="btn btn-outline-primary btn-sm mx-1 pagination-link" data-page="${hasPreviousPage ? currentPage - 1 : currentPage}" ${hasPreviousPage ? '' : 'disabled'}><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg></button>`;
                // Render "Next" button and disable it if there's no next page
                const nextButton =
                    `<button class="btn btn-outline-primary btn-sm mx-1 pagination-link" data-page="${hasNextPage ? currentPage + 1 : currentPage}" ${hasNextPage ? '' : 'disabled'}><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                    </svg></button>`;
                // Render "Last" button and disable it if there's no next page
                const lastButton =
                    `<button class="btn btn-outline-primary btn-sm mx-1 pagination-link" data-page="${hasNextPage ? totalPages : currentPage}" ${hasNextPage ? '' : 'disabled'}>Last</button>`;

                paginationContainer.append(firstButton);
                paginationContainer.append(previousButton);

                for (let i = 1; i <= totalPages; i++) {
                    paginationContainer.append(`
            <button class="btn btn-outline-primary btn-sm mx-1 pagination-link ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>
        `);
                }

                paginationContainer.append(nextButton);
                paginationContainer.append(lastButton);

                // Add click event for pagination links
                paginationContainer.on("click", ".pagination-link", function() {
                    const page = $(this).data("page");
                    currentPage = page;
                    fetchAndRenderProducts(page);
                });
            }




            // Fetch and render products on page load
            fetchAndRenderProducts(currentPage);

            function renderProducts(data) {
                elements.productsBox.empty(); // Clear existing products
                data.data.forEach(renderProduct);
            }

            function renderProduct(element) {
                // Render individual product
                if (element.img_path == null) {
                    element.img_path = 'no_image.png';
                }
                elements.productsBox.append(`
                <div class="col-lg-4 col-md-6 col-sm-6 product-card" data-id="${element.id}" data-price="${element.price}" data-name="${element.name}" data-img_path="${element.img_path}">
                    <div class="card cursor-pointer">
                        <img src="/images/products/${element.img_path}" class="card-img-top" alt="">
                        <div class="card-body pos-card-product">
                            <p class="text-gray-600">${element.name}</p>
                            <h6 class="title m-0"> {{ $currency }} ${element.price}</h6>
                        </div>
                        <div class="quantity"></div>
                    </div>
                </div>
            `);
            }

            function playClickSound() {
                // Play click sound
                const clickSound = document.getElementById("clickSound");
                if (clickSound) {
                    clickSound.play();
                }
            }

            function addToCart(id, price, name, img_path) {
                // Add to cart
                $.ajax({
                    url: routes.addToCart,
                    type: "POST",
                    token: "{{ csrf_token() }}",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    data: {
                        id,
                        price,
                        name,
                        img_path,
                        warehouse_id: $("#warehouse_id").val()
                    },
                    success: function(response) {
                        if (response.message) {
                            toastr.error('Out of stock');
                        } else {
                            updateCartBox(response);
                        }
                    },
                    error: function(data) {
                        console.log("Error:", data);
                    }
                });
            }

            function deleteProductFromCart(id) {
                // Delete product from cart
                $.ajax({
                    url: routes.deleteProductFromCart,
                    type: "POST",
                    token: "{{ csrf_token() }}",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    data: {
                        id
                    },
                    success: updateCartBox
                });
            }

            function updateQuantity(id, action) {
                // Update quantity
                const route = action === 'add' ? routes.addQuantity : routes.removeQuantity;

                $.ajax({
                    url: route,
                    type: "POST",
                    token: "{{ csrf_token() }}",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    data: {
                        id: id,
                        warehouse_id: $("#warehouse_id").val()
                    },
                    success: function(responseData) {
                        if (responseData.message === 'Out of stock') {
                            toastr.error('Out of stock');
                        }
                        updateCartBox(responseData); // Call updateCartBox with the response data
                        checkCartItemsAndEnableWarehouseSelect();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }

            function updateCartBox(responseData) {
                // Update cart box
                elements.cartItems.empty();

                // Assign the responseData to the global data variable
                data = responseData;

                grandTotal = 0;

                for (const detailId in data.cart) {
                    if (data.cart.hasOwnProperty(detailId)) {
                        const detail = data.cart[detailId];
                        renderCartItem(detail);
                        grandTotal += detail.price * detail.quantity;
                    }
                }

                updateGrandTotalWithShippingAndTax();
                checkCartItemsAndEnableWarehouseSelect();
            }

            function updateGrandTotal(total, taxNet) {
                // Update grand total without changing previous calculation
                total = total.toFixed(2);
                $("#GrandTotal").text(total);

                // Assuming you have an element for TaxNet, update its value
                $("#TaxNet").text(taxNet.toFixed(2));

                $("#paying_amount_badge").text("Grand Total: " + total);
            }

            function renderCartItem(detail) {
                // Render cart item
                if (detail.img_path == null) {
                    detail.img_path = 'no_image.png';
                }
                elements.cartItems.append(`
                <div class="cart-item box-shadow-3">
                    <div class="d-flex align-items-center">
                        <img src="/images/products/${detail.img_path}" alt="">
                        <div>
                            <p class="text-gray-600 m-0 font_12">${detail.name}</p>
                            <h6 class="fw-semibold m-0 font_16">{{ $currency }} ${detail.price * detail.quantity}</h6>
                            <a title="Delete" id="DeleteProduct" data-id="${detail.id}"
                                class="cursor-pointer ul-link-action text-danger">
                                <i class="i-Close-Window"></i>
                            </a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="increment-decrement btn btn-light rounded-circle" id="removeQty" data-id="${detail.id}" ${detail.quantity <= 1 ? 'disabled' : ''}>-</span>
                        <input class="fw-semibold cart-qty m-0 px-2" readonly value="${detail.quantity}">
                        <span class="increment-decrement btn btn-light rounded-circle" id="addQty" data-id="${detail.id}">+</span>
                    </div>
                </div>
            `);
                // Disable the button if the quantity is 1 or less
                if (detail.quantity <= 1) {
                    $(`#removeQty[data-id='${detail.id}']`).prop('disabled', true);
                }
            }

            function updateGrandTotalWithShippingAndTax() {
                // Get the shipping amount from the "shipping" field
                const shippingAmount = parseFloat($("#shipping").val()) || 0;

                // Get the order tax percentage from the "orderTax" field
                const orderTaxPercentage = parseFloat($("#orderTax").val()) || 0;

                // Get the discount amount based on user input
                const discountType = elements.discountSelect.val();
                const discountInput = parseFloat(elements.discountInput.val()) || 0;

                // Calculate discount amount based on type (fixed or percentage)
                const discountAmount = calculateDiscountAmount(grandTotal, discountType, discountInput);

                $("#discountAmount").text(discountAmount);
                // Calculate product amount after discount
                const productAmountAfterDiscount = Math.max(grandTotal - discountAmount, 0);

                // Calculate total without discount
                const totalWithoutDiscount = productAmountAfterDiscount;

                // Calculate TaxNet
                const taxNet = (totalWithoutDiscount * orderTaxPercentage) / 100;

                // Update grand total including shipping, tax, and product amounts
                const newGrandTotal = productAmountAfterDiscount + shippingAmount + taxNet;

                // Update cart box including shipping, tax, and product amounts
                elements.cartItems.empty();
                for (const detailId in data.cart) {
                    if (data.cart.hasOwnProperty(detailId)) {
                        const detail = data.cart[detailId];
                        renderCartItem(detail);
                    }
                }

                // Update grand total with TaxNet without changing the previous calculation
                updateGrandTotal(newGrandTotal, taxNet);
            }



            function calculateDiscountAmount(total, type, value) {
                if (type === "percent") {
                    return (total * value) / 100;
                } else if (type === "fixed") {
                    return value;
                } else {
                    return 0;
                }
            }

            // Print Category
            function GetCategories() {
                $.ajax({
                    url: "{{ route('GetCategories') }}",
                    type: "GET",
                    success: function(data) {
                        $("#CategoryUl").empty();

                        // Add a li for showing all categories
                        $("#CategoryUl").append(`
                            <li class="category-item" data-id="all" id="Category">
                                <i class="i-Bookmark"></i>All Categories
                            </li>
                        `);

                        // Add li elements for each category
                        $.each(data, function(key, value) {
                            $("#CategoryUl").append(`
                                <li class="category-item" data-id="${value.id}" id="Category">
                                    <i class="i-Bookmark"></i>${value.name}
                                </li>
                            `);
                        });

                        // Handle click events on category items
                        $("#CategoryUl").on("click", ".category-item", function() {
                            // Remove the 'selected' class from all category items
                            $(".category-item").removeClass("CategorySelected");

                            // Add the 'selected' class to the clicked category item
                            $(this).addClass("CategorySelected");

                            // Get the selected category and warehouse IDs
                            const selectedCategory = $(this).data("id");
                            const selectedWarehouse = $("#warehouse_id").val();

                            // Make the AJAX request
                            ProductByCategory(selectedCategory, selectedWarehouse, "Category");
                        });
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }


            GetCategories();

            $("body").on("click", "#Category", function() {
                const id = $(this).data("id");

                // Get the selected category and warehouse IDs
                const selectedCategory = $(this).data("id");
                const selectedWarehouse = $("#warehouse_id").val();

                // Make the AJAX request
                ProductByCategory(selectedCategory, selectedWarehouse, "Category");
            });

            function renderProductsByCategory(products) {
                elements.productsBox.empty();
                if (Array.isArray(products)) {
                    products.forEach(renderProduct);
                } else {
                    console.error("Invalid data format: expected an array of products", products);
                }
            }

            function ProductByCategory(categoryId, warehouseId, type) {
                $.ajax({
                    url: "{{ route('ProductByCategory') }}",
                    type: "POST",
                    token: "{{ csrf_token() }}",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    data: {
                        category_id: categoryId,
                        warehouse_id: warehouseId,
                        type: type
                    },
                    success: function(data) {
                        if (Array.isArray(data.products)) {
                            renderProductsByCategory(data.products);
                        } else {}
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        });

        $("#PayNow").click(function(e) {
            $("#form_Update_Detail").modal("show");
            e.preventDefault();
        });

        $("#save_pos").click(function(e) {
            $("#form_Update_Detail").modal("hide");
            e.preventDefault();
            $.ajax({
                url: "{{ url('pos/create_pos') }}",
                type: "POST",
                token: "{{ csrf_token() }}",
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                data: {
                    date: $("#date").val(),
                    warehouse_id: $("#warehouse_id").val(),
                    client_id: $("#customer_id").val(),
                    tax_rate: $("#orderTax").val(),
                    TaxNet: $("#TaxNet").text(),
                    discount: $("#discount").val(),
                    discount_type: $("#inputGroupSelect02").val(),
                    discount_percent_total: $("#discountAmount").text(),
                    shipping: $("#shipping").val(),
                    GrandTotal: $("#GrandTotal").text(),
                    notes: $("#note").val(),
                    paying_amount: $("#paying_amount").val(),
                    payment_method_id: $("#payment_method_id").val(),
                    account_id: $("#account_id").val(),
                    sale_note: $("#sale_note").val(),
                },
                success: function(data) {
                    if (data.success) {
                        $("#form_Update_Detail").modal("hide");
                        $("#form_Update_Detail").trigger("reset");
                        // $("#sale_table").DataTable().ajax.reload();
                        console.log(data.id);
                        toastr.success(data.message);
                        window.open("{{ url('invoice_pos') }}/"+data.id, "_blank");
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                    console.log(data);
                },
                error: function(data) {
                    console.log(data);
                }
            })
        });
    </script>

</body>

</html>

<style>
    .CategorySelected {
        background-color: #f5f5f5;
        color: #4E97FD;
        border-radius: 5px;
    }

    .autocomplete-result-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: none;
        /* Start with display: none; */
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: absolute;
        width: 100%;
        background-color: #fff;
        z-index: 1;
        transition: opacity 0.3s ease-in-out;
        /* Apply transition on opacity */
    }

    .autocomplete-result-list li {
        padding: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
        /* Apply transition on background-color */
    }

    .autocomplete-result-list li:hover {
        background-color: #f2f2f2;
    }
</style>
