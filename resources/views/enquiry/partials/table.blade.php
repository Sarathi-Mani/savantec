<!-- resources/views/enquiry/partials/table.blade.php -->
<div class="table-responsive">
    <table class="table table-bordered table-hover mb-0" id="enquiryDataTable">
        <thead class="table-light">
            <tr>
                <th width="60">{{ __('S.No') }}</th>
                <th>{{ __('Enquiry No') }}</th>
                <th>{{ __('Enquiry Date') }}</th>
                <th>{{ __('Company Name') }}</th>
                <th>{{ __('Salesman') }}</th>
                <th>{{ __('Status') }}</th>
                <th class="no-export">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($enquiries as $index => $enquiry)
                <!-- MAIN ROW - This will be processed by DataTables -->
                <tr>
                    <td class="text-center">{{ $enquiries->firstItem() + $index }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-primary me-2 toggle-details" 
                                    data-bs-toggle="collapse"  
                                    data-bs-target="#details-{{ $enquiry->id }}"
                                    aria-expanded="false"
                                    aria-controls="details-{{ $enquiry->id }}"
                                    data-bs-toggle="tooltip" 
                                    title="{{ __('Show/Hide Details') }}">
                                <i class="ti ti-plus"></i>
                            </button>
                            <div>
                                <strong>{{ $enquiry->serial_no }}</strong>
                                @if($enquiry->kind_attn)
                                    <br><small class="text-muted">Attn: {{ $enquiry->kind_attn }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($enquiry->enquiry_date)->format('d-m-Y') }}</td>
                    <td>
                        <div class="fw-medium">{{ $enquiry->company_name }}</div>
                        @if($enquiry->mail_id)
                            <small class="text-muted d-block">{{ $enquiry->mail_id }}</small>
                        @endif
                        @if($enquiry->phone_no)
                            <small class="text-muted">{{ $enquiry->phone_no }}</small>
                        @endif
                    </td>
                    <td>
                        @if($enquiry->salesman)
                            <div class="fw-medium">{{ $enquiry->salesman->name }}</div>
                            @if($enquiry->salesman->phone)
                                <small class="text-muted">{{ $enquiry->salesman->phone }}</small>
                            @endif
                        @else
                            <span class="text-muted">{{ __('Not Assigned') }}</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $statusColors = [
                                'pending' => 'warning',
                                'assigned' => 'info',
                                'quoted' => 'primary',
                                'purchased' => 'success',
                                'cancelled' => 'danger',
                                'completed' => 'success',
                                'ignored' => 'secondary'
                            ];
                            $color = $statusColors[$enquiry->status] ?? 'secondary';
                            
                            $statusText = ucfirst($enquiry->status);
                            if($enquiry->status == 'completed' && $enquiry->question_no) {
                                $statusText = 'Completed Question No: ' . $enquiry->question_no;
                            }
                        @endphp
                        <span class="badge bg-{{ $color }}">
                            {{ $statusText }}
                        </span>
                    </td>
                    <td class="no-export">
                        @if($enquiry->status == 'completed')
                            @can('enquiry_view')
                            <a href="{{ route('enquiry.show', $enquiry->id) }}" class="btn btn-sm btn-success w-100 mb-1">
                                <i class="ti ti-eye"></i> {{ __('View') }}
                            </a>
                            @endcan
                        @else
                            <!-- Not Completed: Assign button -->
                            @can('enquiry_edit')
                                <a class="btn btn-sm btn-primary w-100 mb-1" href="{{ route('enquiry.edit', $enquiry->id) }}">
                                    <i class="ti ti-person me-2"></i>{{ __('Assign') }}
                                </a>
                            @else
                                @can('enquiry_view')
                                <a href="{{ route('enquiry.show', $enquiry->id) }}" class="btn btn-sm btn-info w-100 mb-1">
                                    <i class="ti ti-eye"></i> {{ __('View') }}
                                </a>
                                @endcan
                            @endcan
                        @endif
                    </td>
                </tr>
                
                <!-- HIDDEN DETAIL ROW - MUST be placed OUTSIDE the tbody or use different approach -->
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4">{{ __('No enquiries found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- HIDDEN DETAILS CONTAINER - Place OUTSIDE the DataTable -->
@foreach($enquiries as $enquiry)
    <div class="collapse" id="details-{{ $enquiry->id }}" style="margin-top: -1px;">
        <div class="card border-0 m-0">
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <small class="text-muted d-block">{{ __('Assigned Date & Time') }}</small>
                            <strong>
                                @if($enquiry->assigned_date_time)
                                    {{ \Carbon\Carbon::parse($enquiry->assigned_date_time)->format('d-m-Y H:i:s') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </strong>
                        </div>
                    </div>
                    <div class="col-md-6">   
                        <div class="mb-2">
                            <small class="text-muted d-block">{{ __('Purchase Date & Time') }}</small>
                            <strong>
                                @if($enquiry->purchase_date_time)
                                    {{ \Carbon\Carbon::parse($enquiry->purchase_date_time)->format('d-m-Y H:i:s') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <small class="text-muted d-block">{{ __('Quotation Date & Time') }}</small>
                            <strong>
                                @if($enquiry->quotation_date_time)
                                    {{ \Carbon\Carbon::parse($enquiry->quotation_date_time)->format('d-m-Y H:i:s') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </strong>
                        </div>
                    </div>
                   
                    @if($enquiry->remarks)
                    <div class="col-md-12 mt-2">
                        <div class="mb-0">
                            <small class="text-muted d-block">{{ __('Remarks') }}</small>
                                {{ $enquiry->remarks }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Alternative: Custom Pagination with Page Numbers -->
@if($enquiries->hasPages())
    <div class="mt-3 pt-3 border-top">
        <div class="d-flex justify-content-end">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm">
                    {{-- Previous --}}
                    <li class="page-item {{ $enquiries->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $enquiries->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    
                    {{-- Page Numbers --}}
                    @for ($i = 1; $i <= $enquiries->lastPage(); $i++)
                        <li class="page-item {{ $i == $enquiries->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $enquiries->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    
                    {{-- Next --}}
                    <li class="page-item {{ !$enquiries->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $enquiries->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endif