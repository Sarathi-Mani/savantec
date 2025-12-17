

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Item')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('items.index')); ?>"><?php echo e(__('Items')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Edit')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="card-title mb-0"><?php echo e(__('Edit Item')); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('items.update', $item->id)); ?>" id="itemForm" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <!-- First Row: Basic Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label"><strong><?php echo e(__('Item Name*')); ?></strong></label>
                                    <input type="text" class="form-control" id="name" name="name" required 
                                           placeholder="Enter item name" value="<?php echo e(old('name', $item->name)); ?>">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="item_group" class="form-label"><strong><?php echo e(__('Item Group*')); ?></strong></label>
                                    <select class="form-control select2" id="item_group" name="item_group" required>
                                        <option value=""><?php echo e(__('-Select-')); ?></option>
                                        <option value="single" <?php echo e(old('item_group', $item->item_group) == 'single' ? 'selected' : ''); ?>><?php echo e(__('Single')); ?></option>
                                        <option value="variants" <?php echo e(old('item_group', $item->item_group) == 'variants' ? 'selected' : ''); ?>><?php echo e(__('Variants')); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Second Row: Identification - Hidden when Variants selected -->
                        <div id="identificationSection" class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hsn" class="form-label"><strong><?php echo e(__('HSN')); ?></strong></label>
                                    <input type="text" class="form-control" id="hsn" name="hsn" 
                                           placeholder="Enter HSN code" value="<?php echo e(old('hsn', $item->hsn)); ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="barcode" class="form-label"><strong><?php echo e(__('Barcode')); ?></strong></label>
                                    <input type="text" class="form-control" id="barcode" name="barcode" 
                                           placeholder="Enter barcode" value="<?php echo e(old('barcode', $item->barcode)); ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sku" class="form-label"><strong><?php echo e(__('SKU')); ?></strong></label>
                                    <input type="text" class="form-control" id="sku" name="sku" 
                                           placeholder="Enter SKU" value="<?php echo e(old('sku', $item->sku)); ?>">
                                    <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Variants Section - Only shown when Variants selected -->
                        <div id="variantsSection" class="row mb-4" style="display: none;">
                            <div class="col-md-12">
                                <h6 class="mb-3" style="color: #ef4444; font-weight: 600; border-bottom: 2px solid #ef4444; padding-bottom: 8px;">
                                    <i class="fas fa-list"></i> <?php echo e(__('Variant Management')); ?>

                                </h6>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0"><?php echo e(__('Variants List')); ?></h6>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="addVariantRow()">
                                                <i class="fas fa-plus me-1"></i> <?php echo e(__('Add Variant')); ?>

                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0 align-middle" id="variantsTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="text-nowrap"><?php echo e(__('Variant Name')); ?> *</th>
                                                        <th class="text-nowrap"><?php echo e(__('HSN')); ?></th>
                                                        <th class="text-nowrap"><?php echo e(__('SKU')); ?></th>
                                                        <th class="text-nowrap"><?php echo e(__('Barcode')); ?></th>
                                                        <th class="text-nowrap"><?php echo e(__('Price')); ?></th>
                                                        <th class="text-nowrap"><?php echo e(__('Purchase Price')); ?></th>
                                                        <th class="text-nowrap"><?php echo e(__('Profit Margin')); ?></th>
                                                        <th class="text-nowrap"><?php echo e(__('Sales Price')); ?></th>
                                                        <th class="text-nowrap"><?php echo e(__('MRP')); ?></th>
                                                        <th class="text-nowrap"><?php echo e(__('Opening Stock')); ?></th>
                                                        <th class="text-nowrap text-center"><?php echo e(__('Action')); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="variantsTableBody">
                                                    <!-- Existing variants will be populated here -->
                                                    <?php if($item->item_group == 'variants' && $item->variants->count() > 0): ?>
                                                        <?php $__currentLoopData = $item->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr id="variant_<?php echo e($index + 1); ?>" class="variant-row">
                                                                <td>
                                                                    <input type="text" name="variants[<?php echo e($index + 1); ?>][name]" 
                                                                           class="form-control form-control-sm variant-input" 
                                                                           placeholder="Variant Name" required
                                                                           value="<?php echo e(old('variants.' . ($index + 1) . '.name', $variant->name)); ?>">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="variants[<?php echo e($index + 1); ?>][hsn]" 
                                                                           class="form-control form-control-sm variant-input" 
                                                                           placeholder="Optional"
                                                                           value="<?php echo e(old('variants.' . ($index + 1) . '.hsn', $variant->hsn)); ?>">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="variants[<?php echo e($index + 1); ?>][sku]" 
                                                                           class="form-control form-control-sm variant-input" 
                                                                           placeholder="Optional"
                                                                           value="<?php echo e(old('variants.' . ($index + 1) . '.sku', $variant->sku)); ?>">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="variants[<?php echo e($index + 1); ?>][barcode]" 
                                                                           class="form-control form-control-sm variant-input" 
                                                                           placeholder="Optional"
                                                                           value="<?php echo e(old('variants.' . ($index + 1) . '.barcode', $variant->barcode)); ?>">
                                                                </td>
                                                                <td>
                                                                    <div class="currency-input-wrapper">
                                                                        <span class="currency-symbol">₹</span>
                                                                        <input type="number" name="variants[<?php echo e($index + 1); ?>][price]" 
                                                                               class="form-control form-control-sm variant-input currency-input" 
                                                                               placeholder="0.00" min="0" step="0.01" required
                                                                               value="<?php echo e(old('variants.' . ($index + 1) . '.price', $variant->price)); ?>"
                                                                               onchange="calculateVariantPurchasePrice(<?php echo e($index + 1); ?>)">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="currency-input-wrapper">
                                                                        <span class="currency-symbol">₹</span>
                                                                        <input type="number" name="variants[<?php echo e($index + 1); ?>][purchase_price]" 
                                                                               class="form-control form-control-sm variant-input currency-input" 
                                                                               placeholder="0.00" min="0" step="0.01" required
                                                                               value="<?php echo e(old('variants.' . ($index + 1) . '.purchase_price', $variant->purchase_price)); ?>"
                                                                               onchange="calculateVariantProfitMargin(<?php echo e($index + 1); ?>)">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="percentage-input-wrapper">
                                                                        <input type="number" name="variants[<?php echo e($index + 1); ?>][profit_margin]" 
                                                                               class="form-control form-control-sm variant-input percentage-input" 
                                                                               placeholder="0.00" min="0" step="0.01"
                                                                               value="<?php echo e(old('variants.' . ($index + 1) . '.profit_margin', $variant->profit_margin)); ?>"
                                                                               onchange="calculateVariantSalesPrice(<?php echo e($index + 1); ?>)">
                                                                        <span class="percentage-symbol">%</span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="currency-input-wrapper">
                                                                        <span class="currency-symbol">₹</span>
                                                                        <input type="number" name="variants[<?php echo e($index + 1); ?>][sales_price]" 
                                                                               class="form-control form-control-sm variant-input currency-input" 
                                                                               placeholder="0.00" min="0" step="0.01" required
                                                                               value="<?php echo e(old('variants.' . ($index + 1) . '.sales_price', $variant->sales_price)); ?>"
                                                                               onchange="calculateVariantProfitMarginFromSales(<?php echo e($index + 1); ?>)">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="currency-input-wrapper">
                                                                        <span class="currency-symbol">₹</span>
                                                                        <input type="number" name="variants[<?php echo e($index + 1); ?>][mrp]" 
                                                                               class="form-control form-control-sm variant-input currency-input" 
                                                                               placeholder="0.00" min="0" step="0.01"
                                                                               value="<?php echo e(old('variants.' . ($index + 1) . '.mrp', $variant->mrp)); ?>">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="variants[<?php echo e($index + 1); ?>][opening_stock]" 
                                                                           class="form-control form-control-sm variant-input number-input" 
                                                                           placeholder="0" min="0" step="1"
                                                                           value="<?php echo e(old('variants.' . ($index + 1) . '.opening_stock', $variant->opening_stock)); ?>">
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-sm btn-danger variant-delete-btn" onclick="removeVariantRow('variant_<?php echo e($index + 1); ?>')" title="Remove">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function() {
                                                                variantCounter = <?php echo e($item->variants->count()); ?>;
                                                            });
                                                        </script>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer bg-light text-center py-2">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                <?php echo e(__('For variants, HSN, SKU, and Barcode can be specified at variant level.')); ?>

                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Third Row: Category & Brand -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="brand" class="form-label"><strong><?php echo e(__('Brand')); ?></strong></label>
                                    <select class="form-control select2" id="brand" name="brand">
                                        <option value=""><?php echo e(__('-Select-')); ?></option>
                                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $brandName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($brandName); ?>" <?php echo e(old('brand', $item->brand) == $brandName ? 'selected' : ''); ?>>
                                                <?php echo e($brandName); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <option value="other" <?php echo e((old('brand') == 'other' || (!in_array($item->brand, $brands) && $item->brand)) ? 'selected' : ''); ?>>
                                            <?php echo e(__('Other')); ?>

                                        </option>
                                    </select>
                                    <input type="text" class="form-control mt-2" id="other_brand" name="other_brand" 
                                           placeholder="Enter other brand" 
                                           value="<?php echo e((!in_array($item->brand, $brands) && $item->brand) ? $item->brand : old('other_brand')); ?>"
                                           style="<?php echo e((old('brand') == 'other' || (!in_array($item->brand, $brands) && $item->brand)) ? '' : 'display: none;'); ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category" class="form-label"><strong><?php echo e(__('Category')); ?></strong></label>
                                    <select class="form-control select2" id="category" name="category">
                                        <option value=""><?php echo e(__('-Select-')); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $categoryName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($categoryName); ?>" <?php echo e(old('category', $item->category) == $categoryName ? 'selected' : ''); ?>>
                                                <?php echo e($categoryName); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <option value="other" <?php echo e((old('category') == 'other' || (!in_array($item->category, $categories) && $item->category)) ? 'selected' : ''); ?>>
                                            <?php echo e(__('Other')); ?>

                                        </option>
                                    </select>
                                    <input type="text" class="form-control mt-2" id="other_category" name="other_category" 
                                           placeholder="Enter other category" 
                                           value="<?php echo e((!in_array($item->category, $categories) && $item->category) ? $item->category : old('other_category')); ?>"
                                           style="<?php echo e((old('category') == 'other' || (!in_array($item->category, $categories) && $item->category)) ? '' : 'display: none;'); ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_id" class="form-label"><strong><?php echo e(__('Company')); ?></strong></label>
                                    <select class="form-control select2" id="company_id" name="company_id" required>
                                        <option value=""><?php echo e(__('-Select-')); ?></option>
                                        <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $companyName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php echo e(old('company_id', $item->company_id) == $id ? 'selected' : ''); ?>>
                                                <?php echo e($companyName); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Fourth Row: Inventory -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="unit" class="form-label"><strong><?php echo e(__('Unit')); ?></strong></label>
                                    <select class="form-control select2" id="unit" name="unit">
                                        <option value=""><?php echo e(__('-Select-')); ?></option>
                                        <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $unitName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>" <?php echo e(old('unit', $item->unit) == $key ? 'selected' : ''); ?>>
                                                <?php echo e($unitName); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <option value="other" <?php echo e((old('unit') == 'other' || (!in_array($item->unit, array_keys($units)) && $item->unit)) ? 'selected' : ''); ?>>
                                            <?php echo e(__('Other')); ?>

                                        </option>
                                    </select>
                                    <input type="text" class="form-control mt-2" id="other_unit" name="other_unit" 
                                           placeholder="Enter other unit" 
                                           value="<?php echo e((!in_array($item->unit, array_keys($units)) && $item->unit) ? $item->unit : old('other_unit')); ?>"
                                           style="<?php echo e((old('unit') == 'other' || (!in_array($item->unit, array_keys($units)) && $item->unit)) ? '' : 'display: none;'); ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="alert_quantity" class="form-label"><strong><?php echo e(__('Alert Quantity')); ?></strong></label>
                                    <input type="number" class="form-control text-end" id="alert_quantity" 
                                           name="alert_quantity" min="0" step="1" placeholder="0" 
                                           value="<?php echo e(old('alert_quantity', $item->alert_quantity)); ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="opening_stock" class="form-label"><strong><?php echo e(__('Opening Stock')); ?></strong></label>
                                    <input type="number" class="form-control text-end" id="opening_stock" 
                                           name="opening_stock" min="0" step="1" placeholder="0" 
                                           value="<?php echo e(old('opening_stock', $item->opening_stock)); ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Description Row -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="form-label"><strong><?php echo e(__('Description')); ?></strong></label>
                                    <textarea class="form-control" id="description" name="description" 
                                              rows="3" placeholder="Enter item description"><?php echo e(old('description', $item->description)); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Fifth Row: Pricing Section - Start -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="mb-3" style="color: #667eea; font-weight: 600; border-bottom: 2px solid #667eea; padding-bottom: 8px;">
                                    <i class="fas fa-money-bill-wave"></i> <?php echo e(__('Pricing Information')); ?>

                                </h6>
                            </div>
                        </div>

                        <!-- Sixth Row: Base Price -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price" class="form-label"><strong><?php echo e(__('Price*')); ?></strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control text-end" id="price" 
                                               name="price" min="0" step="0.01" placeholder="0.00" 
                                               required value="<?php echo e(old('price', $item->price)); ?>">
                                    </div>
                                    <small class="form-text text-muted"><?php echo e(__('Base price without tax')); ?></small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mrp" class="form-label"><strong><?php echo e(__('MRP')); ?></strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control text-end" id="mrp" 
                                               name="mrp" min="0" step="0.01" placeholder="0.00" 
                                               value="<?php echo e(old('mrp', $item->mrp)); ?>">
                                    </div>
                                    <small class="form-text text-muted"><?php echo e(__('Maximum Retail Price')); ?></small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="seller_points" class="form-label"><strong><?php echo e(__('Seller Points')); ?></strong></label>
                                    <input type="number" class="form-control text-end" id="seller_points" 
                                           name="seller_points" min="0" step="1" placeholder="0" 
                                           value="<?php echo e(old('seller_points', $item->seller_points)); ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Seventh Row: Discount -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="discount_type" class="form-label"><strong><?php echo e(__('Discount Type')); ?></strong></label>
                                    <select class="form-control select2" id="discount_type" name="discount_type">
                                        <option value="percentage" <?php echo e(old('discount_type', $item->discount_type) == 'percentage' ? 'selected' : 'selected'); ?>>
                                            <?php echo e(__('Percentage(%)')); ?>

                                        </option>
                                        <option value="fixed" <?php echo e(old('discount_type', $item->discount_type) == 'fixed' ? 'selected' : ''); ?>>
                                            <?php echo e(__('Fixed Amount')); ?>

                                        </option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="discount" class="form-label"><strong><?php echo e(__('Discount')); ?></strong></label>
                                    <input type="number" class="form-control text-end" id="discount" 
                                           name="discount" min="0" step="0.01" placeholder="0.00" 
                                           value="<?php echo e(old('discount', $item->discount)); ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tax_type" class="form-label"><strong><?php echo e(__('Tax Type*')); ?></strong></label>
                                    <select class="form-control select2" id="tax_type" name="tax_type" required>
                                        <option value=""><?php echo e(__('-Select-')); ?></option>
                                        <option value="inclusive" <?php echo e(old('tax_type', $item->tax_type) == 'inclusive' ? 'selected' : 'selected'); ?>>
                                            <?php echo e(__('Inclusive')); ?>

                                        </option>
                                        <option value="exclusive" <?php echo e(old('tax_type', $item->tax_type) == 'exclusive' ? 'selected' : ''); ?>>
                                            <?php echo e(__('Exclusive')); ?>

                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Eighth Row: Tax Information -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tax_id" class="form-label"><strong><?php echo e(__('Tax')); ?></strong></label>
                                    <select class="form-control select2" id="tax_id" name="tax_id">
                                        <option value=""><?php echo e(__('-Select-')); ?></option>
                                        <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $taxName = $tax->name;
                                                $taxRate = $tax->rate;
                                                if (strpos($taxName, 'TAX@') !== false) {
                                                    $displayText = $taxName;
                                                } else {
                                                    $displayText = $taxName . ' (' . $taxRate . '%)';
                                                }
                                            ?>
                                            <option value="<?php echo e($tax->id); ?>" 
                                                    <?php echo e(old('tax_id', $item->tax_id) == $tax->id ? 'selected' : ''); ?>

                                                    data-rate="<?php echo e($taxRate); ?>">
                                                <?php echo e($displayText); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="alert alert-info" style="margin-top: 28px;">
                                    <small><i class="fas fa-info-circle"></i> <?php echo e(__('Tax will be applied to calculate purchase price')); ?></small>
                                </div>
                            </div>
                        </div>

                        <!-- Ninth Row: Purchase Price Calculation -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="mb-3" style="color: #10b981; font-weight: 600; border-bottom: 2px solid #10b981; padding-bottom: 8px;">
                                    <i class="fas fa-calculator"></i> <?php echo e(__('Purchase Price Calculation')); ?>

                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="purchase_price" class="form-label"><strong><?php echo e(__('Purchase Price*')); ?></strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control text-end" id="purchase_price" 
                                               name="purchase_price" min="0" step="0.01" placeholder="0.00" 
                                               required value="<?php echo e(old('purchase_price', $item->purchase_price)); ?>">
                                    </div>
                                    <small class="form-text text-muted"><?php echo e(__('Price + Tax Amount')); ?></small>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="calculatePurchasePrice()">
                                            <i class="fas fa-calculator"></i> <?php echo e(__('Auto Calculate')); ?>

                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="alert alert-light" style="margin-top: 28px;">
                                    <small><i class="fas fa-lightbulb"></i> <?php echo e(__('Purchase Price = Price + Tax Amount. Click "Auto Calculate" to compute based on selected tax.')); ?></small>
                                </div>
                            </div>
                        </div>

                        <!-- Tenth Row: Sales Price & Profit Margin -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="mb-3" style="color: #f59e0b; font-weight: 600; border-bottom: 2px solid #f59e0b; padding-bottom: 8px;">
                                    <i class="fas fa-chart-line"></i> <?php echo e(__('Sales & Profit Calculation')); ?>

                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sales_price" class="form-label"><strong><?php echo e(__('Sales Price*')); ?></strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control text-end" id="sales_price" 
                                               name="sales_price" min="0" step="0.01" placeholder="0.00" 
                                               required value="<?php echo e(old('sales_price', $item->sales_price)); ?>">
                                    </div>
                                    <small class="form-text text-muted"><?php echo e(__('Final selling price')); ?></small>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="calculateSalesPriceFromPurchase()">
                                            <i class="fas fa-calculator"></i> <?php echo e(__('Auto Calculate')); ?>

                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="profit_margin" class="form-label"><strong><?php echo e(__('Profit Margin(%)')); ?></strong></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control text-end" id="profit_margin" 
                                               name="profit_margin" min="0" step="0.01" placeholder="0.00" 
                                               value="<?php echo e(old('profit_margin', $item->profit_margin)); ?>">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <small class="form-text text-muted"><?php echo e(__('Auto-calculated')); ?></small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="alert alert-light" style="margin-top: 28px;">
                                    <small><i class="fas fa-lightbulb"></i> <?php echo e(__('Profit Margin = ((Sales Price - Purchase Price) / Purchase Price) × 100')); ?></small>
                                </div>
                            </div>
                        </div>

                        <!-- Eleventh Row: Images -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="mb-3" style="color: #8b5cf6; font-weight: 600; border-bottom: 2px solid #8b5cf6; padding-bottom: 8px;">
                                    <i class="fas fa-images"></i> <?php echo e(__('Images')); ?>

                                </h6>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><strong><?php echo e(__('Main Image')); ?></strong></label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="item_image" name="item_image" 
                                               accept="image/*" onchange="previewImage(this)">
                                        <label class="input-group-text" for="item_image"><?php echo e(__('Pick Image')); ?></label>
                                    </div>
                                    <div class="form-text text-muted">
                                        <?php echo e(__('Max Width/Height: 1000px * 1000px & Size: 1MB')); ?>

                                    </div>
                                    <?php if($item->item_image): ?>
                                        <div class="mt-2">
                                            <p class="mb-1">Current Image:</p>
                                            <img src="<?php echo e(asset('storage/' . $item->item_image)); ?>" alt="Current Image" style="max-width: 200px; border: 1px solid #ddd; padding: 5px;">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="remove_item_image" name="remove_item_image" value="1">
                                                <label class="form-check-label" for="remove_item_image">
                                                    <?php echo e(__('Remove current image')); ?>

                                                </label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="mt-2">
                                        <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 200px; display: none;">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"><strong><?php echo e(__('Additional Image')); ?></strong></label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="additional_image" 
                                               name="additional_image" accept="image/*" onchange="previewAdditionalImage(this)">
                                    </div>
                                    <div class="form-text text-muted">
                                        <?php echo e(__('Max Width/Height: 1000px * 1000px & Size: 1MB')); ?>

                                    </div>
                                    <?php if($item->additional_image): ?>
                                        <div class="mt-2">
                                            <p class="mb-1">Current Additional Image:</p>
                                            <img src="<?php echo e(asset('storage/' . $item->additional_image)); ?>" alt="Current Additional Image" style="max-width: 200px; border: 1px solid #ddd; padding: 5px;">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="remove_additional_image" name="remove_additional_image" value="1">
                                                <label class="form-check-label" for="remove_additional_image">
                                                    <?php echo e(__('Remove additional image')); ?>

                                                </label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="mt-2">
                                        <img id="additionalImagePreview" src="#" alt="Additional Image Preview" style="max-width: 200px; display: none;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" name="updated_by" value="<?php echo e(Auth::id()); ?>">

                        <!-- Footer Buttons -->
                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="fas fa-save"></i> <?php echo e(__('Update')); ?>

                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-lg px-5" onclick="window.history.back()">
                                    <i class="fas fa-times"></i> <?php echo e(__('Cancel')); ?>

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Calculation Modal (Same as create) -->
    <div class="modal fade" id="calculationModal" tabindex="-1" aria-labelledby="calculationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Same modal content as in create page -->
                <div class="modal-header">
                    <h5 class="modal-title" id="calculationModalLabel"><?php echo e(__('Calculate Price')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="base_price" class="form-label"><?php echo e(__('Base Price (Cost)')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control" id="base_price" 
                                           step="0.01" placeholder="0.00" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="calculation_type" class="form-label"><?php echo e(__('Calculation Type')); ?></label>
                                <select class="form-control" id="calculation_type">
                                    <option value="purchase"><?php echo e(__('Calculate Purchase Price')); ?></option>
                                    <option value="sales"><?php echo e(__('Calculate Sales Price')); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tax_percentage" class="form-label"><?php echo e(__('Tax %')); ?></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="tax_percentage" 
                                           step="0.01" placeholder="0" value="18">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="margin_percentage" class="form-label"><?php echo e(__('Profit Margin %')); ?></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="margin_percentage" 
                                           step="0.01" placeholder="0" value="20">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount_percentage" class="form-label"><?php echo e(__('Discount %')); ?></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="discount_percentage" 
                                           step="0.01" placeholder="0" value="0">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shipping_cost" class="form-label"><?php echo e(__('Shipping Cost')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control" id="shipping_cost" 
                                           step="0.01" placeholder="0.00" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h6 class="alert-heading"><?php echo e(__('Calculation Results:')); ?></h6>
                                <hr>
                                <div id="calculation_result" class="mt-2">
                                    <p><strong><?php echo e(__('Purchase Price:')); ?></strong> <span id="calc_purchase_price">₹0.00</span></p>
                                    <p><strong><?php echo e(__('Sales Price:')); ?></strong> <span id="calc_sales_price">₹0.00</span></p>
                                    <p><strong><?php echo e(__('Profit Amount:')); ?></strong> <span id="calc_profit_amount">₹0.00</span></p>
                                    <p><strong><?php echo e(__('Profit Percentage:')); ?></strong> <span id="calc_profit_percentage">0%</span></p>
                                    <p><strong><?php echo e(__('Tax Amount:')); ?></strong> <span id="calc_tax_amount">₹0.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                    <button type="button" class="btn btn-primary" onclick="calculatePrice()"><?php echo e(__('Calculate')); ?></button>
                    <button type="button" class="btn btn-success" onclick="applyCalculation()"><?php echo e(__('Apply to Form')); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
 /* Variants Table Styling - Consistent Height and Alignment */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

#variantsTable {
    min-width: 1200px;
    width: 100%;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

#variantsTable th {
    background-color: #f8fafc;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #475569;
    border-bottom: 2px solid #e2e8f0;
    padding: 12px 8px;
    white-space: nowrap;
    position: sticky;
    top: 0;
    z-index: 10;
    vertical-align: middle;
}

#variantsTable td {
    vertical-align: middle;
    padding: 8px 8px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.85rem;
    min-width: 80px;
    height: 48px; /* Fixed height for all cells */
}

/* Consistent input styling */
.variant-input {
    width: 100%;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    padding: 6px 8px;
    font-size: 0.85rem;
    transition: all 0.2s ease;
    height: 32px;
    box-sizing: border-box;
}

.variant-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
}

/* Currency and percentage input wrappers */
.currency-input-wrapper,
.percentage-input-wrapper {
    position: relative;
    width: 100%;
}

.currency-symbol,
.percentage-symbol {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: #f1f5f9;
    color: #475569;
    font-weight: 600;
    font-size: 0.75rem;
    padding: 0 8px;
    height: 32px;
    display: flex;
    align-items: center;
    border: 1px solid #e2e8f0;
    z-index: 1;
}

.currency-symbol {
    left: 0;
    border-radius: 4px 0 0 4px;
    border-right: none;
}

.percentage-symbol {
    right: 0;
    border-radius: 0 4px 4px 0;
    border-left: none;
}

/* Adjust input padding for symbols */
.currency-input {
    padding-left: 28px !important;
    text-align: right;
}

.percentage-input {
    padding-right: 28px !important;
    text-align: right;
}

.number-input {
    text-align: right;
}

/* Delete button styling */
.variant-delete-btn {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    border: none;
    border-radius: 4px;
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    transition: all 0.2s ease;
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.variant-delete-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
}

/* Zebra striping for better readability */
#variantsTable tbody tr:nth-child(odd) td {
    background-color: #fafafa;
}

#variantsTable tbody tr:nth-child(even) td {
    background-color: #ffffff;
}

/* Responsive adjustments */
@media (max-width: 1400px) {
    #variantsTable {
        min-width: 1100px;
    }
    
    #variantsTable th,
    #variantsTable td {
        padding: 8px 6px;
        font-size: 0.8rem;
    }
    
    #variantsTable td {
        height: 44px;
    }
    
    .variant-input {
        font-size: 0.8rem;
        padding: 4px 6px;
        height: 30px;
    }
    
    .currency-symbol,
    .percentage-symbol {
        height: 30px;
        font-size: 0.7rem;
        padding: 0 6px;
    }
    
    .currency-input {
        padding-left: 24px !important;
    }
    
    .percentage-input {
        padding-right: 24px !important;
    }
    
    .variant-delete-btn {
        width: 30px;
        height: 30px;
        padding: 0.2rem 0.4rem;
    }
}

@media (max-width: 768px) {
    #variantsTable {
        min-width: 1000px;
    }
    
    #variantsTable th {
        font-size: 0.7rem;
        padding: 6px 4px;
    }
    
    #variantsTable td {
        font-size: 0.75rem;
        padding: 6px 4px;
        height: 40px;
    }
    
    .variant-input {
        font-size: 0.75rem;
        padding: 3px 4px;
        height: 28px;
    }
    
    .currency-symbol,
    .percentage-symbol {
        height: 28px;
        font-size: 0.65rem;
        padding: 0 4px;
    }
    
    .currency-input {
        padding-left: 20px !important;
    }
    
    .percentage-input {
        padding-right: 20px !important;
    }
    
    .variant-delete-btn {
        width: 28px;
        height: 28px;
        padding: 0.15rem 0.3rem;
        font-size: 0.7rem;
    }
}

/* Ensure all cells have same height */
#variantsTable td {
    height: 48px;
}

/* Make sure inputs don't overflow */
.variant-input {
    max-height: 32px;
}

/* Table cell alignment */
#variantsTable td {
    vertical-align: middle;
}

/* Scrollbar styling */
.table-responsive::-webkit-scrollbar {
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Hover effect */
#variantsTable tbody tr:hover td {
    background-color: #f8fafc;
}

/* Border for the last row */
#variantsTable tbody tr:last-child td {
    border-bottom: 1px solid #e2e8f0;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let calculationResults = {
        purchasePrice: 0,
        salesPrice: 0,
        profitAmount: 0,
        profitPercentage: 0,
        taxAmount: 0
    };
    
    let variantCounter = <?php echo e($item->variants->count()); ?>;
    
    $(document).ready(function() {
        // Initialize all Select2 dropdowns
        $('.select2').select2({
            width: '100%',
            placeholder: 'Select...',
            allowClear: true,
            dropdownParent: $('#itemForm')
        });
        
        // Handle other options for brand, unit, category
        $('#brand, #unit, #category').on('change', function() {
            const field = $(this).attr('id');
            const otherField = $('#other_' + field);
            
            if ($(this).val() === 'other') {
                otherField.show();
                otherField.prop('required', true);
            } else {
                otherField.hide();
                otherField.prop('required', false);
                otherField.val('');
            }
        });
        
        // Initialize "other" fields if they exist
        <?php if(!in_array($item->brand, $brands) && $item->brand): ?>
            $('#other_brand').show().prop('required', true);
        <?php endif; ?>
        
        <?php if(!in_array($item->category, $categories) && $item->category): ?>
            $('#other_category').show().prop('required', true);
        <?php endif; ?>
        
        <?php if(!in_array($item->unit, array_keys($units)) && $item->unit): ?>
            $('#other_unit').show().prop('required', true);
        <?php endif; ?>
        
        // Toggle sections based on item group selection
        $('#item_group').on('change', function() {
            toggleIdentificationSection();
            togglePriceFields();
        });
        
        // Initialize sections based on current item group
        toggleIdentificationSection();
        togglePriceFields();
        
        // Auto-calculate sales price based on purchase price and profit margin
        $('#purchase_price, #profit_margin').on('keyup change', function() {
            calculateSalesPriceFromPurchase();
        });
        
        // Auto-calculate profit margin when purchase and sales prices change
        $('#purchase_price, #sales_price').on('keyup change', function() {
            calculateProfitMargin();
        });
        
        // Auto-calculate price with discount
        $('#price, #discount, #discount_type').on('keyup change', function() {
            calculateDiscountedPrice();
        });
        
        // Auto-calculate purchase price from price and tax
        $('#price, #tax_id').on('keyup change', function() {
            calculatePurchasePriceFromPrice();
        });
        
        // Initialize calculations
        calculateSalesPriceFromPurchase();
        calculateProfitMargin();
        calculateDiscountedPrice();
        calculatePurchasePriceFromPrice();
        
        // Set tax percentage from selected tax
        $('#tax_id').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const taxRate = selectedOption.data('rate') || 18;
            $('#tax_percentage').val(taxRate);
        });
        
        // When profit margin changes, update sales price
        $('#profit_margin').on('keyup change', function() {
            if ($('#purchase_price').val() > 0) {
                calculateSalesPriceFromPurchase();
            }
        });
    });
    
    // Toggle identification section (HSN, SKU, Barcode)
    function toggleIdentificationSection() {
        const itemGroup = $('#item_group').val();
        
        if (itemGroup === 'variants') {
            $('#identificationSection').hide();
            
            // Make SKU and Barcode not required when hidden
            $('#sku').prop('required', false);
            $('#barcode').prop('required', false);
            $('#hsn').prop('required', false);
        } else {
            $('#identificationSection').show();
            
            // Make SKU and Barcode optional
            $('#sku').prop('required', false);
            $('#barcode').prop('required', false);
            $('#hsn').prop('required', false);
        }
    }
    
    // Toggle price fields and variants section
    function togglePriceFields() {
        const itemGroup = $('#item_group').val();
        
        if (itemGroup === 'variants') {
            $('#variantsSection').show();
            
            // Hide and disable price-related fields for single items
            $('.single-price-field').hide();
            $('#price, #mrp, #purchase_price, #sales_price, #profit_margin').prop('required', false);
        } else {
            $('#variantsSection').hide();
            
            // Show fields for single items
            $('.single-price-field').show();
            $('#price, #purchase_price, #sales_price').prop('required', true);
        }
    }
    
    // Add variant row (same as create)
    function addVariantRow() {
        variantCounter++;
        const rowId = 'variant_' + variantCounter;
        
        const rowHtml = `
            <tr id="${rowId}" class="variant-row">
                <td>
                    <input type="text" name="variants[${variantCounter}][name]" 
                           class="form-control form-control-sm variant-input" placeholder="Variant Name" required>
                </td>
                <td>
                    <input type="text" name="variants[${variantCounter}][hsn]" 
                           class="form-control form-control-sm variant-input" placeholder="Optional">
                </td>
                <td>
                    <input type="text" name="variants[${variantCounter}][sku]" 
                           class="form-control form-control-sm variant-input" placeholder="Optional">
                </td>
                <td>
                    <input type="text" name="variants[${variantCounter}][barcode]" 
                           class="form-control form-control-sm variant-input" placeholder="Optional">
                </td>
                <td>
                    <div class="currency-input-wrapper">
                        <span class="currency-symbol">₹</span>
                        <input type="number" name="variants[${variantCounter}][price]" 
                               class="form-control form-control-sm variant-input currency-input" 
                               placeholder="0.00" min="0" step="0.01" required
                               onchange="calculateVariantPurchasePrice(${variantCounter})">
                    </div>
                </td>
                <td>
                    <div class="currency-input-wrapper">
                        <span class="currency-symbol">₹</span>
                        <input type="number" name="variants[${variantCounter}][purchase_price]" 
                               class="form-control form-control-sm variant-input currency-input" 
                               placeholder="0.00" min="0" step="0.01" required
                               onchange="calculateVariantProfitMargin(${variantCounter})">
                    </div>
                </td>
                <td>
                    <div class="percentage-input-wrapper">
                        <input type="number" name="variants[${variantCounter}][profit_margin]" 
                               class="form-control form-control-sm variant-input percentage-input" 
                               placeholder="0.00" min="0" step="0.01"
                               onchange="calculateVariantSalesPrice(${variantCounter})">
                        <span class="percentage-symbol">%</span>
                    </div>
                </td>
                <td>
                    <div class="currency-input-wrapper">
                        <span class="currency-symbol">₹</span>
                        <input type="number" name="variants[${variantCounter}][sales_price]" 
                               class="form-control form-control-sm variant-input currency-input" 
                               placeholder="0.00" min="0" step="0.01" required
                               onchange="calculateVariantProfitMarginFromSales(${variantCounter})">
                    </div>
                </td>
                <td>
                    <div class="currency-input-wrapper">
                        <span class="currency-symbol">₹</span>
                        <input type="number" name="variants[${variantCounter}][mrp]" 
                               class="form-control form-control-sm variant-input currency-input" 
                               placeholder="0.00" min="0" step="0.01">
                    </div>
                </td>
                <td>
                    <input type="number" name="variants[${variantCounter}][opening_stock]" 
                           class="form-control form-control-sm variant-input number-input" 
                           placeholder="0" min="0" step="1" value="0">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger variant-delete-btn" onclick="removeVariantRow('${rowId}')" title="Remove">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        
        $('#variantsTableBody').append(rowHtml);
        
        // Initialize calculations for the new row
        calculateVariantPurchasePrice(variantCounter);
    }
    
    // Remove variant row
    function removeVariantRow(rowId) {
        $('#' + rowId).remove();
    }
    
    // Calculate variant purchase price from price and tax
    function calculateVariantPurchasePrice(variantId) {
        const priceInput = $(`input[name="variants[${variantId}][price]"]`);
        const purchasePriceInput = $(`input[name="variants[${variantId}][purchase_price]"]`);
        const profitMarginInput = $(`input[name="variants[${variantId}][profit_margin]"]`);
        const salesPriceInput = $(`input[name="variants[${variantId}][sales_price]"]`);
        
        const price = parseFloat(priceInput.val()) || 0;
        const taxRate = getSelectedTaxRate();
        
        if (price > 0) {
            const taxAmount = price * (taxRate / 100);
            const purchasePrice = price + taxAmount;
            purchasePriceInput.val(purchasePrice.toFixed(2));
            
            // If sales price is set, recalculate profit margin
            const salesPrice = parseFloat(salesPriceInput.val()) || 0;
            if (salesPrice > 0) {
                calculateVariantProfitMarginFromSales(variantId);
            } else if (parseFloat(profitMarginInput.val()) > 0) {
                // If profit margin is set, recalculate sales price
                calculateVariantSalesPrice(variantId);
            }
        }
    }
    
    // Calculate variant profit margin
    function calculateVariantProfitMargin(variantId) {
        const purchasePriceInput = $(`input[name="variants[${variantId}][purchase_price]"]`);
        const salesPriceInput = $(`input[name="variants[${variantId}][sales_price]"]`);
        const profitMarginInput = $(`input[name="variants[${variantId}][profit_margin]"]`);
        
        const purchasePrice = parseFloat(purchasePriceInput.val()) || 0;
        const salesPrice = parseFloat(salesPriceInput.val()) || 0;
        
        if (purchasePrice > 0 && salesPrice > 0) {
            const profitMargin = ((salesPrice - purchasePrice) / purchasePrice) * 100;
            profitMarginInput.val(profitMargin.toFixed(2));
        }
    }
    
    // Calculate variant profit margin from sales price
    function calculateVariantProfitMarginFromSales(variantId) {
        const purchasePriceInput = $(`input[name="variants[${variantId}][purchase_price]"]`);
        const salesPriceInput = $(`input[name="variants[${variantId}][sales_price]"]`);
        const profitMarginInput = $(`input[name="variants[${variantId}][profit_margin]"]`);
        
        const purchasePrice = parseFloat(purchasePriceInput.val()) || 0;
        const salesPrice = parseFloat(salesPriceInput.val()) || 0;
        
        if (purchasePrice > 0 && salesPrice > 0) {
            const profitMargin = ((salesPrice - purchasePrice) / purchasePrice) * 100;
            profitMarginInput.val(profitMargin.toFixed(2));
        } else if (purchasePrice > 0 && parseFloat(profitMarginInput.val()) > 0) {
            // If profit margin is set but sales price isn't, calculate sales price
            calculateVariantSalesPrice(variantId);
        }
    }
    
    // Calculate variant sales price from purchase price and profit margin
    function calculateVariantSalesPrice(variantId) {
        const purchasePriceInput = $(`input[name="variants[${variantId}][purchase_price]"]`);
        const profitMarginInput = $(`input[name="variants[${variantId}][profit_margin]"]`);
        const salesPriceInput = $(`input[name="variants[${variantId}][sales_price]"]`);
        
        const purchasePrice = parseFloat(purchasePriceInput.val()) || 0;
        const profitMargin = parseFloat(profitMarginInput.val()) || 0;
        
        if (purchasePrice > 0) {
            const salesPrice = purchasePrice * (1 + (profitMargin / 100));
            salesPriceInput.val(salesPrice.toFixed(2));
        }
    }
    
    // Calculate profit margin automatically
    function calculateProfitMargin() {
        const purchasePrice = parseFloat($('#purchase_price').val()) || 0;
        const salesPrice = parseFloat($('#sales_price').val()) || 0;
        
        if (purchasePrice > 0 && salesPrice > 0) {
            const profitMargin = ((salesPrice - purchasePrice) / purchasePrice) * 100;
            $('#profit_margin').val(profitMargin.toFixed(2));
        }
    }
    
    // Open calculation modal for purchase price
    function calculatePurchasePrice() {
        $('#calculation_type').val('purchase');
        $('#calculationModalLabel').text('Calculate Purchase Price');
        $('#base_price').val($('#price').val() || 0);
        
        // Get tax rate from selected option
        const selectedTax = $('#tax_id').find('option:selected');
        const taxRate = selectedTax.data('rate') || 18;
        $('#tax_percentage').val(taxRate);
        
        $('#margin_percentage').val($('#profit_margin').val() || 20);
        calculatePrice();
        new bootstrap.Modal(document.getElementById('calculationModal')).show();
    }
    
    // Open calculation modal for sales price
    function calculateSalesPriceFromPurchase() {
        $('#calculation_type').val('sales');
        $('#calculationModalLabel').text('Calculate Sales Price');
        $('#base_price').val($('#purchase_price').val() || 0);
        
        // Get tax rate from selected option
        const selectedTax = $('#tax_id').find('option:selected');
        const taxRate = selectedTax.data('rate') || 18;
        $('#tax_percentage').val(taxRate);
        
        $('#margin_percentage').val($('#profit_margin').val() || 20);
        calculatePrice();
    }
    
    // Get selected tax rate from dropdown
    function getSelectedTaxRate() {
        const selectedOption = $('#tax_id').find('option:selected');
        return selectedOption.data('rate') || 18;
    }
    
    // Main calculation function (same as create)
    function calculatePrice() {
        const basePrice = parseFloat($('#base_price').val()) || 0;
        const taxPercentage = parseFloat($('#tax_percentage').val()) || 0;
        const marginPercentage = parseFloat($('#margin_percentage').val()) || 0;
        const discountPercentage = parseFloat($('#discount_percentage').val()) || 0;
        const shippingCost = parseFloat($('#shipping_cost').val()) || 0;
        const calculationType = $('#calculation_type').val();
        
        let purchasePrice = 0;
        let salesPrice = 0;
        let taxAmount = 0;
        
        if (calculationType === 'purchase') {
            // Calculate Purchase Price from base price (cost)
            taxAmount = basePrice * (taxPercentage / 100);
            purchasePrice = basePrice + taxAmount;
            
            // Calculate Sales Price from Purchase Price with profit margin
            salesPrice = purchasePrice * (1 + (marginPercentage / 100));
            
            // Apply discount if any
            if (discountPercentage > 0) {
                salesPrice = salesPrice - (salesPrice * (discountPercentage / 100));
            }
            
            // Add shipping cost
            salesPrice += shippingCost;
        } else {
            // Calculate Sales Price from purchase price
            purchasePrice = basePrice;
            salesPrice = purchasePrice * (1 + (marginPercentage / 100));
            
            // Apply discount if any
            if (discountPercentage > 0) {
                salesPrice = salesPrice - (salesPrice * (discountPercentage / 100));
            }
            
            // Add shipping cost
            salesPrice += shippingCost;
            
            // Calculate tax amount (if needed)
            taxAmount = purchasePrice * (taxPercentage / 100);
        }
        
        // Calculate profit
        const profitAmount = salesPrice - purchasePrice;
        const profitPercentage = purchasePrice > 0 ? (profitAmount / purchasePrice) * 100 : 0;
        
        // Store results
        calculationResults = {
            purchasePrice: purchasePrice,
            salesPrice: salesPrice,
            profitAmount: profitAmount,
            profitPercentage: profitPercentage,
            taxAmount: taxAmount
        };
        
        // Update display
        updateCalculationDisplay();
    }
    
    // Update calculation results display
    function updateCalculationDisplay() {
        $('#calc_purchase_price').text('₹' + calculationResults.purchasePrice.toFixed(2));
        $('#calc_sales_price').text('₹' + calculationResults.salesPrice.toFixed(2));
        $('#calc_profit_amount').text('₹' + calculationResults.profitAmount.toFixed(2));
        $('#calc_profit_percentage').text(calculationResults.profitPercentage.toFixed(2) + '%');
        $('#calc_tax_amount').text('₹' + calculationResults.taxAmount.toFixed(2));
    }
    
    // Apply calculation results to form
    function applyCalculation() {
        const calculationType = $('#calculation_type').val();
        
        if (calculationType === 'purchase') {
            $('#purchase_price').val(calculationResults.purchasePrice.toFixed(2));
            $('#sales_price').val(calculationResults.salesPrice.toFixed(2));
            $('#profit_margin').val(calculationResults.profitPercentage.toFixed(2));
        } else {
            $('#sales_price').val(calculationResults.salesPrice.toFixed(2));
            $('#profit_margin').val(calculationResults.profitPercentage.toFixed(2));
        }
        
        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('calculationModal')).hide();
    }
    
    // Auto-calculate sales price from purchase price and profit margin
    function calculateSalesPriceFromPurchase() {
        const purchasePrice = parseFloat($('#purchase_price').val()) || 0;
        const profitMargin = parseFloat($('#profit_margin').val()) || 0;
        
        if (purchasePrice > 0) {
            const salesPrice = purchasePrice * (1 + (profitMargin / 100));
            $('#sales_price').val(salesPrice.toFixed(2));
        }
    }
    
    // Auto-calculate purchase price from base price and tax
    function calculatePurchasePriceFromPrice() {
        const basePrice = parseFloat($('#price').val()) || 0;
        const taxRate = getSelectedTaxRate();
        
        if (basePrice > 0) {
            const taxAmount = basePrice * (taxRate / 100);
            const purchasePrice = basePrice + taxAmount;
            $('#purchase_price').val(purchasePrice.toFixed(2));
            
            // Recalculate sales price if profit margin is set
            calculateSalesPriceFromPurchase();
        }
    }
    
    // Calculate discounted price
    function calculateDiscountedPrice() {
        const price = parseFloat($('#price').val()) || 0;
        const discount = parseFloat($('#discount').val()) || 0;
        const discountType = $('#discount_type').val();
        
        let finalPrice = price;
        
        if (discount > 0) {
            if (discountType === 'percentage') {
                if (discount <= 100) {
                    finalPrice = price - (price * (discount / 100));
                }
            } else {
                if (discount <= price) {
                    finalPrice = price - discount;
                }
            }
        }
        
        // Update MRP if it's empty or same as price
        if (!$('#mrp').val() || $('#mrp').val() == $('#price').val()) {
            $('#mrp').val(finalPrice.toFixed(2));
        }
    }
    
    // Image preview functions
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        previewImageFile(input, preview);
    }
    
    function previewAdditionalImage(input) {
        const preview = document.getElementById('additionalImagePreview');
        previewImageFile(input, preview);
    }
    
    function previewImageFile(input, previewElement) {
        const file = input.files[0];
        
        if (file) {
            // Validate file size (1MB = 1048576 bytes)
            if (file.size > 1048576) {
                alert('File size must be less than 1MB');
                input.value = '';
                previewElement.style.display = 'none';
                return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewElement.src = e.target.result;
                previewElement.style.display = 'block';
                
                // Validate image dimensions
                const img = new Image();
                img.onload = function() {
                    if (this.width > 1000 || this.height > 1000) {
                        alert('Image dimensions must be 1000px x 1000px or less');
                        input.value = '';
                        previewElement.style.display = 'none';
                    }
                };
                img.src = e.target.result;
            };
            
            reader.readAsDataURL(file);
        } else {
            previewElement.style.display = 'none';
        }
    }
    
    // Form validation
    $('#itemForm').on('submit', function(e) {
        let isValid = true;
        
        // Check required fields
        if ($('#name').val().trim() === '') {
            alert('Please enter item name');
            $('#name').focus();
            isValid = false;
        }
        
        if ($('#item_group').val() === '') {
            alert('Please select an item group');
            $('#item_group').focus();
            isValid = false;
        }
        
        const itemGroup = $('#item_group').val();
        
        if (itemGroup === 'variants') {
            // Check if at least one variant is added
            if ($('#variantsTableBody tr').length === 0) {
                alert('Please add at least one variant for variable items');
                isValid = false;
            }
            
            // Validate each variant
            $('#variantsTableBody tr').each(function() {
                const variantName = $(this).find('input[name*="[name]"]').val();
                const price = $(this).find('input[name*="[price]"]').val();
                const purchasePrice = $(this).find('input[name*="[purchase_price]"]').val();
                const salesPrice = $(this).find('input[name*="[sales_price]"]').val();
                
                if (!variantName || variantName.trim() === '') {
                    alert('Please enter variant name for all variants');
                    $(this).find('input[name*="[name]"]').focus();
                    isValid = false;
                    return false;
                }
                
                if (!price || parseFloat(price) < 0) {
                    alert('Please enter valid price for all variants');
                    $(this).find('input[name*="[price]"]').focus();
                    isValid = false;
                    return false;
                }
                
                if (!purchasePrice || parseFloat(purchasePrice) < 0) {
                    alert('Please enter valid purchase price for all variants');
                    $(this).find('input[name*="[purchase_price]"]').focus();
                    isValid = false;
                    return false;
                }
                
                if (!salesPrice || parseFloat(salesPrice) < 0) {
                    alert('Please enter valid sales price for all variants');
                    $(this).find('input[name*="[sales_price]"]').focus();
                    isValid = false;
                    return false;
                }
                
                // Validate price relationships
                const purchasePriceVal = parseFloat(purchasePrice);
                const salesPriceVal = parseFloat(salesPrice);
                
                if (salesPriceVal < purchasePriceVal) {
                    alert('Sales price should be greater than or equal to purchase price for all variants');
                    $(this).find('input[name*="[sales_price]"]').focus();
                    isValid = false;
                    return false;
                }
            });
        } else {
            // Validate single item fields
            if ($('#price').val() === '' || parseFloat($('#price').val()) < 0) {
                alert('Please enter a valid price');
                $('#price').focus();
                isValid = false;
            }
            
            if ($('#purchase_price').val() === '' || parseFloat($('#purchase_price').val()) < 0) {
                alert('Please enter a valid purchase price');
                $('#purchase_price').focus();
                isValid = false;
            }
            
            if ($('#sales_price').val() === '' || parseFloat($('#sales_price').val()) < 0) {
                alert('Please enter a valid sales price');
                $('#sales_price').focus();
                isValid = false;
            }
            
            // Validate price relationships for single items
            const purchasePrice = parseFloat($('#purchase_price').val()) || 0;
            const salesPrice = parseFloat($('#sales_price').val()) || 0;
            
            if (salesPrice < purchasePrice) {
                alert('Sales price should be greater than or equal to purchase price');
                $('#sales_price').focus();
                isValid = false;
            }
        }
        
        if ($('#tax_type').val() === '') {
            alert('Please select a tax type');
            $('#tax_type').focus();
            isValid = false;
        }
        
        if ($('#company_id').val() === '') {
            alert('Please select a company');
            $('#company_id').focus();
            isValid = false;
        }
        
        // Check if "other" fields are filled when selected
        if ($('#brand').val() === 'other' && $('#other_brand').val().trim() === '') {
            alert('Please enter brand name');
            $('#other_brand').focus();
            isValid = false;
        }
        
        if ($('#unit').val() === 'other' && $('#other_unit').val().trim() === '') {
            alert('Please enter unit name');
            $('#other_unit').focus();
            isValid = false;
        }
        
        if ($('#category').val() === 'other' && $('#other_category').val().trim() === '') {
            alert('Please enter category name');
            $('#other_category').focus();
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WORK GPT\Github repo\savantec-erp\resources\views/items/edit.blade.php ENDPATH**/ ?>