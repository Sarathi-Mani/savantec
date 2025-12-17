
<?php
   // $profile=asset(Storage::url('uploads/avatar/'));
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Company')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Company')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('company.create')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                 
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Email')); ?></th>
                                    <th><?php echo e(__('Mobile')); ?></th>
                                  <th><?php echo e(__('Details')); ?></th>
                                  
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                       
                                        <td><?php echo e($company->name); ?></td>
                                        <td><?php echo e($company->email); ?></td>
                                        <td><?php echo e($company->mobile ?? '-'); ?></td>
                                        <td><?php echo e($company->details ?? '-'); ?></td>
                                        <td>
                                            <?php if($company->delete_status==0): ?>
                                                <span class="badge bg-danger"><?php echo e(__('Inactive')); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-success"><?php echo e(__('Active')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($company->is_active == 1): ?>
                                                <div class="d-flex">
                                                    <div class="action-btn bg-light-secondary ms-2">
                                                        <a href="<?php echo e(route('company.edit', $company->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>">
                                                            <i class="ti ti-pencil text-dark"></i>
                                                        </a>
                                                    </div>
                                                  
                                                </div>
                                            <?php else: ?>
                                                <a href="#" class="btn btn-sm btn-light-secondary"><i class="ti ti-lock"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Add click event for delete buttons
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

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-erp\resources\views/company/index.blade.php ENDPATH**/ ?>