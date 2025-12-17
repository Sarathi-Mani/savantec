

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Create Quotation')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('quotation.index')); ?>"><?php echo e(__('Quotation')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Create')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="card-title mb-0"><?php echo e(__('Create Quotation')); ?></h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="quotation_type" id="with_image" value="with_image" checked>
                                <label class="form-check-label" for="with_image">With Image</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="quotation_type" id="without_image" value="without_image">
                                <label class="form-check-label" for="without_image">Without Image</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('quotation.store')); ?>" id="quotationForm">
                        <?php echo csrf_field(); ?>
                        
                        <!-- Header Section -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h4 class="text-primary mb-3">
                                    <i class="fas fa-file-invoice"></i> <?php echo e(__('Savantec Quotation')); ?>

                                </h4>
                            </div>
                        </div>

                        <!-- Quotation Code Section -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="quotation_code" class="form-label"><strong><?php echo e(__('Quotation Code*')); ?></strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light fw-bold">QTN</span>
                                        <input type="text" class="form-control" id="quotation_code" name="quotation_code" value="<?php echo e(old('quotation_code', 'QTN' . date('Ym') . '001')); ?>" required>
                                    </div>
                                    <small class="text-muted">Format: QTNYYYYMM001</small>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Details -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_id" class="form-label"><strong><?php echo e(__('Customer Name*')); ?></strong></label>
                                    <select class="form-control select2" id="customer_id" name="customer_id" required onchange="loadCustomerDetails(this.value)">
                                        <option value=""><?php echo e(__('-select-')); ?></option>
                                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($customer->id); ?>" 
                                                data-email="<?php echo e($customer->email); ?>"
                                                data-mobile="<?php echo e($customer->mobile); ?>"
                                                data-contact-person="<?php echo e($customer->contact_person); ?>"
                                                data-tax-number="<?php echo e($customer->tax_number); ?>"
                                                data-gst-number="<?php echo e($customer->gst_number); ?>"
                                                data-previous-due="<?php echo e($customer->previous_due); ?>">
                                                <?php echo e($customer->name); ?> (<?php echo e($customer->customer_code); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div id="customer_details" class="mt-2" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <small class="text-muted" id="customer_email_display"></small>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted" id="customer_mobile_display"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="previous_due" class="text-danger mt-1" style="display: none;">
                                        <strong><?php echo e(__('Previous Due:')); ?></strong> ₹<span id="due_amount">0.00</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="status" class="form-label"><strong><?php echo e(__('Status*')); ?></strong></label>
                                    <select class="form-control select2" id="status" name="status" required>
                                        <option value=""><?php echo e(__('-select-')); ?></option>
                                        <option value="open" <?php echo e(old('status') == 'open' ? 'selected' : ''); ?>><?php echo e(__('Open')); ?></option>
                                        <option value="closed" <?php echo e(old('status') == 'closed' ? 'selected' : ''); ?>><?php echo e(__('Closed')); ?></option>
                                        <option value="po_converted" <?php echo e(old('status') == 'po_converted' ? 'selected' : ''); ?>><?php echo e(__('PO Converted')); ?></option>
                                        <option value="lost" <?php echo e(old('status') == 'lost' ? 'selected' : ''); ?>><?php echo e(__('Lost')); ?></option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="expire_date" class="form-label"><strong><?php echo e(__('Expire Date')); ?></strong></label>
                                    <input type="date" class="form-control" id="expire_date" name="expire_date">
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="salesman_id" class="form-label"><strong><?php echo e(__('Salesman*')); ?></strong></label>
                                    <select class="form-control select2" id="salesman_id" name="salesman_id" required>
                                        <option value=""><?php echo e(__('-select-')); ?></option>
                                        <?php $__currentLoopData = $salesmen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($salesmen->isEmpty()): ?>
                                            <option value="">No Salesmen Found</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Three column row -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="reference" class="form-label"><strong><?php echo e(__('Reference')); ?></strong></label>
                                    <input type="text" class="form-control" id="reference" name="reference" placeholder="Enter reference" value="<?php echo e(old('reference')); ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quotation_date" class="form-label"><strong><?php echo e(__('Quotation Date*')); ?></strong></label>
                                    <input type="text" class="form-control bg-light" id="quotation_date" name="quotation_date" value="<?php echo e(date('d-m-Y')); ?>" readonly required>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="reference_no" class="form-label"><strong><?php echo e(__('Reference No.')); ?></strong></label>
                                    <input type="text" class="form-control" id="reference_no" name="reference_no" placeholder="Enter reference number" value="<?php echo e(old('reference_no')); ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Three column row -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="reference_date" class="form-label"><strong><?php echo e(__('Reference Date')); ?></strong></label>
                                    <input type="date" class="form-control" id="reference_date" name="reference_date" value="<?php echo e(old('reference_date')); ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_terms" class="form-label"><strong><?php echo e(__('Payment Terms')); ?></strong></label>
                                    <input type="text" class="form-control" id="payment_terms" name="payment_terms" placeholder="Enter payment terms description">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_person" class="form-label"><strong><?php echo e(__('Contact Person')); ?></strong></label>
                                    <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Enter contact person" value="<?php echo e(old('contact_person')); ?>">
                                </div>
                            </div>
                        </div>

                        <!-- GST Type Section - Auto Determined -->
                        <!-- <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label"><strong><?php echo e(__('GST Type')); ?></strong></label>
                                    <div class="alert alert-info" id="gstTypeInfo">
                                        <i class="fas fa-info-circle"></i> 
                                        GST type will be automatically determined based on customer's shipping address.
                                        <div id="gstDetails" class="mt-2"></div>
                                    </div>
                                    <input type="hidden" name="gst_type" id="gst_type" value="">
                                </div>
                            </div>
                        </div> -->

                        <!-- Items Table - PROFESSIONAL DESIGN -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="itemsTable">
                                    <thead class="table-primary">
    <tr>
        <th width="3%">#</th>
        <th width="20%"><strong><?php echo e(__('Item Name*')); ?></strong></th>
        <th width="10%"><strong><?php echo e(__('Quantity')); ?></strong></th>
        <th width="12%"><strong><?php echo e(__('Unit Price')); ?></strong></th>
        <th width="13%"><strong><?php echo e(__('Discount')); ?></strong></th>
        <th width="8%" class="cgst-col"><strong><?php echo e(__('CGST(%)')); ?></strong></th>
        <th width="8%" class="sgst-col"><strong><?php echo e(__('SGST(%)')); ?></strong></th>
        <th width="8%" class="igst-col"><strong><?php echo e(__('IGST(%)')); ?></strong></th>
        <th width="10%"><strong><?php echo e(__('Total')); ?></strong></th>
        <th width="5%"><strong><?php echo e(__('Action')); ?></strong></th>
    </tr>
</thead>
                                        <tbody id="itemsBody">
                                            <!-- Default row -->
                                            <tr id="row_0">
                                                <td class="text-center">1</td>
                                                <td>
                                                    <input type="hidden" name="company_id" value="<?php echo e(Auth::user()->creatorId()); ?>">
<input type="hidden" name="created_by" value="<?php echo e(Auth::id()); ?>">

                                                    <select class="form-control item-select" name="items[0][item_id]" onchange="updateItemDetails(0)">
                                                        <option value=""><?php echo e(__('-select-')); ?></option>
                                                        <option value="1" data-price="250.00" data-cgst="9" data-sgst="9" data-igst="18">Office Chair</option>
                                                        <option value="2" data-price="500.00" data-cgst="9" data-sgst="9" data-igst="18">Office Desk</option>
                                                        <option value="3" data-price="300.00" data-cgst="9" data-sgst="9" data-igst="18">Computer Monitor</option>
                                                        <option value="4" data-price="75.00" data-cgst="9" data-sgst="9" data-igst="18">Keyboard & Mouse</option>
                                                        <option value="5" data-price="1200.00" data-cgst="9" data-sgst="9" data-igst="18">Conference Table</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control quantity text-end" name="items[0][quantity]" id="quantity_0" min="0.01" step="0.01" value="1.00" onchange="calculateRow(0)" onkeyup="calculateRow(0)">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control unit-price text-end" name="items[0][unit_price]" id="unit_price_0" min="0" step="0.01" value="0" onchange="calculateRow(0)" onkeyup="calculateRow(0)">
                                                </td>
                                                <td>
                                                    <div class="discount-container">
                                                        <div class="row g-1 align-items-center">
                                                            <div class="col-5">
                                                                <select class="form-control form-control-sm discount-type" name="items[0][discount_type]" id="discount_type_0" onchange="toggleDiscountInput(0)">
                                                                    <option value="percent">%</option>
                                                                    <option value="amount">₹</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-7">
                                                                <input type="number" class="form-control form-control-sm discount text-end" name="items[0][discount]" id="discount_0" min="0" step="0.01" value="0" onchange="calculateRow(0)" onkeyup="calculateRow(0)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="cgst-col">
                                                    <select class="form-control select2-cgst-rate cgst-rate" name="items[0][cgst_rate]" id="cgst_rate_0">
                                                        <option value="0">0%</option>
                                                        <option value="2.5">2.5%</option>
                                                        <option value="6">6%</option>
                                                        <option value="9" selected>9%</option>
                                                        <option value="14">14%</option>
                                                    </select>
                                                </td>
                                                <td class="sgst-col">
                                                    <select class="form-control select2-sgst-rate sgst-rate" name="items[0][sgst_rate]" id="sgst_rate_0">
                                                        <option value="0">0%</option>
                                                        <option value="2.5">2.5%</option>
                                                        <option value="6">6%</option>
                                                        <option value="9" selected>9%</option>
                                                        <option value="14">14%</option>
                                                    </select>
                                                </td>
                                                <td class="igst-col" style="display: none;">
                                                    <select class="form-control select2-igst-rate igst-rate" name="items[0][igst_rate]" id="igst_rate_0">
                                                        <option value="0">0%</option>
                                                        <option value="5">5%</option>
                                                        <option value="12">12%</option>
                                                        <option value="18" selected>18%</option>
                                                        <option value="28">28%</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control total-amount text-end" name="items[0][total_amount]" id="total_amount_0" value="0.00" readonly>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(0)" disabled>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addNewRow()">
                                    <i class="fas fa-plus"></i> <?php echo e(__('Add Item')); ?>

                                </button>
                            </div>
                        </div>

                        <!-- Totals Section -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="other_charges_amount" class="form-label"><strong><?php echo e(__('Other Charges')); ?></strong></label>
                                            <input type="number" class="form-control text-end" id="other_charges_amount" name="other_charges_amount" min="0" step="0.01" value="0" onchange="calculateTotals()" onkeyup="calculateTotals()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tax_percentage" class="form-label"><strong><?php echo e(__('Tax on Other Charges')); ?></strong></label>
                                            <select class="form-control select2-tax-percentage" id="tax_percentage" name="tax_percentage" onchange="calculateTotals()">
                                                <option value="0" selected>0%</option>
                                                <option value="5">5%</option>
                                                <option value="12">12%</option>
                                                <option value="18">18%</option>
                                                <option value="28">28%</option>
                                                <option value="2.5">2.5%</option>
                                                <option value="6">6%</option>
                                                <option value="9">9%</option>
                                                <option value="14">14%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="discount_on_all_percent" class="form-label"><strong><?php echo e(__('Discount on All')); ?></strong></label>
                                            <div class="row g-2">
                                                <div class="col-4">
                                                    <select class="form-control form-control-sm" id="discount_all_type" name="discount_all_type" onchange="toggleDiscountAllInput()">
                                                        <option value="percent">%</option>
                                                        <option value="amount">₹</option>
                                                    </select>
                                                </div>
                                                <div class="col-8">
                                                    <input type="number" class="form-control form-control-sm text-end" id="discount_on_all_value" name="discount_on_all_value" min="0" step="0.01" value="0" onchange="calculateTotals()" onkeyup="calculateTotals()">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label"><strong><?php echo e(__('Description')); ?></strong></label>
                                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description..."><?php echo e(old('description')); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered summary-table">
                                        <tbody>
                                            <tr>
                                                <td><strong><?php echo e(__('Total Items')); ?></strong></td>
                                                <td class="text-end"><span id="total_items_count">1</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo e(__('Total Quantity')); ?></strong></td>
                                                <td class="text-end"><span id="total_quantity_display">1.00</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo e(__('Subtotal')); ?></strong></td>
                                                <td class="text-end"><span id="subtotal_amount">₹0.00</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo e(__('Other Charges')); ?></strong></td>
                                                <td class="text-end"><span id="other_charges_display">₹0.00</span></td>
                                            </tr>
                                            <tr id="tax_on_other_charges_row" style="display: none;">
                                                <td><strong><?php echo e(__('Tax on Other Charges')); ?></strong></td>
                                                <td class="text-end"><span id="tax_on_other_charges_display">₹0.00</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo e(__('Discount on All')); ?></strong></td>
                                                <td class="text-end"><span id="discount_all_display">₹0.00</span></td>
                                            </tr>
                                            <tr id="cgst_row">
                                                <td><strong><?php echo e(__('CGST')); ?></strong></td>
                                                <td class="text-end"><span id="cgst_display">₹0.00</span></td>
                                            </tr>
                                            <tr id="sgst_row">
                                                <td><strong><?php echo e(__('SGST')); ?></strong></td>
                                                <td class="text-end"><span id="sgst_display">₹0.00</span></td>
                                            </tr>
                                            <tr id="igst_row" style="display: none;">
                                                <td><strong><?php echo e(__('IGST')); ?></strong></td>
                                                <td class="text-end"><span id="igst_display">₹0.00</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo e(__('Round Off')); ?></strong></td>
                                                <td class="text-end"><span id="round_off_display">₹0.00</span></td>
                                            </tr>
                                            <tr class="bg-success text-white">
                                                <td><strong><?php echo e(__('Grand Total')); ?></strong></td>
                                                <td class="text-end"><span id="grand_total_display">₹0.00</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Send Message to Customer -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="text-primary">
                                    <i class="fas fa-envelope"></i> <?php echo e(__('Send Message to Customer')); ?>

                                </h6>
                                <div class="form-group">
                                    <textarea class="form-control" id="customer_message" name="customer_message" rows="4" placeholder="Dear Customer,

We are pleased to submit our quotation for your kind consideration. Please find the details below.

Thank you for giving us this opportunity.

Best regards,
Savantec Team"><?php echo e(old('customer_message')); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" id="hidden_subtotal" name="subtotal" value="0">
                        <input type="hidden" id="hidden_cgst" name="cgst" value="0">
                        <input type="hidden" id="hidden_sgst" name="sgst" value="0">
                        <input type="hidden" id="hidden_igst" name="igst" value="0">
                        <input type="hidden" id="hidden_total_discount" name="total_discount" value="0">
                        <input type="hidden" id="hidden_round_off" name="round_off" value="0">
                        <input type="hidden" id="hidden_grand_total" name="grand_total" value="0">
                        <input type="hidden" id="hidden_total_items" name="total_items" value="1">
                        <input type="hidden" id="hidden_total_quantity" name="total_quantity" value="1.00">

                        <!-- Footer -->
                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success btn-lg px-5">
                                    <i class="fas fa-save"></i> <?php echo e(__('Save Quotation')); ?>

                                </button>
                                <a href="<?php echo e(route('quotation.index')); ?>" class="btn btn-outline-secondary btn-lg px-5">
                                    <i class="fas fa-times"></i> <?php echo e(__('Cancel')); ?>

                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet" />
<style>
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: none;
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 1.2rem 1.8rem;
        border-bottom: none;
    }
    
    .card-title {
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        margin: 0;
    }
    
    .card-body {
        padding: 1.8rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 8px;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-control, .select2-container .select2-selection--single {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 10px 14px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        height: 42px;
    }
    
    .form-control:focus, .select2-container--focus .select2-selection--single {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        transform: translateY(-1px);
    }
    
    .text-end {
        text-align: right !important;
    }
    
    .table {
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        margin-bottom: 0;
    }
    
    .table.table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
    }
    
    .table thead th {
        background-color: #4f46e5;
        color: white;
        border: none;
        padding: 14px 10px;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        vertical-align: middle;
         white-space: nowrap;
    min-width: 90px;
    }
    .cgst-col, .sgst-col, .igst-col {
    width: 90px !important;
    min-width: 90px;
}
    
    .table tbody td {
        padding: 12px 10px;
        vertical-align: middle;
        border-color: #f1f5f9;
        font-size: 0.9rem;
    }
    
    .table-bordered {
        border: 1px solid #e2e8f0;
    }
    
    .summary-table {
        background: #f8fafc;
    }
    
    .summary-table tbody tr:last-child {
        border-top: 2px solid #2d3748;
    }
    
    .bg-success {
        background-color: #10b981 !important;
    }
    
    .bg-success.text-white td {
        color: white !important;
        font-weight: 700;
        font-size: 1rem;
    }
    
    .bg-light {
        background-color: #f8fafc !important;
        color: #475569;
    }
    
    .text-primary {
        color: #4f46e5 !important;
    }
    
    .discount-container {
        padding: 2px 0;
    }
    
    .discount-container .row.g-1 > [class*="col-"] {
        padding-right: 4px;
        padding-left: 4px;
    }
    
    .discount-container .form-control-sm {
        height: 32px;
        font-size: 0.85rem;
        padding: 5px 8px;
        border-radius: 6px;
    }
    
    .discount-type {
        min-width: 60px;
    }
    
    .btn-outline-primary {
        border-color: #4f46e5;
        color: #4f46e5;
        transition: all 0.3s;
    }
    
    .btn-outline-primary:hover {
        background-color: #4f46e5;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    
    .btn-outline-danger {
        border-color: #ef4444;
        color: #ef4444;
        transition: all 0.3s;
    }
    
    .btn-outline-danger:hover {
        background-color: #ef4444;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        transition: all 0.3s;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(16, 185, 129, 0.4);
    }
    
    .btn-outline-secondary {
        transition: all 0.3s;
    }
    
    .btn-outline-secondary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(148, 163, 184, 0.3);
    }
    
    .alert-info {
        background-color: #f0f9ff;
        border-color: #bae6fd;
        color: #0369a1;
        border-radius: 8px;
        padding: 12px 16px;
    }
    
    .input-group-text {
        background-color: #f1f5f9;
        border-color: #e2e8f0;
        color: #475569;
        font-weight: 600;
    }
    
    .select2-container--default .select2-selection--single {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        height: 42px;
    }

    .select2-container--default {
    width: 100% !important;
}
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px;
        padding-left: 14px;
        color: #2d3748;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.2rem;
        }
        
        .table-responsive {
            border: none;
        }
        
        .table thead th {
            padding: 10px 8px;
            font-size: 0.8rem;
        }
        
        .table tbody td {
            padding: 10px 8px;
            font-size: 0.85rem;
        }
        
        .discount-container .row.g-1 > [class*="col-"] {
            padding-right: 3px;
            padding-left: 3px;
        }
        
        .discount-type {
            min-width: 50px;
        }
    }
    
    /* Print styles */
    @media print {
        .card {
            box-shadow: none;
            border: 1px solid #ddd;
        }
        
        .btn, .form-check, .text-end:last-child {
            display: none !important;
        }
        
        .table thead th {
            background-color: #f8f9fa !important;
            color: #000 !important;
            border-bottom: 2px solid #000;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>
<script>
    let rowCounter = 0;
    let currentGstType = 'cgst_sgst'; // Track current GST type globally
    
    $(document).ready(function() {
        // Initialize Select2 for main dropdowns
        $('.select2').select2({
            width: '100%',
            placeholder: 'Select...',
            allowClear: true,
            dropdownParent: $('#quotationForm')
        });
        
        // Initialize tax percentage select
        $('.select2-tax-percentage').select2({
            width: '100%',
            placeholder: 'Select Tax Rate',
            allowClear: false,
            minimumResultsForSearch: 0,
            dropdownParent: $('#quotationForm')
        });
        
        // Initialize item select for first row
        $('.item-select').select2({
            width: '100%',
            placeholder: 'Select Item',
            allowClear: true,
            dropdownParent: $('#quotationForm')
        });
        
        // Initialize tax rate select2 dropdowns for the first row
        initializeTaxRateSelect2(0);
        
        // Set initial GST type
        $('#gst_type').val(currentGstType);
        
        // Calculate initial totals
        calculateRow(0);
        calculateTotals();
    });
    
    // Function to initialize tax rate select2 dropdowns for a specific row
    function initializeTaxRateSelect2(rowId) {
        // All three columns should be initialized but shown/hidden based on GST type
        $(`#cgst_rate_${rowId}`).select2({
            width: '100%',
            placeholder: 'CGST %',
            allowClear: false,
            minimumResultsForSearch: 0,
            dropdownParent: $('#quotationForm')
        }).on('change', function() {
            calculateRow(rowId);
        });
        
        $(`#sgst_rate_${rowId}`).select2({
            width: '100%',
            placeholder: 'SGST %',
            allowClear: false,
            minimumResultsForSearch: 0,
            dropdownParent: $('#quotationForm')
        }).on('change', function() {
            calculateRow(rowId);
        });
        
        $(`#igst_rate_${rowId}`).select2({
            width: '100%',
            placeholder: 'IGST %',
            allowClear: false,
            minimumResultsForSearch: 0,
            dropdownParent: $('#quotationForm')
        }).on('change', function() {
            calculateRow(rowId);
        });
        
        // Apply current GST type visibility
        applyGstTypeToRow(rowId);
    }
    
    // Apply current GST type to a specific row
    function applyGstTypeToRow(rowId) {
        if (currentGstType === 'cgst_sgst') {
            // Show CGST+SGST, hide IGST
            $(`#row_${rowId} .cgst-col`).show();
            $(`#row_${rowId} .sgst-col`).show();
            $(`#row_${rowId} .igst-col`).hide();
            
            $(`#cgst_rate_${rowId}`).prop('disabled', false);
            $(`#sgst_rate_${rowId}`).prop('disabled', false);
            $(`#igst_rate_${rowId}`).prop('disabled', true);
        } else if (currentGstType === 'igst') {
            // Show IGST, hide CGST+SGST
            $(`#row_${rowId} .cgst-col`).hide();
            $(`#row_${rowId} .sgst-col`).hide();
            $(`#row_${rowId} .igst-col`).show();
            
            $(`#cgst_rate_${rowId}`).prop('disabled', true);
            $(`#sgst_rate_${rowId}`).prop('disabled', true);
            $(`#igst_rate_${rowId}`).prop('disabled', false);
        }
    }
    
    // Load customer details including GST type
    function loadCustomerDetails(customerId) {
        if (!customerId) {
            $('#customer_details').hide();
            $('#previous_due').hide();
            $('#contact_person').val('');
            $('#gstDetails').html('');
            $('#gst_type').val('');
            resetGSTColumns();
            return;
        }
        
        const selectedOption = $('#customer_id option:selected');
        const email = selectedOption.data('email') || '';
        const mobile = selectedOption.data('mobile') || '';
        const contactPerson = selectedOption.data('contact-person') || '';
        const previousDue = selectedOption.data('previous-due') || 0;
        
        // Display customer details
        if (email || mobile) {
            $('#customer_details').show();
            $('#customer_email_display').html(email ? `<i class="fas fa-envelope me-1"></i> ${email}` : '');
            $('#customer_mobile_display').html(mobile ? `<i class="fas fa-phone me-1"></i> ${mobile}` : '');
        } else {
            $('#customer_details').hide();
        }
        
        // Display previous due
        if (previousDue > 0) {
            $('#previous_due').show();
            $('#due_amount').text(parseFloat(previousDue).toFixed(2));
        } else {
            $('#previous_due').hide();
        }
        
        // Auto-fill contact person
        $('#contact_person').val(contactPerson);
        
        // Get GST type via AJAX
        getGstType(customerId);
    }
    
    // Get GST type from server
    function getGstType(customerId) {
        // Show loading
        $('#gstDetails').html('<i class="fas fa-spinner fa-spin me-2"></i> Determining GST type...');
        
        $.ajax({
            url: '<?php echo e(route("quotation.getGstType")); ?>',
            type: 'POST',
            data: {
                customer_id: customerId,
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function(response) {
                if (response.error) {
                    $('#gstDetails').html('<span class="text-danger"><i class="fas fa-exclamation-circle me-2"></i>' + response.error + '</span>');
                    return;
                }
                
                if (response.gst_type) {
                    // Update global GST type
                    currentGstType = response.gst_type;
                    $('#gst_type').val(response.gst_type);
                    
                    // Update GST type display
                    let gstDetailsHtml = `<strong>${response.message}</strong><br>`;
                    gstDetailsHtml += `<small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>Supplier State: ${response.supplier_state}</small><br>`;
                    gstDetailsHtml += `<small class="text-muted"><i class="fas fa-truck me-1"></i>Customer Shipping State: ${response.customer_state || 'Not specified'}</small>`;
                    $('#gstDetails').html(gstDetailsHtml);
                    
                    // Update GST columns based on type
                    updateGSTColumns(response.gst_type);
                    
                    // Recalculate all rows with new GST type
                    recalculateAllRows();
                }
            },
            error: function(xhr) {
                $('#gstDetails').html('<span class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Error determining GST type. Using default CGST+SGST.</span>');
                // Default to CGST+SGST on error
                currentGstType = 'cgst_sgst';
                $('#gst_type').val('cgst_sgst');
                updateGSTColumns('cgst_sgst');
                recalculateAllRows();
            }
        });
    }
    
    // Update GST columns with Select2 support
    function updateGSTColumns(gstType) {
        if (gstType === 'cgst_sgst') {
            // Show ONLY CGST+SGST columns, hide IGST in table header and body
            $('.cgst-col').show();
            $('.sgst-col').show();
            $('.igst-col').hide();
            
            // Update summary rows
            $('#cgst_row').show();
            $('#sgst_row').show();
            $('#igst_row').hide();
            
            // Apply to all rows
            $('#itemsBody tr').each(function(index) {
                applyGstTypeToRow(index);
            });
        } else if (gstType === 'igst') {
            // Show ONLY IGST column, hide CGST+SGST in table header and body
            $('.cgst-col').hide();
            $('.sgst-col').hide();
            $('.igst-col').show();
            
            // Update summary rows
            $('#cgst_row').hide();
            $('#sgst_row').hide();
            $('#igst_row').show();
            
            // Apply to all rows
            $('#itemsBody tr').each(function(index) {
                applyGstTypeToRow(index);
            });
        }
    }
    
    // Reset GST columns
    function resetGSTColumns() {
        currentGstType = 'cgst_sgst';
        updateGSTColumns('cgst_sgst');
    }
    
    // Toggle discount input type
    function toggleDiscountInput(rowId) {
        const discountType = $(`#discount_type_${rowId}`).val();
        const discountInput = $(`#discount_${rowId}`);
        
        if (discountType === 'amount') {
            discountInput.attr('placeholder', '₹');
            discountInput.attr('max', '');
        } else {
            discountInput.attr('placeholder', '%');
            discountInput.attr('max', '100');
        }
        
        calculateRow(rowId);
    }
    
    // Toggle discount on all input type
    function toggleDiscountAllInput() {
        const discountType = $('#discount_all_type').val();
        const discountInput = $('#discount_on_all_value');
        
        if (discountType === 'amount') {
            discountInput.attr('placeholder', 'Amount');
            discountInput.attr('max', '');
        } else {
            discountInput.attr('placeholder', 'Percentage');
            discountInput.attr('max', '100');
        }
        
        calculateTotals();
    }
    
    // Calculate row total
    function calculateRow(rowId) {
        const quantity = parseFloat($(`#quantity_${rowId}`).val()) || 0;
        const unitPrice = parseFloat($(`#unit_price_${rowId}`).val()) || 0;
        const discountType = $(`#discount_type_${rowId}`).val();
        const discountValue = parseFloat($(`#discount_${rowId}`).val()) || 0;
        
        // Calculate amount before discount
        const amount = quantity * unitPrice;
        
        // Calculate discount amount
        let discountAmount = 0;
        if (discountType === 'percent') {
            discountAmount = amount * (discountValue / 100);
        } else {
            discountAmount = discountValue;
        }
        
        // Ensure discount doesn't exceed amount
        discountAmount = Math.min(discountAmount, amount);
        
        const amountAfterDiscount = amount - discountAmount;
        
        // Calculate tax based on GST type
        let totalTax = 0;
        
        if (currentGstType === 'cgst_sgst') {
            const cgstRate = parseFloat($(`#cgst_rate_${rowId}:visible`).val()) || 0;
            const sgstRate = parseFloat($(`#sgst_rate_${rowId}:visible`).val()) || 0;
            totalTax = amountAfterDiscount * ((cgstRate + sgstRate) / 100);
        } else if (currentGstType === 'igst') {
            const igstRate = parseFloat($(`#igst_rate_${rowId}:visible`).val()) || 0;
            totalTax = amountAfterDiscount * (igstRate / 100);
        }
        
        // Calculate total
        const total = amountAfterDiscount + totalTax;
        
        // Update row total
        $(`#total_amount_${rowId}`).val(formatCurrency(total));
        
        // Recalculate totals
        calculateTotals();
    }
    
    // Recalculate all rows
    function recalculateAllRows() {
        $('#itemsBody tr').each(function(index) {
            calculateRow(index);
        });
        calculateTotals();
    }
    
    // Calculate all totals
    function calculateTotals() {
        let subtotal = 0;
        let totalCgst = 0;
        let totalSgst = 0;
        let totalIgst = 0;
        let totalQuantity = 0;
        let totalItems = $('#itemsBody tr').length;
        
        // Calculate from all rows
        $('#itemsBody tr').each(function(index) {
            const quantity = parseFloat($(`#quantity_${index}`).val()) || 0;
            const unitPrice = parseFloat($(`#unit_price_${index}`).val()) || 0;
            const discountType = $(`#discount_type_${index}`).val();
            const discountValue = parseFloat($(`#discount_${index}`).val()) || 0;
            const rowTotal = parseFloat($(`#total_amount_${index}`).val().replace(/[^0-9.-]+/g, "")) || 0;
            
            subtotal += rowTotal;
            totalQuantity += quantity;
            
            // Calculate tax amounts for this row
            const amount = quantity * unitPrice;
            
            // Calculate discount amount for tax calculation
            let discountAmount = 0;
            if (discountType === 'percent') {
                discountAmount = amount * (discountValue / 100);
            } else {
                discountAmount = discountValue;
            }
            
            discountAmount = Math.min(discountAmount, amount);
            const amountAfterDiscount = amount - discountAmount;
            
            if (currentGstType === 'cgst_sgst') {
                const cgstRate = parseFloat($(`#cgst_rate_${index}`).val()) || 0;
                const sgstRate = parseFloat($(`#sgst_rate_${index}`).val()) || 0;
                totalCgst += amountAfterDiscount * (cgstRate / 100);
                totalSgst += amountAfterDiscount * (sgstRate / 100);
            } else if (currentGstType === 'igst') {
                const igstRate = parseFloat($(`#igst_rate_${index}`).val()) || 0;
                totalIgst += amountAfterDiscount * (igstRate / 100);
            }
        });
        
        // Calculate other charges
        const otherCharges = parseFloat($('#other_charges_amount').val()) || 0;
        const taxPercentage = parseFloat($('#tax_percentage').val()) || 0;
        const discountAllType = $('#discount_all_type').val();
        const discountAllValue = parseFloat($('#discount_on_all_value').val()) || 0;
        
        // Calculate tax on other charges
        let taxOnOtherCharges = 0;
        if (otherCharges > 0 && taxPercentage > 0) {
            taxOnOtherCharges = otherCharges * (taxPercentage / 100);
            $('#tax_on_other_charges_row').show();
        } else {
            $('#tax_on_other_charges_row').hide();
        }
        
        // Calculate discount on all
        let discountAllAmount = 0;
        if (discountAllType === 'percent') {
            discountAllAmount = subtotal * (discountAllValue / 100);
        } else {
            discountAllAmount = discountAllValue;
        }
        
        // Ensure discount doesn't exceed subtotal
        discountAllAmount = Math.min(discountAllAmount, subtotal);
        
        // Calculate grand total before round off
        let grandTotal = subtotal + otherCharges + taxOnOtherCharges - discountAllAmount;
        
        // Calculate round off
        const roundOff = Math.round(grandTotal) - grandTotal;
        grandTotal = Math.round(grandTotal);
        
        // Format currency
        const formatCurrency = (num) => {
            return '₹' + num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        };
        
        // Update display values
        $('#total_items_count').text(totalItems);
        $('#total_quantity_display').text(totalQuantity.toFixed(2));
        $('#subtotal_amount').text(formatCurrency(subtotal));
        $('#other_charges_display').text(formatCurrency(otherCharges));
        $('#tax_on_other_charges_display').text(formatCurrency(taxOnOtherCharges));
        $('#discount_all_display').text('- ' + formatCurrency(discountAllAmount));
        $('#cgst_display').text(formatCurrency(totalCgst));
        $('#sgst_display').text(formatCurrency(totalSgst));
        $('#igst_display').text(formatCurrency(totalIgst));
        $('#round_off_display').text(formatCurrency(roundOff));
        $('#grand_total_display').text(formatCurrency(grandTotal));
        
        // Update hidden fields
        $('#hidden_subtotal').val(subtotal.toFixed(2));
        $('#hidden_cgst').val(totalCgst.toFixed(2));
        $('#hidden_sgst').val(totalSgst.toFixed(2));
        $('#hidden_igst').val(totalIgst.toFixed(2));
        $('#hidden_total_discount').val(discountAllAmount.toFixed(2));
        $('#hidden_round_off').val(roundOff.toFixed(2));
        $('#hidden_grand_total').val(grandTotal.toFixed(2));
        $('#hidden_total_items').val(totalItems);
        $('#hidden_total_quantity').val(totalQuantity.toFixed(2));
    }
    
    // Format currency helper function
    function formatCurrency(num) {
        return '₹' + num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    
    // Add new row
    function addNewRow() {
        rowCounter++;
        const rowNumber = rowCounter + 1;
        
        // Create new row with all three GST columns
        const newRow = `
            <tr id="row_${rowCounter}">
                <td class="text-center">${rowNumber}</td>
                <td>
                    <select class="form-control item-select" name="items[${rowCounter}][item_id]" onchange="updateItemDetails(${rowCounter})">
                        <option value=""><?php echo e(__('-select-')); ?></option>
                        <option value="1" data-price="250.00" data-cgst="9" data-sgst="9" data-igst="18">Office Chair</option>
                        <option value="2" data-price="500.00" data-cgst="9" data-sgst="9" data-igst="18">Office Desk</option>
                        <option value="3" data-price="300.00" data-cgst="9" data-sgst="9" data-igst="18">Computer Monitor</option>
                        <option value="4" data-price="75.00" data-cgst="9" data-sgst="9" data-igst="18">Keyboard & Mouse</option>
                        <option value="5" data-price="1200.00" data-cgst="9" data-sgst="9" data-igst="18">Conference Table</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control quantity text-end" name="items[${rowCounter}][quantity]" id="quantity_${rowCounter}" min="0.01" step="0.01" value="1.00" onchange="calculateRow(${rowCounter})" onkeyup="calculateRow(${rowCounter})">
                </td>
                <td>
                    <input type="number" class="form-control unit-price text-end" name="items[${rowCounter}][unit_price]" id="unit_price_${rowCounter}" min="0" step="0.01" value="0" onchange="calculateRow(${rowCounter})" onkeyup="calculateRow(${rowCounter})">
                </td>
                <td>
                    <div class="discount-container">
                        <div class="row g-1 align-items-center">
                            <div class="col-5">
                                <select class="form-control form-control-sm discount-type" name="items[${rowCounter}][discount_type]" id="discount_type_${rowCounter}" onchange="toggleDiscountInput(${rowCounter})">
                                    <option value="percent">%</option>
                                    <option value="amount">₹</option>
                                </select>
                            </div>
                            <div class="col-7">
                                <input type="number" class="form-control form-control-sm discount text-end" name="items[${rowCounter}][discount]" id="discount_${rowCounter}" min="0" step="0.01" value="0" onchange="calculateRow(${rowCounter})" onkeyup="calculateRow(${rowCounter})">
                            </div>
                        </div>
                    </div>
                </td>
                <td class="cgst-col">
                    <select class="form-control cgst-rate" name="items[${rowCounter}][cgst_rate]" id="cgst_rate_${rowCounter}">
                        <option value="0">0%</option>
                        <option value="2.5">2.5%</option>
                        <option value="6">6%</option>
                        <option value="9" selected>9%</option>
                        <option value="14">14%</option>
                    </select>
                </td>
                <td class="sgst-col">
                    <select class="form-control sgst-rate" name="items[${rowCounter}][sgst_rate]" id="sgst_rate_${rowCounter}">
                        <option value="0">0%</option>
                        <option value="2.5">2.5%</option>
                        <option value="6">6%</option>
                        <option value="9" selected>9%</option>
                        <option value="14">14%</option>
                    </select>
                </td>
                <td class="igst-col">
                    <select class="form-control igst-rate" name="items[${rowCounter}][igst_rate]" id="igst_rate_${rowCounter}">
                        <option value="0">0%</option>
                        <option value="5">5%</option>
                        <option value="12">12%</option>
                        <option value="18" selected>18%</option>
                        <option value="28">28%</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control total-amount text-end" name="items[${rowCounter}][total_amount]" id="total_amount_${rowCounter}" value="0.00" readonly>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(${rowCounter})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        
        $('#itemsBody').append(newRow);
        
        // Initialize Select2 for new row
        $(`#row_${rowCounter} .item-select`).select2({
            width: '100%',
            placeholder: 'Select Item',
            allowClear: true,
            dropdownParent: $('#quotationForm')
        });
        
        // Initialize tax rate Select2 dropdowns for the new row
        initializeTaxRateSelect2(rowCounter);
        
        // Initialize discount input
        toggleDiscountInput(rowCounter);
        
        // Enable delete button on first row if it was disabled
        if (rowCounter === 1) {
            $('#row_0 .btn-outline-danger').prop('disabled', false);
        }
        
        // Update row numbers
        updateRowNumbers();
        calculateTotals();
    }
    
    function removeRow(rowId) {
        if ($('#itemsBody tr').length > 1) {
            $('#row_' + rowId).remove();
            updateRowNumbers();
            calculateTotals();
            
            // Disable delete button on first row if only one row remains
            if ($('#itemsBody tr').length === 1) {
                $('#row_0 .btn-outline-danger').prop('disabled', true);
            }
        }
    }
    
    function updateRowNumbers() {
        $('#itemsBody tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
    }
    
    function updateItemDetails(rowId) {
        const selectedOption = $(`#row_${rowId} .item-select option:selected`);
        const price = selectedOption.data('price') || 0;
        const defaultCgst = selectedOption.data('cgst') || 9;
        const defaultSgst = selectedOption.data('sgst') || 9;
        const defaultIgst = selectedOption.data('igst') || 18;
        
        $(`#unit_price_${rowId}`).val(price);
        
        // Update tax rates based on current GST type
        if (currentGstType === 'cgst_sgst') {
            $(`#cgst_rate_${rowId}`).val(defaultCgst).trigger('change');
            $(`#sgst_rate_${rowId}`).val(defaultSgst).trigger('change');
        } else if (currentGstType === 'igst') {
            $(`#igst_rate_${rowId}`).val(defaultIgst).trigger('change');
        }
        
        calculateRow(rowId);
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WORK GPT\Github repo\savantec-erp\resources\views/quotation/create.blade.php ENDPATH**/ ?>