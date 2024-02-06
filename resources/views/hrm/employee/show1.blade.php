@extends('layouts.master')

@section('main-content')
@section('page-css')
@endsection

<div class="breadcrumb">
    <h1>{{ __('Employee Details') }}</h1>
    <div><a href="{{ route('employee.index') }}">{{ __('Employees') }}</a></div>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row" id="section_create_client">
    <div class="col-lg-12 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4 {{ $errors->has('first_name') ? 'has-error' : '' }}">
                        <label for="designation">{{ __('First Name') }} <span class="field_required">*</span></label>
                        <input type="text" class="form-control" name="first_name"
                            placeholder="{{ __('First Name') }}" value="{{ $employee->first_name ?? '' }}" readonly>

                    </div>
                    <div class="form-group col-md-4 {{ $errors->has('designation') ? 'has-error' : '' }}">
                        <label for="designation">{{ __('Last Name') }} <span class="field_required">*</span></label>
                        <input type="text" class="form-control" name="last_name" placeholder="{{ __('Last Name') }}"
                            value="{{ $employee->last_name ?? '' }}" readonly>

                    </div>
                    <div class="form-group col-md-4 {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <label for="designation">{{ __('Phone') }} <span class="field_required">*</span></label>
                        <input type="tel" class="form-control" name="phone" pattern="[0-9+()-]{4,20}"
                            title="Enter a valid phone number (4-20 digits)" placeholder="{{ __('Phone Number') }}"
                            value="{{ $employee->phone ?? '' }}" readonly>

                    </div>
                    <div class="form-group col-md-4 {{ $errors->has('office') ? 'has-error' : '' }}">
                        <label for="office">{{ __('office') }} <span class="field_required">*</span></label>
                        <input type="text" class="form-control" value="{{ $office->name ?? ''}}" readonly>
                    </div>
                    <div class="form-group col-md-4 {{ $errors->has('designation') ? 'has-error' : '' }}">
                        <label for="office">{{ __('Designation') }} <span class="field_required">*</span></label>
                        <input type="text" class="form-control" value="{{ $designations->name ?? '' }}" readonly>
                    </div>

                    <div class="form-group col-md-4 {{ $errors->has('department') ? 'has-error' : '' }}">
                        <label for="office">{{ __('Office Shift') }} <span class="field_required">*</span></label>
                        <input type="text" class="form-control" value="{{ $departments->name ?? '' }}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4 {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">{{ __('Email Address') }} <span class="field_required">*</span></label>
                        <input type="email" class="form-control" name="email"
                            placeholder="{{ __('Email Address') }}" value="{{ $employee->email ?? '' }}" readonly>

                    </div>
                    <div class="form-group col-md-4 {{ $errors->has('address') ? 'has-error' : '' }}">
                        <label for="address">{{ __('Address') }} <span class="field_required">*</span></label>
                        <input type="text" class="form-control" name="address" placeholder="{{ __('Address') }}"
                            value="{{ $employee->address ?? '' }}" readonly>

                    </div>
                    <div class="form-group col-md-4 {{ $errors->has('country') ? 'has-error' : '' }}">
                        <label for="country">{{ __('Country') }} <span class="field_required">*</span></label>
                        <input type="text" class="form-control" name="country" placeholder="{{ __('Country') }}"
                            value="{{ $employee->country ?? '' }}" readonly>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 {{ $errors->has('city') ? 'has-error' : '' }}">
                            <label for="City">{{ __('City') }} <span class="field_required">*</span></label>
                            <input type="text" class="form-control" name="city" placeholder="{{ __('City') }}"
                                value="{{ $employee->city ?? '' }}" readonly>
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('province') ? 'has-error' : '' }}">
                            <label for="province">{{ __('Province') }} <span class="field_required">*</span></label>
                            <input type="text" class="form-control" name="province"
                                placeholder="{{ __('Province') }}" value="{{ $employee->province ?? '' }}" readonly>
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('zip') ? 'has-error' : '' }}">
                            <label for="zip">{{ __('Zip') }} <span class="field_required">*</span></label>
                            <input type="number" class="form-control" name="zip"
                                placeholder="{{ __('Zip') }}" value="{{ $employee->zip ?? '' }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 {{ $errors->has('family_status') ? 'has-error' : '' }}">
                            <label for="family_status">{{ __('Family Status') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" class="form-control"
                                value="{{ $employee->family_status == 0 ? 'Single' : ($employee->family_status == 1 ? 'Married' : 'Divorced') }}"
                                readonly>
                        </div>


                        <div class="form-group col-md-4 {{ $errors->has('gender') ? 'has-error' : '' }}">
                            <label for="gender">{{ __('Gender') }} <span class="field_required">*</span></label>
                            <input type="text" class="form-control"
                                value="{{ $employee->gender == 0 ? 'Female' : 'Male' }}" readonly>
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('employment_type') ? 'has-error' : '' }}">
                            <label for="employment_type">{{ __('Employment Type') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" class="form-control"
                                value="{{ $employee->employment_type == 'full_time'
                                    ? 'Full Time'
                                    : ($employee->employment_type == 'part_time'
                                        ? 'Part Time'
                                        : ($employee->employment_type == 'self_employed'
                                            ? 'Self Employed'
                                            : ($employee->employment_type == 'contract'
                                                ? 'Contract'
                                                : ($employee->employment_type == 'internship'
                                                    ? 'Internship'
                                                    : ($employee->employment_type == 'seasonal'
                                                        ? 'Seasonal'
                                                        : ''))))) }}"
                                readonly>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 {{ $errors->has('birth_date') ? 'has-error' : '' }}">
                            <label for="birth_date">{{ __('Birth Date') }} <span
                                    class="field_required">*</span></label>
                            <input type="date" class="form-control" name="birth_date"
                                placeholder="{{ __('Birth Date') }}" value="{{ $employee->birth_date }}" readonly>
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('join_date') ? 'has-error' : '' }}">
                            <label for="join_date">{{ __('Joining Date') }} <span
                                    class="field_required">*</span></label>
                            <input type="date" class="form-control" name="join_date"
                                value="{{ $employee->join_date }}" readonly>

                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('leaving_date') ? 'has-error' : '' }}">
                            <label for="leaving_date">{{ __('Leaving Date') }} <span
                                    class="field_required">*</span></label>
                            <input type="date" class="form-control" name="leaving_date"
                                value="{{ $employee->leaving_date }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4 {{ $errors->has('annual_leave') ? 'has-error' : '' }}">
                            <label for="annual_leave">{{ __('Annual Leave') }} <span
                                    class="field_required">*</span></label>
                            <input type="number" class="form-control" name="annual_leave"
                                value="{{ $employee->annual_leave }}" readonly>
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('remaining_leave') ? 'has-error' : '' }}">
                            <label for="remaining_leave">{{ __('Remaining Leave') }} <span
                                    class="field_required">*</span></label>
                            <input type="number" class="form-control" name="remaining_leave"
                               value="{{ $employee->remaining_leave }}" readonly>
                       
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('hourly_late') ? 'has-error' : '' }}">
                            <label for="hourly_late">{{ __('Hourly Late') }} <span
                                    class="field_required">*</span></label>
                            <input type="number" class="form-control" name="hourly_late"
                             value="{{ $employee->hourly_late }}" readonly>
                       
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 {{ $errors->has('salaray') ? 'has-error' : '' }}">
                            <label for="salaray">{{ __('Salaray') }} <span class="field_required">*</span></label>
                            <input type="number" class="form-control" name="salaray"
                                value="{{ $employee->salary }}" readonly>
                        
                        </div>
                    </div>
                    {{-- Social social --}}
                    <div class="social_social">
                        <h3>{{ __('Social social') }}</h3>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="skype">{{ __('Skype') }} <span
                                        class="field_required">*</span></label>
                                        <input type="text" class="form-control" name="social_social"
                                        value="{{ $social->skype ?? '' }}" readonly>                          
                            </div>


                            <div class="form-group col-md-4">
                                <label for="facebook">{{ __('Facebook') }} <span
                                        class="field_required">*</span></label>
                                        <input type="text" class="form-control" name="social_social"
                                        value="{{ $social->facebook ?? '' }}" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="whatsApp">{{ __('WhatsApp') }} <span
                                        class="field_required">*</span></label>
                                <input type="text" class="form-control" name="whatsApp"
                            value="{{ $social->whatsapp ?? '' }}" readonly>
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="linkedIn">{{ __('LinkedIn') }} <span
                                        class="field_required">*</span></label>
                                <input type="text" class="form-control" name="linkedIn"
                              value="{{ $social->linkedin ?? '' }}" readonly>
                              
                            </div>

                            <div class="form-group col-md-4">
                                <label for="twitter">{{ __('Twitter') }} <span
                                        class="field_required">*</span></label>
                                <input type="text" class="form-control" name="twitter"
                                  value="{{ $social->twitter ?? '' }}" readonly>
                         
                            </div>
                        </div>
                    </div>
                    {{-- social social End --}}

                    {{-- Bank Accounts --}}
                    <h3>{{ __('Bank Accounts') }}</h3>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="bank_name">{{ __('Bank Name') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" class="form-control" name="bank_name"
                                value="{{ $bank->bank_name ?? '' }}" readonly>
                        
                        </div>
                        <div class="form-group col-md-6">
                            <label for="bank_branch">{{ __('Bank Branch *') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" class="form-control" name="bank_branch"
                            value="{{ $bank->bank_branch ?? '' }}" readonly>
                       
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="bank_number">{{ __('Bank Number') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" class="form-control" name="bank_no"
                            value="{{ $bank->bank_no ?? '' }}" readonly>
                          
                        </div>
                        <label for="bank_detail">{{ __('Bank Please provide any details') }} <span
                                class="field_required">*</span></label>
                        <div class="form-group col-md-6">
                            <textarea name="bank_detail" rows="3" cols="40"> {{ $bank->details ?? '' }}
                            </textarea>
                        </div>
                    </div>
                    {{-- Bank End Accounts --}}
                    <h3> {{ __('Experience') }}</h3>
                    {{-- Experience --}}
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="title">{{ __('Title') }} <span class="field_required">*</span></label>
                            <input type="title" class="form-control" name="title" value="{{ $experience->title ?? ''}}" readonly>   
                        </div>


                        <div class="form-group col-md-4">
                            <label for="company_name">{{ __('Company Name') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" class="form-control" name="company_name"
                               value="{{ $experience->company_name ?? '' }}" readonly>
                     
                        </div>

                        <div class="form-group col-md-4">
                            <label for="location">{{ __('Location') }} <span class="field_required">*</span></label>
                            <input type="text" class="form-control" name="location"
                   value="{{ $experience->location ?? '' }}" readonly>
                       
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="start_date">{{ __('Start Date') }} <span
                                    class="field_required">*</span></label>
                            <input type="date" class="form-control" name="start_date"
                        value="{{ $experience->start_date ?? '' }}" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="finish_date">{{ __('Finish date') }} <span
                                    class="field_required">*</span></label>
                            <input type="date" class="form-control" name="finish_date"
                        value="{{ $experience->finish_date ?? '' }}" readonly>
                        </div>

                        <div class="form-group col-md-4 {{ $errors->has('employment_type') ? 'has-error' : '' }}">
                            <label for="employment_type">Employment Type <span class="field_required"></span></label>
                        
                            <!-- Display the selected employment type in an input field -->
                            <input type="text" class="form-control" name="employment_type" id="employment_type" value="{{ 
                                $employee->employment_type == 'full_time' ? 'Full Time' :
                                ($employee->employment_type == 'part_time' ? 'Part Time' :
                                ($employee->employment_type == 'self_employed' ? 'Self Employed' :
                                ($employee->employment_type == 'contract' ? 'Contract' :
                                ($employee->employment_type == 'internship' ? 'Internship' :
                                ($employee->employment_type == 'seasonal' ? 'Seasonal' : ''))))) }}" readonly>

                        </div>                
                    </div>
                    <div class="row">
                        <label for="description">{{ __('Description') }} <span
                                class="field_required">*</span></label>
                        <div class="form-group col-md-12">
                            <textarea name="description" id="" cols="144" rows="4"> {{$experience->description ?? '' }}
                             </textarea>
                        </div>
                    </div>

                    {{-- Experience End --}}
                </div>
                {{-- <div class="row mt-3">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div> --}}
            </div>

        </div>
    </div>
</div>
@endsection
