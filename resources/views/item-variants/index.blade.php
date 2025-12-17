@extends('layouts.admin')

@section('page-title')
    {{ __('Item Variants') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Item Variants') }}</li>
@endsection

@section('action-btn')
    {{-- Use the export buttons component --}}
    <x-export-buttons 
        tableId="variantsTable"
        :createButton="true"
        createRoute="{{ route('item-variants.create') }}"
        createPermission="variant_add"
        createLabel="Add Variant"
        createIcon="ti-plus"
        createTooltip="Add New Variant"
        :columns="[
            ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Name', 'description' => 'Variant name'],
            ['index' => 2, 'name' => 'Description', 'description' => 'Variant description'],
            ['index' => 3, 'name' => 'Created At', 'description' => 'Creation date'],
            ['index' => 4, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
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
                        <div class="col-md-8">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">
                                    <i class="ti ti-search"></i>
                                </span>
                                <input type="text" class="form-control" id="search-input" 
                                       placeholder="{{ __('Search variants...') }}">
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-sm btn-light" id="clear-filters">
                                <i class="ti ti-refresh me-1"></i> {{ __('Clear') }}
                            </button>
                        </div>
                    </div> -->
                    
                    <div class="table-responsive">
                        <table class="table w-100" id="variantsTable">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center">{{ __('#') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    <th width="120" class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($variants as $key => $variant)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>
                                            <strong>{{ $variant->name }}</strong>
                                        </td>
                                        <td>
                                            @if($variant->description)
                                                <span class="text-truncate d-inline-block" style="max-width: 300px;"
                                                      data-bs-toggle="tooltip" title="{{ $variant->description }}">
                                                    {{ Str::limit($variant->description, 100) }}
                                                </span>
                                            @else
                                                <span class="text-muted">{{ __('No description') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $variant->created_at->format('d-m-Y H:i') }}
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                @can('variant_edit')
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="{{ route('item-variants.edit', $variant->id) }}" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil text-dark"></i>
                                                    </a>
                                                </div>
                                                @endcan
                                                
                                                @can('variant_delete')
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['item-variants.destroy', $variant->id], 'id' => 'delete-form-' . $variant->id, 'class' => 'd-inline']) !!}
                                                    <a href="#!" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" 
                                                       data-bs-toggle="tooltip" 
                                                       title="{{ __('Delete') }}" 
                                                       data-confirm="{{ __('Are You Sure?') }}" 
                                                       data-text="{{ __('This action will permanently delete the variant. Do you want to continue?') }}" 
                                                       data-confirm-yes="delete-form-{{ $variant->id }}">
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
                                        <td colspan="5" class="text-center">
                                            <div class="alert alert-info d-inline-flex align-items-center">
                                                <i class="ti ti-package-off me-2"></i>
                                                {{ __('No variants found.') }}
                                                @can('variant_add')
                                                <a href="{{ route('item-variants.create') }}" class="alert-link ms-1">
                                                    {{ __('Create your first variant') }}
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
        tableId="variantsTable"
        searchPlaceholder="Search variants..."
        pdfTitle="Item Variants"
    />
    
    <script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        // Clear filters
        $('#clear-filters').on('click', function() {
            $('#search-input').val('');
            
            if (window.dataTables && window.dataTables['variantsTable']) {
                const table = window.dataTables['variantsTable'];
                table.search('').draw();
            }
        });
        
        // Real-time search
        let searchTimer;
        $('#search-input').on('keyup', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                if (window.dataTables && window.dataTables['variantsTable']) {
                    const table = window.dataTables['variantsTable'];
                    table.search($(this).val()).draw();
                }
            }, 300);
        });
    });
    </script>
@endpush