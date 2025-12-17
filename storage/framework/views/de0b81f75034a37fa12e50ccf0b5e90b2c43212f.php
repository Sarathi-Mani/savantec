

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Item Variants')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Item Variants')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-buttons','data' => ['tableId' => 'variantsTable','createButton' => true,'createRoute' => ''.e(route('item-variants.create')).'','createPermission' => 'variant_add','createLabel' => 'Add Variant','createIcon' => 'ti-plus','createTooltip' => 'Add New Variant','columns' => [
            ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Name', 'description' => 'Variant name'],
            ['index' => 2, 'name' => 'Description', 'description' => 'Variant description'],
            ['index' => 3, 'name' => 'Created At', 'description' => 'Creation date'],
            ['index' => 4, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'variantsTable','createButton' => true,'createRoute' => ''.e(route('item-variants.create')).'','createPermission' => 'variant_add','createLabel' => 'Add Variant','createIcon' => 'ti-plus','createTooltip' => 'Add New Variant','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Name', 'description' => 'Variant name'],
            ['index' => 2, 'name' => 'Description', 'description' => 'Variant description'],
            ['index' => 3, 'name' => 'Created At', 'description' => 'Creation date'],
            ['index' => 4, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
        ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
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
                    
                    <!-- Search and Filter Section -->
                    <!-- <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">
                                    <i class="ti ti-search"></i>
                                </span>
                                <input type="text" class="form-control" id="search-input" 
                                       placeholder="<?php echo e(__('Search variants...')); ?>">
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-sm btn-light" id="clear-filters">
                                <i class="ti ti-refresh me-1"></i> <?php echo e(__('Clear')); ?>

                            </button>
                        </div>
                    </div> -->
                    
                    <div class="table-responsive">
                        <table class="table w-100" id="variantsTable">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center"><?php echo e(__('#')); ?></th>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Description')); ?></th>
                                    <th><?php echo e(__('Created At')); ?></th>
                                    <th width="120" class="text-center"><?php echo e(__('Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="text-center"><?php echo e($key + 1); ?></td>
                                        <td>
                                            <strong><?php echo e($variant->name); ?></strong>
                                        </td>
                                        <td>
                                            <?php if($variant->description): ?>
                                                <span class="text-truncate d-inline-block" style="max-width: 300px;"
                                                      data-bs-toggle="tooltip" title="<?php echo e($variant->description); ?>">
                                                    <?php echo e(Str::limit($variant->description, 100)); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted"><?php echo e(__('No description')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo e($variant->created_at->format('d-m-Y H:i')); ?>

                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('variant_edit')): ?>
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="<?php echo e(route('item-variants.edit', $variant->id)); ?>" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="<?php echo e(__('Edit')); ?>">
                                                        <i class="ti ti-pencil text-dark"></i>
                                                    </a>
                                                </div>
                                                <?php endif; ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('variant_delete')): ?>
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['item-variants.destroy', $variant->id], 'id' => 'delete-form-' . $variant->id, 'class' => 'd-inline']); ?>

                                                    <a href="#!" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" 
                                                       data-bs-toggle="tooltip" 
                                                       title="<?php echo e(__('Delete')); ?>" 
                                                       data-confirm="<?php echo e(__('Are You Sure?')); ?>" 
                                                       data-text="<?php echo e(__('This action will permanently delete the variant. Do you want to continue?')); ?>" 
                                                       data-confirm-yes="delete-form-<?php echo e($variant->id); ?>">
                                                        <i class="ti ti-trash text-danger"></i>
                                                    </a>
                                                    <?php echo Form::close(); ?>

                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <div class="alert alert-info d-inline-flex align-items-center">
                                                <i class="ti ti-package-off me-2"></i>
                                                <?php echo e(__('No variants found.')); ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('variant_add')): ?>
                                                <a href="<?php echo e(route('item-variants.create')); ?>" class="alert-link ms-1">
                                                    <?php echo e(__('Create your first variant')); ?>

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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-scripts','data' => ['tableId' => 'variantsTable','searchPlaceholder' => 'Search variants...','pdfTitle' => 'Item Variants']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-scripts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'variantsTable','searchPlaceholder' => 'Search variants...','pdfTitle' => 'Item Variants']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    
    <script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        // Clear filters
        $('#clear-filters').on('click', function() {
            $('#search-input').val('');
            
            if (window.dataTables && window.dataTables['variantsTable']) {
                const table = window.dataTables['variantsTable'];
                table.search('').draw();
            }
        });
        
        // Real-time search
        let searchTimer;
        $('#search-input').on('keyup', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                if (window.dataTables && window.dataTables['variantsTable']) {
                    const table = window.dataTables['variantsTable'];
                    table.search($(this).val()).draw();
                }
            }, 300);
        });
    });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WORK GPT\Github repo\savantec-erp\resources\views/item-variants/index.blade.php ENDPATH**/ ?>