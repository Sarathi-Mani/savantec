

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Enquiry List')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Enquiry')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.export-buttons','data' => ['tableId' => 'enquiryTable','createButton' => true,'createRoute' => ''.e(route('enquiry.create')).'','createPermission' => 'enquiry_add','createLabel' => 'New Enquiry','createIcon' => 'ti-plus','createTooltip' => 'Create New Enquiry','columns' => [
            ['index' => 0, 'name' => 'S.No', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Enquiry No', 'description' => 'Enquiry number'],
            ['index' => 2, 'name' => 'Enquiry Date', 'description' => 'Date of enquiry'],
            ['index' => 3, 'name' => 'Company Name', 'description' => 'Company name'],
            ['index' => 4, 'name' => 'Salesman', 'description' => 'Assigned salesman'],
            ['index' => 5, 'name' => 'Status', 'description' => 'Enquiry status'],
            ['index' => 6, 'name' => 'Actions', 'description' => 'View/Edit/Delete actions']
        ],'customButtons' => [
            [
                'label' => 'CSV',
                'icon' => 'ti-download',
                'class' => 'btn btn-outline-success btn-sm',
                'tooltip' => 'Export as CSV',
                'onclick' => 'exportCSV()'
            ],
            [
                'label' => 'Print',
                'icon' => 'ti-printer',
                'class' => 'btn btn-outline-secondary btn-sm',
                'tooltip' => 'Print Report',
                'onclick' => 'printReport()'
            ]
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('export-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'enquiryTable','createButton' => true,'createRoute' => ''.e(route('enquiry.create')).'','createPermission' => 'enquiry_add','createLabel' => 'New Enquiry','createIcon' => 'ti-plus','createTooltip' => 'Create New Enquiry','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['index' => 0, 'name' => 'S.No', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Enquiry No', 'description' => 'Enquiry number'],
            ['index' => 2, 'name' => 'Enquiry Date', 'description' => 'Date of enquiry'],
            ['index' => 3, 'name' => 'Company Name', 'description' => 'Company name'],
            ['index' => 4, 'name' => 'Salesman', 'description' => 'Assigned salesman'],
            ['index' => 5, 'name' => 'Status', 'description' => 'Enquiry status'],
            ['index' => 6, 'name' => 'Actions', 'description' => 'View/Edit/Delete actions']
        ]),'customButtons' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            [
                'label' => 'CSV',
                'icon' => 'ti-download',
                'class' => 'btn btn-outline-success btn-sm',
                'tooltip' => 'Export as CSV',
                'onclick' => 'exportCSV()'
            ],
            [
                'label' => 'Print',
                'icon' => 'ti-printer',
                'class' => 'btn btn-outline-secondary btn-sm',
                'tooltip' => 'Print Report',
                'onclick' => 'printReport()'
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
                    <div class="mb-4 border p-3 rounded bg-light">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="from_date" class="form-label"><?php echo e(__('From Date')); ?></label>
                                    <input type="date" class="form-control form-control-sm" id="from_date" value="<?php echo e(request('from_date')); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="to_date" class="form-label"><?php echo e(__('To Date')); ?></label>
                                    <input type="date" class="form-control form-control-sm" id="to_date" value="<?php echo e(request('to_date')); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="company_id" class="form-label"><?php echo e(__('Company')); ?></label>
                                    <select class="form-control form-control-sm select2" id="company_id">
                                        <option value=""><?php echo e(__('All Companies')); ?></option>
                                        <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php echo e(request('company_id') == $id ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status" class="form-label"><?php echo e(__('Status')); ?></label>
                                    <select class="form-control form-control-sm select2" id="status">
                                        <option value=""><?php echo e(__('All Status')); ?></option>
                                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>><?php echo e(__('Pending')); ?></option>
                                        <option value="assigned" <?php echo e(request('status') == 'assigned' ? 'selected' : ''); ?>><?php echo e(__('Assigned')); ?></option>
                                        <option value="quoted" <?php echo e(request('status') == 'quoted' ? 'selected' : ''); ?>><?php echo e(__('Quoted')); ?></option>
                                        <option value="purchased" <?php echo e(request('status') == 'purchased' ? 'selected' : ''); ?>><?php echo e(__('Purchased')); ?></option>
                                        <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>><?php echo e(__('Cancelled')); ?></option>
                                        <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>><?php echo e(__('Completed')); ?></option>
                                        <option value="ignored" <?php echo e(request('status') == 'ignored' ? 'selected' : ''); ?>><?php echo e(__('Ignored')); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="salesman_id" class="form-label"><?php echo e(__('Sales Engineer')); ?></label>
                                    <select class="form-control form-control-sm select2" id="salesman_id">
                                        <option value=""><?php echo e(__('All Sales Engineers')); ?></option>
                                        <?php $__currentLoopData = $salesmen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php echo e(request('salesman_id') == $id ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="search" class="form-label"><?php echo e(__('Search')); ?></label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" id="search" placeholder="<?php echo e(__('Search by enquiry no, company, etc...')); ?>" value="<?php echo e(request('search')); ?>">
                                        <button class="btn btn-outline-primary" type="button" id="search-btn">
                                            <i class="ti ti-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="per_page" class="form-label"><?php echo e(__('Show')); ?></label>
                                    <select class="form-control form-control-sm" id="per_page">
                                        <option value="10" <?php echo e(request('per_page', 10) == 10 ? 'selected' : ''); ?>>10</option>
                                        <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25</option>
                                        <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50</option>
                                        <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-sm btn-light me-2" id="reset-btn">
                                        <i class="ti ti-refresh me-1"></i> <?php echo e(__('Reset')); ?>

                                    </button>
                                    <button class="btn btn-sm btn-primary" id="apply-filters">
                                        <i class="ti ti-filter me-1"></i> <?php echo e(__('Apply Filters')); ?>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Enquiry Table Container -->
                    <div class="table-responsive" id="enquiry-table-container">
                        <?php echo $__env->make('enquiry.partials.table', ['enquiries' => $enquiries], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet" />
<style>
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .table td {
        font-size: 0.85rem;
        vertical-align: middle;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    
    .select2-container--bootstrap-5 .select2-selection {
        height: calc(1.5em + 0.5rem + 2px) !important;
        font-size: 0.85rem !important;
    }
    
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        line-height: 1.5 !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        if (typeof $.fn.select2 !== 'undefined') {
            $('.select2').select2({
                width: '100%',
                theme: 'bootstrap-5'
            });
        }

        // Function to get filter parameters
        function getFilterParams() {
            return {
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val(),
                company_id: $('#company_id').val(),
                status: $('#status').val(),
                salesman_id: $('#salesman_id').val(),
                search: $('#search').val(),
                per_page: $('#per_page').val()
            };
        }

        // Function to load table via AJAX
        function loadTable() {
            const params = getFilterParams();
            const url = "<?php echo e(route('enquiry.index')); ?>";
            
            // Show loading overlay
            $('#enquiry-table-container').addClass('position-relative');
            $('#enquiry-table-container').append('<div class="loading-overlay"><div class="spinner-border text-primary"></div></div>');
            
            $.ajax({
                url: url,
                type: 'GET',
                data: params,
                success: function(response) {
                    $('#enquiry-table-container').html(response);
                    initializeTableEvents();
                    updateURL(params);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading table:', error);
                    alert('Error loading data. Please try again.');
                },
                complete: function() {
                    $('#enquiry-table-container .loading-overlay').remove();
                }
            });
        }

        // Function to update URL without reloading page
        function updateURL(params) {
            // Remove empty parameters
            const cleanParams = {};
            Object.keys(params).forEach(key => {
                if (params[key] && params[key].toString().trim() !== '') {
                    cleanParams[key] = params[key];
                }
            });
            
            // Build query string
            const queryString = Object.keys(cleanParams)
                .map(key => encodeURIComponent(key) + '=' + encodeURIComponent(cleanParams[key]))
                .join('&');
            
            // Build new URL
            const newUrl = window.location.origin + window.location.pathname + (queryString ? '?' + queryString : '');
            
            // Update browser URL without reloading
            window.history.pushState(cleanParams, '', newUrl);
        }

        // Function to initialize table events
        function initializeTableEvents() {
            // Initialize tooltips
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            // Pagination links - use event delegation
            $(document).off('click', '.pagination a').on('click', '.pagination a', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                
                $('#enquiry-table-container').addClass('position-relative');
                $('#enquiry-table-container').append('<div class="loading-overlay"><div class="spinner-border text-primary"></div></div>');
                
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#enquiry-table-container').html(response);
                        initializeTableEvents();
                        
                        // Extract params from URL and update filters
                        const urlObj = new URL(url);
                        const urlParams = urlObj.searchParams;
                        
                        if (urlParams.has('from_date')) $('#from_date').val(urlParams.get('from_date'));
                        if (urlParams.has('to_date')) $('#to_date').val(urlParams.get('to_date'));
                        if (urlParams.has('company_id')) $('#company_id').val(urlParams.get('company_id')).trigger('change');
                        if (urlParams.has('status')) $('#status').val(urlParams.get('status')).trigger('change');
                        if (urlParams.has('salesman_id')) $('#salesman_id').val(urlParams.get('salesman_id')).trigger('change');
                        if (urlParams.has('search')) $('#search').val(urlParams.get('search'));
                        if (urlParams.has('per_page')) $('#per_page').val(urlParams.get('per_page'));
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading page:', error);
                        alert('Error loading page. Please try again.');
                    },
                    complete: function() {
                        $('#enquiry-table-container .loading-overlay').remove();
                    }
                });
            });
        }

        // Filter event handlers
        $('#apply-filters').click(function() {
            loadTable();
        });

        $('#search-btn').click(function() {
            loadTable();
        });

        $('#search').on('keyup', function(e) {
            if (e.key === 'Enter') {
                loadTable();
            }
        });

        $('#reset-btn').click(function() {
            // Clear all filters
            $('#from_date').val('');
            $('#to_date').val('');
            $('#company_id').val('').trigger('change');
            $('#status').val('').trigger('change');
            $('#salesman_id').val('').trigger('change');
            $('#search').val('');
            $('#per_page').val('10');
            
            // Update URL
            window.history.pushState({}, '', "<?php echo e(route('enquiry.index')); ?>");
            
            loadTable();
        });

        // Auto apply filters on select change
        $('#per_page').change(function() {
            loadTable();
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function(event) {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('from_date')) $('#from_date').val(urlParams.get('from_date'));
            if (urlParams.has('to_date')) $('#to_date').val(urlParams.get('to_date'));
            if (urlParams.has('company_id')) $('#company_id').val(urlParams.get('company_id')).trigger('change');
            if (urlParams.has('status')) $('#status').val(urlParams.get('status')).trigger('change');
            if (urlParams.has('salesman_id')) $('#salesman_id').val(urlParams.get('salesman_id')).trigger('change');
            if (urlParams.has('search')) $('#search').val(urlParams.get('search'));
            if (urlParams.has('per_page')) $('#per_page').val(urlParams.get('per_page'));
            
            loadTable();
        });

        // Initialize table events on page load
        initializeTableEvents();
        
        // Export functions
        window.exportCSV = function() {
            const params = getFilterParams();
            const csvUrl = "<?php echo e(route('enquiry.export.csv')); ?>?" + $.param(params);
            window.location.href = csvUrl;
        };
        
        window.printReport = function() {
            const params = getFilterParams();
            const printUrl = "<?php echo e(route('enquiry.print')); ?>?" + $.param(params);
            window.open(printUrl, '_blank');
        };
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\WORK GPT\Github repo\savantec-erp\resources\views/enquiry/index.blade.php ENDPATH**/ ?>