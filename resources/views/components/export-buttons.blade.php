{{-- resources/views/components/export-buttons.blade.php --}}
@props([
    'tableId' => 'defaultTable',
    'exportButtons' => true,
    'columnToggle' => true,
    'columns' => [],
    'createButton' => false,
    'createRoute' => null,
    'createPermission' => null,
    'createLabel' => 'Create New',
    'createIcon' => 'ti-plus',
    'createTooltip' => 'Create New',
    'position' => 'float-end',
    'buttonClass' => 'btn-sm btn-primary',
    'includePdf' => true,
    'pdfOrientation' => 'portrait', // portrait or landscape
    'pdfPageSize' => 'A4' // A4, A3, Letter, Legal, etc.
])

@php
    // Default columns if not provided
    $defaultColumns = [
        ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
        ['index' => 1, 'name' => 'Name', 'description' => 'Name'],
        ['index' => 2, 'name' => 'Email', 'description' => 'Email address'],
        ['index' => 3, 'name' => 'Mobile', 'description' => 'Mobile number'],
        ['index' => 4, 'name' => 'Details', 'description' => 'Details'],
        ['index' => 5, 'name' => 'Status', 'description' => 'Status'],
        ['index' => 6, 'name' => 'Actions', 'description' => 'View/Edit/Delete actions']
    ];
    
    $columns = !empty($columns) ? $columns : $defaultColumns;
@endphp

<div class="{{ $position }}">
    <div class="d-flex flex-wrap gap-2 justify-content-end align-items-center">
        @if($exportButtons)
            {{-- Copy Button --}}
            <button type="button" 
                    class="btn {{ $buttonClass }} btn-export" 
                    data-table-id="{{ $tableId }}"
                    data-export="copy"
                    data-bs-toggle="tooltip" 
                    title="{{__('Copy to Clipboard')}}">
                <!-- <i class="ti ti-copy"></i> -->
                 <span class="d-none d-md-inline">{{ __('Copy') }}</span>
            </button>
            
            {{-- CSV Export Button --}}
            <button type="button" 
                    class="btn {{ $buttonClass }} btn-export" 
                    data-table-id="{{ $tableId }}"
                    data-export="csv"
                    data-bs-toggle="tooltip" 
                    title="{{__('Export as CSV')}}">
                <!-- <i class="ti ti-file-text"></i> -->
                 <span class="d-none d-md-inline">{{ __('CSV') }}</span>
            </button>
            
            {{-- Excel Export Button --}}
            <button type="button" 
                    class="btn {{ $buttonClass }} btn-export" 
                    data-table-id="{{ $tableId }}"
                    data-export="excel"
                    data-bs-toggle="tooltip" 
                    title="{{__('Export as Excel')}}">
                <!-- <i class="ti ti-file-excel"></i>  -->
                <span class="d-none d-md-inline">{{ __('Excel') }}</span>
            </button>
            
            {{-- PDF Export Button --}}
            @if($includePdf)
            <button type="button" 
                    class="btn {{ $buttonClass }} btn-export" 
                    data-table-id="{{ $tableId }}"
                    data-export="pdf"
                    data-orientation="{{ $pdfOrientation }}"
                    data-page-size="{{ $pdfPageSize }}"
                    data-bs-toggle="tooltip" 
                    title="{{__('Export as PDF')}}">
                <!-- <i class="ti ti-file-pdf"></i>  -->
                <span class="d-none d-md-inline">{{ __('PDF') }}</span>
            </button>
            @endif
            
            {{-- Print Button --}}
            <button type="button" 
                    class="btn {{ $buttonClass }} btn-export" 
                    data-table-id="{{ $tableId }}"
                    data-export="print"
                    data-bs-toggle="tooltip" 
                    title="{{__('Print')}}">
                <!-- <i class="ti ti-printer"></i>  -->
                <span class="d-none d-md-inline">{{ __('Print') }}</span>
            </button>
        @endif
        
        @if($columnToggle)
            {{-- Columns Toggle Dropdown --}}
            <div class="dropdown column-toggle-dropdown">
                <button class="btn {{ $buttonClass }} btn-export dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" title="{{__('Show/Hide Columns')}}">
                    <i class="ti ti-columns"></i> <span class="d-none d-md-inline">{{ __('Columns') }}</span>
                </button>
                <ul class="dropdown-menu p-2">
                    <li><h6 class="dropdown-header">{{ __('Toggle Columns') }}</h6></li>
                    @foreach($columns as $column)
                        <li>
                            <div class="form-check dropdown-item column-toggle-item" 
                                 data-column="{{ $column['index'] }}" 
                                 data-table-id="{{ $tableId }}">
                                <input class="form-check-input column-checkbox" 
                                       type="checkbox" 
                                       data-column="{{ $column['index'] }}" 
                                       data-table-id="{{ $tableId }}"
                                       id="col-{{ $tableId }}-{{ $column['index'] }}" 
                                       checked>
                                <label class="form-check-label w-100" for="col-{{ $tableId }}-{{ $column['index'] }}">
                                    {{ $column['name'] }}
                                    @if(isset($column['description']))
                                        <small class="text-muted d-block">{{ $column['description'] }}</small>
                                    @endif
                                </label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if($createButton && $createRoute)
            @if($createPermission)
                @can($createPermission)
                    <div class="ms-md-2">
                        <a href="{{ $createRoute }}" 
                           data-bs-toggle="tooltip" title="{{__($createTooltip)}}" 
                           class="btn btn-sm btn-primary">
                            <i class="ti {{ $createIcon }}"></i> <span class="d-none d-md-inline">{{ __($createLabel) }}</span>
                        </a>
                    </div>
                @endcan
            @else
                <div class="ms-md-2">
                    <a href="{{ $createRoute }}" 
                       data-bs-toggle="tooltip" title="{{__($createTooltip)}}" 
                       class="btn btn-sm btn-primary">
                        <i class="ti {{ $createIcon }}"></i> <span class="d-none d-md-inline">{{ __($createLabel) }}</span>
                    </a>
                </div>
            @endif
        @endif
    </div>
</div>