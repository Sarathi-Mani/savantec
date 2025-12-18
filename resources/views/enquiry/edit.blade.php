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
    
    // Create a lookup array for item images from the items table
    $itemImagesLookup = [];
    foreach($items ?? [] as $item) {
        if ($item->image) {
            $itemImagesLookup[$item->id] = $item->image;
        }
    }
@endphp

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="form-group">
            <h6 class="my-3 mb-3">{{ __('Items') }}</h6>
            <div class="table-responsive">
                <table class="table table-bordered" id="items-table">
                    <thead class='mt-5'>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 20%;">{{ __('Item Name') }}</th>
                            <th style="width: 10%;">{{ __('Qty') }}</th>
                            <th style="width: 25%;">{{ __('Description') }}</th>
                            <th style="width: 15%;">{{ __('Suitable Item') }}</th>
                            @if($status == 'ready_for_purchase' || $status == 'ready_for_quotation')
                                <th style="width: 10%;">{{ __('Purchase Price') }}</th>
                                <th style="width: 10%;">{{ __('Sales Price') }}</th>
                            @endif
                            <th style="width: 10%;">{{ __('Item Image') }}</th>
                          
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
                                    $itemName = '';
                                    
                                    // Get item name from items collection if item_id exists
                                    if ($itemId && isset($items) && $items->contains('id', $itemId)) {
                                        $selectedItem = $items->firstWhere('id', $itemId);
                                        $itemName = $selectedItem->name ?? '';
                                        
                                        // If itemImage is null but item exists in items table, get image from items table
                                        if (empty($itemImage) && isset($itemImagesLookup[$itemId])) {
                                            $itemImage = $itemImagesLookup[$itemId];
                                        }
                                    } else {
                                        $itemName = $item['description'] ?? 'Custom Item';
                                    }
                                    
                                    // Initialize variables for image display
                                    $imageFound = false;
                                    $imageUrl = null;
                                    
                                    if ($itemImage) {
                                        // Extract just the filename
                                        $filename = basename($itemImage);
                                        
                                        // Check different possible paths
                                        $possiblePaths = [
                                            'items/' => storage_path('app/public/items/'),
                                            'enquiry_items/' => storage_path('app/public/enquiry_items/'),
                                        ];
                                        
                                        foreach ($possiblePaths as $folder => $basePath) {
                                            $fullPath = $basePath . $filename;
                                            if (file_exists($fullPath)) {
                                                $imageFound = true;
                                                $imageUrl = asset('storage/' . $folder . $filename);
                                                break;
                                            }
                                        }
                                        
                                        // If not found, check with different variations
                                        if (!$imageFound) {
                                            // Try with only filename (remove any query strings or extra paths)
                                            $cleanFilename = preg_replace('/\?.*/', '', $filename);
                                            $cleanFilename = basename($cleanFilename);
                                            
                                            foreach ($possiblePaths as $folder => $basePath) {
                                                $fullPath = $basePath . $cleanFilename;
                                                if (file_exists($fullPath)) {
                                                    $imageFound = true;
                                                    $imageUrl = asset('storage/' . $folder . $cleanFilename);
                                                    break;
                                                }
                                            }
                                        }
                                        
                                        // Check if it's already a valid URL
                                        if (!$imageFound && filter_var($itemImage, FILTER_VALIDATE_URL)) {
                                            $imageFound = true;
                                            $imageUrl = $itemImage;
                                        }
                                        
                                        // Check if it's a public URL
                                        if (!$imageFound && strpos($itemImage, 'http') === 0) {
                                            $imageFound = true;
                                            $imageUrl = $itemImage;
                                        }
                                    }
                                @endphp
                                <tr data-item-index="{{ $currentItemIndex }}">
                                    <td>{{ $currentItemIndex }}</td>
                                    <td>
                                        <!-- Item Name Display (Regular Column) -->
                                        <div class="item-name-display" id="item_name_display_{{ $currentItemIndex }}">
                                            {{ $itemName ?: 'No item selected' }}
                                        </div>
                                        <!-- Hidden input for item_id or custom item -->
                                        @if($itemId)
                                            <input type="hidden" class="item-name-input" 
                                                   name="items[{{ $currentItemIndex }}][item_id]" 
                                                   value="{{ $itemId }}">
                                        @else
                                            <input type="hidden" class="item-name-input" 
                                                   name="items[{{ $currentItemIndex }}][item_id]" 
                                                   value="">
                                            <input type="hidden" 
                                                   name="items[{{ $currentItemIndex }}][custom_item]" 
                                                   value="{{ $itemName }}">
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Qty Display (Regular Column) -->
                                        <div class="qty-display" id="qty_display_{{ $currentItemIndex }}">
                                            {{ $item['quantity'] ?? 1 }}
                                        </div>
                                        <input type="hidden" class="qty-input" 
                                               name="items[{{ $currentItemIndex }}][quantity]" 
                                               value="{{ $item['quantity'] ?? 1 }}">
                                    </td>
                                    <td>
                                        <!-- Description Display (Regular Column - NO INPUT BOX) -->
                                        <div class="item-description-display" id="item_description_display_{{ $currentItemIndex }}">
                                            {{ $itemDescription ?: 'No description' }}
                                        </div>
                                        <input type="hidden" class="item-description-input" 
                                               name="items[{{ $currentItemIndex }}][description]" 
                                               value="{{ $itemDescription }}">
                                    </td>
                                    <td>
                                        <!-- Suitable Item Input Box -->
                                        <input type="text" class="form-control form-control-sm" 
                                               name="items[{{ $currentItemIndex }}][suitable_item]" 
                                               value="{{ old('items.' . $currentItemIndex . '.suitable_item', $item['suitable_item'] ?? '') }}"
                                               placeholder="{{ __('Enter suitable item...') }}">
                                    </td>
                                    
                                    <!-- Show purchase price and sales price columns only for ready_for_purchase or ready_for_quotation -->
                                    @if($status == 'ready_for_purchase' || $status == 'ready_for_quotation')
                                        <td>
                                            <input type="number" class="form-control form-control-sm purchase-price" 
                                                   name="items[{{ $currentItemIndex }}][purchase_price]" 
                                                   value="{{ old('items.' . $currentItemIndex . '.purchase_price', $item['purchase_price'] ?? '0.00') }}" 
                                                   step="0.01" min="0"
                                                   placeholder="0.00">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm sales-price" 
                                                   name="items[{{ $currentItemIndex }}][sales_price]" 
                                                   value="{{ old('items.' . $currentItemIndex . '.sales_price', $item['sales_price'] ?? '0.00') }}" 
                                                   step="0.01" min="0"
                                                   placeholder="0.00">
                                        </td>
                                    @else
                                        <!-- Hidden inputs for purchase and sales price when columns are not shown -->
                                        <input type="hidden" class="purchase-price" 
                                               name="items[{{ $currentItemIndex }}][purchase_price]" 
                                               value="{{ $item['purchase_price'] ?? '0.00' }}">
                                        <input type="hidden" class="sales-price" 
                                               name="items[{{ $currentItemIndex }}][sales_price]" 
                                               value="{{ $item['sales_price'] ?? '0.00' }}">
                                    @endif
                                    
                                    <td>
                                        <!-- Image Preview -->
                                        <div class="item-image-container text-center">
                                            @if($itemImage && $imageFound)
                                                <a href="{{ $imageUrl }}" 
                                                   target="_blank" 
                                                   class="d-block">
                                                    <img src="{{ $imageUrl }}" 
                                                         alt="Item Image" 
                                                         class="img-thumbnail" 
                                                         style="max-height: 60px; max-width: 60px;"
                                                        onerror="this.onerror=null; this.style.display='none'; this.parentElement.innerHTML='<div class=\'text-warning small\'><i class=\'ti ti-alert-triangle\'></i> Image not found</div>';">
                                                </a>
                                                <small class="text-muted d-block mt-1">
                                                    <a href="{{ $imageUrl }}" 
                                                       target="_blank" class="text-decoration-none">
                                                        <i class="ti ti-eye"></i> View
                                                    </a>
                                                </small>
                                                <input type="hidden" 
                                                       name="items[{{ $currentItemIndex }}][existing_image]" 
                                                       value="{{ $itemImage }}">
                                            @elseif($itemImage && !$imageFound)
                                                <div class="text-danger small">
                                                    <i class="ti ti-alert-circle"></i> Image missing
                                                </div>
                                                <input type="hidden" 
                                                       name="items[{{ $currentItemIndex }}][existing_image]" 
                                                       value="{{ $itemImage }}">
                                            @else
                                                <div class="text-muted small">
                                                    <i class="ti ti-photo-off"></i> No image
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        @else
                            <!-- Default item row -->
                            <tr data-item-index="1">
                                <td>1</td>
                                <td>
                                    <!-- Item Name Display (Regular Column) -->
                                    <div class="item-name-display" id="item_name_display_1">
                                        No item selected
                                    </div>
                                    <input type="hidden" class="item-name-input" 
                                           name="items[1][item_id]" 
                                           value="">
                                </td>
                                <td>
                                    <!-- Qty Display (Regular Column) -->
                                    <div class="qty-display" id="qty_display_1">
                                        1
                                    </div>
                                    <input type="hidden" class="qty-input" 
                                           name="items[1][quantity]" 
                                           value="1">
                                </td>
                                <td>
                                    <!-- Description Display (Regular Column - NO INPUT BOX) -->
                                    <div class="item-description-display" id="item_description_display_1">
                                        No description
                                    </div>
                                    <input type="hidden" class="item-description-input" 
                                           name="items[1][description]" 
                                           value="">
                                </td>
                                <td>
                                    <!-- Suitable Item Input Box -->
                                    <input type="text" class="form-control form-control-sm" 
                                           name="items[1][suitable_item]" 
                                           value="{{ old('items.1.suitable_item', '') }}"
                                           placeholder="{{ __('Enter suitable item...') }}">
                                </td>
                                
                                <!-- Show purchase price and sales price columns only for ready_for_purchase or ready_for_quotation -->
                                @if($status == 'ready_for_purchase' || $status == 'ready_for_quotation')
                                    <td>
                                        <input type="number" class="form-control form-control-sm purchase-price" 
                                               name="items[1][purchase_price]" 
                                               value="{{ old('items.1.purchase_price', '0.00') }}" 
                                               step="0.01" min="0"
                                               placeholder="0.00">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm sales-price" 
                                               name="items[1][sales_price]" 
                                               value="{{ old('items.1.sales_price', '0.00') }}" 
                                               step="0.01" min="0"
                                               placeholder="0.00">
                                    </td>
                                @else
                                    <!-- Hidden inputs for purchase and sales price when columns are not shown -->
                                    <input type="hidden" class="purchase-price" 
                                           name="items[1][purchase_price]" 
                                           value="0.00">
                                    <input type="hidden" class="sales-price" 
                                           name="items[1][sales_price]" 
                                           value="0.00">
                                @endif
                                
                                <td>
                                    <!-- Image Preview Only (No Upload) -->
                                    <div class="item-image-container text-center">
                                        <div class="text-muted small">
                                            <i class="ti ti-photo-off"></i> No image
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>     

<!-- Status Section -->
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <!-- Pending Remarks (left side) - Conditionally shown -->
            <div class="col-md-6 purchase-remarks-section" id="pending-remarks-section">
                @if($status == 'ready_for_purchase')
                    <div class="form-group">
                        <label for="pending_remarks" class="form-label">{{ __('Pending Remarks') }}</label>
                        <textarea class="form-control" id="pending_remarks" name="pending_remarks" rows="3" placeholder="{{ __('Enter pending remarks...') }}">{{ old('pending_remarks', $enquiry->pending_remarks) }}</textarea>
                    </div>
                @elseif($status == 'ready_for_quotation')
                    <div class="form-group">
                        <label for="pending_remarks" class="form-label">{{ __('Pending Remarks') }}</label>
                        <div class="form-control-plaintext bg-light p-2 rounded" style="min-height: 80px;">
                            {{ old('pending_remarks', $enquiry->pending_remarks) ?: 'No pending remarks' }}
                        </div>
                        <input type="hidden" name="pending_remarks" value="{{ old('pending_remarks', $enquiry->pending_remarks) }}">
                    </div>
                @else
                    <input type="hidden" name="pending_remarks" value="{{ old('pending_remarks', $enquiry->pending_remarks) }}">
                @endif
            </div>
            
            <!-- Status (right side) -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status" class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="status" name="status" required>
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

     .select2-container--default .select2-selection--single {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        height: 38px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
        padding-left: 12px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    
    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-right: 30px;
    }
    
    .select2-dropdown {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }
    
    .select2-results__option {
        padding: 8px 12px;
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #696cff;
    }
    
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #f8f9fa;
        color: #212529;
    }
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
        // Initialize Select2 for status dropdown
        $('#status').select2({
            width: '100%',
            placeholder: "Select status",
            allowClear: false,
            minimumResultsForSearch: 0 // Always show search
        });

        // Global item counter
        let itemCount = {{ $itemCount }};

        // Add empty item row
        $('#add-item-btn').click(function() {
            itemCount++;
            
            const status = $('#status').val();
            const showPrices = (status == 'ready_for_purchase' || status == 'ready_for_quotation');
            
            let newRow = `
                <tr data-item-index="${itemCount}">
                    <td>${itemCount}</td>
                    <td>
                        <div class="item-name-display" id="item_name_display_${itemCount}">
                            Custom Item
                        </div>
                        <input type="hidden" class="item-name-input" 
                               name="items[${itemCount}][item_id]" 
                               value="">
                        <input type="hidden" 
                               name="items[${itemCount}][custom_item]" 
                               value="Custom Item">
                    </td>
                    <td>
                        <div class="qty-display" id="qty_display_${itemCount}">
                            1
                        </div>
                        <input type="hidden" class="qty-input" 
                               name="items[${itemCount}][quantity]" 
                               value="1">
                    </td>
                    <td>
                        <div class="item-description-display" id="item_description_display_${itemCount}">
                            Custom Item
                        </div>
                        <input type="hidden" class="item-description-input" 
                               name="items[${itemCount}][description]" 
                               value="Custom Item">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" 
                               name="items[${itemCount}][suitable_item]" 
                               value=""
                               placeholder="{{ __('Enter suitable item...') }}">
                    </td>`;
            
            if (showPrices) {
                newRow += `
                    <td>
                        <input type="number" class="form-control form-control-sm purchase-price" 
                               name="items[${itemCount}][purchase_price]" 
                               value="0.00" 
                               step="0.01" min="0"
                               placeholder="0.00">
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm sales-price" 
                               name="items[${itemCount}][sales_price]" 
                               value="0.00" 
                               step="0.01" min="0"
                               placeholder="0.00">
                    </td>`;
            } else {
                newRow += `
                    <input type="hidden" class="purchase-price" 
                           name="items[${itemCount}][purchase_price]" 
                           value="0.00">
                    <input type="hidden" class="sales-price" 
                           name="items[${itemCount}][sales_price]" 
                           value="0.00">`;
            }
            
            newRow += `
                    <td>
                        <div class="item-image-container text-center">
                            <div class="text-muted small">
                                <i class="ti ti-photo-off"></i> No image
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger remove-item-btn" data-index="${itemCount}">
                            <i class="ti ti-trash"></i>
                        </button>
                    </td>
                </tr>`;
            
            $('#items-table tbody').append(newRow);
            
            // Renumber items
            renumberItems();
        });

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
                $row.find('.item-name-input').attr('name', `items[${newIndex}][item_id]`);
                $row.find('.qty-input').attr('name', `items[${newIndex}][quantity]`);
                $row.find('.item-description-input').attr('name', `items[${newIndex}][description]`).attr('id', `item_description_input_${newIndex}`);
                $row.find('input[name*="custom_item"]').attr('name', `items[${newIndex}][custom_item]`);
                $row.find('input[name*="suitable_item"]').attr('name', `items[${newIndex}][suitable_item]`);
                $row.find('.purchase-price').attr('name', `items[${newIndex}][purchase_price]`);
                $row.find('.sales-price').attr('name', `items[${newIndex}][sales_price]`);
                $row.find('input[name*="existing_image"]').attr('name', `items[${newIndex}][existing_image]`);
                
                // Update display elements
                $row.find('.item-name-display').attr('id', `item_name_display_${newIndex}`);
                $row.find('.qty-display').attr('id', `qty_display_${newIndex}`);
                $row.find('.item-description-display').attr('id', `item_description_display_${newIndex}`);
                
                // Update remove button
                $row.find('.remove-item-btn').data('index', newIndex);
            });
            
            itemCount = newIndex;
            
            if (itemCount === 1) {
                $('#items-table tbody tr:first .remove-item-btn').remove();
                $('#items-table tbody tr:first td:last').html('');
            }
        }

        // Function to toggle UI based on status
        function toggleStatusBasedUI() {
            const status = $('#status').val();
            const quotationSection = $('#quotation-section');
            const pendingRemarksSection = $('#pending-remarks-section');
            const showPrices = (status == 'ready_for_purchase' || status == 'ready_for_quotation');
            
            // Toggle quotation section
            if (status === 'ready_for_quotation') {
                quotationSection.slideDown();
            } else {
                quotationSection.slideUp();
            }
            
            // Toggle pending remarks based on status
            const currentValue = getPendingRemarksValue();
            
            if (status === 'ready_for_purchase') {
                // Show textarea for editing
                pendingRemarksSection.html(`
                    <div class="form-group">
                        <label for="pending_remarks" class="form-label">{{ __('Pending Remarks') }}</label>
                        <textarea class="form-control" id="pending_remarks" name="pending_remarks" rows="3" placeholder="{{ __('Enter pending remarks...') }}">${currentValue}</textarea>
                    </div>
                `);
            } else if (status === 'ready_for_quotation') {
                // Show read-only display
                pendingRemarksSection.html(`
                    <div class="form-group">
                        <label for="pending_remarks" class="form-label">{{ __('Pending Remarks') }}</label>
                        <div class="form-control-plaintext bg-light p-2 rounded" style="min-height: 80px;">
                            ${currentValue || 'No pending remarks'}
                        </div>
                        <input type="hidden" name="pending_remarks" value="${currentValue}">
                    </div>
                `);
            } else {
                // Hide and store in hidden input
                pendingRemarksSection.html(`<input type="hidden" name="pending_remarks" value="${currentValue}">`);
            }
            
            // Toggle price columns based on status
            togglePriceColumns(showPrices);
        }

        // Function to get current pending remarks value
        function getPendingRemarksValue() {
            const pendingRemarksSection = $('#pending-remarks-section');
            
            // Check for textarea
            const textarea = pendingRemarksSection.find('textarea');
            if (textarea.length > 0) {
                return textarea.val();
            }
            
            // Check for hidden input
            const hiddenInput = pendingRemarksSection.find('input[type="hidden"][name="pending_remarks"]');
            if (hiddenInput.length > 0) {
                return hiddenInput.val();
            }
            
            // Check for displayed text
            const displayedText = pendingRemarksSection.find('.form-control-plaintext');
            if (displayedText.length > 0) {
                return displayedText.text().trim();
            }
            
            return '';
        }

        // Function to toggle price columns
        function togglePriceColumns(showPrices) {
            const itemsTable = $('#items-table');
            const thead = itemsTable.find('thead tr');
            const tbodyRows = itemsTable.find('tbody tr');
            
            if (showPrices) {
                // Show price columns if not already shown
                if (thead.find('th:nth-child(6)').text() !== '{{ __('Purchase Price') }}') {
                    // Add headers
                    thead.find('th:nth-child(6), th:nth-child(7)').remove();
                    thead.append(`
                        <th style="width: 10%;">{{ __('Purchase Price') }}</th>
                        <th style="width: 10%;">{{ __('Sales Price') }}</th>
                         <th style="width: 10%;">{{ __('Item Image') }}</th>
                          
                    `);
                    
                    // Add price columns to each row
                    tbodyRows.each(function() {
                        const $row = $(this);
                        const itemIndex = $row.data('item-index');
                        
                        // Get existing purchase price and sales price from hidden inputs
                        let purchasePrice = '0.00';
                        let salesPrice = '0.00';
                        
                        // Check if there are hidden price inputs
                        const hiddenPurchaseInput = $row.find('input[name*="purchase_price"][type="hidden"]');
                        const hiddenSalesInput = $row.find('input[name*="sales_price"][type="hidden"]');
                        
                        if (hiddenPurchaseInput.length > 0) {
                            purchasePrice = hiddenPurchaseInput.val();
                            hiddenPurchaseInput.remove();
                        }
                        
                        if (hiddenSalesInput.length > 0) {
                            salesPrice = hiddenSalesInput.val();
                            hiddenSalesInput.remove();
                        }
                        
                        // Insert price columns before the image column
                        $row.find('td:nth-last-child(2)').before(`
                            <td>
                                <input type="number" class="form-control form-control-sm purchase-price" 
                                       name="items[${itemIndex}][purchase_price]" 
                                       value="${purchasePrice}" 
                                       step="0.01" min="0"
                                       placeholder="0.00">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm sales-price" 
                                       name="items[${itemIndex}][sales_price]" 
                                       value="${salesPrice}" 
                                       step="0.01" min="0"
                                       placeholder="0.00">
                            </td>
                        `);
                    });
                }
            } else {
                // Hide price columns if they are shown
                if (thead.find('th:nth-child(6)').text() === '{{ __('Purchase Price') }}') {
                    // Store price values in hidden inputs and remove columns
                    thead.find('th:nth-child(6), th:nth-child(7)').remove();
                    
                    tbodyRows.each(function() {
                        const $row = $(this);
                        const itemIndex = $row.data('item-index');
                        
                        // Get current price values
                        const purchasePriceInput = $row.find('.purchase-price[type="number"]');
                        const salesPriceInput = $row.find('.sales-price[type="number"]');
                        
                        let purchasePrice = '0.00';
                        let salesPrice = '0.00';
                        
                        if (purchasePriceInput.length > 0) {
                            purchasePrice = purchasePriceInput.val() || '0.00';
                            purchasePriceInput.parent().remove();
                        }
                        
                        if (salesPriceInput.length > 0) {
                            salesPrice = salesPriceInput.val() || '0.00';
                            salesPriceInput.parent().remove();
                        }
                        
                        // Add hidden inputs with the values
                        $row.append(`
                            <input type="hidden" class="purchase-price" 
                                   name="items[${itemIndex}][purchase_price]" 
                                   value="${purchasePrice}">
                            <input type="hidden" class="sales-price" 
                                   name="items[${itemIndex}][sales_price]" 
                                   value="${salesPrice}">
                        `);
                    });
                }
            }
        }

        // Initial toggle
        toggleStatusBasedUI();

        // Toggle on status change
        $('#status').on('change', function() {
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
            
            if (!status) {
                e.preventDefault();
                alert('Please select a status.');
                return false;
            }
            
            // Check if at least one item has either item_id or custom_item
            let hasValidItem = false;
            $('#items-table tbody tr').each(function() {
                const itemNameDisplay = $(this).find('.item-name-display').text().trim();
                if (itemNameDisplay && itemNameDisplay !== 'No item selected') {
                    hasValidItem = true;
                }
            });
            
            if (!hasValidItem) {
                e.preventDefault();
                alert('Please add at least one item.');
                return false;
            }
            
            return true;
        });
        
        // Handle broken images
        $('img.img-thumbnail').on('error', function() {
            const $img = $(this);
            const $container = $img.closest('.item-image-container');
            if ($container.length) {
                $container.html('<div class="text-warning small"><i class="ti ti-alert-triangle"></i> Image failed to load</div>');
            }
        });
    });
</script>
@endpush