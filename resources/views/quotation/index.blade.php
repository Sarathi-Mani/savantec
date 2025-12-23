@extends('layouts.admin')

@section('page-title')
    {{__('Quotations')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Quotations')}}</li>
@endsection

@section('action-btn')
    {{-- Use the export buttons component --}}
    <x-export-buttons 
        tableId="quotationsTable"
        :createButton="true"
        createRoute="{{ route('quotation.create') }}"
        createPermission="quotation_add"
        createLabel="New Quotation"
        createIcon="ti-plus"
        createTooltip="Create New Quotation"
        :columns="[
            ['index' => 0, 'name' => 'Serial No', 'description' => 'Serial number with toggle button'],
            ['index' => 1, 'name' => 'Quotation Date', 'description' => 'Quotation creation date'],
            ['index' => 2, 'name' => 'Expiry Date', 'description' => 'Quotation expiry date'],
            ['index' => 3, 'name' => 'Quotation Code', 'description' => 'Unique quotation code'],
            ['index' => 4, 'name' => 'Reference No', 'description' => 'Reference number'],
            ['index' => 5, 'name' => 'Customer', 'description' => 'Customer name'],
            ['index' => 6, 'name' => 'Salesman', 'description' => 'Salesman name'],
            ['index' => 7, 'name' => 'Total', 'description' => 'Grand total amount'],
            ['index' => 8, 'name' => 'Status', 'description' => 'Quotation status'],
            ['index' => 9, 'name' => 'Actions', 'description' => 'View/Edit/Delete actions']
        ]"
    />
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
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
                    
                    <div class="table-responsive">
                        <table class="table table-hover" id="quotationsTable">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center">
                                        {{__('#')}}
                                    </th>
                                    <th>{{__('Quotation Date')}}</th>
                                    <th>{{__('Expiry Date')}}</th>
                                    <th>{{__('Quotation Code')}}</th>
                                    <th class="extra-column" style="display: none;">{{__('Reference No')}}</th>
                                    <th>{{__('Customer')}}</th>
                                    <th>{{__('Salesman')}}</th>
                                    <th class="text-end">{{__('Total')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th width="120" class="text-center">{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($quotations as $key => $quotation)
                                    @php
                                        // Get salesman from users table
                                        $salesman = \App\Models\User::find($quotation->salesman_id);
                                        $salesmanName = $salesman ? $salesman->name : 'N/A';
                                        $salesmanMobile = $salesman ? $salesman->mobile : '';
                                        $salesmanEmail = $salesman ? $salesman->email : '';
                                    @endphp
                                    <tr>
                                        <td class="text-center">
                                            {{ $key + 1 }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            @if($quotation->expire_date)
                                                {{ \Carbon\Carbon::parse($quotation->expire_date)->format('d-m-Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $quotation->quotation_code }}</strong>
                                        </td>
                                        <td class="extra-column" style="display: none;">
                                            @if($quotation->reference_no)
                                                <span class="badge bg-light text-dark">{{ $quotation->reference_no }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="customer-name" 
                                                 style="white-space: normal; 
                                                        word-wrap: break-word; 
                                                        max-width: 150px; 
                                                        line-height: 1.2;">
                                                {{ $quotation->customer_name }}
                                            </div>
                                            <div class="extra-details" style="display: none; font-size: 0.85rem; color: #6c757d;">
                                                @if($quotation->reference_no)
                                                    <div><strong>Ref No:</strong> {{ $quotation->reference_no }}</div>
                                                @endif
                                                @if($quotation->contact_person)
                                                    <div><strong>Contact:</strong> {{ $quotation->contact_person }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($salesman)
                                                <div class="salesman-info">
                                                    <div class="fw-semibold">{{ $salesmanName }}</div>
                                                    @if($salesmanMobile)
                                                        <div class="text-muted small mt-1">
                                                            {{ $salesmanMobile }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td class="text-end fw-bold">
                                            ₹{{ number_format($quotation->grand_total, 2) }}
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'open' => 'primary',
                                                    'closed' => 'success',
                                                    'po_converted' => 'info',
                                                    'lost' => 'danger'
                                                ];
                                                $color = $statusColors[$quotation->status] ?? 'secondary';
                                                $statusLabels = [
                                                    'open' => 'Open',
                                                    'closed' => 'Closed',
                                                    'po_converted' => 'PO Converted',
                                                    'lost' => 'Lost'
                                                ];
                                                $label = $statusLabels[$quotation->status] ?? ucfirst($quotation->status);
                                            @endphp
                                            <span class="badge bg-{{ $color }}">
                                                {{ $label }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-btn">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-icon-only" 
                                                            type="button" 
                                                            data-bs-toggle="dropdown" 
                                                            aria-haspopup="true" 
                                                            aria-expanded="false"
                                                            title="{{ __('Actions') }}">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        {{-- View --}}
                                                        @can('quotation_view')
                                                        <a class="dropdown-item" 
                                                           href="{{ route('quotation.show', $quotation->id) }}">
                                                            <i class="ti ti-eye me-2"></i>{{ __('View') }}
                                                        </a>
                                                        @endcan
                                                        
                                                        {{-- Edit --}}
                                                        @can('quotation_edit')
                                                        <a class="dropdown-item" 
                                                           href="{{ route('quotation.edit', $quotation->id) }}">
                                                            <i class="ti ti-pencil me-2"></i>{{ __('Edit') }}
                                                        </a>
                                                        @endcan
                                                        
                                                        {{-- Print --}}
                                                        @can('print quotation')
                                                        <a class="dropdown-item" 
                                                           href="{{ route('quotation.print', $quotation->id) }}"
                                                           target="_blank">
                                                            <i class="ti ti-printer me-2"></i>{{ __('Print') }}
                                                        </a>
                                                        @endcan
                                                        
                                                        {{-- PDF --}}
                                                        <a class="dropdown-item" 
                                                           href="{{ route('quotation.pdf', $quotation->id) }}"
                                                           target="_blank">
                                                            <i class="ti ti-file-type-pdf me-2"></i>{{ __('Download PDF') }}
                                                        </a>
                                                        
                                                        {{-- Convert to Invoice --}}
                                                        @can('convert quotation')
                                                        <a class="dropdown-item" 
                                                           href="{{ route('quotation.convertToInvoice', $quotation->id) }}"
                                                           onclick="return confirm('Convert to invoice?')">
                                                            <i class="ti ti-file-invoice me-2"></i>{{ __('Convert to Invoice') }}
                                                        </a>
                                                        @endcan
                                                        
                                                        {{-- Convert to Delivery Challan --}}
                                                        <a class="dropdown-item" 
                                                           href="{{ route('quotation.convertToDC', $quotation->id) }}"
                                                           onclick="return confirm('Convert to delivery challan?')">
                                                            <i class="ti ti-truck-delivery me-2"></i>{{ __('Convert to DC') }}
                                                        </a>
                                                        
                                                        <div class="dropdown-divider"></div>
                                                        
                                                        {{-- Delete --}}
                                                        @can('quotation_delete')
                                                        <form action="{{ route('quotation.destroy', $quotation->id) }}" 
                                                              method="POST" 
                                                              class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="dropdown-item text-danger"
                                                                    onclick="return confirm('Delete quotation?')">
                                                                <i class="ti ti-trash me-2"></i>{{ __('Delete') }}
                                                            </button>
                                                        </form>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <i class="ti ti-file-text ti-lg text-muted mb-2"></i>
                                                <p class="text-muted mb-0">{{ __('No quotations found.') }}</p>
                                                @can('quotation_add')
                                                <a href="{{ route('quotation.create') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class="ti ti-plus me-1"></i>{{ __('Create New Quotation') }}
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
    /* Fix table alignment */
    #quotationsTable th, 
    #quotationsTable td {
        vertical-align: middle !important;
        padding: 0.75rem !important;
    }
    
    /* Style the 3-dot menu button */
    .btn-icon-only {
        padding: 0.25rem 0.5rem !important;
        background: transparent !important;
        border: 1px solid #dee2e6 !important;
        color: #6c757d !important;
        border-radius: 4px !important;
    }
    
    .btn-icon-only:hover {
        background: #f8f9fa !important;
        border-color: #adb5bd !important;
        color: #495057 !important;
    }
    
    /* Style dropdown menu */
    .dropdown-menu {
        min-width: 200px !important;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        border: 1px solid rgba(0, 0, 0, 0.15) !important;
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem !important;
        font-size: 0.875rem !important;
    }
    
    .dropdown-item i {
        width: 18px !important;
        text-align: center !important;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa !important;
        color: #212529 !important;
    }
    
    .dropdown-divider {
        margin: 0.25rem 0 !important;
    }
    
    /* Fix table responsive */
    .table-responsive {
        overflow-x: auto;
    }
    
    /* Customer name wrapping */
    .customer-name {
        white-space: normal !important;
        word-wrap: break-word !important;
        max-width: 150px !important;
        line-height: 1.2 !important;
    }
    
    /* Salesman info styling */
    .salesman-info {
        min-width: 120px;
    }
    
    .salesman-info .small {
        font-size: 0.75rem !important;
        line-height: 1.2;
    }
    
    /* Toggle button styling */
    .toggle-row-btn, #toggleColumnsBtn {
        width: 24px !important;
        height: 24px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin-right: 4px !important;
        border: 1px solid #dee2e6 !important;
        border-radius: 4px !important;
        background: #f8f9fa !important;
        color: #6c757d !important;
        transition: all 0.2s !important;
    }
    
    .toggle-row-btn:hover, #toggleColumnsBtn:hover {
        background: #e9ecef !important;
        border-color: #adb5bd !important;
        color: #495057 !important;
    }
    
    .toggle-row-btn i, #toggleColumnsBtn i {
        font-size: 12px !important;
    }
    
    /* Fix column widths */
    #quotationsTable th:nth-child(1) { width: 60px !important; }
    #quotationsTable th:nth-child(2) { width: 110px !important; }
    #quotationsTable th:nth-child(3) { width: 110px !important; }
    #quotationsTable th:nth-child(4) { width: 140px !important; }
    #quotationsTable th:nth-child(5) { width: 120px !important; }
    #quotationsTable th:nth-child(6) { width: 150px !important; }
    #quotationsTable th:nth-child(7) { width: 180px !important; }
    #quotationsTable th:nth-child(8) { width: 100px !important; }
    #quotationsTable th:nth-child(9) { width: 100px !important; }
    #quotationsTable th:nth-child(10) { width: 120px !important; min-width: 100px !important; }
    
    /* Extra details styling */
    .extra-details {
        margin-top: 4px !important;
        padding-top: 4px !important;
        border-top: 1px dashed #dee2e6 !important;
    }
    
    .extra-details div {
        margin-bottom: 2px !important;
    }
    
    /* Active state for toggle buttons */
    .toggle-row-btn.active i,
    #toggleColumnsBtn.active i {
        transform: rotate(45deg);
        color: #0d6efd;
    }
    
    /* Mobile number icon */
    .ti-phone {
        font-size: 10px !important;
    }
</style>
@endpush

@push('scripts')
    <x-export-scripts 
        tableId="quotationsTable"
        searchPlaceholder="Search quotations..."
        pdfTitle="Quotations"
    />
    
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize dropdowns
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });
    
    // Toggle all extra columns
    const toggleColumnsBtn = document.getElementById('toggleColumnsBtn');
    let columnsVisible = false;
    
    if (toggleColumnsBtn) {
        toggleColumnsBtn.addEventListener('click', function() {
            columnsVisible = !columnsVisible;
            
            // Toggle all extra columns
            const extraColumns = document.querySelectorAll('.extra-column');
            extraColumns.forEach(col => {
                col.style.display = columnsVisible ? 'table-cell' : 'none';
            });
            
            // Toggle button icon
            const icon = this.querySelector('i');
            if (columnsVisible) {
                icon.classList.remove('ti-plus');
                icon.classList.add('ti-minus');
                this.classList.add('active');
                this.setAttribute('title', 'Hide extra columns');
            } else {
                icon.classList.remove('ti-minus');
                icon.classList.add('ti-plus');
                this.classList.remove('active');
                this.setAttribute('title', 'Show extra columns');
            }
            
            // Update tooltip
            const tooltip = bootstrap.Tooltip.getInstance(this);
            if (tooltip) {
                tooltip.update();
            }
            
            // Adjust DataTable if exists
            if ($.fn.dataTable && $('#quotationsTable').DataTable()) {
                $('#quotationsTable').DataTable().columns.adjust().draw();
            }
        });
    }
    
    // Toggle individual row details
    const toggleRowBtns = document.querySelectorAll('.toggle-row-btn');
    toggleRowBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const extraDetails = row.querySelector('.extra-details');
            
            if (extraDetails) {
                const isVisible = extraDetails.style.display !== 'none';
                
                // Toggle extra details
                extraDetails.style.display = isVisible ? 'none' : 'block';
                
                // Toggle button icon
                const icon = this.querySelector('i');
                if (isVisible) {
                    icon.classList.remove('ti-minus');
                    icon.classList.add('ti-plus');
                    this.classList.remove('active');
                    this.setAttribute('title', 'Show extra details');
                } else {
                    icon.classList.remove('ti-plus');
                    icon.classList.add('ti-minus');
                    this.classList.add('active');
                    this.setAttribute('title', 'Hide extra details');
                }
                
                // Update tooltip
                const tooltip = bootstrap.Tooltip.getInstance(this);
                if (tooltip) {
                    tooltip.update();
                }
            }
        });
    });
});
</script>
@endpush