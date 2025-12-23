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
                                                <th width="25%">{{ __('Item*') }}</th>
                                                <th width="30%">{{ __('Description') }}</th>
                                                <th width="10%">{{ __('Qty*') }}</th>
                                                <th width="10%">{{ __('Unit Price*') }}</th>
                                                <th width="10%">{{ __('Discount') }}</th>
                                                <th width="10%">{{ __('Tax %') }}</th>
                                                <th width="10%">{{ __('Total') }}</th>
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
                                                                        @elseif(isset($item['description']) && $item['description'] == $name) selected @endif>
                                                                        {{ $name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
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
                                                            <input type="number" class="form-control discount" 
                                                                   name="items[{{ $index }}][discount]" min="0" step="0.01" 
                                                                   value="0">
                                                        </td>
                                                        <td>
                                                            <select class="form-control tax-percentage" name="items[{{ $index }}][tax_percentage]">
                                                                <option value="0">0%</option>
                                                                <option value="5">5%</option>
                                                                <option value="12">12%</option>
                                                                <option value="18" selected>18%</option>
                                                                <option value="28">28%</option>
                                                            </select>
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
                                                                <option value="{{ $id }}">{{ $name }}</option>
                                                            @endforeach
                                                        </select>
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
                                                        <input type="number" class="form-control discount" 
                                                               name="items[0][discount]" min="0" step="0.01" 
                                                               value="0">
                                                    </td>
                                                    <td>
                                                        <select class="form-control tax-percentage" name="items[0][tax_percentage]">
                                                            <option value="0">0%</option>
                                                            <option value="5">5%</option>
                                                            <option value="12">12%</option>
                                                            <option value="18" selected>18%</option>
                                                            <option value="28">28%</option>
                                                        </select>
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
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('Subtotal') }}</label>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <span id="subtotal">0.00</span>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('Discount') }}</label>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <span id="totalDiscount">0.00</span>
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
                                        
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('Grand Total') }}</label>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <h5 id="grandTotal">0.00</h5>
                                            </div>
                                        </div>
                                        
                                        <!-- Hidden fields for calculations -->
                                        <input type="hidden" id="subtotalInput" name="subtotal" value="0">
                                        <input type="hidden" id="totalDiscountInput" name="total_discount" value="0">
                                        <input type="hidden" id="taxableAmountInput" name="taxable_amount" value="0">
                                        <input type="hidden" id="cgstInput" name="cgst" value="0">
                                        <input type="hidden" id="sgstInput" name="sgst" value="0">
                                        <input type="hidden" id="igstInput" name="igst" value="0">
                                        <input type="hidden" id="totalTaxInput" name="total_tax" value="0">
                                        <input type="hidden" id="grandTotalInput" name="grand_total" value="0">
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
        
        calculateTotals();
        
        // Add new item row
        $('#addItem').click(function() {
            const newRow = `
                <tr data-index="${itemIndex}">
                    <td>
                        <select class="form-control select2-item" name="items[${itemIndex}][item_id]" required>
                            <option value="">{{ __('Search Item...') }}</option>
                            @foreach($items as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
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
                        <input type="number" class="form-control discount" 
                               name="items[${itemIndex}][discount]" min="0" step="0.01" 
                               value="0">
                    </td>
                    <td>
                        <select class="form-control tax-percentage" name="items[${itemIndex}][tax_percentage]">
                            <option value="0">0%</option>
                            <option value="5">5%</option>
                            <option value="12">12%</option>
                            <option value="18" selected>18%</option>
                            <option value="28">28%</option>
                        </select>
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
        
        // Remove item row
        $(document).on('click', '.remove-item', function() {
            if($('#itemsBody tr').length > 1) {
                $(this).closest('tr').remove();
                calculateTotals();
            }
        });
        
        // Calculate item totals
        $(document).on('keyup change', '.quantity, .unit-price, .discount, .tax-percentage', function() {
            const row = $(this).closest('tr');
            calculateRowTotal(row);
            calculateTotals();
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
        
        // Auto-fill description when item is selected - FIXED VERSION
        $(document).on('change', '.select2-item', function() {
            const selectedText = $(this).find('option:selected').text();
            const descriptionField = $(this).closest('tr').find('.item-description');
            
            // Always update description when item changes
            if(selectedText && selectedText !== '') {
                descriptionField.val(selectedText);
            }
            
            const itemId = $(this).val();
            if(itemId) {
                getItemPrice(itemId, $(this).closest('tr'));
            }
        });
        
        // Get item details via AJAX - UPDATED to get description
        function getItemDetails(itemId, row) {
            $.ajax({
                url: '{{ route("quotation.get-item-price") }}',
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
        
        // Get item price via AJAX - ORIGINAL FUNCTION
        function getItemPrice(itemId, row) {
            $.ajax({
                url: '{{ route("quotation.get-item-price") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    item_id: itemId
                },
                success: function(response) {
                    if(response.success && response.price > 0) {
                        row.find('.unit-price').val(response.price);
                        
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
            
            // Recalculate all rows
            $('#itemsBody tr').each(function() {
                calculateRowTotal($(this));
            });
            
            calculateTotals();
        });
        
        @if(session('converted_enquiry') && isset(session('converted_enquiry')['customer_id']))
            $('#customer_id').val('{{ session("converted_enquiry")["customer_id"] }}').trigger('change');
        @endif
        
        function calculateRowTotal(row) {
            const quantity = parseFloat(row.find('.quantity').val()) || 0;
            const unitPrice = parseFloat(row.find('.unit-price').val()) || 0;
            const discount = parseFloat(row.find('.discount').val()) || 0;
            const taxPercentage = parseFloat(row.find('.tax-percentage').val()) || 0;
            
            let subtotal = quantity * unitPrice;
            let discountAmount = 0;
            
            if(discount > 0) {
                discountAmount = subtotal * discount / 100;
            }
            
            const taxableAmount = subtotal - discountAmount;
            const taxAmount = taxableAmount * taxPercentage / 100;
            const total = taxableAmount + taxAmount;
            
            row.find('.total-amount').val(total.toFixed(2));
        }
        
        function calculateTotals() {
            let subtotal = 0;
            let totalDiscount = 0;
            let totalTax = 0;
            let totalCgst = 0;
            let totalSgst = 0;
            let totalIgst = 0;
            
            $('#itemsBody tr').each(function() {
                const rowTotal = parseFloat($(this).find('.total-amount').val()) || 0;
                subtotal += rowTotal;
                
                const quantity = parseFloat($(this).find('.quantity').val()) || 0;
                const unitPrice = parseFloat($(this).find('.unit-price').val()) || 0;
                const discount = parseFloat($(this).find('.discount').val()) || 0;
                const taxPercentage = parseFloat($(this).find('.tax-percentage').val()) || 0;
                
                const itemSubtotal = quantity * unitPrice;
                let itemDiscount = 0;
                
                if(discount > 0) {
                    itemDiscount = itemSubtotal * discount / 100;
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
            });
            
            const taxableAmount = subtotal - totalDiscount;
            const grandTotal = subtotal;
            
            // Update display
            $('#subtotal').text(subtotal.toFixed(2));
            $('#totalDiscount').text(totalDiscount.toFixed(2));
            $('#taxableAmount').text(taxableAmount.toFixed(2));
            $('#totalCgst').text(totalCgst.toFixed(2));
            $('#totalSgst').text(totalSgst.toFixed(2));
            $('#totalIgst').text(totalIgst.toFixed(2));
            $('#totalTax').text(totalTax.toFixed(2));
            $('#grandTotal').text(grandTotal.toFixed(2));
            
            // Update hidden inputs
            $('#subtotalInput').val(subtotal);
            $('#totalDiscountInput').val(totalDiscount);
            $('#taxableAmountInput').val(taxableAmount);
            $('#cgstInput').val(totalCgst);
            $('#sgstInput').val(totalSgst);
            $('#igstInput').val(totalIgst);
            $('#totalTaxInput').val(totalTax);
            $('#grandTotalInput').val(grandTotal);
        }
        
        function clearCustomerFields() {
            $('#customer_email').val('');
            $('#customer_phone').val('');
            $('#customer_gst_no').val('');
            $('#customer_state').val('');
            $('#contact_person').val('');
        }
        
        // Recalculate when tax regime changes
        $('#tax_regime').change(function() {
            calculateTotals();
        });
        
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
                
                if(itemId && quantity > 0 && unitPrice > 0) {
                    hasValidItems = true;
                }
            });
            
            if(!hasValidItems) {
                errorMessages.push('Please add at least one valid item');
            }
            
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