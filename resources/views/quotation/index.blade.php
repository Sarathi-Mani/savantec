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
        createPermission="create quotation"
        createLabel="New Quotation"
        createIcon="ti-plus"
        createTooltip="Create New Quotation"
        :columns="[
            ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Quotation Date', 'description' => 'Date when quotation was created'],
            ['index' => 2, 'name' => 'Expiry Date', 'description' => 'Quotation expiry date'],
            ['index' => 3, 'name' => 'Quotation Code', 'description' => 'Unique quotation code'],
            ['index' => 4, 'name' => 'Reference No', 'description' => 'Reference number'],
            ['index' => 5, 'name' => 'Customer', 'description' => 'Customer name'],
            ['index' => 6, 'name' => 'Salesman', 'description' => 'Salesperson name'],
            ['index' => 7, 'name' => 'Total', 'description' => 'Total amount'],
            ['index' => 8, 'name' => 'Status', 'description' => 'Quotation status'],
            ['index' => 9, 'name' => 'Actions', 'description' => 'View/Edit/Print/Convert/Delete actions']
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
                    
                    <div class="table-responsive">
                        <table class="table w-100" id="quotationsTable">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center">{{__('#')}}</th>
                                    <th>{{__('Quotation Date')}}</th>
                                    <th>{{__('Expiry Date')}}</th>
                                    <th>{{__('Quotation Code')}}</th>
                                    <th>{{__('Reference No')}}</th>
                                    <th>{{__('Customer')}}</th>
                                    <th>{{__('Salesman')}}</th>
                                    <th class="text-end">{{__('Total')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th width="250" class="text-center">{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($quotations as $key => $quotation)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
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
                                        <td>
                                            @if($quotation->reference_no)
                                                {{ $quotation->reference_no }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $quotation->customer_name }}
                                        </td>
                                        <td>
                                            @php
                                                $salesman = \App\Models\User::find($quotation->salesman_id);
                                            @endphp
                                            {{ $salesman->name ?? 'N/A' }}
                                        </td>
                                        <td class="text-end fw-bold">
                                            {{ number_format($quotation->grand_total, 2) }}
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
                                            <div class="d-flex justify-content-center">
                                                @can('view quotation')
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="{{ route('quotation.show', $quotation->id) }}" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="{{__('View Quotation')}}">
                                                        <i class="ti ti-eye text-dark"></i>
                                                    </a>
                                                </div>
                                                @endcan
                                                
                                                @can('edit quotation')
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="{{ route('quotation.edit', $quotation->id) }}" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="{{__('Edit Quotation')}}">
                                                        <i class="ti ti-pencil text-dark"></i>
                                                    </a>
                                                </div>
                                                @endcan
                                                
                                                @can('print quotation')
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="{{ route('quotation.print', $quotation->id) }}" 
                                                       target="_blank"
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="{{__('Print Quotation')}}">
                                                        <i class="ti ti-printer text-dark"></i>
                                                    </a>
                                                </div>
                                                @endcan
                                                
                                                @can('convert quotation')
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <button type="button" 
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                            data-bs-toggle="tooltip" 
                                                            title="{{__('Convert to Invoice')}}"
                                                            onclick="convertToInvoice({{ $quotation->id }})">
                                                        <i class="ti ti-file-invoice text-success"></i>
                                                    </button>
                                                </div>
                                                @endcan
                                                
                                                @can('delete quotation')
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['quotation.destroy', $quotation->id], 'id' => 'delete-form-' . $quotation->id, 'class' => 'd-inline']) !!}
                                                    <a href="#!" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" 
                                                       data-bs-toggle="tooltip" 
                                                       title="{{__('Delete Quotation')}}" 
                                                       data-confirm="{{__('Are You Sure?')}}" 
                                                       data-text="{{__('This action will permanently delete the quotation. Do you want to continue?')}}" 
                                                       data-confirm-yes="delete-form-{{ $quotation->id }}">
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
                                        <td colspan="10" class="text-center">
                                            <div class="alert alert-info d-inline-flex align-items-center">
                                                <i class="ti ti-info-circle me-2"></i>
                                                {{ __('No quotations found.') }}
                                                @can('create quotation')
                                                <a href="{{ route('quotation.create') }}" class="alert-link ms-1">
                                                    {{ __('Create your first quotation') }}
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
        tableId="quotationsTable"
        searchPlaceholder="Search quotations..."
        pdfTitle="Quotations"
    />
    
    <script>
    function convertToInvoice(quotationId) {
        if (confirm('Are you sure you want to convert this quotation to an invoice?')) {
            window.location.href = '{{ url('quotation') }}/' + quotationId + '/convert-to-invoice';
        }
    }
    
    // Add delete confirmation for quotations
    document.addEventListener('DOMContentLoaded', function() {
        const passButtons = document.querySelectorAll('.bs-pass-para');
        passButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const formId = this.getAttribute('data-confirm-yes');
                const confirmText = this.getAttribute('data-text');
                const confirmMessage = this.getAttribute('data-confirm');
                
                if (confirm(confirmMessage + '\n\n' + confirmText)) {
                    document.getElementById(formId).submit();
                }
            });
        });
    });
    </script>
@endpush