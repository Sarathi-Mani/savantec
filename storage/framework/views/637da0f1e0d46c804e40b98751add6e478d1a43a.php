
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Create New Role')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('roles.index')); ?>"><?php echo e(__('Role')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Create')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php echo e(Form::open(array('url'=>'roles','method'=>'post'))); ?>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <?php echo e(Form::label('name',__('Role Name'),['class'=>'form-label'])); ?>

                                <?php echo e(Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Role Name'),'required'=>'required'))); ?>

                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                </small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group">
                                <?php echo e(Form::label('description',__('Description'),['class'=>'form-label'])); ?>

                                <?php echo e(Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description (Optional)'),'rows'=>'2'))); ?>

                                <small class="text-muted"><?php echo e(__('Optional')); ?></small>
                            </div>

                            <?php $__errorArgs = ['permissions'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert alert-danger">
                                <strong class="text-danger"><?php echo e($message); ?></strong>
                            </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php if(!empty($permissions)): ?>
                                        <h6 class="my-3"><?php echo e(__('Assign Permissions to Role')); ?></h6>
                                        
                                        <!-- Category Buttons -->
                                        <div class="d-flex flex-wrap gap-2 mb-4">
                                            <button type="button" class="btn btn-outline-primary category-btn active" data-category="all">
                                                <?php echo e(__('All')); ?>

                                            </button>
                                            <button type="button" class="btn btn-outline-primary category-btn" data-category="inventory">
                                                <?php echo e(__('Inventory')); ?>

                                            </button>
                                            <button type="button" class="btn btn-outline-primary category-btn" data-category="sales">
                                                <?php echo e(__('Sales')); ?>

                                            </button>
                                            <button type="button" class="btn btn-outline-primary category-btn" data-category="purchase">
                                                <?php echo e(__('Purchase')); ?>

                                            </button>
                                            <button type="button" class="btn btn-outline-primary category-btn" data-category="reports">
                                                <?php echo e(__('Reports')); ?>

                                            </button>
                                            <button type="button" class="btn btn-outline-primary category-btn" data-category="accounts">
                                                <?php echo e(__('Accounts')); ?>

                                            </button>
                                            <button type="button" class="btn btn-outline-primary category-btn" data-category="others">
                                                <?php echo e(__('Others')); ?>

                                            </button>
                                        </div>

                                        <!-- Select All Checkbox -->
                                        <div class="d-flex justify-content-end mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkAll">
                                                <label class="form-check-label fw-bold" for="checkAll"><?php echo e(__('Select All Permissions')); ?></label>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0" id="dataTable-1">
                                                <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="25%">
                                                        <div class="form-check">
                                                            <?php echo e(__('Modules')); ?>

                                                        </div>
                                                    </th>
                                                    <th width="70%"><?php echo e(__('Specific Permissions')); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <!-- Category: INVENTORY -->
                                                <!-- Module 3: Tax -->
                                                <tr class="permission-row" data-categories="inventory,others">
                                                    <td>1</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_tax">
                                                            <label class="form-check-label" for="module_tax"><strong><?php echo e(__('Tax')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-tax" name="permissions[]" value="tax_view" id="permission_tax_view">
                                                                <label class="form-check-label" for="permission_tax_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-tax" name="permissions[]" value="tax_add" id="permission_tax_add">
                                                                <label class="form-check-label" for="permission_tax_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-tax" name="permissions[]" value="tax_edit" id="permission_tax_edit">
                                                                <label class="form-check-label" for="permission_tax_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-tax" name="permissions[]" value="tax_delete" id="permission_tax_delete">
                                                                <label class="form-check-label" for="permission_tax_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 4: Units -->
                                                <tr class="permission-row" data-categories="inventory">
                                                    <td>2</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_units">
                                                            <label class="form-check-label" for="module_units"><strong><?php echo e(__('Units')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-units" name="permissions[]" value="unit_view" id="permission_unit_view">
                                                                <label class="form-check-label" for="permission_unit_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-units" name="permissions[]" value="unit_add" id="permission_unit_add">
                                                                <label class="form-check-label" for="permission_unit_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-units" name="permissions[]" value="unit_edit" id="permission_unit_edit">
                                                                <label class="form-check-label" for="permission_unit_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-units" name="permissions[]" value="unit_delete" id="permission_unit_delete">
                                                                <label class="form-check-label" for="permission_unit_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 11: Items -->
                                                <tr class="permission-row" data-categories="inventory">
                                                    <td>3</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_items">
                                                            <label class="form-check-label" for="module_items"><strong><?php echo e(__('Items')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_view" id="permission_item_view">
                                                                <label class="form-check-label" for="permission_item_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_add" id="permission_item_add">
                                                                <label class="form-check-label" for="permission_item_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_edit" id="permission_item_edit">
                                                                <label class="form-check-label" for="permission_item_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_delete" id="permission_item_delete">
                                                                <label class="form-check-label" for="permission_item_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                            <!-- Category Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_category_view" id="permission_item_category_view">
                                                                <label class="form-check-label" for="permission_item_category_view"><?php echo e(__('Category View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_category_add" id="permission_item_category_add">
                                                                <label class="form-check-label" for="permission_item_category_add"><?php echo e(__('Category Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_category_edit" id="permission_item_category_edit">
                                                                <label class="form-check-label" for="permission_item_category_edit"><?php echo e(__('Category Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_category_delete" id="permission_item_category_delete">
                                                                <label class="form-check-label" for="permission_item_category_delete"><?php echo e(__('Category Delete')); ?></label>
                                                            </div>
                                                            <!-- Special Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="print_labels" id="permission_print_labels">
                                                                <label class="form-check-label" for="permission_print_labels"><?php echo e(__('Print Labels')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="import_items" id="permission_import_items">
                                                                <label class="form-check-label" for="permission_import_items"><?php echo e(__('Import Items')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 12: Stock Transfer -->
                                                <tr class="permission-row" data-categories="inventory">
                                                    <td>4</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_stock_transfer">
                                                            <label class="form-check-label" for="module_stock_transfer"><strong><?php echo e(__('Stock Transfer')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-transfer" name="permissions[]" value="stock_transfer_view" id="permission_stock_transfer_view">
                                                                <label class="form-check-label" for="permission_stock_transfer_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-transfer" name="permissions[]" value="stock_transfer_add" id="permission_stock_transfer_add">
                                                                <label class="form-check-label" for="permission_stock_transfer_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-transfer" name="permissions[]" value="stock_transfer_edit" id="permission_stock_transfer_edit">
                                                                <label class="form-check-label" for="permission_stock_transfer_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-transfer" name="permissions[]" value="stock_transfer_delete" id="permission_stock_transfer_delete">
                                                                <label class="form-check-label" for="permission_stock_transfer_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 13: Stock Journal -->
                                                <tr class="permission-row" data-categories="inventory">
                                                    <td>5</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_stock_journal">
                                                            <label class="form-check-label" for="module_stock_journal"><strong><?php echo e(__('Stock Journal')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-journal" name="permissions[]" value="stock_journal_view" id="permission_stock_journal_view">
                                                                <label class="form-check-label" for="permission_stock_journal_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-journal" name="permissions[]" value="stock_journal_add" id="permission_stock_journal_add">
                                                                <label class="form-check-label" for="permission_stock_journal_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-journal" name="permissions[]" value="stock_journal_edit" id="permission_stock_journal_edit">
                                                                <label class="form-check-label" for="permission_stock_journal_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-journal" name="permissions[]" value="stock_journal_delete" id="permission_stock_journal_delete">
                                                                <label class="form-check-label" for="permission_stock_journal_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 14: Stock Adjustment -->
                                                <tr class="permission-row" data-categories="inventory">
                                                    <td>6</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_stock_adjustment">
                                                            <label class="form-check-label" for="module_stock_adjustment"><strong><?php echo e(__('Stock Adjustment')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-adjustment" name="permissions[]" value="stock_adjustment_view" id="permission_stock_adjustment_view">
                                                                <label class="form-check-label" for="permission_stock_adjustment_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-adjustment" name="permissions[]" value="stock_adjustment_add" id="permission_stock_adjustment_add">
                                                                <label class="form-check-label" for="permission_stock_adjustment_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-adjustment" name="permissions[]" value="stock_adjustment_edit" id="permission_stock_adjustment_edit">
                                                                <label class="form-check-label" for="permission_stock_adjustment_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-adjustment" name="permissions[]" value="stock_adjustment_delete" id="permission_stock_adjustment_delete">
                                                                <label class="form-check-label" for="permission_stock_adjustment_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 15: Brand -->
                                                <tr class="permission-row" data-categories="inventory">
                                                    <td>7</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_brand">
                                                            <label class="form-check-label" for="module_brand"><strong><?php echo e(__('Brand')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-brand" name="permissions[]" value="brand_view" id="permission_brand_view">
                                                                <label class="form-check-label" for="permission_brand_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-brand" name="permissions[]" value="brand_add" id="permission_brand_add">
                                                                <label class="form-check-label" for="permission_brand_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-brand" name="permissions[]" value="brand_edit" id="permission_brand_edit">
                                                                <label class="form-check-label" for="permission_brand_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-brand" name="permissions[]" value="brand_delete" id="permission_brand_delete">
                                                                <label class="form-check-label" for="permission_brand_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 16: Variant -->
                                                <tr class="permission-row" data-categories="inventory">
                                                    <td>8</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_variant">
                                                            <label class="form-check-label" for="module_variant"><strong><?php echo e(__('Variant')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-variant" name="permissions[]" value="variant_view" id="permission_variant_view">
                                                                <label class="form-check-label" for="permission_variant_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-variant" name="permissions[]" value="variant_add" id="permission_variant_add">
                                                                <label class="form-check-label" for="permission_variant_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-variant" name="permissions[]" value="variant_edit" id="permission_variant_edit">
                                                                <label class="form-check-label" for="permission_variant_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-variant" name="permissions[]" value="variant_delete" id="permission_variant_delete">
                                                                <label class="form-check-label" for="permission_variant_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Category: SALES -->
                                                <!-- Module 18: Customers -->
                                                <tr class="permission-row" data-categories="sales">
                                                    <td>9</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_customers">
                                                            <label class="form-check-label" for="module_customers"><strong><?php echo e(__('Customers')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customers" name="permissions[]" value="customer_view" id="permission_customer_view">
                                                                <label class="form-check-label" for="permission_customer_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customers" name="permissions[]" value="customer_add" id="permission_customer_add">
                                                                <label class="form-check-label" for="permission_customer_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customers" name="permissions[]" value="customer_edit" id="permission_customer_edit">
                                                                <label class="form-check-label" for="permission_customer_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customers" name="permissions[]" value="customer_delete" id="permission_customer_delete">
                                                                <label class="form-check-label" for="permission_customer_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                            <!-- Special Permission -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customers" name="permissions[]" value="import_customers" id="permission_import_customers">
                                                                <label class="form-check-label" for="permission_import_customers"><?php echo e(__('Import Customers')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 19: Customers Advance Payments -->
                                                <tr class="permission-row" data-categories="sales">
                                                    <td>10</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_customer_advance">
                                                            <label class="form-check-label" for="module_customer_advance"><strong><?php echo e(__('Customers Advance Payments')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customer-advance" name="permissions[]" value="customer_advance_view" id="permission_customer_advance_view">
                                                                <label class="form-check-label" for="permission_customer_advance_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customer-advance" name="permissions[]" value="customer_advance_add" id="permission_customer_advance_add">
                                                                <label class="form-check-label" for="permission_customer_advance_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customer-advance" name="permissions[]" value="customer_advance_edit" id="permission_customer_advance_edit">
                                                                <label class="form-check-label" for="permission_customer_advance_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customer-advance" name="permissions[]" value="customer_advance_delete" id="permission_customer_advance_delete">
                                                                <label class="form-check-label" for="permission_customer_advance_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 24: Sales -->
                                                <tr class="permission-row" data-categories="sales">
                                                    <td>11</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_sales">
                                                            <label class="form-check-label" for="module_sales"><strong><?php echo e(__('Sales')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="sales_view" id="permission_sales_view">
                                                                <label class="form-check-label" for="permission_sales_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="sales_add" id="permission_sales_add">
                                                                <label class="form-check-label" for="permission_sales_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="sales_edit" id="permission_sales_edit">
                                                                <label class="form-check-label" for="permission_sales_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="sales_delete" id="permission_sales_delete">
                                                                <label class="form-check-label" for="permission_sales_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                            <!-- Sales Payments -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="sales_payments_view" id="permission_sales_payments_view">
                                                                <label class="form-check-label" for="permission_sales_payments_view"><?php echo e(__('Sales Payments View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="sales_payments_add" id="permission_sales_payments_add">
                                                                <label class="form-check-label" for="permission_sales_payments_add"><?php echo e(__('Sales Payments Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="sales_payments_delete" id="permission_sales_payments_delete">
                                                                <label class="form-check-label" for="permission_sales_payments_delete"><?php echo e(__('Sales Payments Delete')); ?></label>
                                                            </div>
                                                            <!-- Special Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="show_all_users_sales_invoices" id="permission_show_all_users_sales_invoices">
                                                                <label class="form-check-label" for="permission_show_all_users_sales_invoices"><?php echo e(__('Show all users Sales Invoices')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="show_item_purchase_price" id="permission_show_item_purchase_price">
                                                                <label class="form-check-label" for="permission_show_item_purchase_price"><?php echo e(__('Show Item Purchase Price')); ?> (<?php echo e(__('While making invoice')); ?>)</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 25: Proforma Invoice -->
                                                <tr class="permission-row" data-categories="sales">
                                                    <td>12</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_proforma_invoice">
                                                            <label class="form-check-label" for="module_proforma_invoice"><strong><?php echo e(__('Proforma Invoice')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-proforma-invoice" name="permissions[]" value="proforma_invoice_view" id="permission_proforma_invoice_view">
                                                                <label class="form-check-label" for="permission_proforma_invoice_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-proforma-invoice" name="permissions[]" value="proforma_invoice_add" id="permission_proforma_invoice_add">
                                                                <label class="form-check-label" for="permission_proforma_invoice_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-proforma-invoice" name="permissions[]" value="proforma_invoice_edit" id="permission_proforma_invoice_edit">
                                                                <label class="form-check-label" for="permission_proforma_invoice_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-proforma-invoice" name="permissions[]" value="proforma_invoice_delete" id="permission_proforma_invoice_delete">
                                                                <label class="form-check-label" for="permission_proforma_invoice_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 26: Delivery Challan In -->
                                                <tr class="permission-row" data-categories="sales">
                                                    <td>13</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_delivery_challan_in">
                                                            <label class="form-check-label" for="module_delivery_challan_in"><strong><?php echo e(__('Delivery Challan In')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-in" name="permissions[]" value="delivery_challan_in_view" id="permission_delivery_challan_in_view">
                                                                <label class="form-check-label" for="permission_delivery_challan_in_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-in" name="permissions[]" value="delivery_challan_in_add" id="permission_delivery_challan_in_add">
                                                                <label class="form-check-label" for="permission_delivery_challan_in_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-in" name="permissions[]" value="delivery_challan_in_edit" id="permission_delivery_challan_in_edit">
                                                                <label class="form-check-label" for="permission_delivery_challan_in_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-in" name="permissions[]" value="delivery_challan_in_delete" id="permission_delivery_challan_in_delete">
                                                                <label class="form-check-label" for="permission_delivery_challan_in_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 27: Delivery Challan Out -->
                                                <tr class="permission-row" data-categories="sales">
                                                    <td>14</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_delivery_challan_out">
                                                            <label class="form-check-label" for="module_delivery_challan_out"><strong><?php echo e(__('Delivery Challan Out')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-out" name="permissions[]" value="delivery_challan_out_view" id="permission_delivery_challan_out_view">
                                                                <label class="form-check-label" for="permission_delivery_challan_out_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-out" name="permissions[]" value="delivery_challan_out_add" id="permission_delivery_challan_out_add">
                                                                <label class="form-check-label" for="permission_delivery_challan_out_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-out" name="permissions[]" value="delivery_challan_out_edit" id="permission_delivery_challan_out_edit">
                                                                <label class="form-check-label" for="permission_delivery_challan_out_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-out" name="permissions[]" value="delivery_challan_out_delete" id="permission_delivery_challan_out_delete">
                                                                <label class="form-check-label" for="permission_delivery_challan_out_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 28: Salesorder -->
                                                <tr class="permission-row" data-categories="sales">
                                                    <td>15</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_salesorder">
                                                            <label class="form-check-label" for="module_salesorder"><strong><?php echo e(__('Salesorder')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-salesorder" name="permissions[]" value="salesorder_view" id="permission_salesorder_view">
                                                                <label class="form-check-label" for="permission_salesorder_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-salesorder" name="permissions[]" value="salesorder_add" id="permission_salesorder_add">
                                                                <label class="form-check-label" for="permission_salesorder_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-salesorder" name="permissions[]" value="salesorder_edit" id="permission_salesorder_edit">
                                                                <label class="form-check-label" for="permission_salesorder_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-salesorder" name="permissions[]" value="salesorder_delete" id="permission_salesorder_delete">
                                                                <label class="form-check-label" for="permission_salesorder_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 29: Discount Coupon -->
                                                <tr class="permission-row" data-categories="sales">
                                                    <td>16</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_discount_coupon">
                                                            <label class="form-check-label" for="module_discount_coupon"><strong><?php echo e(__('Discount Coupon')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-discount-coupon" name="permissions[]" value="discount_coupon_view" id="permission_discount_coupon_view">
                                                                <label class="form-check-label" for="permission_discount_coupon_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-discount-coupon" name="permissions[]" value="discount_coupon_add" id="permission_discount_coupon_add">
                                                                <label class="form-check-label" for="permission_discount_coupon_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-discount-coupon" name="permissions[]" value="discount_coupon_edit" id="permission_discount_coupon_edit">
                                                                <label class="form-check-label" for="permission_discount_coupon_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-discount-coupon" name="permissions[]" value="discount_coupon_delete" id="permission_discount_coupon_delete">
                                                                <label class="form-check-label" for="permission_discount_coupon_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 30: Quotation -->
                                                <tr class="permission-row" data-categories="sales">
                                                    <td>17</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_quotation">
                                                            <label class="form-check-label" for="module_quotation"><strong><?php echo e(__('Quotation')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-quotation" name="permissions[]" value="quotation_view" id="permission_quotation_view">
                                                                <label class="form-check-label" for="permission_quotation_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-quotation" name="permissions[]" value="quotation_add" id="permission_quotation_add">
                                                                <label class="form-check-label" for="permission_quotation_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-quotation" name="permissions[]" value="quotation_edit" id="permission_quotation_edit">
                                                                <label class="form-check-label" for="permission_quotation_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-quotation" name="permissions[]" value="quotation_delete" id="permission_quotation_delete">
                                                                <label class="form-check-label" for="permission_quotation_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                            <!-- Special Permission -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-quotation" name="permissions[]" value="show_all_users_quotations" id="permission_show_all_users_quotations">
                                                                <label class="form-check-label" for="permission_show_all_users_quotations"><?php echo e(__('Show all users Quotations')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 31: Sales Return -->
                                                <tr class="permission-row" data-categories="sales">
                                                    <td>18</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_sales_return">
                                                            <label class="form-check-label" for="module_sales_return"><strong><?php echo e(__('Sales Return')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="sales_return_view" id="permission_sales_return_view">
                                                                <label class="form-check-label" for="permission_sales_return_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="sales_return_add" id="permission_sales_return_add">
                                                                <label class="form-check-label" for="permission_sales_return_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="sales_return_edit" id="permission_sales_return_edit">
                                                                <label class="form-check-label" for="permission_sales_return_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="sales_return_delete" id="permission_sales_return_delete">
                                                                <label class="form-check-label" for="permission_sales_return_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                            <!-- Sales Return Payments -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="sales_return_payments_view" id="permission_sales_return_payments_view">
                                                                <label class="form-check-label" for="permission_sales_return_payments_view"><?php echo e(__('Sales Return Payments View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="sales_return_payments_add" id="permission_sales_return_payments_add">
                                                                <label class="form-check-label" for="permission_sales_return_payments_add"><?php echo e(__('Sales Return Payments Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="sales_return_payments_delete" id="permission_sales_return_payments_delete">
                                                                <label class="form-check-label" for="permission_sales_return_payments_delete"><?php echo e(__('Sales Return Payments Delete')); ?></label>
                                                            </div>
                                                            <!-- Special Permission -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="show_all_users_sales_return_invoices" id="permission_show_all_users_sales_return_invoices">
                                                                <label class="form-check-label" for="permission_show_all_users_sales_return_invoices"><?php echo e(__('Show all users Sales Return Invoices')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Category: PURCHASE -->
                                                <!-- Module 17: Suppliers -->
                                                <tr class="permission-row" data-categories="purchase">
                                                    <td>19</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_suppliers">
                                                            <label class="form-check-label" for="module_suppliers"><strong><?php echo e(__('Suppliers')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-suppliers" name="permissions[]" value="supplier_view" id="permission_supplier_view">
                                                                <label class="form-check-label" for="permission_supplier_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-suppliers" name="permissions[]" value="supplier_add" id="permission_supplier_add">
                                                                <label class="form-check-label" for="permission_supplier_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-suppliers" name="permissions[]" value="supplier_edit" id="permission_supplier_edit">
                                                                <label class="form-check-label" for="permission_supplier_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-suppliers" name="permissions[]" value="supplier_delete" id="permission_supplier_delete">
                                                                <label class="form-check-label" for="permission_supplier_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                            <!-- Special Permission -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-suppliers" name="permissions[]" value="import_suppliers" id="permission_import_suppliers">
                                                                <label class="form-check-label" for="permission_import_suppliers"><?php echo e(__('Import Suppliers')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 20: Supplier Advance Payments -->
                                                <tr class="permission-row" data-categories="purchase">
                                                    <td>20</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_supplier_advance">
                                                            <label class="form-check-label" for="module_supplier_advance"><strong><?php echo e(__('Supplier Advance Payments')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-supplier-advance" name="permissions[]" value="supplier_advance_view" id="permission_supplier_advance_view">
                                                                <label class="form-check-label" for="permission_supplier_advance_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-supplier-advance" name="permissions[]" value="supplier_advance_add" id="permission_supplier_advance_add">
                                                                <label class="form-check-label" for="permission_supplier_advance_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-supplier-advance" name="permissions[]" value="supplier_advance_edit" id="permission_supplier_advance_edit">
                                                                <label class="form-check-label" for="permission_supplier_advance_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-supplier-advance" name="permissions[]" value="supplier_advance_delete" id="permission_supplier_advance_delete">
                                                                <label class="form-check-label" for="permission_supplier_advance_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 21: Purchase -->
                                                <tr class="permission-row" data-categories="purchase">
                                                    <td>21</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_purchase">
                                                            <label class="form-check-label" for="module_purchase"><strong><?php echo e(__('Purchase')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="purchase_view" id="permission_purchase_view">
                                                                <label class="form-check-label" for="permission_purchase_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="purchase_add" id="permission_purchase_add">
                                                                <label class="form-check-label" for="permission_purchase_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="purchase_edit" id="permission_purchase_edit">
                                                                <label class="form-check-label" for="permission_purchase_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="purchase_delete" id="permission_purchase_delete">
                                                                <label class="form-check-label" for="permission_purchase_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                            <!-- Purchase Payments -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="purchase_payments_view" id="permission_purchase_payments_view">
                                                                <label class="form-check-label" for="permission_purchase_payments_view"><?php echo e(__('Purchase Payments View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="purchase_payments_add" id="permission_purchase_payments_add">
                                                                <label class="form-check-label" for="permission_purchase_payments_add"><?php echo e(__('Purchase Payments Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="purchase_payments_delete" id="permission_purchase_payments_delete">
                                                                <label class="form-check-label" for="permission_purchase_payments_delete"><?php echo e(__('Purchase Payments Delete')); ?></label>
                                                            </div>
                                                            <!-- Special Permission -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="show_all_users_purchase_invoices" id="permission_show_all_users_purchase_invoices">
                                                                <label class="form-check-label" for="permission_show_all_users_purchase_invoices"><?php echo e(__('Show all users Purchase Invoices')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 22: Purchase Order -->
                                                <tr class="permission-row" data-categories="purchase">
                                                    <td>22</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_purchase_order">
                                                            <label class="form-check-label" for="module_purchase_order"><strong><?php echo e(__('Purchase Order')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-order" name="permissions[]" value="purchase_order_view" id="permission_purchase_order_view">
                                                                <label class="form-check-label" for="permission_purchase_order_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-order" name="permissions[]" value="purchase_order_add" id="permission_purchase_order_add">
                                                                <label class="form-check-label" for="permission_purchase_order_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-order" name="permissions[]" value="purchase_order_edit" id="permission_purchase_order_edit">
                                                                <label class="form-check-label" for="permission_purchase_order_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-order" name="permissions[]" value="purchase_order_delete" id="permission_purchase_order_delete">
                                                                <label class="form-check-label" for="permission_purchase_order_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 23: Purchase Return -->
                                                <tr class="permission-row" data-categories="purchase">
                                                    <td>23</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_purchase_return">
                                                            <label class="form-check-label" for="module_purchase_return"><strong><?php echo e(__('Purchase Return')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="purchase_return_view" id="permission_purchase_return_view">
                                                                <label class="form-check-label" for="permission_purchase_return_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="purchase_return_add" id="permission_purchase_return_add">
                                                                <label class="form-check-label" for="permission_purchase_return_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="purchase_return_edit" id="permission_purchase_return_edit">
                                                                <label class="form-check-label" for="permission_purchase_return_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="purchase_return_delete" id="permission_purchase_return_delete">
                                                                <label class="form-check-label" for="permission_purchase_return_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                            <!-- Purchase Return Payments -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="purchase_return_payments_view" id="permission_purchase_return_payments_view">
                                                                <label class="form-check-label" for="permission_purchase_return_payments_view"><?php echo e(__('Purchase Return Payments View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="purchase_return_payments_add" id="permission_purchase_return_payments_add">
                                                                <label class="form-check-label" for="permission_purchase_return_payments_add"><?php echo e(__('Purchase Return Payments Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="purchase_return_payments_delete" id="permission_purchase_return_payments_delete">
                                                                <label class="form-check-label" for="permission_purchase_return_payments_delete"><?php echo e(__('Purchase Return Payments Delete')); ?></label>
                                                            </div>
                                                            <!-- Special Permission -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="show_all_users_purchase_return_invoices" id="permission_show_all_users_purchase_return_invoices">
                                                                <label class="form-check-label" for="permission_show_all_users_purchase_return_invoices"><?php echo e(__('Show all users Purchase Return Invoices')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Category: ACCOUNTS -->
                                                <!-- Module 9: Accounts -->
                                                <tr class="permission-row" data-categories="accounts">
                                                    <td>24</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_accounts">
                                                            <label class="form-check-label" for="module_accounts"><strong><?php echo e(__('Accounts')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="account_view" id="permission_account_view">
                                                                <label class="form-check-label" for="permission_account_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="account_add" id="permission_account_add">
                                                                <label class="form-check-label" for="permission_account_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="account_edit" id="permission_account_edit">
                                                                <label class="form-check-label" for="permission_account_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="account_delete" id="permission_account_delete">
                                                                <label class="form-check-label" for="permission_account_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                            <!-- Money Deposit -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_deposit_view" id="permission_money_deposit_view">
                                                                <label class="form-check-label" for="permission_money_deposit_view"><?php echo e(__('View Money Deposit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_deposit_add" id="permission_money_deposit_add">
                                                                <label class="form-check-label" for="permission_money_deposit_add"><?php echo e(__('Add Money Deposit ')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_deposit_edit" id="permission_money_deposit_edit">
                                                                <label class="form-check-label" for="permission_money_deposit_edit"><?php echo e(__('Edit Money Deposit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_deposit_delete" id="permission_money_deposit_delete">
                                                                <label class="form-check-label" for="permission_money_deposit_delete"><?php echo e(__('Delete Money Deposit')); ?></label>
                                                            </div>
                                                            <!-- Cash Flow -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="cash_flow_view" id="permission_cash_flow_view">
                                                                <label class="form-check-label" for="permission_cash_flow_view"><?php echo e(__('View Cash Flow')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="cash_flow_add" id="permission_cash_flow_add">
                                                                <label class="form-check-label" for="permission_cash_flow_add"><?php echo e(__('Add Cash Flow')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="cash_flow_edit" id="permission_cash_flow_edit">
                                                                <label class="form-check-label" for="permission_cash_flow_edit"><?php echo e(__('Edit Cash Flow')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="cash_flow_delete" id="permission_cash_flow_delete">
                                                                <label class="form-check-label" for="permission_cash_flow_delete"><?php echo e(__('Delete Cash Flow')); ?></label>
                                                            </div>
                                                            <!-- Money Transfer -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_transfer_view" id="permission_money_transfer_view">
                                                                <label class="form-check-label" for="permission_money_transfer_view"><?php echo e(__('View Money Transfer')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_transfer_add" id="permission_money_transfer_add">
                                                                <label class="form-check-label" for="permission_money_transfer_add"><?php echo e(__('Add Money Transfer')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_transfer_edit" id="permission_money_transfer_edit">
                                                                <label class="form-check-label" for="permission_money_transfer_edit"><?php echo e(__('Edit Money Transfer')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_transfer_delete" id="permission_money_transfer_delete">
                                                                <label class="form-check-label" for="permission_money_transfer_delete"><?php echo e(__('Delete Money Transfer')); ?></label>
                                                            </div>
                                                            <!-- Chart of Accounts -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="chart_of_accounts_view" id="permission_chart_of_accounts_view">
                                                                <label class="form-check-label" for="permission_chart_of_accounts_view"><?php echo e(__('View Chart of Accounts')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="chart_of_accounts_add" id="permission_chart_of_accounts_add">
                                                                <label class="form-check-label" for="permission_chart_of_accounts_add"><?php echo e(__('Add Chart of Accounts')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="chart_of_accounts_edit" id="permission_chart_of_accounts_edit">
                                                                <label class="form-check-label" for="permission_chart_of_accounts_edit"><?php echo e(__('Edit Chart of Accounts')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="chart_of_accounts_delete" id="permission_chart_of_accounts_delete">
                                                                <label class="form-check-label" for="permission_chart_of_accounts_delete"><?php echo e(__('Delete Chart of Accounts')); ?></label>
                                                            </div>
                                                            <!-- Entries -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="entries_view" id="permission_entries_view">
                                                                <label class="form-check-label" for="permission_entries_view"><?php echo e(__('View Entries')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="entries_add" id="permission_entries_add">
                                                                <label class="form-check-label" for="permission_entries_add"><?php echo e(__('Add Entries')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="entries_edit" id="permission_entries_edit">
                                                                <label class="form-check-label" for="permission_entries_edit"><?php echo e(__('Edit Entries')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="entries_delete" id="permission_entries_delete">
                                                                <label class="form-check-label" for="permission_entries_delete"><?php echo e(__('Delete Entries')); ?></label>
                                                            </div>
                                                            <!-- Cash Transactions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="cash_transactions" id="permission_cash_transactions">
                                                                <label class="form-check-label" for="permission_cash_transactions"><?php echo e(__('Cash Transactions')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 10: Expense -->
                                                <tr class="permission-row" data-categories="accounts">
                                                    <td>25</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_expense">
                                                            <label class="form-check-label" for="module_expense"><strong><?php echo e(__('Expense')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_view" id="permission_expense_view">
                                                                <label class="form-check-label" for="permission_expense_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_add" id="permission_expense_add">
                                                                <label class="form-check-label" for="permission_expense_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_edit" id="permission_expense_edit">
                                                                <label class="form-check-label" for="permission_expense_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_delete" id="permission_expense_delete">
                                                                <label class="form-check-label" for="permission_expense_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                            <!-- Category Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_category_view" id="permission_expense_category_view">
                                                                <label class="form-check-label" for="permission_expense_category_view"><?php echo e(__('Category View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_category_add" id="permission_expense_category_add">
                                                                <label class="form-check-label" for="permission_expense_category_add"><?php echo e(__('Category Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_category_edit" id="permission_expense_category_edit">
                                                                <label class="form-check-label" for="permission_expense_category_edit"><?php echo e(__('Category Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_category_delete" id="permission_expense_category_delete">
                                                                <label class="form-check-label" for="permission_expense_category_delete"><?php echo e(__('Category Delete')); ?></label>
                                                            </div>
                                                            <!-- Expense Item Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_item_view" id="permission_expense_item_view">
                                                                <label class="form-check-label" for="permission_expense_item_view"><?php echo e(__('view Expense Item')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_item_add" id="permission_expense_item_add">
                                                                <label class="form-check-label" for="permission_expense_item_add"><?php echo e(__('Add Expense Item')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_item_edit" id="permission_expense_item_edit">
                                                                <label class="form-check-label" for="permission_expense_item_edit"><?php echo e(__('Edit Expense Item')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_item_delete" id="permission_expense_item_delete">
                                                                <label class="form-check-label" for="permission_expense_item_delete"><?php echo e(__('Delete Expense Item')); ?></label>
                                                            </div>
                                                            <!-- Special Permission -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="show_all_users_expenses" id="permission_show_all_users_expenses">
                                                                <label class="form-check-label" for="permission_show_all_users_expenses"><?php echo e(__('Show All Users Expenses')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 5: Payment Types -->
                                                <tr class="permission-row" data-categories="accounts">
                                                    <td>26</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_payment_types">
                                                            <label class="form-check-label" for="module_payment_types"><strong><?php echo e(__('Payment Types')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-payment-types" name="permissions[]" value="payment_type_view" id="permission_payment_type_view">
                                                                <label class="form-check-label" for="permission_payment_type_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-payment-types" name="permissions[]" value="payment_type_add" id="permission_payment_type_add">
                                                                <label class="form-check-label" for="permission_payment_type_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-payment-types" name="permissions[]" value="payment_type_edit" id="permission_payment_type_edit">
                                                                <label class="form-check-label" for="permission_payment_type_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-payment-types" name="permissions[]" value="payment_type_delete" id="permission_payment_type_delete">
                                                                <label class="form-check-label" for="permission_payment_type_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Category: REPORTS -->
                                                <!-- Module 32: Reports -->
                                                <tr class="permission-row" data-categories="reports">
                                                    <td>27</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_reports">
                                                            <label class="form-check-label" for="module_reports"><strong><?php echo e(__('Reports')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_delivery_sheet" id="permission_report_delivery_sheet">
                                                                <label class="form-check-label" for="permission_report_delivery_sheet"><?php echo e(__('Delivery Sheet Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_load_sheet" id="permission_report_load_sheet">
                                                                <label class="form-check-label" for="permission_report_load_sheet"><?php echo e(__('Load Sheet Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_customer_orders" id="permission_report_customer_orders">
                                                                <label class="form-check-label" for="permission_report_customer_orders"><?php echo e(__('Customer Orders Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_customer" id="permission_report_customer">
                                                                <label class="form-check-label" for="permission_report_customer"><?php echo e(__('Customer Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_supplier" id="permission_report_supplier">
                                                                <label class="form-check-label" for="permission_report_supplier"><?php echo e(__('Supplier Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_sales_tax" id="permission_report_sales_tax">
                                                                <label class="form-check-label" for="permission_report_sales_tax"><?php echo e(__('Sales Tax Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_purchase_tax" id="permission_report_purchase_tax">
                                                                <label class="form-check-label" for="permission_report_purchase_tax"><?php echo e(__('Purchase Tax Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_supplier_items" id="permission_report_supplier_items">
                                                                <label class="form-check-label" for="permission_report_supplier_items"><?php echo e(__('Supplier Items Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_sales" id="permission_report_sales">
                                                                <label class="form-check-label" for="permission_report_sales"><?php echo e(__('Sales Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_sales_register" id="permission_report_sales_register">
                                                                <label class="form-check-label" for="permission_report_sales_register"><?php echo e(__('Sales Register Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_purchase_register" id="permission_report_purchase_register">
                                                                <label class="form-check-label" for="permission_report_purchase_register"><?php echo e(__('Purchase Register Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_sales_return" id="permission_report_sales_return">
                                                                <label class="form-check-label" for="permission_report_sales_return"><?php echo e(__('Sales Return Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_seller_points" id="permission_report_seller_points">
                                                                <label class="form-check-label" for="permission_report_seller_points"><?php echo e(__('Seller Points Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_purchase" id="permission_report_purchase">
                                                                <label class="form-check-label" for="permission_report_purchase"><?php echo e(__('Purchase Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_overseas_ledger" id="permission_report_overseas_ledger">
                                                                <label class="form-check-label" for="permission_report_overseas_ledger"><?php echo e(__('Overseas Ledger')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_purchase_return" id="permission_report_purchase_return">
                                                                <label class="form-check-label" for="permission_report_purchase_return"><?php echo e(__('Purchase Return Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_expense" id="permission_report_expense">
                                                                <label class="form-check-label" for="permission_report_expense"><?php echo e(__('Expense Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_expense_outstanding" id="permission_report_expense_outstanding">
                                                                <label class="form-check-label" for="permission_report_expense_outstanding"><?php echo e(__('Expense Outstanding Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_expense_payment" id="permission_report_expense_payment">
                                                                <label class="form-check-label" for="permission_report_expense_payment"><?php echo e(__('Expense Payment Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_expense_gst" id="permission_report_expense_gst">
                                                                <label class="form-check-label" for="permission_report_expense_gst"><?php echo e(__('Expense GST Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_profit" id="permission_report_profit">
                                                                <label class="form-check-label" for="permission_report_profit"><?php echo e(__('Profit Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_stock" id="permission_report_stock">
                                                                <label class="form-check-label" for="permission_report_stock"><?php echo e(__('Stock Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_stock_ledger" id="permission_report_stock_ledger">
                                                                <label class="form-check-label" for="permission_report_stock_ledger"><?php echo e(__('Stock Ledger Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_sales_item" id="permission_report_sales_item">
                                                                <label class="form-check-label" for="permission_report_sales_item"><?php echo e(__('Sales item Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_return_items" id="permission_report_return_items">
                                                                <label class="form-check-label" for="permission_report_return_items"><?php echo e(__('Return Items Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_purchase_payments" id="permission_report_purchase_payments">
                                                                <label class="form-check-label" for="permission_report_purchase_payments"><?php echo e(__('Purchase Payments Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_sales_payments" id="permission_report_sales_payments">
                                                                <label class="form-check-label" for="permission_report_sales_payments"><?php echo e(__('Sales Payments Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_gstr1" id="permission_report_gstr1">
                                                                <label class="form-check-label" for="permission_report_gstr1"><?php echo e(__('GSTR-1 Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_gstr2" id="permission_report_gstr2">
                                                                <label class="form-check-label" for="permission_report_gstr2"><?php echo e(__('GSTR-2 Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_sales_gst" id="permission_report_sales_gst">
                                                                <label class="form-check-label" for="permission_report_sales_gst"><?php echo e(__('Sales GST Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_purchase_gst" id="permission_report_purchase_gst">
                                                                <label class="form-check-label" for="permission_report_purchase_gst"><?php echo e(__('Purchase GST Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_quotation_items" id="permission_report_quotation_items">
                                                                <label class="form-check-label" for="permission_report_quotation_items"><?php echo e(__('Quotation Items Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_purchase_order_item" id="permission_report_purchase_order_item">
                                                                <label class="form-check-label" for="permission_report_purchase_order_item"><?php echo e(__('Purchase Order Item Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_hsn_summary" id="permission_report_hsn_summary">
                                                                <label class="form-check-label" for="permission_report_hsn_summary"><?php echo e(__('HSN Summary Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_balance_sheet" id="permission_report_balance_sheet">
                                                                <label class="form-check-label" for="permission_report_balance_sheet"><?php echo e(__('Balance Sheet Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_trial_balance" id="permission_report_trial_balance">
                                                                <label class="form-check-label" for="permission_report_trial_balance"><?php echo e(__('Trial Balance Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_ledger_statement" id="permission_report_ledger_statement">
                                                                <label class="form-check-label" for="permission_report_ledger_statement"><?php echo e(__('Ledger Statement Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_ledger_entries" id="permission_report_ledger_entries">
                                                                <label class="form-check-label" for="permission_report_ledger_entries"><?php echo e(__('Ledger Entries Report')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_reconciliation" id="permission_report_reconciliation">
                                                                <label class="form-check-label" for="permission_report_reconciliation"><?php echo e(__('Reconciliation Report')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Category: OTHERS -->
                                                <!-- Module 1: Users -->
                                                <tr class="permission-row" data-categories="others">
                                                    <td>28</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_users">
                                                            <label class="form-check-label" for="module_users"><strong><?php echo e(__('Users')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-users" name="permissions[]" value="user_view" id="permission_user_view">
                                                                <label class="form-check-label" for="permission_user_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-users" name="permissions[]" value="user_add" id="permission_user_add">
                                                                <label class="form-check-label" for="permission_user_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-users" name="permissions[]" value="user_edit" id="permission_user_edit">
                                                                <label class="form-check-label" for="permission_user_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-users" name="permissions[]" value="user_delete" id="permission_user_delete">
                                                                <label class="form-check-label" for="permission_user_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 2: Roles -->
                                                <tr class="permission-row" data-categories="others">
                                                    <td>29</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_roles">
                                                            <label class="form-check-label" for="module_roles"><strong><?php echo e(__('Roles')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-roles" name="permissions[]" value="role_view" id="permission_role_view">
                                                                <label class="form-check-label" for="permission_role_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-roles" name="permissions[]" value="role_add" id="permission_role_add">
                                                                <label class="form-check-label" for="permission_role_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-roles" name="permissions[]" value="role_edit" id="permission_role_edit">
                                                                <label class="form-check-label" for="permission_role_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-roles" name="permissions[]" value="role_delete" id="permission_role_delete">
                                                                <label class="form-check-label" for="permission_role_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 6: Company -->
                                                <tr class="permission-row" data-categories="others">
                                                    <td>30</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_company">
                                                            <label class="form-check-label" for="module_company"><strong><?php echo e(__('Company')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-company" name="permissions[]" value="company_view" id="permission_company_view">
                                                                <label class="form-check-label" for="permission_company_view"><?php echo e(__('View')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-company" name="permissions[]" value="company_add" id="permission_company_add">
                                                                <label class="form-check-label" for="permission_company_add"><?php echo e(__('Add')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-company" name="permissions[]" value="company_edit" id="permission_company_edit">
                                                                <label class="form-check-label" for="permission_company_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-company" name="permissions[]" value="company_delete" id="permission_company_delete">
                                                                <label class="form-check-label" for="permission_company_delete"><?php echo e(__('Delete')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 7: Store(Own Store) -->
                                                <tr class="permission-row" data-categories="others">
                                                    <td>31</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_store">
                                                            <label class="form-check-label" for="module_store"><strong><?php echo e(__('Store(Own Store)')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-store" name="permissions[]" value="store_edit" id="permission_store_edit">
                                                                <label class="form-check-label" for="permission_store_edit"><?php echo e(__('Edit')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Module 8: Dashboard -->
                                                <tr class="permission-row" data-categories="others">
                                                    <td>32</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_dashboard">
                                                            <label class="form-check-label" for="module_dashboard"><strong><?php echo e(__('Dashboard')); ?></strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_view" id="permission_dashboard_view">
                                                                <label class="form-check-label" for="permission_dashboard_view"><?php echo e(__('View Dashboard')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_info1" id="permission_dashboard_info1">
                                                                <label class="form-check-label" for="permission_dashboard_info1"><?php echo e(__('Info Box 1')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_info2" id="permission_dashboard_info2">
                                                                <label class="form-check-label" for="permission_dashboard_info2"><?php echo e(__('Info Box 2')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_chart" id="permission_dashboard_chart">
                                                                <label class="form-check-label" for="permission_dashboard_chart"><?php echo e(__('Purchase and Sales Chart')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_items" id="permission_dashboard_items">
                                                                <label class="form-check-label" for="permission_dashboard_items"><?php echo e(__('Recent Items')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_stock_alert" id="permission_dashboard_stock_alert">
                                                                <label class="form-check-label" for="permission_dashboard_stock_alert"><?php echo e(__('Stock Alert')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_trending" id="permission_dashboard_trending">
                                                                <label class="form-check-label" for="permission_dashboard_trending"><?php echo e(__('Trending Items')); ?></label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_recent_sales" id="permission_dashboard_recent_sales">
                                                                <label class="form-check-label" for="permission_dashboard_recent_sales"><?php echo e(__('Recent Sales')); ?></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" onclick="window.location.href='<?php echo e(route('roles.index')); ?>'">
                        <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
                    </div>

                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
<script>
    $(document).ready(function () {
        // 1. Category button functionality
        $(".category-btn").click(function(){
            var category = $(this).data('category');
            
            // Update active button
            $(".category-btn").removeClass("active btn-primary").addClass("btn-outline-primary");
            $(this).removeClass("btn-outline-primary").addClass("active btn-primary");
            
            // Show/hide permission rows based on category
            if (category === 'all') {
                $(".permission-row").show();
            } else {
                $(".permission-row").each(function(){
                    var categories = $(this).data('categories').split(',');
                    if (categories.includes(category)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });

        // 2. Select All functionality
        $("#checkAll").click(function(){
            var isChecked = $(this).prop('checked');
            
            // Check all module checkboxes
            $('.module-checkbox').prop('checked', isChecked);
            
            // Check all permission checkboxes
            $('.permission-checkbox').prop('checked', isChecked);
            
            // Update visual feedback
            updateVisualFeedback();
        });

        // 3. Module checkbox functionality
        $(".module-checkbox").click(function(){
            var moduleId = $(this).attr('id').replace('module_', '');
            var isChecked = $(this).prop('checked');
            
            // Check all permissions for this module
            $('.module-' + moduleId.replace(/_/g, '-')).prop('checked', isChecked);
            
            // Update Select All checkbox
            updateSelectAllCheckbox();
            
            // Update visual feedback
            updateVisualFeedback();
        });

        // 4. Individual permission checkbox functionality
        $(".permission-checkbox").click(function(){
            // Find the module checkbox for this permission
            var moduleClass = $(this).attr('class').split(' ').find(c => c.startsWith('module-'));
            
            if (moduleClass) {
                var moduleName = moduleClass.replace('module-', '').replace(/-/g, '_');
                var moduleCheckbox = $('#module_' + moduleName);
                
                // Check if all permissions in this module are checked
                var allPermissions = $('.' + moduleClass);
                var checkedPermissions = allPermissions.filter(':checked');
                
                // Update module checkbox state
                if (checkedPermissions.length === 0) {
                    moduleCheckbox.prop('checked', false);
                    moduleCheckbox.prop('indeterminate', false);
                } else if (checkedPermissions.length === allPermissions.length) {
                    moduleCheckbox.prop('checked', true);
                    moduleCheckbox.prop('indeterminate', false);
                } else {
                    moduleCheckbox.prop('checked', false);
                    moduleCheckbox.prop('indeterminate', true);
                }
            }
            
            // Update Select All checkbox
            updateSelectAllCheckbox();
            
            // Update visual feedback
            updateVisualFeedback();
        });

        // 5. Function to update Select All checkbox
        function updateSelectAllCheckbox() {
            var totalPermissions = $('.permission-checkbox').length;
            var checkedPermissions = $('.permission-checkbox:checked').length;
            
            if (checkedPermissions === 0) {
                $('#checkAll').prop('checked', false);
                $('#checkAll').prop('indeterminate', false);
            } else if (checkedPermissions === totalPermissions) {
                $('#checkAll').prop('checked', true);
                $('#checkAll').prop('indeterminate', false);
            } else {
                $('#checkAll').prop('checked', false);
                $('#checkAll').prop('indeterminate', true);
            }
        }

        // 6. Function to update visual feedback
        function updateVisualFeedback() {
            // Remove all active classes
            $('.form-check').removeClass('active');
            
            // Add active class to checked checkboxes
            $('.module-checkbox:checked').closest('.form-check').addClass('active');
            $('.permission-checkbox:checked').closest('.form-check').addClass('active');
            
            if ($('#checkAll').prop('checked')) {
                $('#checkAll').closest('.form-check').addClass('active');
            }
        }

        // 7. Initialize visual feedback on page load
        updateVisualFeedback();
    });
</script>

<style>
    .category-btn {
        min-width: 120px;
        transition: all 0.3s ease;
    }
    .category-btn.active {
        font-weight: bold;
    }
    .form-check.active {
        background-color: rgba(var(--primary-rgb), 0.1);
        border-radius: 4px;
    }
    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    .form-check-label {
        cursor: pointer;
        user-select: none;
    }
    .form-check {
        margin-bottom: 4px;
        padding: 4px 8px;
        transition: background-color 0.2s;
    }
    table th .form-check {
        margin-bottom: 0;
        padding: 0;
    }
    .module-checkbox {
        margin-right: 8px;
    }
    .permission-checkbox {
        margin-right: 5px;
    }
    .table td {
        vertical-align: middle;
    }
    .permission-row {
        transition: all 0.3s ease;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WORK GPT\Github repo\savantec-erp\resources\views/role/create.blade.php ENDPATH**/ ?>