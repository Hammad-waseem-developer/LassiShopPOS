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
                                    <label>{{ __('translate.Customer') }} <span class="field_required">*</span></label>
                                    <select name="customer_id" class="form-control" id="">
                                        <option value="">Select Customer</option>
                                        @foreach ($clients as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->username }}</option>
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
                                                            id="basic-addon3">$</span>
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
                                                        <option value="fixed">$</option>
                                                        <option value="percent">%</option>
                                                    </select>
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

                                    <button class="cart-btn btn btn-primary">
                                        {{ __('translate.Pay_Now') }}
                                    </button>

                                </div>

                            </form>

                        </div>

                        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mt-3">
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="row" id="products-box">

                                        <div class="d-flex justify-content-center">
                                        </div>

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
                                        {{-- <nav aria-label="Page navigation example mt-3">
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item" :class="{ 'disabled': currentPage_cat == 1 }">
                                                    <a class="page-link" href="#" aria-label="Previous"
                                                        @click.prevent="previousPage_Category">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                                <li class="page-item" v-for="i in pages_cat" :key="i"
                                                    :class="{ 'active': currentPage_cat == i }">
                                                    <a class="page-link" href="#"
                                                        @click.prevent="goToPage_Category(i)">@{{ i }}</a>
                                                </li>
                                                <li class="page-item"
                                                    :class="{ 'disabled': currentPage_cat == pages_cat }">
                                                    <a class="page-link" href="#" aria-label="Next"
                                                        @click.prevent="nextPage_Category">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav> --}}

                                    </div>

                                    <div class="card category-card">
                                        <div class="category-head">
                                            <h5 class="fw-semibold m-0">{{ __('translate.All_brands') }}</h5>
                                        </div>
                                        <ul class="p-0">
                                            <li class="category-item" @click="Selected_Brand('')"
                                                :class="{ 'active': brand_id === '' }">
                                                <i class="i-Bookmark"></i> {{ __('translate.All_brands') }}
                                            </li>
                                            <li class="category-item" @click="Selected_Brand(brand.id)"
                                                v-for="brand in brands" :key="brand.id"
                                                :class="{ 'active': brand.id === brand_id }">
                                                <i class="i-Bookmark"></i> @{{ brand.name }}
                                            </li>
                                        </ul>
                                        <nav aria-label="Page navigation example mt-3">
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item" :class="{ 'disabled': currentPage_brand == 1 }">
                                                    <a class="page-link" href="#" aria-label="Previous"
                                                        @click.prevent="previousPage_brand">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                                <li class="page-item" v-for="i in pages_brand" :key="i"
                                                    :class="{ 'active': currentPage_brand == i }">
                                                    <a class="page-link" href="#"
                                                        @click.prevent="goToPage_brand(i)">@{{ i }}</a>
                                                </li>
                                                <li class="page-item"
                                                    :class="{ 'disabled': currentPage_brand == pages_brand }">
                                                    <a class="page-link" href="#" aria-label="Next"
                                                        @click.prevent="nextPage_brand">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>


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

        $(document).ready(function() {
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

            initialize();

            function initialize() {
                fetchAndRenderProducts();

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

            function fetchAndRenderProducts() {
                // Fetch and render products
                $.ajax({
                    url: routes.getProducts,
                    type: "GET",
                    dataType: "json",
                    success: renderProducts,
                    error: function(data) {
                        console.log(data);
                    }
                });
            }

            function renderProducts(data) {
                // Render products
                data.forEach(renderProduct);
            }

            function renderProduct(element) {
                // Render individual product
                if (element.img_path == null) {
                    element.img_path = 'no_image.png';
                }
                elements.productsBox.append(`
                    <div class="col-lg-4 col-md-6 col-sm-6 product-card" data-id="${element.id}" data-price="${element.price}" data-name="${element.name}" data-img="${element.img_path}">
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
                        img_path
                    },
                    success: updateCartBox,
                    error: function(data) {
                        console.log(data);
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
                        id
                    },
                    success: function(responseData) {
                        updateCartBox(responseData); // Call updateCartBox with the response data
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
            }

            function updateGrandTotal(total) {
                // Update grand total
                total = total.toFixed(2);
                $("#GrandTotal").text(total);
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
                            <input class="fw-semibold cart-qty m-0 px-2" value="${detail.quantity}">
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
                const discountAmount = calculateDiscountAmount(grandTotal, discountType, discountInput);

                // Calculate tax amount only if the product amount is not zero after discount
                const productAmountAfterDiscount = Math.max(grandTotal - discountAmount, 0);
                const taxAmount = (productAmountAfterDiscount * orderTaxPercentage) / 100;

                // Update grand total including shipping, tax, and product amounts
                const newGrandTotal = productAmountAfterDiscount + shippingAmount + taxAmount;

                // Update cart box including shipping, tax, and product amounts
                elements.cartItems.empty();

                for (const detailId in data.cart) {
                    if (data.cart.hasOwnProperty(detailId)) {
                        const detail = data.cart[detailId];
                        renderCartItem(detail);
                    }
                }

                updateGrandTotal(newGrandTotal);
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
                        $.each(data, function(key, value) {
                            $("#CategoryUl").append(`
                                <li class="category-item" data-id="${value.id}" id="Category">
                                    <i class="i-Bookmark"></i>${value.name}
                                </li>
                        `);
                        });
                    },
                    error: function(data) {
                        console.log(data);
                    }
                })
            }

            GetCategories();

            $("body").on("click", "#Category", function() {
                const id = $(this).data("id");
                console.log(id);
                ProductByCategory(id);
            });


            function ProductByCategory(id) {
                $.ajax({
                    url: "{{ route('ProductByCategory') }}",
                    type: "POST",
                    token: "{{ csrf_token() }}",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    data: {
                        id
                    },
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }

        });
    </script>


</body>

</html>
