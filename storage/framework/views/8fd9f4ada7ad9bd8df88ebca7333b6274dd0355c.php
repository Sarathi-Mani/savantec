

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Categories')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Categories')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_category_add')): ?>
            <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i> <?php echo e(__('Create')); ?>

            </a>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <!-- Search and Filter -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="<?php echo e(route('categories.index')); ?>">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" 
                                   placeholder="<?php echo e(__('Search categories...')); ?>" 
                                   value="<?php echo e(request('search')); ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="<?php echo e(route('categories.index')); ?>">
                        <div class="input-group">
                            <select class="form-select" name="status" onchange="this.form.submit()">
                                <option value=""><?php echo e(__('All Status')); ?></option>
                                <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>
                                    <?php echo e(__('Active')); ?>

                                </option>
                                <option value="0" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>
                                    <?php echo e(__('Inactive')); ?>

                                </option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><?php echo e(__('S.No')); ?></th>
                            <th><?php echo e(__('Name')); ?></th>
                            <th><?php echo e(__('Description')); ?></th>
                            <th><?php echo e(__('Items')); ?></th>
                            <th><?php echo e(__('Status')); ?></th>
                            <th><?php echo e(__('Created At')); ?></th>
                            <th><?php echo e(__('Action')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <strong><?php echo e($category->name); ?></strong>
                                    <br>
                                    <small class="text-muted"><?php echo e($category->slug); ?></small>
                                </td>
                                <td>
                                    <?php if($category->description): ?>
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;">
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
                                <td>
                                    <div class="d-flex">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_category_view')): ?>
                                            <a href="<?php echo e(route('categories.show', $category->id)); ?>" 
                                               class="btn btn-sm btn-icon btn-light-info me-1"
                                               data-bs-toggle="tooltip" title="<?php echo e(__('View')); ?>">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_category_edit')): ?>
                                            <a href="<?php echo e(route('categories.edit', $category->id)); ?>" 
                                               class="btn btn-sm btn-icon btn-light-primary me-1"
                                               data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_category_delete')): ?>
                                            <button type="button" 
                                                    class="btn btn-sm btn-icon btn-light-danger delete-category-btn"
                                                    data-id="<?php echo e($category->id); ?>"
                                                    data-name="<?php echo e($category->name); ?>"
                                                    data-bs-toggle="tooltip" 
                                                    title="<?php echo e(__('Delete')); ?>">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="ti ti-category-off" style="font-size: 48px; color: #adb5bd;"></i>
                                    <h5 class="text-muted mt-3"><?php echo e(__('No categories found')); ?></h5>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_category_add')): ?>
                                        <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary mt-2">
                                            <i class="ti ti-plus me-1"></i> <?php echo e(__('Create Your First Category')); ?>

                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        // Delete button click handler
        $(document).on('click', '.delete-category-btn', function() {
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
            // Optional: You can add AJAX submission here if needed
            // For now, let the form submit normally
            $('#deleteCategoryModal').modal('hide');
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-erp\resources\views/categories/index.blade.php ENDPATH**/ ?>