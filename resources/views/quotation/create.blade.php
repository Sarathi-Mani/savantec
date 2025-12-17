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
                                <!-- Customer Information -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">{{ __('Customer Information') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="customer_id" class="form-label">{{ __('Customer*') }}</label>
                                                <select class="form-control" id="customer_id" name="customer_id" required>
                                                    <option value="">{{ __('Select Customer') }}</option>
                                                    @foreach($customers as $customer)
                                                       <!-- Fixed version -->
<option value="{{ $customer->id }}" 
    @if(isset($selectedCustomerId) && $selectedCustomerId == $customer->id) selected 
    @elseif(session('converted_enquiry') && isset(session('converted_enquiry')['customer_id']) && session('converted_enquiry')['customer_id'] == $customer->id) selected @endif>
    {{ $customer->name }}
</option>
                                                    @endforeach
                                                </select>
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
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Quotation Details -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">{{ __('Quotation Details') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="quotation_code" class="form-label">{{ __('Quotation No*') }}</label>
                                                <input type="text" class="form-control" id="quotation_code" 
                                                       name="quotation_code" required readonly
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
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="open" selected>{{ __('Open') }}</option>
                                                    <option value="closed">{{ __('Closed') }}</option>
                                                    <option value="po_converted">{{ __('PO Converted') }}</option>
                                                    <option value="lost">{{ __('Lost') }}</option>
                                                </select>
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
                                                <select class="form-control" id="salesman_id" name="salesman_id" required>
                                                    <option value="">{{ __('Select Sales Engineer') }}</option>
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
                                
                                <!-- GST Information -->
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">{{ __('GST Information') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="gst_type" class="form-label">{{ __('GST Type') }}</label>
                                                <select class="form-control" id="gst_type" name="gst_type">
                                                    <option value="">{{ __('Select GST Type') }}</option>
                                                    <option value="cgst_sgst">{{ __('CGST + SGST') }}</option>
                                                    <option value="igst">{{ __('IGST') }}</option>
                                                </select>
                                                <small id="gstMessage" class="form-text text-muted"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Items Section -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">{{ __('Items') }}</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="itemsTable">
                                        <thead>
                                            <tr>
                                                <th width="30%">{{ __('Item*') }}</th>
                                                <th width="30%">{{ __('Description') }}</th>
                                                <th width="10%">{{ __('Qty*') }}</th>
                                                <th width="10%">{{ __('Unit Price*') }}</th>
                                                <th width="10%">{{ __('Discount') }}</th>
                                                <th width="10%">{{ __('Total') }}</th>
                                                <th width="5%">{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemsBody">
                                            <!-- Items will be added here -->
                                            @if(session('converted_enquiry') && isset(session('converted_enquiry')['items']))
                                                @php
                                                    $enquiryItems = session('converted_enquiry')['items'] ?? [];
                                                @endphp
                                                @foreach($enquiryItems as $index => $item)
                                                    <tr data-index="{{ $index }}">
                                                        <td>
                                                            <select class="form-control item-select" name="items[{{ $index }}][item_id]" required>
                                                                <option value="">{{ __('Select Item') }}</option>
                                                                @foreach($items as $id => $name)
                                                                    <option value="{{ $name }}"
                                                                        @if(isset($item['item_id']) && $item['item_id'] == $name) selected 
                                                                        @elseif(isset($item['description']) && $item['description'] == $name) selected @endif>
                                                                        {{ $name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control" name="items[{{ $index }}][description]" rows="1">{{ $item['description'] ?? ($item['item_id'] ?? '') }}</textarea>
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
                                                        <select class="form-control item-select" name="items[0][item_id]" required>
                                                            <option value="">{{ __('Select Item') }}</option>
                                                            @foreach($items as $id => $name)
                                                                <option value="{{ $name }}">{{ $name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="items[0][description]" rows="1"></textarea>
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
                                                <label class="form-label">{{ __('Grand Total') }}</label>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <h5 id="grandTotal">0.00</h5>
                                            </div>
                                        </div>
                                        
                                        <!-- Hidden fields for calculations -->
                                        <input type="hidden" id="subtotalInput" name="subtotal" value="0">
                                        <input type="hidden" id="totalDiscountInput" name="total_discount" value="0">
                                        <input type="hidden" id="cgstInput" name="cgst" value="0">
                                        <input type="hidden" id="sgstInput" name="sgst" value="0">
                                        <input type="hidden" id="igstInput" name="igst" value="0">
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
<script>
    $(document).ready(function() {
        // Initialize itemIndex based on session data or default to 1
        let itemIndex = 0;
        @if(session('converted_enquiry') && isset(session('converted_enquiry')['items']))
            itemIndex = {{ count(session('converted_enquiry')['items']) }};
        @endif
        
        // Calculate totals for initial rows
        calculateTotals();
        
        // Add new item row
        $('#addItem').click(function() {
            const newRow = `
                <tr data-index="${itemIndex}">
                    <td>
                        <select class="form-control item-select" name="items[${itemIndex}][item_id]" required>
                            <option value="">{{ __('Select Item') }}</option>
                            @foreach($items as $id => $name)
                                <option value="{{ $name }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <textarea class="form-control" name="items[${itemIndex}][description]" rows="1"></textarea>
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
        $(document).on('keyup', '.quantity, .unit-price, .discount', function() {
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
                            $('#customerDetails').show();
                        }
                    }
                });
                
                // Get GST type for this customer
                $.ajax({
                    url: '{{ route("quotation.get-gst-type") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        customer_id: customerId
                    },
                    success: function(response) {
                        $('#gst_type').val(response.gst_type);
                        $('#gstMessage').text(response.message);
                    }
                });
            } else {
                $('#customerDetails').hide();
                $('#gst_type').val('');
                $('#gstMessage').text('');
            }
        });
        
        // Auto-fill description when item is selected
        $(document).on('change', '.item-select', function() {
            const selectedItem = $(this).val();
            const descriptionField = $(this).closest('tr').find('textarea[name$="[description]"]');
            
            if(selectedItem && descriptionField.val().trim() === '') {
                descriptionField.val(selectedItem);
            }
        });
        
        // Initialize customer selection if coming from enquiry
        @if(session('converted_enquiry') && isset(session('converted_enquiry')['customer_id']))
            $('#customer_id').val('{{ session("converted_enquiry")["customer_id"] }}').trigger('change');
        @endif
        
        function calculateRowTotal(row) {
            const quantity = parseFloat(row.find('.quantity').val()) || 0;
            const unitPrice = parseFloat(row.find('.unit-price').val()) || 0;
            const discount = parseFloat(row.find('.discount').val()) || 0;
            
            let total = quantity * unitPrice;
            if(discount > 0) {
                total -= (total * discount / 100);
            }
            
            row.find('.total-amount').val(total.toFixed(2));
        }
        
        function calculateTotals() {
            let subtotal = 0;
            let totalDiscount = 0;
            
            $('#itemsBody tr').each(function() {
                const rowTotal = parseFloat($(this).find('.total-amount').val()) || 0;
                subtotal += rowTotal;
                
                const quantity = parseFloat($(this).find('.quantity').val()) || 0;
                const unitPrice = parseFloat($(this).find('.unit-price').val()) || 0;
                const discount = parseFloat($(this).find('.discount').val()) || 0;
                
                if(discount > 0) {
                    const itemSubtotal = quantity * unitPrice;
                    totalDiscount += (itemSubtotal * discount / 100);
                }
            });
            
            // Calculate GST based on selected type
            const gstType = $('#gst_type').val();
            let cgst = 0;
            let sgst = 0;
            let igst = 0;
            
            if(gstType === 'cgst_sgst') {
                cgst = sgst = (subtotal * 9) / 100; // Assuming 18% GST split as 9% CGST + 9% SGST
            } else if(gstType === 'igst') {
                igst = (subtotal * 18) / 100; // Assuming 18% IGST
            }
            
            const grandTotal = subtotal - totalDiscount + cgst + sgst + igst;
            
            // Update display
            $('#subtotal').text(subtotal.toFixed(2));
            $('#totalDiscount').text(totalDiscount.toFixed(2));
            $('#totalCgst').text(cgst.toFixed(2));
            $('#totalSgst').text(sgst.toFixed(2));
            $('#totalIgst').text(igst.toFixed(2));
            $('#grandTotal').text(grandTotal.toFixed(2));
            
            // Update hidden inputs
            $('#subtotalInput').val(subtotal);
            $('#totalDiscountInput').val(totalDiscount);
            $('#cgstInput').val(cgst);
            $('#sgstInput').val(sgst);
            $('#igstInput').val(igst);
            $('#grandTotalInput').val(grandTotal);
        }
        
        // Recalculate when GST type changes
        $('#gst_type').change(function() {
            calculateTotals();
        });
        
        // Form validation
        $('#quotationForm').submit(function(e) {
            let isValid = true;
            let errorMessages = [];
            
            // Validate required fields
            if($('#customer_id').val() === '') {
                errorMessages.push('Please select a customer');
                $('#customer_id').focus();
                isValid = false;
            }
            
            if($('#contact_person').val().trim() === '') {
                errorMessages.push('Please enter contact person');
                $('#contact_person').focus();
                isValid = false;
            }
            
            if($('#salesman_id').val() === '') {
                errorMessages.push('Please select a sales engineer');
                $('#salesman_id').focus();
                isValid = false;
            }
            
            // Validate items
            let hasValidItems = false;
            $('#itemsBody tr').each(function(index) {
                const itemId = $(this).find('.item-select').val();
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
    });
</script>
@endpush