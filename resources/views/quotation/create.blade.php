@extends('layouts.admin')

@section('page-title')
    {{__('Create Item')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('items.index')}}">{{__('Items')}}</a></li>
    <li class="breadcrumb-item">{{__('Create')}}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="card-title mb-0">{{__('Add/Update Items')}}</h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="item_type" id="single_item" value="single" checked>
                                <label class="form-check-label" for="single_item">Single Item</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="item_type" id="bulk_items" value="bulk">
                                <label class="form-check-label" for="bulk_items">Bulk Items</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('items.store') }}" id="itemForm" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- First Row -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label"><strong>{{ __('Item Name*') }}</strong></label>
                                    <input type="text" class="form-control" id="name" name="name" required 
                                           placeholder="Enter item name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="item_group" class="form-label"><strong>{{ __('Item Group*') }}</strong></label>
                                    <select class="form-control select2" id="item_group" name="item_group" required>
                                        <option value="">{{ __('-Select-') }}</option>
                                        <option value="single" {{ old('item_group') == 'single' ? 'selected' : 'selected' }}>{{ __('Single') }}</option>
                                        <option value="combo" {{ old('item_group') == 'combo' ? 'selected' : '' }}>{{ __('Combo') }}</option>
                                        <option value="bundle" {{ old('item_group') == 'bundle' ? 'selected' : '' }}>{{ __('Bundle') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Second Row -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hsn" class="form-label"><strong>{{ __('HSN') }}</strong></label>
                                    <input type="text" class="form-control" id="hsn" name="hsn" 
                                           placeholder="Enter HSN code" value="{{ old('hsn') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="barcode" class="form-label"><strong>{{ __('Barcode') }}</strong></label>
                                    <input type="text" class="form-control" id="barcode" name="barcode" 
                                           placeholder="Enter barcode" value="{{ old('barcode') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="brand" class="form-label"><strong>{{ __('Brand') }}</strong></label>
                                    <select class="form-control select2" id="brand" name="brand">
                                        <option value="">{{ __('-Select-') }}</option>
                                        @foreach($brands as $key => $brandName)
                                            <option value="{{ $brandName }}" {{ old('brand') == $brandName ? 'selected' : '' }}>
                                                {{ $brandName }}
                                            </option>
                                        @endforeach
                                        <option value="other">{{ __('Other') }}</option>
                                    </select>
                                    <input type="text" class="form-control mt-2" id="other_brand" name="other_brand" 
                                           placeholder="Enter other brand" style="display: none;">
                                </div>
                            </div>
                        </div>

                        <!-- Third Row -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="unit" class="form-label"><strong>{{ __('Unit') }}</strong></label>
                                    <select class="form-control select2" id="unit" name="unit">
                                        <option value="">{{ __('-Select-') }}</option>
                                        @foreach($units as $key => $unitName)
                                            <option value="{{ $key }}" {{ old('unit') == $key ? 'selected' : '' }}>
                                                {{ $unitName }}
                                            </option>
                                        @endforeach
                                        <option value="other">{{ __('Other') }}</option>
                                    </select>
                                    <input type="text" class="form-control mt-2" id="other_unit" name="other_unit" 
                                           placeholder="Enter other unit" style="display: none;">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="alert_quantity" class="form-label"><strong>{{ __('Alert Quantity') }}</strong></label>
                                    <input type="number" class="form-control text-end" id="alert_quantity" 
                                           name="alert_quantity" min="0" step="1" placeholder="0" 
                                           value="{{ old('alert_quantity', 0) }}">
                                </div>
                            </div>
                            
                           <div class="col-md-4">
    <div class="form-group">
        <label for="category" class="form-label"><strong>{{ __('Category') }}</strong></label>
        <select class="form-control select2" id="category" name="category">
            <option value="">{{ __('-Select-') }}</option>
            @foreach($categories as $key => $categoryName)
                <option value="{{ $categoryName }}" {{ old('category') == $categoryName ? 'selected' : '' }}>
                    {{ $categoryName }}
                </option>
            @endforeach
            <option value="other">{{ __('Other') }}</option>
        </select>
        <input type="text" class="form-control mt-2" id="other_category" name="other_category" 
               placeholder="Enter other category" style="display: none;">
    </div>
</div>
                        </div>

                        <!-- Description Row -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="form-label"><strong>{{ __('Description') }}</strong></label>
                                    <textarea class="form-control" id="description" name="description" 
                                              rows="3" placeholder="Enter item description">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Fourth Row -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="discount_type" class="form-label"><strong>{{ __('Discount Type') }}</strong></label>
                                    <select class="form-control select2" id="discount_type" name="discount_type">
                                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : 'selected' }}>
                                            {{ __('Percentage(%)') }}
                                        </option>
                                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>
                                            {{ __('Fixed Amount') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="discount" class="form-label"><strong>{{ __('Discount') }}</strong></label>
                                    <input type="number" class="form-control text-end" id="discount" 
                                           name="discount" min="0" step="0.01" placeholder="0.00" 
                                           value="{{ old('discount', 0) }}">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price" class="form-label"><strong>{{ __('Price*') }}</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control text-end" id="price" 
                                               name="price" min="0" step="0.01" placeholder="0.00" 
                                               required value="{{ old('price', 0) }}">
                                    </div>
                                    <small class="form-text text-muted">{{ __('Price of item without Tax') }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Fifth Row -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tax_type" class="form-label"><strong>{{ __('Tax Type*') }}</strong></label>
                                    <select class="form-control select2" id="tax_type" name="tax_type" required>
                                        <option value="">{{ __('-Select-') }}</option>
                                        <option value="inclusive" {{ old('tax_type') == 'inclusive' ? 'selected' : 'selected' }}>
                                            {{ __('Inclusive') }}
                                        </option>
                                        <option value="exclusive" {{ old('tax_type') == 'exclusive' ? 'selected' : '' }}>
                                            {{ __('Exclusive') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mrp" class="form-label"><strong>{{ __('MRP') }}</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control text-end" id="mrp" 
                                               name="mrp" min="0" step="0.01" placeholder="0.00" 
                                               value="{{ old('mrp', 0) }}">
                                    </div>
                                    <small class="form-text text-muted">{{ __('Maximum Retail Price') }}</small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_id" class="form-label"><strong>{{ __('Company') }}</strong></label>
                                    <select class="form-control select2" id="company_id" name="company_id" required>
                                        <option value="">{{ __('-Select-') }}</option>
                                        @foreach($companies as $id => $companyName)
                                            <option value="{{ $id }}" {{ old('company_id') == $id ? 'selected' : '' }}>
                                                {{ $companyName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Sixth Row -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tax_id" class="form-label"><strong>{{ __('Tax') }}</strong></label>
                                    <select class="form-control select2" id="tax_id" name="tax_id">
                                        <option value="">{{ __('-Select-') }}</option>
                                        @foreach($taxes as $id => $taxName)
                                            <option value="{{ $id }}" {{ old('tax_id') == $id ? 'selected' : '' }}>
                                                {{ $taxName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="profit_margin" class="form-label"><strong>{{ __('Profit Margin(%)') }}</strong></label>
                                    <input type="number" class="form-control text-end" id="profit_margin" 
                                           name="profit_margin" min="0" step="0.01" placeholder="0.00" 
                                           value="{{ old('profit_margin', 0) }}">
                                    <small class="form-text text-muted">{{ __('Profit in %') }}</small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sku" class="form-label"><strong>{{ __('SKU') }}</strong></label>
                                    <input type="text" class="form-control" id="sku" name="sku" 
                                           placeholder="Enter SKU" value="{{ old('sku') }}">
                                    @error('sku')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Seventh Row -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="seller_points" class="form-label"><strong>{{ __('Seller Points') }}</strong></label>
                                    <input type="number" class="form-control text-end" id="seller_points" 
                                           name="seller_points" min="0" step="1" placeholder="0" 
                                           value="{{ old('seller_points', 0) }}">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="purchase_price" class="form-label"><strong>{{ __('Purchase Price*') }}</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control text-end" id="purchase_price" 
                                               name="purchase_price" min="0" step="0.01" placeholder="0.00" 
                                               required value="{{ old('purchase_price', 0) }}">
                                    </div>
                                    <small class="form-text text-muted">{{ __('Total Price with Tax Amount') }}</small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sales_price" class="form-label"><strong>{{ __('Sales Price*') }}</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control text-end" id="sales_price" 
                                               name="sales_price" min="0" step="0.01" placeholder="0.00" 
                                               required value="{{ old('sales_price', 0) }}">
                                    </div>
                                    <small class="form-text text-muted">{{ __('Sales Price') }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Eighth Row - Opening Stock -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="opening_stock" class="form-label"><strong>{{ __('Opening Stock') }}</strong></label>
                                    <input type="number" class="form-control text-end" id="opening_stock" 
                                           name="opening_stock" min="0" step="1" placeholder="0" 
                                           value="{{ old('opening_stock', 0) }}">
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label"><strong>{{ __('Select Image') }}</strong></label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="item_image" name="item_image" 
                                               accept="image/*" onchange="previewImage(this)">
                                        <label class="input-group-text" for="item_image">{{ __('Choose File') }}</label>
                                    </div>
                                    <div class="form-text text-muted">
                                        {{ __('Max Width/Height: 1000px * 1000px & Size: 1MB') }}
                                    </div>
                                    <div class="mt-2">
                                        <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 200px; display: none;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Image Row -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label"><strong>{{ __('Additional Image') }}</strong></label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="additional_image" 
                                               name="additional_image" accept="image/*" onchange="previewAdditionalImage(this)">
                                        <label class="input-group-text" for="additional_image">{{ __('Choose File') }}</label>
                                    </div>
                                    <div class="form-text text-muted">
                                        {{ __('Max Width/Height: 1000px * 1000px & Size: 1MB') }}
                                    </div>
                                    <div class="mt-2">
                                        <img id="additionalImagePreview" src="#" alt="Additional Image Preview" style="max-width: 200px; display: none;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" name="created_by" value="{{ Auth::id() }}">

                        <!-- Footer Buttons -->
                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success btn-lg px-5">
                                    <i class="fas fa-save"></i> {{ __('Save') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-lg px-5" onclick="window.history.back()">
                                    <i class="fas fa-times"></i> {{ __('Close') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
<style>
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: none;
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 1.2rem 1.8rem;
        border-bottom: none;
    }
    
    .card-title {
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        margin: 0;
    }
    
    .card-body {
        padding: 1.8rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 8px;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-control, .select2-container .select2-selection--single {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 10px 14px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        height: 42px;
    }
    
    .form-control:focus, .select2-container--focus .select2-selection--single {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        transform: translateY(-1px);
    }
    
    .text-end {
        text-align: right !important;
    }
    
    .input-group-text {
        background-color: #f1f5f9;
        border-color: #e2e8f0;
        color: #475569;
        font-weight: 600;
    }
    
    .form-text {
        font-size: 0.8rem;
        color: #6b7280 !important;
    }
    
    .select2-container--default {
        width: 100% !important;
    }
    
    .select2-container--default .select2-selection--single {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        height: 42px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px;
        padding-left: 14px;
        color: #2d3748;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        transition: all 0.3s;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(16, 185, 129, 0.4);
    }
    
    .btn-outline-secondary {
        transition: all 0.3s;
    }
    
    .btn-outline-secondary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(148, 163, 184, 0.3);
    }
    
    /* Image preview styling */
    #imagePreview, #additionalImagePreview {
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 10px;
        background-color: #f9fafb;
        max-height: 200px;
        object-fit: contain;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.2rem;
        }
        
        .card-header {
            padding: 1rem 1.2rem;
        }
        
        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
        }
        
        .form-control, .select2-container .select2-selection--single {
            padding: 8px 12px;
            font-size: 0.85rem;
            height: 38px;
        }
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Initialize all Select2 dropdowns
        $('.select2').select2({
            width: '100%',
            placeholder: 'Select...',
            allowClear: true,
            dropdownParent: $('#itemForm')
        });
        
        // Handle radio button changes for item type
        $('input[name="item_type"]').change(function() {
            if ($(this).val() === 'bulk') {
                alert('Bulk item creation would open a different interface or upload form.');
                // You can redirect or show/hide fields here
            }
        });
        
        // Handle other options for brand, unit, category
        $('#brand, #unit, #category').on('change', function() {
            const field = $(this).attr('id');
            const otherField = $('#other_' + field);
            
            if ($(this).val() === 'other') {
                otherField.show();
                otherField.prop('required', true);
            } else {
                otherField.hide();
                otherField.prop('required', false);
                otherField.val('');
            }
        });
        
        // Auto-calculate sales price based on purchase price and profit margin
        $('#purchase_price, #profit_margin').on('keyup change', function() {
            calculateSalesPrice();
        });
        
        // Auto-calculate discount amount
        $('#price, #discount, #discount_type').on('keyup change', function() {
            calculateDiscountedPrice();
        });
        
        // Initialize calculations
        calculateSalesPrice();
        calculateDiscountedPrice();
    });
    
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const file = input.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(file);
            
            // Validate file size (1MB = 1048576 bytes)
            if (file.size > 1048576) {
                alert('File size must be less than 1MB');
                input.value = '';
                preview.style.display = 'none';
                return;
            }
            
            // Validate image dimensions
            const img = new Image();
            img.onload = function() {
                if (this.width > 1000 || this.height > 1000) {
                    alert('Image dimensions must be 1000px x 1000px or less');
                    input.value = '';
                    preview.style.display = 'none';
                }
            };
            img.src = URL.createObjectURL(file);
        } else {
            preview.style.display = 'none';
        }
    }
    
    function previewAdditionalImage(input) {
        const preview = document.getElementById('additionalImagePreview');
        const file = input.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(file);
            
            // Validate file size (1MB = 1048576 bytes)
            if (file.size > 1048576) {
                alert('File size must be less than 1MB');
                input.value = '';
                preview.style.display = 'none';
                return;
            }
            
            // Validate image dimensions
            const img = new Image();
            img.onload = function() {
                if (this.width > 1000 || this.height > 1000) {
                    alert('Image dimensions must be 1000px x 1000px or less');
                    input.value = '';
                    preview.style.display = 'none';
                }
            };
            img.src = URL.createObjectURL(file);
        } else {
            preview.style.display = 'none';
        }
    }
    
    function calculateSalesPrice() {
        const purchasePrice = parseFloat($('#purchase_price').val()) || 0;
        const profitMargin = parseFloat($('#profit_margin').val()) || 0;
        
        if (purchasePrice > 0 && profitMargin > 0) {
            const salesPrice = purchasePrice * (1 + (profitMargin / 100));
            $('#sales_price').val(salesPrice.toFixed(2));
        }
    }
    
    function calculateDiscountedPrice() {
        const price = parseFloat($('#price').val()) || 0;
        const discount = parseFloat($('#discount').val()) || 0;
        const discountType = $('#discount_type').val();
        
        let finalPrice = price;
        
        if (discount > 0) {
            if (discountType === 'percentage') {
                if (discount <= 100) {
                    finalPrice = price - (price * (discount / 100));
                }
            } else {
                if (discount <= price) {
                    finalPrice = price - discount;
                }
            }
        }
        
        // Update sales price if needed
        if ($('#sales_price').val() === '' || $('#sales_price').val() === '0.00') {
            $('#sales_price').val(finalPrice.toFixed(2));
        }
    }
    
    // Form validation
    $('#itemForm').on('submit', function(e) {
        let isValid = true;
        
        // Check required fields
        if ($('#name').val().trim() === '') {
            alert('Please enter item name');
            $('#name').focus();
            isValid = false;
        }
        
        if ($('#item_group').val() === '') {
            alert('Please select an item group');
            $('#item_group').focus();
            isValid = false;
        }
        
        if ($('#price').val() === '' || parseFloat($('#price').val()) < 0) {
            alert('Please enter a valid price');
            $('#price').focus();
            isValid = false;
        }
        
        if ($('#purchase_price').val() === '' || parseFloat($('#purchase_price').val()) < 0) {
            alert('Please enter a valid purchase price');
            $('#purchase_price').focus();
            isValid = false;
        }
        
        if ($('#sales_price').val() === '' || parseFloat($('#sales_price').val()) < 0) {
            alert('Please enter a valid sales price');
            $('#sales_price').focus();
            isValid = false;
        }
        
        if ($('#tax_type').val() === '') {
            alert('Please select a tax type');
            $('#tax_type').focus();
            isValid = false;
        }
        
        if ($('#company_id').val() === '') {
            alert('Please select a company');
            $('#company_id').focus();
            isValid = false;
        }
        
        // Check if "other" fields are filled when selected
        if ($('#brand').val() === 'other' && $('#other_brand').val().trim() === '') {
            alert('Please enter brand name');
            $('#other_brand').focus();
            isValid = false;
        }
        
        if ($('#unit').val() === 'other' && $('#other_unit').val().trim() === '') {
            alert('Please enter unit name');
            $('#other_unit').focus();
            isValid = false;
        }
        
        if ($('#category').val() === 'other' && $('#other_category').val().trim() === '') {
            alert('Please enter category name');
            $('#other_category').focus();
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });
</script>
@endpush