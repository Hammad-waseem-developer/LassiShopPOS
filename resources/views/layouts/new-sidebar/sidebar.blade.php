<?php
$path = Request::path();
$parentPath = explode('/', $path)[0];
$setting = DB::table('settings')
    ->where('deleted_at', '=', null)
    ->first();
?>

<!-- start sidebar -->
<div x-data="{ isCompact: false }" :class="isCompact ? 'compact' : ''" class="sidebar-content bg-gray-900 card rounded-0">
    <div class="sidebar-header mb-5 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img class="app-logo me-2" width="100" src="{{ asset('images/' . $setting->logo) }}" alt="">
        </div>
        <button @click="isCompact = !isCompact"
            class="compact-button btn border border-gray-600 d-none d-lg-flex align-items-center p-1 width_24">
            @include('components.icons.collapse', ['class' => 'width_16'])
        </button>
        <button class="close-sidebar btn border border-gray-600 d-flex d-lg-none align-items-center p-1 width_24">
            @include('components.icons.collapse', ['class' => 'width_16'])
        </button>
    </div>

    <!-- user -->
    <div class="scroll-nav" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul x-data="collapse('{{ $parentPath }}')" class="list-group" id="menu">
            {{-- Dashboard --}}
            <li class="">
                <a href="/" class="nav-item @if ($path == 'dashboard/admin') active @endif">
                    @include('components.icons.dashboard', ['class' => 'width_16'])
                    <span class="item-name">{{ __('translate.dashboard') }}</span>
                </a>
            </li>

            {{-- User Management --}}
            @if (auth()->user()->can('user_view') ||
                    auth()->user()->can('group_permission'))
                <li>
                    <div @click="selectCollapse('user-management')"
                        :class="selected == 'user-management' ? 'collapse-active' : 'collapse-deactive'"
                        class="collapse-button">
                        @include('components.sidebar.collapse-navitem', [
                            'title' => __('translate.UserManagement'),
                            'icon' => 'components.icons.user',
                        ])
                    </div>
                    <div x-ref="user-management" x-bind:style="activeCollapse($refs, 'user-management', selected)"
                        class="collapse-content">
                        <ul class="list-group">
                            @can('user_view')
                                <li class="">
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/user-management/users',
                                        'title' => __('translate.Users'),
                                    ])
                                </li>
                            @endcan
                            @can('group_permission')
                                <li class="">
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/user-management/permissions',
                                        'title' => __('translate.Roles'),
                                    ])
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif


            {{-- People --}}
            @if (auth()->user()->can('client_view_all') ||
                    auth()->user()->can('client_view_own') ||
                    auth()->user()->can('suppliers_view_all') ||
                    auth()->user()->can('suppliers_view_own'))
                <li>
                    <div @click="selectCollapse('people')"
                        :class="selected == 'people' ? 'collapse-active' : 'collapse-deactive'" class="collapse-button">
                        @include('components.sidebar.collapse-navitem', [
                            'title' => __('translate.People'),
                            'icon' => 'components.icons.customers',
                        ])
                    </div>
                    <div x-ref="people" x-bind:style="activeCollapse($refs, 'people', selected)"
                        class="collapse-content">
                        <ul class="list-group">
                            @if (auth()->user()->can('client_view_all') ||
                                    auth()->user()->can('client_view_own'))
                                <li class="">
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/people/clients',
                                        'title' => __('translate.Customers'),
                                    ])
                                </li>
                            @endif
                            @if (auth()->user()->can('suppliers_view_all') ||
                                    auth()->user()->can('suppliers_view_own'))
                                <li class="">
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/people/suppliers',
                                        'title' => __('translate.Suppliers'),
                                    ])
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif

            {{-- HRM --}}
            <li>
                <div @click="selectCollapse('HRM')" :class="selected == 'HRM' ? 'collapse-active' : 'collapse-deactive'"
                    class="collapse-button">
                    <div class="d-flex align-items-center">
                        <svg class="" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 10C9.20938 10 11 8.20906 11 6C11 3.79094 9.20938 2 7 2C4.79063 2 3 3.79094 3 6C3 8.20906 4.79063 10 7 10ZM8.58438 11.5H5.41563C2.42406 11.5 0 13.925 0 16.9156C0 17.5156 0.485 18 1.08312 18H12.9156C13.5156 18 14 17.5156 14 16.9156C14 13.925 11.575 11.5 8.58438 11.5Z"
                                fill="currentColor"></path>
                            <path
                                d="M14.9647 12H12.6536C14.0916 13.1781 14.9929 14.9406 14.9929 16.9156C14.9929 17.3156 14.874 17.6844 14.6799 18H18.9986C19.5525 18 20 17.55 20 16.9719C20 14.2375 17.7593 12 14.9647 12ZM13.4907 10C15.4279 10 16.9957 8.43437 16.9957 6.5C16.9957 4.56562 15.4279 3 13.4907 3C12.7049 3 11.9873 3.26734 11.4028 3.70344C11.7633 4.39469 11.9886 5.16875 11.9886 6C11.9886 7.11 11.6153 8.12938 11 8.95969C11.635 9.6 12.5143 10 13.4907 10Z"
                                fill="#4B566B"></path>
                        </svg>
                        <span class="item-name">HRM</span>
                    </div>
                    <svg class="collapse-icon" width="5" height="8" viewBox="0 0 5 8" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 7L4 4L1 1" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </div>
                <div x-ref="HRM" x-bind:style="activeCollapse($refs, 'HRM', selected)" class="collapse-content"
                    style="">
                    <ul class="list-group">
                        <li class="">
                            <a href="{{ route('department.index') }}" class="nav-item child-nav">
                                <span class="prefix rounded-circle"></span>
                                <span class="item-name">Departments</span>
                            </a>                            
                        </li>
                        <li class="">
                            <a href="#" class="nav-item child-nav ">
                                <span class="prefix rounded-circle"></span>
                                <span class="item-name">Designation</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#" class="nav-item child-nav ">
                                <span class="prefix rounded-circle"></span>
                                <span class="item-name">Office</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#" class="nav-item child-nav ">
                                <span class="prefix rounded-circle"></span>
                                <span class="item-name">Employee Shift</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#" class="nav-item child-nav ">
                                <span class="prefix rounded-circle"></span>
                                <span class="item-name">Attendance</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#" class="nav-item child-nav ">
                                <span class="prefix rounded-circle"></span>
                                <span class="item-name">Leave Type</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#" class="nav-item child-nav ">
                                <span class="prefix rounded-circle"></span>
                                <span class="item-name">Leave Request</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#" class="nav-item child-nav ">
                                <span class="prefix rounded-circle"></span>
                                <span class="item-name">Holidays</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- HRM end     --}}

            {{-- Products --}}
            @if (auth()->user()->can('products_add') ||
                    auth()->user()->can('products_view') ||
                    auth()->user()->can('category') ||
                    auth()->user()->can('brand') ||
                    auth()->user()->can('unit') ||
                    auth()->user()->can('warehouse') ||
                    auth()->user()->can('print_labels'))
                <li>
                    <div @click="selectCollapse('products')"
                        :class="selected == 'products' ? 'collapse-active' : 'collapse-deactive'"
                        class="collapse-button">
                        @include('components.sidebar.collapse-navitem', [
                            'title' => __('translate.Products'),
                            'icon' => 'components.icons.product',
                        ])
                    </div>

                    <div x-ref="products" x-bind:style="activeCollapse($refs, 'products', selected)"
                        class="collapse-content">
                        <ul class="list-group">
                            @can('products_view')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/products/products',
                                        'title' => __('translate.productsList'),
                                    ])
                                </li>
                            @endcan
                            @can('products_add')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/products/products/create',
                                        'title' => __('translate.AddProduct'),
                                    ])
                                </li>
                            @endcan
                            @can('print_labels')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/products/print_labels',
                                        'title' => __('translate.Print_Labels'),
                                    ])
                                </li>
                            @endcan
                            @can('category')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/products/categories',
                                        'title' => __('translate.Categories'),
                                    ])
                                </li>
                            @endcan
                            @can('unit')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/products/units',
                                        'title' => __('translate.Units'),
                                    ])
                                </li>
                            @endcan
                            @can('brand')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/products/brands',
                                        'title' => __('translate.Brand'),
                                    ])
                                </li>
                            @endcan
                            @can('warehouse')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/products/warehouses',
                                        'title' => __('translate.Warehouses'),
                                    ])
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Stock Adjustment --}}
            @if (auth()->user()->can('adjustment_view_all') ||
                    auth()->user()->can('adjustment_view_own') ||
                    auth()->user()->can('adjustment_add'))
                <li>
                    <div @click="selectCollapse('adjustment')"
                        :class="selected == 'adjustment' ? 'collapse-active' : 'collapse-deactive'"
                        class="collapse-button">
                        @include('components.sidebar.collapse-navitem', [
                            'title' => __('translate.StockAdjustement'),
                            'icon' => 'components.icons.store',
                        ])
                    </div>

                    <div x-ref="adjustment" x-bind:style="activeCollapse($refs, 'adjustment', selected)"
                        class="collapse-content">
                        <ul class="list-group">
                            @if (auth()->user()->can('adjustment_view_all') ||
                                    auth()->user()->can('adjustment_view_own'))
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/adjustment/adjustments',
                                        'title' => __('translate.ListAdjustments'),
                                    ])
                                </li>
                            @endif
                            @can('adjustment_add')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/adjustment/adjustments/create',
                                        'title' => __('translate.CreateAdjustment'),
                                    ])
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Stock Transfer --}}
            @if (auth()->user()->can('transfer_view_all') ||
                    auth()->user()->can('transfer_view_own') ||
                    auth()->user()->can('transfer_add'))
                <li>
                    <div @click="selectCollapse('transfer')"
                        :class="selected == 'transfer' ? 'collapse-active' : 'collapse-deactive'"
                        class="collapse-button">
                        @include('components.sidebar.collapse-navitem', [
                            'title' => __('translate.StockTransfers'),
                            'icon' => 'components.icons.refund',
                        ])
                    </div>
                    <div x-ref="transfer" x-bind:style="activeCollapse($refs, 'transfer', selected)"
                        class="collapse-content">
                        <ul class="list-group">
                            @if (auth()->user()->can('transfer_view_all') ||
                                    auth()->user()->can('transfer_view_own'))
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/transfer/transfers',
                                        'title' => __('translate.ListTransfers'),
                                    ])
                                </li>
                            @endif
                            @can('transfer_add')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/transfer/transfers/create',
                                        'title' => __('translate.CreateTransfer'),
                                    ])
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Quotations --}}
            @if (auth()->user()->can('quotations_view_all') ||
                    auth()->user()->can('quotations_view_own') ||
                    auth()->user()->can('quotations_add'))
                <li>
                    <div @click="selectCollapse('quotation')"
                        :class="selected == 'quotation' ? 'collapse-active' : 'collapse-deactive'"
                        class="collapse-button">
                        @include('components.sidebar.collapse-navitem', [
                            'title' => __('translate.Quotations'),
                            'icon' => 'components.icons.order',
                        ])
                    </div>
                    <div x-ref="quotation" x-bind:style="activeCollapse($refs, 'quotation', selected)"
                        class="collapse-content">
                        <ul class="list-group">
                            @if (auth()->user()->can('quotations_view_all') ||
                                    auth()->user()->can('quotations_view_own'))
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/quotation/quotations',
                                        'title' => __('translate.All_Quotations'),
                                    ])
                                </li>
                            @endif
                            @can('quotations_add')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/quotation/quotations/create',
                                        'title' => __('translate.Add_Quotation'),
                                    ])
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Purchases --}}
            @if (auth()->user()->can('purchases_view_all') ||
                    auth()->user()->can('purchases_view_own') ||
                    auth()->user()->can('purchases_add'))
                <li>
                    <div @click="selectCollapse('purchase')"
                        :class="selected == 'purchase' ? 'collapse-active' : 'collapse-deactive'"
                        class="collapse-button">
                        @include('components.sidebar.collapse-navitem', [
                            'title' => __('translate.Purchases'),
                            'icon' => 'components.icons.cart',
                        ])
                    </div>
                    <div x-ref="purchase" x-bind:style="activeCollapse($refs, 'purchase', selected)"
                        class="collapse-content">
                        <ul class="list-group">
                            @if (auth()->user()->can('purchases_view_all') ||
                                    auth()->user()->can('purchases_view_own'))
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/purchase/purchases',
                                        'title' => __('translate.ListPurchases'),
                                    ])
                                </li>
                            @endif
                            @can('purchases_add')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/purchase/purchases/create',
                                        'title' => __('translate.AddPurchase'),
                                    ])
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Sales --}}
            @if (auth()->user()->can('sales_view_all') ||
                    auth()->user()->can('sales_view_own') ||
                    auth()->user()->can('sales_add'))
                <li>
                    <div @click="selectCollapse('sale')"
                        :class="selected == 'sale' ? 'collapse-active' : 'collapse-deactive'" class="collapse-button">
                        @include('components.sidebar.collapse-navitem', [
                            'title' => __('translate.Sales'),
                            'icon' => 'components.icons.add-to-cart',
                        ])
                    </div>
                    <div x-ref="sale" x-bind:style="activeCollapse($refs, 'sale', selected)"
                        class="collapse-content">
                        <ul class="list-group">
                            @if (auth()->user()->can('sales_view_all') ||
                                    auth()->user()->can('sales_view_own'))
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/sale/sales',
                                        'title' => __('translate.ListSales'),
                                    ])
                                </li>
                            @endif
                            @can('sales_add')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/sale/sales/create',
                                        'title' => __('translate.AddSale'),
                                    ])
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Sales Return --}}
            @if (auth()->user()->can('sale_returns_view_all') ||
                    auth()->user()->can('sale_returns_view_own'))
                <li class="">
                    <a href="/sales-return/returns_sale"
                        class="nav-item @if ($path == 'sales-return/returns_sale') active @endif">
                        @include('components.icons.sales-return', ['class' => 'width_16'])
                        <span class="item-name">{{ __('translate.SalesReturn') }}</span>
                    </a>
                </li>
            @endif

            {{-- Purchase Return --}}
            @if (auth()->user()->can('purchase_returns_view_all') ||
                    auth()->user()->can('purchase_returns_view_own'))
                <li class="">
                    <a href="/purchase-return/returns_purchase"
                        class="nav-item @if ($path == 'purchase-return/returns_purchase') active @endif">
                        @include('components.icons.purchases-return', ['class' => 'width_16'])
                        <span class="item-name">{{ __('translate.PurchasesReturn') }}</span>
                    </a>
                </li>
            @endif

            {{-- Accounting --}}
            @if (auth()->user()->can('account_view') ||
                    auth()->user()->can('deposit_view') ||
                    auth()->user()->can('expense_view') ||
                    auth()->user()->can('expense_category') ||
                    auth()->user()->can('deposit_category') ||
                    auth()->user()->can('payment_method'))
                <li>
                    <div @click="selectCollapse('accounting')"
                        :class="selected == 'accounting' ? 'collapse-active' : 'collapse-deactive'"
                        class="collapse-button">
                        @include('components.sidebar.collapse-navitem', [
                            'title' => __('translate.Accounting'),
                            'icon' => 'components.icons.account',
                        ])
                    </div>
                    <div x-ref="accounting" x-bind:style="activeCollapse($refs, 'accounting', selected)"
                        class="collapse-content">
                        <ul class="list-group">
                            @can('account_view')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/accounting/account',
                                        'title' => __('translate.Account'),
                                    ])
                                </li>
                            @endcan
                            @can('deposit_view')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/accounting/deposit',
                                        'title' => __('translate.Deposit'),
                                    ])
                                </li>
                            @endcan
                            @can('expense_view')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/accounting/expense',
                                        'title' => __('translate.Expense'),
                                    ])
                                </li>
                            @endcan
                            @can('expense_category')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/accounting/expense_category',
                                        'title' => __('translate.Expense_Category'),
                                    ])
                                </li>
                            @endcan
                            @can('deposit_category')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/accounting/deposit_category',
                                        'title' => __('translate.Deposit_Category'),
                                    ])
                                </li>
                            @endcan
                            @can('payment_method')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/accounting/payment_methods',
                                        'title' => __('translate.Payment_Methods'),
                                    ])
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Settings --}}
            @if (auth()->user()->can('settings') ||
                    auth()->user()->can('backup') ||
                    auth()->user()->can('currency') ||
                    auth()->user()->can('sms_settings') ||
                    auth()->user()->can('notification_template') ||
                    auth()->user()->can('pos_settings'))
                <li>
                    <div @click="selectCollapse('settings')"
                        :class="selected == 'settings' ? 'collapse-active' : 'collapse-deactive'"
                        class="collapse-button">
                        @include('components.sidebar.collapse-navitem', [
                            'title' => __('translate.Settings'),
                            'icon' => 'components.icons.settings',
                        ])
                    </div>
                    <div x-ref="settings" x-bind:style="activeCollapse($refs, 'settings', selected)"
                        class="collapse-content">
                        <ul class="list-group">
                            @can('settings')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/settings/system_settings',
                                        'title' => __('translate.System_Settings'),
                                    ])
                                </li>
                            @endcan

                            @can('pos_settings')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/settings/pos_settings',
                                        'title' => __('translate.Pos_Receipt_Settings'),
                                    ])
                                </li>
                            @endcan

                            @can('sms_settings')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/settings/sms_settings',
                                        'title' => __('translate.sms_settings'),
                                    ])
                                </li>
                            @endcan
                            @can('notification_template')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/settings/sms_template',
                                        'title' => __('translate.sms_template'),
                                    ])
                                </li>

                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/settings/emails_template',
                                        'title' => __('translate.emails_template'),
                                    ])
                                </li>
                            @endcan
                            @can('currency')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/settings/currency',
                                        'title' => __('translate.Currency'),
                                    ])
                                </li>
                            @endcan
                            @can('backup')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/settings/backup',
                                        'title' => __('translate.Backup'),
                                    ])
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif

            {{-- Reports --}}
            @if (auth()->user()->can('report_products') ||
                    auth()->user()->can('report_inventaire') ||
                    auth()->user()->can('report_clients') ||
                    auth()->user()->can('report_fournisseurs') ||
                    auth()->user()->can('reports_alert_qty') ||
                    auth()->user()->can('report_profit') ||
                    auth()->user()->can('sale_reports') ||
                    auth()->user()->can('purchase_reports') ||
                    auth()->user()->can('payment_sale_reports') ||
                    auth()->user()->can('payment_purchase_reports') ||
                    auth()->user()->can('payment_return_purchase_reports') ||
                    auth()->user()->can('payment_return_sale_reports'))
                <li>
                    <div @click="selectCollapse('reports')"
                        :class="selected == 'reports' ? 'collapse-active' : 'collapse-deactive'"
                        class="collapse-button">
                        @include('components.sidebar.collapse-navitem', [
                            'title' => __('translate.Reports'),
                            'icon' => 'components.icons.reports',
                        ])
                    </div>
                    <div x-ref="reports" x-bind:style="activeCollapse($refs, 'reports', selected)"
                        class="collapse-content">
                        <ul class="list-group">

                            @can('report_profit')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/reports/report_profit',
                                        'title' => __('translate.ProfitandLoss'),
                                    ])
                                </li>
                            @endcan

                            @can('sale_reports')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/reports/sale_report',
                                        'title' => __('translate.SalesReport'),
                                    ])
                                </li>
                            @endcan
                            @can('purchase_reports')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/reports/purchase_report',
                                        'title' => __('translate.PurchasesReport'),
                                    ])
                                </li>
                            @endcan

                            @can('report_inventaire')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/reports/report_stock',
                                        'title' => __('translate.Inventory_report'),
                                    ])
                                </li>
                            @endcan
                            @can('report_products')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/reports/report_product',
                                        'title' => __('translate.product_report'),
                                    ])
                                </li>
                            @endcan

                            @can('report_clients')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/reports/report_clients',
                                        'title' => __('translate.CustomersReport'),
                                    ])
                                </li>
                            @endcan
                            @can('report_fournisseurs')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/reports/report_providers',
                                        'title' => __('translate.SuppliersReport'),
                                    ])
                                </li>
                            @endcan

                            @can('payment_sale_reports')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/reports/payment_sale',
                                        'title' => __('translate.payment_sale'),
                                    ])
                                </li>
                            @endcan
                            @can('payment_purchase_reports')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/reports/payment_purchase',
                                        'title' => __('translate.payment_purchase'),
                                    ])
                                </li>
                            @endcan
                            @can('payment_return_sale_reports')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/reports/payment_sale_return',
                                        'title' => __('translate.payment_sale_return'),
                                    ])
                                </li>
                            @endcan
                            @can('payment_return_purchase_reports')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/reports/payment_purchase_return',
                                        'title' => __('translate.payment_purchase_return'),
                                    ])
                                </li>
                            @endcan
                            @can('reports_alert_qty')
                                <li>
                                    @include('components.sidebar.child-navitem', [
                                        'href' => '/reports/reports_quantity_alerts',
                                        'title' => __('translate.ProductQuantityAlerts'),
                                    ])
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</div>
