@extends('layouts.admin')

@section('page-title')
    {{ __('Create Customer') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">{{ __('Customers') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title mb-0">{{ __('Create New Customer') }}</h5>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('customer.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-arrow-left"></i> {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => 'customer.store', 'method' => 'post', 'id' => 'customerForm']) }}
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="sub-title">{{ __('Basic Info') }}</h6>
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter customer name')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('contact', __('Contact'), ['class' => 'form-label']) }}
                                        {{ Form::number('contact', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter contact number')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                                        {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('Enter email address')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('mobile', __('Mobile'), ['class' => 'form-label']) }}
                                        {{ Form::text('mobile', null, ['class' => 'form-control', 'placeholder' => __('Enter mobile number')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('tax_number', __('GST Number'), ['class' => 'form-label']) }}
                                        {{ Form::text('tax_number', null, ['class' => 'form-control', 'placeholder' => __('Enter GST number')]) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="sub-title">{{ __('Additional Info') }}</h6>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('credit_limit', __('Credit Limit'), ['class' => 'form-label']) }}
                                        {{ Form::number('credit_limit', null, ['class' => 'form-control', 'step' => '0.01', 'placeholder' => __('Enter credit limit')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('credit_days', __('Credit Days'), ['class' => 'form-label']) }}
                                        {{ Form::number('credit_days', null, ['class' => 'form-control', 'placeholder' => __('Enter credit days')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('address', __('Address'), ['class' => 'form-label']) }}
                                        {{ Form::textarea('address', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => __('Enter address')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('city', __('City'), ['class' => 'form-label']) }}
                                        {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => __('Enter city')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('state', __('State'), ['class' => 'form-label']) }}
                                        {{ Form::text('state', null, ['class' => 'form-control', 'placeholder' => __('Enter state')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('country', __('Country'), ['class' => 'form-label']) }}
                                        {{ Form::text('country', 'India', ['class' => 'form-control', 'placeholder' => __('Enter country')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('pincode', __('Pincode'), ['class' => 'form-label']) }}
                                        {{ Form::text('pincode', null, ['class' => 'form-control', 'placeholder' => __('Enter pincode')]) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="sub-title">{{ __('Billing Address') }}</h6>
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('billing_name', __('Contact Person'), ['class' => 'form-label']) }}
                                        {{ Form::text('billing_name', null, ['class' => 'form-control', 'placeholder' => __('Enter contact person name')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('billing_phone', __('Phone'), ['class' => 'form-label']) }}
                                        {{ Form::text('billing_phone', null, ['class' => 'form-control', 'placeholder' => __('Enter billing phone')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('billing_email', __('Email'), ['class' => 'form-label']) }}
                                        {{ Form::email('billing_email', null, ['class' => 'form-control', 'placeholder' => __('Enter billing email')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('billing_address', __('Address'), ['class' => 'form-label']) }}
                                        {{ Form::textarea('billing_address', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => __('Enter billing address')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('billing_city', __('City'), ['class' => 'form-label']) }}
                                        {{ Form::text('billing_city', null, ['class' => 'form-control', 'placeholder' => __('Enter city')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('billing_state', __('State'), ['class' => 'form-label']) }}
                                        {{ Form::text('billing_state', null, ['class' => 'form-control', 'placeholder' => __('Enter state')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('billing_country', __('Country'), ['class' => 'form-label']) }}
                                        {{ Form::text('billing_country', 'India', ['class' => 'form-control', 'placeholder' => __('Enter country')]) }}
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('billing_zip', __('Pincode'), ['class' => 'form-label']) }}
                                        {{ Form::text('billing_zip', null, ['class' => 'form-control', 'placeholder' => __('Enter pincode')]) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if(App\Models\Utility::getValByName('shipping_display') == 'on')
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="sub-title mb-0">{{ __('Shipping Address') }}</h6>
                                    <button type="button" id="copyBillingAddress" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-copy"></i> {{ __('Copy from Billing') }}
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('shipping_name', __('Contact Person'), ['class' => 'form-label']) }}
                                            {{ Form::text('shipping_name', null, ['class' => 'form-control', 'placeholder' => __('Enter shipping contact person')]) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('shipping_phone', __('Phone'), ['class' => 'form-label']) }}
                                            {{ Form::text('shipping_phone', null, ['class' => 'form-control', 'placeholder' => __('Enter shipping phone')]) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('shipping_email', __('Email'), ['class' => 'form-label']) }}
                                            {{ Form::email('shipping_email', null, ['class' => 'form-control', 'placeholder' => __('Enter shipping email')]) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            {{ Form::label('shipping_address', __('Address'), ['class' => 'form-label']) }}
                                            {{ Form::textarea('shipping_address', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => __('Enter shipping address')]) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('shipping_city', __('City'), ['class' => 'form-label']) }}
                                            {{ Form::text('shipping_city', null, ['class' => 'form-control', 'placeholder' => __('Enter city')]) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('shipping_state', __('State'), ['class' => 'form-label']) }}
                                            {{ Form::text('shipping_state', null, ['class' => 'form-control', 'placeholder' => __('Enter state')]) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('shipping_country', __('Country'), ['class' => 'form-label']) }}
                                            {{ Form::text('shipping_country', 'India', ['class' => 'form-control', 'placeholder' => __('Enter country')]) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('shipping_zip', __('Pincode'), ['class' => 'form-label']) }}
                                            {{ Form::text('shipping_zip', null, ['class' => 'form-control', 'placeholder' => __('Enter pincode')]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if(!$customFields->isEmpty())
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="sub-title">{{ __('Additional Fields') }}</h6>
                                <div class="row">
                                    @include('customFields.formBuilder')
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="row mt-4">
                        <div class="col-md-12 text-end">
                            <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                                <i class="ti ti-x"></i> {{ __('Cancel') }}
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-save"></i> {{ __('Save Customer') }}
                            </button>
                        </div>
                    </div>
                    
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Copy billing address to shipping address
        $('#copyBillingAddress').click(function() {
            $('[name="shipping_name"]').val($('[name="billing_name"]').val());
            $('[name="shipping_phone"]').val($('[name="billing_phone"]').val());
            $('[name="shipping_email"]').val($('[name="billing_email"]').val());
            $('[name="shipping_address"]').val($('[name="billing_address"]').val());
            $('[name="shipping_city"]').val($('[name="billing_city"]').val());
            $('[name="shipping_state"]').val($('[name="billing_state"]').val());
            $('[name="shipping_country"]').val($('[name="billing_country"]').val());
            $('[name="shipping_zip"]').val($('[name="billing_zip"]').val());
            
            toastr.success('Billing address copied to shipping address');
        });
        
        // Form validation
        $('#customerForm').submit(function(e) {
            let isValid = true;
            let errorMessages = [];
            
            // Required fields validation
            if($('[name="name"]').val().trim() === '') {
                errorMessages.push('Customer name is required');
                $('[name="name"]').focus();
                isValid = false;
            }
            
            if($('[name="contact"]').val().trim() === '') {
                errorMessages.push('Contact number is required');
                $('[name="contact"]').focus();
                isValid = false;
            }
            
            // Email validation if provided
            const email = $('[name="email"]').val().trim();
            if(email !== '' && !isValidEmail(email)) {
                errorMessages.push('Please enter a valid email address');
                $('[name="email"]').focus();
                isValid = false;
            }
            
            // Mobile validation if provided
            const mobile = $('[name="mobile"]').val().trim();
            if(mobile !== '' && !isValidMobile(mobile)) {
                errorMessages.push('Please enter a valid mobile number (10 digits)');
                $('[name="mobile"]').focus();
                isValid = false;
            }
            
            if(!isValid) {
                e.preventDefault();
                alert(errorMessages.join('\n'));
            }
        });
        
        function isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
        
        function isValidMobile(mobile) {
            const re = /^[0-9]{10}$/;
            return re.test(mobile);
        }
    });
</script>
@endpush