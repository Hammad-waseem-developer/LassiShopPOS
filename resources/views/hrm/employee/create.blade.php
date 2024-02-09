@extends('layouts.master')

@section('main-content')
@section('page-css')
@endsection

<div class="breadcrumb">
    <h1>{{ __('Add Employees') }}</h1>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row" id="section_create_client">
    <div class="col-lg-12 mb-3">
        <div class="card">
            <form method="POST" action="{{ route('employees.store') }}" @submit.prevent="Create_Client()">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4 {{ $errors->has('first_name') ? 'has-error' : '' }}">
                            <label for="designation">{{ __('First Name') }} <span
                                    class="field_required">*</span></label>
                            <input type="text" class="form-control" name="first_name"
                                placeholder="{{ __('First Name') }}" value="{{ old('first_name') }}">
                            @if ($errors->has('first_name'))
                                <span class="help-block text-danger">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('designation') ? 'has-error' : '' }}">
                            <label for="designation">{{ __('Last Name') }} <span class="field_required">*</span></label>
                            <input type="text" class="form-control" name="last_name"
                                placeholder="{{ __('Last Name') }}" value="{{ old('last_name') }}">
                            @if ($errors->has('last_name'))
                                <span class="help-block text-danger">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('phone') ? 'has-error' : '' }}">
                            <label for="designation">{{ __('Phone') }} <span class="field_required">*</span></label>
                            <input type="tel" class="form-control" name="phone" pattern="[0-9+()-]{4,20}"
                                title="Enter a valid phone number (4-20 digits)" placeholder="{{ __('Phone Number') }}"
                                value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                                <span class="help-block text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('office') ? 'has-error' : '' }}">
                            <label for="office">{{ __('office') }} <span class="field_required">*</span></label>

                            <!-- Use a select element for the dropdown -->
                            <select class="form-control" name="office" id="office">
                                <!-- Add an option for the default or empty value -->
                                <option value="" selected disabled>{{ __('Select office') }}</option>
                                @foreach ($offices as $office)
                                    <option value="{{ $office->id }}"
                                        {{ old('office') == $office->id ? 'selected' : '' }}>
                                        {{ $office->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('office'))
                                <span class="help-block text-danger">{{ $errors->first('office') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('designation') ? 'has-error' : '' }}">
                            <label for="office">{{ __('Designation') }} <span class="field_required">*</span></label>

                            <!-- Use a select element for the dropdown -->
                            <select class="form-control" name="designation" id="office">
                                <!-- Add an option for the default or empty value -->
                                <option value="" selected disabled>{{ __('Select Designation') }}</option>
                                @foreach ($designations as $designations)
                                    <option value="{{ $designations->id }}"
                                        {{ old('office') == $designations->id ? 'selected' : '' }}>
                                        {{ $designations->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('office'))
                                <span class="help-block text-danger">{{ $errors->first('office') }}</span>
                            @endif
                        </div>

                        <div class="form-group col-md-4 {{ $errors->has('department') ? 'has-error' : '' }}">
                            <label for="office">{{ __('Office Shift') }} <span
                                    class="field_required">*</span></label>
                            <select class="form-control" name="department" id="office">
                                <option value="" selected disabled>{{ __('Select Department') }}</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ old('office') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('office'))
                                <span class="help-block text-danger">{{ $errors->first('office') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email">{{ __('Email Address') }} <span
                                    class="field_required">*</span></label>
                            <input type="email" class="form-control" name="email"
                                placeholder="{{ __('Email Address') }}" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('address') ? 'has-error' : '' }}">
                            <label for="address">{{ __('Address') }} <span class="field_required">*</span></label>
                            <input type="text" class="form-control" name="address" placeholder="{{ __('Address') }}"
                                value="{{ old('address') }}">
                            @if ($errors->has('address'))
                                <span class="help-block text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 {{ $errors->has('country') ? 'has-error' : '' }}">
                            <label for="country">{{ __('Country') }} <span class="field_required">*</span></label>
                            <input type="text" class="form-control" name="country" placeholder="{{ __('Country') }}"
                                value="{{ old('country') }}">
                            @if ($errors->has('country'))
                                <span class="help-block text-danger">{{ $errors->first('country') }}</span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 {{ $errors->has('city') ? 'has-error' : '' }}">
                                <label for="City">{{ __('City') }} <span class="field_required">*</span></label>
                                <input type="text" class="form-control" name="city"
                                    placeholder="{{ __('City') }}" value="{{ old('city') }}">
                                @if ($errors->has('city'))
                                    <span class="help-block text-danger">{{ $errors->first('city') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('province') ? 'has-error' : '' }}">
                                <label for="province">{{ __('Province') }} <span
                                        class="field_required">*</span></label>
                                <input type="text" class="form-control" name="province"
                                    placeholder="{{ __('province') }}" value="{{ old('province') }}">
                                @if ($errors->has('province'))
                                    <span class="help-block text-danger">{{ $errors->first('province') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('zip') ? 'has-error' : '' }}">
                                <label for="zip">{{ __('Zip') }} <span
                                        class="field_required">*</span></label>
                                <input type="number" class="form-control" name="zip"
                                    placeholder="{{ __('Zip') }}" value="{{ old('zip') }}">
                                @if ($errors->has('zip'))
                                    <span class="help-block text-danger">{{ $errors->first('zip') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 {{ $errors->has('family_status') ? 'has-error' : '' }}">
                                <label for="family_status">{{ __('Family Status') }} <span
                                        class="field_required">*</span></label>

                                <!-- Use a select element for the dropdown -->
                                <select class="form-control" name="family_status" id="family_status">
                                    <!-- Add options for the family status -->
                                    <option value="1" {{ old('family_status') == 'married' ? 'selected' : '' }}>
                                        {{ __('Married') }}
                                    </option>
                                    <option value="2" {{ old('family_status') == 'divorced' ? 'selected' : '' }}>
                                        {{ __('Divorced') }}
                                    </option>
                                    <option value="0" {{ old('family_status') == 'single' ? 'selected' : '' }}>
                                        {{ __('Single') }}
                                    </option>
                                </select>

                                @if ($errors->has('family_status'))
                                    <span class="help-block text-danger">{{ $errors->first('family_status') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-4 {{ $errors->has('gender') ? 'has-error' : '' }}">
                                <label for="gender">{{ __('Gender') }} <span
                                        class="field_required">*</span></label>

                                <!-- Use a select element for the dropdown -->
                                <select class="form-control" name="gender" id="gender">
                                    <!-- Add options for gender -->
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                        {{ __('Male') }}
                                    </option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                        {{ __('Female') }}
                                    </option>
                                </select>

                                @if ($errors->has('gender'))
                                    <span class="help-block text-danger">{{ $errors->first('gender') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('employment_type') ? 'has-error' : '' }}">
                                <label for="employment_type">{{ __('Employment Type') }} <span
                                        class="field_required">*</span></label>

                                <!-- Use a select element for the dropdown -->
                                <select class="form-control" name="employment_type" id="employment_type">
                                    <!-- Add options for employment type -->
                                    <option value="full_time"
                                        {{ old('employment_type') == 'full_time' ? 'selected' : '' }}>
                                        {{ __('Full Time') }}
                                    </option>
                                    <option value="part_time"
                                        {{ old('employment_type') == 'part_time' ? 'selected' : '' }}>
                                        {{ __('Part Time') }}
                                    </option>
                                    <option value="self_employed"
                                        {{ old('employment_type') == 'self_employed' ? 'selected' : '' }}>
                                        {{ __('Self Employed') }}
                                    </option>
                                    <option value="contract"
                                        {{ old('employment_type') == 'contract' ? 'selected' : '' }}>
                                        {{ __('Contract') }}
                                    </option>
                                    <option value="internship"
                                        {{ old('employment_type') == 'internship' ? 'selected' : '' }}>
                                        {{ __('Internship') }}
                                    </option>
                                    <option value="seasonal"
                                        {{ old('employment_type') == 'seasonal' ? 'selected' : '' }}>
                                        {{ __('Seasonal') }}
                                    </option>
                                </select>

                                @if ($errors->has('employment_type'))
                                    <span
                                        class="help-block text-danger">{{ $errors->first('employment_type') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 {{ $errors->has('birth_date') ? 'has-error' : '' }}">
                                <label for="birth_date">{{ __('Birth Date') }} <span
                                        class="field_required">*</span></label>
                                <input type="date" class="form-control" name="birth_date"
                                    placeholder="{{ __('Birth Date') }}" value="{{ old('birth_date') }}">
                                @if ($errors->has('birth_date'))
                                    <span class="help-block text-danger">{{ $errors->first('birth_date') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('join_date') ? 'has-error' : '' }}">
                                <label for="join_date">{{ __('Joining Date') }} <span
                                        class="field_required">*</span></label>
                                <input type="date" class="form-control" name="join_date"
                                    placeholder="{{ __('Joining Date') }}" value="{{ old('join_date') }}">
                                @if ($errors->has('join_date'))
                                    <span class="help-block text-danger">{{ $errors->first('join_date') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('leaving_date') ? 'has-error' : '' }}">
                                <label for="leaving_date">{{ __('Leaving Date') }} <span
                                        class="field_required">*</span></label>
                                <input type="date" class="form-control" name="leaving_date"
                                    placeholder="{{ __('Leaving Date') }}" value="{{ old('leaving_date') }}">
                                @if ($errors->has('leaving_date'))
                                    <span class="help-block text-danger">{{ $errors->first('leaving_date') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4 {{ $errors->has('annual_leave') ? 'has-error' : '' }}">
                                <label for="annual_leave">{{ __('Annual Leave') }} <span
                                        class="field_required">*</span></label>
                                <input type="number" class="form-control" name="annual_leave"
                                    placeholder="{{ __('annual_leave') }}" value="{{ old('annual_leave') }}">
                                @if ($errors->has('annual_leave'))
                                    <span class="help-block text-danger">{{ $errors->first('annual_leave') }}</span>
                                @endif
                            </div>
                            <div
                                class="form-group col-md-4 {{ $errors->has('remaining_leave') ? 'has-error' : '' }}">
                                <label for="remaining_leave">{{ __('Remaining Leave') }} <span
                                        class="field_required">*</span></label>
                                <input type="number" class="form-control" name="remaining_leave"
                                    placeholder="{{ __('remaining_leave') }}"
                                    value="{{ old('remaining_leave') }}">
                                @if ($errors->has('remaining_leave'))
                                    <span
                                        class="help-block text-danger">{{ $errors->first('remaining_leave') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('hourly_late') ? 'has-error' : '' }}">
                                <label for="hourly_late">{{ __('Hourly Late') }} <span
                                        class="field_required">*</span></label>
                                <input type="number" class="form-control" name="hourly_late"
                                    placeholder="{{ __('hourly_late') }}" value="{{ old('hourly_late') }}">
                                @if ($errors->has('hourly_late'))
                                    <span class="help-block text-danger">{{ $errors->first('hourly_late') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 {{ $errors->has('salaray') ? 'has-error' : '' }}">
                                <label for="salaray">{{ __('Salaray') }} <span
                                        class="field_required">*</span></label>
                                <input type="number" class="form-control" name="salaray"
                                    placeholder="{{ __('salaray') }}" value="{{ old('salaray') }}">
                                @if ($errors->has('salaray'))
                                    <span class="help-block text-danger">{{ $errors->first('salaray') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="company">{{ __('Company') }} <span class="field_required">*</span></label>
                                <select class="form-control" name="company" id="company">
                                    <option value="" selected disabled>{{ __('Select Company') }}</option>
                                    @foreach ($company as $comp)
                                        <option value="{{ $comp->id }}"
                                            {{ old('company') == $comp->id ? 'selected' : '' }}>
                                            {{ $comp->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company')
                                    <span class="help-block text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        {{-- Social Media --}}
                        <div class="social_media">
                            <h3>{{ __('Social Media') }}</h3>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="skype">{{ __('Skype') }} <span
                                            class="field_required">*</span></label>
                                    <input type="text" class="form-control" name="skype"
                                        placeholder="{{ __('Skype') }}" value="">
                                    @if ($errors->has('skype'))
                                        <span class="help-block text-danger">{{ $errors->first('skype') }}</span>
                                    @endif
                                </div>


                                <div class="form-group col-md-4">
                                    <label for="facebook">{{ __('Facebook') }} <span
                                            class="field_required">*</span></label>
                                    <input type="text" class="form-control" name="facebook"
                                        placeholder="{{ __('Facebook') }}" value="">
                                    @if ($errors->has('facebook'))
                                        <span class="help-block text-danger">{{ $errors->first('facebook') }}</span>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="whatsApp">{{ __('WhatsApp') }} <span
                                            class="field_required">*</span></label>
                                    <input type="text" class="form-control" name="whatsApp"
                                        placeholder="{{ __('WhatsApp') }}" value="">
                                    @if ($errors->has('whatsApp'))
                                        <span class="help-block text-danger">{{ $errors->first('whatsApp') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="linkedIn">{{ __('LinkedIn') }} <span
                                            class="field_required">*</span></label>
                                    <input type="text" class="form-control" name="linkedIn"
                                        placeholder="{{ __('LinkedIn') }}" value="">
                                    @if ($errors->has('linkedIn'))
                                        <span class="help-block text-danger">{{ $errors->first('linkedIn') }}</span>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="twitter">{{ __('Twitter') }} <span
                                            class="field_required">*</span></label>
                                    <input type="text" class="form-control" name="twitter"
                                        placeholder="{{ __('Twitter') }}" value="">
                                    @if ($errors->has('twitter'))
                                        <span class="help-block text-danger">{{ $errors->first('twitter') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- social Media End --}}

                        {{-- Bank Accounts --}}
                        <h3>{{ __('Bank Accounts') }}</h3>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="bank_name">{{ __('Bank Name') }} <span
                                        class="field_required">*</span></label>
                                <input type="text" class="form-control" name="bank_name"
                                    placeholder="{{ __('Bank Name') }}" value="">
                                @if ($errors->has('bank_name'))
                                    <span class="help-block text-danger">{{ $errors->first('bank_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="bank_branch">{{ __('Bank Branch *') }} <span
                                        class="field_required">*</span></label>
                                <input type="text" class="form-control" name="bank_branch"
                                    placeholder="{{ __('Bank Branch *') }}" value="">
                                @if ($errors->has('bank_branch'))
                                    <span class="help-block text-danger">{{ $errors->first('bank_branch') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="bank_number">{{ __('Bank Number') }} <span
                                        class="field_required">*</span></label>
                                <input type="text" class="form-control" name="bank_no"
                                    placeholder="{{ __('Bank Number') }}" value="">
                                @if ($errors->has('bank_no'))
                                    <span class="help-block text-danger">{{ $errors->first('bank_no') }}</span>
                                @endif
                            </div>
                            <label for="bank_detail">{{ __('Bank Please provide any details') }} <span
                                    class="field_required">*</span></label>
                            <div class="form-group col-md-6">
                                <textarea name="bank_detail" placeholder="{{ __('Enter Description') }}" rows="3" cols="40"></textarea>
                                @if ($errors->has('bank_detail'))
                                    <span class="help-block text-danger">{{ $errors->first('bank_detail') }}</span>
                                @endif
                            </div>
                        </div>
                        {{-- Bank End Accounts --}}
                        <h3> {{ __('Experience') }}</h3>
                        {{-- Experience --}}
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="title">{{ __('Title') }} <span
                                        class="field_required">*</span></label>
                                <input type="title" class="form-control" name="title"
                                    placeholder="{{ __('Title') }}" value="">
                                @if ($errors->has('title'))
                                    <span class="help-block text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>


                            <div class="form-group col-md-4">
                                <label for="company_name">{{ __('Company Name') }} <span
                                        class="field_required">*</span></label>
                                <input type="text" class="form-control" name="company_name"
                                    placeholder="{{ __('Company Name') }}" value="">
                                @if ($errors->has('company_name'))
                                    <span class="help-block text-danger">{{ $errors->first('company_name') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label for="location">{{ __('Location') }} <span
                                        class="field_required">*</span></label>
                                <input type="text" class="form-control" name="location"
                                    placeholder="{{ __('Location') }}" value="">
                                @if ($errors->has('location'))
                                    <span class="help-block text-danger">{{ $errors->first('location') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="start_date">{{ __('Start Date') }} <span
                                        class="field_required">*</span></label>
                                <input type="date" class="form-control" name="start_date"
                                    placeholder="{{ __('Start Date') }}" value="">
                                @if ($errors->has('start_date'))
                                    <span class="help-block text-danger">{{ $errors->first('start_date') }}</span>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label for="finish_date">{{ __('Finish date') }} <span
                                        class="field_required">*</span></label>
                                <input type="date" class="form-control" name="finish_date"
                                    placeholder="{{ __('Finish date') }}" value="">
                                @if ($errors->has('finish_date'))
                                    <span class="help-block text-danger">{{ $errors->first('finish_date') }}</span>
                                @endif
                            </div>

                            <div
                                class="form-group col-md-4 {{ $errors->has('employment_type') ? 'has-error' : '' }}">
                                <label for="employment_type">{{ __('Employment Type') }} <span
                                        class="field_required">*</span></label>

                                <!-- Use a select element for the dropdown -->
                                <select class="form-control" name="employment_type" id="employment_type">
                                    <!-- Add options for employment type -->
                                    <option value="full_time"
                                        {{ $employee->employment_type == 'full_time' ? 'selected' : '' }}>
                                        {{ __('Full Time') }}
                                    </option>
                                    <option value="part_time"
                                        {{ $employee->employment_type == 'part_time' ? 'selected' : '' }}>
                                        {{ __('Part Time') }}
                                    </option>
                                    <option value="self_employed"
                                        {{ $employee->employment_type == 'self_employed' ? 'selected' : '' }}>
                                        {{ __('Self Employed') }}
                                    </option>
                                    <option value="contract"
                                        {{ $employee->employment_type == 'contract' ? 'selected' : '' }}>
                                        {{ __('Contract') }}
                                    </option>
                                    <option value="internship"
                                        {{ $employee->employment_type == 'internship' ? 'selected' : '' }}>
                                        {{ __('Internship') }}
                                    </option>
                                    <option value="seasonal"
                                        {{ $employee->employment_type == 'seasonal' ? 'selected' : '' }}>
                                        {{ __('Seasonal') }}
                                    </option>
                                </select>

                                @if ($errors->has('employment_type'))
                                    <span
                                        class="help-block text-danger">{{ $errors->first('employment_type') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <label for="description">{{ __('Description') }} <span
                                    class="field_required">*</span></label>
                            <div class="form-group col-md-12">
                                <textarea name="description" id="" cols="144" rows="4">
                             </textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Experience End --}}
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
@endsection
