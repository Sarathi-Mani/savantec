

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Item Variant')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('item-variants.index')); ?>"><?php echo e(__('Item Variants')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Edit')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="ti ti-edit me-2"></i><?php echo e(__('Edit Item Variant')); ?>

                        </h5>
                        <a href="<?php echo e(route('item-variants.index')); ?>" class="btn btn-sm btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i><?php echo e(__('Back')); ?>

                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('item-variants.update', $itemVariant->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="form-label"><?php echo e(__('Variant Name')); ?> <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" 
                                           class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('name', $itemVariant->name)); ?>" 
                                           placeholder="<?php echo e(__('Enter variant name')); ?>" 
                                           required>
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
                                </div>
                            </div>
                            
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="description" class="form-label"><?php echo e(__('Description')); ?></label>
                                    <textarea name="description" id="description" 
                                              class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                              rows="4" 
                                              placeholder="<?php echo e(__('Enter variant description (optional)')); ?>"><?php echo e(old('description', $itemVariant->description)); ?></textarea>
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
                                </div>
                            </div>
                            
                            <div class="col-md-12 mt-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-check me-1"></i> <?php echo e(__('Update Variant')); ?>

                                    </button>
                                  
                                    <a href="<?php echo e(route('item-variants.index')); ?>" class="btn btn-outline-secondary">
                                        <i class="ti ti-x me-1"></i> <?php echo e(__('Cancel')); ?>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php if($errors->any()): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    toastr.error('<?php echo e($error); ?>');
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            });
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WORK GPT\Github repo\savantec-erp\resources\views/item-variants/edit.blade.php ENDPATH**/ ?>