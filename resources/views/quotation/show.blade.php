<!-- In quotation/show.blade.php -->
@extends('layouts.admin')

@section('page-title')
    {{ __('View Quotation') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('quotation.index') }}">{{ __('Quotations') }}</a></li>
    <li class="breadcrumb-item">{{ __('View') }}</li>
@endsection

@push('styles')
<style>
    .invoice-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 10px;
        margin-bottom: 30px;
    }
    .company-logo {
        max-width: 150px;
        max-height: 100px;
    }
    .status-badge {
        font-size: 0.85rem;
        padding: 5px 15px;
        border-radius: 20px;
    }
    .invoice-table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #495057;
    }
    .totals-table {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
    }
    .totals-table td {
        padding: 8px 15px;
        border-bottom: 1px solid #dee2e6;
    }
    .totals-table tr:last-child td {
        border-bottom: none;
    }
    .section-title {
        color: #495057;
        border-bottom: 2px solid #667eea;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .customer-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
    }
    .print-only {
        display: none;
    }
    @media print {
        .no-print {
            display: none !important;
        }
        .print-only {
            display: block;
        }
        body {
            font-size: 12px;
        }
        .invoice-header {
            background: #667eea !important;
            -webkit-print-color-adjust: exact;
        }
        .invoice-table th {
            background-color: #f8f9fa !important;
            -webkit-print-color-adjust: exact;
        }
    }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('Quotation Details') }}</h5>
                        <div class="btn-group no-print">
                            <a href="{{ route('quotation.edit', $quotation->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="ti ti-pencil"></i> {{ __('Edit') }}
                            </a>
                            <a href="{{ route('quotation.print', $quotation->id) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="ti ti-printer"></i> {{ __('Print') }}
                            </a>
                            @if($quotation->status == 'open')
                                <a href="{{ route('quotation.convertToInvoice', $quotation->id) }}" 
                                   class="btn btn-outline-success btn-sm"
                                   onclick="return confirm('{{ __('Are you sure you want to convert this quotation to invoice?') }}')">
                                    <i class="ti ti-file-invoice"></i> {{ __('Convert to Invoice') }}
                                </a>
                            @endif
                            <a href="{{ route('quotation.pdf', $quotation->id) }}" class="btn btn-outline-warning btn-sm">
                                <i class="ti ti-download"></i> {{ __('Download PDF') }}
                            </a>
                            <a href="{{ route('quotation.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="ti ti-arrow-left"></i> {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Quotation Header -->
                    <div class="invoice-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <h1 class="display-5 mb-3">{{ __('QUOTATION') }}</h1>
                                <h3 class="mb-2">{{ $quotation->quotation_code }}</h3>
                                <p class="mb-1"><strong>{{ __('Date') }}:</strong> {{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d-m-Y') }}</p>
                                @if($quotation->expire_date)
                                    <p class="mb-1"><strong>{{ __('Valid Until') }}:</strong> {{ \Carbon\Carbon::parse($quotation->expire_date)->format('d-m-Y') }}</p>
                                @endif
                                <span class="status-badge badge bg-{{ $quotation->status == 'open' ? 'success' : ($quotation->status == 'closed' ? 'secondary' : ($quotation->status == 'po_converted' ? 'info' : 'danger')) }}">
                                    {{ ucfirst($quotation->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <!-- Bill To -->
                        <div class="col-md-6">
                            <div class="customer-card">
                                <h6 class="section-title">{{ __('Bill To') }}</h6>
                                <h5 class="mb-2">{{ $quotation->customer_name }}</h5>
                                <p class="mb-1"><strong>{{ __('Contact Person') }}:</strong> {{ $quotation->contact_person }}</p>
                                @if($quotation->customer_email)
                                    <p class="mb-1"><strong>{{ __('Email') }}:</strong> {{ $quotation->customer_email }}</p>
                                @endif
                                @if($quotation->customer_mobile)
                                    <p class="mb-1"><strong>{{ __('Phone') }}:</strong> {{ $quotation->customer_mobile }}</p>
                                @endif
                                <p class="mb-1"><strong>{{ __('Shipping State') }}:</strong> {{ $quotation->customer->shipping_state ?? 'N/A' }}</p>
                                <p class="mb-0"><strong>{{ __('GST Type') }}:</strong> 
                                    @if($quotation->gst_type == 'cgst_sgst')
                                        {{ __('CGST + SGST') }}
                                    @else
                                        {{ __('IGST') }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Sales Info -->
                        <div class="col-md-6">
                            <div class="customer-card">
                                <h6 class="section-title">{{ __('Sales Information') }}</h6>
                                <p class="mb-1"><strong>{{ __('Sales Engineer') }}:</strong> 
                                    {{ $quotation->salesman->name ?? 'N/A' }}
                                </p>
                                @if($quotation->reference)
                                    <p class="mb-1"><strong>{{ __('Reference') }}:</strong> {{ $quotation->reference }}</p>
                                @endif
                                @if($quotation->reference_no)
                                    <p class="mb-1"><strong>{{ __('Reference No') }}:</strong> {{ $quotation->reference_no }}</p>
                                @endif
                                @if($quotation->reference_date)
                                    <p class="mb-1"><strong>{{ __('Reference Date') }}:</strong> {{ \Carbon\Carbon::parse($quotation->reference_date)->format('d-m-Y') }}</p>
                                @endif
                                <p class="mb-0"><strong>{{ __('Created On') }}:</strong> {{ $quotation->created_at->format('d-m-Y h:i A') }}</p>
                                @if($quotation->updated_at != $quotation->created_at)
                                    <p class="mb-0"><strong>{{ __('Last Updated') }}:</strong> {{ $quotation->updated_at->format('d-m-Y h:i A') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">{{ __('Items') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 invoice-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>{{ __('Item') }}</th>
                                            <th>{{ __('HSN Code') }}</th>
                                            <th>{{ __('SKU') }}</th>
                                            <th class="text-center">{{ __('Qty') }}</th>
                                            <th class="text-end">{{ __('Unit Price') }}</th>
                                            <th class="text-end">{{ __('Discount') }}</th>
                                            <th class="text-center">{{ __('Tax %') }}</th>
                                            <th class="text-end">{{ __('Tax Amount') }}</th>
                                            <th class="text-end">{{ __('Total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $itemCounter = 1;
                                            $grandTotal = 0;
                                        @endphp
                                        @foreach($quotation->items as $item)
                                            @php
                                                $subtotal = $item->quantity * $item->unit_price;
                                                $discountAmount = 0;
                                                if($item->discount_type == 'percentage') {
                                                    $discountAmount = ($subtotal * $item->discount) / 100;
                                                } else {
                                                    $discountAmount = $item->discount;
                                                }
                                                $taxableAmount = $subtotal - $discountAmount;
                                                $taxAmount = ($taxableAmount * $item->tax_percentage) / 100;
                                                $total = $taxableAmount + $taxAmount;
                                                $grandTotal += $total;
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $itemCounter++ }}</td>
                                                <td>
                                                    <strong>{{ $item->item_name }}</strong>
                                                    @if($item->description)
                                                        <br>
                                                        <small class="text-muted">{{ $item->description }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $item->hsn_code ?? 'N/A' }}</td>
                                                <td>{{ $item->sku ?? 'N/A' }}</td>
                                                <td class="text-center">{{ number_format($item->quantity, 2) }}</td>
                                                <td class="text-end">₹{{ number_format($item->unit_price, 2) }}</td>
                                                <td class="text-end">
                                                    @if($item->discount > 0)
                                                        {{ number_format($item->discount, 2) }}
                                                        @if($item->discount_type == 'percentage')
                                                            %
                                                        @else
                                                            ₹
                                                        @endif
                                                    @else
                                                        0.00
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ number_format($item->tax_percentage, 2) }}%</td>
                                                <td class="text-end">₹{{ number_format($taxAmount, 2) }}</td>
                                                <td class="text-end">₹{{ number_format($total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Section -->
                    <div class="row">
                        <!-- Terms & Conditions -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">{{ __('Terms & Conditions') }}</h6>
                                </div>
                                <div class="card-body">
                                    @if($quotation->payment_terms)
                                        <h6>{{ __('Payment Terms') }}:</h6>
                                        <p>{{ $quotation->payment_terms }}</p>
                                    @endif
                                    
                                    @if($quotation->description)
                                        <h6>{{ __('Additional Notes') }}:</h6>
                                        <p>{{ $quotation->description }}</p>
                                    @endif
                                    
                                    @if(empty($quotation->payment_terms) && empty($quotation->description))
                                        <p class="text-muted">{{ __('No terms and conditions added.') }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Other Charges -->
                            @php
                                $otherCharges = json_decode($quotation->other_charges, true) ?? [];
                            @endphp
                            @if(!empty($otherCharges))
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">{{ __('Other Charges') }}</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('Charge Name') }}</th>
                                                        <th class="text-end">{{ __('Amount') }}</th>
                                                        <th class="text-center">{{ __('Tax %') }}</th>
                                                        <th class="text-end">{{ __('Total') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($otherCharges as $charge)
                                                        <tr>
                                                            <td>{{ $charge['name'] ?? 'N/A' }}</td>
                                                            <td class="text-end">₹{{ number_format($charge['amount'] ?? 0, 2) }}</td>
                                                            <td class="text-center">{{ $charge['tax_rate'] ?? 0 }}%</td>
                                                            <td class="text-end">₹{{ number_format($charge['total'] ?? 0, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Totals -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">{{ __('Summary') }}</h6>
                                </div>
                                <div class="card-body totals-table">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <td>{{ __('Total Items') }}</td>
                                            <td class="text-end">{{ $quotation->total_items }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Total Quantity') }}</td>
                                            <td class="text-end">{{ number_format($quotation->total_quantity, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Subtotal') }}</td>
                                            <td class="text-end">₹{{ number_format($quotation->subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Total Discount') }}</td>
                                            <td class="text-end text-danger">-₹{{ number_format($quotation->total_discount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Taxable Amount') }}</td>
                                            <td class="text-end">₹{{ number_format($quotation->taxable_amount, 2) }}</td>
                                        </tr>
                                        
                                        <!-- Tax Breakdown -->
                                        @if($quotation->gst_type == 'cgst_sgst')
                                            <tr>
                                                <td>{{ __('CGST') }}</td>
                                                <td class="text-end">₹{{ number_format($quotation->cgst, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('SGST') }}</td>
                                                <td class="text-end">₹{{ number_format($quotation->sgst, 2) }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ __('IGST') }}</td>
                                                <td class="text-end">₹{{ number_format($quotation->igst, 2) }}</td>
                                            </tr>
                                        @endif
                                        
                                        <tr>
                                            <td>{{ __('Total Tax') }}</td>
                                            <td class="text-end">₹{{ number_format($quotation->total_tax, 2) }}</td>
                                        </tr>
                                        
                                        @if($quotation->other_charges_total > 0)
                                            <tr>
                                                <td>{{ __('Other Charges') }}</td>
                                                <td class="text-end">+₹{{ number_format($quotation->other_charges_total, 2) }}</td>
                                            </tr>
                                        @endif
                                        
                                        @if($quotation->round_off != 0)
                                            <tr>
                                                <td>{{ __('Round Off') }}</td>
                                                <td class="text-end {{ $quotation->round_off > 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ $quotation->round_off > 0 ? '+' : '' }}₹{{ number_format($quotation->round_off, 2) }}
                                                </td>
                                            </tr>
                                        @endif
                                        
                                        <tr class="table-active">
                                            <td><strong>{{ __('Grand Total') }}</strong></td>
                                            <td class="text-end">
                                                <h4 class="mb-0 text-primary">₹{{ number_format($quotation->grand_total, 2) }}</h4>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <!-- Amount in Words -->
                                    <div class="mt-4 pt-3 border-top">
                                        <p class="mb-0">
                                            <strong>{{ __('Amount in Words') }}:</strong><br>
                                            <em>{{ $amountInWords }} Rupees Only</em>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                   
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Print functionality
    function printQuotation() {
        window.print();
    }
    
    // Convert to invoice confirmation
    $('.convert-to-invoice').click(function(e) {
        if(!confirm('Are you sure you want to convert this quotation to an invoice?')) {
            e.preventDefault();
        }
    });
    
    // Keyboard shortcuts
    $(document).keydown(function(e) {
        // Ctrl+P for print
        if((e.ctrlKey || e.metaKey) && e.keyCode === 80) {
            e.preventDefault();
            printQuotation();
        }
        // Esc key to go back
        if(e.keyCode === 27) {
            window.history.back();
        }
    });
});
</script>
@endpush