

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Enquiry List')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Enquiry')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('enquiry_add')): ?>
            <a href="<?php echo e(route('enquiry.create')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="mt-2" id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        <?php echo e(Form::open(['route' => ['enquiry.index'], 'method' => 'GET', 'id' => 'enquiry_form'])); ?>

                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">

                                    <!-- From Date Filter -->
                                    <div class="col-3">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('from_date', __('From Date'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::date('from_date', isset($_GET['from_date']) ? $_GET['from_date'] : null, ['class' => 'form-control', 'id' => 'from_date'])); ?>

                                        </div>
                                    </div>

                                    <!-- To Date Filter -->
                                    <div class="col-3">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('to_date', __('To Date'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::date('to_date', isset($_GET['to_date']) ? $_GET['to_date'] : null, ['class' => 'form-control', 'id' => 'to_date'])); ?>

                                        </div>
                                    </div>

                                    <!-- Company Filter -->
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('company_id', __('Company'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('company_id', $companies, isset($_GET['company_id']) ? $_GET['company_id'] : '', ['class' => 'form-control select', 'id' => 'company_id'])); ?>

                                        </div>
                                    </div>

                                    <!-- Status Filter -->
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('status', __('Status'), ['class' => 'form-label'])); ?>

                                            <select name="status" class="form-control select" id="status">
                                                <option value=""><?php echo e(__('All Status')); ?></option>
                                                <option value="pending" <?php echo e(isset($_GET['status']) && $_GET['status'] == 'pending' ? 'selected' : ''); ?>><?php echo e(__('Pending')); ?></option>
                                                <option value="assigned" <?php echo e(isset($_GET['status']) && $_GET['status'] == 'assigned' ? 'selected' : ''); ?>><?php echo e(__('Assigned')); ?></option>
                                                <option value="quoted" <?php echo e(isset($_GET['status']) && $_GET['status'] == 'quoted' ? 'selected' : ''); ?>><?php echo e(__('Quoted')); ?></option>
                                                <option value="purchased" <?php echo e(isset($_GET['status']) && $_GET['status'] == 'purchased' ? 'selected' : ''); ?>><?php echo e(__('Purchased')); ?></option>
                                                <option value="cancelled" <?php echo e(isset($_GET['status']) && $_GET['status'] == 'cancelled' ? 'selected' : ''); ?>><?php echo e(__('Cancelled')); ?></option>
                                                <option value="completed" <?php echo e(isset($_GET['status']) && $_GET['status'] == 'completed' ? 'selected' : ''); ?>><?php echo e(__('Completed')); ?></option>
                                                <option value="ignored" <?php echo e(isset($_GET['status']) && $_GET['status'] == 'ignored' ? 'selected' : ''); ?>><?php echo e(__('Ignored')); ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Sales Engineer Filter -->
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            <?php echo e(Form::label('salesman_id', __('Sales Engineer'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('salesman_id', $salesmen, isset($_GET['salesman_id']) ? $_GET['salesman_id'] : '', ['class' => 'form-control select', 'id' => 'salesman_id'])); ?>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-auto mt-4">
                                <div class="row">
                                    <div class="col-auto">

                                        <!-- Apply Button -->
                                        <button type="button" class="btn btn-sm btn-primary" id="apply-filter" data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </button>

                                        <!-- Reset Button -->
                                        <a href="<?php echo e(route('enquiry.index')); ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="<?php echo e(__('Reset')); ?>">
                                            <span class="btn-inner--icon"><i class="ti ti-refresh text-white"></i></span>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style mt-2">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Date')); ?></th>
                                    <th><?php echo e(__('Company')); ?></th>
                                    <th><?php echo e(__('Contact Person')); ?></th>
                                    <th><?php echo e(__('Product')); ?></th>
                                    <th><?php echo e(__('Quantity')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Sales Engineer')); ?></th>
                                    <th><?php echo e(__('Remarks')); ?></th>
                                    <?php if(Gate::check('enquiry_edit') || Gate::check('enquiry_delete')): ?>
                                        <th width="10%"><?php echo e(__('Action')); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $enquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="font-style">
                                        <td><?php echo e(Auth::user()->dateFormat($enquiry->enquiry_date)); ?></td>
                                        <td><?php echo e($enquiry->company->name ?? '-'); ?></td>
                                        <td><?php echo e($enquiry->contact_person ?? '-'); ?></td>
                                        <td><?php echo e($enquiry->product ?? '-'); ?></td>
                                        <td><?php echo e($enquiry->quantity ?? '-'); ?></td>
                                        <td>
                                            <?php
                                                $statusClass = [
                                                    'pending' => 'warning',
                                                    'assigned' => 'info',
                                                    'quoted' => 'primary',
                                                    'purchased' => 'success',
                                                    'cancelled' => 'danger',
                                                    'completed' => 'dark',
                                                    'ignored' => 'secondary'
                                                ][$enquiry->status] ?? 'secondary';
                                            ?>
                                            <span class="badge bg-<?php echo e($statusClass); ?>">
                                                <?php echo e(ucfirst($enquiry->status)); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($enquiry->salesman->name ?? '-'); ?></td>
                                        <td><?php echo e(Str::limit($enquiry->remarks, 30) ?? '-'); ?></td>
                                        
                                        <?php if(Gate::check('enquiry_edit') || Gate::check('enquiry_delete')): ?>
                                            <td class="Action">
                                                <span>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('enquiry_edit')): ?>
                                                        <div class="action-btn bg-primary ms-2">
                                                            <a href="<?php echo e(route('enquiry.edit', $enquiry->id)); ?>" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>" data-original-title="<?php echo e(__('Edit')); ?>">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('enquiry_delete')): ?>
                                                        <div class="action-btn bg-danger ms-2">
                                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['enquiry.destroy', $enquiry->id], 'class' => 'delete-form-btn', 'id' => 'delete-form-'.$enquiry->id]); ?>

                                                            <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($enquiry->id); ?>').submit();">
                                                                <i class="ti ti-trash text-white"></i>
                                                            </a>
                                                            <?php echo Form::close(); ?>

                                                        </div>
                                                    <?php endif; ?>
                                                </span>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select').select2({
            width: '100%',
            theme: 'bootstrap-5'
        });

        // Apply filter button click handler
        $('#apply-filter').on('click', function() {
            var params = {};
            
            // Collect only non-empty values
            var fromDate = $('#from_date').val();
            var toDate = $('#to_date').val();
            var companyId = $('#company_id').val();
            var status = $('#status').val();
            var salesmanId = $('#salesman_id').val();
            
            if (fromDate) params.from_date = fromDate;
            if (toDate) params.to_date = toDate;
            if (companyId) params.company_id = companyId;
            if (status) params.status = status;
            if (salesmanId) params.salesman_id = salesmanId;
            
            // Build query string
            var queryString = Object.keys(params).map(key => 
                key + '=' + encodeURIComponent(params[key])
            ).join('&');
            
            // Navigate to URL with clean parameters
            var baseUrl = "<?php echo e(route('enquiry.index')); ?>";
            var url = queryString ? baseUrl + '?' + queryString : baseUrl;
            
            window.location.href = url;
        });

        // Optional: Press Enter in any field to apply filter
        $('#enquiry_form input, #enquiry_form select').on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                e.preventDefault();
                $('#apply-filter').click();
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-github\resources\views/enquiry/index.blade.php ENDPATH**/ ?>