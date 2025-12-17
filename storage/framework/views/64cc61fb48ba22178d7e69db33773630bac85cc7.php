

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Brand')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('brands.index')); ?>"><?php echo e(__('Brands')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Edit')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><?php echo e(__('Edit Brand')); ?></h5>
                        <a href="<?php echo e(route('brands.index')); ?>" class="btn btn-sm btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i> <?php echo e(__('Back')); ?>

                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('brands.update', $brand->id)); ?>" id="brandForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <!-- Simple Form with only 2 inputs (same as create) -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Brand Name -->
                                <div class="form-group mb-4">
                                    <label for="name" class="form-label">
                                        <strong><?php echo e(__('Brand Name')); ?> <span class="text-danger">*</span></strong>
                                    </label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="name" name="name" required 
                                           placeholder="Enter brand name" 
                                           value="<?php echo e(old('name', $brand->name)); ?>">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">
                                        <?php echo e(__('Enter the name of the brand (e.g., Apple, Samsung, Nike)')); ?>

                                    </small>
                                </div>

                                <!-- Brand Description -->
                                <div class="form-group mb-4">
                                    <label for="description" class="form-label">
                                        <strong><?php echo e(__('Description')); ?></strong>
                                    </label>
                                    <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                              id="description" name="description" 
                                              rows="5" 
                                              placeholder="Enter brand description (optional)"><?php echo e(old('description', $brand->description)); ?></textarea>
                                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">
                                        <?php echo e(__('Describe the brand, its products, quality, etc.')); ?>

                                    </small>
                                </div>

                               
                                <!-- Submit Button -->
                                <div class="form-group mt-5">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a href="<?php echo e(route('brands.index')); ?>" class="btn btn-secondary px-4 me-2">
                                                <i class="ti ti-x me-1"></i> <?php echo e(__('Cancel')); ?>

                                            </a>
                                            <?php if(\Auth::user()->can('brand_delete')): ?>
                                                <button type="button" class="btn btn-danger px-4" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                    <i class="ti ti-trash me-1"></i> <?php echo e(__('Delete')); ?>

                                                </button>
                                            <?php endif; ?>
                                        </div>
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="ti ti-check me-1"></i> <?php echo e(__('Update Brand')); ?>

                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <?php if(\Auth::user()->can('brand_delete')): ?>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel"><?php echo e(__('Delete Brand')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo e(__('Are you sure you want to delete this brand?')); ?></p>
                    <p class="text-danger"><strong><?php echo e(__('Warning:')); ?></strong> <?php echo e(__('This action cannot be undone.')); ?></p>
                    
                    <?php
                        $itemCount = \App\Models\Items::where('brand', $brand->name)
                            ->where('created_by', Auth::user()->creatorId())
                            ->count();
                    ?>
                    
                    <?php if($itemCount > 0): ?>
                        <div class="alert alert-warning mt-3">
                            <i class="ti ti-alert-triangle me-2"></i>
                            <?php echo e(__('This brand is being used in :count items. You cannot delete it until you remove or reassign these items.', ['count' => $itemCount])); ?>

                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                    <?php if($itemCount == 0): ?>
                        <form action="<?php echo e(route('brands.destroy', $brand->id)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger"><?php echo e(__('Delete Brand')); ?></button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 0.95rem;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }
    
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: none;
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 1rem 1.5rem;
        border-bottom: none;
    }
    
    .card-title {
        color: white;
        font-weight: 600;
        font-size: 1rem;
        margin: 0;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border: none;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
    }
    
    .btn-secondary {
        border: 1px solid #e2e8f0;
        background: white;
        color: #4a5568;
    }
    
    .btn-secondary:hover {
        background: #f8f9fa;
        border-color: #cbd5e0;
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(239, 68, 68, 0.4);
    }
    
    .form-text {
        font-size: 0.8rem;
        color: #718096;
        margin-top: 4px;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }
    
    .badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
    }
    
    .text-primary {
        color: #3b82f6 !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        
        .btn {
            padding: 8px 16px;
            font-size: 0.9rem;
        }
        
        .form-control {
            padding: 10px 12px;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 10px;
        }
        
        .d-flex.justify-content-between > div {
            width: 100%;
            display: flex;
            gap: 10px;
        }
        
        .d-flex.justify-content-between > div .btn {
            flex: 1;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        // Form validation
        $('#brandForm').on('submit', function(e) {
            let isValid = true;
            
            // Check brand name
            const brandName = $('#name').val().trim();
            if (!brandName) {
                $('#name').addClass('is-invalid');
                $('#name').next('.invalid-feedback').remove();
                $('#name').after('<div class="invalid-feedback">Brand name is required</div>');
                isValid = false;
            } else {
                $('#name').removeClass('is-invalid');
            }
            
            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                $('html, body').animate({
                    scrollTop: $('.is-invalid').first().offset().top - 100
                }, 500);
            }
        });
        
        // Remove validation on input
        $('#name').on('input', function() {
            $(this).removeClass('is-invalid');
        });
        
        // Auto-focus on brand name field
        $('#name').focus();
        
        // Character counter for description
        $('#description').on('input', function() {
            const length = $(this).val().length;
            const counter = $(this).next('.char-counter');
            if (counter.length === 0) {
                $(this).after('<small class="char-counter text-muted float-end mt-1">0/1000</small>');
            }
            $(this).next('.char-counter').text(length + '/1000');
        });
        
        // Initialize character counter on page load
        const descLength = $('#description').val().length;
        $('#description').after('<small class="char-counter text-muted float-end mt-1">' + descLength + '/1000</small>');
        
        // Delete modal confirmation
        $('#deleteModal').on('show.bs.modal', function(event) {
            // Any additional logic before showing delete modal
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WORK GPT\Github repo\savantec-erp\resources\views/brands/edit.blade.php ENDPATH**/ ?>