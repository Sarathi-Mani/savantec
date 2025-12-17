

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Create Enquiry')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('enquiry.index')); ?>"><?php echo e(__('Enquiry')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Create')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?php echo e(__('Enquiry')); ?></h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('enquiry.store')); ?>" enctype="multipart/form-data" id="enquiryForm">
                        <?php echo csrf_field(); ?>
                        
                        <!-- Basic Information Section -->
                        <div class="row mb-4">
                           <div class="col-md-6">
    <div class="form-group">
        <label for="enquiry_no" class="form-label"><?php echo e(__('Enquiry No')); ?> <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="enquiry_no" value="<?php echo e(old('enquiry_no', $suggestedSerial)); ?>" name="enquiry_no" required>
        <small class="form-text text-muted">Enter your custom enquiry number</small>
    </div>
</div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="enquiry_date" class="form-label"><?php echo e(__('Date')); ?> <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="enquiry_date" name="enquiry_date" value="<?php echo e(old('enquiry_date', date('Y-m-d'))); ?>" required>
                                </div>
                            </div>
                        </div>

                        
                        <!-- Company Information Section -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="company_id" class="form-label"><?php echo e(__('Company Name')); ?> <span class="text-danger">*</span></label>
                                    <select class=" select2" id="company_id" name="company_id" required>
                                        <option value=""><?php echo e(__('Select Company')); ?></option>
                                        <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php echo e(old('company_id') == $id ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Company Contact Details -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kind_attn" class="form-label"><?php echo e(__('Kind Attn.')); ?></label>
                                    <input type="text" class="form-control" id="kind_attn" name="kind_attn" value="<?php echo e(old('kind_attn')); ?>" placeholder="<?php echo e(__('Person Name')); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mail_id" class="form-label"><?php echo e(__('Mail-ID')); ?></label>
                                    <input type="email" class="form-control" id="mail_id" name="mail_id" value="<?php echo e(old('mail_id')); ?>" placeholder="<?php echo e(__('Email')); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone_no" class="form-label"><?php echo e(__('Phone No')); ?></label>
                                    <input type="text" class="form-control" id="phone_no" name="phone_no" value="<?php echo e(old('phone_no')); ?>" placeholder="<?php echo e(__('Phone Number')); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks" class="form-label"><?php echo e(__('Remarks')); ?></label>
                                    <textarea class="form-control" id="remarks" name="remarks" rows="2" placeholder="<?php echo e(__('Additional remarks...')); ?>"><?php echo e(old('remarks')); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Items Section -->
                        <div class="row mb-4">
                            <div class="col-md-12 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><?php echo e(__('Items')); ?></h6>
                                <button type="button" id="add-item-btn" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-plus"></i> <?php echo e(__('Add Item')); ?>

                                </button>
                            </div>
                        </div>

                        <!-- Items Container -->
                        <div id="items-container">
                            <!-- Item 1 -->
                            <div class="item-row mb-4 border p-3 rounded" data-item-index="1">
                                <div class="row mb-3">
                                    <div class="col-md-10">
                                        <h6 class="text-primary mb-0"><?php echo e(__('Item')); ?> <span class="item-number">1</span></h6>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <button type="button" class="btn btn-sm btn-danger remove-item-btn" data-index="1">
                                            <i class="ti ti-minus"></i> <?php echo e(__('Remove')); ?>

                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="item_description_1" class="form-label"><?php echo e(__('Item Description')); ?> <span class="text-danger">*</span></label>
                                            <textarea class="form-control item-description" id="item_description_1" name="items[1][description]" rows="3" placeholder="<?php echo e(__('Enter item description...')); ?>" required><?php echo e(old('items.1.description')); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="item_qty_1" class="form-label"><?php echo e(__('Qty')); ?></label>
                                            <input type="number" class="form-control item-qty" id="item_qty_1" name="items[1][quantity]" value="<?php echo e(old('items.1.quantity', 1)); ?>" min="1" placeholder="Qty" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="item_image_1" class="form-label"><?php echo e(__('Image')); ?></label>
                                            <div class="input-group">
                                                <input type="file" class="form-control item-image" id="item_image_1" name="items[1][image]" accept="image/*">
                                                <button type="button" class="btn btn-outline-primary pick-image-btn" data-target="item_image_1">
                                                    <i class="ti ti-plus"></i> <?php echo e(__('Pick Image')); ?>

                                                </button>
                                            </div>
                                            <div id="file-name-1" class="mt-1 small text-muted"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Salesman and Status (Optional - you can keep if needed) -->
                        <input type="hidden" name="salesman_id" value="<?php echo e(Auth::user()->hasRole('Sales Engineer') ? Auth::id() : ''); ?>">
                        <input type="hidden" name="status" value="pending">

                        <!-- Buttons -->
                        <div class="form-group text-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check"></i> <?php echo e(__('Save')); ?>

                            </button>
                            <a href="<?php echo e(route('enquiry.index')); ?>" class="btn btn-secondary">
                                <i class="ti ti-x"></i> <?php echo e(__('Cancel')); ?>

                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>

<style>
    .select2-container .select2-selection--single {
        height: 38px;
        border: 1px solid #ced4da;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
        color: #495057;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    .bg-light {
        background-color: #f8f9fa !important;
        cursor: not-allowed;
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .card-title {
        color: #333;
        font-weight: 600;
    }
    .item-row {
        background-color: #f8f9fa;
        transition: all 0.3s;
    }
    .item-row:hover {
        background-color: #e9ecef;
    }
    .remove-item-btn {
        opacity: 0.8;
        transition: opacity 0.3s;
    }
    .remove-item-btn:hover {
        opacity: 1;
    }
    #items-container {
        min-height: 100px;
    }
    .item-qty {
        min-width: 80px;
    }
    /* Hide theme Choices.js dropdown under Select2 */
.select2-hidden-accessible + .choices {
    display: none !important;
}

</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>

<script>
 


    $(document).ready(function() {
        // Initialize Select2 dropdowns
        $('.select2').select2({
            width: '100%',
            placeholder: "Select an option",
            allowClear: true
        });

        // Set today's date as default for enquiry date
        $('#enquiry_date').val(new Date().toISOString().split('T')[0]);

        // Global item counter
        let itemCount = 1;

        // Pick image button click
        $(document).on('click', '.pick-image-btn', function() {
            const targetId = $(this).data('target');
            $('#' + targetId).click();
        });

        // Display selected image filename
        $(document).on('change', '.item-image', function() {
            const fileName = $(this).val().split('\\').pop();
            const idParts = $(this).attr('id').split('_');
            const index = idParts.length > 2 ? idParts[2] : 1;
            if (fileName) {
                $('#file-name-' + index).html('<i class="ti ti-check text-success"></i> ' + fileName.substring(0, 25) + (fileName.length > 25 ? '...' : ''));
            } else {
                $('#file-name-' + index).html('');
            }
        });

        // Add item functionality - FIXED
        $('#add-item-btn').click(function() {
            itemCount++;
            
            const newItem = `
                <div class="item-row mb-4 border p-3 rounded" data-item-index="${itemCount}">
                    <div class="row mb-3">
                        <div class="col-md-10">
                            <h6 class="text-primary mb-0"><?php echo e(__('Item')); ?> <span class="item-number">${itemCount}</span></h6>
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-sm btn-danger remove-item-btn" data-index="${itemCount}">
                                <i class="ti ti-minus"></i> <?php echo e(__('Remove')); ?>

                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item_description_${itemCount}" class="form-label"><?php echo e(__('Item Description')); ?> <span class="text-danger">*</span></label>
                                <textarea class="form-control item-description" id="item_description_${itemCount}" name="items[${itemCount}][description]" rows="3" placeholder="<?php echo e(__('Enter item description...')); ?>" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="item_qty_${itemCount}" class="form-label"><?php echo e(__('Qty')); ?></label>
                                <input type="number" class="form-control item-qty" id="item_qty_${itemCount}" name="items[${itemCount}][quantity]" value="1" min="1" placeholder="Qty" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="item_image_${itemCount}" class="form-label"><?php echo e(__('Image')); ?></label>
                                <div class="input-group">
                                    <input type="file" class="form-control item-image" id="item_image_${itemCount}" name="items[${itemCount}][image]" accept="image/*">
                                    <button type="button" class="btn btn-outline-primary pick-image-btn" data-target="item_image_${itemCount}">
                                        <i class="ti ti-plus"></i> <?php echo e(__('Pick Image')); ?>

                                    </button>
                                </div>
                                <div id="file-name-${itemCount}" class="mt-1 small text-muted"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            $('#items-container').append(newItem);
            
            // Show remove button for all items when more than 1
            $('.remove-item-btn').show();
        });

        // Remove item functionality - SIMPLIFIED VERSION
        $(document).on('click', '.remove-item-btn', function(e) {
            e.preventDefault();
          
           
            
            // Remove the clicked item
            $(this).closest('.item-row').remove();
            
            // Renumber remaining items
            renumberItems();
        });

        // Function to renumber items
        function renumberItems() {
            let newIndex = 0;
            $('.item-row').each(function() {
                newIndex++;
                const $row = $(this);
                
                // Update data attribute
                $row.attr('data-item-index', newIndex);
                
                // Update item number display
                $row.find('.item-number').text(newIndex);
                
                // Update remove button data-index
                $row.find('.remove-item-btn').data('index', newIndex);
                
                // Update description field
                $row.find('.item-description').attr({
                    'name': `items[${newIndex}][description]`,
                    'id': `item_description_${newIndex}`
                });
                
                // Update quantity field
                $row.find('.item-qty').attr({
                    'name': `items[${newIndex}][quantity]`,
                    'id': `item_qty_${newIndex}`
                });
                
                // Update image field
                $row.find('.item-image').attr({
                    'name': `items[${newIndex}][image]`,
                    'id': `item_image_${newIndex}`
                });
                
                // Update pick image button
                $row.find('.pick-image-btn').data('target', `item_image_${newIndex}`);
                
                // Update file name display
                $row.find('.small.text-muted').attr('id', `file-name-${newIndex}`);
            });
            
            // Update global counter
            itemCount = newIndex;
            
          
        }

       

        // Form validation
        $('#enquiryForm').submit(function(e) {
            const companyId = $('#company_id').val();
            let hasValidItem = false;
            let itemErrors = [];
            
            if (!companyId) {
                e.preventDefault();
                alert('Please select a company.');
                return false;
            }
            
            // Validate each item
            $('.item-row').each(function(index) {
                const itemNumber = index + 1;
                const description = $(this).find('.item-description').val().trim();
                const quantity = $(this).find('.item-qty').val().trim();
                
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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WORK GPT\Github repo\savantec-erp\resources\views/enquiry/create.blade.php ENDPATH**/ ?>