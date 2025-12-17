

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Enquiry')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('enquiry.index')); ?>"><?php echo e(__('Enquiry')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Edit')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('enquiry.update', $enquiry->id)); ?>" enctype="multipart/form-data" id="enquiryForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <!-- Basic Information Section -->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="serial_no" class="form-label"><?php echo e(__('Enquiry No')); ?></label>
                                    <input type="text" class="form-control bg-light" id="serial_no" value="<?php echo e($enquiry->serial_no); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Company Information in Table Format - DISPLAY ONLY -->
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group mb-3">
                                    <h6 class="my-3 mb-3"><?php echo e(__('Company Information')); ?></h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 25%; font-weight: bold;">
                                                        <label class="form-label mb-0"><?php echo e(__('Company Name')); ?></label>
                                                    </td>
                                                    <td style="width: 25%;">
                                                        <div class="form-control-plaintext"><?php echo e($enquiry->company_name ?? 'N/A'); ?></div>
                                                        <input type="hidden" name="company_id" value="<?php echo e($enquiry->company_id); ?>">
                                                    </td>
                                                    <td style="width: 25%; font-weight: bold;">
                                                        <label class="form-label mb-0"><?php echo e(__('Enquiry Date')); ?></label>
                                                    </td>
                                                    <td style="width: 25%;">
                                                        <div class="form-control-plaintext"><?php echo e(\Carbon\Carbon::parse($enquiry->enquiry_date)->format('d-m-Y')); ?></div>
                                                        <input type="hidden" name="enquiry_date" value="<?php echo e($enquiry->enquiry_date); ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;">
                                                        <label class="form-label mb-0"><?php echo e(__('Sales Engineer')); ?></label>
                                                    </td>
                                                    <td>
                                                        <div class="form-control-plaintext"><?php echo e($enquiry->salesman->name ?? 'Not Assigned'); ?></div>
                                                        <input type="hidden" name="salesman_id" value="<?php echo e($enquiry->salesman_id); ?>">
                                                    </td>
                                                    <td style="font-weight: bold;">
                                                        <label class="form-label mb-0"><?php echo e(__('Kind Attn.')); ?></label>
                                                    </td>
                                                    <td>
                                                        <div class="form-control-plaintext"><?php echo e($enquiry->kind_attn ?? 'N/A'); ?></div>
                                                        <input type="hidden" name="kind_attn" value="<?php echo e($enquiry->kind_attn); ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;">
                                                        <label class="form-label mb-0"><?php echo e(__('Email')); ?></label>
                                                    </td>
                                                    <td>
                                                        <div class="form-control-plaintext"><?php echo e($enquiry->mail_id ?? 'N/A'); ?></div>
                                                        <input type="hidden" name="mail_id" value="<?php echo e($enquiry->mail_id); ?>">
                                                    </td>
                                                    <td style="font-weight: bold;">
                                                        <label class="form-label mb-0"><?php echo e(__('Phone')); ?></label>
                                                    </td>
                                                    <td>
                                                        <div class="form-control-plaintext"><?php echo e($enquiry->phone_no ?? 'N/A'); ?></div>
                                                        <input type="hidden" name="phone_no" value="<?php echo e($enquiry->phone_no); ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;">
                                                        <label class="form-label mb-0"><?php echo e(__('Remarks')); ?></label>
                                                    </td>
                                                    <td colspan="3">
                                                        <div class="form-control-plaintext"><?php echo e($enquiry->remarks ?? 'N/A'); ?></div>
                                                        <input type="hidden" name="remarks" value="<?php echo e($enquiry->remarks); ?>">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Items Section -->
                       <!-- Items Section - Updated Code -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="form-group">
            <h6 class="my-3 mb-3"><?php echo e(__('Items')); ?></h6>
            <div class="table-responsive">
                <table class="table table-bordered" id="items-table">
                    <thead class='mt-5'>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 40%;"><?php echo e(__('Item Name')); ?></th>
                            <th style="width: 10%;"><?php echo e(__('Qty')); ?></th>
                            <th style="width: 20%;"><?php echo e(__('Suitable Item')); ?></th>
                            <th style="width: 12.5%;"><?php echo e(__('Purchase Price')); ?></th>
                            <th style="width: 12.5%;"><?php echo e(__('Sales Price')); ?></th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $items = json_decode($enquiry->items, true) ?? [];
                            $itemCount = 0;
                        ?>
                        
                        <?php if(count($items) > 0): ?>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $itemCount++; ?>
                                <tr data-item-index="<?php echo e($itemCount); ?>">
                                    <td><?php echo e($itemCount); ?></td>
                                    <td>
                                        <textarea class="form-control" name="items[<?php echo e($itemCount); ?>][description]" rows="2" required><?php echo e(old('items.' . $itemCount . '.description', $item['description'] ?? '')); ?></textarea>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="items[<?php echo e($itemCount); ?>][quantity]" value="<?php echo e(old('items.' . $itemCount . '.quantity', $item['quantity'] ?? 1)); ?>" min="1" required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="items[<?php echo e($itemCount); ?>][suitable_item]" value="<?php echo e(old('items.' . $itemCount . '.suitable_item', $item['suitable_item'] ?? '')); ?>">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="items[<?php echo e($itemCount); ?>][purchase_price]" value="<?php echo e(old('items.' . $itemCount . '.purchase_price', $item['purchase_price'] ?? '0.00')); ?>" step="0.01" min="0">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="items[<?php echo e($itemCount); ?>][sales_price]" value="<?php echo e(old('items.' . $itemCount . '.sales_price', $item['sales_price'] ?? '0.00')); ?>" step="0.01" min="0">
                                    </td>
                                    
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <!-- Default item row -->
                            <tr data-item-index="1">
                                <td>1</td>
                                <td>
                                    <textarea class="form-control" name="items[1][description]" rows="2" required><?php echo e(old('items.1.description')); ?></textarea>
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="items[1][quantity]" value="<?php echo e(old('items.1.quantity', 1)); ?>" min="1" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="items[1][suitable_item]" value="<?php echo e(old('items.1.suitable_item', '')); ?>">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="items[1][purchase_price]" value="<?php echo e(old('items.1.purchase_price', '0.00')); ?>" step="0.01" min="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="items[1][sales_price]" value="<?php echo e(old('items.1.sales_price', '0.00')); ?>" step="0.01" min="0">
                                </td>
                                <td></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>

                      
                     <div class="row">
    <div class="col-md-12">
        <div class="form-group">
      <label class='form-label' style="<?php echo e(old('status', $enquiry->status) == 'ignored' ? 'display: none;' : ''); ?>">Pending Remarks</label>
      </div>
        <div class="row">
            <!-- Purchase Remarks (left side) -->
          <div class="col-md-6 purchase-remarks-section" style="<?php echo e(old('status', $enquiry->status) == 'ignored' ? 'display: none;' : ''); ?>">
    <div class="form-group">
        <label for="purchase_remarks" class="form-label"><?php echo e(__('Purchase Remarks')); ?></label>
        <textarea class="form-control" id="purchase_remarks" name="purchase_remarks" rows="3" placeholder="<?php echo e(__('Enter purchase remarks...')); ?>"><?php echo e(old('pending_remarks', $enquiry->pending_remarks)); ?></textarea>
    </div>
</div>
            
            <!-- Status (right side) -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status" class="form-label"><?php echo e(__('Status')); ?> <span class="text-danger">*</span></label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="completed" <?php echo e(old('status', $enquiry->status) == 'completed' ? 'selected' : ''); ?>><?php echo e(__('Ready for Quotation')); ?></option>
                        <option value="ready_for_purchase" <?php echo e(old('status', $enquiry->status) == 'ready_for_purchase' ? 'selected' : ''); ?>><?php echo e(__('Ready for Purchase')); ?></option>
                     <option value="ignored" <?php echo e(old('status', $enquiry->status) == 'ignored' ? 'selected' : ''); ?>><?php echo e(__('Ignore Enquiry')); ?></option>
              
                    </select>
                   
                </div>
            </div>
        </div>
    </div>
</div>
                        <!-- Additional Dates Section -->
                      

                        <!-- Form Buttons -->
                        <div class="modal-footer">
                            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-light" onclick="window.location.href='<?php echo e(route('enquiry.index')); ?>'">
                            <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .bg-light {
        background-color: #f8f9fa !important;
        cursor: not-allowed;
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .table-bordered td, .table-bordered th {
        border: 1px solid #dee2e6;
    }
    .table td {
        vertical-align: middle;
    }
    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    .form-control-plaintext {
        display: block;
        width: 100%;
        padding: 0.375rem 0;
        margin-bottom: 0;
        line-height: 1.5;
        color: #697a8d;
        background-color: transparent;
        border: solid transparent;
        border-width: 1px 0;
    }
    .table td .form-control {
        border: 1px solid transparent;
        background: transparent;
        transition: all 0.3s;
    }
    .table td .form-control:focus {
        border: 1px solid #80bdff;
        background: #fff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    textarea.form-control {
        resize: vertical;
    }
    .w-auto {
        width: auto !important;
        min-width: 200px;
    }
    .btn-outline-primary {
        border-color: #696cff;
        color: #696cff;
    }
    .btn-outline-primary:hover {
        background-color: #696cff;
        border-color: #696cff;
        color: #fff;
    }
    .btn-danger {
        background-color: #ff3e1d;
        border-color: #ff3e1d;
    }
    .btn-danger:hover {
        background-color: #e63517;
        border-color: #e63517;
    }
    .btn-light {
        background-color: #f8f9fa;
        border-color: #f8f9fa;
        color: #697a8d;
    }
    .btn-light:hover {
        background-color: #e9ecef;
        border-color: #e9ecef;
        color: #697a8d;
    }
    .btn-primary {
        background-color: #696cff;
        border-color: #696cff;
    }
    .btn-primary:hover {
        background-color: #5f61e6;
        border-color: #5f61e6;
    }
    .modal-footer {
        border-top: 1px solid #dee2e6;
        padding: 1rem 0 0 0;
        margin-top: 1.5rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        // Global item counter
        let itemCount = <?php echo e($itemCount > 0 ? $itemCount : 1); ?>;

        // Add item functionality
        $('#add-item-btn').click(function() {
            itemCount++;
            
            const newRow = `
                <tr data-item-index="${itemCount}">
                    <td>${itemCount}</td>
                    <td>
                        <textarea class="form-control" name="items[${itemCount}][description]" rows="2" required style="border: none; background: transparent;"></textarea>
                    </td>
                    <td>
                        <input type="number" class="form-control" name="items[${itemCount}][quantity]" value="1" min="1" required style="border: none; background: transparent;">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="items[${itemCount}][suitable_item]" value="" style="border: none; background: transparent;">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="items[${itemCount}][purchase_price]" value="0.00" step="0.01" min="0" style="border: none; background: transparent;">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="items[${itemCount}][sales_price]" value="0.00" step="0.01" min="0" style="border: none; background: transparent;">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger remove-item-btn" data-index="${itemCount}">
                            <i class="ti ti-minus"></i>
                        </button>
                    </td>
                </tr>
            `;
            
            $('#items-table tbody').append(newRow);
        });

        // Remove item functionality
        $(document).on('click', '.remove-item-btn', function(e) {
            e.preventDefault();
            
            // Don't remove if it's the only item
            if ($('#items-table tbody tr').length <= 1) {
                alert('At least one item is required');
                return;
            }
            
            // Remove the clicked row
            $(this).closest('tr').remove();
            
            // Renumber remaining items
            renumberItems();
        });

        // Function to renumber items
        function renumberItems() {
            let newIndex = 0;
            $('#items-table tbody tr').each(function() {
                newIndex++;
                const $row = $(this);
                
                // Update data attribute
                $row.attr('data-item-index', newIndex);
                
                // Update serial number
                $row.find('td:first').text(newIndex);
                
                // Update description field name
                $row.find('textarea').attr('name', `items[${newIndex}][description]`);
                
                // Update quantity field name
                $row.find('input[name*="quantity"]').attr('name', `items[${newIndex}][quantity]`);
                
                // Update suitable item field name
                $row.find('input[name*="suitable_item"]').attr('name', `items[${newIndex}][suitable_item]`);
                
                // Update purchase price field name
                $row.find('input[name*="purchase_price"]').attr('name', `items[${newIndex}][purchase_price]`);
                
                // Update sales price field name
                $row.find('input[name*="sales_price"]').attr('name', `items[${newIndex}][sales_price]`);
                
                // Update remove button data-index
                $row.find('.remove-item-btn').data('index', newIndex);
            });
            
            // Update global counter
            itemCount = newIndex;
            
            // Hide remove button if only one item remains
            if (itemCount === 1) {
                $('#items-table tbody tr:first .remove-item-btn').remove();
            }
        }

        // Hide remove button for first item initially if only one item
        if (itemCount === 1) {
            $('#items-table tbody tr:first .remove-item-btn').remove();
        }

        // Form validation
        $('#enquiryForm').submit(function(e) {
            const status = $('#status').val();
            let hasValidItem = false;
            let itemErrors = [];
            
            if (!status) {
                e.preventDefault();
                alert('Please select a status.');
                return false;
            }
            
            // Validate each item
            $('textarea[name*="[description]"]').each(function(index) {
                const itemNumber = index + 1;
                const description = $(this).val().trim();
                const quantity = $(this).closest('tr').find('input[name*="quantity"]').val().trim();
                
                if (!description) {
                    itemErrors.push(`Item ${itemNumber}: Description is required`);
                } else {
                    hasValidItem = true;
                }
                
                if (!quantity || quantity < 1) {
                    itemErrors.push(`Item ${itemNumber}: Quantity must be at least 1`);
                }
            });
            
            if (!hasValidItem) {
                e.preventDefault();
                alert('Please enter description for at least one item.');
                return false;
            }
            
            if (itemErrors.length > 0) {
                e.preventDefault();
                alert('Please fix the following errors:\n\n' + itemErrors.join('\n'));
                return false;
            }
            
            return true;
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WORK GPT\Github repo\savantec-erp\resources\views/enquiry/edit.blade.php ENDPATH**/ ?>