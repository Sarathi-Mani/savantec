

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Brands')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Brands')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-buttons','data' => ['tableId' => 'brandsTable','createButton' => true,'createRoute' => ''.e(route('brands.create')).'','createPermission' => 'brand_add','createLabel' => 'New Brand','createIcon' => 'ti-plus','createTooltip' => 'Create New Brand','columns' => [
            ['index' => 0, 'name' => 'S.No', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Name', 'description' => 'Brand name'],
            ['index' => 2, 'name' => 'Description', 'description' => 'Brand description'],
            ['index' => 3, 'name' => 'Items', 'description' => 'Number of items in brand'],
            ['index' => 4, 'name' => 'Status', 'description' => 'Active/Inactive status'],
            ['index' => 5, 'name' => 'Created At', 'description' => 'Creation date'],
            ['index' => 6, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
        ],'customButtons' => [
            [
                'label' => 'Export',
                'icon' => 'ti-download',
                'route' => route('brands.export'),
                'tooltip' => 'Export Brands',
                'class' => 'btn btn-outline-success btn-sm',
                'permission' => 'brand_view'
            ]
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'brandsTable','createButton' => true,'createRoute' => ''.e(route('brands.create')).'','createPermission' => 'brand_add','createLabel' => 'New Brand','createIcon' => 'ti-plus','createTooltip' => 'Create New Brand','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['index' => 0, 'name' => 'S.No', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Name', 'description' => 'Brand name'],
            ['index' => 2, 'name' => 'Description', 'description' => 'Brand description'],
            ['index' => 3, 'name' => 'Items', 'description' => 'Number of items in brand'],
            ['index' => 4, 'name' => 'Status', 'description' => 'Active/Inactive status'],
            ['index' => 5, 'name' => 'Created At', 'description' => 'Creation date'],
            ['index' => 6, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
        ]),'customButtons' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            [
                'label' => 'Export',
                'icon' => 'ti-download',
                'route' => route('brands.export'),
                'tooltip' => 'Export Brands',
                'class' => 'btn btn-outline-success btn-sm',
                'permission' => 'brand_view'
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
                    
                    <!-- Search and Filter Section -->
                    <!-- <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">
                                    <i class="ti ti-search"></i>
                                </span>
                                <input type="text" class="form-control" id="search-input" 
                                       placeholder="<?php echo e(__('Search brands...')); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm" id="status-filter">
                                <option value=""><?php echo e(__('All Status')); ?></option>
                                <option value="1"><?php echo e(__('Active')); ?></option>
                                <option value="0"><?php echo e(__('Inactive')); ?></option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm" id="sort-by">
                                <option value="name"><?php echo e(__('Sort by Name')); ?></option>
                                <option value="created_at"><?php echo e(__('Sort by Date')); ?></option>
                                <option value="items"><?php echo e(__('Sort by Items')); ?></option>
                            </select>
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-sm btn-light" id="clear-filters">
                                <i class="ti ti-refresh me-1"></i> <?php echo e(__('Clear')); ?>

                            </button>
                        </div>
                    </div> -->
                    
                    <!-- Bulk Actions Section -->
                    <div class="row mb-3 d-none" id="bulk-actions-section">
                        <div class="col-12">
                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" id="select-all-checkbox">
                                    <label class="form-check-label" for="select-all-checkbox">
                                        <span id="selected-count">0</span> <?php echo e(__('selected')); ?>

                                    </label>
                                </div>
                                <select class="form-select form-select-sm me-2" style="width: auto;" id="bulk-action-select">
                                    <option value=""><?php echo e(__('Choose Action')); ?></option>
                                    <option value="activate"><?php echo e(__('Activate')); ?></option>
                                    <option value="deactivate"><?php echo e(__('Deactivate')); ?></option>
                                    <option value="delete"><?php echo e(__('Delete')); ?></option>
                                </select>
                                <button class="btn btn-sm btn-primary" id="apply-bulk-action">
                                    <?php echo e(__('Apply')); ?>

                                </button>
                                <button class="btn btn-sm btn-light ms-2" id="cancel-bulk-action">
                                    <?php echo e(__('Cancel')); ?>

                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table w-100" id="brandsTable">
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
                                <?php $__empty_1 = true; $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr data-brand-id="<?php echo e($brand->id); ?>" data-status="<?php echo e($brand->status); ?>">
                                        <td class="text-center"><?php echo e($index + 1); ?></td>
                                        <td>
                                            <strong><?php echo e($brand->name); ?></strong>
                                        </td>
                                        <td>
                                            <?php if($brand->description): ?>
                                                <span class="text-truncate d-inline-block" style="max-width: 200px;"
                                                      data-bs-toggle="tooltip" title="<?php echo e($brand->description); ?>">
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
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand_edit')): ?>
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="<?php echo e(route('brands.edit', $brand->id)); ?>" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="<?php echo e(__('Edit')); ?>">
                                                        <i class="ti ti-pencil text-dark"></i>
                                                    </a>
                                                </div>
                                                <?php endif; ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand_delete')): ?>
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['brands.destroy', $brand->id], 'id' => 'delete-form-' . $brand->id, 'class' => 'd-inline']); ?>

                                                    <a href="#!" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" 
                                                       data-bs-toggle="tooltip" 
                                                       title="<?php echo e(__('Delete')); ?>" 
                                                       data-confirm="<?php echo e(__('Are You Sure?')); ?>" 
                                                       data-text="<?php echo e(__('This action will permanently delete the brand. Do you want to continue?')); ?>" 
                                                       data-confirm-yes="delete-form-<?php echo e($brand->id); ?>">
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
                                        <td colspan="7" class="text-center">
                                            <div class="alert alert-info d-inline-flex align-items-center">
                                                <i class="ti ti-package-off me-2"></i>
                                                <?php echo e(__('No brands found.')); ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brand_add')): ?>
                                                <a href="<?php echo e(route('brands.create')); ?>" class="alert-link ms-1">
                                                    <?php echo e(__('Create your first brand')); ?>

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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-scripts','data' => ['tableId' => 'brandsTable','searchPlaceholder' => 'Search brands...','pdfTitle' => 'Brands']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-scripts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'brandsTable','searchPlaceholder' => 'Search brands...','pdfTitle' => 'Brands']); ?>
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
        
        // Bulk Actions functionality
        let selectedBrands = [];
        
        // Row selection
        $(document).on('click', '#brandsTable tbody tr', function(e) {
            // Don't trigger if clicking on action buttons or links
            if ($(e.target).closest('a, button, .action-btn, .bs-pass-para').length) {
                return;
            }
            
            const brandId = $(this).data('brand-id');
            const $row = $(this);
            
            if (brandId) {
                if ($row.hasClass('selected')) {
                    $row.removeClass('selected');
                    selectedBrands = selectedBrands.filter(id => id !== brandId);
                } else {
                    $row.addClass('selected');
                    selectedBrands.push(brandId);
                }
                
                updateBulkActionsUI();
            }
        });
        
        // Select all checkbox
        $('#select-all-checkbox').on('change', function() {
            if ($(this).is(':checked')) {
                $('#brandsTable tbody tr').each(function() {
                    const brandId = $(this).data('brand-id');
                    if (brandId && !selectedBrands.includes(brandId)) {
                        $(this).addClass('selected');
                        selectedBrands.push(brandId);
                    }
                });
            } else {
                $('#brandsTable tbody tr').each(function() {
                    $(this).removeClass('selected');
                });
                selectedBrands = [];
            }
            
            updateBulkActionsUI();
        });
        
        // Update bulk actions UI
        function updateBulkActionsUI() {
            const count = selectedBrands.length;
            $('#selected-count').text(count);
            
            if (count > 0) {
                $('#bulk-actions-section').removeClass('d-none');
            } else {
                $('#bulk-actions-section').addClass('d-none');
                $('#select-all-checkbox').prop('checked', false);
            }
        }
        
        // Cancel bulk action
        $('#cancel-bulk-action').on('click', function() {
            selectedBrands = [];
            $('#brandsTable tbody tr').removeClass('selected');
            updateBulkActionsUI();
        });
        
        // Apply bulk action
        $('#apply-bulk-action').on('click', function() {
            const action = $('#bulk-action-select').val();
            
            if (selectedBrands.length === 0) {
                alert('<?php echo e(__("Please select at least one brand")); ?>');
                return;
            }
            
            if (!action) {
                alert('<?php echo e(__("Please select an action")); ?>');
                return;
            }
            
            let confirmMessage = '';
            if (action === 'delete') {
                confirmMessage = '<?php echo e(__("Are you sure you want to delete selected brands?")); ?>';
            } else {
                confirmMessage = '<?php echo e(__("Are you sure you want to update status of selected brands?")); ?>';
            }
            
            if (confirm(confirmMessage)) {
                $.ajax({
                    url: '<?php echo e(route("brands.bulk.update")); ?>',
                    method: 'POST',
                    data: {
                        ids: selectedBrands,
                        action: action,
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
        
        // Clear filters
        $('#clear-filters').on('click', function() {
            $('#search-input').val('');
            $('#status-filter').val('');
            $('#sort-by').val('name');
            
            if (window.dataTables && window.dataTables['brandsTable']) {
                const table = window.dataTables['brandsTable'];
                table.search('').columns().search('').draw();
            }
        });
        
        // Real-time search
        let searchTimer;
        $('#search-input').on('keyup', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                if (window.dataTables && window.dataTables['brandsTable']) {
                    const table = window.dataTables['brandsTable'];
                    table.search($(this).val()).draw();
                }
            }, 300);
        });
        
        // Status filter
        $('#status-filter').on('change', function() {
            const status = $(this).val();
            
            if (window.dataTables && window.dataTables['brandsTable']) {
                const table = window.dataTables['brandsTable'];
                if (status) {
                    table.column(4).search(status).draw(); // Status column index
                } else {
                    table.column(4).search('').draw();
                }
            }
        });
        
        // Sort by
        $('#sort-by').on('change', function() {
            const sortBy = $(this).val();
            
            if (window.dataTables && window.dataTables['brandsTable']) {
                const table = window.dataTables['brandsTable'];
                // Determine column index based on sort option
                let columnIndex;
                switch(sortBy) {
                    case 'name': columnIndex = 1; break;
                    case 'created_at': columnIndex = 5; break;
                    case 'items': columnIndex = 3; break;
                    default: columnIndex = 1;
                }
                
                // Get current order and toggle
                const currentOrder = table.order();
                if (currentOrder.length > 0 && currentOrder[0][0] === columnIndex) {
                    // Toggle order if same column
                    table.order([columnIndex, currentOrder[0][1] === 'asc' ? 'desc' : 'asc']).draw();
                } else {
                    // New column, default to asc
                    table.order([columnIndex, 'asc']).draw();
                }
            }
        });
        
        // Add CSS for selected rows
        $('<style>')
            .text('#brandsTable tbody tr.selected { background-color: rgba(13, 110, 253, 0.1); }')
            .appendTo('head');
    });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-github\resources\views/brands/index.blade.php ENDPATH**/ ?>