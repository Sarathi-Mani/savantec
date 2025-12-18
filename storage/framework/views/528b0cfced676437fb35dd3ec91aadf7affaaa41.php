

<?php $__env->startSection('page-title'); ?>
    <?php echo e(('Enquiry List')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(('Enquiry')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('enquiry_add')): ?>
        <a href="<?php echo e(route('enquiry.create')); ?>" data-bs-toggle="tooltip" title="<?php echo e(('Create')); ?>"  class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- <div class="row">
        <div class="col-12"> -->
            <div class="card">
                <div class="card-body">
                    <!-- Top Controls -->
                    <!-- <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <label class="me-2 mb-0">Show</label>
                                <select class="form-select me-2 form-select-sm w-auto" id="per_page">
                                    <option value="10" <?php echo e(request('per_page', 10) == 10 ? 'selected' : ''); ?>>10</option>
                                    <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25</option>
                                    <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50</option>
                                    <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100</option>
                                </select>
                                <label class="ms-2 mb-0">entries</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end">
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="print-btn">
                                    <i class="ti ti-printer"></i> <?php echo e(__('Print')); ?>

                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="csv-btn">
                                    <i class="ti ti-download"></i> <?php echo e(__('CSV')); ?>

                                </button>
                            </div>
                        </div>
                    </div> -->

                    <!-- Filters -->
                    <div class="mb-4 border p-3 rounded">
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
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="search" class="form-label"><?php echo e(__('Search')); ?></label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" id="search" placeholder="<?php echo e(__('Search...')); ?>" value="<?php echo e(request('search')); ?>">
                                        <button class="btn btn-outline-secondary" type="button" id="search-btn">
                                            <i class="ti ti-search"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary" type="button" id="reset-btn">
                                            <i class="ti ti-refresh"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enquiry Table Container -->
                    <div id="enquiry-table-container">
                        <?php echo $__env->make('enquiry.partials.table', ['enquiries' => $enquiries], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        <!-- </div>
    </div> -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet" />
<!-- <style>
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        font-size: 0.85rem;
        white-space: nowrap;
    }
    .table td {
        font-size: 0.85rem;
        vertical-align: middle;
    }
    .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    .toggle-details {
        transition: all 0.2s ease;
        width: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .toggle-details[aria-expanded="true"] .ti-plus {
        transform: rotate(45deg);
        transition: transform 0.2s ease;
    }
    .collapse {
        border-top: 1px solid #dee2e6;
    }
    .collapse .card-body {
        padding: 1rem;
    }
    .form-control-sm, .form-select-sm {
        font-size: 0.85rem;
        padding: 0.25rem 0.5rem;
    }
    .form-label {
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }
    .bg-light {
        background-color: #f8fafc !important;
    }
    .d-flex.align-items-center {
        min-height: 24px;
    }
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
</style> -->
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        // Debug: Check if jQuery is loaded
        console.log('jQuery version:', $.fn.jquery);
        
        // Initialize Select2
        if (typeof $.fn.select2 !== 'undefined') {
            $('.select2').select2({
                width: '100%',
                theme: 'bootstrap-5'
            });
        } else {
            console.error('Select2 is not loaded!');
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
            
            console.log('Loading table with params:', params);
            
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
                    console.error('XHR response:', xhr.responseText);
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
            
            console.log('Updating URL to:', newUrl);
            
            // Update browser URL without reloading
            window.history.pushState(cleanParams, '', newUrl);
        }

        // Function to initialize table events
        function initializeTableEvents() {
            // Toggle icon rotation and change
            $('.toggle-details').on('click', function() {
                const icon = $(this).find('i');
                const isExpanded = $(this).attr('aria-expanded') === 'true';
                
                if (isExpanded) {
                    icon.removeClass('ti-minus').addClass('ti-plus');
                } else {
                    icon.removeClass('ti-plus').addClass('ti-minus');
                }
            });

            // Initialize all tooltips
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            // Pagination links - use event delegation
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                
                console.log('Pagination click:', url);
                
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
                        
                        if (urlParams.has('from_date')) {
                            $('#from_date').val(urlParams.get('from_date'));
                        }
                        if (urlParams.has('to_date')) {
                            $('#to_date').val(urlParams.get('to_date'));
                        }
                        if (urlParams.has('company_id')) {
                            $('#company_id').val(urlParams.get('company_id')).trigger('change');
                        }
                        if (urlParams.has('status')) {
                            $('#status').val(urlParams.get('status')).trigger('change');
                        }
                        if (urlParams.has('salesman_id')) {
                            $('#salesman_id').val(urlParams.get('salesman_id')).trigger('change');
                        }
                        if (urlParams.has('search')) {
                            $('#search').val(urlParams.get('search'));
                        }
                        if (urlParams.has('per_page')) {
                            $('#per_page').val(urlParams.get('per_page'));
                        }
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

        // Function to update filters from URL params
        function updateFiltersFromURL(urlParams) {
            if (urlParams.has('from_date')) {
                $('#from_date').val(urlParams.get('from_date'));
            }
            if (urlParams.has('to_date')) {
                $('#to_date').val(urlParams.get('to_date'));
            }
            if (urlParams.has('company_id')) {
                $('#company_id').val(urlParams.get('company_id')).trigger('change');
            }
            if (urlParams.has('status')) {
                $('#status').val(urlParams.get('status')).trigger('change');
            }
            if (urlParams.has('salesman_id')) {
                $('#salesman_id').val(urlParams.get('salesman_id')).trigger('change');
            }
            if (urlParams.has('search')) {
                $('#search').val(urlParams.get('search'));
            }
            if (urlParams.has('per_page')) {
                $('#per_page').val(urlParams.get('per_page'));
            }
        }

        // Load initial state from URL on page load
        const urlParams = new URLSearchParams(window.location.search);
        updateFiltersFromURL(urlParams);

        // Filter event handlers
        $('#from_date, #to_date').change(function() {
            console.log('Date filter changed');
            loadTable();
        });

        $('#company_id, #status, #salesman_id, #per_page').change(function() {
            console.log('Select filter changed:', $(this).attr('id'), $(this).val());
            loadTable();
        });

        $('#search').on('keyup', function(e) {
            if (e.key === 'Enter') {
                loadTable();
            }
        });

        $('#search-btn').click(function() {
            loadTable();
        });

        $('#reset-btn').click(function() {
            console.log('Reset clicked');
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

        // Print button
        $('#print-btn').click(function() {
            const params = getFilterParams();
            const printUrl = "<?php echo e(route('enquiry.print')); ?>?" + $.param(params);
            console.log('Opening print URL:', printUrl);
            window.open(printUrl, '_blank');
        });

        // CSV export
        $('#csv-btn').click(function() {
            const params = getFilterParams();
            const csvUrl = "<?php echo e(route('enquiry.export.csv')); ?>?" + $.param(params);
            console.log('Downloading CSV from:', csvUrl);
            window.location.href = csvUrl;
        });

        // Handle browser back/forward buttons
        if (window.addEventListener) {
            window.addEventListener('popstate', function(event) {
                console.log('Popstate event:', event);
                const urlParams = new URLSearchParams(window.location.search);
                updateFiltersFromURL(urlParams);
                loadTable();
            });
        }

        // Initialize table events on page load
        initializeTableEvents();
        
        console.log('Enquiry page JavaScript loaded successfully');
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-github\resources\views/enquiry/index.blade.php ENDPATH**/ ?>