

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Create Company')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('company.index')); ?>"><?php echo e(__('Company')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Create')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?php echo e(__('Create New Company')); ?></h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('company.store')); ?>">
                        <?php echo csrf_field(); ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label"><?php echo e(__('Company Name')); ?> <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label"><?php echo e(__('Email')); ?> <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email')); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile" class="form-label"><?php echo e(__('Mobile')); ?></label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo e(old('mobile')); ?>">
                                </div>
                            </div>
                          
                        </div>

                        <div class="form-group text-end mt-4">
                            <button type="submit" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
                            <a href="<?php echo e(route('company.index')); ?>" class="btn btn-secondary"><?php echo e(__('Close')); ?></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-github\resources\views/company/create.blade.php ENDPATH**/ ?>