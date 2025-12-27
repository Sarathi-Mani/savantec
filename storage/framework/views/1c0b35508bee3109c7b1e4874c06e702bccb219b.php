<!-- In quotation/show.blade.php -->


<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('View Quotation')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('quotation.index')); ?>"><?php echo e(__('Quotations')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('View')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo e(__('Quotation Details')); ?></h5>
                        <div class="btn-group no-print">
                            <a href="<?php echo e(route('quotation.edit', $quotation->id)); ?>" class="btn btn-outline-primary btn-sm">
                                <i class="ti ti-pencil"></i> <?php echo e(__('Edit')); ?>

                            </a>
                            <a href="<?php echo e(route('quotation.print', $quotation->id)); ?>" target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="ti ti-printer"></i> <?php echo e(__('Print')); ?>

                            </a>
                            <?php if($quotation->status == 'open'): ?>
                                <a href="<?php echo e(route('quotation.convertToInvoice', $quotation->id)); ?>" 
                                   class="btn btn-outline-success btn-sm"
                                   onclick="return confirm('<?php echo e(__('Are you sure you want to convert this quotation to invoice?')); ?>')">
                                    <i class="ti ti-file-invoice"></i> <?php echo e(__('Convert to Invoice')); ?>

                                </a>
                            <?php endif; ?>
                            <a href="<?php echo e(route('quotation.pdf', $quotation->id)); ?>" class="btn btn-outline-warning btn-sm">
                                <i class="ti ti-download"></i> <?php echo e(__('Download PDF')); ?>

                            </a>
                            <a href="<?php echo e(route('quotation.index')); ?>" class="btn btn-outline-secondary btn-sm">
                                <i class="ti ti-arrow-left"></i> <?php echo e(__('Back')); ?>

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
                                <h1 class="display-5 mb-3"><?php echo e(__('QUOTATION')); ?></h1>
                                <h3 class="mb-2"><?php echo e($quotation->quotation_code); ?></h3>
                                <p class="mb-1"><strong><?php echo e(__('Date')); ?>:</strong> <?php echo e(\Carbon\Carbon::parse($quotation->quotation_date)->format('d-m-Y')); ?></p>
                                <?php if($quotation->expire_date): ?>
                                    <p class="mb-1"><strong><?php echo e(__('Valid Until')); ?>:</strong> <?php echo e(\Carbon\Carbon::parse($quotation->expire_date)->format('d-m-Y')); ?></p>
                                <?php endif; ?>
                                <span class="status-badge badge bg-<?php echo e($quotation->status == 'open' ? 'success' : ($quotation->status == 'closed' ? 'secondary' : ($quotation->status == 'po_converted' ? 'info' : 'danger'))); ?>">
                                    <?php echo e(ucfirst($quotation->status)); ?>

                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <!-- Bill To -->
                        <div class="col-md-6">
                            <div class="customer-card">
                                <h6 class="section-title"><?php echo e(__('Bill To')); ?></h6>
                                <h5 class="mb-2"><?php echo e($quotation->customer_name); ?></h5>
                                <p class="mb-1"><strong><?php echo e(__('Contact Person')); ?>:</strong> <?php echo e($quotation->contact_person); ?></p>
                                <?php if($quotation->customer_email): ?>
                                    <p class="mb-1"><strong><?php echo e(__('Email')); ?>:</strong> <?php echo e($quotation->customer_email); ?></p>
                                <?php endif; ?>
                                <?php if($quotation->customer_mobile): ?>
                                    <p class="mb-1"><strong><?php echo e(__('Phone')); ?>:</strong> <?php echo e($quotation->customer_mobile); ?></p>
                                <?php endif; ?>
                                <p class="mb-1"><strong><?php echo e(__('Shipping State')); ?>:</strong> <?php echo e($quotation->customer->shipping_state ?? 'N/A'); ?></p>
                                <p class="mb-0"><strong><?php echo e(__('GST Type')); ?>:</strong> 
                                    <?php if($quotation->gst_type == 'cgst_sgst'): ?>
                                        <?php echo e(__('CGST + SGST')); ?>

                                    <?php else: ?>
                                        <?php echo e(__('IGST')); ?>

                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <!-- Sales Info -->
                        <div class="col-md-6">
                            <div class="customer-card">
                                <h6 class="section-title"><?php echo e(__('Sales Information')); ?></h6>
                                <p class="mb-1"><strong><?php echo e(__('Sales Engineer')); ?>:</strong> 
                                    <?php echo e($quotation->salesman->name ?? 'N/A'); ?>

                                </p>
                                <?php if($quotation->reference): ?>
                                    <p class="mb-1"><strong><?php echo e(__('Reference')); ?>:</strong> <?php echo e($quotation->reference); ?></p>
                                <?php endif; ?>
                                <?php if($quotation->reference_no): ?>
                                    <p class="mb-1"><strong><?php echo e(__('Reference No')); ?>:</strong> <?php echo e($quotation->reference_no); ?></p>
                                <?php endif; ?>
                                <?php if($quotation->reference_date): ?>
                                    <p class="mb-1"><strong><?php echo e(__('Reference Date')); ?>:</strong> <?php echo e(\Carbon\Carbon::parse($quotation->reference_date)->format('d-m-Y')); ?></p>
                                <?php endif; ?>
                                <p class="mb-0"><strong><?php echo e(__('Created On')); ?>:</strong> <?php echo e($quotation->created_at->format('d-m-Y h:i A')); ?></p>
                                <?php if($quotation->updated_at != $quotation->created_at): ?>
                                    <p class="mb-0"><strong><?php echo e(__('Last Updated')); ?>:</strong> <?php echo e($quotation->updated_at->format('d-m-Y h:i A')); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><?php echo e(__('Items')); ?></h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 invoice-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th><?php echo e(__('Item')); ?></th>
                                            <th><?php echo e(__('HSN Code')); ?></th>
                                            <th><?php echo e(__('SKU')); ?></th>
                                            <th class="text-center"><?php echo e(__('Qty')); ?></th>
                                            <th class="text-end"><?php echo e(__('Unit Price')); ?></th>
                                            <th class="text-end"><?php echo e(__('Discount')); ?></th>
                                            <th class="text-center"><?php echo e(__('Tax %')); ?></th>
                                            <th class="text-end"><?php echo e(__('Tax Amount')); ?></th>
                                            <th class="text-end"><?php echo e(__('Total')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $itemCounter = 1;
                                            $grandTotal = 0;
                                        ?>
                                        <?php $__currentLoopData = $quotation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
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
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo e($itemCounter++); ?></td>
                                                <td>
                                                    <strong><?php echo e($item->item_name); ?></strong>
                                                    <?php if($item->description): ?>
                                                        <br>
                                                        <small class="text-muted"><?php echo e($item->description); ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($item->hsn_code ?? 'N/A'); ?></td>
                                                <td><?php echo e($item->sku ?? 'N/A'); ?></td>
                                                <td class="text-center"><?php echo e(number_format($item->quantity, 2)); ?></td>
                                                <td class="text-end">₹<?php echo e(number_format($item->unit_price, 2)); ?></td>
                                                <td class="text-end">
                                                    <?php if($item->discount > 0): ?>
                                                        <?php echo e(number_format($item->discount, 2)); ?>

                                                        <?php if($item->discount_type == 'percentage'): ?>
                                                            %
                                                        <?php else: ?>
                                                            ₹
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        0.00
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center"><?php echo e(number_format($item->tax_percentage, 2)); ?>%</td>
                                                <td class="text-end">₹<?php echo e(number_format($taxAmount, 2)); ?></td>
                                                <td class="text-end">₹<?php echo e(number_format($total, 2)); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    <h6 class="mb-0"><?php echo e(__('Terms & Conditions')); ?></h6>
                                </div>
                                <div class="card-body">
                                    <?php if($quotation->payment_terms): ?>
                                        <h6><?php echo e(__('Payment Terms')); ?>:</h6>
                                        <p><?php echo e($quotation->payment_terms); ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if($quotation->description): ?>
                                        <h6><?php echo e(__('Additional Notes')); ?>:</h6>
                                        <p><?php echo e($quotation->description); ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if(empty($quotation->payment_terms) && empty($quotation->description)): ?>
                                        <p class="text-muted"><?php echo e(__('No terms and conditions added.')); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Other Charges -->
                            <?php
                                $otherCharges = json_decode($quotation->other_charges, true) ?? [];
                            ?>
                            <?php if(!empty($otherCharges)): ?>
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><?php echo e(__('Other Charges')); ?></h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo e(__('Charge Name')); ?></th>
                                                        <th class="text-end"><?php echo e(__('Amount')); ?></th>
                                                        <th class="text-center"><?php echo e(__('Tax %')); ?></th>
                                                        <th class="text-end"><?php echo e(__('Total')); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $otherCharges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $charge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($charge['name'] ?? 'N/A'); ?></td>
                                                            <td class="text-end">₹<?php echo e(number_format($charge['amount'] ?? 0, 2)); ?></td>
                                                            <td class="text-center"><?php echo e($charge['tax_rate'] ?? 0); ?>%</td>
                                                            <td class="text-end">₹<?php echo e(number_format($charge['total'] ?? 0, 2)); ?></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Totals -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><?php echo e(__('Summary')); ?></h6>
                                </div>
                                <div class="card-body totals-table">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <td><?php echo e(__('Total Items')); ?></td>
                                            <td class="text-end"><?php echo e($quotation->total_items); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo e(__('Total Quantity')); ?></td>
                                            <td class="text-end"><?php echo e(number_format($quotation->total_quantity, 2)); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo e(__('Subtotal')); ?></td>
                                            <td class="text-end">₹<?php echo e(number_format($quotation->subtotal, 2)); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo e(__('Total Discount')); ?></td>
                                            <td class="text-end text-danger">-₹<?php echo e(number_format($quotation->total_discount, 2)); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo e(__('Taxable Amount')); ?></td>
                                            <td class="text-end">₹<?php echo e(number_format($quotation->taxable_amount, 2)); ?></td>
                                        </tr>
                                        
                                        <!-- Tax Breakdown -->
                                        <?php if($quotation->gst_type == 'cgst_sgst'): ?>
                                            <tr>
                                                <td><?php echo e(__('CGST')); ?></td>
                                                <td class="text-end">₹<?php echo e(number_format($quotation->cgst, 2)); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo e(__('SGST')); ?></td>
                                                <td class="text-end">₹<?php echo e(number_format($quotation->sgst, 2)); ?></td>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <td><?php echo e(__('IGST')); ?></td>
                                                <td class="text-end">₹<?php echo e(number_format($quotation->igst, 2)); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        
                                        <tr>
                                            <td><?php echo e(__('Total Tax')); ?></td>
                                            <td class="text-end">₹<?php echo e(number_format($quotation->total_tax, 2)); ?></td>
                                        </tr>
                                        
                                        <?php if($quotation->other_charges_total > 0): ?>
                                            <tr>
                                                <td><?php echo e(__('Other Charges')); ?></td>
                                                <td class="text-end">+₹<?php echo e(number_format($quotation->other_charges_total, 2)); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        
                                        <?php if($quotation->round_off != 0): ?>
                                            <tr>
                                                <td><?php echo e(__('Round Off')); ?></td>
                                                <td class="text-end <?php echo e($quotation->round_off > 0 ? 'text-success' : 'text-danger'); ?>">
                                                    <?php echo e($quotation->round_off > 0 ? '+' : ''); ?>₹<?php echo e(number_format($quotation->round_off, 2)); ?>

                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        
                                        <tr class="table-active">
                                            <td><strong><?php echo e(__('Grand Total')); ?></strong></td>
                                            <td class="text-end">
                                                <h4 class="mb-0 text-primary">₹<?php echo e(number_format($quotation->grand_total, 2)); ?></h4>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <!-- Amount in Words -->
                                    <div class="mt-4 pt-3 border-top">
                                        <p class="mb-0">
                                            <strong><?php echo e(__('Amount in Words')); ?>:</strong><br>
                                            <em><?php echo e($amountInWords); ?> Rupees Only</em>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-github\resources\views/quotation/show.blade.php ENDPATH**/ ?>