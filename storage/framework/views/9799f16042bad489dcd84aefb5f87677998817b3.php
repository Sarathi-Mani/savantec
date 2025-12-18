
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'tableId' => 'defaultTable',
    'exportButtons' => true,
    'columnToggle' => true,
    'columns' => [],
    'createButton' => false,
    'createRoute' => null,
    'createPermission' => null,
    'createLabel' => 'Create New',
    'createIcon' => 'ti-plus',
    'createTooltip' => 'Create New',
    'position' => 'float-end',
    'buttonClass' => 'btn-sm btn-primary',
    'includePdf' => true,
    'pdfOrientation' => 'portrait', // portrait or landscape
    'pdfPageSize' => 'A4' // A4, A3, Letter, Legal, etc.
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'tableId' => 'defaultTable',
    'exportButtons' => true,
    'columnToggle' => true,
    'columns' => [],
    'createButton' => false,
    'createRoute' => null,
    'createPermission' => null,
    'createLabel' => 'Create New',
    'createIcon' => 'ti-plus',
    'createTooltip' => 'Create New',
    'position' => 'float-end',
    'buttonClass' => 'btn-sm btn-primary',
    'includePdf' => true,
    'pdfOrientation' => 'portrait', // portrait or landscape
    'pdfPageSize' => 'A4' // A4, A3, Letter, Legal, etc.
]); ?>
<?php foreach (array_filter(([
    'tableId' => 'defaultTable',
    'exportButtons' => true,
    'columnToggle' => true,
    'columns' => [],
    'createButton' => false,
    'createRoute' => null,
    'createPermission' => null,
    'createLabel' => 'Create New',
    'createIcon' => 'ti-plus',
    'createTooltip' => 'Create New',
    'position' => 'float-end',
    'buttonClass' => 'btn-sm btn-primary',
    'includePdf' => true,
    'pdfOrientation' => 'portrait', // portrait or landscape
    'pdfPageSize' => 'A4' // A4, A3, Letter, Legal, etc.
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    // Default columns if not provided
    $defaultColumns = [
        ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
        ['index' => 1, 'name' => 'Name', 'description' => 'Name'],
        ['index' => 2, 'name' => 'Email', 'description' => 'Email address'],
        ['index' => 3, 'name' => 'Mobile', 'description' => 'Mobile number'],
        ['index' => 4, 'name' => 'Details', 'description' => 'Details'],
        ['index' => 5, 'name' => 'Status', 'description' => 'Status'],
        ['index' => 6, 'name' => 'Actions', 'description' => 'View/Edit/Delete actions']
    ];
    
    $columns = !empty($columns) ? $columns : $defaultColumns;
?>

<div class="<?php echo e($position); ?>">
    <div class="d-flex flex-wrap gap-2 justify-content-end align-items-center">
        <?php if($exportButtons): ?>
            
            <button type="button" 
                    class="btn <?php echo e($buttonClass); ?> btn-export" 
                    data-table-id="<?php echo e($tableId); ?>"
                    data-export="copy"
                    data-bs-toggle="tooltip" 
                    title="<?php echo e(__('Copy to Clipboard')); ?>">
                <!-- <i class="ti ti-copy"></i> -->
                 <span class="d-none d-md-inline"><?php echo e(__('Copy')); ?></span>
            </button>
            
            
            <button type="button" 
                    class="btn <?php echo e($buttonClass); ?> btn-export" 
                    data-table-id="<?php echo e($tableId); ?>"
                    data-export="csv"
                    data-bs-toggle="tooltip" 
                    title="<?php echo e(__('Export as CSV')); ?>">
                <!-- <i class="ti ti-file-text"></i> -->
                 <span class="d-none d-md-inline"><?php echo e(__('CSV')); ?></span>
            </button>
            
            
            <button type="button" 
                    class="btn <?php echo e($buttonClass); ?> btn-export" 
                    data-table-id="<?php echo e($tableId); ?>"
                    data-export="excel"
                    data-bs-toggle="tooltip" 
                    title="<?php echo e(__('Export as Excel')); ?>">
                <!-- <i class="ti ti-file-excel"></i>  -->
                <span class="d-none d-md-inline"><?php echo e(__('Excel')); ?></span>
            </button>
            
            
            <?php if($includePdf): ?>
            <button type="button" 
                    class="btn <?php echo e($buttonClass); ?> btn-export" 
                    data-table-id="<?php echo e($tableId); ?>"
                    data-export="pdf"
                    data-orientation="<?php echo e($pdfOrientation); ?>"
                    data-page-size="<?php echo e($pdfPageSize); ?>"
                    data-bs-toggle="tooltip" 
                    title="<?php echo e(__('Export as PDF')); ?>">
                <!-- <i class="ti ti-file-pdf"></i>  -->
                <span class="d-none d-md-inline"><?php echo e(__('PDF')); ?></span>
            </button>
            <?php endif; ?>
            
            
            <button type="button" 
                    class="btn <?php echo e($buttonClass); ?> btn-export" 
                    data-table-id="<?php echo e($tableId); ?>"
                    data-export="print"
                    data-bs-toggle="tooltip" 
                    title="<?php echo e(__('Print')); ?>">
                <!-- <i class="ti ti-printer"></i>  -->
                <span class="d-none d-md-inline"><?php echo e(__('Print')); ?></span>
            </button>
        <?php endif; ?>
        
        <?php if($columnToggle): ?>
            
            <div class="dropdown column-toggle-dropdown">
                <button class="btn <?php echo e($buttonClass); ?> btn-export dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" title="<?php echo e(__('Show/Hide Columns')); ?>">
                    <i class="ti ti-columns"></i> <span class="d-none d-md-inline"><?php echo e(__('Columns')); ?></span>
                </button>
                <ul class="dropdown-menu p-2">
                    <li><h6 class="dropdown-header"><?php echo e(__('Toggle Columns')); ?></h6></li>
                    <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="form-check dropdown-item column-toggle-item" 
                                 data-column="<?php echo e($column['index']); ?>" 
                                 data-table-id="<?php echo e($tableId); ?>">
                                <input class="form-check-input column-checkbox" 
                                       type="checkbox" 
                                       data-column="<?php echo e($column['index']); ?>" 
                                       data-table-id="<?php echo e($tableId); ?>"
                                       id="col-<?php echo e($tableId); ?>-<?php echo e($column['index']); ?>" 
                                       checked>
                                <label class="form-check-label w-100" for="col-<?php echo e($tableId); ?>-<?php echo e($column['index']); ?>">
                                    <?php echo e($column['name']); ?>

                                    <?php if(isset($column['description'])): ?>
                                        <small class="text-muted d-block"><?php echo e($column['description']); ?></small>
                                    <?php endif; ?>
                                </label>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if($createButton && $createRoute): ?>
            <?php if($createPermission): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($createPermission)): ?>
                    <div class="ms-md-2">
                        <a href="<?php echo e($createRoute); ?>" 
                           data-bs-toggle="tooltip" title="<?php echo e(__($createTooltip)); ?>" 
                           class="btn btn-sm btn-primary">
                            <i class="ti <?php echo e($createIcon); ?>"></i> <span class="d-none d-md-inline"><?php echo e(__($createLabel)); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="ms-md-2">
                    <a href="<?php echo e($createRoute); ?>" 
                       data-bs-toggle="tooltip" title="<?php echo e(__($createTooltip)); ?>" 
                       class="btn btn-sm btn-primary">
                        <i class="ti <?php echo e($createIcon); ?>"></i> <span class="d-none d-md-inline"><?php echo e(__($createLabel)); ?></span>
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div><?php /**PATH C:\Users\ADMIN\Projects\savantec-github\resources\views/components/export-buttons.blade.php ENDPATH**/ ?>