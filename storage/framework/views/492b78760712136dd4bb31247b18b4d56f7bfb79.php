
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Role')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Role')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
<div class="float-end">
    <div class="d-flex flex-wrap gap-2 justify-content-end align-items-center">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-buttons','data' => ['tableId' => 'rolesTable','createButton' => true,'createRoute' => ''.e(route('roles.create')).'','createPermission' => 'create roles','createLabel' => 'New roles','createIcon' => 'ti-plus','createTooltip' => 'Create New roles','columns' => [
            ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Role', 'description' => 'Company name'],
            ['index' => 2, 'name' => 'Description', 'description' => 'Email address'],
            ['index' => 3, 'name' => 'Permissions', 'description' => 'Mobile number'],
            ['index' => 4, 'name' => 'Status', 'description' => 'Active/Inactive status'],
            ['index' => 5, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'rolesTable','createButton' => true,'createRoute' => ''.e(route('roles.create')).'','createPermission' => 'create roles','createLabel' => 'New roles','createIcon' => 'ti-plus','createTooltip' => 'Create New roles','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Role', 'description' => 'Company name'],
            ['index' => 2, 'name' => 'Description', 'description' => 'Email address'],
            ['index' => 3, 'name' => 'Permissions', 'description' => 'Mobile number'],
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
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table " id="rolesTable">
                        <thead>
                        <tr>
                            <th><?php echo e(__('Role')); ?></th>
                            <th><?php echo e(__('Description')); ?></th>
                            <!-- <th><?php echo e(__('Permissions')); ?></th> -->
                            <th><?php echo e(__('Status')); ?></th>
                            <th width="200"><?php echo e(__('Action')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($role->name != 'client'): ?>
                                <tr class="font-style">
                                    <td class="Role"><?php echo e($role->name); ?></td>
                                    <td class="Description">
                                        <?php if($role->description): ?>
                                            <span class="text-muted" data-bs-toggle="tooltip" title="<?php echo e($role->description); ?>">
                                                <?php echo e(Str::limit($role->description, 50)); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">Not available</span>
                                        <?php endif; ?>
                                    </td>
                                    <!-- <td class="Permission">
                                        <?php if($role->permissions->count() > 0): ?>
                                            <?php $__currentLoopData = $role->permissions->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge rounded-pill bg-primary mb-1"><?php echo e($permission->name); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($role->permissions->count() > 3): ?>
                                                <span class="badge rounded-pill bg-secondary" data-bs-toggle="tooltip" 
                                                    title="<?php echo e($role->permissions->skip(3)->pluck('name')->implode(', ')); ?>">
                                                    +<?php echo e($role->permissions->count() - 3); ?>

                                                </span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted"><?php echo e(__('No permissions')); ?></span>
                                        <?php endif; ?>
                                    </td> -->
                                    <td class="Status">
                                        <span class="badge bg-success"><?php echo e(__('Active')); ?></span>
                                    </td>
                                    <td class="Action">
                                        <span>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit role')): ?>
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="<?php echo e(route('roles.edit', $role->id)); ?>" 
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                    data-bs-toggle="tooltip" 
                                                    title="<?php echo e(__('Edit')); ?>">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            <?php endif; ?>

                                            <?php if($role->name != 'Employee'): ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete role')): ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id],'id'=>'delete-form-'.$role->id]); ?>

                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" 
                                                        data-bs-toggle="tooltip" 
                                                        title="<?php echo e(__('Delete')); ?>" 
                                                        data-confirm="<?php echo e(__('Are You Sure?')); ?>" 
                                                        data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>" 
                                                        data-confirm-yes="delete-form-<?php echo e($role->id); ?>">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                        <?php echo Form::close(); ?>

                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endif; ?>
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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WORK GPT\Github repo\savantec-erp\resources\views/role/index.blade.php ENDPATH**/ ?>