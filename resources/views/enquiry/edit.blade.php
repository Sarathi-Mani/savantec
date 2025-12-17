@extends('layouts.admin')

@section('page-title')
    {{__('Edit Enquiry')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('enquiry.index')}}">{{__('Enquiry')}}</a></li>
    <li class="breadcrumb-item">{{__('Edit')}}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('enquiry.update', $enquiry->id) }}" enctype="multipart/form-data" id="enquiryForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Information Section -->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="serial_no" class="form-label">{{ __('Enquiry No') }}</label>
                                    <input type="text" class="form-control bg-light" id="serial_no" value="{{ $enquiry->serial_no }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Company Information in Table Format - DISPLAY ONLY -->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <h6 class="my-3 mb-3">{{ __('Company Information') }}</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 25%; font-weight: bold;">
                                                        <label class="form-label mb-0">{{ __('Company Name') }}</label>
                                                    </td>
                                                    <td style="width: 25%;">
                                                        <div class="form-control-plaintext">{{ $enquiry->company_name ?? 'N/A' }}</div>
                                                        <input type="hidden" name="company_id" value="{{ $enquiry->company_id }}">
                                                    </td>
                                                    <td style="width: 25%; font-weight: bold;">
                                                        <label class="form-label mb-0">{{ __('Enquiry Date') }}</label>
                                                    </td>
                                                    <td style="width: 25%;">
                                                        <div class="form-control-plaintext">{{ \Carbon\Carbon::parse($enquiry->enquiry_date)->format('d-m-Y') }}</div>
                                                        <input type="hidden" name="enquiry_date" value="{{ $enquiry->enquiry_date }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;">
                                                        <label class="form-label mb-0">{{ __('Sales Engineer') }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="form-control-plaintext">{{ $enquiry->salesman->name ?? 'Not Assigned' }}</div>
                                                        <input type="hidden" name="salesman_id" value="{{ $enquiry->salesman_id }}">
                                                    </td>
                                                    <td style="font-weight: bold;">
                                                        <label class="form-label mb-0">{{ __('Kind Attn.') }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="form-control-plaintext">{{ $enquiry->kind_attn ?? 'N/A' }}</div>
                                                        <input type="hidden" name="kind_attn" value="{{ $enquiry->kind_attn }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;">
                                                        <label class="form-label mb-0">{{ __('Email') }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="form-control-plaintext">{{ $enquiry->mail_id ?? 'N/A' }}</div>
                                                        <input type="hidden" name="mail_id" value="{{ $enquiry->mail_id }}">
                                                    </td>
                                                    <td style="font-weight: bold;">
                                                        <label class="form-label mb-0">{{ __('Phone') }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="form-control-plaintext">{{ $enquiry->phone_no ?? 'N/A' }}</div>
                                                        <input type="hidden" name="phone_no" value="{{ $enquiry->phone_no }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;">
                                                        <label class="form-label mb-0">{{ __('Remarks') }}</label>
                                                    </td>
                                                    <td colspan="3">
                                                        <div class="form-control-plaintext">{{ $enquiry->remarks ?? 'N/A' }}</div>
                                                        <input type="hidden" name="remarks" value="{{ $enquiry->remarks }}">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

<!-- Items Section -->
@php
    $enquiryItems = json_decode($enquiry->items, true) ?? [];
    $itemCount = count($enquiryItems);
    $status = old('status', $enquiry->status);
    
    // Ensure itemCount is at least 1
    if ($itemCount === 0) {
        $itemCount = 1;
    }
@endphp

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="form-group">
            <h6 class="my-3 mb-3">{{ __('Items') }}</h6>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <small class="text-muted">Select items from list or type custom item</small>
                <button type="button" id="add-item-btn" class="btn btn-sm btn-outline-primary">
                    <i class="ti ti-plus"></i> {{ __('Add Item') }}
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="items-table">
                    <thead class='mt-5'>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 35%;">{{ __('Item Name / Description') }}</th>
                            <th style="width: 10%;">{{ __('Qty') }}</th>
                            <th style="width: 20%;">{{ __('Suitable Item') }}</th>
                            <th style="width: 12.5%;" class="price-column purchase-price-column">{{ __('Purchase Price') }}</th>
                            <th style="width: 12.5%;" class="price-column sales-price-column">{{ __('Sales Price') }}</th>
                            <th style="width: 5%;">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($enquiryItems) > 0)
                            @foreach($enquiryItems as $index => $item)
                                @php 
                                    $currentItemIndex = $loop->iteration;
                                    $itemId = $item['item_id'] ?? null;
                                    $itemDescription = $item['description'] ?? '';
                                    $itemImage = $item['image'] ?? null;
                                @endphp
                                <tr data-item-index="{{ $currentItemIndex }}">
                                    <td>{{ $currentItemIndex }}</td>
                                    <td>
                                        <!-- Item Select Dropdown -->
                                        <select class="form-control select2-item" id="item_select_{{ $currentItemIndex }}" 
                                                name="items[{{ $currentItemIndex }}][item_id]" 
                                                data-index="{{ $currentItemIndex }}" 
                                                style="width: 100%; margin-bottom: 10px;">
                                            <option value="">{{ __('Select Item') }}</option>
                                            @foreach($items as $itemOption)
                                                <option value="{{ $itemOption->id }}" 
                                                        data-description="{{ $itemOption->description }}"
                                                        {{ (isset($itemId) && $itemId == $itemOption->id) ? 'selected' : '' }}>
                                                    {{ $itemOption->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        
                                        <!-- Description Textarea -->
                                        <textarea class="form-control item-description mt-2" 
                                                  id="item_description_{{ $currentItemIndex }}" 
                                                  name="items[{{ $currentItemIndex }}][description]" 
                                                  rows="3" 
                                                  placeholder="{{ __('Item description...') }}" 
                                                  required
                                                  style="{{ $itemId ? 'display:none;' : '' }}">{{ $itemDescription }}</textarea>
                                        
                                        <!-- Image Preview -->
                                        @if(isset($itemImage) && !empty($itemImage))
                                            <div class="mt-2">
                                                <small class="text-muted">Existing Image:</small>
                                                @if(file_exists(public_path('storage/enquiry_items/' . $itemImage)))
                                                    <a href="{{ asset('storage/enquiry_items/' . $itemImage) }}" target="_blank" class="ms-2">
                                                        <i class="ti ti-eye"></i> View Image
                                                    </a>
                                                    <input type="hidden" name="items[{{ $currentItemIndex }}][existing_image]" value="{{ $itemImage }}">
                                                @else
                                                    <span class="ms-2 text-warning">Image not found</span>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        <!-- New Image Upload -->
                                        <div class="mt-2">
                                            <input type="file" 
                                                   class="form-control form-control-sm" 
                                                   id="item_image_{{ $currentItemIndex }}" 
                                                   name="items[{{ $currentItemIndex }}][image]" 
                                                   accept="image/*">
                                            <small class="text-muted">Upload new image (optional)</small>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="items[{{ $currentItemIndex }}][quantity]" 
                                               value="{{ old('items.' . $currentItemIndex . '.quantity', $item['quantity'] ?? 1) }}" 
                                               min="1" required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="items[{{ $currentItemIndex }}][suitable_item]" 
                                               value="{{ old('items.' . $currentItemIndex . '.suitable_item', $item['suitable_item'] ?? '') }}">
                                    </td>
                                    <!-- Conditional purchase price -->
                                    <td class="purchase-price-column">
                                        @if($status != 'ignored')
                                            <input type="number" class="form-control purchase-price" 
                                                   name="items[{{ $currentItemIndex }}][purchase_price]" 
                                                   value="{{ old('items.' . $currentItemIndex . '.purchase_price', $item['purchase_price'] ?? '0.00') }}" 
                                                   step="0.01" min="0">
                                        @else
                                            <input type="hidden" class="form-control purchase-price" 
                                                   name="items[{{ $currentItemIndex }}][purchase_price]" 
                                                   value="0">
                                            <div class="form-control-plaintext text-muted">-</div>
                                        @endif
                                    </td>
                                    <!-- Conditional sales price -->
                                    <td class="sales-price-column">
                                        @if($status != 'ignored')
                                            <input type="number" class="form-control sales-price" 
                                                   name="items[{{ $currentItemIndex }}][sales_price]" 
                                                   value="{{ old('items.' . $currentItemIndex . '.sales_price', $item['sales_price'] ?? '0.00') }}" 
                                                   step="0.01" min="0">
                                        @else
                                            <input type="hidden" class="form-control sales-price" 
                                                   name="items[{{ $currentItemIndex }}][sales_price]" 
                                                   value="0">
                                            <div class="form-control-plaintext text-muted">-</div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($currentItemIndex > 1)
                                            <button type="button" class="btn btn-sm btn-danger remove-item-btn" data-index="{{ $currentItemIndex }}">
                                                <i class="ti ti-minus"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <!-- Default item row -->
                            <tr data-item-index="1">
                                <td>1</td>
                                <td>
                                    <!-- Item Select Dropdown -->
                                    <select class="form-control select2-item" id="item_select_1" 
                                            name="items[1][item_id]" 
                                            data-index="1" 
                                            style="width: 100%; margin-bottom: 10px;">
                                        <option value="">{{ __('Select Item') }}</option>
                                        @foreach($items as $itemOption)
                                            <option value="{{ $itemOption->id }}" 
                                                    data-description="{{ $itemOption->description }}">
                                                {{ $itemOption->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    <!-- Description Textarea -->
                                    <textarea class="form-control item-description mt-2" 
                                              id="item_description_1" 
                                              name="items[1][description]" 
                                              rows="3" 
                                              placeholder="{{ __('Item description...') }}" 
                                              required
                                              style="display:none;">{{ old('items.1.description') }}</textarea>
                                    
                                    <!-- Image Upload -->
                                    <div class="mt-2">
                                        <input type="file" 
                                               class="form-control form-control-sm" 
                                               id="item_image_1" 
                                               name="items[1][image]" 
                                               accept="image/*">
                                        <small class="text-muted">Upload image (optional)</small>
                                    </div>
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="items[1][quantity]" 
                                           value="{{ old('items.1.quantity', 1) }}" min="1" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="items[1][suitable_item]" 
                                           value="{{ old('items.1.suitable_item', '') }}">
                                </td>
                                <!-- Conditional purchase price -->
                                <td class="purchase-price-column">
                                    @if($status != 'ignored')
                                        <input type="number" class="form-control purchase-price" 
                                               name="items[1][purchase_price]" 
                                               value="{{ old('items.1.purchase_price', '0.00') }}" 
                                               step="0.01" min="0">
                                    @else
                                        <input type="hidden" class="form-control purchase-price" 
                                               name="items[1][purchase_price]" 
                                               value="0">
                                        <div class="form-control-plaintext text-muted">-</div>
                                    @endif
                                </td>
                                <!-- Conditional sales price -->
                                <td class="sales-price-column">
                                    @if($status != 'ignored')
                                        <input type="number" class="form-control sales-price" 
                                               name="items[1][sales_price]" 
                                               value="{{ old('items.1.sales_price', '0.00') }}" 
                                               step="0.01" min="0">
                                    @else
                                        <input type="hidden" class="form-control sales-price" 
                                               name="items[1][sales_price]" 
                                               value="0">
                                        <div class="form-control-plaintext text-muted">-</div>
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
                        <!-- Status Section -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <!-- Pending Remarks (left side) - Conditionally shown -->
                                    <div class="col-md-6 purchase-remarks-section" id="pending-remarks-section">
                                        @if($status != 'ignored')
                                            <div class="form-group">
                                                <label for="pending_remarks" class="form-label">{{ __('Pending Remarks') }}</label>
                                                <textarea class="form-control" id="pending_remarks" name="pending_remarks" rows="3" placeholder="{{ __('Enter pending remarks...') }}">{{ old('pending_remarks', $enquiry->pending_remarks) }}</textarea>
                                            </div>
                                        @else
                                            <input type="hidden" name="pending_remarks" value="{{ old('pending_remarks', $enquiry->pending_remarks) }}">
                                        @endif
                                    </div>
                                    
                                    <!-- Status (right side) -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="ready_for_quotation" {{ old('status', $enquiry->status) == 'ready_for_quotation' ? 'selected' : '' }}>{{ __('Ready for Quotation') }}</option>
                                                <option value="ready_for_purchase" {{ old('status', $enquiry->status) == 'ready_for_purchase' ? 'selected' : '' }}>{{ __('Ready for Purchase') }}</option>
                                                <option value="ignored" {{ old('status', $enquiry->status) == 'ignored' ? 'selected' : '' }}>{{ __('Ignore Enquiry') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quotation Section (Visible only when "Ready for Quotation" is selected) -->
                        <div class="row mt-4" id="quotation-section" style="display: {{ old('status', $enquiry->status) == 'ready_for_quotation' ? 'block' : 'none' }};">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">{{ __('Quotation Details') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="quotation_no" class="form-label">{{ __('Quotation Number') }} </label>
                                                    <input type="text" class="form-control" id="quotation_no" name="quotation_no" value="{{ old('quotation_no', $enquiry->quotation_no ?? '') }}" placeholder="{{ __('Enter quotation number') }}">
                                                    <small class="form-text text-muted">Enter quotation number (e.g., QUOT-2024-001)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="quotation_date" class="form-label">{{ __('Quotation Date') }}</label>
                                                    <input type="date" class="form-control" id="quotation_date" name="quotation_date" value="{{ old('quotation_date', $enquiry->quotation_date ?? date('Y-m-d')) }}">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Convert to Quotation Button -->
                                        <div class="row mt-3">
                                            <div class="col-md-12 text-end">
                                                <button type="button" id="convert-to-quotation-btn" class="btn btn-success">
                                                    <i class="ti ti-file-invoice me-1"></i> {{ __('Convert to Quotation') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Buttons -->
                        <div class="modal-footer">
                            <input type="button" value="{{__('Cancel')}}" class="btn btn-light" onclick="window.location.href='{{ route('enquiry.index') }}'">
                            <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .bg-light {
        background-color: #f8f9fa !important;
        cursor: not-allowed;
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .table-bordered td, .table-bordered th {
        border: 1px solid #dee2e6;
    }
    .table td {
        vertical-align: middle;
    }
    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    .form-control-plaintext {
        display: block;
        width: 100%;
        padding: 0.375rem 0;
        margin-bottom: 0;
        line-height: 1.5;
        color: #697a8d;
        background-color: transparent;
        border: solid transparent;
        border-width: 1px 0;
    }
    .table td .form-control {
        border: 1px solid transparent;
        background: transparent;
        transition: all 0.3s;
    }
    .table td .form-control:focus {
        border: 1px solid #80bdff;
        background: #fff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    textarea.form-control {
        resize: vertical;
    }
    .w-auto {
        width: auto !important;
        min-width: 200px;
    }
    .btn-outline-primary {
        border-color: #696cff;
        color: #696cff;
    }
    .btn-outline-primary:hover {
        background-color: #696cff;
        border-color: #696cff;
        color: #fff;
    }
    .btn-danger {
        background-color: #ff3e1d;
        border-color: #ff3e1d;
    }
    .btn-danger:hover {
        background-color: #e63517;
        border-color: #e63517;
    }
    .btn-light {
        background-color: #f8f9fa;
        border-color: #f8f9fa;
        color: #697a8d;
    }
    .btn-light:hover {
        background-color: #e9ecef;
        border-color: #e9ecef;
        color: #697a8d;
    }
    .btn-primary {
        background-color: #696cff;
        border-color: #696cff;
    }
    .btn-primary:hover {
        background-color: #5f61e6;
        border-color: #5f61e6;
    }
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    .modal-footer {
        border-top: 1px solid #dee2e6;
        padding: 1rem 0 0 0;
        margin-top: 1.5rem;
    }
    .card-header {
        background-color: #f0f8ff;
        border-bottom: 1px solid #dee2e6;
    }
    .price-column {
        transition: all 0.3s ease;
    }
    .form-control-plaintext.text-muted {
        color: #6c757d !important;
        padding: 0.375rem 0.75rem;
        line-height: 1.5;
    }
    /* Make the table more responsive */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.9rem;
        }
        
        .table td, .table th {
            padding: 0.5rem;
        }
    }
</style>
@endpush
@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2 for item dropdowns
        function initializeItemSelect2(selector) {
            $(selector).select2({
                width: '100%',
                placeholder: "Select an item",
                allowClear: true,
                tags: true, // Allow custom entries
                createTag: function (params) {
                    return {
                        id: params.term,
                        text: params.term + ' (New)',
                        newOption: true
                    }
                }
            });
        }

        // Initialize existing item dropdowns
        $('.select2-item').each(function() {
            initializeItemSelect2(this);
        });

        // When item is selected from dropdown
        $(document).on('change', '.select2-item', function() {
            const index = $(this).data('index');
            const selectedOption = $(this).find('option:selected');
            const description = selectedOption.data('description');
            const descriptionTextarea = $('#item_description_' + index);
            
            // Auto-fill description if available
            if (description && description.trim() !== '') {
                descriptionTextarea.val(description);
                descriptionTextarea.hide(); // Hide textarea if description is auto-filled
            } else {
                descriptionTextarea.show(); // Show textarea for custom entry
                descriptionTextarea.val('');
                descriptionTextarea.attr('placeholder', 'Enter description for the new item');
            }
        });

        // Global item counter
      let itemCount = {{ $itemCount }};

        // Add item functionality
        $('#add-item-btn').click(function() {
            itemCount++;
            
            const newRow = `
                <tr data-item-index="${itemCount}">
                    <td>${itemCount}</td>
                    <td>
                        <!-- Item Select Dropdown -->
                        <select class="form-control select2-item" id="item_select_${itemCount}" 
                                name="items[${itemCount}][item_id]" 
                                data-index="${itemCount}" 
                                style="width: 100%; margin-bottom: 10px;">
                            <option value="">{{ __('Select Item') }}</option>
                            @foreach($items as $itemOption)
                                <option value="{{ $itemOption->id }}" 
                                        data-description="{{ $itemOption->description }}">
                                    {{ $itemOption->name }}
                                </option>
                            @endforeach
                        </select>
                        
                        <!-- Description Textarea -->
                        <textarea class="form-control item-description mt-2" 
                                  id="item_description_${itemCount}" 
                                  name="items[${itemCount}][description]" 
                                  rows="3" 
                                  placeholder="{{ __('Item description...') }}" 
                                  required
                                  style="display:none;"></textarea>
                        
                        <!-- Image Upload -->
                        <div class="mt-2">
                            <input type="file" 
                                   class="form-control form-control-sm" 
                                   id="item_image_${itemCount}" 
                                   name="items[${itemCount}][image]" 
                                   accept="image/*">
                            <small class="text-muted">Upload image (optional)</small>
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control" name="items[${itemCount}][quantity]" 
                               value="1" min="1" required>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="items[${itemCount}][suitable_item]" 
                               value="">
                    </td>
                    <td class="purchase-price-column">
                        <input type="number" class="form-control purchase-price" 
                               name="items[${itemCount}][purchase_price]" 
                               value="0.00" step="0.01" min="0">
                    </td>
                    <td class="sales-price-column">
                        <input type="number" class="form-control sales-price" 
                               name="items[${itemCount}][sales_price]" 
                               value="0.00" step="0.01" min="0">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger remove-item-btn" data-index="${itemCount}">
                            <i class="ti ti-minus"></i>
                        </button>
                    </td>
                </tr>
            `;
            
            $('#items-table tbody').append(newRow);
            
            // Initialize Select2 for new item dropdown
            initializeItemSelect2('#item_select_' + itemCount);
        });

        // Function to toggle UI based on status (keep existing function)
        function toggleStatusBasedUI() {
            const status = $('#status').val();
            const quotationSection = $('#quotation-section');
            const pendingRemarksSection = $('#pending-remarks-section');
            
            if (status === 'ready_for_quotation') {
                quotationSection.slideDown();
            } else {
                quotationSection.slideUp();
            }
            
            if (status === 'ignored') {
                // Hide pending remarks
                if (pendingRemarksSection.find('.form-group').length > 0) {
                    const currentValue = $('#pending_remarks').val();
                    pendingRemarksSection.html('<input type="hidden" name="pending_remarks" value="' + currentValue + '">');
                }
                
                // Hide price columns
                $('.purchase-price-column, .sales-price-column').hide();
                
                // Convert price inputs to hidden
                $('.purchase-price').each(function() {
                    if ($(this).is(':visible')) {
                        const value = $(this).val();
                        const name = $(this).attr('name');
                        $(this).hide();
                        $(this).after(`
                            <input type="hidden" name="${name}" value="${value}">
                            <div class="form-control-plaintext text-muted">-</div>
                        `);
                    }
                });
                
                $('.sales-price').each(function() {
                    if ($(this).is(':visible')) {
                        const value = $(this).val();
                        const name = $(this).attr('name');
                        $(this).hide();
                        $(this).after(`
                            <input type="hidden" name="${name}" value="${value}">
                            <div class="form-control-plaintext text-muted">-</div>
                        `);
                    }
                });
            } else {
                // Show pending remarks
                if (pendingRemarksSection.find('input[type="hidden"]').length > 0) {
                    const currentValue = pendingRemarksSection.find('input[type="hidden"]').val();
                    pendingRemarksSection.html(`
                        <div class="form-group">
                            <label for="pending_remarks" class="form-label">{{ __('Pending Remarks') }}</label>
                            <textarea class="form-control" id="pending_remarks" name="pending_remarks" rows="3">${currentValue}</textarea>
                        </div>
                    `);
                }
                
                // Show price columns
                $('.purchase-price-column, .sales-price-column').show();
                
                // Convert hidden back to visible
                $('.purchase-price').each(function() {
                    const $parent = $(this).parent();
                    if ($parent.find('input[type="hidden"]').length > 0) {
                        const $hidden = $parent.find('input[type="hidden"]');
                        const value = $hidden.val();
                        const name = $hidden.attr('name');
                        $hidden.next('.form-control-plaintext').remove();
                        $hidden.remove();
                        $parent.append(`
                            <input type="number" class="form-control purchase-price" name="${name}" value="${value}" step="0.01" min="0">
                        `);
                    }
                });
                
                $('.sales-price').each(function() {
                    const $parent = $(this).parent();
                    if ($parent.find('input[type="hidden"]').length > 0) {
                        const $hidden = $parent.find('input[type="hidden"]');
                        const value = $hidden.val();
                        const name = $hidden.attr('name');
                        $hidden.next('.form-control-plaintext').remove();
                        $hidden.remove();
                        $parent.append(`
                            <input type="number" class="form-control sales-price" name="${name}" value="${value}" step="0.01" min="0">
                        `);
                    }
                });
            }
        }

        // Remove item functionality
        $(document).on('click', '.remove-item-btn', function(e) {
            e.preventDefault();
            
            if ($('#items-table tbody tr').length <= 1) {
                alert('At least one item is required');
                return;
            }
            
            $(this).closest('tr').remove();
            renumberItems();
        });

        // Function to renumber items
        function renumberItems() {
            let newIndex = 0;
            $('#items-table tbody tr').each(function() {
                newIndex++;
                const $row = $(this);
                $row.attr('data-item-index', newIndex);
                $row.find('td:first').text(newIndex);
                
                // Update all field names
                $row.find('.select2-item').attr('name', `items[${newIndex}][item_id]`).data('index', newIndex);
                $row.find('.item-description').attr('name', `items[${newIndex}][description]`).attr('id', `item_description_${newIndex}`);
                $row.find('input[name*="quantity"]').attr('name', `items[${newIndex}][quantity]`);
                $row.find('input[name*="suitable_item"]').attr('name', `items[${newIndex}][suitable_item]`);
                $row.find('input[name*="purchase_price"]').attr('name', `items[${newIndex}][purchase_price]`);
                $row.find('input[name*="sales_price"]').attr('name', `items[${newIndex}][sales_price]`);
                $row.find('input[type="file"]').attr('name', `items[${newIndex}][image]`).attr('id', `item_image_${newIndex}`);
                $row.find('input[name*="existing_image"]').attr('name', `items[${newIndex}][existing_image]`);
                
                // Update remove button
                $row.find('.remove-item-btn').data('index', newIndex);
            });
            
            itemCount = newIndex;
            
            if (itemCount === 1) {
                $('#items-table tbody tr:first .remove-item-btn').remove();
                $('#items-table tbody tr:first td:last').html('');
            }
        }

        // Initial toggle
        toggleStatusBasedUI();

        // Toggle on status change
        $('#status').change(function() {
            toggleStatusBasedUI();
        });

        // Convert to Quotation button
        $('#convert-to-quotation-btn').click(function(e) {
            e.preventDefault();
            
            const status = $('#status').val();
            if (status === 'ignored') {
                alert('Cannot convert ignored enquiry to quotation.');
                return;
            }
            
            if (status !== 'ready_for_quotation') {
                alert('Please select "Ready for Quotation" status first.');
                return;
            }
            
            if (confirm('Are you sure you want to convert this enquiry to quotation?')) {
                // Save and redirect
                const formData = $('#enquiryForm').serialize();
                $(this).prop('disabled', true).html('<i class="ti ti-spinner ti-spin me-1"></i> Converting...');
                
                $.ajax({
                    url: $('#enquiryForm').attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        const enquiryId = {{ $enquiry->id }};
                        window.location.href = "{{ route('enquiry.convertToQuotation', ['id' => $enquiry->id]) }}";
                    },
                    error: function(xhr) {
                        alert('Error saving enquiry. Please try again.');
                        $('#convert-to-quotation-btn').prop('disabled', false).html('<i class="ti ti-file-invoice me-1"></i> {{ __('Convert to Quotation') }}');
                    }
                });
            }
        });

        // Form validation
        $('#enquiryForm').submit(function(e) {
            const status = $('#status').val();
            let hasValidItem = false;
            let itemErrors = [];
            
            if (!status) {
                e.preventDefault();
                alert('Please select a status.');
                return false;
            }
            
            // Validate items
            $('.item-description').each(function(index) {
                const itemNumber = index + 1;
                const description = $(this).val().trim();
                const quantity = $(this).closest('tr').find('input[name*="quantity"]').val().trim();
                
                if (!description) {
                    itemErrors.push(`Item ${itemNumber}: Description is required`);
                } else {
                    hasValidItem = true;
                }
                
                if (!quantity || quantity < 1) {
                    itemErrors.push(`Item ${itemNumber}: Quantity must be at least 1`);
                }
            });
            
            if (!hasValidItem) {
                e.preventDefault();
                alert('Please enter description for at least one item.');
                return false;
            }
            
            if (itemErrors.length > 0) {
                e.preventDefault();
                alert('Please fix the following errors:\n\n' + itemErrors.join('\n'));
                return false;
            }
            
            return true;
        });

        // Auto-fill existing items description on page load
        $('.select2-item').each(function() {
            const index = $(this).data('index');
            const selectedOption = $(this).find('option:selected');
            const description = selectedOption.data('description');
            
            if (description && description.trim() !== '') {
                $('#item_description_' + index).val(description).hide();
            }
        });
    });
</script>
@endpush