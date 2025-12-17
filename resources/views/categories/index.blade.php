@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Categories') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Categories') }}</li>
@endsection

@section('action-btn')
    {{-- Use the export buttons component --}}
    <x-export-buttons 
        tableId="categoriesTable"
        :createButton="true"
        createRoute="{{ route('categories.create') }}"
        createPermission="item_category_add"
        createLabel="New Category"
        createIcon="ti-plus"
        createTooltip="Create New Category"
        :columns="[
            ['index' => 0, 'name' => 'S.No', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Name', 'description' => 'Category name'],
            ['index' => 2, 'name' => 'Description', 'description' => 'Category description'],
            ['index' => 3, 'name' => 'Items', 'description' => 'Number of items in category'],
            ['index' => 4, 'name' => 'Status', 'description' => 'Active/Inactive status'],
            ['index' => 5, 'name' => 'Created At', 'description' => 'Creation date'],
            ['index' => 6, 'name' => 'Actions', 'description' => 'View/Edit/Delete actions']
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
                        <div class="col-md-6">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">
                                    <i class="ti ti-search"></i>
                                </span>
                                <input type="text" class="form-control" id="search-input" 
                                       placeholder="{{ __('Search categories...') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select form-select-sm" id="status-filter">
                                <option value="">{{ __('All Status') }}</option>
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Inactive') }}</option>
                            </select>
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-sm btn-light" id="clear-filters">
                                <i class="ti ti-refresh me-1"></i> {{ __('Clear') }}
                            </button>
                        </div>
                    </div> -->
                    
                    <div class="table-responsive">
                        <table class="table w-100" id="categoriesTable">
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
                                @forelse($categories as $index => $category)
                                    <tr data-category-id="{{ $category->id }}" data-status="{{ $category->status }}">
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="category-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                         style="width: 36px; height: 36px;">
                                                        <i class="ti ti-category"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <strong>{{ $category->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $category->slug }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($category->description)
                                                <span class="text-truncate d-inline-block" style="max-width: 200px;"
                                                      data-bs-toggle="tooltip" title="{{ $category->description }}">
                                                    {{ Str::limit($category->description, 50) }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $category->item_count ?? 0 }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $category->status ? 'success' : 'danger' }}">
                                                {{ $category->status ? __('Active') : __('Inactive') }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $category->created_at->format('d M Y') }}
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                @can('item_category_view')
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="{{ route('categories.show', $category->id) }}" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="{{ __('View') }}">
                                                        <i class="ti ti-eye text-dark"></i>
                                                    </a>
                                                </div>
                                                @endcan
                                                
                                                @can('item_category_edit')
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="{{ route('categories.edit', $category->id) }}" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil text-dark"></i>
                                                    </a>
                                                </div>
                                                @endcan
                                                
                                                @can('item_category_delete')
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <button type="button" 
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center delete-category-btn" 
                                                            data-id="{{ $category->id }}"
                                                            data-name="{{ $category->name }}"
                                                            data-bs-toggle="tooltip" 
                                                            title="{{ __('Delete') }}">
                                                        <i class="ti ti-trash text-danger"></i>
                                                    </button>
                                                </div>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="alert alert-info d-inline-flex align-items-center">
                                                <i class="ti ti-category-off me-2"></i>
                                                {{ __('No categories found.') }}
                                                @can('item_category_add')
                                                <a href="{{ route('categories.create') }}" class="alert-link ms-1">
                                                    {{ __('Create your first category') }}
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryModalLabel">{{ __('Delete Category') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="delete-message"></p>
                    <div class="alert alert-warning mt-3">
                        <i class="ti ti-alert-triangle me-2"></i>
                        {{ __('This action cannot be undone. All items in this category will remain but will show "N/A" for category.') }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <form id="delete-category-form" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('Delete Category') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .category-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 16px;
    }
    
    .category-icon.bg-primary {
        background-color: #0d6efd !important;
    }
    
    .category-icon.bg-success {
        background-color: #198754 !important;
    }
    
    .category-icon.bg-danger {
        background-color: #dc3545 !important;
    }
</style>
@endpush

@push('scripts')
    <x-export-scripts 
        tableId="categoriesTable"
        searchPlaceholder="Search categories..."
        pdfTitle="Categories"
    />
    
    <script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        // Delete button click handler
        $(document).on('click', '.delete-category-btn', function(e) {
            e.preventDefault();
            
            const categoryId = $(this).data('id');
            const categoryName = $(this).data('name');
            
            // Set modal message
            $('#delete-message').html('{{ __("Are you sure you want to delete") }} <strong>"' + categoryName + '"</strong>?');
            
            // Set form action
            $('#delete-category-form').attr('action', '{{ url("categories") }}/' + categoryId);
            
            // Show modal
            $('#deleteCategoryModal').modal('show');
        });

        // Delete form submission
        $('#delete-category-form').on('submit', function(e) {
            $('#deleteCategoryModal').modal('hide');
            // Let the form submit normally
        });
        
        // Clear filters
        $('#clear-filters').on('click', function() {
            $('#search-input').val('');
            $('#status-filter').val('');
            
            if (window.dataTables && window.dataTables['categoriesTable']) {
                const table = window.dataTables['categoriesTable'];
                table.search('').columns().search('').draw();
            }
        });
        
        // Real-time search
        let searchTimer;
        $('#search-input').on('keyup', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                if (window.dataTables && window.dataTables['categoriesTable']) {
                    const table = window.dataTables['categoriesTable'];
                    table.search($(this).val()).draw();
                }
            }, 300);
        });
        
        // Status filter
        $('#status-filter').on('change', function() {
            const status = $(this).val();
            
            if (window.dataTables && window.dataTables['categoriesTable']) {
                const table = window.dataTables['categoriesTable'];
                if (status) {
                    table.column(4).search(status).draw(); // Status column index
                } else {
                    table.column(4).search('').draw();
                }
            }
        });
    });
    </script>
@endpush