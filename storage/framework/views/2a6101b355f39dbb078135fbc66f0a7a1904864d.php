
<?php
    // Determine if user has special permissions
    $isSuperAdmin = \Auth::user()->type == 'super admin';
    $isCompanyAdmin = \Auth::user()->type == 'company';
    
    // Prepare categories for filter
    $categories = $items->unique('category')->pluck('category')->filter();
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Items')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Items')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-buttons','data' => ['tableId' => 'itemTable','createButton' => true,'createRoute' => ''.e(route('items.create')).'','createPermission' => 'create item','createLabel' => 'New Item','createIcon' => 'ti-plus','createTooltip' => 'Create New Item','columns' => [
            ['index' => 0, 'name' => 'S.No', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Image', 'description' => 'Item image'],
            ['index' => 2, 'name' => 'Item Code', 'description' => 'Item SKU/barcode'],
            ['index' => 3, 'name' => 'Item Name', 'description' => 'Item name and group'],
            ['index' => 4, 'name' => 'Description', 'description' => 'Item description'],
            ['index' => 5, 'name' => 'Brand', 'description' => 'Brand name'],
            ['index' => 6, 'name' => 'Category/Item Type', 'description' => 'Category and item type'],
            ['index' => 7, 'name' => 'Unit', 'description' => 'Measurement unit'],
            ['index' => 8, 'name' => 'Stock', 'description' => 'Current stock quantity'],
            ['index' => 9, 'name' => 'Alert Quantity', 'description' => 'Minimum stock alert'],
            ['index' => 10, 'name' => 'Sales Price', 'description' => 'Selling price with cost'],
            ['index' => 11, 'name' => 'Tax', 'description' => 'Tax rate and name'],
            ['index' => 12, 'name' => 'Status', 'description' => 'Active/Inactive status'],
            ['index' => 13, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
        ],'customButtons' => [
            [
                'label' => 'Export',
                'icon' => 'ti-download',
                'route' => route('items.export'),
                'tooltip' => 'Export Items',
                'class' => 'btn btn-outline-success btn-sm',
                'permission' => 'item_export'
            ]
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'itemTable','createButton' => true,'createRoute' => ''.e(route('items.create')).'','createPermission' => 'create item','createLabel' => 'New Item','createIcon' => 'ti-plus','createTooltip' => 'Create New Item','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['index' => 0, 'name' => 'S.No', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Image', 'description' => 'Item image'],
            ['index' => 2, 'name' => 'Item Code', 'description' => 'Item SKU/barcode'],
            ['index' => 3, 'name' => 'Item Name', 'description' => 'Item name and group'],
            ['index' => 4, 'name' => 'Description', 'description' => 'Item description'],
            ['index' => 5, 'name' => 'Brand', 'description' => 'Brand name'],
            ['index' => 6, 'name' => 'Category/Item Type', 'description' => 'Category and item type'],
            ['index' => 7, 'name' => 'Unit', 'description' => 'Measurement unit'],
            ['index' => 8, 'name' => 'Stock', 'description' => 'Current stock quantity'],
            ['index' => 9, 'name' => 'Alert Quantity', 'description' => 'Minimum stock alert'],
            ['index' => 10, 'name' => 'Sales Price', 'description' => 'Selling price with cost'],
            ['index' => 11, 'name' => 'Tax', 'description' => 'Tax rate and name'],
            ['index' => 12, 'name' => 'Status', 'description' => 'Active/Inactive status'],
            ['index' => 13, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
        ]),'customButtons' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            [
                'label' => 'Export',
                'icon' => 'ti-download',
                'route' => route('items.export'),
                'tooltip' => 'Export Items',
                'class' => 'btn btn-outline-success btn-sm',
                'permission' => 'item_export'
            ]
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
                    
                    <!-- Filters Section -->
                    <!-- <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label"><?php echo e(__('Company')); ?></label>
                                    <select class="form-select form-select-sm" id="company-filter">
                                        <option value="">-All Companies-</option>
                                        <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($company->id); ?>"><?php echo e($company->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?php echo e(__('Category')); ?></label>
                                    <select class="form-select form-select-sm" id="category-filter">
                                        <option value="">All Categories</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category); ?>"><?php echo e($category); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end align-items-end h-100">
                                <button class="btn btn-sm btn-light me-2" id="reset-filters">
                                    <i class="ti ti-refresh me-1"></i> <?php echo e(__('Reset')); ?>

                                </button>
                                <button class="btn btn-sm btn-primary" id="apply-filters">
                                    <i class="ti ti-filter me-1"></i> <?php echo e(__('Apply')); ?>

                                </button>
                            </div>
                        </div>
                    </div> -->
                    
                    <div class="table-responsive">
                        <table class="table w-100" id="itemTable">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center"><?php echo e(__('S.No')); ?></th>
                                    <th><?php echo e(__('Image')); ?></th>
                                    <th><?php echo e(__('Item Code')); ?></th>
                                    <th><?php echo e(__('Item Name')); ?></th>
                                    <th><?php echo e(__('Description')); ?></th>
                                    <th><?php echo e(__('Brand')); ?></th>
                                    <th><?php echo e(__('Category')); ?></th>
                                    <th><?php echo e(__('Unit')); ?></th>
                                    <th><?php echo e(__('Stock')); ?></th>
                                    <th><?php echo e(__('Alert Qty')); ?></th>
                                    <th><?php echo e(__('Sales Price')); ?></th>
                                    <th><?php echo e(__('Tax')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th width="120" class="text-center"><?php echo e(__('Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="text-center"><?php echo e($index + 1); ?></td>
                                        <td>
                                            <?php if($item->image): ?>
                                                <img src="<?php echo e(Storage::url($item->image)); ?>" 
                                                     alt="<?php echo e($item->name); ?>" 
                                                     class="rounded-circle" 
                                                     width="40" 
                                                     height="40"
                                                     style="object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="ti ti-photo text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"><?php echo e($item->sku ?? 'N/A'); ?></span>
                                            <?php if($item->barcode): ?>
                                                <small class="d-block text-muted"><?php echo e($item->barcode); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?php echo e($item->name); ?></strong>
                                            <?php if($item->item_group): ?>
                                                <br>
                                                <small class="badge bg-info"><?php echo e(strtoupper($item->item_group)); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($item->description): ?>
                                                <span data-bs-toggle="tooltip" title="<?php echo e($item->description); ?>">
                                                    <?php echo e(Str::limit($item->description, 30)); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($item->brand): ?>
                                                <span class="badge bg-light text-dark"><?php echo e($item->brand); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo e($item->category ?? '-'); ?>

                                            <?php if($item->item_group): ?>
                                                <small class="d-block text-muted"><?php echo e(strtoupper($item->item_group)); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($item->unit): ?>
                                                <span class="badge bg-light text-dark"><?php echo e($item->unit); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                                $stock = $item->quantity ?? 0;
                                                $alertQuantity = $item->alert_quantity ?? 0;
                                            ?>
                                            
                                            <?php if($stock <= $alertQuantity && $stock > 0): ?>
                                                <span class="badge bg-warning" data-bs-toggle="tooltip" title="Low Stock">
                                                    <i class="ti ti-alert-triangle me-1"></i><?php echo e(number_format($stock, 2)); ?>

                                                </span>
                                            <?php elseif($stock == 0): ?>
                                                <span class="badge bg-danger" data-bs-toggle="tooltip" title="Out of Stock">
                                                    <i class="ti ti-x me-1"></i><?php echo e(number_format($stock, 2)); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-success">
                                                    <i class="ti ti-check me-1"></i><?php echo e(number_format($stock, 2)); ?>

                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($item->alert_quantity ?? 0); ?></td>
                                        <td>
                                            <span class="fw-bold">₹<?php echo e(number_format($item->sales_price, 2)); ?></span>
                                            <?php if($item->purchase_price): ?>
                                                <small class="d-block text-muted">Cost: ₹<?php echo e(number_format($item->purchase_price, 2)); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($item->tax): ?>
                                                <span class="badge bg-light text-dark"><?php echo e($item->tax->name ?? ''); ?></span>
                                                <?php if($item->tax->rate): ?>
                                                    <small class="d-block text-muted"><?php echo e(number_format($item->tax->rate, 2)); ?>%</small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($stock > 0): ?>
                                                <span class="badge bg-success"><?php echo e(__('Active')); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><?php echo e(__('Inactive')); ?></span>
                                            <?php endif; ?>
                                            
                                            <?php if($item->profit_margin): ?>
                                                <small class="d-block text-muted"><?php echo e(number_format($item->profit_margin, 2)); ?>% margin</small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_edit')): ?>
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="<?php echo e(route('items.edit', $item->id)); ?>" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="<?php echo e(__('Edit')); ?>">
                                                        <i class="ti ti-pencil text-dark"></i>
                                                    </a>
                                                </div>
                                                <?php endif; ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_delete')): ?>
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['items.destroy', $item->id], 'id' => 'delete-form-' . $item->id, 'class' => 'd-inline']); ?>

                                                    <a href="#!" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" 
                                                       data-bs-toggle="tooltip" 
                                                       title="<?php echo e(__('Delete')); ?>" 
                                                       data-confirm="<?php echo e(__('Are You Sure?')); ?>" 
                                                       data-text="<?php echo e(__('This action will permanently delete the item. Do you want to continue?')); ?>" 
                                                       data-confirm-yes="delete-form-<?php echo e($item->id); ?>">
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
                                        <td colspan="14" class="text-center">
                                            <div class="alert alert-info d-inline-flex align-items-center">
                                                <i class="ti ti-info-circle me-2"></i>
                                                <?php echo e(__('No items found.')); ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create item')): ?>
                                                <a href="<?php echo e(route('items.create')); ?>" class="alert-link ms-1">
                                                    <?php echo e(__('Create your first item')); ?>

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

<?php $__env->startPush('styles'); ?>
<style>
    .table-image {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
    }
    
    .no-image {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 50%;
        color: #6c757d;
    }
    
    /* Stock status colors */
    .stock-low {
        background-color: #fff3cd !important;
        color: #856404 !important;
        border-color: #ffeaa7;
    }
    
    .stock-out {
        background-color: #f8d7da !important;
        color: #721c24 !important;
        border-color: #f5c6cb;
    }
    
    .stock-good {
        background-color: #d4edda !important;
        color: #155724 !important;
        border-color: #c3e6cb;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-scripts','data' => ['tableId' => 'itemTable','searchPlaceholder' => 'Search items...','pdfTitle' => 'Items']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-scripts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'itemTable','searchPlaceholder' => 'Search items...','pdfTitle' => 'Items']); ?>
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
        
        // Filter functionality
        $('#apply-filters').on('click', function() {
            const companyFilter = $('#company-filter').val();
            const categoryFilter = $('#category-filter').val();
            
            if (window.dataTables && window.dataTables['itemTable']) {
                const table = window.dataTables['itemTable'];
                
                // Clear all filters
                table.columns().search('');
                table.search('');
                
                // Apply filters
                if (companyFilter) {
                    table.search(companyFilter).draw();
                }
                
                if (categoryFilter) {
                    table.column(6).search(categoryFilter).draw(); // Category column index
                }
                
                if (!companyFilter && !categoryFilter) {
                    table.search('').columns().search('').draw();
                }
            } else {
                // Fallback: filter by hiding rows
                $('table#itemTable tbody tr').each(function() {
                    const $row = $(this);
                    let showRow = true;
                    
                    // Company filter (assuming company ID is in a data attribute)
                    if (companyFilter) {
                        const companyId = $row.find('td:nth-child(1)').data('company-id');
                        if (companyId != companyFilter) {
                            showRow = false;
                        }
                    }
                    
                    // Category filter
                    if (categoryFilter) {
                        const category = $row.find('td:nth-child(7)').text().trim();
                        if (category !== categoryFilter) {
                            showRow = false;
                        }
                    }
                    
                    if (showRow) {
                        $row.show();
                    } else {
                        $row.hide();
                    }
                });
            }
        });
        
        $('#reset-filters').on('click', function() {
            $('#company-filter').val('');
            $('#category-filter').val('');
            
            if (window.dataTables && window.dataTables['itemTable']) {
                const table = window.dataTables['itemTable'];
                table.search('').columns().search('').draw();
            } else {
                $('table#itemTable tbody tr').show();
            }
        });
        
        // Delete confirmation
        $(document).on('click', '.bs-pass-para', function(e) {
            e.preventDefault();
            
            const formId = $(this).data('confirm-yes');
            const confirmText = $(this).data('text');
            const confirmMessage = $(this).data('confirm');
            
            if (confirm(confirmMessage + '\n\n' + confirmText)) {
                document.getElementById(formId).submit();
            }
        });
    });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WORK GPT\Github repo\savantec-erp\resources\views/items/index.blade.php ENDPATH**/ ?>