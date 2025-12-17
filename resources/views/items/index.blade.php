@extends('layouts.admin')
@php
    // Determine if user has special permissions
    $isSuperAdmin = \Auth::user()->type == 'super admin';
    $isCompanyAdmin = \Auth::user()->type == 'company';
    
    // Prepare categories for filter
    $categories = $items->unique('category')->pluck('category')->filter();
@endphp

@section('page-title')
    {{__('Manage Items')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Items')}}</li>
@endsection

@section('action-btn')
    {{-- Use the export buttons component --}}
    <x-export-buttons 
        tableId="itemTable"
        :createButton="true"
        createRoute="{{ route('items.create') }}"
        createPermission="create item"
        createLabel="New Item"
        createIcon="ti-plus"
        createTooltip="Create New Item"
        :columns="[
            ['index' => 0, 'name' => 'S.No', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Image', 'description' => 'Item image'],
            ['index' => 2, 'name' => 'Item Code', 'description' => 'Item SKU/barcode'],
            ['index' => 3, 'name' => 'Item Name', 'description' => 'Item name and group'],
            ['index' => 4, 'name' => 'Description', 'description' => 'Item description'],
            ['index' => 5, 'name' => 'Brand', 'description' => 'Brand name'],
            ['index' => 6, 'name' => 'Category/Item Type', 'description' => 'Category and item type'],
            ['index' => 7, 'name' => 'Unit', 'description' => 'Measurement unit'],
            ['index' => 8, 'name' => 'Stock', 'description' => 'Current stock quantity'],
            ['index' => 9, 'name' => 'Alert Quantity', 'description' => 'Minimum stock alert'],
            ['index' => 10, 'name' => 'Sales Price', 'description' => 'Selling price with cost'],
            ['index' => 11, 'name' => 'Tax', 'description' => 'Tax rate and name'],
            ['index' => 12, 'name' => 'Status', 'description' => 'Active/Inactive status'],
            ['index' => 13, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
        ]"
        :customButtons="[
            [
                'label' => 'Export',
                'icon' => 'ti-download',
                'route' => route('items.export'),
                'tooltip' => 'Export Items',
                'class' => 'btn btn-outline-success btn-sm',
                'permission' => 'item_export'
            ]
        ]"
    />
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="ti ti-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="ti ti-alert-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <!-- Filters Section -->
                    <!-- <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">{{__('Company')}}</label>
                                    <select class="form-select form-select-sm" id="company-filter">
                                        <option value="">-All Companies-</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{__('Category')}}</label>
                                    <select class="form-select form-select-sm" id="category-filter">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}">{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end align-items-end h-100">
                                <button class="btn btn-sm btn-light me-2" id="reset-filters">
                                    <i class="ti ti-refresh me-1"></i> {{__('Reset')}}
                                </button>
                                <button class="btn btn-sm btn-primary" id="apply-filters">
                                    <i class="ti ti-filter me-1"></i> {{__('Apply')}}
                                </button>
                            </div>
                        </div>
                    </div> -->
                    
                    <div class="table-responsive">
                        <table class="table w-100" id="itemTable">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center">{{__('S.No')}}</th>
                                    <th>{{__('Image')}}</th>
                                    <th>{{__('Item Code')}}</th>
                                    <th>{{__('Item Name')}}</th>
                                    <th>{{__('Description')}}</th>
                                    <th>{{__('Brand')}}</th>
                                    <th>{{__('Category')}}</th>
                                    <th>{{__('Unit')}}</th>
                                    <th>{{__('Stock')}}</th>
                                    <th>{{__('Alert Qty')}}</th>
                                    <th>{{__('Sales Price')}}</th>
                                    <th>{{__('Tax')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th width="120" class="text-center">{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            @if($item->image)
                                                <img src="{{ Storage::url($item->image) }}" 
                                                     alt="{{ $item->name }}" 
                                                     class="rounded-circle" 
                                                     width="40" 
                                                     height="40"
                                                     style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="ti ti-photo text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $item->sku ?? 'N/A' }}</span>
                                            @if($item->barcode)
                                                <small class="d-block text-muted">{{ $item->barcode }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $item->name }}</strong>
                                            @if($item->item_group)
                                                <br>
                                                <small class="badge bg-info">{{ strtoupper($item->item_group) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->description)
                                                <span data-bs-toggle="tooltip" title="{{ $item->description }}">
                                                    {{ Str::limit($item->description, 30) }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->brand)
                                                <span class="badge bg-light text-dark">{{ $item->brand }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->category ?? '-' }}
                                            @if($item->item_group)
                                                <small class="d-block text-muted">{{ strtoupper($item->item_group) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->unit)
                                                <span class="badge bg-light text-dark">{{ $item->unit }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $stock = $item->quantity ?? 0;
                                                $alertQuantity = $item->alert_quantity ?? 0;
                                            @endphp
                                            
                                            @if($stock <= $alertQuantity && $stock > 0)
                                                <span class="badge bg-warning" data-bs-toggle="tooltip" title="Low Stock">
                                                    <i class="ti ti-alert-triangle me-1"></i>{{ number_format($stock, 2) }}
                                                </span>
                                            @elseif($stock == 0)
                                                <span class="badge bg-danger" data-bs-toggle="tooltip" title="Out of Stock">
                                                    <i class="ti ti-x me-1"></i>{{ number_format($stock, 2) }}
                                                </span>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="ti ti-check me-1"></i>{{ number_format($stock, 2) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $item->alert_quantity ?? 0 }}</td>
                                        <td>
                                            <span class="fw-bold">₹{{ number_format($item->sales_price, 2) }}</span>
                                            @if($item->purchase_price)
                                                <small class="d-block text-muted">Cost: ₹{{ number_format($item->purchase_price, 2) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->tax)
                                                <span class="badge bg-light text-dark">{{ $item->tax->name ?? '' }}</span>
                                                @if($item->tax->rate)
                                                    <small class="d-block text-muted">{{ number_format($item->tax->rate, 2) }}%</small>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($stock > 0)
                                                <span class="badge bg-success">{{__('Active')}}</span>
                                            @else
                                                <span class="badge bg-danger">{{__('Inactive')}}</span>
                                            @endif
                                            
                                            @if($item->profit_margin)
                                                <small class="d-block text-muted">{{ number_format($item->profit_margin, 2) }}% margin</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                @can('item_edit')
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="{{ route('items.edit', $item->id) }}" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="{{__('Edit')}}">
                                                        <i class="ti ti-pencil text-dark"></i>
                                                    </a>
                                                </div>
                                                @endcan
                                                
                                                @can('item_delete')
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['items.destroy', $item->id], 'id' => 'delete-form-' . $item->id, 'class' => 'd-inline']) !!}
                                                    <a href="#!" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" 
                                                       data-bs-toggle="tooltip" 
                                                       title="{{__('Delete')}}" 
                                                       data-confirm="{{__('Are You Sure?')}}" 
                                                       data-text="{{__('This action will permanently delete the item. Do you want to continue?')}}" 
                                                       data-confirm-yes="delete-form-{{ $item->id }}">
                                                        <i class="ti ti-trash text-danger"></i>
                                                    </a>
                                                    {!! Form::close() !!}
                                                </div>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="14" class="text-center">
                                            <div class="alert alert-info d-inline-flex align-items-center">
                                                <i class="ti ti-info-circle me-2"></i>
                                                {{ __('No items found.') }}
                                                @can('create item')
                                                <a href="{{ route('items.create') }}" class="alert-link ms-1">
                                                    {{ __('Create your first item') }}
                                                </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .table-image {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
    }
    
    .no-image {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 50%;
        color: #6c757d;
    }
    
    /* Stock status colors */
    .stock-low {
        background-color: #fff3cd !important;
        color: #856404 !important;
        border-color: #ffeaa7;
    }
    
    .stock-out {
        background-color: #f8d7da !important;
        color: #721c24 !important;
        border-color: #f5c6cb;
    }
    
    .stock-good {
        background-color: #d4edda !important;
        color: #155724 !important;
        border-color: #c3e6cb;
    }
</style>
@endpush

@push('scripts')
    <x-export-scripts 
        tableId="itemTable"
        searchPlaceholder="Search items..."
        pdfTitle="Items"
    />
    
    <script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        // Filter functionality
        $('#apply-filters').on('click', function() {
            const companyFilter = $('#company-filter').val();
            const categoryFilter = $('#category-filter').val();
            
            if (window.dataTables && window.dataTables['itemTable']) {
                const table = window.dataTables['itemTable'];
                
                // Clear all filters
                table.columns().search('');
                table.search('');
                
                // Apply filters
                if (companyFilter) {
                    table.search(companyFilter).draw();
                }
                
                if (categoryFilter) {
                    table.column(6).search(categoryFilter).draw(); // Category column index
                }
                
                if (!companyFilter && !categoryFilter) {
                    table.search('').columns().search('').draw();
                }
            } else {
                // Fallback: filter by hiding rows
                $('table#itemTable tbody tr').each(function() {
                    const $row = $(this);
                    let showRow = true;
                    
                    // Company filter (assuming company ID is in a data attribute)
                    if (companyFilter) {
                        const companyId = $row.find('td:nth-child(1)').data('company-id');
                        if (companyId != companyFilter) {
                            showRow = false;
                        }
                    }
                    
                    // Category filter
                    if (categoryFilter) {
                        const category = $row.find('td:nth-child(7)').text().trim();
                        if (category !== categoryFilter) {
                            showRow = false;
                        }
                    }
                    
                    if (showRow) {
                        $row.show();
                    } else {
                        $row.hide();
                    }
                });
            }
        });
        
        $('#reset-filters').on('click', function() {
            $('#company-filter').val('');
            $('#category-filter').val('');
            
            if (window.dataTables && window.dataTables['itemTable']) {
                const table = window.dataTables['itemTable'];
                table.search('').columns().search('').draw();
            } else {
                $('table#itemTable tbody tr').show();
            }
        });
        
        // Delete confirmation
        $(document).on('click', '.bs-pass-para', function(e) {
            e.preventDefault();
            
            const formId = $(this).data('confirm-yes');
            const confirmText = $(this).data('text');
            const confirmMessage = $(this).data('confirm');
            
            if (confirm(confirmMessage + '\n\n' + confirmText)) {
                document.getElementById(formId).submit();
            }
        });
    });
    </script>
@endpush