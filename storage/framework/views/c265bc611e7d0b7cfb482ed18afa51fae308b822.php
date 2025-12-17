

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit User')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('users.index')); ?>"><?php echo e(__('User')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Edit')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?php echo e(__('Edit User')); ?></h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('users.update', $user->id)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name" class="form-label"><?php echo e(__('First Name')); ?> <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo e(old('first_name', $user->first_name)); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="form-label"><?php echo e(__('Last Name')); ?> <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo e(old('last_name', $user->last_name)); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile" class="form-label"><?php echo e(__('Mobile')); ?></label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo e(old('mobile', $user->mobile)); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label"><?php echo e(__('Email')); ?> <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role" class="form-label"><?php echo e(__('Role')); ?> <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="role" name="role" required>
                                        <option value=""><?php echo e(__('Select Role')); ?></option>
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php echo e((old('role', $userRole) == $id) ? 'selected' : ''); ?>><?php echo e($role); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <?php if(\Auth::user()->type == 'super admin'): ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="companies" class="form-label"><?php echo e(__('Companies')); ?> <span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="companies" name="companies[]" multiple="multiple" required>
                                            <?php if(isset($companies)): ?>
                                                <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($id); ?>" <?php echo e(in_array($id, $userCompanies) ? 'selected' : ''); ?>><?php echo e($company); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-label"><?php echo e(__('Password')); ?></label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <small class="form-text text-muted"><?php echo e(__('Leave blank to keep current password')); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label"><?php echo e(__('Confirm Password')); ?></label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <!-- Profile Picture Section -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label"><?php echo e(__('Profile Picture')); ?></label>
                                    
                                    <!-- Current Profile Picture -->
                                    <?php if(!empty($avatarUrl)): ?>
                                        <div class="mb-3">
                                            <label class="form-label"><?php echo e(__('Current Profile Picture')); ?></label>
                                            <div>
                                                <img src="<?php echo e($avatarUrl); ?>" alt="Profile Picture" class="img-thumbnail" style="max-width: 150px; max-height: 150px;"
                                                     onerror="this.onerror=null; this.src='<?php echo e(asset('storage/uploads/avatar/avatar.png')); ?>';">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="profile_picture" name="profile_picture" accept="image/*">
                                        <label class="custom-file-label" for="profile_picture" id="file-label">
                                            <?php echo e(!empty($user->avatar) ? __('Change file') : __('Choose file')); ?>

                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        <?php echo e(__('Max Width/Height: 500px * 500px & Size: 500kb')); ?>

                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Fields -->
                        <?php if(!$customFields->isEmpty()): ?>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5><?php echo e(__('Additional Information')); ?></h5>
                                </div>
                                <?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customField[<?php echo e($field->id); ?>]" class="form-label"><?php echo e($field->name); ?></label>
                                            <?php
                                                $value = isset($user->customField[$field->id]) ? $user->customField[$field->id] : '';
                                            ?>
                                            <?php if($field->type == 'text'): ?>
                                                <input type="text" class="form-control" id="customField[<?php echo e($field->id); ?>]" name="customField[<?php echo e($field->id); ?>]" value="<?php echo e(old('customField['.$field->id.']', $value)); ?>">
                                            <?php elseif($field->type == 'number'): ?>
                                                <input type="number" class="form-control" id="customField[<?php echo e($field->id); ?>]" name="customField[<?php echo e($field->id); ?>]" value="<?php echo e(old('customField['.$field->id.']', $value)); ?>">
                                            <?php elseif($field->type == 'date'): ?>
                                                <input type="date" class="form-control" id="customField[<?php echo e($field->id); ?>]" name="customField[<?php echo e($field->id); ?>]" value="<?php echo e(old('customField['.$field->id.']', $value)); ?>">
                                            <?php elseif($field->type == 'textarea'): ?>
                                                <textarea class="form-control" id="customField[<?php echo e($field->id); ?>]" name="customField[<?php echo e($field->id); ?>]"><?php echo e(old('customField['.$field->id.']', $value)); ?></textarea>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group text-end mt-4">
                            <button type="submit" class="btn btn-primary"><?php echo e(__('Update')); ?></button>
                            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary"><?php echo e(__('Close')); ?></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<!-- Select2 CSS -->
<link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 38px;
        border: 1px solid #ced4da;
    }
    .select2-container .select2-selection--multiple {
        min-height: 38px;
        border: 1px solid #ced4da;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
        color: #495057;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }
    
    /* Search box styling */
    .select2-search--dropdown {
        display: block !important;
        padding: 8px;
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    
    .select2-search--dropdown .select2-search__field {
        width: 100% !important;
        padding: 8px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .select2-search--dropdown .select2-search__field:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    /* Ensure dropdown has enough width */
    .select2-container .select2-dropdown {
        min-width: 300px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    /* Dropdown options styling */
    .select2-results__option {
        padding: 8px 12px;
    }
    
    .select2-results__option--highlighted {
        background-color: #007bff !important;
        color: white !important;
    }

    /* Current profile picture styling */
    .img-thumbnail {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        padding: 0.25rem;
    }

    /* Custom file input styling */
    .custom-file {
        position: relative;
        display: inline-block;
        width: 100%;
        height: calc(2.25rem + 2px);
        margin-bottom: 0;
    }

    .custom-file-input {
        position: relative;
        z-index: 2;
        width: 100%;
        height: calc(2.25rem + 2px);
        margin: 0;
        opacity: 0;
    }

    .custom-file-label {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1;
        height: calc(2.25rem + 2px);
        padding: 0.375rem 0.75rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .custom-file-label::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        display: block;
        height: calc(calc(2.25rem + 2px) - 1px * 2);
        padding: 0.375rem 0.75rem;
        line-height: 1.5;
        color: #495057;
        content: "Browse";
        background-color: #e9ecef;
        border-left: inherit;
        border-radius: 0 0.25rem 0.25rem 0;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- jQuery -->
<script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<!-- Select2 JS -->
<script src="<?php echo e(asset('js/select2.min.js')); ?>"></script>

<script>
    $(document).ready(function() {
        // File input label update
        $('#profile_picture').on('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : '<?php echo e(!empty($user->avatar) ? __("Change file") : __("Choose file")); ?>';
            $('#file-label').text(fileName);
        });

        // Initialize Role dropdown with search
        $('#role').select2({
            width: '100%',
            placeholder: "Select Role",
            allowClear: true,
            dropdownParent: $('#role').closest('.form-group'),
            minimumResultsForSearch: 0, // Always show search
            language: {
                noResults: function() {
                    return "No results found";
                },
                searching: function() {
                    return "Searching...";
                }
            }
        });

        // Initialize Companies dropdown with search
        $('#companies').select2({
            width: '100%',
            placeholder: "Select Companies",
            allowClear: true,
            closeOnSelect: false,
            dropdownParent: $('#companies').closest('.form-group'),
            minimumResultsForSearch: 0, // Always show search
            language: {
                noResults: function() {
                    return "No results found";
                },
                searching: function() {
                    return "Searching...";
                }
            }
        });

        // Focus on search field when dropdown opens
        $(document).on('select2:open', function(e) {
            setTimeout(function() {
                const searchField = document.querySelector('.select2-container--open .select2-search__field');
                if (searchField) {
                    searchField.focus();
                    
                    const targetId = e.target.id;
                    if (targetId === 'role') {
                        searchField.placeholder = 'Search roles...';
                    } else if (targetId === 'companies') {
                        searchField.placeholder = 'Search companies...';
                    } else {
                        searchField.placeholder = 'Search...';
                    }
                }
            }, 100);
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\ADMIN\Projects\savantec-project\resources\views/user/edit.blade.php ENDPATH**/ ?>