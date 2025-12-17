
<?php
    // Determine if user has special permissions
    $isSuperAdmin = \Auth::user()->type == 'super admin';
    $isCompanyAdmin = \Auth::user()->type == 'company';
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Items')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Items')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create item')): ?>
            <a href="<?php echo e(route('items.create')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_export')): ?>
            <a href="<?php echo e(route('items.export')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Export')); ?>" class="btn btn-sm btn-success ms-2">
                <i class="ti ti-download"></i>
            </a>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <!-- Filters Section -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label"><?php echo e(__('Company')); ?></label>
                            <select class="form-select" id="company-filter">
                                <option value="">-All Companies-</option>
                                <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($company->id); ?>"><?php echo e($company->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><?php echo e(__('Category')); ?></label>
                            <select class="form-select" id="category-filter">
                                <option value="">All</option>
                                <?php
                                    $categories = $items->unique('category')->pluck('category')->filter();
                                ?>
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
                            <i class="ti ti-refresh"></i> <?php echo e(__('Reset')); ?>

                        </button>
                        <button class="btn btn-sm btn-primary" id="apply-filters">
                            <i class="ti ti-filter"></i> <?php echo e(__('Apply')); ?>

                        </button>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="table-responsive">
                <table class="table datatable" id="itemTable">
                    <thead>
                        <tr>
                            <th></th> <!-- Expand/Collapse column -->
                            <th><?php echo e(__('S.No')); ?></th>
                            <th><?php echo e(__('Image')); ?></th>
                            <th><?php echo e(__('Item Code')); ?></th>
                            <th><?php echo e(__('Item Name')); ?></th>
                            <th><?php echo e(__('Description')); ?></th>
                            <th><?php echo e(__('Brand')); ?></th>
                            <th><?php echo e(__('Category/ Item Type')); ?></th>
                            <th><?php echo e(__('Unit')); ?></th>
                            <th><?php echo e(__('Stock')); ?></th>
                            <th><?php echo e(__('Alert Quantity')); ?></th>
                            <th><?php echo e(__('Sales Price')); ?></th>
                            <th><?php echo e(__('Tax')); ?></th>
                            <th><?php echo e(__('Status')); ?></th>
                            <th><?php echo e(__('Action')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="expand-control"></td> <!-- Expand control cell -->
                            <td class="serial-number" data-label="<?php echo e(__('S.No')); ?>">
                                <?php echo e($index + 1); ?>

                            </td>
                            <td data-label="<?php echo e(__('Image')); ?>">
                                <?php if($item->image): ?>
                                    <img src="<?php echo e(Storage::url($item->image)); ?>" alt="<?php echo e($item->name); ?>" 
                                         class="img-thumbnail table-image" style="width: 50px; height: 50px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="no-image table-image" style="width: 50px; height: 50px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                        <i class="ti ti-photo text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Item Code')); ?>">
                                <div class="d-flex flex-column">
                                    <span class="badge bg-primary"><?php echo e($item->sku ?? 'N/A'); ?></span>
                                    <?php if($item->barcode): ?>
                                        <small class="text-muted mt-1"><?php echo e($item->barcode); ?></small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Item Name')); ?>">
                                <strong><?php echo e($item->name); ?></strong>
                                <?php if($item->item_group): ?>
                                    <br>
                                    <small class="badge bg-info"><?php echo e(strtoupper($item->item_group)); ?></small>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Description')); ?>">
                                <?php if($item->description): ?>
                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                          data-bs-toggle="tooltip" title="<?php echo e($item->description); ?>">
                                        <?php echo e(Str::limit($item->description, 50)); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Brand')); ?>">
                                <?php if($item->brand): ?>
                                    <span class="badge bg-light text-dark"><?php echo e($item->brand); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Category/ Item Type')); ?>">
                                <div class="d-flex flex-column">
                                    <?php if($item->category): ?>
                                        <span class="fw-bold"><?php echo e($item->category); ?></span>
                                    <?php endif; ?>
                                    <?php if($item->item_group): ?>
                                        <small class="text-muted"><?php echo e(strtoupper($item->item_group)); ?></small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Unit')); ?>">
                                <?php if($item->unit): ?>
                                    <span class="badge bg-light text-dark"><?php echo e($item->unit); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Stock')); ?>">
                                <div class="d-flex align-items-center">
                                    <?php
                                        $stock = $item->quantity ?? 0;
                                        $alertQuantity = $item->alert_quantity ?? 0;
                                    ?>
                                    
                                    <?php if($stock <= $alertQuantity && $stock > 0): ?>
                                        <span class="badge bg-warning me-2"><i class="ti ti-alert-triangle"></i></span>
                                    <?php elseif($stock == 0): ?>
                                        <span class="badge bg-danger me-2"><i class="ti ti-x"></i></span>
                                    <?php else: ?>
                                        <span class="badge bg-success me-2"><i class="ti ti-check"></i></span>
                                    <?php endif; ?>
                                    <?php echo e(number_format($stock, 2)); ?>

                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Alert Quantity')); ?>"><?php echo e($item->alert_quantity ?? 0); ?></td>
                            <td data-label="<?php echo e(__('Sales Price')); ?>">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">₹<?php echo e(number_format($item->sales_price, 2)); ?></span>
                                    <?php if($item->purchase_price): ?>
                                        <small class="text-muted">Cost: ₹<?php echo e(number_format($item->purchase_price, 2)); ?></small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Tax')); ?>">
                                <?php if($item->tax): ?>
                                    <span class="badge bg-light text-dark"><?php echo e($item->tax->name ?? ''); ?></span>
                                    <?php if($item->tax->rate): ?>
                                        <br><small class="text-muted">(<?php echo e(number_format($item->tax->rate, 2)); ?>%)</small>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Status')); ?>">
                                <?php if($stock > 0): ?>
                                    <span class="badge bg-success"><?php echo e(__('Active')); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger"><?php echo e(__('Inactive')); ?></span>
                                <?php endif; ?>
                                
                                <?php if($item->profit_margin): ?>
                                    <br>
                                    <small class="text-muted"><?php echo e(number_format($item->profit_margin, 2)); ?>% margin</small>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Action')); ?>">
                                <?php if(Gate::check('item_edit') || Gate::check('item_delete')): ?>
                                    <div class="d-flex action-buttons">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_edit')): ?>
                                            <a href="<?php echo e(route('items.edit', $item->id)); ?>" class="btn btn-sm btn-icon btn-light-primary me-1" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('item_delete')): ?>
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['items.destroy', $item->id],'id'=>'delete-item-form-'.$item->id, 'class' => 'd-inline']); ?>

                                            <a href="#!" class="btn btn-sm btn-icon btn-light-danger bs-pass-para" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?')); ?>" data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="delete-item-form-<?php echo e($item->id); ?>">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                            <?php echo Form::close(); ?>

                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<style>
/* Custom Styles for Items Table */
#itemTable_wrapper {
    margin-top: 10px;
}

/* Table responsive styling */
#itemTable {
    width: 100% !important;
}

/* Expand/collapse icon styling */
table.dataTable.dtr-inline.collapsed > tbody > tr > td.expand-control:before,
table.dataTable.dtr-inline.collapsed > tbody > tr > th.expand-control:before {
    background-color: #0d6efd;
    border-radius: 50%;
    color: white;
    content: "+";
    font-family: 'Courier New', Courier, monospace;
    font-size: 14px;
    font-weight: bold;
    height: 20px;
    left: 50%;
    line-height: 20px;
    position: absolute;
    text-align: center;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 20px;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

table.dataTable.dtr-inline.collapsed > tbody > tr.parent > td.expand-control:before,
table.dataTable.dtr-inline.collapsed > tbody > tr.parent > th.expand-control:before {
    content: "-";
    background-color: #dc3545;
    transform: translate(-50%, -50%) rotate(0deg);
}

/* Expanded details row styling */
.dtr-details {
    width: 100%;
    padding: 15px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 8px;
    margin: 10px 0;
    border-left: 4px solid #0d6efd;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.dtr-details > li {
    display: flex;
    padding: 8px 0;
    border-bottom: 1px solid rgba(0,0,0,0.1);
    align-items: center;
}

.dtr-details > li:last-child {
    border-bottom: none;
}

.dtr-details .dtr-title {
    font-weight: 600;
    color: #2c3e50;
    min-width: 150px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.dtr-details .dtr-data {
    color: #495057;
    text-align: left;
    flex-grow: 1;
    font-weight: 500;
}

/* Expanded image styling */
.expanded-image-container {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.expanded-image {
    max-width: 200px;
    max-height: 200px;
    border-radius: 6px;
    border: 2px solid #dee2e6;
}

.expanded-no-image {
    width: 150px;
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 8px;
    border: 2px dashed #dee2e6;
}

.expanded-no-image i {
    font-size: 48px;
    color: #adb5bd;
}

/* Make table responsive on mobile */
@media (max-width: 768px) {
    /* Hide the original table header on mobile */
    #itemTable thead {
        display: none;
    }
    
    /* Make table rows stack vertically */
    #itemTable tbody tr {
        display: block;
        margin-bottom: 15px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 10px;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        position: relative;
    }
    
    /* Hide expand control column on mobile */
    #itemTable tbody td.expand-control {
        display: none;
    }
    
    /* Make table cells stack vertically */
    #itemTable tbody td:not(.expand-control) {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border: none;
        border-bottom: 1px solid #f8f9fa;
    }
    
    /* Remove last cell border */
    #itemTable tbody td:last-child {
        border-bottom: none;
    }
    
    /* Add label before each cell content */
    #itemTable tbody td:not(.expand-control)::before {
        content: attr(data-label);
        font-weight: bold;
        color: #495057;
        text-align: left;
        width: 40%;
        padding-right: 15px;
        flex-shrink: 0;
    }
    
    /* Adjust cell content alignment */
    #itemTable tbody td:not(.expand-control) > * {
        width: 60%;
        text-align: right;
        flex-grow: 1;
    }
    
    /* Special styling for serial number */
    #itemTable tbody td.serial-number {
        display: none;
    }
    
    /* Special styling for image column */
    #itemTable tbody td[data-label="Image"] {
        justify-content: center;
        padding: 15px 0;
    }
    
    #itemTable tbody td[data-label="Image"]::before {
        display: none;
    }
    
    #itemTable tbody td[data-label="Image"] > * {
        width: auto;
        text-align: center;
    }
    
    /* Special styling for action buttons */
    #itemTable tbody td[data-label="Action"] {
        justify-content: center;
        padding: 15px 0 5px 0;
    }
    
    #itemTable tbody td[data-label="Action"]::before {
        display: none;
    }
    
    #itemTable tbody td[data-label="Action"] .action-buttons {
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 10px;
    }
    
    /* Adjust image size on mobile */
    .table-image {
        width: 60px !important;
        height: 60px !important;
        border-radius: 8px;
    }
    
    .no-image.table-image {
        width: 60px !important;
        height: 60px !important;
        border-radius: 8px;
    }
    
    /* Make badges and text smaller on mobile */
    .badge {
        font-size: 0.75em;
        padding: 4px 8px;
    }
    
    /* Adjust DataTables buttons on mobile */
    .dt-buttons {
        text-align: center;
        margin-bottom: 10px;
    }
    
    .dt-buttons .btn {
        margin: 2px;
        font-size: 0.875em;
    }
    
    /* Adjust search input on mobile */
    .dataTables_filter {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .dataTables_filter input {
        width: 100% !important;
    }
    
    /* Adjust expanded details on mobile */
    .dtr-details {
        padding: 10px;
        margin: 8px 0;
    }
    
    .dtr-details > li {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }
    
    .dtr-details .dtr-title {
        min-width: auto;
        width: 100%;
        justify-content: flex-start;
    }
    
    .dtr-details .dtr-data {
        width: 100%;
        text-align: left;
    }
    
    .expanded-image-container {
        width: 100%;
    }
    
    .expanded-image {
        max-width: 100%;
        height: auto;
    }
    
    .expanded-no-image {
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }
}

/* Desktop styling */
@media (min-width: 769px) {
    #itemTable {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    #itemTable th {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #2c3e50;
        padding: 12px 8px;
        white-space: nowrap;
        position: relative;
    }
    
    #itemTable th:first-child {
        width: 40px;
        text-align: center;
    }
    
    #itemTable td {
        padding: 10px 8px;
        vertical-align: middle;
        border-bottom: 1px solid #f8f9fa;
        position: relative;
    }
    
    #itemTable td.expand-control {
        text-align: center;
        width: 40px;
    }
    
    #itemTable tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    /* Action buttons styling for desktop */
    .action-buttons {
        min-width: 80px;
        white-space: nowrap;
    }
    
    .action-buttons .btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    
    .action-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .action-buttons .btn.btn-light-primary:hover {
        background-color: #0d6efd !important;
        color: white !important;
    }
    
    .action-buttons .btn.btn-light-danger:hover {
        background-color: #dc3545 !important;
        color: white !important;
    }
    
    .action-buttons .btn i {
        font-size: 16px;
    }
    
    /* Hover effect for expand icon */
    #itemTable tbody tr:hover td.expand-control:before {
        transform: translate(-50%, -50%) scale(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }
}

/* Image styling */
.table-image {
    border-radius: 6px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    cursor: pointer;
}

.table-image:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    border-color: #0d6efd;
}

.no-image.table-image {
    border: 2px dashed #dee2e6;
    color: #adb5bd;
}

.no-image.table-image:hover {
    border-color: #0d6efd;
    color: #0d6efd;
}

/* Status badges */
.badge.bg-success {
    background-color: #d1fae5 !important;
    color: #065f46 !important;
}

.badge.bg-danger {
    background-color: #fee2e2 !important;
    color: #991b1b !important;
}

.badge.bg-warning {
    background-color: #fef3c7 !important;
    color: #92400e !important;
}

.badge.bg-primary {
    background-color: #dbeafe !important;
    color: #1e40af !important;
}

.badge.bg-info {
    background-color: #e0f2fe !important;
    color: #0c4a6e !important;
}

/* Stock indicators */
.stock-low {
    color: #ffc107;
    font-weight: bold;
}

.stock-out {
    color: #dc3545;
    font-weight: bold;
}

/* Column header tooltip */
[data-bs-toggle="tooltip"] {
    cursor: help;
}

/* DataTables custom styling */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    border: 1px solid #dee2e6 !important;
    border-radius: 6px !important;
    margin: 0 2px;
    transition: all 0.2s ease;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #f8f9fa !important;
    border-color: #0d6efd !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;
    color: white !important;
    border-color: #0d6efd !important;
    box-shadow: 0 2px 4px rgba(13, 110, 253, 0.3);
}

.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    margin-bottom: 15px;
}

/* Print styles */
@media print {
    .action-buttons,
    .dataTables_wrapper .dt-buttons,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_paginate,
    .expand-control,
    .dtr-details {
        display: none !important;
    }
    
    #itemTable {
        width: 100% !important;
        border-collapse: collapse !important;
    }
    
    #itemTable th,
    #itemTable td {
        border: 1px solid #000 !important;
        padding: 6px !important;
    }
    
    #itemTable th:first-child,
    #itemTable td:first-child {
        display: none !important;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable with responsive expand/collapse
    var table = $('#itemTable').DataTable({
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="ti ti-copy"></i> <?php echo e(__("Copy")); ?>',
                className: 'btn btn-light-secondary btn-sm',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                text: '<i class="ti ti-file-spreadsheet"></i> <?php echo e(__("Excel")); ?>',
                className: 'btn btn-light-secondary btn-sm',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                text: '<i class="ti ti-file-type-pdf"></i> <?php echo e(__("PDF")); ?>',
                className: 'btn btn-light-secondary btn-sm',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                text: '<i class="ti ti-printer"></i> <?php echo e(__("Print")); ?>',
                className: 'btn btn-light-secondary btn-sm',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ],
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All']
        ],
        pageLength: 25,
        responsive: {
            details: {
                type: 'column',
                target: 0, // Target the first column (expand control)
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col, i) {
                        // Skip the expand control column
                        if (col.columnIndex === 0) return '';
                        
                        // Get the item data from the row
                        var rowData = api.row(rowIdx).data();
                        var item = rowData._itemData; // We'll store item data in a custom property
                        
                        // For image column, show larger image in expanded view
                        if (col.columnIndex === 2) {
                            var imageHtml = '';
                            if (item && item.image) {
                                imageHtml = '<div class="expanded-image-container">' +
                                            '<img src="' + item.image + '" alt="' + item.name + '" class="expanded-image">' +
                                            '</div>';
                            } else {
                                imageHtml = '<div class="expanded-image-container">' +
                                            '<div class="expanded-no-image">' +
                                            '<i class="ti ti-photo"></i>' +
                                            '</div>' +
                                            '</div>';
                            }
                            return col.title + ': ' + imageHtml;
                        }
                        
                        // For HSN and other custom fields
                        if (col.columnIndex === 3) { // Item Code column
                            var hsnInfo = '';
                            if (item && item.hsn) {
                                hsnInfo = '<br><small class="text-muted">HSN: ' + item.hsn + '</small>';
                            }
                            return col.title + ': ' + col.data + hsnInfo;
                        }
                        
                        return col.title + ': ' + col.data;
                    }).join('');
                    
                    return data ? $('<div/>').addClass('dtr-details').html('<ul>' + data + '</ul>') : false;
                }
            }
        },
        columnDefs: [
            {
                orderable: false,
                className: 'dtr-control expand-control',
                targets: 0
            },
            {
                orderable: false,
                targets: [1, 2, 14] // S.No, Image, and Action columns
            },
            {
                className: 'all',
                targets: [3, 4, 8, 14] // Always show Item Code, Item Name, Stock, Action
            },
            {
                className: 'min-tablet',
                targets: [5, 6, 7, 9, 10, 11, 12, 13] // Hide on mobile
            }
        ],
        order: [[1, 'asc']],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search items...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ items",
            infoEmpty: "Showing 0 to 0 of 0 items",
            infoFiltered: "(filtered from _MAX_ total items)",
            zeroRecords: "No matching items found",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        createdRow: function(row, data, dataIndex) {
            // Store item data in the row for use in expand renderer
            var api = this.api();
            var item = api.row(dataIndex).data();
            $(row).find('td').data('item-id', item ? item[0] : null);
            
            // Add click event to expand/collapse when clicking anywhere in the row
            $(row).on('click', function(e) {
                if (!$(e.target).closest('.action-buttons, .expand-control').length) {
                    var tr = $(this).closest('tr');
                    var row = table.row(tr);
                    if (row.child.isShown()) {
                        row.child.hide();
                        tr.removeClass('parent');
                    } else {
                        // Show expanded details
                        showExpandedDetails(row, tr, dataIndex);
                    }
                }
            });
        }
    });
    
    // Function to show expanded details
    function showExpandedDetails(row, tr, dataIndex) {
        var api = table.api();
        var rowData = api.row(dataIndex).data();
        
        // Get the item data (assuming item data is stored somewhere accessible)
        // This would need to be adjusted based on how your data is structured
        var itemData = {
            name: rowData[4], // Item Name
            sku: rowData[3], // Item Code
            hsn: rowData._hsn || '', // Assuming HSN is stored in a custom property
            image: rowData._image || '', // Assuming image URL is stored in a custom property
            description: rowData[5],
            brand: rowData[6],
            category: rowData[7],
            unit: rowData[8],
            stock: rowData[9],
            alert_quantity: rowData[10],
            sales_price: rowData[11],
            tax: rowData[12],
            status: rowData[13]
        };
        
        // Create expanded content
        var expandedContent = '<div class="expanded-details-container">' +
            '<div class="row">' +
                '<div class="col-md-4">' +
                    '<div class="expanded-image-section text-center mb-3">' +
                        (itemData.image ? 
                            '<img src="' + itemData.image + '" alt="' + itemData.name + '" class="expanded-image img-fluid">' :
                            '<div class="expanded-no-image mx-auto">' +
                                '<i class="ti ti-photo"></i>' +
                            '</div>') +
                    '</div>' +
                '</div>' +
                '<div class="col-md-8">' +
                    '<div class="expanded-info-section">' +
                        '<h5 class="mb-3">' + itemData.name + '</h5>' +
                        '<div class="row">' +
                            '<div class="col-6 mb-2">' +
                                '<strong>Item Code:</strong><br>' +
                                '<span class="badge bg-primary">' + itemData.sku + '</span>' +
                            '</div>' +
                            '<div class="col-6 mb-2">' +
                                '<strong>HSN:</strong><br>' +
                                '<span class="text-muted">' + (itemData.hsn || 'N/A') + '</span>' +
                            '</div>' +
                            '<div class="col-6 mb-2">' +
                                '<strong>Brand:</strong><br>' +
                                '<span>' + (itemData.brand || 'N/A') + '</span>' +
                            '</div>' +
                            '<div class="col-6 mb-2">' +
                                '<strong>Category:</strong><br>' +
                                '<span>' + (itemData.category || 'N/A') + '</span>' +
                            '</div>' +
                            '<div class="col-12 mb-2">' +
                                '<strong>Description:</strong><br>' +
                                '<span class="text-muted">' + (itemData.description || 'No description') + '</span>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>';
        
        // Show the expanded content
        row.child(expandedContent).show();
        tr.addClass('parent');
    }
    
    // Filter functionality
    $('#apply-filters').on('click', function() {
        var companyFilter = $('#company-filter').val();
        var categoryFilter = $('#category-filter').val();
        
        // Clear all filters first
        table.columns().search('');
        
        // Apply filters
        if (companyFilter) {
            table.search(companyFilter).draw();
        }
        
        if (categoryFilter) {
            table.column(7).search(categoryFilter).draw(); // Category column
        }
        
        if (!companyFilter && !categoryFilter) {
            table.search('').draw();
        }
    });
    
    $('#reset-filters').on('click', function() {
        $('#company-filter').val('');
        $('#category-filter').val('');
        table.search('').columns().search('').draw();
    });
    
    // Delete confirmation
    $(document).on('click', '.bs-pass-para', function(e) {
        e.preventDefault();
        e.stopPropagation(); // Prevent row click event
        
        const formId = $(this).data('confirm-yes');
        const confirmText = $(this).data('text');
        const confirmMessage = $(this).data('confirm');
        
        if (confirm(confirmMessage + '\n\n' + confirmText)) {
            document.getElementById(formId).submit();
        }
    });
    
    // Prevent action buttons from triggering row click
    $(document).on('click', '.action-buttons a, .action-buttons button', function(e) {
        e.stopPropagation();
    });
    
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Mobile-specific adjustments
    function adjustForMobile() {
        if ($(window).width() <= 768) {
            // Hide expand control column header on mobile
            $('#itemTable thead th:first-child').hide();
        } else {
            $('#itemTable thead th:first-child').show();
        }
    }
    
    // Adjust on load and resize
    adjustForMobile();
    $(window).resize(adjustForMobile);
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-erp\resources\views/items/index.blade.php ENDPATH**/ ?>