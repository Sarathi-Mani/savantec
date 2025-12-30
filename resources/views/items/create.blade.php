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
 @php
        // Prepare tax data for JavaScript
        $taxesArray = $taxes->map(function($tax) {
            return [
                'id' => $tax->id,
                'rate' => $tax->rate,
                'name' => $tax->name,
            ];
        })->toArray();
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="card-title mb-0">{{__('Add/Update Items')}}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('items.store') }}" id="itemForm" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- First Row: Basic Information -->
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
                              <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hsn" class="form-label"><strong>{{ __('HSN') }}</strong></label>
                                    <input type="text" class="form-control" id="hsn" name="hsn" 
                                           placeholder="Enter HSN code" value="{{ old('hsn') }}">
                                </div>
                            </div>
                            
                        </div>

                        <!-- Second Row: Identification - Hidden when Variants selected -->
                        <div id="identificationSection" class="row mb-4">
                          
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="barcode" class="form-label"><strong>{{ __('Barcode') }}</strong></label>
                                    <input type="text" class="form-control" id="barcode" name="barcode" 
                                           placeholder="Enter barcode" value="{{ old('barcode') }}">
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

                


                        <!-- Third Row: Category & Brand -->
                        <div class="row mb-4">
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

                        <!-- Fourth Row: Inventory -->
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
                                    <label for="opening_stock" class="form-label"><strong>{{ __('Opening Stock') }}</strong></label>
                                    <input type="number" class="form-control text-end" id="opening_stock" 
                                           name="opening_stock" min="0" step="1" placeholder="0" 
                                           value="{{ old('opening_stock', 0) }}">
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

                        <!-- Fifth Row: Pricing Section - Start -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="mb-3" style="color: #667eea; font-weight: 600; border-bottom: 2px solid #667eea; padding-bottom: 8px;">
                                    <i class="fas fa-money-bill-wave"></i> {{ __('Pricing Information') }}
                                </h6>
                            </div>
                        </div>

                        <!-- Sixth Row: Base Price -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price" class="form-label"><strong>{{ __('Price*') }}</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control text-end" id="price" 
                                               name="price" min="0" step="0.01" placeholder="0.00" 
                                               required value="{{ old('price', 0) }}">
                                    </div>
                                    <small class="form-text text-muted">{{ __('Base price without tax') }}</small>
                                </div>
                            </div>
                            
                          
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="seller_points" class="form-label"><strong>{{ __('Seller Points') }}</strong></label>
                                    <input type="number" class="form-control text-end" id="seller_points" 
                                           name="seller_points" min="0" step="1" placeholder="0" 
                                           value="{{ old('seller_points', 0) }}">
                                </div>
                            </div>
                        

                        <!-- Seventh Row: Discount -->
                       
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
</div>
                         <div class="row mb-4">    
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
        <label for="tax_percentage_select" class="form-label"><strong>{{ __('Tax %') }}</strong></label>
        <div class="input-group">
            <select class="form-control select2" id="tax_percentage_select" name="tax_percentage_select">
                <option value="">{{ __('-Select-') }}</option>
                <!-- Show only "Add New" option initially -->
                <option value="add_new">{{ __('+ Add New Tax %') }}</option>
            </select>
           
        </div>
        
        <!-- New Tax Input Section - Initially hidden -->
        <div id="newTaxSection" style="display: none; margin-top: 10px;">
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <input type="number" class="form-control text-end" id="new_tax_percentage" 
                               placeholder="Enter tax percentage" min="0" max="100" step="0.01">
                        <span class="input-group-text">%</span>
                        <span class="input-group-text" id="addTaxBtn" style="cursor: pointer; background-color: #28a745; color: white;">
                            <i class="fas fa-plus"></i> Add
                        </span>
                    </div>
                </div>
            </div>
            <small class="text-muted mt-1 d-block">
                {{ __('Enter tax percentage and click Add') }}
            </small>
        </div>
        
        <!-- Hidden inputs for form submission -->
        <input type="hidden" name="tax_percentage" id="selected_tax_percentage" value="{{ old('tax_percentage', 0) }}">
        <input type="hidden" name="tax_name" id="selected_tax_name" value="{{ old('tax_name', '') }}">
        <input type="hidden" name="tax_id" id="selected_tax_id" value="{{ old('tax_id', '') }}">
    </div>
</div>
                            
                            
                        </div>
                           
                        

                        <!-- Eighth Row: Tax Information -->
                       

                        <!-- Ninth Row: Purchase Price Calculation -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="mb-3" style="color: #10b981; font-weight: 600; border-bottom: 2px solid #10b981; padding-bottom: 8px;">
                                    <i class="fas fa-calculator"></i> {{ __('Purchase Price Calculation') }}
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="purchase_price" class="form-label"><strong>{{ __('Purchase Price*') }}</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control text-end" id="purchase_price" 
                                               name="purchase_price" min="0" step="0.01" placeholder="0.00" 
                                               required value="{{ old('purchase_price', 0) }}">
                                    </div>
                                    <small class="form-text text-muted">{{ __('Price + Tax Amount') }}</small>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="calculatePurchasePrice()">
                                            <i class="fas fa-calculator"></i> {{ __('Auto Calculate') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                               <div class="col-md-4">
                                <div class="form-group">
                                    <label for="profit_margin" class="form-label"><strong>{{ __('Profit Margin(%)') }}</strong></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control text-end" id="profit_margin" 
                                               name="profit_margin" min="0" step="0.01" placeholder="0.00" 
                                               value="{{ old('profit_margin', 0) }}">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <small class="form-text text-muted">{{ __('Auto-calculated') }}</small>
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- Tenth Row: Sales Price & Profit Margin -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="mb-3" style="color: #f59e0b; font-weight: 600; border-bottom: 2px solid #f59e0b; padding-bottom: 8px;">
                                    <i class="fas fa-chart-line"></i> {{ __('Sales & Profit Calculation') }}
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sales_price" class="form-label"><strong>{{ __('Sales Price*') }}</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control text-end" id="sales_price" 
                                               name="sales_price" min="0" step="0.01" placeholder="0.00" 
                                               required value="{{ old('sales_price', 0) }}">
                                    </div>
                                    <small class="form-text text-muted">{{ __('Final selling price') }}</small>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="calculateSalesPriceFromPurchase()">
                                            <i class="fas fa-calculator"></i> {{ __('Auto Calculate') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            <div class="col-md-4">
                              
                            </div>
                        </div>

                        <!-- Eleventh Row: Images -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="mb-3" style="color: #8b5cf6; font-weight: 600; border-bottom: 2px solid #8b5cf6; padding-bottom: 8px;">
                                    <i class="fas fa-images"></i> {{ __('Images') }}
                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><strong>{{ __('Main Image') }}</strong></label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="item_image" name="item_image" 
                                               accept="image/*" onchange="previewImage(this)">
                                        <label class="input-group-text" for="item_image">{{ __('Pick Image') }}</label>
                                    </div>
                                    <div class="form-text text-muted">
                                        {{ __('Max Width/Height: 1000px * 1000px & Size: 1MB') }}
                                    </div>
                                    <div class="mt-2">
                                        <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 200px; display: none;">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><strong>{{ __('Additional Image') }}</strong></label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="additional_image" 
                                               name="additional_image" accept="image/*" onchange="previewAdditionalImage(this)">
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

    <!-- Calculation Modal -->
    <div class="modal fade" id="calculationModal" tabindex="-1" aria-labelledby="calculationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="calculationModalLabel">{{ __('Calculate Price') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="base_price" class="form-label">{{ __('Base Price (Cost)') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control" id="base_price" 
                                           step="0.01" placeholder="0.00" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="calculation_type" class="form-label">{{ __('Calculation Type') }}</label>
                                <select class="form-control" id="calculation_type">
                                    <option value="purchase">{{ __('Calculate Purchase Price') }}</option>
                                    <option value="sales">{{ __('Calculate Sales Price') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tax_percentage" class="form-label">{{ __('Tax %') }}</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="tax_percentage" 
                                           step="0.01" placeholder="0" value="18">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="margin_percentage" class="form-label">{{ __('Profit Margin %') }}</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="margin_percentage" 
                                           step="0.01" placeholder="0" value="20">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount_percentage" class="form-label">{{ __('Discount %') }}</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="discount_percentage" 
                                           step="0.01" placeholder="0" value="0">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shipping_cost" class="form-label">{{ __('Shipping Cost') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control" id="shipping_cost" 
                                           step="0.01" placeholder="0.00" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h6 class="alert-heading">{{ __('Calculation Results:') }}</h6>
                                <hr>
                                <div id="calculation_result" class="mt-2">
                                    <p><strong>{{ __('Purchase Price:') }}</strong> <span id="calc_purchase_price">₹0.00</span></p>
                                    <p><strong>{{ __('Sales Price:') }}</strong> <span id="calc_sales_price">₹0.00</span></p>
                                    <p><strong>{{ __('Profit Amount:') }}</strong> <span id="calc_profit_amount">₹0.00</span></p>
                                    <p><strong>{{ __('Profit Percentage:') }}</strong> <span id="calc_profit_percentage">0%</span></p>
                                    <p><strong>{{ __('Tax Amount:') }}</strong> <span id="calc_tax_amount">₹0.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary" onclick="calculatePrice()">{{ __('Calculate') }}</button>
                    <button type="button" class="btn btn-success" onclick="applyCalculation()">{{ __('Apply to Form') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
 /* Variants Table Styling - Consistent Height and Alignment */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

#variantsTable {
    min-width: 1200px;
    width: 100%;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

#variantsTable th {
    background-color: #f8fafc;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #475569;
    border-bottom: 2px solid #e2e8f0;
    padding: 12px 8px;
    white-space: nowrap;
    position: sticky;
    top: 0;
    z-index: 10;
    vertical-align: middle;
}

#variantsTable td {
    vertical-align: middle;
    padding: 8px 8px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.85rem;
    min-width: 80px;
    height: 48px; /* Fixed height for all cells */
}

/* Consistent input styling */
.variant-input {
    width: 100%;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    padding: 6px 8px;
    font-size: 0.85rem;
    transition: all 0.2s ease;
    height: 32px;
    box-sizing: border-box;
}

.variant-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
}

/* Currency and percentage input wrappers */
.currency-input-wrapper,
.percentage-input-wrapper {
    position: relative;
    width: 100%;
}

.currency-symbol,
.percentage-symbol {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: #f1f5f9;
    color: #475569;
    font-weight: 600;
    font-size: 0.75rem;
    padding: 0 8px;
    height: 32px;
    display: flex;
    align-items: center;
    border: 1px solid #e2e8f0;
    z-index: 1;
}

.currency-symbol {
    left: 0;
    border-radius: 4px 0 0 4px;
    border-right: none;
}

.percentage-symbol {
    right: 0;
    border-radius: 0 4px 4px 0;
    border-left: none;
}

/* Adjust input padding for symbols */
.currency-input {
    padding-left: 28px !important;
    text-align: right;
}

.percentage-input {
    padding-right: 28px !important;
    text-align: right;
}

.number-input {
    text-align: right;
}

/* Delete button styling */
.variant-delete-btn {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    border: none;
    border-radius: 4px;
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    transition: all 0.2s ease;
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.variant-delete-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
}

/* Zebra striping for better readability */
#variantsTable tbody tr:nth-child(odd) td {
    background-color: #fafafa;
}

#variantsTable tbody tr:nth-child(even) td {
    background-color: #ffffff;
}

/* Responsive adjustments */
@media (max-width: 1400px) {
    #variantsTable {
        min-width: 1100px;
    }
    
    #variantsTable th,
    #variantsTable td {
        padding: 8px 6px;
        font-size: 0.8rem;
    }
    
    #variantsTable td {
        height: 44px;
    }
    
    .variant-input {
        font-size: 0.8rem;
        padding: 4px 6px;
        height: 30px;
    }
    
    .currency-symbol,
    .percentage-symbol {
        height: 30px;
        font-size: 0.7rem;
        padding: 0 6px;
    }
    
    .currency-input {
        padding-left: 24px !important;
    }
    
    .percentage-input {
        padding-right: 24px !important;
    }
    
    .variant-delete-btn {
        width: 30px;
        height: 30px;
        padding: 0.2rem 0.4rem;
    }
}

@media (max-width: 768px) {
    #variantsTable {
        min-width: 1000px;
    }
    
    #variantsTable th {
        font-size: 0.7rem;
        padding: 6px 4px;
    }
    
    #variantsTable td {
        font-size: 0.75rem;
        padding: 6px 4px;
        height: 40px;
    }
    
    .variant-input {
        font-size: 0.75rem;
        padding: 3px 4px;
        height: 28px;
    }
    
    .currency-symbol,
    .percentage-symbol {
        height: 28px;
        font-size: 0.65rem;
        padding: 0 4px;
    }
    
    .currency-input {
        padding-left: 20px !important;
    }
    
    .percentage-input {
        padding-right: 20px !important;
    }
    
    .variant-delete-btn {
        width: 28px;
        height: 28px;
        padding: 0.15rem 0.3rem;
        font-size: 0.7rem;
    }
}

/* Ensure all cells have same height */
#variantsTable td {
    height: 48px;
}

/* Make sure inputs don't overflow */
.variant-input {
    max-height: 32px;
}

/* Table cell alignment */
#variantsTable td {
    vertical-align: middle;
}

/* Scrollbar styling */
.table-responsive::-webkit-scrollbar {
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Hover effect */
#variantsTable tbody tr:hover td {
    background-color: #f8fafc;
}

/* Border for the last row */
#variantsTable tbody tr:last-child td {
    border-bottom: 1px solid #e2e8f0;
}
</style>
@endpush

@push('scripts')
<script>
    let calculationResults = {
        purchasePrice: 0,
        salesPrice: 0,
        profitAmount: 0,
        profitPercentage: 0,
        taxAmount: 0
    };
    
    let variantCounter = 0;
    let customTaxPercentages = []; // Store custom tax percentages with TAX@ prefix
    
    // Pass existing taxes from Laravel to JavaScript
    const existingTaxes = @json($taxes ?? []);
    
    $(document).ready(function() {
        // Load existing tax percentages from database
        loadExistingTaxPercentages(existingTaxes);
        
        // Initialize tax percentage Select2 dropdown
        $('#tax_percentage_select').select2({
            width: '100%',
            placeholder: 'Select tax % or add new...',
            allowClear: false,
            dropdownParent: $('#itemForm'),
            minimumResultsForSearch: Infinity
        });
        
        // Initialize other Select2 dropdowns
        $('#brand, #unit, #category, #company_id, #discount_type').select2({
            width: '100%',
            placeholder: 'Select...',
            allowClear: true,
            dropdownParent: $('#itemForm')
        });
        
        // Handle tax percentage dropdown change
        $('#tax_percentage_select').on('change', function() {
            const selectedValue = $(this).val();
            const selectedOption = $(this).find('option:selected');
    
            
            if (selectedValue === 'add_new') {
                // Show new tax input section
                $('#newTaxSection').show();
                $('#new_tax_percentage').focus();
                
                // Clear selected tax fields
                $('#selected_tax_percentage').val('');
                $('#selected_tax_name').val('');
                $('#selected_tax_id').val('');
                $('#tax_percentage').val(''); // Clear modal tax percentage
            } else if (selectedValue) {
                // Hide new tax input section
                $('#newTaxSection').hide();
                
                // Store selected tax percentage
                const taxPercent = parseFloat(selectedValue) || 0;
                $('#selected_tax_percentage').val(taxPercent);
                

                const taxId = selectedOption.data('tax-id') || '';
        const taxName = selectedOption.data('tax-name') || ('TAX@' + taxPercent + '%');
        


                $('#selected_tax_name').val(taxName);
        $('#selected_tax_id').val(taxId);
        
        $('#tax_percentage').val(taxPercent); // Update modal tax percentage
        
        // Clear new tax input field
        $('#new_tax_percentage').val('');
        
        // Trigger calculation
        if ($('#price').val() > 0) {
            calculatePurchasePriceFromPrice();
        }
            }
        });
        
        // Add new tax percentage when "Add" button is clicked
        $('#addTaxBtn').on('click', function() {
            addNewTaxPercentage();
        });
        
        // Also allow Enter key to add tax percentage
        $('#new_tax_percentage').on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                addNewTaxPercentage();
                return false;
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
        
        // Toggle sections based on item group selection
        $('#item_group').on('change', function() {
            toggleIdentificationSection();
            togglePriceFields();
        });
        
        // Auto-calculate sales price based on purchase price and profit margin
        $('#purchase_price, #profit_margin').on('keyup change', function() {
            calculateSalesPriceFromPurchase();
        });
        
        // Auto-calculate profit margin when purchase and sales prices change
        $('#purchase_price, #sales_price').on('keyup change', function() {
            calculateProfitMargin();
        });
        
        // Auto-calculate price with discount
        $('#price, #discount, #discount_type').on('keyup change', function() {
            calculateDiscountedPrice();
        });
        
        // Auto-calculate purchase price from price and tax
        $('#price, #tax_percentage_select, #selected_tax_percentage').on('keyup change', function() {
            calculatePurchasePriceFromPrice();
        });
        
        // Initialize calculations
        calculateSalesPriceFromPurchase();
        calculateProfitMargin();
        calculateDiscountedPrice();
        calculatePurchasePriceFromPrice();
        
        // When profit margin changes, update sales price
        $('#profit_margin').on('keyup change', function() {
            if ($('#purchase_price').val() > 0) {
                calculateSalesPriceFromPurchase();
            }
        });
        
        // Initialize sections
        toggleIdentificationSection();
        togglePriceFields();
    });
    
    // Function to load existing tax percentages from database
    function loadExistingTaxPercentages(taxes) {
        // Clear customTaxPercentages array
        customTaxPercentages = [];
        
        // Add existing taxes from database
        if (taxes && taxes.length > 0) {
            taxes.forEach(function(tax) {
                // Check if tax name already has TAX@ prefix
                let displayName = tax.name;
                if (!displayName.includes('TAX@')) {
                    displayName = 'TAX@' + tax.rate + '%';
                }
                
                customTaxPercentages.push({
                    id: tax.id,
                    percentage: parseFloat(tax.rate),
                    name: tax.name,
                    display: displayName,
                    value: tax.rate.toString()
                });
            });
        }
        
        // Sort array by percentage
        customTaxPercentages.sort((a, b) => a.percentage - b.percentage);
        
        // Rebuild dropdown with existing taxes
        rebuildTaxDropdown();
        
        // Set old value if exists (for form validation errors)
        const oldTaxPercentage = parseFloat('{{ old("tax_percentage", 0) }}') || 0;
        const oldTaxName = '{{ old("tax_name", "") }}';
        const oldTaxId = '{{ old("tax_id", "") }}';
        
        if (oldTaxPercentage > 0 && oldTaxName) {
            // Check if this tax already exists in our array
            let existingTax = customTaxPercentages.find(tax => 
                tax.percentage == oldTaxPercentage || tax.name == oldTaxName
            );
            
            if (!existingTax) {
                // Add the old tax to our array
                const displayName = oldTaxName.includes('TAX@') ? oldTaxName : 'TAX@' + oldTaxPercentage + '%';
                customTaxPercentages.push({
                    id: oldTaxId || 'temp_' + Date.now(),
                    percentage: oldTaxPercentage,
                    name: oldTaxName,
                    display: displayName,
                    value: oldTaxPercentage.toString()
                });
                
                // Sort and rebuild
                customTaxPercentages.sort((a, b) => a.percentage - b.percentage);
                rebuildTaxDropdown();
                
                existingTax = customTaxPercentages.find(tax => tax.percentage == oldTaxPercentage);
            }
            
            if (existingTax) {
                // Select the old value
                $('#tax_percentage_select').val(existingTax.value).trigger('change');
                $('#selected_tax_percentage').val(oldTaxPercentage);
                $('#selected_tax_name').val(oldTaxName);
                $('#selected_tax_id').val(oldTaxId || existingTax.id);
            }
        }
    }
    
    // Function to add new tax percentage
    function addNewTaxPercentage() {
        let taxPercent = parseFloat($('#new_tax_percentage').val()) || 0;
        
        // Round to 2 decimal places
        taxPercent = parseFloat(taxPercent.toFixed(2));
        
        if (taxPercent < 0 || taxPercent > 100 || isNaN(taxPercent)) {
            alert('Please enter a valid tax percentage between 0 and 100');
            $('#new_tax_percentage').focus();
            return;
        }
        
        // Generate tax name with TAX@ prefix
        const taxName = 'TAX@' + taxPercent + '%';
        const displayText = taxName;
        const tempId = 'temp_' + Date.now();
        const value = taxPercent.toString();
        
        // Check if this percentage already exists
        const existingTax = customTaxPercentages.find(tax => tax.percentage === taxPercent);
        if (existingTax) {
            // Select existing percentage
            $('#tax_percentage_select').val(existingTax.value).trigger('change');
            $('#selected_tax_percentage').val(taxPercent);
            $('#selected_tax_name').val(existingTax.name);
            $('#selected_tax_id').val(existingTax.id || '');
        } else {
            // Add to custom percentages array with TAX@ prefix
            customTaxPercentages.push({
                id: tempId,
                percentage: taxPercent,
                name: taxName,
                display: displayText,
                value: value
            });
            
            // Sort array by percentage
            customTaxPercentages.sort((a, b) => a.percentage - b.percentage);
            
            // Rebuild dropdown options
            rebuildTaxDropdown();
            
            // Select the new percentage
            $('#tax_percentage_select').val(value).trigger('change');
            $('#selected_tax_percentage').val(taxPercent);
            $('#selected_tax_name').val(taxName);
            $('#selected_tax_id').val(tempId);
        }
        
        // Update tax percentage in calculation modal
        $('#tax_percentage').val(taxPercent);
        
        // Clear input field
        $('#new_tax_percentage').val('');
        
        // Hide new tax section
        $('#newTaxSection').hide();
        
        // Trigger calculation
        if ($('#price').val() > 0) {
            calculatePurchasePriceFromPrice();
        }
    }
    
    // Rebuild tax dropdown with custom percentages
    function rebuildTaxDropdown() {
        // Clear existing options
        $('#tax_percentage_select').empty();
        
        // Add default option
        $('#tax_percentage_select').append(
            $('<option>', {
                value: '',
                text: '-Select-'
            })
        );
        
        // Add custom tax percentages
        customTaxPercentages.forEach(function(tax) {
            $('#tax_percentage_select').append(
                $('<option>', {
                    value: tax.value,
                    text: tax.display,
                    'data-tax-id': tax.id,
                    'data-tax-name': tax.name,
                    'data-tax-percentage': tax.percentage
                })
            );
        });
        
        // Always add "Add New" option at the end
        $('#tax_percentage_select').append(
            $('<option>', {
                value: 'add_new',
                text: '+ Add New Tax %'
            })
        );
        
        // Reinitialize Select2
        $('#tax_percentage_select').select2({
            width: '100%',
            placeholder: 'Select tax % or add new...',
            allowClear: false,
            dropdownParent: $('#itemForm'),
            minimumResultsForSearch: Infinity
        });
    }
    
    // Get selected tax rate from dropdown
    function getSelectedTaxRate() {
        const selectedValue = $('#selected_tax_percentage').val();
        return parseFloat(selectedValue) || 0;
    }
    
    // Toggle identification section (HSN, SKU, Barcode)
    function toggleIdentificationSection() {
        const itemGroup = $('#item_group').val();
        
        if (itemGroup === 'variants') {
            $('#identificationSection').hide();
            
            // Make SKU and Barcode not required when hidden
            $('#sku').prop('required', false);
            $('#barcode').prop('required', false);
            $('#hsn').prop('required', false);
        } else {
            $('#identificationSection').show();
            
            // Make SKU and Barcode optional (if you want them required, change to true)
            $('#sku').prop('required', false);
            $('#barcode').prop('required', false);
            $('#hsn').prop('required', false);
        }
    }
    
    // Toggle price fields and variants section
    function togglePriceFields() {
        const itemGroup = $('#item_group').val();
        
        if (itemGroup === 'variants') {
            $('#variantsSection').show();
            
            // Hide and disable price-related fields for single items
            $('.single-price-field').hide();
            $('#price, #mrp, #purchase_price, #sales_price, #profit_margin').prop('required', false);
        } else {
            $('#variantsSection').hide();
            
            // Show fields for single items
            $('.single-price-field').show();
            $('#price, #purchase_price, #sales_price').prop('required', true);
        }
    }
    
    // Sync tax rate from main form to calculation modal
    function syncTaxRateToModal() {
        const taxRate = getSelectedTaxRate();
        $('#tax_percentage').val(taxRate || 0);
    }
    
    // Open calculation modal for purchase price
    function calculatePurchasePrice() {
        $('#calculation_type').val('purchase');
        $('#calculationModalLabel').text('Calculate Purchase Price');
        $('#base_price').val($('#price').val() || 0);
        
        // Sync tax rate from main form to modal
        syncTaxRateToModal();
        
        $('#margin_percentage').val($('#profit_margin').val() || 20);
        calculatePrice();
        new bootstrap.Modal(document.getElementById('calculationModal')).show();
    }
    
    // Open calculation modal for sales price
    function calculateSalesPriceFromPurchase() {
        $('#calculation_type').val('sales');
        $('#calculationModalLabel').text('Calculate Sales Price');
        $('#base_price').val($('#purchase_price').val() || 0);
        
        // Sync tax rate from main form to modal
        syncTaxRateToModal();
        
        $('#margin_percentage').val($('#profit_margin').val() || 20);
        calculatePrice();
    }
    
    // Main calculation function
    function calculatePrice() {
        const basePrice = parseFloat($('#base_price').val()) || 0;
        const taxPercentage = parseFloat($('#tax_percentage').val()) || 0;
        const marginPercentage = parseFloat($('#margin_percentage').val()) || 0;
        const discountPercentage = parseFloat($('#discount_percentage').val()) || 0;
        const shippingCost = parseFloat($('#shipping_cost').val()) || 0;
        const calculationType = $('#calculation_type').val();
        
        let purchasePrice = 0;
        let salesPrice = 0;
        let taxAmount = 0;
        
        if (calculationType === 'purchase') {
            // Calculate Purchase Price from base price (cost)
            taxAmount = basePrice * (taxPercentage / 100);
            purchasePrice = basePrice + taxAmount;
            
            // Calculate Sales Price from Purchase Price with profit margin
            salesPrice = purchasePrice * (1 + (marginPercentage / 100));
            
            // Apply discount if any
            if (discountPercentage > 0) {
                salesPrice = salesPrice - (salesPrice * (discountPercentage / 100));
            }
            
            // Add shipping cost
            salesPrice += shippingCost;
        } else {
            // Calculate Sales Price from purchase price
            purchasePrice = basePrice;
            salesPrice = purchasePrice * (1 + (marginPercentage / 100));
            
            // Apply discount if any
            if (discountPercentage > 0) {
                salesPrice = salesPrice - (salesPrice * (discountPercentage / 100));
            }
            
            // Add shipping cost
            salesPrice += shippingCost;
            
            // Calculate tax amount (if needed)
            taxAmount = purchasePrice * (taxPercentage / 100);
        }
        
        // Calculate profit
        const profitAmount = salesPrice - purchasePrice;
        const profitPercentage = purchasePrice > 0 ? (profitAmount / purchasePrice) * 100 : 0;
        
        // Store results
        calculationResults = {
            purchasePrice: purchasePrice,
            salesPrice: salesPrice,
            profitAmount: profitAmount,
            profitPercentage: profitPercentage,
            taxAmount: taxAmount
        };
        
        // Update display
        updateCalculationDisplay();
    }
    
    // Update calculation results display
    function updateCalculationDisplay() {
        $('#calc_purchase_price').text('₹' + calculationResults.purchasePrice.toFixed(2));
        $('#calc_sales_price').text('₹' + calculationResults.salesPrice.toFixed(2));
        $('#calc_profit_amount').text('₹' + calculationResults.profitAmount.toFixed(2));
        $('#calc_profit_percentage').text(calculationResults.profitPercentage.toFixed(2) + '%');
        $('#calc_tax_amount').text('₹' + calculationResults.taxAmount.toFixed(2));
    }
    
    // Apply calculation results to form
    function applyCalculation() {
        const calculationType = $('#calculation_type').val();
        
        if (calculationType === 'purchase') {
            $('#purchase_price').val(calculationResults.purchasePrice.toFixed(2));
            $('#sales_price').val(calculationResults.salesPrice.toFixed(2));
            $('#profit_margin').val(calculationResults.profitPercentage.toFixed(2));
        } else {
            $('#sales_price').val(calculationResults.salesPrice.toFixed(2));
            $('#profit_margin').val(calculationResults.profitPercentage.toFixed(2));
        }
        
        // Also update the tax percentage in custom tax if user changed it
        const modalTaxRate = parseFloat($('#tax_percentage').val()) || 0;
        
        // Update tax rate if a custom tax is selected
        const selectedTaxId = $('#selected_tax_id').val();
        if (selectedTaxId && selectedTaxId.startsWith('temp_')) {
            // Find and update the custom tax
            const index = customTaxPercentages.findIndex(tax => tax.id === selectedTaxId);
            if (index !== -1) {
                customTaxPercentages[index].percentage = modalTaxRate;
                customTaxPercentages[index].value = modalTaxRate.toString();
                // Update the display text
                const displayText = 'TAX@' + modalTaxRate + '%';
                customTaxPercentages[index].display = displayText;
                customTaxPercentages[index].name = displayText;
                
                // Sort and rebuild
                customTaxPercentages.sort((a, b) => a.percentage - b.percentage);
                rebuildTaxDropdown();
                
                // Update hidden fields
                $('#selected_tax_percentage').val(modalTaxRate);
                $('#selected_tax_name').val(displayText);
            }
        }
        
        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('calculationModal')).hide();
    }
    
    // Auto-calculate sales price from purchase price and profit margin
    function calculateSalesPriceFromPurchase() {
        const purchasePrice = parseFloat($('#purchase_price').val()) || 0;
        const profitMargin = parseFloat($('#profit_margin').val()) || 0;
        
        if (purchasePrice > 0) {
            const salesPrice = purchasePrice * (1 + (profitMargin / 100));
            $('#sales_price').val(salesPrice.toFixed(2));
        }
    }
    
    // Auto-calculate purchase price from base price and tax
    function calculatePurchasePriceFromPrice() {
        const basePrice = parseFloat($('#price').val()) || 0;
        const taxRate = getSelectedTaxRate();
        
        if (basePrice > 0) {
            const taxAmount = basePrice * (taxRate / 100);
            const purchasePrice = basePrice + taxAmount;
            $('#purchase_price').val(purchasePrice.toFixed(2));
            
            // Recalculate sales price if profit margin is set
            calculateSalesPriceFromPurchase();
        }
    }
    
    // Calculate profit margin
    function calculateProfitMargin() {
        const purchasePrice = parseFloat($('#purchase_price').val()) || 0;
        const salesPrice = parseFloat($('#sales_price').val()) || 0;
        
        if (purchasePrice > 0 && salesPrice > 0) {
            const profitMargin = ((salesPrice - purchasePrice) / purchasePrice) * 100;
            $('#profit_margin').val(profitMargin.toFixed(2));
        }
    }
    
    // Calculate discounted price
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
        
        // Update MRP if it's empty or same as price
        if (!$('#mrp').val() || $('#mrp').val() == $('#price').val()) {
            $('#mrp').val(finalPrice.toFixed(2));
        }
    }
    
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        previewImageFile(input, preview);
    }
    
    function previewAdditionalImage(input) {
        const preview = document.getElementById('additionalImagePreview');
        previewImageFile(input, preview);
    }
    
    function previewImageFile(input, previewElement) {
        const file = input.files[0];
        
        if (file) {
            // Validate file size (1MB = 1048576 bytes)
            if (file.size > 1048576) {
                alert('File size must be less than 1MB');
                input.value = '';
                previewElement.style.display = 'none';
                return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewElement.src = e.target.result;
                previewElement.style.display = 'block';
                
                // Validate image dimensions
                const img = new Image();
                img.onload = function() {
                    if (this.width > 1000 || this.height > 1000) {
                        alert('Image dimensions must be 1000px x 1000px or less');
                        input.value = '';
                        previewElement.style.display = 'none';
                    }
                };
                img.src = e.target.result;
            };
            
            reader.readAsDataURL(file);
        } else {
            previewElement.style.display = 'none';
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
        
        // Tax validation
        const taxPercentage = $('#selected_tax_percentage').val();
        const taxName = $('#selected_tax_name').val();
        
        if (!taxPercentage || taxPercentage === '' || taxPercentage === '0') {
            alert('Please select or add a tax percentage');
            $('#tax_percentage_select').focus();
            isValid = false;
        }
        
        if (!taxName || taxName === '') {
            alert('Please select or add a tax');
            $('#tax_percentage_select').focus();
            isValid = false;
        }
        
        // Company validation
        if ($('#company_id').val() === '') {
            alert('Please select a company');
            $('#company_id').focus();
            isValid = false;
        }
        
        // Price validation for single items
        if (!$('#item_group').val() || $('#item_group').val() !== 'variants') {
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