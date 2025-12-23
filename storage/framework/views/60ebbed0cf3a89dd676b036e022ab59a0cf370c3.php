
<?php
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Company')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Company')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('action-btn'); ?>
    
<div class="float-end">
    <div class="d-flex flex-wrap gap-2 justify-content-end align-items-center">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-buttons','data' => ['tableId' => 'companyTable','createButton' => true,'createRoute' => ''.e(route('company.create')).'','createPermission' => 'create company','createLabel' => 'New Company','createIcon' => 'ti-plus','createTooltip' => 'Create New Company','columns' => [
                ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
                ['index' => 1, 'name' => 'Name', 'description' => 'Company name'],
                ['index' => 2, 'name' => 'Email', 'description' => 'Email address'],
                ['index' => 3, 'name' => 'Mobile', 'description' => 'Mobile number'],
                ['index' => 4, 'name' => 'Status', 'description' => 'Active/Inactive status'],
                ['index' => 5, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'companyTable','createButton' => true,'createRoute' => ''.e(route('company.create')).'','createPermission' => 'create company','createLabel' => 'New Company','createIcon' => 'ti-plus','createTooltip' => 'Create New Company','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
                ['index' => 1, 'name' => 'Name', 'description' => 'Company name'],
                ['index' => 2, 'name' => 'Email', 'description' => 'Email address'],
                ['index' => 3, 'name' => 'Mobile', 'description' => 'Mobile number'],
                ['index' => 4, 'name' => 'Status', 'description' => 'Active/Inactive status'],
                ['index' => 5, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
            ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        
        <div class="ms-md-2">
            <a href="<?php echo e(route('company.create')); ?>" 
               data-bs-toggle="tooltip" title="<?php echo e(__('Create New Company')); ?>" 
               class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i> <?php echo e(__('New Company')); ?>

            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="ti ti-check-circle me-2"></i>
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="ti ti-alert-circle me-2"></i>
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="table-responsive">
                        <table class="table w-10 0 " id="companyTable">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center"><?php echo e(__('#')); ?></th>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Email')); ?></th>
                                    <th><?php echo e(__('Mobile')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th width="150" class="text-center"><?php echo e(__('Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="text-center"><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($company->name); ?></td>
                                        <td><?php echo e($company->email); ?></td>
                                        <td><?php echo e($company->mobile ?? '-'); ?></td>
                                        <td class="text-center">
                                            <?php if($company->delete_status == 0): ?>
                                                <span class="badge bg-danger"><?php echo e(__('Inactive')); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-success"><?php echo e(__('Active')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if($company->is_active == 1): ?>
                                                <div class="d-flex justify-content-center">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit company')): ?>
                                                    <div class="action-btn bg-light-secondary ms-2">
                                                        <a href="<?php echo e(route('company.edit', $company->id)); ?>" 
                                                           class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                           data-bs-toggle="tooltip" 
                                                           title="<?php echo e(__('Edit')); ?>">
                                                            <i class="ti ti-pencil text-dark"></i>
                                                        </a>
                                                    </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete company')): ?>
                                                    <div class="action-btn bg-light-secondary ms-2">
                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['company.destroy', $company->id], 'id' => 'delete-form-' . $company->id, 'class' => 'd-inline']); ?>

                                                        <a href="#!" 
                                                           class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" 
                                                           data-bs-toggle="tooltip" 
                                                           title="<?php echo e(__('Delete')); ?>" 
                                                           data-confirm="<?php echo e(__('Are You Sure?')); ?>" 
                                                           data-text="<?php echo e(__('This action will permanently delete the company. Do you want to continue?')); ?>" 
                                                           data-confirm-yes="delete-form-<?php echo e($company->id); ?>">
                                                            <i class="ti ti-trash text-danger"></i>
                                                        </a>
                                                        <?php echo Form::close(); ?>

                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted"><?php echo e(__('Locked')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="alert alert-info d-inline-flex align-items-center">
                                                <i class="ti ti-info-circle me-2"></i>
                                                <?php echo e(__('No companies found.')); ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create company')): ?>
                                                <a href="<?php echo e(route('company.create')); ?>" class="alert-link ms-1">
                                                    <?php echo e(__('Create your first company')); ?>

                                                </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-scripts','data' => ['tableId' => 'companyTable','searchPlaceholder' => 'Search companies...','pdfTitle' => 'Companies']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-scripts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'companyTable','searchPlaceholder' => 'Search companies...','pdfTitle' => 'Companies']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-github\resources\views/company/index.blade.php ENDPATH**/ ?>