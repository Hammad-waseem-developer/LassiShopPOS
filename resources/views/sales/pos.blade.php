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

                            <!-- Modal Update Detail Product -->
                            {{-- <validation-observer ref="Update_Detail">
                <div class="modal fade" id="form_Update_Detail" tabindex="-1" role="dialog"
                  aria-labelledby="form_Update_Detail" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">@{{ detail.name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form @submit.prevent="submit_Update_Detail">
                          <div class="row">

                            <!-- Unit Price -->
                            <div class="form-group col-md-6">
                              <validation-provider name="Product Price"
                                :rules="{ required: true , regex: /^\d*\.?\d*$/}" v-slot="validationContext">
                                <label for="Unit_price">{{ __('translate.Product_Price') }}
                                  <span class="field_required">*</span></label>
                                <input :state="getValidationState(validationContext)"
                                  aria-describedby="Unit_price-feedback"v-model.number="detail.Unit_price" type="text"
                                  class="form-control">
                                <span class="error">@{{ validationContext.errors[0] }}</span>
                              </validation-provider>
                            </div>

                            <!-- Tax Method -->
                            <div class="form-group col-md-6">
                              <validation-provider name="Tax Method" rules="required" v-slot="{ valid, errors }">
                                <label>{{ __('translate.Tax_Method') }} <span class="field_required">*</span></label>
                                <v-select placeholder="{{ __('translate.Choose_Method') }}" v-model="detail.tax_method"
                                  :reduce="(option) => option.value" :options="
                        [
                          {label: 'Exclusive', value: '1'},
                          {label: 'Inclusive', value: '2'}
                        ]">
                                </v-select>
                                <span class="error">@{{ errors[0] }}</span>
                              </validation-provider>
                            </div>

                            <!-- Tax Rate -->
                            <div class="form-group col-md-6">
                              <validation-provider name="Order Tax" :rules="{ required: true , regex: /^\d*\.?\d*$/}"
                                v-slot="validationContext">
                                <label for="ordertax">{{ __('translate.Order_Tax') }}
                                  <span class="field_required">*</span></label>
                                <div class="input-group">
                                  <input :state="getValidationState(validationContext)"
                                    aria-describedby="OrderTax-feedback" v-model="detail.tax_percent" type="text"
                                    class="form-control">
                                  <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                  </div>
                                </div>
                                <span class="error">@{{ validationContext.errors[0] }}</span>
                              </validation-provider>
                            </div>

                            <!-- Discount Method -->
                            <div class="form-group col-md-6">
                              <validation-provider name="Discount_Method" rules="required" v-slot="{ valid, errors }">
                                <label>{{ __('translate.Discount_Method') }} <span
                                    class="field_required">*</span></label>
                                <v-select placeholder="{{ __('translate.Choose_Method') }}"
                                  v-model="detail.discount_Method" :reduce="(option) => option.value" :options="
                        [
                          {label: 'Percent %', value: '1'},
                          {label: 'Fixed', value: '2'}
                        ]">
                                </v-select>
                                <span class="error">@{{ errors[0] }}</span>
                              </validation-provider>
                            </div>

                            <!-- Discount Rate -->
                            <div class="form-group col-md-6">
                              <validation-provider name="Discount" :rules="{ required: true , regex: /^\d*\.?\d*$/}"
                                v-slot="validationContext">
                                <label for="discount">{{ __('translate.Discount') }}
                                  <span class="field_required">*</span></label>
                                <input :state="getValidationState(validationContext)"
                                  aria-describedby="Discount-feedback" v-model="detail.discount" type="text"
                                  class="form-control">
                                <span class="error">@{{ validationContext.errors[0] }}</span>
                              </validation-provider>
                            </div>

                            <!-- Unit Sale -->
                            <div class="form-group col-md-6" v-if="detail.product_type != 'is_service'">
                              <validation-provider name="UnitSale" rules="required" v-slot="{ valid, errors }">
                                <label>{{ __('translate.Unit_Sale') }} <span class="field_required">*</span></label>
                                <v-select v-model="detail.sale_unit_id" :reduce="label => label.value"
                                  placeholder="{{ __('translate.Choose_Unit_Sale') }}"
                                  :options="units.map(units => ({label: units.name, value: units.id}))">
                                </v-select>
                                <span class="error">@{{ errors[0] }}</span>
                              </validation-provider>
                            </div>

                            <!-- imei_number -->
                            <div class="form-group col-md-12" v-show="detail.is_imei">
                              <label for="imei_number">{{ __('translate.Add_product_IMEI_Serial_number') }}</label>
                              <input v-model="detail.imei_number" type="text" class="form-control"
                                placeholder="{{ __('translate.Add_product_IMEI_Serial_number') }}">
                            </div>

                            <div class="col-lg-12">
                              <button type="submit" :disabled="Submit_Processing_detail" class="btn btn-primary">
                                <span v-if="Submit_Processing_detail" class="spinner-border spinner-border-sm"
                                  role="status" aria-hidden="true"></span> <i class="i-Yes me-2 font-weight-bold"></i>
                                {{ __('translate.Submit') }}
                              </button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </validation-observer> --}}

                            <!-- Modal add sale payment -->
                            {{-- <validation-observer ref="add_payment_sale">
                <div class="modal fade" id="add_payment_sale" tabindex="-1" role="dialog"
                  aria-labelledby="add_payment_sale" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">{{ __('translate.AddPayment') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form @submit.prevent="Submit_Payment()">
                          <div class="row">

                              <div class="col-md-6">
                                  <validation-provider name="date" rules="required" v-slot="validationContext">
                                    <div class="form-group">
                                      <label for="picker3">{{ __('translate.Date') }}</label>
                  
                                      <input type="text" 
                                        :state="getValidationState(validationContext)" 
                                        aria-describedby="date-feedback" 
                                        class="form-control" 
                                        placeholder="{{ __('translate.Select_Date') }}"  
                                        id="datetimepicker" 
                                        v-model="payment.date">
                  
                                      <span class="error">@{{ validationContext.errors[0] }}</span>
                                    </div>
                                  </validation-provider>
                                </div>

                            <!-- Paying_Amount -->
                            <div class="form-group col-md-6">
                              <validation-provider name="Montant à payer"
                                :rules="{ required: true , regex: /^\d*\.?\d*$/}" v-slot="validationContext">
                                <label for="Paying_Amount">{{ __('translate.Paying_Amount') }}
                                  <span class="field_required">*</span></label>
                                <input @keyup="Verified_paidAmount(payment.montant)"
                                  :state="getValidationState(validationContext)"
                                  aria-describedby="Paying_Amount-feedback" v-model.number="payment.montant"
                                  placeholder="{{ __('translate.Paying_Amount') }}" type="text" class="form-control">
                                <div class="error">
                                  @{{ validationContext.errors[0] }}</div>

                                @if ($symbol_placement == 'before')
                                   <span class="badge badge-danger mt-2">{{ __('translate.Total') }} : {{$currency}}  @{{ GrandTotal.toLocaleString('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
}) }} </span>
                                @else
                                   <span class="badge badge-danger mt-2">{{ __('translate.Total') }} : @{{ GrandTotal.toLocaleString('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
}) }} {{$currency}}</span>
                                @endif

                              </validation-provider>
                            </div>

                            <div class="form-group col-md-6">
                              <validation-provider name="Payment choice" rules="required"
                                  v-slot="{ valid, errors }">
                                  <label> {{ __('translate.Payment_choice') }}<span
                                          class="field_required">*</span></label>
                                  <v-select @input="Selected_Payment_Method" 
                                        placeholder="{{ __('translate.Choose_Payment_Choice') }}"
                                      :class="{'is-invalid': !!errors.length}"
                                      :state="errors[0] ? false : (valid ? true : null)"
                                      v-model="payment.payment_method_id" :reduce="(option) => option.value" 
                                      :options="payment_methods.map(payment_methods => ({label: payment_methods.title, value: payment_methods.id}))">

                                  </v-select>
                                  <span class="error">@{{ errors[0] }}</span>
                              </validation-provider>
                          </div>

                          <div class="form-group col-md-6">
                              <label> {{ __('translate.Account') }} </label>
                              <v-select 
                                    placeholder="{{ __('translate.Choose_Account') }}"
                                  v-model="payment.account_id" :reduce="(option) => option.value" 
                                  :options="accounts.map(accounts => ({label: accounts.account_name, value: accounts.id}))">

                              </v-select>
                          </div>

                            <div class="form-group col-md-6">
                              <label for="note">{{ __('translate.Payment_note') }}
                              </label>
                              <textarea type="text" v-model="payment.notes" class="form-control" name="note" id="note"
                                placeholder="{{ __('translate.Payment_note') }}"></textarea>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="note">{{ __('translate.sale_note') }}
                              </label>
                              <textarea type="text" v-model="sale.notes" class="form-control" name="note" id="note"
                                placeholder="{{ __('translate.sale_note') }}"></textarea>
                            </div>
                          </div>

                          <div class="row mt-3">

                            <div class="col-lg-6">
                              <button type="submit" class="btn btn-primary" :disabled="paymentProcessing">
                                <span v-if="paymentProcessing" class="spinner-border spinner-border-sm" role="status"
                                  aria-hidden="true"></span> <i class="i-Yes me-2 font-weight-bold"></i>
                                {{ __('translate.Submit') }}
                              </button>

                            </div>

                          </div>

                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </validation-observer> --}}

                        </div>

                        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mt-3">
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="row" id="products-box">
                                        {{-- @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                      <div class="card product-card cursor-pointer">
                        <img src="'/images/products/'"{{ $product->img_path ? $product->img_path : 'default' }} alt="">
                        <div class="card-body pos-card-product">
                          <p class="text-gray-600">{{$product->name}}</p>
                          <h6 class="title m-0"> {{$product->price}}</h6>
                        </div>
                        <div class="quantity">
                          <span></span>
                        </div>
                      </div>
                    </div>
                    @endforeach --}}

                                        <div class="d-flex justify-content-center">
                                        </div>

                                    </div>
                                </div>

                                <div class="d-md-block col-12 col-lg-4">
                                    <div class="card category-card">
                                        <div class="category-head">
                                            <h5 class="fw-semibold m-0">{{ __('translate.All_Category') }}</h5>
                                        </div>
                                        <ul class="p-0">
                                            <li class="category-item" @click="Selected_Category('')"
                                                :class="{ 'active': category_id === '' }">
                                                <i class="i-Bookmark"></i> {{ __('translate.All_Category') }}
                                            </li>
                                            <li class="category-item" @click="Selected_Category(category.id)"
                                                v-for="category in categories" :key="category.id"
                                                :class="{ 'active': category.id === category_id }">
                                                <i class="i-Bookmark"></i> @{{ category.name }}
                                            </li>
                                        </ul>
                                        <nav aria-label="Page navigation example mt-3">
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
                                        </nav>

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

    <script>
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
                });

                $("body").on("click", "#addQty", function() {
                    const id = $(this).data("id");
                    updateQuantity(id, 'add');
                });

                $("body").on("click", "#removeQty", function() {
                    const id = $(this).data("id");
                    updateQuantity(id, 'remove');
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
                    success: updateCartBox,
                    error: function(data) {
                        console.log(data);
                    }
                });
            }

            function updateCartBox(data) {
                // Update cart box
                elements.cartItems.empty();

                let grandTotal = 0;

                for (const detailId in data.cart) {
                    if (data.cart.hasOwnProperty(detailId)) {
                        const detail = data.cart[detailId];
                        renderCartItem(detail);
                        grandTotal += detail.price * detail.quantity;
                    }
                }

                updateGrandTotal(grandTotal);
            }

            function updateGrandTotal(total) {
                // Update grand total
                $("#GrandTotal").text(total.toFixed(2));
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
      });
    </script>

</body>

</html>
