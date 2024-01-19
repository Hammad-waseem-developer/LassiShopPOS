@extends('layouts.master')
@section('main-content')
@section('page-css')

    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/nprogress.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/flatpickr.min.css') }}">

@endsection


<div class="breadcrumb">

    <h1>{{ __('translate.Departments') }}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row" id="section_Client_list">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="text-end mb-3">
                    @can('client_add')
                        <a class="btn btn-outline-primary btn-md m-1" href="{{ route('department.create') }}"><i
                                class="i-Add me-2 font-weight-bold"></i>
                            {{ __('translate.Create') }}</a>
                    @endcan
                </div>
                <div class="table-responsive">
                    <table id="client_list_table" class="display table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="not_show">{{ __('Department Name') }}</th>
                                <th>{{ __('Department Head') }}</th>
                                <th>{{ __('translate.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $department)
                                <tr>
                                    <td>{{ $department->id }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ $department->dept_head }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-info btn-rounded dropdown-toggle"
                                                id="dropdownMenuButton" type="button" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"
                                                fdprocessedid="d4xzwx">Action</button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                                x-placement="top-start"
                                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -88px, 0px);">
                                               <a class="dropdown-item" href="{{ route('department.edit', $department) }}"><i
                                                        class="nav-icon i-Edit font-weight-bold mr-2"></i> Edit
                                                    Departments</a>
                                                    {{-- <a
                                                    class="dropdown-item delete cursor-pointer" data-id="{{ $department->id }}"{{ route("department.destroy", $department)}}> <i
                                                        class="nav-icon i-Close-Window font-weight-bold mr-2"></i>
                                                    Delete Departments</a> --}}
                                                     <a
                                                    class="dropdown-item delete cursor-pointer" data-id="{{ $department->id }}"> <i
                                                        class="nav-icon i-Close-Window font-weight-bold mr-2"></i>
                                                    Delete Departments</a>
                                                </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Modal add sale payment -->
    <validation-observer ref="add_payment_sale">
        <div class="modal fade" id="add_payment_sale" tabindex="-1" role="dialog" aria-labelledby="add_payment_sale"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('translate.pay_all_sell_due_at_a_time') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="Submit_Payment()">
                            <div class="row">

                                <!-- Date -->
                                <div class="col-md-6">
                                    <validation-provider name="date" rules="required" v-slot="validationContext">
                                        <div class="form-group">
                                            <label for="picker3">{{ __('translate.Date') }}</label>

                                            <input type="text" :state="getValidationState(validationContext)"
                                                aria-describedby="date-feedback" class="form-control"
                                                placeholder="{{ __('translate.Select_Date') }}" id="datetimepicker"
                                                v-model="payment.date">
                                            <span class="error">@{{ validationContext.errors[0] }}</span>
                                        </div>
                                    </validation-provider>
                                </div>

                                <!-- Paying_Amount -->
                                <div class="form-group col-md-6">
                                    <validation-provider name="Montant à payer"
                                        :rules="{ required: true, regex: /^\d*\.?\d*$/ }" v-slot="validationContext">
                                        <label for="Paying_Amount">{{ __('translate.Paying_Amount') }}
                                            <span class="field_required">*</span></label>
                                        <input @keyup="Verified_paidAmount(payment.montant)"
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="Paying_Amount-feedback" v-model.number="payment.montant"
                                            placeholder="{{ __('translate.Paying_Amount') }}" type="text"
                                            class="form-control">
                                        <div class="error">@{{ validationContext.errors[0] }}</div>
                                        <span class="badge badge-danger">reste à payer : {{ $currency }}
                                            @{{ sell_due }}</span>
                                    </validation-provider>
                                </div>

                                <div class="form-group col-md-6">
                                    <validation-provider name="Payment choice" rules="required"
                                        v-slot="{ valid, errors }">
                                        <label> {{ __('translate.Payment_choice') }}<span
                                                class="field_required">*</span></label>
                                        <v-select @input="Selected_Payment_Method"
                                            placeholder="{{ __('translate.Choose_Payment_Choice') }}"
                                            :class="{ 'is-invalid': !!errors.length }"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                            v-model="payment.payment_method_id" :reduce="(option) => option.value"
                                            :options="payment_methods.map(payment_methods => ({ label: payment_methods.title,
                                                value: payment_methods.id }))">

                                        </v-select>
                                        <span class="error">@{{ errors[0] }}</span>
                                    </validation-provider>
                                </div>


                                <div class="form-group col-md-6">
                                    <label> {{ __('translate.Account') }} </label>
                                    <v-select placeholder="{{ __('translate.Choose_Account') }}"
                                        v-model="payment.account_id" :reduce="(option) => option.value"
                                        :options="accounts.map(accounts => ({ label: accounts.account_name, value: accounts.id }))">

                                    </v-select>
                                </div>


                                <div class="form-group col-md-12">
                                    <label for="note">{{ __('translate.Please_provide_any_details') }}
                                    </label>
                                    <textarea type="text" v-model="payment.notes" class="form-control" name="note" id="note"
                                        placeholder="{{ __('translate.Please_provide_any_details') }}"></textarea>
                                </div>

                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary" :disabled="paymentProcessing">
                                        <span v-if="paymentProcessing" class="spinner-border spinner-border-sm"
                                            role="status" aria-hidden="true"></span> <i
                                            class="i-Yes me-2 font-weight-bold"></i>
                                        {{ __('translate.Submit') }}
                                    </button>

                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </validation-observer>

    <!-- Modal add return payment -->
    <validation-observer ref="add_payment_return">
        <div class="modal fade" id="add_payment_return" tabindex="-1" role="dialog"
            aria-labelledby="add_payment_return" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('translate.pay_all_sell_return_due_at_a_time') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="Submit_Payment_sell_return_due()">
                            <div class="row">


                                <!-- Date -->
                                <div class="col-md-6">
                                    <validation-provider name="date" rules="required" v-slot="validationContext">
                                        <div class="form-group">
                                            <label for="picker3">{{ __('translate.Date') }}</label>

                                            <input type="text" :state="getValidationState(validationContext)"
                                                aria-describedby="date-feedback" class="form-control"
                                                placeholder="{{ __('translate.Select_Date') }}" id="datetimepicker"
                                                v-model="payment_return.date">
                                            <span class="error">@{{ validationContext.errors[0] }}</span>
                                        </div>
                                    </validation-provider>
                                </div>

                                <!-- Paying_Amount -->
                                <div class="form-group col-md-6">
                                    <validation-provider name="Montant à payer"
                                        :rules="{ required: true, regex: /^\d*\.?\d*$/ }" v-slot="validationContext">
                                        <label for="Paying_Amount">{{ __('translate.Paying_Amount') }}
                                            <span class="field_required">*</span></label>
                                        <input @keyup="Verified_return_paidAmount(payment_return.montant)"
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="Paying_Amount-feedback"
                                            v-model.number="payment_return.montant"
                                            placeholder="{{ __('translate.Paying_Amount') }}" type="text"
                                            class="form-control">
                                        <div class="error">@{{ validationContext.errors[0] }}</div>
                                        <span class="badge badge-danger">reste à payer : {{ $currency }}
                                            @{{ return_due }}</span>
                                    </validation-provider>
                                </div>

                                <div class="form-group col-md-6">
                                    <validation-provider name="Payment choice" rules="required"
                                        v-slot="{ valid, errors }">
                                        <label> {{ __('translate.Payment_choice') }}<span
                                                class="field_required">*</span></label>
                                        <v-select @input="Selected_return_Payment_Method"
                                            placeholder="{{ __('translate.Choose_Payment_Choice') }}"
                                            :class="{ 'is-invalid': !!errors.length }"
                                            :state="errors[0] ? false : (valid ? true : null)"
                                            v-model="payment_return.payment_method_id"
                                            :reduce="(option) => option.value"
                                            :options="payment_methods.map(payment_methods => ({ label: payment_methods.title,
                                                value: payment_methods.id }))">

                                        </v-select>
                                        <span class="error">@{{ errors[0] }}</span>
                                    </validation-provider>
                                </div>


                                <div class="form-group col-md-6">
                                    <label> {{ __('translate.Account') }} </label>
                                    <v-select placeholder="{{ __('translate.Choose_Account') }}"
                                        v-model="payment_return.account_id" :reduce="(option) => option.value"
                                        :options="accounts.map(accounts => ({ label: accounts.account_name, value: accounts.id }))">

                                    </v-select>
                                </div>


                                <div class="form-group col-md-12">
                                    <label for="note">{{ __('translate.Please_provide_any_details') }}
                                    </label>
                                    <textarea type="text" v-model="payment_return.notes" class="form-control" name="note" id="note"
                                        placeholder="{{ __('translate.Please_provide_any_details') }}"></textarea>
                                </div>

                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary"
                                        :disabled="payment_return_Processing">
                                        <span v-if="payment_return_Processing"
                                            class="spinner-border spinner-border-sm" role="status"
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
    </validation-observer>
</div>


@endsection

@section('page-js')

<script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/nprogress.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.min.js') }}"></script>


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
