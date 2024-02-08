<section class="layout-header card rounded-0">
    <div class="d-flex align-items-center">
        @include('layouts.new-sidebar.mobile-sidebar')
        <button class="toggle-button d-none d-lg-block btn btn-light p-2">
            @include('components.icons.toggle2', ['class' => 'width_20'])
        </button>

        <div class="dropdown layouts_add_new">
            <button class="btn btn-light d-none d-lg-flex align-items-center px-3 py-2 fw-semibold" type="button"
                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                @include('components.icons.plus', ['class' => 'me-2 width_14'])
                <span>{{ __('translate.Add_new') }}</span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                @can('user_add')
                    <li><a class="dropdown-item" href="/user-management/users"> <i
                                class="i-Administrator text-20 me-2 "></i> {{ __('translate.Add user') }}</a></li>
                @endcan
                @can('client_add')
                    <li><a class="dropdown-item" href="/people/clients"> <i class="i-Business-Mens text-20 me-2 "></i>
                            {{ __('translate.Add Client') }}</a></li>
                @endcan
                @can('suppliers_add')
                    <li><a class="dropdown-item" href="/people/suppliers"> <i class="i-Business-Mens text-20 me-2 "></i>
                            {{ __('translate.Add Supplier') }}</a></li>
                @endcan
                @can('products_add')
                    <li><a class="dropdown-item" href="/products/products/create"> <i class="i-Library-2 text-20 me-2 "></i>
                            {{ __('translate.AddProduct') }}</a></li>
                @endcan
                @can('sales_add')
                    <li><a class="dropdown-item" href="/sale/sales/create"> <i class="i-Full-Cart text-20 me-2 "></i>
                            {{ __('translate.AddSale') }}</a></li>
                @endcan
                @can('purchases_add')
                    <li><a class="dropdown-item" href="/purchase/purchases/create"> <i class="i-Receipt text-20 me-2 "></i>
                            {{ __('translate.AddPurchase') }}</a></li>
                @endcan
                @can('adjustment_add')
                    <li><a class="dropdown-item" href="/adjustment/adjustments/create"> <i
                                class="i-Edit-Map text-20 me-2 "></i> {{ __('translate.CreateAdjustment') }}</a></li>
                @endcan
                @can('transfer_add')
                    <li><a class="dropdown-item" href="/transfer/transfers/create"> <i class="i-Back text-20 me-2 "></i>
                            {{ __('translate.CreateTransfer') }}</a></li>
                @endcan
                @can('quotations_add')
                    <li><a class="dropdown-item" href="/quotation/quotations/create"> <i
                                class="i-Checkout-Basket text-20 me-2 "></i> {{ __('translate.Add_Quotation') }}</a></li>
                @endcan

            </ul>
        </div>
    </div>

    <div class="d-flex align-items-center button_pos">
        @can('pos')
            <a href="/pos" class="btn btn-outline-primary fw-bolder">
                {{ __('translate.POS') }}
            </a>
        @endcan
        @can('pos')
            <a href="{{ route('OrderListShow') }}" class="btn btn-outline-success ms-3 fw-bolder">
                Order List
            </a>
        @endcan

        <button class="btn p-2 ms-4" data-fullscreen>
            @include('components.icons.expand', ['class' => 'width_20'])
        </button>


        @php
            $unreadNotificationsCount = App\Models\NotificationDetail::where('user_id', Auth::user()->id)
                ->where('status', 0)
                ->count();
        @endphp
        <!-- Notification container -->
        <div class="notification">
            <a href="#">
                <div class="notBtn" href="#" id="notification-container" data-unread-count="{{ $unreadNotificationsCount }}">
                    <!-- Number supports double digits and automatically hides itself when there is nothing between divs -->
                    <i class="fa fa-bell text-dark pt-2 ps-2" style="font-size: 20px !important;"></i>
                    <div class="box">
                        <a href="javascript:void(0)">
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4"> <label for="markread" id="markread" class="mt-2">Mark All As Read</label></div>
                                </div>
                           
                        </a>
                        <div class="display">
                            <!-- Notification list will be dynamically appended here -->
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <div class="button_language dropdown p-2 ms-2">

            <i class="i-Globe" type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>

            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('language.switch', 'en') }}"> <img class="flag-icon"
                            src="{{ asset('assets/flags/gb.svg') }}"> {{ __('translate.English') }}</a></li>
                <li><a class="dropdown-item" href="{{ route('language.switch', 'fr') }}"><img class="flag-icon"
                            src="{{ asset('assets/flags/fr.svg') }}"> {{ __('translate.Frensh') }}</a></li>
                <li><a class="dropdown-item" href="{{ route('language.switch', 'ar') }}"><img class="flag-icon"
                            src="{{ asset('assets/flags/sa.svg') }}"> {{ __('translate.Arabic') }}</a></li>

            </ul>
        </div>

        <div class="dropdown button_settings">
            <img alt="" width="42" height="42" type="button" data-bs-toggle="dropdown"
                aria-expanded="false" class="rounded-circle dropdown-toggle"
                src="{{ asset('images/avatar/' . Auth::user()->avatar) }}">
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/profile">{{ __('translate.profil') }}</a></li>
                @can('settings')
                    <li><a class="dropdown-item" href="/settings/system_settings">{{ __('translate.Settings') }}</a></li>
                @endcan
                <li><a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('translate.logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <input type="hidden" name="notification_id" id="notification_id">

    <!-- Modal -->
    <div class="modal fade" id="notificationmodal" tabindex="-1" aria-labelledby="notificationmodalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationmodalLabel">Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="notification-details">
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var initialUnreadCount = {{ $unreadNotificationsCount ?? 0 }};
</script>
<script>
     document.getElementById('markread').addEventListener('click', function() {
        // Send an AJAX request to update notification statuses
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route('mark-all-as-read') }}', true); // Adjust the route accordingly
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                // On success, reload the notifications or update the UI as needed
                fetchNotifications(); // Assuming you have a function to fetch and update notifications
            } else {
                console.error('Error marking all notifications as read:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Network error while marking all notifications as read');
        };

        xhr.send();
    });
    // $(document).ready(function() {
    //     function fetchNotifications() {
    //         $.ajax({
    //             url: '{{ route('fetch-notifications') }}',
    //             method: 'GET',
    //             dataType: 'json',
    //             headers: {
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //             },
    //             success: function(response) {
    //                 updateNotifications(response.unreadNotificationsCount, response.notifications);
    //             },
    //             error: function(error) {
    //                 console.error('Error fetching notifications:', error);
    //             }
    //         });
    //     }

    //     function updateNotifications(unreadNotificationsCount, notifications) {
    //         var notificationContainer = document.getElementById('notification-container');

    //         if (unreadNotificationsCount > 0) {
    //             $("#notification-container").addClass('notBtn1');
    //             // toastr.warning(unreadNotificationsCount + ' new notifications.');
    //         }

    //         if (unreadNotificationsCount == 0) {
    //             $("#notification-container").removeClass('notBtn1');
    //         }

    //         if (notificationContainer) {
    //             var notificationList = $('.display'); // Use jQuery selector to get the display element
    //             if (notificationList) {
    //                 notificationList.empty(); // Clear existing content
    //                 notifications.forEach(function(notification) {
    //                     var notificationDiv = $('<div>').addClass('sec');
    //                     if (notification.notification_detail.some(detail => detail.user_id ===
    //                             {{ Auth::user()->id }} && detail.status === 0)) {
    //                         notificationDiv.addClass('new');
    //                     }

    //                     var link = $('<a>');
    //                     var txtDiv = $('<div>').addClass('txt').text(notification.messages);
    //                         var subTxtDiv = $('<div>').addClass('txt sub').text(moment(notification.created_at).fromNow());

    //                     if (notification.notification_detail.some(detail => detail.user_id ===
    //                             {{ Auth::user()->id }} && detail.status === 0)) {
    //                         txtDiv.addClass('boldtxt');
    //                         subTxtDiv.append(' (unread)');
    //                     }

    //                     link.append(txtDiv, subTxtDiv);
    //                     notificationDiv.append(link,
    //                     subTxtDiv); // Append subTxtDiv to notificationDiv here
    //                     notificationList.append(notificationDiv);
    //                 });
    //             }

    //         }

    //     }


    //     updateNotifications({{ $unreadNotificationsCount }}, {!! json_encode($notifications) !!});

    //     setInterval(fetchNotifications, 5000);
    // });



    document.addEventListener('DOMContentLoaded', function() {
        function fetchNotifications() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('fetch-notifications') }}', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    var response = JSON.parse(xhr.responseText);
                    updateNotifications(response.unreadNotificationsCount, response.notifications);
                } else {
                    console.error('Error fetching notifications:', xhr.statusText);
                }
            };

            xhr.onerror = function() {
                console.error('Network error while fetching notifications');
            };

            xhr.send();
        }

        function updateNotifications(unreadNotificationsCount, notifications) {
            var notificationContainer = document.getElementById('notification-container');

            if (unreadNotificationsCount > 0) {
                notificationContainer.classList.add('notBtn1');
                // toastr.warning(unreadNotificationsCount + ' new notifications.');
            }

            if (unreadNotificationsCount === 0) {
                notificationContainer.classList.remove('notBtn1');
            }

            if (notificationContainer) {
                var notificationList = document.querySelector('.display');
                if (notificationList) {
                    while (notificationList.firstChild) {
                        notificationList.removeChild(notificationList.firstChild);
                    }

                    if (notifications.length === 0) {
                        var noNotificationMessage = document.createElement('div');
                        noNotificationMessage.textContent = 'No Notifications';
                        noNotificationMessage.classList.add('no-notification'); // Add your desired class here
                        notificationList.appendChild(noNotificationMessage);
                    } else {
                        notifications.forEach(function(notification) {
                            var notificationDiv = document.createElement('div');
                            notificationDiv.classList.add('sec');
                            // if (notification.notification_detail.some(function(detail) {
                            //         return detail.user_id === {{ Auth::user()->id }} && detail
                            //             .status === 0;
                            //     })) {
                            //     notificationDiv.classList.add('new');
                            // }

                            if (notification.status == 0) {
                                notificationDiv.classList.add('new');
                            }

                            var link = document.createElement('a');
                            var txtDiv = document.createElement('div');
                            // Add the data-bs-toggle and data-bs-target attributes
                            txtDiv.setAttribute('data-bs-toggle', 'modal');
                            txtDiv.setAttribute('data-bs-target', '#notificationmodal');
                            txtDiv.setAttribute('data-id', notification.id);
                            txtDiv.classList.add('notificationBox'); // Use class instead of ID

                            txtDiv.classList.add('txt');
                            txtDiv.textContent = notification.messages;

                            var subTxtDiv = document.createElement('div');
                            subTxtDiv.classList.add('txt', 'sub');
                            subTxtDiv.textContent = moment(notification.created_at).fromNow();

                            if (notification.status == 0) {
                                txtDiv.classList.add('boldtxt');
                                subTxtDiv.textContent += ' (unread)';
                            }

                            link.appendChild(txtDiv);
                            link.appendChild(subTxtDiv);
                            notificationDiv.appendChild(link);
                            notificationList.appendChild(notificationDiv);

                            // Add event listener to the modal within the loop
                            txtDiv.addEventListener('click', function() {
                                var id = this.getAttribute('data-id');
                                document.getElementById('notification_id').value = id;

                                var xhr = new XMLHttpRequest();
                                var url = '{{ route('fetch-notifications-message') }}?id=' +
                                    id; // Include id in the URL
                                xhr.open('GET', url, true);
                                xhr.setRequestHeader('Content-Type', 'application/json');
                                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                                xhr.onload = function() {
                                    if (xhr.status >= 200 && xhr.status < 300) {
                                        var response = JSON.parse(xhr.responseText);
                                        document.getElementById('notification-details')
                                            .innerHTML = ' ';
                                        document.getElementById('notification-details')
                                            .innerHTML = response.notificationDetails.notification.messages;
                                    } else {
                                        console.error('Error fetching notifications:', xhr
                                            .statusText);
                                    }
                                };

                                xhr.onerror = function() {
                                    console.error(
                                        'Network error while fetching notifications');
                                };

                                xhr.send();
                            });
                        });
                    }
                }
            }
        }

        updateNotifications({{ $unreadNotificationsCount }}, {!! json_encode($notifications) !!});

        setInterval(fetchNotifications, 5000);
    });
</script>
<style>
    .box::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #F5F5F5;
        border-radius: 5px;
    }

    .box::-webkit-scrollbar {
        width: 10px;
        background-color: #F5F5F5;
        border-radius: 5px;
    }

    .box::-webkit-scrollbar-thumb {
        background-color: rgb(43, 43, 43);
        border-radius: 5px;
    }

    .notification {
        position: relative;
        display: inline-block;
    }

    .notBtn1 {
        transition: 0.5s;
        cursor: pointer
    }

    .notBtn1::before {
        content: '';
        position: absolute;
        top: 6px;
        /* Adjust the top position */
        left: 18px;
        /* Adjust the left position */
        width: 10px;
        height: 10px;
        background-color: red;
        border-radius: 50%;
        border: 1px solid #ffffff;
    }


    .box {
        overflow-x: hidden;
        width: 400px;
        height: 0;
        border-radius: 10px;
        transition: 0.5s;
        position: absolute;
        overflow-y: scroll;
        padding: 0px;
        left: -300px;
        margin-top: 5px;
        background-color: #F4F4F4;
        -webkit-box-shadow: 10px 10px 23px 0px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 10px 10px 23px 0px rgba(0, 0, 0, 0.1);
        box-shadow: 10px 10px 23px 0px rgba(0, 0, 0, 0.1);
        cursor: context-menu;
        z-index: 999;
    }

    .fas:hover {
        color: #d63031;
    }

    .notBtn:hover>.box {
        height: 60vh
    }

    .content {
        padding: 20px;
        color: black;
        vertical-align: middle;
        text-align: left;
    }

    .gry {
        background-color: #F4F4F4;
    }

    .top {
        color: black;
        padding: 10px
    }

    .display {
        position: relative;
    }

    .cont {
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: #F4F4F4;
    }

    .cont:empty {
        display: none;
    }

    .stick {
        text-align: center;
        display: block;
        font-size: 50pt;
        padding-top: 70px;
        padding-left: 80px
    }

    .stick:hover {
        color: black;
    }

    .cent {
        text-align: center;
        display: block;
    }

    .sec {
        padding: 10px 5px;
        background-color: #F4F4F4;
        transition: 0.5s;
        text-align: center;
    }

    .profCont {
        padding-left: 15px;
    }

    .profile {
        -webkit-clip-path: circle(50% at 50% 50%);
        clip-path: circle(50% at 50% 50%);
        width: 75px;
        float: left;
    }

    .txt {
        vertical-align: top;
        font-size: 17px;
        padding-top: 5px;
        padding-bottom: 5px;
        padding-left: 40px;
        padding-right: 40px;
        text-align: center;
        color: rgb(82, 82, 82);
    }

    .boldtxt {
        font-weight: bolder;
        color: rgb(43, 43, 43);
    }

    .sub {
        /* font-size: 1rem; */
        font-size: 13px;
        color: grey;
        border-bottom: 2px solid rgba(130, 130, 130, 0.514);
    }

    .new {
        border-style: none none solid none;
        border-color: rgb(255, 84, 84);
    }

    .sec:hover {
        background-color: #BFBFBF;
    }

    .no-notification {
        text-align: center;
        padding: 10px;
        color: rgb(82, 82, 82);
        font-size: 15px;
        font-weight: bolder;
        background-color: #F4F4F4;
        transition: 0.5s;
        margin-top: 5px;
        border-radius: 10px;
        margin-bottom: 5px;
        margin-top: 20px;
    }
</style>
