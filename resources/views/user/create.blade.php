@extends('layouts.admin')

@section('page-title')
    {{__('Create User')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('users.index')}}">{{__('Users')}}</a></li>
    <li class="breadcrumb-item">{{__('Create User')}}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">{{__('Create New User')}}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data" id="userCreateForm">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="mb-3 border-bottom pb-2 text-primary">{{ __('Basic Information') }}</h6>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name" class="form-label">{{ __('First Name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                <div class="invalid-feedback" id="first_name_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name" class="form-label">{{ __('Last Name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                <div class="invalid-feedback" id="last_name_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                <div class="invalid-feedback" id="email_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobile" class="form-label">{{ __('Mobile') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}" required>
                                <div class="invalid-feedback" id="mobile_error"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="mb-3 border-bottom pb-2 text-primary">{{ __('Personal Information') }}</h6>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date_of_birth" class="form-label">{{ __('Date of Birth') }}</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="gender" class="form-label">{{ __('Gender') }}</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="">{{ __('Select Gender') }}</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="blood_group" class="form-label">{{ __('Blood Group') }}</label>
                                <select class="form-control" id="blood_group" name="blood_group">
                                    <option value="">{{ __('Select Blood Group') }}</option>
                                    <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                    <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="marital_status" class="form-label">{{ __('Marital Status') }}</label>
                                <select class="form-control" id="marital_status" name="marital_status">
                                    <option value="">{{ __('Select Marital Status') }}</option>
                                    <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>{{ __('Single') }}</option>
                                    <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>{{ __('Married') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="mb-3 border-bottom pb-2 text-primary">{{ __('Contact Information') }}</h6>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address" class="form-label">{{ __('Address') }}</label>
                                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="city" class="form-label">{{ __('City') }}</label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="state" class="form-label">{{ __('State') }}</label>
                                <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="country" class="form-label">{{ __('Country') }}</label>
                                <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pincode" class="form-label">{{ __('Pincode') }}</label>
                                <input type="text" class="form-control" id="pincode" name="pincode" value="{{ old('pincode') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="alternate_mobile" class="form-label">{{ __('Alternate Mobile') }}</label>
                                <input type="text" class="form-control" id="alternate_mobile" name="alternate_mobile" value="{{ old('alternate_mobile') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="mb-3 border-bottom pb-2 text-primary">{{ __('Employment Information') }}</h6>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date_of_joining" class="form-label">{{ __('Date of Joining') }}</label>
                                <input type="date" class="form-control" id="date_of_joining" name="date_of_joining" value="{{ old('date_of_joining') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="role" class="form-label">{{ __('Role') }} <span class="text-danger">*</span></label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="">{{ __('Select Role') }}</option>
                                    @foreach($roles as $id => $role)
                                        <option value="{{ $id }}" {{ old('role') == $id ? 'selected' : '' }}>{{ $role }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="role_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="companies" class="form-label">{{ __('Companies') }} <span class="text-danger">*</span></label>
                                <select class="form-control select2-multiple" id="companies" name="companies[]" multiple="multiple">
                                    @foreach($companies as $id => $name)
                                        <option value="{{ $id }}" {{ in_array($id, old('companies', [])) ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="companies_error">{{ __('Please select at least one company') }}</div>
                                <small class="text-muted">{{ __('Select one or more companies') }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="mb-3 border-bottom pb-2 text-primary">{{ __('Account Information') }}</h6>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password" class="form-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" required minlength="6">
                                <div class="invalid-feedback" id="password_error"></div>
                                <small class="text-muted">{{ __('Minimum 6 characters required') }}</small>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required minlength="6">
                                <div class="invalid-feedback" id="password_confirmation_error"></div>
                                <small class="text-muted">{{ __('Re-enter password') }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Picture -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="mb-3 border-bottom pb-2 text-primary">{{ __('Profile Picture') }}</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profile_picture" name="profile_picture" accept="image/*">
                                    <label class="custom-file-label" for="profile_picture">{{ __('Choose file') }}</label>
                                </div>
                                <small class="text-muted">{{ __('Max size: 500KB, Formats: JPG, PNG, GIF') }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Custom Fields -->
                    @if(!$customFields->isEmpty())
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="mb-3 border-bottom pb-2">{{ __('Custom Fields') }}</h6>
                        </div>
                        @foreach($customFields as $field)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customField[{{$field->id}}]" class="form-label">{{ $field->name }}</label>
                                    @if($field->type == 'text')
                                        <input type="text" class="form-control" id="customField[{{$field->id}}]" name="customField[{{$field->id}}]" value="{{ old('customField['.$field->id.']') }}">
                                    @elseif($field->type == 'number')
                                        <input type="number" class="form-control" id="customField[{{$field->id}}]" name="customField[{{$field->id}}]" value="{{ old('customField['.$field->id.']') }}">
                                    @elseif($field->type == 'date')
                                        <input type="date" class="form-control" id="customField[{{$field->id}}]" name="customField[{{$field->id}}]" value="{{ old('customField['.$field->id.']') }}">
                                    @elseif($field->type == 'textarea')
                                        <textarea class="form-control" id="customField[{{$field->id}}]" name="customField[{{$field->id}}]" rows="2">{{ old('customField['.$field->id.']') }}</textarea>
                                    @elseif($field.type == 'select')
                                        <select class="form-control" id="customField[{{$field->id}}]" name="customField[{{$field->id}}]">
                                            <option value="">{{ __('Select') }} {{ $field->name }}</option>
                                            @foreach(explode(',', $field->options) as $option)
                                                <option value="{{ trim($option) }}" {{ old('customField['.$field->id.']') == trim($option) ? 'selected' : '' }}>{{ trim($option) }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Form Actions -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">{{ __('Create User') }}</button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')

<script>
    $(document).ready(function() {
        console.log('Document ready - form loaded, Select2:', typeof $.fn.select2);
        
        // Check if Select2 is loaded
        if (typeof $.fn.select2 === 'undefined') {
            console.error('Select2 is not loaded! Loading now...');
            // Try to load Select2 dynamically if not loaded
            $.getScript("{{ asset('js/select2.min.js') }}", function() {
                console.log('Select2 loaded dynamically');
                initializeForm();
            });
        } else {
            initializeForm();
        }
        
        function initializeForm() {
            // File input label update
            $('#profile_picture').on('change', function(e) {
                const fileName = e.target.files[0] ? e.target.files[0].name : '{{ __("Choose file") }}';
                $(this).next('.custom-file-label').text(fileName);
            });

            // Date validation
            const today = new Date().toISOString().split('T')[0];
            $('#date_of_joining').attr('max', today);
            
            const maxBirthDate = new Date();
            maxBirthDate.setFullYear(maxBirthDate.getFullYear() - 18);
            $('#date_of_birth').attr('max', maxBirthDate.toISOString().split('T')[0]);

            // Initialize Select2 for multi-select - WITH ERROR HANDLING
            try {
                $('#companies').select2({
                    width: '100%',
                    placeholder: "{{ __('Select companies') }}",
                    allowClear: true,
                    closeOnSelect: false
                });
                console.log('Select2 initialized successfully');
            } catch (error) {
                console.error('Error initializing Select2:', error);
                // Fallback to regular select if Select2 fails
                $('#companies').attr('multiple', 'multiple');
            }

            // Phone number formatting
            function formatPhoneNumber(input) {
                let value = input.val().replace(/\D/g, '');
                if (value.length > 10) value = value.substring(0, 10);
                input.val(value);
            }
            
            $('#mobile, #alternate_mobile').on('input', function() {
                formatPhoneNumber($(this));
            });

            // Simple validation function
            function validateRequired(fieldId, fieldName) {
                const field = $('#' + fieldId);
                const value = field.val();
                const errorDiv = $('#' + fieldId + '_error');
                
                if (!value || value.trim() === '') {
                    field.addClass('is-invalid');
                    errorDiv.text(fieldName + ' {{ __("is required") }}').show();
                    return false;
                } else {
                    field.removeClass('is-invalid').addClass('is-valid');
                    errorDiv.hide();
                    return true;
                }
            }

            // Validate email format
            function validateEmailFormat() {
                const email = $('#email').val();
                const errorDiv = $('#email_error');
                
                if (!email) {
                    $('#email').addClass('is-invalid');
                    errorDiv.text('{{ __("Email is required") }}').show();
                    return false;
                }
                
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    $('#email').addClass('is-invalid');
                    errorDiv.text('{{ __("Please enter a valid email address") }}').show();
                    return false;
                }
                
                $('#email').removeClass('is-invalid').addClass('is-valid');
                errorDiv.hide();
                return true;
            }

            // Validate password length
            function validatePassword() {
                const password = $('#password').val();
                const errorDiv = $('#password_error');
                
                if (!password) {
                    $('#password').addClass('is-invalid');
                    errorDiv.text('{{ __("Password is required") }}').show();
                    return false;
                } else if (password.length < 6) {
                    $('#password').addClass('is-invalid');
                    errorDiv.text('{{ __("Password must be at least 6 characters") }}').show();
                    return false;
                } else {
                    $('#password').removeClass('is-invalid').addClass('is-valid');
                    errorDiv.hide();
                    return true;
                }
            }

            // Validate password match
            function validatePasswordMatch() {
                const password = $('#password').val();
                const confirmPassword = $('#password_confirmation').val();
                const errorDiv = $('#password_confirmation_error');
                
                if (!confirmPassword) {
                    $('#password_confirmation').addClass('is-invalid');
                    errorDiv.text('{{ __("Please confirm your password") }}').show();
                    return false;
                } else if (password !== confirmPassword) {
                    $('#password_confirmation').addClass('is-invalid');
                    errorDiv.text('{{ __("Passwords do not match") }}').show();
                    return false;
                } else {
                    $('#password_confirmation').removeClass('is-invalid').addClass('is-valid');
                    errorDiv.hide();
                    return true;
                }
            }

            // Validate companies
            function validateCompanies() {
                const companies = $('#companies').val();
                const errorDiv = $('#companies_error');
                
                // Handle both Select2 and regular select
                const selectElement = $('#companies');
                
                if (!companies || (Array.isArray(companies) && companies.length === 0) || 
                    (!Array.isArray(companies) && companies === '')) {
                    
                    // Try to find Select2 container or use the select itself
                    const select2Container = selectElement.next('.select2-container');
                    if (select2Container.length > 0) {
                        select2Container.find('.select2-selection--multiple').addClass('is-invalid');
                    } else {
                        selectElement.addClass('is-invalid');
                    }
                    
                    errorDiv.show();
                    return false;
                } else {
                    const select2Container = selectElement.next('.select2-container');
                    if (select2Container.length > 0) {
                        select2Container.find('.select2-selection--multiple').removeClass('is-invalid').addClass('is-valid');
                    } else {
                        selectElement.removeClass('is-invalid').addClass('is-valid');
                    }
                    errorDiv.hide();
                    return true;
                }
            }

            // Real-time validation
            $('#first_name, #last_name, #mobile').on('blur', function() {
                const fieldId = $(this).attr('id');
                const fieldName = $(this).closest('.form-group').find('.form-label').text().replace('*', '').trim();
                validateRequired(fieldId, fieldName);
            });

            $('#email').on('blur', validateEmailFormat);
            
            $('#role').on('change', function() {
                validateRequired('role', 'Role');
            });

            $('#password').on('blur', validatePassword);
            $('#password_confirmation').on('blur', validatePasswordMatch);
            $('#companies').on('change', validateCompanies);

            // Form submission - SIMPLIFIED
            $('#userCreateForm').submit(function(e) {
                console.log('Form submit event triggered');
                
                // Clear previous validation
                $('.is-invalid').removeClass('is-invalid');
                $('.is-valid').removeClass('is-valid');
                $('.invalid-feedback').hide();
                
                let isValid = true;
                
                // Validate all required fields
                if (!validateRequired('first_name', 'First Name')) isValid = false;
                if (!validateRequired('last_name', 'Last Name')) isValid = false;
                if (!validateEmailFormat()) isValid = false;
                if (!validateRequired('mobile', 'Mobile')) isValid = false;
                if (!validateRequired('role', 'Role')) isValid = false;
                if (!validatePassword()) isValid = false;
                if (!validatePasswordMatch()) isValid = false;
                if (!validateCompanies()) isValid = false;
                
                console.log('Validation result:', isValid ? 'VALID' : 'INVALID');
                
                if (!isValid) {
                    e.preventDefault();
                    console.log('Form submission prevented');
                    
                    // Show alert for password length
                    const password = $('#password').val();
                    if (password && password.length < 6) {
                        alert('{{ __("Password must be at least 6 characters") }}');
                    }
                    
                    // Focus on first error
                    $('.is-invalid').first().focus();
                    return false;
                }
                
                console.log('Form submitted successfully');
                // Allow form to submit normally
            });

            console.log('Form initialized successfully');
        }
    });
</script>
@endpush