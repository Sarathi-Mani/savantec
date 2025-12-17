

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Categories')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Categories')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-buttons','data' => ['tableId' => 'categoriesTable','createButton' => true,'createRoute' => ''.e(route('categories.create')).'','createPermission' => 'item_category_add','createLabel' => 'New Category','createIcon' => 'ti-plus','createTooltip' => 'Create New Category','columns' => [
            ['index' => 0, 'name' => 'S.No', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Name', 'description' => 'Category name'],
            ['index' => 2, 'name' => 'Description', 'description' => 'Category description'],
            ['index' => 3, 'name' => 'Items', 'description' => 'Number of items in category'],
            ['index' => 4, 'name' => 'Status', 'description' => 'Active/Inactive status'],
            ['index' => 5, 'name' => 'Created At', 'description' => 'Creation date'],
            ['index' => 6, 'name' => 'Actions', 'description' => 'View/Edit/Delete actions']
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'categoriesTable','createButton' => true,'createRoute' => ''.e(route('categories.create')).'','createPermission' => 'item_category_add','createLabel' => 'New Category','createIcon' => 'ti-plus','createTooltip' => 'Create New Category','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['index' => 0, 'name' => 'S.No', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Name', 'description' => 'Category name'],
            ['index' => 2, 'name' => 'Description', 'description' => 'Category description'],
            ['index' => 3, 'name' => 'Items', 'description' => 'Number of items in category'],
            ['index' => 4, 'name' => 'Status', 'description' => 'Active/Inactive status'],
            ['index' => 5, 'name' => 'Created At', 'description' => 'Creation date'],
            ['index' => 6, 'name' => 'Actions', 'description' => 'View/Edit/Delete actions']
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
                        <div class="col-md-6">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">
                                    <i class="ti ti-search"></i>
                                </span>
                                <input type="text" class="form-control" id="search-input" 
                                       placeholder="<?php echo e(__('Search categories...')); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select form-select-sm" id="status-filter">
                                <option value=""><?php echo e(__('All Status')); ?></option>
                                <option value="1"><?php echo e(__('Active')); ?></option>
                                <option value="0"><?php echo e(__('Inactive')); ?></option>
                            </select>
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-sm btn-light" id="clear-filters">
                                <i class="ti ti-refresh me-1"></i> <?php echo e(__('Clear')); ?>

                            </button>
                        </div>
                    </div> -->
                    
                    <div class="table-responsive">
                        <table class="table w-100" id="categoriesTable">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center"><?php echo e(__('S.No')); ?></th>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Description')); ?></th>
                                    <th><?php echo e(__('Items')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Created At')); ?></th>
                                    <th width="150" class="text-center"><?php echo e(__('Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr data-category-id="<?php echo e($category->id); ?>" data-status="<?php echo e($category->status); ?>">
                                        <td class="text-center"><?php echo e($index + 1); ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="category-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                         style="width: 36px; height: 36px;">
                                                        <i class="ti ti-category"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <strong><?php echo e($category->name); ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?php echo e($category->slug); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($category->description): ?>
                                                <span class="text-truncate d-inline-block" style="max-width: 200px;"
                                                      data-bs-toggle="tooltip" title="<?php echo e($category->description); ?>">
                                                    <?php echo e(Str::limit($category->description, 50)); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?php echo e($category->item_count ?? 0); ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo e($category->status ? 'success' : 'danger'); ?>">
                                                <?php echo e($category->status ? __('Active') : __('Inactive')); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php echo e($category->created_at->format('d M Y')); ?>

                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_category_view')): ?>
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="<?php echo e(route('categories.show', $category->id)); ?>" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="<?php echo e(__('View')); ?>">
                                                        <i class="ti ti-eye text-dark"></i>
                                                    </a>
                                                </div>
                                                <?php endif; ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_category_edit')): ?>
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="<?php echo e(route('categories.edit', $category->id)); ?>" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="<?php echo e(__('Edit')); ?>">
                                                        <i class="ti ti-pencil text-dark"></i>
                                                    </a>
                                                </div>
                                                <?php endif; ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_category_delete')): ?>
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <button type="button" 
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center delete-category-btn" 
                                                            data-id="<?php echo e($category->id); ?>"
                                                            data-name="<?php echo e($category->name); ?>"
                                                            data-bs-toggle="tooltip" 
                                                            title="<?php echo e(__('Delete')); ?>">
                                                        <i class="ti ti-trash text-danger"></i>
                                                    </button>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="alert alert-info d-inline-flex align-items-center">
                                                <i class="ti ti-category-off me-2"></i>
                                                <?php echo e(__('No categories found.')); ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_category_add')): ?>
                                                <a href="<?php echo e(route('categories.create')); ?>" class="alert-link ms-1">
                                                    <?php echo e(__('Create your first category')); ?>

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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryModalLabel"><?php echo e(__('Delete Category')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="delete-message"></p>
                    <div class="alert alert-warning mt-3">
                        <i class="ti ti-alert-triangle me-2"></i>
                        <?php echo e(__('This action cannot be undone. All items in this category will remain but will show "N/A" for category.')); ?>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                    <form id="delete-category-form" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger"><?php echo e(__('Delete Category')); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .category-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 16px;
    }
    
    .category-icon.bg-primary {
        background-color: #0d6efd !important;
    }
    
    .category-icon.bg-success {
        background-color: #198754 !important;
    }
    
    .category-icon.bg-danger {
        background-color: #dc3545 !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-scripts','data' => ['tableId' => 'categoriesTable','searchPlaceholder' => 'Search categories...','pdfTitle' => 'Categories']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-scripts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'categoriesTable','searchPlaceholder' => 'Search categories...','pdfTitle' => 'Categories']); ?>
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
        
        // Delete button click handler
        $(document).on('click', '.delete-category-btn', function(e) {
            e.preventDefault();
            
            const categoryId = $(this).data('id');
            const categoryName = $(this).data('name');
            
            // Set modal message
            $('#delete-message').html('<?php echo e(__("Are you sure you want to delete")); ?> <strong>"' + categoryName + '"</strong>?');
            
            // Set form action
            $('#delete-category-form').attr('action', '<?php echo e(url("categories")); ?>/' + categoryId);
            
            // Show modal
            $('#deleteCategoryModal').modal('show');
        });

        // Delete form submission
        $('#delete-category-form').on('submit', function(e) {
            $('#deleteCategoryModal').modal('hide');
            // Let the form submit normally
        });
        
        // Clear filters
        $('#clear-filters').on('click', function() {
            $('#search-input').val('');
            $('#status-filter').val('');
            
            if (window.dataTables && window.dataTables['categoriesTable']) {
                const table = window.dataTables['categoriesTable'];
                table.search('').columns().search('').draw();
            }
        });
        
        // Real-time search
        let searchTimer;
        $('#search-input').on('keyup', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                if (window.dataTables && window.dataTables['categoriesTable']) {
                    const table = window.dataTables['categoriesTable'];
                    table.search($(this).val()).draw();
                }
            }, 300);
        });
        
        // Status filter
        $('#status-filter').on('change', function() {
            const status = $(this).val();
            
            if (window.dataTables && window.dataTables['categoriesTable']) {
                const table = window.dataTables['categoriesTable'];
                if (status) {
                    table.column(4).search(status).draw(); // Status column index
                } else {
                    table.column(4).search('').draw();
                }
            }
        });
    });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WORK GPT\Github repo\savantec-erp\resources\views/categories/index.blade.php ENDPATH**/ ?>