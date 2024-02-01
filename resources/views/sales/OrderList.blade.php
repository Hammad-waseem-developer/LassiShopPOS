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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
    <style>
        body {
            background-color: #2a2a2a !important;
        }

        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px
        }

        .image {
            max-width: 270px;
            max-height: 200px;
        }
    </style>

    {{-- Alpine Js --}}
    <script defer src="{{ asset('js/plugin-core/alpine-collapse.js') }}"></script>
    <script defer src="{{ asset('js/plugin-core/alpine.js') }}"></script>
    <script src="{{ asset('js/plugin-script/alpine-data.js') }}"></script>
    <script src="{{ asset('js/plugin-script/alpine-store.js') }}"></script>

</head>

<body class="sidebar-toggled sidebar-fixed-page pos-body">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mt-5 mb-5">
                <img src="{{ asset('images/') }}/{{ $settings->logo }}" class="img-fluid" width="120px"
                    alt="">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div id="orderListContainer" class="card-container">
                <div class="col-md-4">
                    <!-- OrderList content will be dynamically updated here -->
                </div>
            </div>
        </div>
    </div>

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

    <script>
        $(document).ready(function() {
            function updateOrderListCards(orderList) {
                var container = $('#orderListContainer');
                container.empty();

                if (!orderList || orderList.length === 0) {
                    container.append('<p>No orders found.</p>');
                }
                $.each(orderList, function(index, item) {
                    var card = $('<div class="card p-2 text-center" style="width: 18rem; height: 20rem;">');
                    card.append('<img src="/images/products/' + item.img_path +
                        '" class="card-img-top image img-fluid m-0 p-0" alt="Product Image">');
                    card.append('<div class="card-body m-0 p-0">');
                    card.append('<h4 class="card-title m-0 p-0">' + item.name + '</h4>');
                    card.append('<p class="card-text p-0 mb-2">Quantity: ' + item.quantity + '</p>');

                    var buttonContainer = $(
                        '<div class="d-flex justify-content-center align-items-center gap-2">');
                    var completeOrderBtn1 = $(
                        '<a href="#" id="completeOrder" data-id="' + item.id +
                        '" class="btn btn-success">Complete Order</a>');
                    var completeOrderBtn2 = $('<a href="#" id="undoOrder" data-id="' + item.id +
                        '" class="btn btn-danger">Undo</a>');

                    buttonContainer.append(completeOrderBtn1);
                    buttonContainer.append(completeOrderBtn2);

                    card.append(buttonContainer);
                    card.append('</div>');
                    container.append(card);
                });

            }

            function fetchOrderList() {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('OrderList') }}',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    dataType: 'json',
                    success: function(response) {
                        updateOrderListCards(response.OrderList);
                    },
                    error: function(error) {
                        console.error('Error fetching OrderList:', error);
                    }
                });
            }

            fetchOrderList();

            setInterval(function() {
                fetchOrderList();
            }, 5000);

            $("body").on('click', '#completeOrder', function() {
                var orderId = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('complete_order') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order_id: orderId
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        fetchOrderList();
                    },
                    error: function(error) {
                        console.error('Error fetching OrderList:', error);
                    }
                })
            });

            $("body").on('click', '#undoOrder', function() {
                var orderId = $(this).data('id');
                undoOrder(orderId);
            });

            function undoOrder(orderId) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('undo_order') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order_id: orderId
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    dataType: 'json',
                    success: function(response) {
                        fetchOrderList();
                    },
                    error: function(error) {
                        console.error('Error fetching OrderList:', error);
                    }
                })
            }

        })
    </script>

</body>

</html>
