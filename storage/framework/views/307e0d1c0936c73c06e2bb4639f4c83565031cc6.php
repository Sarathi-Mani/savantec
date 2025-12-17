

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Brands')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Brands')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand_add')): ?>
            <a href="<?php echo e(route('brands.create')); ?>" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i> <?php echo e(__('Create')); ?>

            </a>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand_view')): ?>
            <a href="<?php echo e(route('brands.export')); ?>" class="btn btn-sm btn-success ms-2">
                <i class="ti ti-download"></i> <?php echo e(__('Export')); ?>

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
                    <form method="GET" action="<?php echo e(route('brands.index')); ?>">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" 
                                   placeholder="<?php echo e(__('Search brands...')); ?>" 
                                   value="<?php echo e(request('search')); ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="<?php echo e(route('brands.index')); ?>">
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

            <!-- Brands Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all">
                            </th>
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
                        <?php $__empty_1 = true; $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="brand-checkbox" value="<?php echo e($brand->id); ?>">
                                </td>
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <strong><?php echo e($brand->name); ?></strong>
                                
                                </td>
                                <td>
                                    <?php if($brand->description): ?>
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;">
                                            <?php echo e(Str::limit($brand->description, 50)); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo e($brand->item_count ?? 0); ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($brand->status ? 'success' : 'danger'); ?>">
                                        <?php echo e($brand->status ? __('Active') : __('Inactive')); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php echo e($brand->created_at->format('d M Y')); ?>

                                </td>
                                <td>
                                    <div class="d-flex">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand_view')): ?>
                                            <a href="<?php echo e(route('brands.show', $brand->id)); ?>" 
                                               class="btn btn-sm btn-icon btn-light-info me-1"
                                               data-bs-toggle="tooltip" title="<?php echo e(__('View')); ?>">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand_edit')): ?>
                                            <a href="<?php echo e(route('brands.edit', $brand->id)); ?>" 
                                               class="btn btn-sm btn-icon btn-light-primary me-1"
                                               data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand_delete')): ?>
                                            <form method="POST" action="<?php echo e(route('brands.destroy', $brand->id)); ?>" 
                                                  class="d-inline" onsubmit="return confirmDelete();">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" 
                                                        class="btn btn-sm btn-icon btn-light-danger"
                                                        data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="ti ti-package-off" style="font-size: 48px; color: #adb5bd;"></i>
                                    <h5 class="text-muted mt-3"><?php echo e(__('No brands found')); ?></h5>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand_add')): ?>
                                        <a href="<?php echo e(route('brands.create')); ?>" class="btn btn-primary mt-2">
                                            <i class="ti ti-plus me-1"></i> <?php echo e(__('Create Your First Brand')); ?>

                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Bulk Actions -->
            <?php if($brands->count() > 0): ?>
                <div class="mt-3">
                    <div class="d-flex align-items-center">
                        <select class="form-select form-select-sm me-2" style="width: auto;" id="bulk-action">
                            <option value=""><?php echo e(__('Bulk Actions')); ?></option>
                            <option value="activate"><?php echo e(__('Activate')); ?></option>
                            <option value="deactivate"><?php echo e(__('Deactivate')); ?></option>
                        </select>
                        <button class="btn btn-sm btn-primary" id="apply-bulk-action">
                            <?php echo e(__('Apply')); ?>

                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function confirmDelete() {
        return confirm('<?php echo e(__("Are you sure you want to delete this brand?")); ?>');
    }

    $(document).ready(function() {
        // Select all checkbox
        $('#select-all').on('change', function() {
            $('.brand-checkbox').prop('checked', this.checked);
        });

        // Bulk action
        $('#apply-bulk-action').on('click', function() {
            const selectedIds = $('.brand-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedIds.length === 0) {
                alert('<?php echo e(__("Please select at least one brand")); ?>');
                return;
            }

            const action = $('#bulk-action').val();
            if (!action) {
                alert('<?php echo e(__("Please select an action")); ?>');
                return;
            }

            if (confirm('<?php echo e(__("Are you sure you want to perform this action on selected brands?")); ?>')) {
                $.ajax({
                    url: '<?php echo e(route("brands.bulk.update")); ?>',
                    method: 'POST',
                    data: {
                        ids: selectedIds,
                        status: action === 'activate' ? 1 : 0,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('<?php echo e(__("An error occurred. Please try again.")); ?>');
                    }
                });
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-erp\resources\views/brands/index.blade.php ENDPATH**/ ?>