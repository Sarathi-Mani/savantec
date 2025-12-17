
<?php
    // Use the Utility helper function to get the correct file path
    $profile = \App\Models\Utility::get_file('uploads/avatar');
    
    // Determine if user is super admin
    $isSuperAdmin = \Auth::user()->type == 'super admin';
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage User')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('User')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-buttons','data' => ['tableId' => 'userTable','createButton' => true,'createRoute' => ''.e(route('users.create')).'','createPermission' => 'create user','createLabel' => 'New User','createIcon' => 'ti-plus','createTooltip' => 'Create New User','columns' => [
            ['index' => 0, 'name' => 'Name', 'description' => 'User name and avatar'],
            ['index' => 1, 'name' => 'Email', 'description' => 'Email address'],
            ['index' => 2, 'name' => 'Type', 'description' => 'User type/role'],
            ['index' => 3, 'name' => 'Last Login', 'description' => 'Last login date'],
            ['index' => 4, 'name' => 'Status', 'description' => 'Active/Inactive status'],
            ['index' => 5, 'name' => 'Plan', 'description' => 'Subscription plan'],
            ['index' => 6, 'name' => 'Plan Expired', 'description' => 'Plan expiry date'],
            ['index' => 7, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'userTable','createButton' => true,'createRoute' => ''.e(route('users.create')).'','createPermission' => 'create user','createLabel' => 'New User','createIcon' => 'ti-plus','createTooltip' => 'Create New User','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['index' => 0, 'name' => 'Name', 'description' => 'User name and avatar'],
            ['index' => 1, 'name' => 'Email', 'description' => 'Email address'],
            ['index' => 2, 'name' => 'Type', 'description' => 'User type/role'],
            ['index' => 3, 'name' => 'Last Login', 'description' => 'Last login date'],
            ['index' => 4, 'name' => 'Status', 'description' => 'Active/Inactive status'],
            ['index' => 5, 'name' => 'Plan', 'description' => 'Subscription plan'],
            ['index' => 6, 'name' => 'Plan Expired', 'description' => 'Plan expiry date'],
            ['index' => 7, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
        ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'HR'): ?>
                        <div class="mb-3">
                            <a href="<?php echo e(route('user.userlog')); ?>" 
                               class="btn btn-outline-primary btn-sm <?php echo e(Request::segment(1) == 'user'); ?>"
                               data-bs-toggle="tooltip" 
                               data-bs-placement="top" 
                               title="<?php echo e(__('User Logs History')); ?>">
                                <i class="ti ti-user-check me-1"></i> <?php echo e(__('User Logs History')); ?>

                            </a>
                        </div>
                    <?php endif; ?>
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
                        <table class="table w-100 " id="userTable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Email')); ?></th>
                                    <th><?php echo e(__('Type')); ?></th>
                                    <th><?php echo e(__('Last Login')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <?php if($isSuperAdmin): ?>
                                        <th><?php echo e(__('Plan')); ?></th>
                                        <th><?php echo e(__('Plan Expired')); ?></th>
                                    <?php endif; ?>
                                    <th width="150" class="text-center"><?php echo e(__('Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php
                                                    // Check if avatar exists and is not a URL
                                                    $avatarPath = $user->avatar;
                                                    $avatarUrl = null;
                                                    
                                                    if (!empty($avatarPath)) {
                                                        // Check if it's a full URL (for external storage like S3)
                                                        if (filter_var($avatarPath, FILTER_VALIDATE_URL)) {
                                                            $avatarUrl = $avatarPath;
                                                        } else {
                                                            // Check if it starts with 'uploads/avatar'
                                                            if (strpos($avatarPath, 'uploads/avatar/') === 0) {
                                                                $avatarUrl = asset(Storage::url($avatarPath));
                                                            } else {
                                                                // Try different possible paths
                                                                $possiblePaths = [
                                                                    $avatarPath,
                                                                    'uploads/avatar/' . $avatarPath,
                                                                    'avatar/' . $avatarPath
                                                                ];
                                                                
                                                                foreach ($possiblePaths as $path) {
                                                                    if (Storage::exists($path) || Storage::disk('public')->exists($path)) {
                                                                        $avatarUrl = asset(Storage::url($path));
                                                                        break;
                                                                    }
                                                                }
                                                                
                                                                // If still not found, use default
                                                                if (!$avatarUrl) {
                                                                    $avatarUrl = asset(Storage::url('uploads/avatar/avatar.png'));
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $avatarUrl = asset(Storage::url('uploads/avatar/avatar.png'));
                                                    }
                                                ?>
                                                
                                                <img src="<?php echo e($avatarUrl); ?>" 
                                                     class="rounded-circle me-2" width="30" height="30" alt="<?php echo e($user->name); ?>">
                                                <?php echo e($user->name); ?>

                                            </div>
                                        </td>
                                        <td><?php echo e($user->email); ?></td>
                                        <td>
                                            <div class="badge bg-primary p-2 px-3 rounded">
                                                <?php echo e(ucfirst($user->type)); ?>

                                            </div>
                                        </td>
                                        <td><?php echo e(!empty($user->last_login_at) ? $user->last_login_at : '-'); ?></td>
                                        <td>
                                            <?php if($user->delete_status == 0): ?>
                                                <span class="badge bg-danger"><?php echo e(__('Inactive')); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-success"><?php echo e(__('Active')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <?php if($isSuperAdmin): ?>
                                            <td><?php echo e(!empty($user->currentPlan) ? $user->currentPlan->name : '-'); ?></td>
                                            <td><?php echo e(!empty($user->plan_expire_date) ? \Auth::user()->dateFormat($user->plan_expire_date) : __('Lifetime')); ?></td>
                                        <?php endif; ?>
                                        <td class="text-center">
                                            <?php if($user->is_active == 1): ?>
                                                <div class="d-flex justify-content-center">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit user')): ?>
                                                    <div class="action-btn bg-light-secondary ms-2">
                                                        <a href="<?php echo e(route('users.edit', $user->id)); ?>" 
                                                           class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                           data-bs-toggle="tooltip" 
                                                           title="<?php echo e(__('Edit')); ?>">
                                                            <i class="ti ti-pencil text-dark"></i>
                                                        </a>
                                                    </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete user')): ?>
                                                    <div class="action-btn bg-light-secondary ms-2">
                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'id' => 'delete-form-' . $user->id, 'class' => 'd-inline']); ?>

                                                        <a href="#!" 
                                                           class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" 
                                                           data-bs-toggle="tooltip" 
                                                           title="<?php if($user->delete_status != 0): ?><?php echo e(__('Delete')); ?><?php else: ?><?php echo e(__('Restore')); ?><?php endif; ?>" 
                                                           data-confirm="<?php echo e(__('Are You Sure?')); ?>" 
                                                           data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>" 
                                                           data-confirm-yes="delete-form-<?php echo e($user->id); ?>">
                                                            <i class="ti ti-archive text-dark"></i>
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
                                        <td colspan="<?php echo e($isSuperAdmin ? 8 : 6); ?>" class="text-center">
                                            <div class="alert alert-info d-inline-flex align-items-center">
                                                <i class="ti ti-info-circle me-2"></i>
                                                <?php echo e(__('No users found.')); ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create user')): ?>
                                                <a href="<?php echo e(route('users.create')); ?>" class="alert-link ms-1">
                                                    <?php echo e(__('Create your first user')); ?>

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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-scripts','data' => ['tableId' => 'userTable','searchPlaceholder' => 'Search users...','pdfTitle' => 'Users']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-scripts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'userTable','searchPlaceholder' => 'Search users...','pdfTitle' => 'Users']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WORK GPT\Github repo\savantec-erp\resources\views/user/index.blade.php ENDPATH**/ ?>