@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Brands') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Brands') }}</li>
@endsection

@section('action-btn')
    {{-- Use the export buttons component --}}
    <x-export-buttons 
        tableId="brandsTable"
        :createButton="true"
        createRoute="{{ route('brands.create') }}"
        createPermission="brand_add"
        createLabel="New Brand"
        createIcon="ti-plus"
        createTooltip="Create New Brand"
        :columns="[
            ['index' => 0, 'name' => 'S.No', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Name', 'description' => 'Brand name'],
            ['index' => 2, 'name' => 'Description', 'description' => 'Brand description'],
            ['index' => 3, 'name' => 'Items', 'description' => 'Number of items in brand'],
            ['index' => 4, 'name' => 'Status', 'description' => 'Active/Inactive status'],
            ['index' => 5, 'name' => 'Created At', 'description' => 'Creation date'],
            ['index' => 6, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
        ]"
        :customButtons="[
            [
                'label' => 'Export',
                'icon' => 'ti-download',
                'route' => route('brands.export'),
                'tooltip' => 'Export Brands',
                'class' => 'btn btn-outline-success btn-sm',
                'permission' => 'brand_view'
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
                    
                    <!-- Search and Filter Section -->
                    <!-- <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">
                                    <i class="ti ti-search"></i>
                                </span>
                                <input type="text" class="form-control" id="search-input" 
                                       placeholder="{{ __('Search brands...') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm" id="status-filter">
                                <option value="">{{ __('All Status') }}</option>
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Inactive') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm" id="sort-by">
                                <option value="name">{{ __('Sort by Name') }}</option>
                                <option value="created_at">{{ __('Sort by Date') }}</option>
                                <option value="items">{{ __('Sort by Items') }}</option>
                            </select>
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-sm btn-light" id="clear-filters">
                                <i class="ti ti-refresh me-1"></i> {{ __('Clear') }}
                            </button>
                        </div>
                    </div> -->
                    
                    <!-- Bulk Actions Section -->
                    <div class="row mb-3 d-none" id="bulk-actions-section">
                        <div class="col-12">
                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" id="select-all-checkbox">
                                    <label class="form-check-label" for="select-all-checkbox">
                                        <span id="selected-count">0</span> {{ __('selected') }}
                                    </label>
                                </div>
                                <select class="form-select form-select-sm me-2" style="width: auto;" id="bulk-action-select">
                                    <option value="">{{ __('Choose Action') }}</option>
                                    <option value="activate">{{ __('Activate') }}</option>
                                    <option value="deactivate">{{ __('Deactivate') }}</option>
                                    <option value="delete">{{ __('Delete') }}</option>
                                </select>
                                <button class="btn btn-sm btn-primary" id="apply-bulk-action">
                                    {{ __('Apply') }}
                                </button>
                                <button class="btn btn-sm btn-light ms-2" id="cancel-bulk-action">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table w-100" id="brandsTable">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center">{{ __('S.No') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Items') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    <th width="150" class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($brands as $index => $brand)
                                    <tr data-brand-id="{{ $brand->id }}" data-status="{{ $brand->status }}">
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $brand->name }}</strong>
                                        </td>
                                        <td>
                                            @if($brand->description)
                                                <span class="text-truncate d-inline-block" style="max-width: 200px;"
                                                      data-bs-toggle="tooltip" title="{{ $brand->description }}">
                                                    {{ Str::limit($brand->description, 50) }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $brand->item_count ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $brand->status ? 'success' : 'danger' }}">
                                                {{ $brand->status ? __('Active') : __('Inactive') }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $brand->created_at->format('d M Y') }}
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                
                                                @can('brand_edit')
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="{{ route('brands.edit', $brand->id) }}" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil text-dark"></i>
                                                    </a>
                                                </div>
                                                @endcan
                                                
                                                @can('brand_delete')
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['brands.destroy', $brand->id], 'id' => 'delete-form-' . $brand->id, 'class' => 'd-inline']) !!}
                                                    <a href="#!" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" 
                                                       data-bs-toggle="tooltip" 
                                                       title="{{ __('Delete') }}" 
                                                       data-confirm="{{ __('Are You Sure?') }}" 
                                                       data-text="{{ __('This action will permanently delete the brand. Do you want to continue?') }}" 
                                                       data-confirm-yes="delete-form-{{ $brand->id }}">
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
                                        <td colspan="7" class="text-center">
                                            <div class="alert alert-info d-inline-flex align-items-center">
                                                <i class="ti ti-package-off me-2"></i>
                                                {{ __('No brands found.') }}
                                                @can('brand_add')
                                                <a href="{{ route('brands.create') }}" class="alert-link ms-1">
                                                    {{ __('Create your first brand') }}
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

@push('scripts')
    <x-export-scripts 
        tableId="brandsTable"
        searchPlaceholder="Search brands..."
        pdfTitle="Brands"
    />
    
    <script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        // Bulk Actions functionality
        let selectedBrands = [];
        
        // Row selection
        $(document).on('click', '#brandsTable tbody tr', function(e) {
            // Don't trigger if clicking on action buttons or links
            if ($(e.target).closest('a, button, .action-btn, .bs-pass-para').length) {
                return;
            }
            
            const brandId = $(this).data('brand-id');
            const $row = $(this);
            
            if (brandId) {
                if ($row.hasClass('selected')) {
                    $row.removeClass('selected');
                    selectedBrands = selectedBrands.filter(id => id !== brandId);
                } else {
                    $row.addClass('selected');
                    selectedBrands.push(brandId);
                }
                
                updateBulkActionsUI();
            }
        });
        
        // Select all checkbox
        $('#select-all-checkbox').on('change', function() {
            if ($(this).is(':checked')) {
                $('#brandsTable tbody tr').each(function() {
                    const brandId = $(this).data('brand-id');
                    if (brandId && !selectedBrands.includes(brandId)) {
                        $(this).addClass('selected');
                        selectedBrands.push(brandId);
                    }
                });
            } else {
                $('#brandsTable tbody tr').each(function() {
                    $(this).removeClass('selected');
                });
                selectedBrands = [];
            }
            
            updateBulkActionsUI();
        });
        
        // Update bulk actions UI
        function updateBulkActionsUI() {
            const count = selectedBrands.length;
            $('#selected-count').text(count);
            
            if (count > 0) {
                $('#bulk-actions-section').removeClass('d-none');
            } else {
                $('#bulk-actions-section').addClass('d-none');
                $('#select-all-checkbox').prop('checked', false);
            }
        }
        
        // Cancel bulk action
        $('#cancel-bulk-action').on('click', function() {
            selectedBrands = [];
            $('#brandsTable tbody tr').removeClass('selected');
            updateBulkActionsUI();
        });
        
        // Apply bulk action
        $('#apply-bulk-action').on('click', function() {
            const action = $('#bulk-action-select').val();
            
            if (selectedBrands.length === 0) {
                alert('{{ __("Please select at least one brand") }}');
                return;
            }
            
            if (!action) {
                alert('{{ __("Please select an action") }}');
                return;
            }
            
            let confirmMessage = '';
            if (action === 'delete') {
                confirmMessage = '{{ __("Are you sure you want to delete selected brands?") }}';
            } else {
                confirmMessage = '{{ __("Are you sure you want to update status of selected brands?") }}';
            }
            
            if (confirm(confirmMessage)) {
                $.ajax({
                    url: '{{ route("brands.bulk.update") }}',
                    method: 'POST',
                    data: {
                        ids: selectedBrands,
                        action: action,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('{{ __("An error occurred. Please try again.") }}');
                    }
                });
            }
        });
        
        // Clear filters
        $('#clear-filters').on('click', function() {
            $('#search-input').val('');
            $('#status-filter').val('');
            $('#sort-by').val('name');
            
            if (window.dataTables && window.dataTables['brandsTable']) {
                const table = window.dataTables['brandsTable'];
                table.search('').columns().search('').draw();
            }
        });
        
        // Real-time search
        let searchTimer;
        $('#search-input').on('keyup', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                if (window.dataTables && window.dataTables['brandsTable']) {
                    const table = window.dataTables['brandsTable'];
                    table.search($(this).val()).draw();
                }
            }, 300);
        });
        
        // Status filter
        $('#status-filter').on('change', function() {
            const status = $(this).val();
            
            if (window.dataTables && window.dataTables['brandsTable']) {
                const table = window.dataTables['brandsTable'];
                if (status) {
                    table.column(4).search(status).draw(); // Status column index
                } else {
                    table.column(4).search('').draw();
                }
            }
        });
        
        // Sort by
        $('#sort-by').on('change', function() {
            const sortBy = $(this).val();
            
            if (window.dataTables && window.dataTables['brandsTable']) {
                const table = window.dataTables['brandsTable'];
                // Determine column index based on sort option
                let columnIndex;
                switch(sortBy) {
                    case 'name': columnIndex = 1; break;
                    case 'created_at': columnIndex = 5; break;
                    case 'items': columnIndex = 3; break;
                    default: columnIndex = 1;
                }
                
                // Get current order and toggle
                const currentOrder = table.order();
                if (currentOrder.length > 0 && currentOrder[0][0] === columnIndex) {
                    // Toggle order if same column
                    table.order([columnIndex, currentOrder[0][1] === 'asc' ? 'desc' : 'asc']).draw();
                } else {
                    // New column, default to asc
                    table.order([columnIndex, 'asc']).draw();
                }
            }
        });
        
        // Add CSS for selected rows
        $('<style>')
            .text('#brandsTable tbody tr.selected { background-color: rgba(13, 110, 253, 0.1); }')
            .appendTo('head');
    });
    </script>
@endpush