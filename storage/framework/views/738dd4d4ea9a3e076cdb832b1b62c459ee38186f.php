
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Role')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Role')); ?></li>p
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
<div class="float-end">
    <div class="d-flex flex-wrap gap-2 justify-content-end align-items-center">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-buttons','data' => ['tableId' => 'rolesTable','createButton' => true,'createRoute' => ''.e(route('roles.create')).'','createPermission' => 'create roles','createLabel' => 'New Role','createIcon' => 'ti-plus','createTooltip' => 'Create New Role','columns' => [
                ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
                ['index' => 1, 'name' => 'Role', 'description' => 'Role name'],
                ['index' => 2, 'name' => 'Description', 'description' => 'Role description'],
                ['index' => 3, 'name' => 'Status', 'description' => 'Active status'],
                ['index' => 4, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'rolesTable','createButton' => true,'createRoute' => ''.e(route('roles.create')).'','createPermission' => 'create roles','createLabel' => 'New Role','createIcon' => 'ti-plus','createTooltip' => 'Create New Role','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
                ['index' => 1, 'name' => 'Role', 'description' => 'Role name'],
                ['index' => 2, 'name' => 'Description', 'description' => 'Role description'],
                ['index' => 3, 'name' => 'Status', 'description' => 'Active status'],
                ['index' => 4, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
            ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        
        <div class="ms-md-2">
            <a href="<?php echo e(route('roles.create')); ?>" 
               data-bs-toggle="tooltip" title="<?php echo e(__('Create New Role')); ?>" 
               class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i> <?php echo e(__('New Role')); ?>

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
                        <table class="table w-100" id="rolesTable">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center"><?php echo e(__('#')); ?></th>
                                    <th><?php echo e(__('Role')); ?></th>
                                    <th><?php echo e(__('Description')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th width="150" class="text-center"><?php echo e(__('Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php if($role->name != 'client'): ?>
                                        <tr>
                                            <td class="text-center"><?php echo e($key + 1); ?></td>
                                            <td><?php echo e($role->name); ?></td>
                                            <td>
                                                <?php if($role->description): ?>
                                                    <span class="text-muted" data-bs-toggle="tooltip" title="<?php echo e($role->description); ?>">
                                                        <?php echo e(Str::limit($role->description, 50)); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted"><?php echo e(__('Not available')); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success"><?php echo e(__('Active')); ?></span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit role')): ?>
                                                    <div class="action-btn bg-light-secondary ms-2">
                                                        <a href="<?php echo e(route('roles.edit', $role->id)); ?>" 
                                                           class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                           data-bs-toggle="tooltip" 
                                                           title="<?php echo e(__('Edit')); ?>">
                                                            <i class="ti ti-pencil text-dark"></i>
                                                        </a>
                                                    </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if($role->name != 'Employee'): ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete role')): ?>
                                                        <div class="action-btn bg-light-secondary ms-2">
                                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'id' => 'delete-form-' . $role->id, 'class' => 'd-inline']); ?>

                                                            <a href="#!" 
                                                               class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" 
                                                               data-bs-toggle="tooltip" 
                                                               title="<?php echo e(__('Delete')); ?>" 
                                                               data-confirm="<?php echo e(__('Are You Sure?')); ?>" 
                                                               data-text="<?php echo e(__('This action will permanently delete the role. Do you want to continue?')); ?>" 
                                                               data-confirm-yes="delete-form-<?php echo e($role->id); ?>">
                                                                <i class="ti ti-trash text-danger"></i>
                                                            </a>
                                                            <?php echo Form::close(); ?>

                                                        </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <div class="alert alert-info d-inline-flex align-items-center">
                                                <i class="ti ti-info-circle me-2"></i>
                                                <?php echo e(__('No roles found.')); ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create roles')): ?>
                                                <a href="<?php echo e(route('roles.create')); ?>" class="alert-link ms-1">
                                                    <?php echo e(__('Create your first role')); ?>

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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-scripts','data' => ['tableId' => 'rolesTable','searchPlaceholder' => 'Search roles...','pdfTitle' => 'Roles']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-scripts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'rolesTable','searchPlaceholder' => 'Search roles...','pdfTitle' => 'Roles']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-github\resources\views/role/index.blade.php ENDPATH**/ ?>