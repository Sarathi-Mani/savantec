
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'tableId' => 'defaultTable',
    'searchPlaceholder' => 'Search...',
    'pdfTitle' => 'Report',
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'tableId' => 'defaultTable',
    'searchPlaceholder' => 'Search...',
    'pdfTitle' => 'Report',
]); ?>
<?php foreach (array_filter(([
    'tableId' => 'defaultTable',
    'searchPlaceholder' => 'Search...',
    'pdfTitle' => 'Report',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php $__env->startPush('styles'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Global variable to store DataTable instances
window.dataTables = {};
let isDataTableInitialized = false;

$(document).ready(function() {
    console.log('Initializing DataTables export system...');
    
    // Use the passed tableId prop
    const tableId = '<?php echo e($tableId); ?>';
    console.log('Table ID to initialize:', tableId);
    
    // Check if DataTables is available
    if (typeof $.fn.dataTable === 'undefined') {
        console.error('DataTables not loaded!');
        return;
    }
    
    // Check if jsPDF and html2canvas are available for PDF export
    const pdfAvailable = typeof jsPDF !== 'undefined' && typeof html2canvas !== 'undefined';
    if (!pdfAvailable) {
        console.warn('jsPDF or html2canvas not loaded. PDF export may not work properly.');
    }
    
    // Initialize table only if not already initialized
    const tableElement = $('#' + tableId);
    
    if (!tableElement.length) {
        console.error('Table element not found:', tableId);
        return;
    }
    
    // Check if already initialized
    if ($.fn.DataTable.isDataTable('#' + tableId)) {
        console.log('DataTable already initialized for:', tableId);
        window.dataTables[tableId] = $('#' + tableId).DataTable();
        setupExportButtonHandlers(tableId);
        setupColumnToggles(tableId);
        return;
    }
    
    // Remove any existing DataTable classes that might cause auto-init
    tableElement.removeClass('datatable dataTable');
    
    // Store original HTML structure
    const tableHTML = tableElement.html();
    
    try {
        // Initialize DataTable with proper layout
        const dataTable = tableElement.DataTable({
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: {
                dom: {
                    button: {
                        className: 'btn btn-sm btn-light'
                    }
                },
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="ti ti-copy"></i> Copy',
                        className: 'd-none export-btn-copy',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="ti ti-file-text"></i> CSV',
                        className: 'd-none export-btn-csv',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        },
                        filename: function() {
                            return '<?php echo e($pdfTitle); ?>_Export_' + new Date().toISOString().slice(0, 10);
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="ti ti-file-excel"></i> Excel',
                        className: 'd-none export-btn-excel',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        },
                        filename: function() {
                            return '<?php echo e($pdfTitle); ?>_Export_' + new Date().toISOString().slice(0, 10);
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="ti ti-file-pdf"></i> PDF',
                        className: 'd-none export-btn-pdf',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        },
                        orientation: 'portrait',
                        pageSize: 'A4',
                        customize: function(doc) {
                            // PDF customization
                            doc.defaultStyle.fontSize = 9;
                            doc.styles.tableHeader.fontSize = 10;
                            doc.styles.title.fontSize = 12;
                        },
                        filename: function() {
                            return '<?php echo e($pdfTitle); ?>_Export_' + new Date().toISOString().slice(0, 10);
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="ti ti-printer"></i> Print',
                        className: 'd-none export-btn-print',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        },
                        customize: function(win) {
                            $(win.document.body).find('table').addClass('display').css('font-size', '11px');
                            $(win.document.body).find('h1').css('text-align','center').css('font-size', '16px').css('color', '#4f46e5');
                            $(win.document.body).find('h1').text('<?php echo e($pdfTitle); ?> Report - ' + new Date().toLocaleDateString());
                            $(win.document.body).find('th:last-child, td:last-child').remove();
                        }
                    }
                ]
            },
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            language: {
                search: "Search:",
                searchPlaceholder: "<?php echo e($searchPlaceholder); ?>",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _MAX_ total entries)",
                zeroRecords: "No matching records found",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: '<i class="ti ti-chevron-right"></i>',
                    previous: '<i class="ti ti-chevron-left"></i>'
                }
            },
            responsive: true,
            autoWidth: false,
            processing: false,
            serverSide: false,
            deferRender: true,
            initComplete: function(settings, json) {
                console.log('DataTable successfully initialized for:', tableId);
                
                // Store instance globally
                window.dataTables[tableId] = this.api();
                isDataTableInitialized = true;
                
                // Hide the default button container if exists
                try {
                    const buttonContainer = this.api().buttons().container();
                    if (buttonContainer.length) {
                        buttonContainer.addClass('d-none');
                        console.log('Button container hidden');
                    }
                } catch (e) {
                    console.log('Button container not available:', e.message);
                }
                
                // Setup event handlers
                setupExportButtonHandlers(tableId);
                setupColumnToggles(tableId);
                
                // Re-apply Bootstrap tooltips
                setTimeout(function() {
                    initTooltips();
                }, 100);
            },
            drawCallback: function(settings) {
                // Re-init tooltips after table redraw
                initTooltips();
                
                // Update column toggle checkboxes based on current visibility
                if (window.dataTables[tableId]) {
                    const api = window.dataTables[tableId];
                    $('.column-checkbox[data-table-id="' + tableId + '"]').each(function() {
                        const colIndex = parseInt($(this).data('column'));
                        try {
                            const isVisible = api.column(colIndex).visible();
                            $(this).prop('checked', isVisible);
                        } catch (e) {
                            console.log('Could not check column visibility:', e.message);
                        }
                    });
                }
            },
            error: function(xhr, error, thrown) {
                console.error('DataTables error:', error, thrown);
            }
        });
        
        console.log('DataTable instance created for:', tableId);
        
    } catch (error) {
        console.error('Error initializing DataTable:', error);
        
        // Restore original HTML if initialization fails
        tableElement.html(tableHTML);
        
        // Fallback: Simple table styling
        tableElement.addClass('table table-striped table-bordered');
    }
    
    // Setup delete confirmations
    setupDeleteConfirmations();
    
    // Initialize tooltips
    initTooltips();
});

// Setup export button handlers (updated to include PDF)
function setupExportButtonHandlers(tableId) {
    console.log('Setting up export handlers for:', tableId);
    
    // Remove any existing click handlers first
    $(`[data-table-id="${tableId}"][data-export]`).off('click');
    
    // Define button handlers
    const buttonHandlers = {
        'copy': { index: 0, className: '.export-btn-copy' },
        'csv': { index: 1, className: '.export-btn-csv' },
        'excel': { index: 2, className: '.export-btn-excel' },
        'pdf': { index: 3, className: '.export-btn-pdf' },
        'print': { index: 4, className: '.export-btn-print' }
    };
    
    // Setup each export button
    $.each(buttonHandlers, function(type, config) {
        $(`[data-table-id="${tableId}"][data-export="${type}"]`).on('click', function(e) {
            e.preventDefault();
            console.log(`${type} button clicked for:`, tableId);
            
            // Get PDF settings if applicable
            const pdfOrientation = $(this).data('orientation') || 'portrait';
            const pdfPageSize = $(this).data('page-size') || 'A4';
            
            const dataTable = window.dataTables[tableId];
            if (!dataTable) {
                console.error('DataTable instance not found');
                fallbackExport(tableId, type, pdfOrientation, pdfPageSize);
                return;
            }
            
            try {
                // For PDF, update orientation and page size
                if (type === 'pdf' && dataTable.button && dataTable.button('.export-btn-pdf').length) {
                    const pdfButton = dataTable.button('.export-btn-pdf');
                    if (pdfButton[0] && pdfButton[0].action) {
                        // Update PDF settings
                        const originalAction = pdfButton[0].action;
                        pdfButton[0].action = function(e, dt, node, config) {
                            config.orientation = pdfOrientation;
                            config.pageSize = pdfPageSize;
                            return originalAction(e, dt, node, config);
                        };
                    }
                }
                
                // Try to trigger button via API
                if (dataTable.button && typeof dataTable.button === 'function') {
                    dataTable.button(config.className).trigger();
                    console.log(`${type} triggered successfully via API`);
                    return;
                }
                
                // Try to trigger by index
                if (dataTable.buttons && typeof dataTable.buttons === 'function') {
                    const button = dataTable.button(config.index);
                    if (button && typeof button.trigger === 'function') {
                        button.trigger();
                        console.log(`${type} triggered by index`);
                        return;
                    }
                }
                
                // Fallback
                console.log(`Using fallback for ${type}`);
                fallbackExport(tableId, type, pdfOrientation, pdfPageSize);
                
            } catch (error) {
                console.error(`Error triggering ${type}:`, error);
                fallbackExport(tableId, type, pdfOrientation, pdfPageSize);
            }
        });
    });
}

// Fallback export functions (updated to include PDF)
function fallbackExport(tableId, type, pdfOrientation = 'portrait', pdfPageSize = 'A4') {
    console.log(`Using custom fallback export for: ${type}`);
    
    const tableElement = document.getElementById(tableId);
    if (!tableElement) {
        console.error('Table element not found:', tableId);
        return;
    }
    
    switch(type) {
        case 'copy':
            exportToClipboard(tableElement);
            break;
        case 'csv':
        case 'excel':
            exportToCSV(tableElement, type);
            break;
        case 'pdf':
            exportToPDF(tableElement, pdfOrientation, pdfPageSize);
            break;
        case 'print':
            printTable(tableElement);
            break;
    }
}

function exportToClipboard(tableElement) {
    try {
        // Create a temporary textarea
        const textarea = document.createElement('textarea');
        textarea.value = tableToText(tableElement);
        document.body.appendChild(textarea);
        textarea.select();
        
        const success = document.execCommand('copy');
        document.body.removeChild(textarea);
        
        if (success) {
            showAlert('Table copied to clipboard!', 'success');
        } else {
            showAlert('Failed to copy to clipboard. Please try again.', 'danger');
        }
    } catch (error) {
        console.error('Copy failed:', error);
        showAlert('Copy failed. Please select and copy manually.', 'danger');
    }
}

function tableToText(tableElement) {
    let text = '';
    const rows = tableElement.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('th, td:not(:last-child)');
        const rowText = Array.from(cells).map(cell => cell.textContent.trim()).join('\t');
        text += rowText + '\n';
    });
    
    return text;
}

function exportToCSV(tableElement, type) {
    let csv = [];
    const rows = tableElement.querySelectorAll('tr');
    
    // Get headers (excluding actions column)
    const headers = [];
    $(tableElement).find('thead th:not(:last-child)').each(function() {
        headers.push('"' + $(this).text().trim().replace(/"/g, '""') + '"');
    });
    csv.push(headers.join(','));
    
    // Get rows (excluding actions column)
    $(tableElement).find('tbody tr').each(function() {
        const row = [];
        $(this).find('td:not(:last-child)').each(function() {
            const text = $(this).text().trim();
            row.push('"' + text.replace(/"/g, '""') + '"');
        });
        csv.push(row.join(','));
    });
    
    const csvContent = csv.join('\n');
    const filename = `company_export_${new Date().toISOString().slice(0, 10)}.${type === 'excel' ? 'xls' : 'csv'}`;
    
    downloadFile(csvContent, filename, type === 'excel' ? 'application/vnd.ms-excel' : 'text/csv');
}

// PDF Export function using jsPDF and html2canvas
function exportToPDF(tableElement, orientation = 'portrait', pageSize = 'A4') {
    // Check if jsPDF and html2canvas are available
    if (typeof jsPDF === 'undefined' || typeof html2canvas === 'undefined') {
        showAlert('PDF export requires jsPDF and html2canvas libraries. Please include them.', 'danger');
        console.error('jsPDF or html2canvas not loaded');
        
        // Fallback: Open print dialog
        console.log('Falling back to print for PDF');
        printTable(tableElement);
        return;
    }
    
    showAlert('Generating PDF... Please wait.', 'info');
    
    // Clone the table for PDF generation (excluding actions column)
    const tableClone = tableElement.cloneNode(true);
    $(tableClone).find('th:last-child, td:last-child').remove();
    
    // Add custom styles for PDF
    $(tableClone).addClass('pdf-export');
    $(tableClone).find('thead th').css({
        'background-color': '#f8f9fa',
        'font-weight': 'bold',
        'border': '1px solid #ddd',
        'padding': '8px'
    });
    
    $(tableClone).find('td').css({
        'border': '1px solid #ddd',
        'padding': '6px'
    });
    
    // Create container for PDF
    const pdfContainer = document.createElement('div');
    pdfContainer.style.position = 'absolute';
    pdfContainer.style.left = '-9999px';
    pdfContainer.style.top = '0';
    pdfContainer.style.width = pageSize === 'A4' ? '210mm' : '297mm';
    pdfContainer.style.padding = '20px';
    pdfContainer.style.backgroundColor = 'white';
    
    // Add title
    const title = document.createElement('h2');
    title.textContent = 'Companies Report';
    title.style.textAlign = 'center';
    title.style.color = '#4f46e5';
    title.style.marginBottom = '20px';
    title.style.fontSize = '18px';
    
    // Add date
    const date = document.createElement('p');
    date.textContent = 'Generated on: ' + new Date().toLocaleDateString();
    date.style.textAlign = 'center';
    date.style.color = '#666';
    date.style.marginBottom = '20px';
    date.style.fontSize = '12px';
    
    pdfContainer.appendChild(title);
    pdfContainer.appendChild(date);
    pdfContainer.appendChild(tableClone);
    
    document.body.appendChild(pdfContainer);
    
    // Generate PDF
    html2canvas(pdfContainer, {
        scale: 2, // Higher quality
        useCORS: true,
        logging: false
    }).then(canvas => {
        // Remove temporary container
        document.body.removeChild(pdfContainer);
        
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF({
            orientation: orientation,
            unit: 'mm',
            format: pageSize.toLowerCase()
        });
        
        const imgWidth = pdf.internal.pageSize.getWidth();
        const imgHeight = (canvas.height * imgWidth) / canvas.width;
        
        pdf.setFillColor(248, 249, 250);
        pdf.rect(0, 0, imgWidth, 20, 'F');
        
        // Add header
        pdf.setFontSize(16);
        pdf.setTextColor(79, 70, 229);
        pdf.text('Companies Report', imgWidth / 2, 10, { align: 'center' });
        
        pdf.setFontSize(10);
        pdf.setTextColor(102, 102, 102);
        pdf.text('Generated on: ' + new Date().toLocaleDateString(), imgWidth / 2, 16, { align: 'center' });
        
        // Add the table image
        pdf.addImage(imgData, 'PNG', 10, 25, imgWidth - 20, imgHeight - 10);
        
        // Add footer
        const totalPages = pdf.internal.getNumberOfPages();
        for (let i = 1; i <= totalPages; i++) {
            pdf.setPage(i);
            pdf.setFontSize(8);
            pdf.setTextColor(128, 128, 128);
            pdf.text(`Page ${i} of ${totalPages}`, imgWidth - 20, pdf.internal.pageSize.getHeight() - 10);
        }
        
        // Save the PDF
        pdf.save(`company_export_${new Date().toISOString().slice(0, 10)}.pdf`);
        
        showAlert('PDF exported successfully!', 'success');
    }).catch(error => {
        console.error('PDF generation error:', error);
        showAlert('Error generating PDF. Please try again.', 'danger');
        
        // Fallback to print
        printTable(tableElement);
    });
}

function printTable(tableElement) {
    const printWindow = window.open('', '_blank');
    const tableClone = tableElement.cloneNode(true);
    
    // Remove actions column
    $(tableClone).find('th:last-child, td:last-child').remove();
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
            <head>
                <title>Companies Report</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    h1 { text-align: center; color: #4f46e5; margin-bottom: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; font-weight: bold; }
                    .text-center { text-align: center; }
                    @media print {
                        body { margin: 0; }
                        table { font-size: 11px; }
                        @page { margin: 0.5cm; }
                    }
                </style>
            </head>
            <body>
                <h1>Companies Report - ${new Date().toLocaleDateString()}</h1>
                ${tableClone.outerHTML}
                <script>
                    window.onload = function() {
                        window.print();
                        setTimeout(function() {
                            window.close();
                        }, 500);
                    };
                <\/script>
            </body>
        </html>
    `);
    printWindow.document.close();
}

function downloadFile(content, filename, contentType) {
    const blob = new Blob([content], { type: contentType });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.style.display = 'none';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

// Setup column toggles
function setupColumnToggles(tableId) {
    const dataTable = window.dataTables[tableId];
    if (!dataTable) return;
    
    // Remove existing handlers
    $(`.column-checkbox[data-table-id="${tableId}"]`).off('change');
    $(`.column-toggle-item[data-table-id="${tableId}"]`).off('click');
    
    // Handle checkbox changes
    $(`.column-checkbox[data-table-id="${tableId}"]`).on('change', function() {
        const columnIndex = parseInt($(this).data('column'));
        const isVisible = $(this).is(':checked');
        
        console.log(`Toggling column ${columnIndex} to ${isVisible ? 'visible' : 'hidden'}`);
        
        try {
            dataTable.column(columnIndex).visible(isVisible);
            
            // Update DataTables layout
            dataTable.columns.adjust().draw();
            
            // Show feedback
            const columnName = $(this).closest('.column-toggle-item').find('.form-check-label').text().trim().split('\n')[0];
            showAlert(`Column "${columnName}" ${isVisible ? 'shown' : 'hidden'}`, 'info', 1500);
        } catch (error) {
            console.error('Error toggling column:', error);
            showAlert('Error toggling column. Please try again.', 'danger');
        }
    });
    
    // Handle dropdown item clicks
    $(`.column-toggle-item[data-table-id="${tableId}"]`).on('click', function(e) {
        if ($(e.target).is('input, .form-check-input, label')) {
            return;
        }
        e.stopPropagation();
        const checkbox = $(this).find('.column-checkbox');
        if (checkbox.length) {
            const isChecked = !checkbox.prop('checked');
            checkbox.prop('checked', isChecked);
            checkbox.trigger('change');
        }
    });
}

// Setup delete confirmations
function setupDeleteConfirmations() {
    $(document).off('click', '.bs-pass-para').on('click', '.bs-pass-para', function(e) {
        e.preventDefault();
        const formId = $(this).data('confirm-yes');
        const confirmText = $(this).data('text');
        const confirmMessage = $(this).data('confirm');
        
        if (confirm(confirmMessage + '\n\n' + confirmText)) {
            $('#' + formId).submit();
        }
    });
}

// Initialize tooltips
function initTooltips() {
    // Remove existing tooltips first
    $('[data-bs-toggle="tooltip"]').tooltip('dispose');
    
    // Initialize new tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            trigger: 'hover',
            placement: 'top'
        });
    });
}

// Show temporary alert
function showAlert(message, type = 'info', duration = 3000) {
    const alertId = 'temp-alert-' + Date.now();
    const alertHtml = `
        <div id="${alertId}" class="alert alert-${type} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 1050; min-width: 250px;">
            <i class="ti ti-${type === 'success' ? 'check-circle' : type === 'danger' ? 'alert-circle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('body').append(alertHtml);
    
    // Auto remove after duration
    setTimeout(() => {
        $(`#${alertId}`).alert('close');
    }, duration);
}

// Handle window resize
$(window).on('resize', function() {
    if (window.dataTables['companyTable']) {
        try {
            window.dataTables['companyTable'].columns.adjust().responsive.recalc();
        } catch (e) {
            console.log('Resize adjustment error:', e.message);
        }
    }
});

</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-project\resources\views/components/export-scripts.blade.php ENDPATH**/ ?>