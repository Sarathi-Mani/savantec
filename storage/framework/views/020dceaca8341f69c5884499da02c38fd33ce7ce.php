<!-- resources/views/enquiry/partials/table.blade.php -->
<div class="table-responsive">
    <table class="table table-bordered table-hover mb-0" id="enquiryDataTable">
        <thead class="table-light">
            <tr>
                <th width="60"><?php echo e(__('S.No')); ?></th>
                <th><?php echo e(__('Enquiry No')); ?></th>
                <th><?php echo e(__('Enquiry Date')); ?></th>
                <th><?php echo e(__('Company Name')); ?></th>
                <th><?php echo e(__('Salesman')); ?></th>
                <th><?php echo e(__('Status')); ?></th>
                <th class="no-export"><?php echo e(__('Action')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $enquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $enquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <!-- MAIN ROW - This will be processed by DataTables -->
                <tr>
                    <td class="text-center"><?php echo e($enquiries->firstItem() + $index); ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-primary me-2 toggle-details" 
                                    data-bs-toggle="collapse"  
                                    data-bs-target="#details-<?php echo e($enquiry->id); ?>"
                                    aria-expanded="false"
                                    aria-controls="details-<?php echo e($enquiry->id); ?>"
                                    data-bs-toggle="tooltip" 
                                    title="<?php echo e(__('Show/Hide Details')); ?>">
                                <i class="ti ti-plus"></i>
                            </button>
                            <div>
                                <strong><?php echo e($enquiry->serial_no); ?></strong>
                                <?php if($enquiry->kind_attn): ?>
                                    <br><small class="text-muted">Attn: <?php echo e($enquiry->kind_attn); ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td><?php echo e(\Carbon\Carbon::parse($enquiry->enquiry_date)->format('d-m-Y')); ?></td>
                    <td>
                        <div class="fw-medium"><?php echo e($enquiry->company_name); ?></div>
                        <?php if($enquiry->mail_id): ?>
                            <small class="text-muted d-block"><?php echo e($enquiry->mail_id); ?></small>
                        <?php endif; ?>
                        <?php if($enquiry->phone_no): ?>
                            <small class="text-muted"><?php echo e($enquiry->phone_no); ?></small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($enquiry->salesman): ?>
                            <div class="fw-medium"><?php echo e($enquiry->salesman->name); ?></div>
                            <?php if($enquiry->salesman->phone): ?>
                                <small class="text-muted"><?php echo e($enquiry->salesman->phone); ?></small>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-muted"><?php echo e(__('Not Assigned')); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php
                            $statusColors = [
                                'pending' => 'warning',
                                'assigned' => 'info',
                                'quoted' => 'primary',
                                'purchased' => 'success',
                                'cancelled' => 'danger',
                                'completed' => 'success',
                                'ignored' => 'secondary'
                            ];
                            $color = $statusColors[$enquiry->status] ?? 'secondary';
                            
                            $statusText = ucfirst($enquiry->status);
                            if($enquiry->status == 'completed' && $enquiry->question_no) {
                                $statusText = 'Completed Question No: ' . $enquiry->question_no;
                            }
                        ?>
                        <span class="badge bg-<?php echo e($color); ?>">
                            <?php echo e($statusText); ?>

                        </span>
                    </td>
                    <td class="no-export">
                        <?php if($enquiry->status == 'completed'): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('enquiry_view')): ?>
                            <a href="<?php echo e(route('enquiry.show', $enquiry->id)); ?>" class="btn btn-sm btn-success w-100 mb-1">
                                <i class="ti ti-eye"></i> <?php echo e(__('View')); ?>

                            </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- Not Completed: Assign button -->
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('enquiry_edit')): ?>
                                <a class="btn btn-sm btn-primary w-100 mb-1" href="<?php echo e(route('enquiry.edit', $enquiry->id)); ?>">
                                    <i class="ti ti-person me-2"></i><?php echo e(__('Assign')); ?>

                                </a>
                            <?php else: ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('enquiry_view')): ?>
                                <a href="<?php echo e(route('enquiry.show', $enquiry->id)); ?>" class="btn btn-sm btn-info w-100 mb-1">
                                    <i class="ti ti-eye"></i> <?php echo e(__('View')); ?>

                                </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
                
                <!-- HIDDEN DETAIL ROW - MUST be placed OUTSIDE the tbody or use different approach -->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-4"><?php echo e(__('No enquiries found')); ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- HIDDEN DETAILS CONTAINER - Place OUTSIDE the DataTable -->
<?php $__currentLoopData = $enquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="collapse" id="details-<?php echo e($enquiry->id); ?>" style="margin-top: -1px;">
        <div class="card border-0 m-0">
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <small class="text-muted d-block"><?php echo e(__('Assigned Date & Time')); ?></small>
                            <strong>
                                <?php if($enquiry->assigned_date_time): ?>
                                    <?php echo e(\Carbon\Carbon::parse($enquiry->assigned_date_time)->format('d-m-Y H:i:s')); ?>

                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </strong>
                        </div>
                    </div>
                    <div class="col-md-6">   
                        <div class="mb-2">
                            <small class="text-muted d-block"><?php echo e(__('Purchase Date & Time')); ?></small>
                            <strong>
                                <?php if($enquiry->purchase_date_time): ?>
                                    <?php echo e(\Carbon\Carbon::parse($enquiry->purchase_date_time)->format('d-m-Y H:i:s')); ?>

                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <small class="text-muted d-block"><?php echo e(__('Quotation Date & Time')); ?></small>
                            <strong>
                                <?php if($enquiry->quotation_date_time): ?>
                                    <?php echo e(\Carbon\Carbon::parse($enquiry->quotation_date_time)->format('d-m-Y H:i:s')); ?>

                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </strong>
                        </div>
                    </div>
                   
                    <?php if($enquiry->remarks): ?>
                    <div class="col-md-12 mt-2">
                        <div class="mb-0">
                            <small class="text-muted d-block"><?php echo e(__('Remarks')); ?></small>
                                <?php echo e($enquiry->remarks); ?>

                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<!-- Alternative: Custom Pagination with Page Numbers -->
<?php if($enquiries->hasPages()): ?>
    <div class="mt-3 pt-3 border-top">
        <div class="d-flex justify-content-end">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm">
                    
                    <li class="page-item <?php echo e($enquiries->onFirstPage() ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e($enquiries->previousPageUrl()); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    
                    
                    <?php for($i = 1; $i <= $enquiries->lastPage(); $i++): ?>
                        <li class="page-item <?php echo e($i == $enquiries->currentPage() ? 'active' : ''); ?>">
                            <a class="page-link" href="<?php echo e($enquiries->url($i)); ?>"><?php echo e($i); ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    
                    <li class="page-item <?php echo e(!$enquiries->hasMorePages() ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e($enquiries->nextPageUrl()); ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
<?php endif; ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-github\resources\views/enquiry/partials/table.blade.php ENDPATH**/ ?>