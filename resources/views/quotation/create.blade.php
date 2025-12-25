<!-- In quotation/create.blade.php -->
@extends('layouts.admin')

@section('page-title')
    {{ __('Create Quotation') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('quotation.index') }}">{{ __('Quotations') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create') }}</li>
@endsection

@push('styles')
<style>
    .select2-container .select2-selection--single {
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    .add-new-link {
        font-size: 0.85rem;
        text-decoration: none;
    }
    .text-success {
        color: #28a745 !important;
    }
    .text-danger {
        color: #dc3545 !important;
    }
    .other-charge-row {
        margin-bottom: 5px;
    }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title mb-0">{{ __('Create New Quotation') }}</h5>
                        </div>
                        <div class="col-md-4 text-end">
                            @if(session('converted_enquiry'))
                                <span class="badge bg-info">
                                    <i class="ti ti-refresh"></i> Converted from Enquiry #{{ session('converted_enquiry')['enquiry_no'] ?? '' }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('quotation.store') }}" id="quotationForm">
                        @csrf
                        
                        <!-- Hidden fields -->
                        <input type="hidden" name="subtotal" id="subtotalInput" value="0">
                        <input type="hidden" name="total_discount" id="totalDiscountInput" value="0">
                        <input type="hidden" name="cgst" id="cgstInput" value="0">
                        <input type="hidden" name="sgst" id="sgstInput" value="0">
                        <input type="hidden" name="igst" id="igstInput" value="0">
                        <input type="hidden" name="grand_total" id="grandTotalInput" value="0">
                        <input type="hidden" name="taxable_amount" id="taxableAmountInput" value="0">
                        <input type="hidden" name="total_tax" id="totalTaxInput" value="0">
                        <input type="hidden" name="round_off" id="roundOffInput" value="0">
                        <input type="hidden" name="other_charges" id="otherChargesInput" value="[]">
                        <input type="hidden" name="other_charges_total" id="otherChargesTotalInput" value="0">
                        
                        <!-- Enquiry Reference (Hidden) -->
                        @if(session('converted_enquiry'))
                            <input type="hidden" name="enquiry_id" value="{{ session('converted_enquiry')['enquiry_id'] ?? '' }}">
                        @endif
                        
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">{{ __('Quotation Details') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="quotation_code" class="form-label">{{ __('Quotation No*') }}</label>
                                                <input type="text" class="form-control" id="quotation_code" 
                                                       name="quotation_code" required
                                                       value="{{ $quotationCode }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="quotation_date" class="form-label">{{ __('Date*') }}</label>
                                                <input type="date" class="form-control" id="quotation_date" 
                                                       name="quotation_date" required
                                                       value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="expire_date" class="form-label">{{ __('Expiry Date') }}</label>
                                                <input type="date" class="form-control" id="expire_date" 
                                                       name="expire_date" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="status" class="form-label">{{ __('Status*') }}</label>
                                                <select class="form-control select2-search" id="status" name="status" required>
                                                    <option value="open" selected>{{ __('Open') }}</option>
                                                    <option value="closed">{{ __('Closed') }}</option>
                                                    <option value="po_converted">{{ __('PO Converted') }}</option>
                                                    <option value="lost">{{ __('Lost') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Customer Information -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">{{ __('Customer Information') }}</h6>
                                            <a href="{{ route('customer.create') }}" 
                                               class="btn btn-sm btn-outline-primary add-new-link">
                                                <i class="ti ti-plus"></i> {{ __('Add New Customer') }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="customer_id" class="form-label">{{ __('Customer*') }}</label>
                                                <div class="input-group">
                                                    <select class="form-control select2-search" id="customer_id" name="customer_id" required>
                                                        <option value="">{{ __('Search Customer...') }}</option>
                                                        @foreach($customers as $customer)
                                                            <option value="{{ $customer->id }}" 
                                                                @if(isset($selectedCustomerId) && $selectedCustomerId == $customer->id) selected 
                                                                @elseif(session('converted_enquiry') && isset(session('converted_enquiry')['customer_id']) && session('converted_enquiry')['customer_id'] == $customer->id) selected @endif>
                                                                {{ $customer->name }} 
                                                                @if($customer->mobile) - {{ $customer->mobile }} @endif
                                                                @if($customer->email) - {{ $customer->email }} @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="contact_person" class="form-label">{{ __('Contact Person*') }}</label>
                                                <input type="text" class="form-control" id="contact_person" 
                                                       name="contact_person" required
                                                       value="{{ session('converted_enquiry')['contact_person'] ?? old('contact_person') }}">
                                            </div>
                                        </div>
                                        
                                        <!-- Customer Details (Will be auto-filled via AJAX) -->
                                        <div id="customerDetails" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">{{ __('Email') }}</label>
                                                    <input type="text" class="form-control" id="customer_email" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">{{ __('Phone') }}</label>
                                                    <input type="text" class="form-control" id="customer_phone" readonly>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <label class="form-label">{{ __('GST No') }}</label>
                                                    <input type="text" class="form-control" id="customer_gst_no" readonly>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <label class="form-label">{{ __('State') }}</label>
                                                    <input type="text" class="form-control" id="customer_state" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="col-md-6">
                                <!-- Sales & Reference -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">{{ __('Sales & Reference') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="salesman_id" class="form-label">{{ __('Sales Engineer*') }}</label>
                                                <select class="form-control select2-search" id="salesman_id" name="salesman_id" required>
                                                    <option value="">{{ __('Search Sales Engineer...') }}</option>
                                                    @foreach($salesmen as $id => $name)
                                                        <option value="{{ $id }}"
                                                            @if(session('converted_enquiry') && session('converted_enquiry')['salesman_id'] == $id) selected 
                                                            @elseif(old('salesman_id') == $id) selected @endif>
                                                            {{ $name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="reference" class="form-label">{{ __('Reference') }}</label>
                                                <input type="text" class="form-control" id="reference" 
                                                       name="reference" value="{{ old('reference') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="reference_no" class="form-label">{{ __('Reference No') }}</label>
                                                <input type="text" class="form-control" id="reference_no" 
                                                       name="reference_no" value="{{ old('reference_no') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="reference_date" class="form-label">{{ __('Reference Date') }}</label>
                                                <input type="date" class="form-control" id="reference_date" 
                                                       name="reference_date" value="{{ old('reference_date') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Tax Information -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">{{ __('Tax Information') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="tax_type" class="form-label">{{ __('Tax Type') }}</label>
                                                <select class="form-control select2-search" id="tax_type" name="tax_type">
                                                    <option value="">{{ __('Select Tax Type...') }}</option>
                                                    <option value="tax_0">{{ __('Tax 0%') }}</option>
                                                    <option value="tax_5">{{ __('Tax 5%') }}</option>
                                                    <option value="tax_12">{{ __('Tax 12%') }}</option>
                                                    <option value="tax_18">{{ __('Tax 18%') }}</option>
                                                    <option value="tax_28">{{ __('Tax 28%') }}</option>
                                                </select>
                                                <small id="taxMessage" class="form-text text-muted"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="tax_regime" class="form-label">{{ __('GST Regime') }}</label>
                                                <select class="form-control select2-search" id="tax_regime" name="tax_regime">
                                                    <option value="">{{ __('Select GST Regime...') }}</option>
                                                    <option value="cgst_sgst">{{ __('CGST + SGST') }}</option>
                                                    <option value="igst">{{ __('IGST') }}</option>
                                                </select>
                                                <small id="taxRegimeMessage" class="form-text text-muted"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Items Section -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">{{ __('Items') }}</h6>
                                    <a href="{{ route('items.create') }}" 
                                       class="btn btn-sm btn-outline-primary add-new-link">
                                        <i class="ti ti-plus"></i> {{ __('Add New Item') }}
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="itemsTable">
                                        <thead>
                                            <tr>
                                                <th width="20%">{{ __('Item*') }}</th>
                                                <th width="15%">{{ __('HSN Code') }}</th>
                                                <th width="15%">{{ __('SKU') }}</th>
                                                <th width="15%">{{ __('Description') }}</th>
                                                <th width="8%">{{ __('Qty*') }}</th>
                                                <th width="8%">{{ __('Unit Price*') }}</th>
                                                <th width="8%">{{ __('Discount') }}</th>
                                                <th width="8%">{{ __('Tax %') }}</th>
                                                <th width="8%">{{ __('Total') }}</th>
                                                <th width="5%">{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemsBody">
                                            @if(session('converted_enquiry') && isset(session('converted_enquiry')['items']))
                                                @php
                                                    $enquiryItems = session('converted_enquiry')['items'] ?? [];
                                                @endphp
                                                @foreach($enquiryItems as $index => $item)
                                                    <tr data-index="{{ $index }}">
                                                        <td>
                                                            <select class="form-control select2-item" name="items[{{ $index }}][item_id]" required>
                                                                <option value="">{{ __('Search Item...') }}</option>
                                                                @foreach($items as $id => $name)
                                                                    <option value="{{ $id }}"
                                                                        @if(isset($item['item_id']) && $item['item_id'] == $id) selected 
                                                                        @elseif(isset($item['description']) && $item['description'] == $name) selected @endif
                                                                        data-hsn="{{ $item['hsn'] ?? '' }}"
                                                                        data-sku="{{ $item['sku'] ?? '' }}"
                                                                        data-discount="{{ $itemDetails[$id]['discount'] ?? 0 }}">
                                                                        {{ $name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control hsn" 
                                                                   name="items[{{ $index }}][hsn]" 
                                                                   value="{{ $item['hsn'] ?? '' }}"
                                                                   placeholder="{{ __('HSN') }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control sku" 
                                                                   name="items[{{ $index }}][sku]" 
                                                                   value="{{ $item['sku'] ?? '' }}"
                                                                   placeholder="{{ __('SKU') }}">
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control item-description" name="items[{{ $index }}][description]" rows="1">{{ $item['description'] ?? ($item['item_id'] ?? '') }}</textarea>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control quantity" 
                                                                   name="items[{{ $index }}][quantity]" min="0.01" step="0.01" 
                                                                   value="{{ $item['quantity'] ?? 1 }}" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control unit-price" 
                                                                   name="items[{{ $index }}][unit_price]" min="0" step="0.01" 
                                                                   value="{{ $item['unit_price'] ?? ($item['sales_price'] ?? 0) }}" required>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="number" class="form-control discount" 
                                                                       name="items[{{ $index }}][discount]" min="0" max="100" step="0.01" 
                                                                       value="{{ $item['discount'] ?? 0 }}">
                                                                <select class="form-control discount-type" name="items[{{ $index }}][discount_type]" style="max-width: 80px;">
                                                                    <option value="percentage" @if(($item['discount_type'] ?? 'percentage') == 'percentage') selected @endif>%</option>
                                                                    <option value="fixed" @if(($item['discount_type'] ?? 'percentage') == 'fixed') selected @endif>₹</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <select class="form-control tax-percentage" name="items[{{ $index }}][tax_percentage]">
                                                                    <option value="0" @if(($item['tax_percentage'] ?? 18) == 0) selected @endif>0%</option>
                                                                    <option value="5" @if(($item['tax_percentage'] ?? 18) == 5) selected @endif>5%</option>
                                                                    <option value="12" @if(($item['tax_percentage'] ?? 18) == 12) selected @endif>12%</option>
                                                                    <option value="18" @if(($item['tax_percentage'] ?? 18) == 18) selected @endif>18%</option>
                                                                    <option value="28" @if(($item['tax_percentage'] ?? 18) == 28) selected @endif>28%</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control total-amount" 
                                                                   name="items[{{ $index }}][total_amount]" readonly
                                                                   value="{{ isset($item['total_amount']) ? number_format($item['total_amount'], 2) : '0.00' }}">
                                                        </td>
                                                        <td>
                                                            @if($loop->first && count($enquiryItems) == 1)
                                                                <button type="button" class="btn btn-sm btn-danger remove-item" disabled>
                                                                    <i class="ti ti-trash"></i>
                                                                </button>
                                                            @else
                                                                <button type="button" class="btn btn-sm btn-danger remove-item">
                                                                    <i class="ti ti-trash"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <!-- Default first row -->
                                                <tr data-index="0">
                                                    <td>
                                                        <select class="form-control select2-item" name="items[0][item_id]" required>
                                                            <option value="">{{ __('Search Item...') }}</option>
                                                            @foreach($items as $id => $name)
                                                                <option value="{{ $id }}" 
                                                                    data-hsn="{{ $itemDetails[$id]['hsn'] ?? '' }}"
                                                                    data-sku="{{ $itemDetails[$id]['sku'] ?? '' }}"
                                                                    data-discount="{{ $itemDetails[$id]['discount'] ?? 0 }}"
                                                                    data-discount-type="{{ $itemDetails[$id]['discount_type'] ?? 'percentage' }}">
                                                                    {{ $name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control hsn" 
                                                               name="items[0][hsn]" 
                                                               value=""
                                                               placeholder="{{ __('HSN Code') }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control sku" 
                                                               name="items[0][sku]" 
                                                               value=""
                                                               placeholder="{{ __('SKU') }}">
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control item-description" name="items[0][description]" rows="1"></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control quantity" 
                                                               name="items[0][quantity]" min="0.01" step="0.01" 
                                                               value="1" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control unit-price" 
                                                               name="items[0][unit_price]" min="0" step="0.01" 
                                                               value="0" required>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control discount" 
                                                                   name="items[0][discount]" min="0" step="0.01" 
                                                                   value="0">
                                                            <select class="form-control discount-type" name="items[0][discount_type]" style="max-width: 80px;">
                                                                <option value="percentage" selected>%</option>
                                                                <option value="fixed">₹</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <select class="form-control tax-percentage" name="items[0][tax_percentage]">
                                                                <option value="0">0%</option>
                                                                <option value="5">5%</option>
                                                                <option value="12">12%</option>
                                                                <option value="18" selected>18%</option>
                                                                <option value="28">28%</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control total-amount" 
                                                               name="items[0][total_amount]" readonly
                                                               value="0.00">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger remove-item" disabled>
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="text-end mt-3">
                                    <button type="button" class="btn btn-primary" id="addItem">
                                        <i class="ti ti-plus"></i> {{ __('Add Item') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Summary Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Terms & Conditions -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">{{ __('Terms & Conditions') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="payment_terms" class="form-label">{{ __('Payment Terms') }}</label>
                                                <textarea class="form-control" id="payment_terms" 
                                                          name="payment_terms" rows="3" placeholder="{{ __('Enter payment terms...') }}">{{ old('payment_terms') }}</textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="description" class="form-label">{{ __('Additional Notes') }}</label>
                                                <textarea class="form-control" id="description" 
                                                          name="description" rows="3" placeholder="{{ __('Enter additional notes...') }}">{{ old('description') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <!-- Totals -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">{{ __('Summary') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Items Count and Quantity -->
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('Total Items') }}</label>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <span id="totalItems">0</span>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('Total Quantity') }}</label>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <span id="totalQuantity">0.00</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Subtotal -->
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('Subtotal') }}</label>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <span id="subtotal">0.00</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Global Discount -->
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('All Items Discount') }}</label>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <div class="input-group input-group-sm mb-2" style="max-width: 200px; float: right;">
                                                    <input type="number" class="form-control" id="globalDiscountValue" 
                                                           value="0" min="0" step="0.01">
                                                    <select class="form-control" id="globalDiscountType" style="width: 80px;">
                                                        <option value="percentage">%</option>
                                                        <option value="fixed">₹</option>
                                                    </select>
                                                    <button type="button" class="btn btn-outline-primary btn-sm" 
                                                            id="applyGlobalDiscount">
                                                        Apply
                                                    </button>
                                                </div>
                                                <span id="totalDiscountDisplay" style="clear: both; display: block;">0.00</span>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('Taxable Amount') }}</label>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <span id="taxableAmount">0.00</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Other Charges Section -->
                                        <div class="card mt-3 mb-3">
                                            <div class="card-header bg-light py-1">
                                                <h6 class="mb-0">{{ __('Other Charges') }}</h6>
                                            </div>
                                            <div class="card-body py-2">
                                                <div class="row mb-2" id="otherChargesContainer">
                                                    <!-- Other charges will be added here dynamically -->
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 text-end">
                                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                                id="addOtherCharge">
                                                            <i class="ti ti-plus"></i> Add Charge
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Tax Breakdown -->
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('CGST') }}</label>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <span id="totalCgst">0.00</span>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('SGST') }}</label>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <span id="totalSgst">0.00</span>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('IGST') }}</label>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <span id="totalIgst">0.00</span>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('Total Tax') }}</label>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <span id="totalTax">0.00</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Round Off -->
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('Round Off') }}</label>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <span id="roundOff">0.00</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Grand Total -->
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('Grand Total') }}</label>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <h5 id="grandTotal">0.00</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Footer Buttons -->
                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success btn-lg px-5">
                                    <i class="ti ti-save"></i> {{ __('Save Quotation') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-lg px-5" onclick="window.history.back()">
                                    <i class="ti ti-x"></i> {{ __('Cancel') }}
                                </button>
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
    // Initialize Select2 for searchable dropdowns
    function initializeSelect2() {
        $('.select2-search').select2({
            placeholder: function() {
                return $(this).data('placeholder') || 'Search...';
            },
            allowClear: true,
            width: '100%'
        });
        
        $('.select2-item').select2({
            placeholder: 'Search Item...',
            allowClear: true,
            width: '100%'
        });
    }
    
    initializeSelect2();
    
    // Initialize itemIndex
    let itemIndex = 0;
    @if(session('converted_enquiry') && isset(session('converted_enquiry')['items']))
        itemIndex = {{ count(session('converted_enquiry')['items']) }};
    @endif
    
    // Initialize other charges index
    let otherChargeIndex = 0;
    
    calculateTotals();
    
    $('#addItem').click(function() {
        const newRow = `
            <tr data-index="${itemIndex}">
                <td>
                    <select class="form-control select2-item" name="items[${itemIndex}][item_id]" required>
                        <option value="">{{ __('Search Item...') }}</option>
                        @foreach($items as $id => $name)
                            <option value="{{ $id }}" 
                                data-hsn="{{ $itemDetails[$id]['hsn'] ?? '' }}"
                                data-sku="{{ $itemDetails[$id]['sku'] ?? '' }}"
                                data-discount="{{ $itemDetails[$id]['discount'] ?? 0 }}"
                                data-discount-type="{{ $itemDetails[$id]['discount_type'] ?? 'percentage' }}">
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control hsn" 
                           name="items[${itemIndex}][hsn]" 
                           value=""
                           placeholder="{{ __('HSN Code') }}">
                </td>
                <td>
                    <input type="text" class="form-control sku" 
                           name="items[${itemIndex}][sku]" 
                           value=""
                           placeholder="{{ __('SKU') }}">
                </td>
                <td>
                    <textarea class="form-control item-description" name="items[${itemIndex}][description]" rows="1"></textarea>
                </td>
                <td>
                    <input type="number" class="form-control quantity" 
                           name="items[${itemIndex}][quantity]" min="0.01" step="0.01" 
                           value="1" required>
                </td>
                <td>
                    <input type="number" class="form-control unit-price" 
                           name="items[${itemIndex}][unit_price]" min="0" step="0.01" 
                           value="0" required>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" class="form-control discount" 
                               name="items[${itemIndex}][discount]" min="0" step="0.01" 
                               value="0">
                        <select class="form-control discount-type" name="items[${itemIndex}][discount_type]" style="max-width: 80px;">
                            <option value="percentage" selected>%</option>
                            <option value="fixed">₹</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <select class="form-control tax-percentage" name="items[${itemIndex}][tax_percentage]">
                            <option value="0">0%</option>
                            <option value="5">5%</option>
                            <option value="12">12%</option>
                            <option value="18" selected>18%</option>
                            <option value="28">28%</option>
                        </select>
                    </div>
                </td>
                <td>
                    <input type="text" class="form-control total-amount" 
                           name="items[${itemIndex}][total_amount]" readonly
                           value="0.00">
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-item">
                        <i class="ti ti-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        
        $('#itemsBody').append(newRow);
        
        $(`[name="items[${itemIndex}][item_id]"]`).select2({
            placeholder: 'Search Item...',
            allowClear: true,
            width: '100%'
        });
        
        itemIndex++;
        calculateTotals();
    });
    
    // Add other charge row
    $('#addOtherCharge').click(function() {
        const chargeHtml = `
            <div class="other-charge-row mb-2" data-index="${otherChargeIndex}">
                <div class="row">
                    <div class="col-5">
                        <input type="text" class="form-control form-control-sm charge-name" 
                               placeholder="Charge Name" name="other_charges[${otherChargeIndex}][name]">
                    </div>
                    <div class="col-4">
                        <div class="input-group input-group-sm">
                            <input type="number" class="form-control charge-amount" 
                                   name="other_charges[${otherChargeIndex}][amount]" 
                                   value="0" min="0" step="0.01">
                            <select class="form-control charge-type" 
                                    name="other_charges[${otherChargeIndex}][type]" style="max-width: 70px;">
                                <option value="fixed">₹</option>
                                <option value="percentage">%</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <select class="form-control form-control-sm charge-tax" 
                                name="other_charges[${otherChargeIndex}][tax]">
                            <option value="0">0%</option>
                            <option value="5">5%</option>
                            <option value="12">12%</option>
                            <option value="18" selected>18%</option>
                            <option value="28">28%</option>
                        </select>
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-charge">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        $('#otherChargesContainer').append(chargeHtml);
        otherChargeIndex++;
        
        calculateTotals();
    });
    
    // Remove other charge
    $(document).on('click', '.remove-charge', function() {
        $(this).closest('.other-charge-row').remove();
        calculateTotals();
    });
    
    // Apply global discount to all items
    $('#applyGlobalDiscount').click(function() {
        const discountValue = parseFloat($('#globalDiscountValue').val()) || 0;
        const discountType = $('#globalDiscountType').val();
        
        if (discountValue > 0) {
            // Apply discount to all items
            $('#itemsBody tr').each(function() {
                const row = $(this);
                const unitPrice = parseFloat(row.find('.unit-price').val()) || 0;
                
                if (unitPrice > 0) {
                    if (discountType === 'percentage') {
                        // Check if percentage exceeds 100
                        const finalDiscount = discountValue > 100 ? 100 : discountValue;
                        row.find('.discount').val(finalDiscount);
                        row.find('.discount-type').val('percentage');
                    } else if (discountType === 'fixed') {
                        const quantity = parseFloat(row.find('.quantity').val()) || 0;
                        const subtotal = quantity * unitPrice;
                        // Check if fixed discount exceeds subtotal
                        const finalDiscount = discountValue > subtotal ? subtotal : discountValue;
                        row.find('.discount').val(finalDiscount);
                        row.find('.discount-type').val('fixed');
                    }
                    
                    calculateRowTotal(row);
                }
            });
            
            calculateTotals();
            toastr.success('Discount applied to all items');
        } else {
            toastr.warning('Please enter a discount value');
        }
    });
    
    // Auto-fill HSN, SKU, and Description when item is selected
    $(document).on('change', '.select2-item', function() {
        const selectedOption = $(this).find('option:selected');
        const selectedText = selectedOption.text();
        const row = $(this).closest('tr');
        
        // Get HSN and SKU from data attributes
        const hsnCode = selectedOption.data('hsn');
        const sku = selectedOption.data('sku');
        const discount = selectedOption.data('discount');
        const discountType = selectedOption.data('discount-type') || 'percentage';
        
        // Fill HSN code
        if(hsnCode) {
            row.find('.hsn').val(hsnCode);
        }
        
        // Fill SKU
        if(sku) {
            row.find('.sku').val(sku);
        }
        
        if(discount !== undefined && discount !== '') {
            row.find('.discount').val(discount);
        }
        
        if(discountType) {
            row.find('.discount-type').val(discountType);
        }
        
        // Fill description with item name
        if(selectedText && selectedText !== '') {
            row.find('.item-description').val(selectedText);
        }
        
        const itemId = $(this).val();
        if(itemId) {
            getItemDetails(itemId, row);
        }
    });
    
    // Updated getItemDetails function to include HSN and SKU
    function getItemDetails(itemId, row) {
        $.ajax({
            url: '{{ route("quotation.get-item-details") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                item_id: itemId
            },
            success: function(response) {
                if(response.success) {
                    // Update description if available
                    if(response.description) {
                        row.find('.item-description').val(response.description);
                    }
                    
                    // Update HSN code if available
                    if(response.hsn) {
                        row.find('.hsn').val(response.hsn);
                    }
                    
                    // Update SKU if available
                    if(response.sku) {
                        row.find('.sku').val(response.sku);
                    }
                    
                    if(response.discount_type) {
                        row.find('.discount-type').val(response.discount_type);
                    }
                    
                    if(response.discount !== undefined) {
                        row.find('.discount').val(response.discount);
                    }
                    
                    // Update price if available
                    if(response.price && response.price > 0) {
                        row.find('.unit-price').val(response.price);
                    }
                    
                    // If item has default tax rate, set it
                    if(response.tax_rate !== undefined) {
                        row.find('.tax-percentage').val(response.tax_rate);
                    }
                    
                    calculateRowTotal(row);
                    calculateTotals();
                }
            }
        });
    }
    
    // Update calculateRowTotal function to handle both percentage and fixed discount
    function calculateRowTotal(row) {
        const quantity = parseFloat(row.find('.quantity').val()) || 0;
        const unitPrice = parseFloat(row.find('.unit-price').val()) || 0;
        const discountValue = parseFloat(row.find('.discount').val()) || 0;
        const discountType = row.find('.discount-type').val();
        const taxPercentage = parseFloat(row.find('.tax-percentage').val()) || 0;
        
        let subtotal = quantity * unitPrice;
        let discountAmount = 0;
        
        if(discountValue > 0) {
            if(discountType === 'percentage') {
                discountAmount = subtotal * discountValue / 100;
            } else if(discountType === 'fixed') {
                discountAmount = discountValue;
                // Ensure discount doesn't exceed subtotal
                if(discountAmount > subtotal) {
                    discountAmount = subtotal;
                    row.find('.discount').val(subtotal);
                }
            }
        }
        
        const taxableAmount = subtotal - discountAmount;
        const taxAmount = taxableAmount * taxPercentage / 100;
        const total = taxableAmount + taxAmount;
        
        row.find('.total-amount').val(total.toFixed(2));
    }
    
    // Update calculateTotals function
    function calculateTotals() {
        let subtotal = 0;
        let totalDiscount = 0;
        let totalTax = 0;
        let totalCgst = 0;
        let totalSgst = 0;
        let totalIgst = 0;
        let totalItems = 0;
        let totalQuantity = 0;
        let taxableAmount = 0;
        
        // Calculate items totals
        $('#itemsBody tr').each(function() {
            const row = $(this);
            const quantity = parseFloat(row.find('.quantity').val()) || 0;
            const unitPrice = parseFloat(row.find('.unit-price').val()) || 0;
            const discountValue = parseFloat(row.find('.discount').val()) || 0;
            const discountType = row.find('.discount-type').val();
            const taxPercentage = parseFloat(row.find('.tax-percentage').val()) || 0;
            
            // Count items and quantities
            if (unitPrice > 0) {
                totalItems++;
            }
            totalQuantity += quantity;
            
            const itemSubtotal = quantity * unitPrice;
            let itemDiscount = 0;
            
            if(discountValue > 0) {
                if(discountType === 'percentage') {
                    itemDiscount = itemSubtotal * discountValue / 100;
                } else if(discountType === 'fixed') {
                    itemDiscount = discountValue;
                    if(itemDiscount > itemSubtotal) {
                        itemDiscount = itemSubtotal;
                    }
                }
                totalDiscount += itemDiscount;
            }
            
            const itemTaxable = itemSubtotal - itemDiscount;
            const itemTax = itemTaxable * taxPercentage / 100;
            totalTax += itemTax;
            
            // Calculate CGST/SGST/IGST based on tax regime
            const taxRegime = $('#tax_regime').val();
            if(taxRegime === 'cgst_sgst') {
                totalCgst += itemTax / 2;
                totalSgst += itemTax / 2;
            } else if(taxRegime === 'igst') {
                totalIgst += itemTax;
            }
            
            subtotal += itemTaxable + itemTax;
        });
        
        taxableAmount = subtotal - totalDiscount;
        
        // Calculate other charges
        let otherChargesTotal = 0;
        let otherChargesArray = [];
        
        $('.other-charge-row').each(function() {
            const row = $(this);
            const name = row.find('.charge-name').val();
            const amount = parseFloat(row.find('.charge-amount').val()) || 0;
            const type = row.find('.charge-type').val();
            const taxRate = parseFloat(row.find('.charge-tax').val()) || 0;
            
            let chargeAmount = amount;
            if (type === 'percentage') {
                // Apply percentage on taxable amount
                chargeAmount = taxableAmount * amount / 100;
            }
            
            // Calculate tax on charge
            const chargeTax = chargeAmount * taxRate / 100;
            const chargeTotal = chargeAmount + chargeTax;
            
            otherChargesTotal += chargeTotal;
            
            // Add to array
            otherChargesArray.push({
                name: name,
                amount: amount,
                type: type,
                tax_rate: taxRate,
                tax_amount: chargeTax,
                total: chargeTotal
            });
            
            // Add to tax totals
            const taxRegime = $('#tax_regime').val();
            if(taxRegime === 'cgst_sgst') {
                totalCgst += chargeTax / 2;
                totalSgst += chargeTax / 2;
            } else if(taxRegime === 'igst') {
                totalIgst += chargeTax;
            }
            
            totalTax += chargeTax;
        });
        
        // Update other charges hidden input
        $('#otherChargesInput').val(JSON.stringify(otherChargesArray));
        $('#otherChargesTotalInput').val(otherChargesTotal);
        
        // Calculate final totals
        const totalBeforeRoundOff = subtotal + otherChargesTotal;
        
        // Calculate round off (nearest whole number)
        const roundOff = Math.round(totalBeforeRoundOff) - totalBeforeRoundOff;
        const grandTotal = totalBeforeRoundOff + roundOff;
        
        // Update display
        $('#totalItems').text(totalItems);
        $('#totalQuantity').text(totalQuantity.toFixed(2));
        $('#subtotal').text(subtotal.toFixed(2));
        $('#totalDiscountDisplay').text(totalDiscount.toFixed(2));
        $('#taxableAmount').text(taxableAmount.toFixed(2));
        $('#totalCgst').text(totalCgst.toFixed(2));
        $('#totalSgst').text(totalSgst.toFixed(2));
        $('#totalIgst').text(totalIgst.toFixed(2));
        $('#totalTax').text(totalTax.toFixed(2));
        $('#grandTotal').text(grandTotal.toFixed(2));
        
        // Style round off
        const roundOffElement = $('#roundOff');
        if (roundOff > 0) {
            roundOffElement.addClass('text-success').removeClass('text-danger');
            roundOffElement.text('+' + roundOff.toFixed(2));
        } else if (roundOff < 0) {
            roundOffElement.addClass('text-danger').removeClass('text-success');
            roundOffElement.text(roundOff.toFixed(2));
        } else {
            roundOffElement.removeClass('text-success text-danger');
            roundOffElement.text('0.00');
        }
        
        // Update hidden inputs
        $('#subtotalInput').val(subtotal);
        $('#totalDiscountInput').val(totalDiscount);
        $('#taxableAmountInput').val(taxableAmount);
        $('#otherChargesTotalInput').val(otherChargesTotal);
        $('#cgstInput').val(totalCgst);
        $('#sgstInput').val(totalSgst);
        $('#igstInput').val(totalIgst);
        $('#totalTaxInput').val(totalTax);
        $('#roundOffInput').val(roundOff);
        $('#grandTotalInput').val(grandTotal);
    }
    
    // Update event listeners
    $(document).on('keyup change', '.quantity, .unit-price, .discount, .discount-type, .tax-percentage, .hsn, .sku', function() {
        const row = $(this).closest('tr');
        calculateRowTotal(row);
        calculateTotals();
    });
    
    $(document).on('keyup change', '.charge-name, .charge-amount, .charge-type, .charge-tax', function() {
        calculateTotals();
    });
    
    // Remove item row
    $(document).on('click', '.remove-item', function() {
        if($('#itemsBody tr').length > 1) {
            $(this).closest('tr').remove();
            calculateTotals();
        }
    });
    
    // Load customer details
    $('#customer_id').change(function() {
        const customerId = $(this).val();
        if(customerId) {
            $.ajax({
                url: '{{ route("quotation.get-customer-details") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    customer_id: customerId
                },
                success: function(response) {
                    if(response.success) {
                        $('#customer_email').val(response.email);
                        $('#customer_phone').val(response.mobile);
                        $('#customer_gst_no').val(response.gst_no);
                        $('#customer_state').val(response.state);
                        $('#customerDetails').show();
                        
                        if(response.contact_person) {
                            $('#contact_person').val(response.contact_person);
                        }
                        
                        // Set tax regime based on customer state
                        setTaxRegime(response.state);
                    }
                }
            });
        } else {
            $('#customerDetails').hide();
            clearCustomerFields();
            $('#tax_regime').val('').trigger('change');
        }
    });
    
    // Refresh customer list after adding new customer
    function refreshCustomerList() {
        $.ajax({
            url: '{{ route("quotation.get-customer-details") }}',
            type: 'GET',
            success: function(response) {
                if(response.success) {
                    // Clear and repopulate customer dropdown
                    $('#customer_id').empty();
                    $('#customer_id').append('<option value="">{{ __('Search Customer...') }}</option>');
                    
                    $.each(response.customers, function(id, customer) {
                        $('#customer_id').append(
                            '<option value="' + customer.id + '">' + 
                            customer.name + 
                            (customer.mobile ? ' - ' + customer.mobile : '') + 
                            (customer.email ? ' - ' + customer.email : '') + 
                            '</option>'
                        );
                    });
                    
                    // Reinitialize Select2
                    $('#customer_id').select2({
                        placeholder: 'Search Customer...',
                        allowClear: true,
                        width: '100%'
                    });
                    
                    toastr.success('Customer list refreshed successfully');
                }
            }
        });
    }
    
    // Refresh item list after adding new item
    function refreshItemList() {
        $.ajax({
            url: '{{ route("quotation.get-item-price") }}',
            type: 'GET',
            success: function(response) {
                if(response.success) {
                    // Update all item dropdowns
                    $('.select2-item').each(function() {
                        const currentValue = $(this).val();
                        $(this).empty();
                        $(this).append('<option value="">{{ __('Search Item...') }}</option>');
                        
                        $.each(response.items, function(id, name) {
                            $(this).append('<option value="' + id + '">' + name + '</option>');
                        }.bind(this));
                        
                        // Restore previous selection
                        if(currentValue) {
                            $(this).val(currentValue).trigger('change');
                        }
                        
                        // Reinitialize Select2
                        $(this).select2({
                            placeholder: 'Search Item...',
                            allowClear: true,
                            width: '100%'
                        });
                    });
                    
                    toastr.success('Item list refreshed successfully');
                }
            }
        });
    }
    
    // Set tax regime based on customer state
    function setTaxRegime(customerState) {
        const companyState = 'Maharashtra'; // Set your company state
        
        if(customerState === companyState) {
            $('#tax_regime').val('cgst_sgst').trigger('change');
            $('#taxRegimeMessage').text('Same state - CGST + SGST applicable');
        } else {
            $('#tax_regime').val('igst').trigger('change');
            $('#taxRegimeMessage').text('Interstate - IGST applicable');
        }
    }
    
    // Apply global tax type to all items
    $('#tax_type').change(function() {
        const taxType = $(this).val();
        let taxRate = 18; // Default
        
        switch(taxType) {
            case 'tax_0':
                taxRate = 0;
                break;
            case 'tax_5':
                taxRate = 5;
                break;
            case 'tax_12':
                taxRate = 12;
                break;
            case 'tax_18':
                taxRate = 18;
                break;
            case 'tax_28':
                taxRate = 28;
                break;
        }
        
        // Apply tax rate to all items
        $('.tax-percentage').val(taxRate);
        
        // Apply tax rate to all other charges
        $('.charge-tax').val(taxRate);
        
        // Recalculate all rows
        $('#itemsBody tr').each(function() {
            calculateRowTotal($(this));
        });
        
        calculateTotals();
    });
    
    // Recalculate when tax regime changes
    $('#tax_regime').change(function() {
        calculateTotals();
    });
    
    @if(session('converted_enquiry') && isset(session('converted_enquiry')['customer_id']))
        $('#customer_id').val('{{ session("converted_enquiry")["customer_id"] }}').trigger('change');
    @endif
    
    function clearCustomerFields() {
        $('#customer_email').val('');
        $('#customer_phone').val('');
        $('#customer_gst_no').val('');
        $('#customer_state').val('');
        $('#contact_person').val('');
    }
    
    // Form validation
    $('#quotationForm').submit(function(e) {
        let isValid = true;
        let errorMessages = [];
        
        if($('#customer_id').val() === '') {
            errorMessages.push('Please select a customer');
            $('#customer_id').select2('open');
            isValid = false;
        }
        
        if($('#contact_person').val().trim() === '') {
            errorMessages.push('Please enter contact person');
            $('#contact_person').focus();
            isValid = false;
        }
        
        if($('#salesman_id').val() === '') {
            errorMessages.push('Please select a sales engineer');
            $('#salesman_id').select2('open');
            isValid = false;
        }
        
        if($('#quotation_code').val().trim() === '') {
            errorMessages.push('Please enter quotation number');
            $('#quotation_code').focus();
            isValid = false;
        }
        
        let hasValidItems = false;
        $('#itemsBody tr').each(function(index) {
            const itemId = $(this).find('.select2-item').val();
            const quantity = $(this).find('.quantity').val();
            const unitPrice = $(this).find('.unit-price').val();
            
            if(!itemId) {
                errorMessages.push(`Item ${index + 1}: Please select an item`);
            }
            
            if(!quantity || parseFloat(quantity) <= 0) {
                errorMessages.push(`Item ${index + 1}: Please enter a valid quantity`);
            }
            
            if(!unitPrice || parseFloat(unitPrice) < 0) {
                errorMessages.push(`Item ${index + 1}: Please enter a valid unit price`);
            }
            
            // Validate discount
            const discount = parseFloat($(this).find('.discount').val()) || 0;
            const discountType = $(this).find('.discount-type').val();
            const itemSubtotal = parseFloat(quantity) * parseFloat(unitPrice);
            
            if(discountType === 'fixed' && discount > itemSubtotal) {
                errorMessages.push(`Item ${index + 1}: Fixed discount cannot exceed item subtotal`);
            }
            
            if(itemId && quantity > 0 && unitPrice > 0) {
                hasValidItems = true;
            }
        });
        
        if(!hasValidItems) {
            errorMessages.push('Please add at least one valid item');
        }
        
        // Validate other charges
        $('.other-charge-row').each(function(index) {
            const name = $(this).find('.charge-name').val();
            const amount = parseFloat($(this).find('.charge-amount').val()) || 0;
            
            if(name && name.trim() !== '' && amount < 0) {
                errorMessages.push(`Other Charge ${index + 1}: Amount cannot be negative`);
            }
            
            if(name && name.trim() === '' && amount > 0) {
                errorMessages.push(`Other Charge ${index + 1}: Please enter charge name`);
            }
        });
        
        if(!isValid) {
            e.preventDefault();
            alert(errorMessages.join('\n'));
        }
    });
    
    // Listen for messages from new windows (customer/item creation)
    window.addEventListener('message', function(event) {
        if (event.data && event.data.action === 'customer_created') {
            refreshCustomerList();
        } else if (event.data && event.data.action === 'item_created') {
            refreshItemList();
        }
    }, false);
});
</script>
@endpush