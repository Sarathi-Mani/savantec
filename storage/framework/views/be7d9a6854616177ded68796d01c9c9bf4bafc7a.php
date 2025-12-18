

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
                    <label for="item_select_1" class="form-label"><?php echo e(__('Select Item')); ?> <span class="text-danger">*</span></label>
                    <select class="form-control item-select select2-item" id="item_select_1" name="items[1][item_id]" data-index="1">
                        <option value=""><?php echo e(__('Select Item')); ?></option>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>" 
                                    data-description="<?php echo e($item->description); ?>"
                                    data-image-url="<?php echo e($item->image ? asset('storage/' . $item->image) : ''); ?>"
                                    data-has-image="<?php echo e($item->image ? 'true' : 'false'); ?>">
                                <?php echo e($item->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="item_description_1" class="form-label"><?php echo e(__('Item Description')); ?> <span class="text-danger">*</span></label>
                    <textarea class="form-control item-description" id="item_description_1" name="items[1][description]" rows="3" placeholder="<?php echo e(__('Item description...')); ?>" required><?php echo e(old('items.1.description')); ?></textarea>
                    <small class="text-muted">Description will auto-fill when you select an item</small>
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
                        <input type="file" class="form-control item-image" id="item_image_1" name="items[1][image]" accept="image/*" onchange="previewImage(this, 'imagePreview_1')">
                        <button type="button" class="btn btn-outline-primary pick-image-btn" data-target="item_image_1">
                            <i class="ti ti-plus"></i> <?php echo e(__('Pick Image')); ?>

                        </button>
                    </div>
                    <div id="file-name-1" class="mt-1 small text-muted"></div>
                    <small class="text-muted">Optional - Upload item image if needed</small>
                    
                    <!-- Image Preview Area -->
                    <div class="mt-2" id="imagePreviewArea_1">
                        <div class="image-preview-container">
                            <div class="existing-image-preview" id="existingImagePreview_1" style="display: none;">
                                <p class="small text-muted mb-1">Existing Item Image:</p>
                                <img id="existingImage_1" src="" alt="Existing Image" style="max-width: 150px; max-height: 150px; border: 1px solid #ddd; border-radius: 4px; padding: 3px;">
                                <button type="button" class="btn btn-sm btn-info mt-1" onclick="testImageUrl('existingImage_1')">Test URL</button>
                            </div>
                            <div class="uploaded-image-preview" id="uploadedImagePreview_1" style="display: none;">
                                <p class="small text-muted mb-1">Uploaded Image Preview:</p>
                                <img id="uploadedImage_1" src="" alt="Uploaded Image Preview" style="max-width: 150px; max-height: 150px; border: 1px solid #ddd; border-radius: 4px; padding: 3px;">
                                <button type="button" class="btn btn-sm btn-danger mt-1" onclick="removeUploadedImage('item_image_1', 'uploadedImagePreview_1')">Remove</button>
                            </div>
                        </div>
                    </div>
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
    
    /* Image preview styling */
    .image-preview-container img {
        max-width: 150px;
        max-height: 150px;
        object-fit: contain;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 3px;
        background-color: #f9f9f9;
    }
    
    .image-preview-container {
        margin-top: 10px;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 4px;
        border: 1px dashed #dee2e6;
    }
    
    .image-preview-container p {
        margin-bottom: 5px;
        font-size: 0.85rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        console.log('Enquiry form loaded');
        
        // Test function to check image URL
        window.testImageUrl = function(imageId) {
            const img = document.getElementById(imageId);
            console.log('Testing image URL:', img.src);
            window.open(img.src, '_blank');
        };

        // Initialize Select2 for main dropdowns
        $('.select2').select2({
            width: '100%',
            placeholder: "Select an option",
            allowClear: true
        });

        // Initialize Select2 for item dropdowns
        function initializeItemSelect2(selector) {
            $(selector).select2({
                width: '100%',
                placeholder: "Select an item",
                allowClear: true,
                tags: true,
                createTag: function (params) {
                    return {
                        id: params.term,
                        text: params.term + ' (New)',
                        newOption: true
                    }
                }
            });
        }

        // Initialize existing item dropdown
        initializeItemSelect2('.select2-item');

        // Set today's date as default for enquiry date
        $('#enquiry_date').val(new Date().toISOString().split('T')[0]);

        // Global item counter
        let itemCount = 1;

        // Function to preview uploaded image
        function previewImage(input, previewId) {
            const previewContainerId = 'uploadedImagePreview_' + previewId.split('_')[1];
            const previewImgId = 'uploadedImage_' + previewId.split('_')[1];
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Hide existing image if showing
                    $('#existingImagePreview_' + previewId.split('_')[1]).hide();
                    
                    // Show uploaded image preview
                    $('#' + previewImgId).attr('src', e.target.result);
                    $('#' + previewContainerId).show();
                }
                
                reader.readAsDataURL(input.files[0]);
                
                // Display filename
                const fileName = input.files[0].name;
                const index = previewId.split('_')[1];
                $('#file-name-' + index).html('<i class="ti ti-check text-success"></i> ' + fileName.substring(0, 25) + (fileName.length > 25 ? '...' : ''));
            }
        }

        // Function to remove uploaded image
        window.removeUploadedImage = function(inputId, previewId) {
            $('#' + inputId).val('');
            $('#' + previewId).hide();
            const index = inputId.split('_')[2];
            $('#file-name-' + index).html('');
        }

        // Pick image button click
        $(document).on('click', '.pick-image-btn', function() {
            const targetId = $(this).data('target');
            $('#' + targetId).click();
        });

        // Display selected image filename and preview
        $(document).on('change', '.item-image', function() {
            const idParts = $(this).attr('id').split('_');
            const index = idParts.length > 2 ? idParts[2] : 1;
            previewImage(this, 'imagePreview_' + index);
        });

        // When item is selected from dropdown - DEBUG VERSION
        $(document).on('change', '.item-select', function() {
            const index = $(this).data('index');
            const selectedOption = $(this).find('option:selected');
            const description = selectedOption.data('description');
            const imageUrl = selectedOption.data('image-url');
            const hasImage = selectedOption.data('has-image') === 'true';
            
            console.log('================== ITEM SELECTED ==================');
            console.log('Index:', index);
            console.log('Item ID:', $(this).val());
            console.log('Description:', description);
            console.log('Image URL:', imageUrl);
            console.log('Has Image:', hasImage);
            console.log('Selected Option HTML:', selectedOption[0].outerHTML);
            
            // Log all data attributes
            const allData = selectedOption.data();
            console.log('All data attributes:', allData);
            
            // Auto-fill description if available
            if (description && description.trim() !== '') {
                $('#item_description_' + index).val(description);
                console.log('Description filled');
            } else {
                $('#item_description_' + index).val('');
                console.log('No description available');
            }
            
            // Show/hide existing image preview
            const existingImagePreview = $('#existingImagePreview_' + index);
            const existingImage = $('#existingImage_' + index);
            const uploadedImagePreview = $('#uploadedImagePreview_' + index);
            
            if (hasImage && imageUrl) {
                console.log('Attempting to show image preview');
                console.log('Image URL to set:', imageUrl);
                
                // Set image source
                existingImage.attr('src', imageUrl);
                
                // Add error handler for image
                existingImage.on('error', function() {
                    console.error('Image failed to load:', imageUrl);
                    console.log('Trying alternative path...');
                    
                    // Try alternative path without 'storage/'
                    const altImageUrl = imageUrl.replace('/storage/', '/');
                    existingImage.attr('src', altImageUrl);
                    console.log('Trying alternative URL:', altImageUrl);
                    
                    // If still fails, try direct URL
                    existingImage.on('error', function() {
                        console.error('Alternative image also failed to load');
                        existingImagePreview.hide();
                    });
                });
                
                // Add load handler
                existingImage.on('load', function() {
                    console.log('Image loaded successfully:', imageUrl);
                    existingImagePreview.show();
                    uploadedImagePreview.hide();
                });
                
                // Show the preview
                existingImagePreview.show();
                uploadedImagePreview.hide();
                
                console.log('Image preview should be visible now');
            } else {
                console.log('No image to show - hiding preview');
                existingImagePreview.hide();
            }
            
            // If it's a custom entry (typed by user)
            if ($(this).val() && !$(this).find('option[value="' + $(this).val() + '"]').length) {
                $('#item_description_' + index).val('');
                $('#item_description_' + index).attr('placeholder', 'Enter description for the new item');
                existingImagePreview.hide();
                console.log('Custom entry detected');
            }
            
            console.log('================== END ITEM SELECTION ==================');
        });

        // Add item functionality
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
                                <label for="item_select_${itemCount}" class="form-label"><?php echo e(__('Select Item')); ?> <span class="text-danger">*</span></label>
                                <select class="form-control item-select select2-item" id="item_select_${itemCount}" name="items[${itemCount}][item_id]" data-index="${itemCount}">
                                    <option value=""><?php echo e(__('Select Item')); ?></option>
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>" 
                                                data-description="<?php echo e($item->description); ?>"
                                                data-image-url="<?php echo e($item->image ? asset('storage/' . $item->image) : ''); ?>"
                                                data-has-image="<?php echo e($item->image ? 'true' : 'false'); ?>">
                                            <?php echo e($item->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <label for="item_description_${itemCount}" class="form-label"><?php echo e(__('Item Description')); ?> <span class="text-danger">*</span></label>
                                <textarea class="form-control item-description" id="item_description_${itemCount}" name="items[${itemCount}][description]" rows="3" placeholder="<?php echo e(__('Item description...')); ?>" required></textarea>
                                <small class="text-muted">Description will auto-fill when you select an item</small>
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
                                    <input type="file" class="form-control item-image" id="item_image_${itemCount}" name="items[${itemCount}][image]" accept="image/*" onchange="previewImage(this, 'imagePreview_${itemCount}')">
                                    <button type="button" class="btn btn-outline-primary pick-image-btn" data-target="item_image_${itemCount}">
                                        <i class="ti ti-plus"></i> <?php echo e(__('Pick Image')); ?>

                                    </button>
                                </div>
                                <div id="file-name-${itemCount}" class="mt-1 small text-muted"></div>
                                <small class="text-muted">Optional - Upload item image if needed</small>
                                
                                <!-- Image Preview Area -->
                                <div class="mt-2" id="imagePreviewArea_${itemCount}">
                                    <div class="image-preview-container">
                                        <div class="existing-image-preview" id="existingImagePreview_${itemCount}" style="display: none;">
                                            <p class="small text-muted mb-1">Existing Item Image:</p>
                                            <img id="existingImage_${itemCount}" src="" alt="Existing Image" style="max-width: 150px; max-height: 150px; border: 1px solid #ddd; border-radius: 4px; padding: 3px;">
                                            <button type="button" class="btn btn-sm btn-info mt-1" onclick="testImageUrl('existingImage_${itemCount}')">Test URL</button>
                                        </div>
                                        <div class="uploaded-image-preview" id="uploadedImagePreview_${itemCount}" style="display: none;">
                                            <p class="small text-muted mb-1">Uploaded Image Preview:</p>
                                            <img id="uploadedImage_${itemCount}" src="" alt="Uploaded Image Preview" style="max-width: 150px; max-height: 150px; border: 1px solid #ddd; border-radius: 4px; padding: 3px;">
                                            <button type="button" class="btn btn-sm btn-danger mt-1" onclick="removeUploadedImage('item_image_${itemCount}', 'uploadedImagePreview_${itemCount}')">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            $('#items-container').append(newItem);
            
            // Initialize Select2 for new item dropdown
            initializeItemSelect2('#item_select_' + itemCount);
            
            // Show remove button for all items when more than 1
            $('.remove-item-btn').show();
            
            console.log('New item added with index:', itemCount);
        });

        // Remove item functionality
        $(document).on('click', '.remove-item-btn', function(e) {
            e.preventDefault();
            
            if ($('.item-row').length <= 1) {
                alert('At least one item is required.');
                return;
            }
            
            // Remove the clicked item
            $(this).closest('.item-row').remove();
            
            // Renumber remaining items
            renumberItems();
            
            console.log('Item removed, total items now:', $('.item-row').length);
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
                
                // Update item select field
                $row.find('.item-select').attr({
                    'name': `items[${newIndex}][item_id]`,
                    'id': `item_select_${newIndex}`,
                    'data-index': newIndex
                });
                
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
                    'id': `item_image_${newIndex}`,
                    'onchange': `previewImage(this, 'imagePreview_${newIndex}')`
                });
                
                // Update pick image button
                $row.find('.pick-image-btn').data('target', `item_image_${newIndex}`);
                
                // Update file name display
                $row.find('.small.text-muted').attr('id', `file-name-${newIndex}`);
                
                // Update image preview containers
                $row.find('.existing-image-preview').attr('id', `existingImagePreview_${newIndex}`);
                $row.find('.existing-image-preview img').attr('id', `existingImage_${newIndex}`);
                $row.find('.uploaded-image-preview').attr('id', `uploadedImagePreview_${newIndex}`);
                $row.find('.uploaded-image-preview img').attr('id', `uploadedImage_${newIndex}`);
                $row.find('.uploaded-image-preview button').attr('onclick', `removeUploadedImage('item_image_${newIndex}', 'uploadedImagePreview_${newIndex}')`);
            });
            
            // Update global counter
            itemCount = newIndex;
            console.log('Items renumbered, new count:', itemCount);
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
                const itemSelect = $(this).find('.item-select').val();
                const description = $(this).find('.item-description').val().trim();
                const quantity = $(this).find('.item-qty').val().trim();
                
                if (!itemSelect && !description) {
                    itemErrors.push(`Item ${itemNumber}: Please select an item or enter description`);
                } else {
                    hasValidItem = true;
                }
                
                if (!description) {
                    itemErrors.push(`Item ${itemNumber}: Description is required`);
                }
                
                if (!quantity || quantity < 1) {
                    itemErrors.push(`Item ${itemNumber}: Quantity must be at least 1`);
                }
            });
            
            if (!hasValidItem) {
                e.preventDefault();
                alert('Please add at least one valid item.');
                return false;
            }
            
            if (itemErrors.length > 0) {
                e.preventDefault();
                alert('Please fix the following errors:\n\n' + itemErrors.join('\n'));
                return false;
            }
            
            return true;
        });
        
        // Debug: Check all option data attributes on load
        console.log('Checking all item options on page load:');
        $('.item-select option').each(function(index) {
            const $option = $(this);
            if ($option.val()) {
                console.log(`Option ${index}:`, {
                    value: $option.val(),
                    text: $option.text(),
                    description: $option.data('description'),
                    imageUrl: $option.data('image-url'),
                    hasImage: $option.data('has-image')
                });
            }
        });
        
        // Initialize existing image previews if any
        $('.item-select').each(function() {
            const index = $(this).data('index');
            const selectedOption = $(this).find('option:selected');
            const imageUrl = selectedOption.data('image-url');
            const hasImage = selectedOption.data('has-image') === 'true';
            
            if (hasImage && imageUrl) {
                console.log('Initializing preview for item', index, 'with URL:', imageUrl);
                $('#existingImage_' + index).attr('src', imageUrl);
                $('#existingImagePreview_' + index).show();
            }
        });
        
        // Add a test button for debugging
        $('body').append(`
            <div style="position: fixed; bottom: 10px; right: 10px; z-index: 9999;">
                <button onclick="testAllImages()" class="btn btn-warning btn-sm">Debug Images</button>
            </div>
        `);
    });
    
    // Global debug function
    window.testAllImages = function() {
        console.log('=== DEBUGGING ALL IMAGES ===');
        $('.existing-image-preview img').each(function(index) {
            const $img = $(this);
            console.log(`Image ${index}:`, {
                id: $img.attr('id'),
                src: $img.attr('src'),
                visible: $img.is(':visible'),
                parentVisible: $img.parent().is(':visible')
            });
        });
        
        // Test if storage link exists
        fetch('/storage/items/1765727407_item.jpg')
            .then(response => {
                console.log('Image test response:', response.status, response.statusText);
                if (response.ok) {
                    console.log('✓ Storage link works!');
                } else {
                    console.log('✗ Storage link failed:', response.status);
                }
            })
            .catch(error => {
                console.error('Image test error:', error);
            });
    };
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-github\resources\views/enquiry/create.blade.php ENDPATH**/ ?>