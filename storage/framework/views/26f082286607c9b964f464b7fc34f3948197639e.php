

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Quotations')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Quotations')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-buttons','data' => ['tableId' => 'quotationsTable','createButton' => true,'createRoute' => ''.e(route('quotation.create')).'','createPermission' => 'create quotation','createLabel' => 'New Quotation','createIcon' => 'ti-plus','createTooltip' => 'Create New Quotation','columns' => [
            ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Quotation Date', 'description' => 'Date when quotation was created'],
            ['index' => 2, 'name' => 'Expiry Date', 'description' => 'Quotation expiry date'],
            ['index' => 3, 'name' => 'Quotation Code', 'description' => 'Unique quotation code'],
            ['index' => 4, 'name' => 'Reference No', 'description' => 'Reference number'],
            ['index' => 5, 'name' => 'Customer', 'description' => 'Customer name'],
            ['index' => 6, 'name' => 'Salesman', 'description' => 'Salesperson name'],
            ['index' => 7, 'name' => 'Total', 'description' => 'Total amount'],
            ['index' => 8, 'name' => 'Status', 'description' => 'Quotation status'],
            ['index' => 9, 'name' => 'Actions', 'description' => 'View/Edit/Print/Convert/Delete actions']
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'quotationsTable','createButton' => true,'createRoute' => ''.e(route('quotation.create')).'','createPermission' => 'create quotation','createLabel' => 'New Quotation','createIcon' => 'ti-plus','createTooltip' => 'Create New Quotation','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Quotation Date', 'description' => 'Date when quotation was created'],
            ['index' => 2, 'name' => 'Expiry Date', 'description' => 'Quotation expiry date'],
            ['index' => 3, 'name' => 'Quotation Code', 'description' => 'Unique quotation code'],
            ['index' => 4, 'name' => 'Reference No', 'description' => 'Reference number'],
            ['index' => 5, 'name' => 'Customer', 'description' => 'Customer name'],
            ['index' => 6, 'name' => 'Salesman', 'description' => 'Salesperson name'],
            ['index' => 7, 'name' => 'Total', 'description' => 'Total amount'],
            ['index' => 8, 'name' => 'Status', 'description' => 'Quotation status'],
            ['index' => 9, 'name' => 'Actions', 'description' => 'View/Edit/Print/Convert/Delete actions']
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
                    
                    <div class="table-responsive">
                        <table class="table w-100" id="quotationsTable">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center"><?php echo e(__('#')); ?></th>
                                    <th><?php echo e(__('Quotation Date')); ?></th>
                                    <th><?php echo e(__('Expiry Date')); ?></th>
                                    <th><?php echo e(__('Quotation Code')); ?></th>
                                    <th><?php echo e(__('Reference No')); ?></th>
                                    <th><?php echo e(__('Customer')); ?></th>
                                    <th><?php echo e(__('Salesman')); ?></th>
                                    <th class="text-end"><?php echo e(__('Total')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th width="250" class="text-center"><?php echo e(__('Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $quotations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $quotation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="text-center"><?php echo e($key + 1); ?></td>
                                        <td>
                                            <?php echo e(\Carbon\Carbon::parse($quotation->quotation_date)->format('d-m-Y')); ?>

                                        </td>
                                        <td>
                                            <?php if($quotation->expire_date): ?>
                                                <?php echo e(\Carbon\Carbon::parse($quotation->expire_date)->format('d-m-Y')); ?>

                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?php echo e($quotation->quotation_code); ?></strong>
                                        </td>
                                        <td>
                                            <?php if($quotation->reference_no): ?>
                                                <?php echo e($quotation->reference_no); ?>

                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo e($quotation->customer_name); ?>

                                        </td>
                                        <td>
                                            <?php
                                                $salesman = \App\Models\User::find($quotation->salesman_id);
                                            ?>
                                            <?php echo e($salesman->name ?? 'N/A'); ?>

                                        </td>
                                        <td class="text-end fw-bold">
                                            <?php echo e(number_format($quotation->grand_total, 2)); ?>

                                        </td>
                                        <td>
                                            <?php
                                                $statusColors = [
                                                    'open' => 'primary',
                                                    'closed' => 'success',
                                                    'po_converted' => 'info',
                                                    'lost' => 'danger'
                                                ];
                                                $color = $statusColors[$quotation->status] ?? 'secondary';
                                                $statusLabels = [
                                                    'open' => 'Open',
                                                    'closed' => 'Closed',
                                                    'po_converted' => 'PO Converted',
                                                    'lost' => 'Lost'
                                                ];
                                                $label = $statusLabels[$quotation->status] ?? ucfirst($quotation->status);
                                            ?>
                                            <span class="badge bg-<?php echo e($color); ?>">
                                                <?php echo e($label); ?>

                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view quotation')): ?>
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="<?php echo e(route('quotation.show', $quotation->id)); ?>" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="<?php echo e(__('View Quotation')); ?>">
                                                        <i class="ti ti-eye text-dark"></i>
                                                    </a>
                                                </div>
                                                <?php endif; ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit quotation')): ?>
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="<?php echo e(route('quotation.edit', $quotation->id)); ?>" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="<?php echo e(__('Edit Quotation')); ?>">
                                                        <i class="ti ti-pencil text-dark"></i>
                                                    </a>
                                                </div>
                                                <?php endif; ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('print quotation')): ?>
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <a href="<?php echo e(route('quotation.print', $quotation->id)); ?>" 
                                                       target="_blank"
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                       data-bs-toggle="tooltip" 
                                                       title="<?php echo e(__('Print Quotation')); ?>">
                                                        <i class="ti ti-printer text-dark"></i>
                                                    </a>
                                                </div>
                                                <?php endif; ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('convert quotation')): ?>
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <button type="button" 
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                            data-bs-toggle="tooltip" 
                                                            title="<?php echo e(__('Convert to Invoice')); ?>"
                                                            onclick="convertToInvoice(<?php echo e($quotation->id); ?>)">
                                                        <i class="ti ti-file-invoice text-success"></i>
                                                    </button>
                                                </div>
                                                <?php endif; ?>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete quotation')): ?>
                                                <div class="action-btn bg-light-secondary ms-2">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['quotation.destroy', $quotation->id], 'id' => 'delete-form-' . $quotation->id, 'class' => 'd-inline']); ?>

                                                    <a href="#!" 
                                                       class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" 
                                                       data-bs-toggle="tooltip" 
                                                       title="<?php echo e(__('Delete Quotation')); ?>" 
                                                       data-confirm="<?php echo e(__('Are You Sure?')); ?>" 
                                                       data-text="<?php echo e(__('This action will permanently delete the quotation. Do you want to continue?')); ?>" 
                                                       data-confirm-yes="delete-form-<?php echo e($quotation->id); ?>">
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
                                        <td colspan="10" class="text-center">
                                            <div class="alert alert-info d-inline-flex align-items-center">
                                                <i class="ti ti-info-circle me-2"></i>
                                                <?php echo e(__('No quotations found.')); ?>

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create quotation')): ?>
                                                <a href="<?php echo e(route('quotation.create')); ?>" class="alert-link ms-1">
                                                    <?php echo e(__('Create your first quotation')); ?>

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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-scripts','data' => ['tableId' => 'quotationsTable','searchPlaceholder' => 'Search quotations...','pdfTitle' => 'Quotations']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-scripts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'quotationsTable','searchPlaceholder' => 'Search quotations...','pdfTitle' => 'Quotations']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    
    <script>
    function convertToInvoice(quotationId) {
        if (confirm('Are you sure you want to convert this quotation to an invoice?')) {
            window.location.href = '<?php echo e(url('quotation')); ?>/' + quotationId + '/convert-to-invoice';
        }
    }
    
    // Add delete confirmation for quotations
    document.addEventListener('DOMContentLoaded', function() {
        const passButtons = document.querySelectorAll('.bs-pass-para');
        passButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const formId = this.getAttribute('data-confirm-yes');
                const confirmText = this.getAttribute('data-text');
                const confirmMessage = this.getAttribute('data-confirm');
                
                if (confirm(confirmMessage + '\n\n' + confirmText)) {
                    document.getElementById(formId).submit();
                }
            });
        });
    });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-github\resources\views/quotation/index.blade.php ENDPATH**/ ?>