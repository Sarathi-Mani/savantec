@php
    // Try to decode the items JSON - handle potential errors
    try {
        $items = json_decode($enquiry->items, true) ?? [];
    } catch (Exception $e) {
        $items = [];
    }
    
    // Debug: Uncomment to see what's in items
    // dd($items, $enquiry->items);
@endphp
@extends('layouts.admin')

@section('page-title')
    {{__('Enquiry Details')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('enquiry.index')}}">{{__('Enquiry')}}</a></li>
    <li class="breadcrumb-item">{{__('Details')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="{{ route('enquiry.index') }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" title="{{__('Back to List')}}">
            <i class="ti ti-arrow-left me-2"></i>Back to List
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Column 1 - Basic Information with Dates -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0">{{__('Basic Information')}}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%" class="text-muted">{{ __('Enquiry No') }}</td>
                                            <td width="60%" class="fw-bold">{{ $enquiry->serial_no }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">{{ __('Enquiry Date') }}</td>
                                            <td class="fw-bold">{{ \Carbon\Carbon::parse($enquiry->enquiry_date)->format('d-m-Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">{{ __('Company Name') }}</td>
                                            <td class="fw-bold">{{ $enquiry->company_name }}</td>
                                        </tr>
                                        
                                        @if($enquiry->kind_attn && trim($enquiry->kind_attn) != '')
                                        <tr>
                                            <td class="text-muted">{{ __('Contact Person') }}</td>
                                            <td>{{ $enquiry->kind_attn }}</td>
                                        </tr>
                                        @endif
                                        
                                        @if($enquiry->mail_id && trim($enquiry->mail_id) != '')
                                        <tr>
                                            <td class="text-muted">{{ __('Email') }}</td>
                                            <td>
                                                <a href="mailto:{{ $enquiry->mail_id }}" class="text-primary">
                                                    {{ $enquiry->mail_id }}
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        
                                        @if($enquiry->phone_no && trim($enquiry->phone_no) != '')
                                        <tr>
                                            <td class="text-muted">{{ __('Phone') }}</td>
                                            <td>{{ $enquiry->phone_no }}</td>
                                        </tr>
                                        @endif
                                        
                                        @if($enquiry->pending_remarks && trim($enquiry->pending_remarks) != '')
                                        <tr>
                                            <td class="text-muted">{{ __('Pending Remarks') }}</td>
                                            <td>{{ $enquiry->pending_remarks }}</td>
                                        </tr>
                                        @endif
                                        
                                        @if($enquiry->createdBy && $enquiry->createdBy->name && trim($enquiry->createdBy->name) != '')
                                        <tr>
                                            <td class="text-muted">{{ __('Created By') }}</td>
                                            <td>{{ $enquiry->createdBy->name }}</td>
                                        </tr>
                                        @endif
                                        
                                        <tr>
                                            <td class="text-muted">{{ __('Created At') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($enquiry->created_at)->format('d-m-Y H:i:s') }}</td>
                                        </tr>
                                        
                                        @if($enquiry->assigned_date_time)
                                        <tr>
                                            <td class="text-muted">{{ __('Assigned Date & Time') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($enquiry->assigned_date_time)->format('d-m-Y H:i:s') }}</td>
                                        </tr>
                                        @endif
                                        
                                        @if($enquiry->quotation_date_time)
                                        <tr>
                                            <td class="text-muted">{{ __('Quotation Date & Time') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($enquiry->quotation_date_time)->format('d-m-Y H:i:s') }}</td>
                                        </tr>
                                        @endif
                                        
                                        @if($enquiry->purchase_date_time)
                                        <tr>
                                            <td class="text-muted">{{ __('Purchase Date & Time') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($enquiry->purchase_date_time)->format('d-m-Y H:i:s') }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Column 2 - Status Information with Remarks below -->
                        <div class="col-md-6">
                            <!-- Status Information Card -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">{{__('Status Information')}}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%" class="text-muted">{{ __('Status') }}</td>
                                            <td width="60%">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'assigned' => 'info',
                                                        'quoted' => 'primary',
                                                        'purchased' => 'success',
                                                        'cancelled' => 'danger',
                                                        'completed' => 'success',
                                                        'ignored' => 'secondary',
                                                        'ready_for_purchase' => 'info',
                                                        'ready_for_quotation' => 'primary'
                                                    ];
                                                    $statusLabels = [
                                                        'pending' => 'Pending',
                                                        'assigned' => 'Assigned',
                                                        'quoted' => 'Quoted',
                                                        'purchased' => 'Purchased',
                                                        'cancelled' => 'Cancelled',
                                                        'completed' => 'Completed',
                                                        'ignored' => 'Ignored',
                                                        'ready_for_purchase' => 'Ready for Purchase',
                                                        'ready_for_quotation' => 'Ready for Quotation'
                                                    ];
                                                    $color = $statusColors[$enquiry->status] ?? 'secondary';
                                                    $label = $statusLabels[$enquiry->status] ?? strtoupper($enquiry->status);
                                                @endphp
                                                <span class="badge bg-{{ $color }} rounded-pill px-3 py-1">
                                                    {{ $label }}
                                                </span>
                                            </td>
                                        </tr>
                                        
                                        @if($enquiry->salesman)
                                        <tr>
                                            <td class="text-muted">{{ __('Sales Engineer') }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2">
                                                        <span class="badge rounded-pill bg-primary px-3 py-1">
                                                            {{ $enquiry->salesman->name }}
                                                        </span>
                                                    </div>
                                                    @if($enquiry->salesman->phone && trim($enquiry->salesman->phone) != '')
                                                    <small class="text-muted">{{ $enquiry->salesman->phone }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        
                                        @if($enquiry->qty)
                                        <tr>
                                            <td class="text-muted">{{ __('Total Quantity') }}</td>
                                            <td>
                                                <span class="badge rounded-pill bg-light text-dark px-3 py-1">
                                                    {{ $enquiry->qty }} units
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                        
                                        @if(count($items) > 0)
                                        <tr>
                                            <td class="text-muted">{{ __('Total Items') }}</td>
                                            <td>
                                                <span class="badge rounded-pill bg-light text-dark px-3 py-1">
                                                    {{ count($items) }} items
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            <!-- Remarks Card (Below Status Information) -->
                            @if($enquiry->remarks && trim($enquiry->remarks) != '')
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">{{__('Remarks')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="bg-light p-3 rounded">
                                        <p class="mb-0">{{ $enquiry->remarks }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Items Section - Only show if there are items -->
                    @if(count($items) > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">{{__('Items')}}</h5>
                                    <span class="badge rounded-pill bg-primary">
                                        {{ count($items) }} items
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="35%">{{ __('Description') }}</th>
                                                    <th width="10%">{{ __('Quantity') }}</th>
                                                    <th width="15%">{{ __('Suitable Item') }}</th>
                                                    <th width="15%">{{ __('Purchase Price') }}</th>
                                                    <th width="15%">{{ __('Sales Price') }}</th>
                                                    <th width="5%">{{ __('Image') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $totalPurchase = 0;
                                                    $totalSales = 0;
                                                    $totalQty = 0;
                                                @endphp
                                                
                                                @foreach($items as $index => $item)
                                                @php
                                                    $hasDescription = isset($item['description']) && trim($item['description']) != '';
                                                    $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 1;
                                                    $suitableItem = isset($item['suitable_item']) ? $item['suitable_item'] : 'N/A';
                                                    $purchasePrice = isset($item['purchase_price']) ? (float)$item['purchase_price'] : 0;
                                                    $salesPrice = isset($item['sales_price']) ? (float)$item['sales_price'] : 0;
                                                    $hasImage = isset($item['image']) && $item['image'] && trim($item['image']) != '';
                                                    
                                                    // Calculate totals
                                                    $totalPurchase += $purchasePrice * $quantity;
                                                    $totalSales += $salesPrice * $quantity;
                                                    $totalQty += $quantity;
                                                @endphp
                                                
                                                @if($hasDescription)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>
                                                        <div class="fw-medium">{{ $item['description'] }}</div>
                                                    </td>
                                                    <td>
                                                        <span class="badge rounded-pill bg-light text-dark px-3 py-1">
                                                            {{ $quantity }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $suitableItem }}</td>
                                                    <td>₹{{ number_format($purchasePrice, 2) }}</td>
                                                    <td>₹{{ number_format($salesPrice, 2) }}</td>
                                                 <td>
    @if($hasImage)
        @php
            // Check different possible image paths
            $imagePaths = [
                public_path('storage/enquiry_items/' . $item['image']),
                public_path('storage/' . $item['image']),
                public_path('enquiry_items/' . $item['image']),
            ];
            
            $imageFound = false;
            $imageUrl = '';
            
            foreach ($imagePaths as $path) {
                if (file_exists($path)) {
                    $imageFound = true;
                    $imageUrl = asset('storage/enquiry_items/' . $item['image']);
                    break;
                }
            }
        @endphp
        
        @if($imageFound)
            <a href="{{ $imageUrl }}" target="_blank" class="text-primary" data-bs-toggle="tooltip" title="View Image">
                <i class="ti ti-photo me-1"></i> View
            </a>
        @else
            <span class="text-muted" data-bs-toggle="tooltip" title="Image file not found">N/A</span>
        @endif
    @else
        <span class="text-muted">N/A</span>
    @endif
</td>
                                                </tr>
                                                @endif
                                                @endforeach
                                                
                                                <!-- Totals Row -->
                                                @if(count($items) > 1)
                                                <tr class="table-active">
                                                    <td colspan="2" class="text-end fw-bold">Totals:</td>
                                                    <td class="fw-bold">{{ $totalQty }}</td>
                                                    <td></td>
                                                    <td class="fw-bold">₹{{ number_format($totalPurchase, 2) }}</td>
                                                    <td class="fw-bold">₹{{ number_format($totalSales, 2) }}</td>
                                                    <td></td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!-- Notes about images -->
                                    @php
                                        $hasAnyImage = false;
                                        foreach ($items as $item) {
                                            if (isset($item['image']) && $item['image'] && trim($item['image']) != '') {
                                                $hasAnyImage = true;
                                                break;
                                            }
                                        }
                                    @endphp
                                    
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <i class="ti ti-alert-triangle me-2"></i>
                                No items found or items data is incomplete.
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: none;
        margin-bottom: 1rem;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
        padding: 1rem 1.25rem;
    }
    .card-header h5 {
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    .table-borderless td {
        padding: 0.5rem 0;
        vertical-align: middle;
        border: none;
    }
    .badge {
        font-weight: 500;
        font-size: 0.85em;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
    .text-muted {
        color: #6c757d !important;
    }
    .fw-bold {
        color: #333;
        font-weight: 600;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    .h-100 {
        height: 100%;
    }
    a.text-primary:hover {
        text-decoration: underline;
    }
    .table-active {
        background-color: rgba(0,0,0,.05);
    }
    .alert {
        border-radius: 8px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Image preview modal
        $(document).on('click', '.image-preview-link', function(e) {
            e.preventDefault();
            var imageUrl = $(this).attr('href');
            var imageTitle = $(this).data('title') || 'Item Image';
            
            // Create modal HTML
            var modalHtml = `
                <div class="modal fade" id="imagePreviewModal" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${imageTitle}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="${imageUrl}" class="img-fluid" alt="${imageTitle}" style="max-height: 70vh;">
                            </div>
                            <div class="modal-footer">
                                <a href="${imageUrl}" download class="btn btn-primary">
                                    <i class="ti ti-download me-1"></i> Download
                                </a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing modal if any
            $('#imagePreviewModal').remove();
            
            // Add modal to body and show it
            $('body').append(modalHtml);
            var modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
            modal.show();
        });
    });
</script>
@endpush