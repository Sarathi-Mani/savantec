@extends('layouts.admin')
@section('page-title')
    {{__('Edit Role')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('roles.index')}}">{{__('Role')}}</a></li>
    <li class="breadcrumb-item">{{__('Edit')}}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT'))}}
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                {{Form::label('name',__('Role Name'),['class'=>'form-label'])}}
                                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Role Name'),'required'=>'required'))}}
                                @error('name')
                                <small class="invalid-name" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>

                            <div class="form-group">
                                {{Form::label('description',__('Description'),['class'=>'form-label'])}}
                                {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description (Optional)'),'rows'=>'2'))}}
                                <small class="text-muted">{{__('Optional')}}</small>
                            </div>

                            @error('permissions')
                            <div class="alert alert-danger">
                                <strong class="text-danger">{{ $message }}</strong>
                            </div>
                            @enderror

                            <div class="col-md-12">
                                <div class="form-group">
                                    @if(!empty($permissions))
                                        <h6 class="my-3">{{__('Assign Permissions to Role')}}</h6>
                                        
                                        <!-- Category Buttons -->
                                        <div class="d-flex flex-wrap gap-2 mb-4">
                                            <button type="button" class="btn btn-outline-primary category-btn active" data-category="all">
                                                {{__('All')}}
                                            </button>
                                            <button type="button" class="btn btn-outline-primary category-btn" data-category="inventory">
                                                {{__('Inventory')}}
                                            </button>
                                            <button type="button" class="btn btn-outline-primary category-btn" data-category="sales">
                                                {{__('Sales')}}
                                            </button>
                                            <button type="button" class="btn btn-outline-primary category-btn" data-category="purchase">
                                                {{__('Purchase')}}
                                            </button>
                                            <button type="button" class="btn btn-outline-primary category-btn" data-category="reports">
                                                {{__('Reports')}}
                                            </button>
                                            <button type="button" class="btn btn-outline-primary category-btn" data-category="accounts">
                                                {{__('Accounts')}}
                                            </button>
                                            <button type="button" class="btn btn-outline-primary category-btn" data-category="others">
                                                {{__('Others')}}
                                            </button>
                                        </div>

                                        <!-- Select All Checkbox -->
                                        <div class="d-flex justify-content-end mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkAll">
                                                <label class="form-check-label fw-bold" for="checkAll">{{__('Select All Permissions')}}</label>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0" id="dataTable-1">
                                                <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="25%">
                                                        <div class="form-check">
                                                            {{__('Modules')}}
                                                        </div>
                                                    </th>
                                                    <th width="70%">{{__('Specific Permissions')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @php
                                                    $rolePermissions = $role->permissions->pluck('name')->toArray();
                                                @endphp

                                                <!-- Category: INVENTORY -->
                                                <!-- Module 3: Tax -->
                                                <tr class="permission-row" data-categories="inventory,others">
                                                    <td>1</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input module-checkbox" id="module_tax">
                                                            <label class="form-check-label" for="module_tax"><strong>{{__('Tax')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-tax" name="permissions[]" value="tax_view" id="permission_tax_view" {{ in_array('tax_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_tax_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-tax" name="permissions[]" value="tax_add" id="permission_tax_add" {{ in_array('tax_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_tax_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-tax" name="permissions[]" value="tax_edit" id="permission_tax_edit" {{ in_array('tax_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_tax_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-tax" name="permissions[]" value="tax_delete" id="permission_tax_delete" {{ in_array('tax_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_tax_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_units"><strong>{{__('Units')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-units" name="permissions[]" value="unit_view" id="permission_unit_view" {{ in_array('unit_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_unit_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-units" name="permissions[]" value="unit_add" id="permission_unit_add" {{ in_array('unit_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_unit_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-units" name="permissions[]" value="unit_edit" id="permission_unit_edit" {{ in_array('unit_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_unit_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-units" name="permissions[]" value="unit_delete" id="permission_unit_delete" {{ in_array('unit_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_unit_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_items"><strong>{{__('Items')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_view" id="permission_item_view" {{ in_array('item_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_item_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_add" id="permission_item_add" {{ in_array('item_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_item_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_edit" id="permission_item_edit" {{ in_array('item_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_item_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_delete" id="permission_item_delete" {{ in_array('item_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_item_delete">{{__('Delete')}}</label>
                                                            </div>
                                                            <!-- Category Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_category_view" id="permission_item_category_view" {{ in_array('item_category_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_item_category_view">{{__('Category View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_category_add" id="permission_item_category_add" {{ in_array('item_category_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_item_category_add">{{__('Category Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_category_edit" id="permission_item_category_edit" {{ in_array('item_category_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_item_category_edit">{{__('Category Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="item_category_delete" id="permission_item_category_delete" {{ in_array('item_category_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_item_category_delete">{{__('Category Delete')}}</label>
                                                            </div>
                                                            <!-- Special Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="print_labels" id="permission_print_labels" {{ in_array('print_labels', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_print_labels">{{__('Print Labels')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-items" name="permissions[]" value="import_items" id="permission_import_items" {{ in_array('import_items', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_import_items">{{__('Import Items')}}</label>
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
                                                            <label class="form-check-label" for="module_stock_transfer"><strong>{{__('Stock Transfer')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-transfer" name="permissions[]" value="stock_transfer_view" id="permission_stock_transfer_view" {{ in_array('stock_transfer_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_stock_transfer_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-transfer" name="permissions[]" value="stock_transfer_add" id="permission_stock_transfer_add" {{ in_array('stock_transfer_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_stock_transfer_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-transfer" name="permissions[]" value="stock_transfer_edit" id="permission_stock_transfer_edit" {{ in_array('stock_transfer_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_stock_transfer_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-transfer" name="permissions[]" value="stock_transfer_delete" id="permission_stock_transfer_delete" {{ in_array('stock_transfer_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_stock_transfer_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_stock_journal"><strong>{{__('Stock Journal')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-journal" name="permissions[]" value="stock_journal_view" id="permission_stock_journal_view" {{ in_array('stock_journal_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_stock_journal_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-journal" name="permissions[]" value="stock_journal_add" id="permission_stock_journal_add" {{ in_array('stock_journal_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_stock_journal_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-journal" name="permissions[]" value="stock_journal_edit" id="permission_stock_journal_edit" {{ in_array('stock_journal_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_stock_journal_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-journal" name="permissions[]" value="stock_journal_delete" id="permission_stock_journal_delete" {{ in_array('stock_journal_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_stock_journal_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_stock_adjustment"><strong>{{__('Stock Adjustment')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-adjustment" name="permissions[]" value="stock_adjustment_view" id="permission_stock_adjustment_view" {{ in_array('stock_adjustment_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_stock_adjustment_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-adjustment" name="permissions[]" value="stock_adjustment_add" id="permission_stock_adjustment_add" {{ in_array('stock_adjustment_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_stock_adjustment_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-adjustment" name="permissions[]" value="stock_adjustment_edit" id="permission_stock_adjustment_edit" {{ in_array('stock_adjustment_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_stock_adjustment_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-stock-adjustment" name="permissions[]" value="stock_adjustment_delete" id="permission_stock_adjustment_delete" {{ in_array('stock_adjustment_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_stock_adjustment_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_brand"><strong>{{__('Brand')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-brand" name="permissions[]" value="brand_view" id="permission_brand_view" {{ in_array('brand_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_brand_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-brand" name="permissions[]" value="brand_add" id="permission_brand_add" {{ in_array('brand_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_brand_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-brand" name="permissions[]" value="brand_edit" id="permission_brand_edit" {{ in_array('brand_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_brand_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-brand" name="permissions[]" value="brand_delete" id="permission_brand_delete" {{ in_array('brand_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_brand_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_variant"><strong>{{__('Variant')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-variant" name="permissions[]" value="variant_view" id="permission_variant_view" {{ in_array('variant_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_variant_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-variant" name="permissions[]" value="variant_add" id="permission_variant_add" {{ in_array('variant_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_variant_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-variant" name="permissions[]" value="variant_edit" id="permission_variant_edit" {{ in_array('variant_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_variant_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-variant" name="permissions[]" value="variant_delete" id="permission_variant_delete" {{ in_array('variant_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_variant_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_customers"><strong>{{__('Customers')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customers" name="permissions[]" value="customer_view" id="permission_customer_view" {{ in_array('customer_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_customer_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customers" name="permissions[]" value="customer_add" id="permission_customer_add" {{ in_array('customer_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_customer_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customers" name="permissions[]" value="customer_edit" id="permission_customer_edit" {{ in_array('customer_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_customer_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customers" name="permissions[]" value="customer_delete" id="permission_customer_delete" {{ in_array('customer_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_customer_delete">{{__('Delete')}}</label>
                                                            </div>
                                                            <!-- Special Permission -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customers" name="permissions[]" value="import_customers" id="permission_import_customers" {{ in_array('import_customers', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_import_customers">{{__('Import Customers')}}</label>
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
                                                            <label class="form-check-label" for="module_customer_advance"><strong>{{__('Customers Advance Payments')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customer-advance" name="permissions[]" value="customer_advance_view" id="permission_customer_advance_view" {{ in_array('customer_advance_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_customer_advance_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customer-advance" name="permissions[]" value="customer_advance_add" id="permission_customer_advance_add" {{ in_array('customer_advance_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_customer_advance_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customer-advance" name="permissions[]" value="customer_advance_edit" id="permission_customer_advance_edit" {{ in_array('customer_advance_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_customer_advance_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-customer-advance" name="permissions[]" value="customer_advance_delete" id="permission_customer_advance_delete" {{ in_array('customer_advance_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_customer_advance_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_sales"><strong>{{__('Sales')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="sales_view" id="permission_sales_view" {{ in_array('sales_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_sales_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="sales_add" id="permission_sales_add" {{ in_array('sales_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_sales_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="sales_edit" id="permission_sales_edit" {{ in_array('sales_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_sales_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="sales_delete" id="permission_sales_delete" {{ in_array('sales_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_sales_delete">{{__('Delete')}}</label>
                                                            </div>
                                                            <!-- Sales Payments -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="sales_payments_view" id="permission_sales_payments_view" {{ in_array('sales_payments_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_sales_payments_view">{{__('Sales Payments View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="sales_payments_add" id="permission_sales_payments_add" {{ in_array('sales_payments_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_sales_payments_add">{{__('Sales Payments Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="sales_payments_delete" id="permission_sales_payments_delete" {{ in_array('sales_payments_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_sales_payments_delete">{{__('Sales Payments Delete')}}</label>
                                                            </div>
                                                            <!-- Special Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="show_all_users_sales_invoices" id="permission_show_all_users_sales_invoices" {{ in_array('show_all_users_sales_invoices', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_show_all_users_sales_invoices">{{__('Show all users Sales Invoices')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales" name="permissions[]" value="show_item_purchase_price" id="permission_show_item_purchase_price" {{ in_array('show_item_purchase_price', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_show_item_purchase_price">{{__('Show Item Purchase Price')}} ({{__('While making invoice')}})</label>
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
                                                            <label class="form-check-label" for="module_proforma_invoice"><strong>{{__('Proforma Invoice')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-proforma-invoice" name="permissions[]" value="proforma_invoice_view" id="permission_proforma_invoice_view" {{ in_array('proforma_invoice_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_proforma_invoice_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-proforma-invoice" name="permissions[]" value="proforma_invoice_add" id="permission_proforma_invoice_add" {{ in_array('proforma_invoice_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_proforma_invoice_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-proforma-invoice" name="permissions[]" value="proforma_invoice_edit" id="permission_proforma_invoice_edit" {{ in_array('proforma_invoice_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_proforma_invoice_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-proforma-invoice" name="permissions[]" value="proforma_invoice_delete" id="permission_proforma_invoice_delete" {{ in_array('proforma_invoice_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_proforma_invoice_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_delivery_challan_in"><strong>{{__('Delivery Challan In')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-in" name="permissions[]" value="delivery_challan_in_view" id="permission_delivery_challan_in_view" {{ in_array('delivery_challan_in_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_delivery_challan_in_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-in" name="permissions[]" value="delivery_challan_in_add" id="permission_delivery_challan_in_add" {{ in_array('delivery_challan_in_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_delivery_challan_in_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-in" name="permissions[]" value="delivery_challan_in_edit" id="permission_delivery_challan_in_edit" {{ in_array('delivery_challan_in_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_delivery_challan_in_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-in" name="permissions[]" value="delivery_challan_in_delete" id="permission_delivery_challan_in_delete" {{ in_array('delivery_challan_in_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_delivery_challan_in_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_delivery_challan_out"><strong>{{__('Delivery Challan Out')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-out" name="permissions[]" value="delivery_challan_out_view" id="permission_delivery_challan_out_view" {{ in_array('delivery_challan_out_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_delivery_challan_out_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-out" name="permissions[]" value="delivery_challan_out_add" id="permission_delivery_challan_out_add" {{ in_array('delivery_challan_out_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_delivery_challan_out_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-out" name="permissions[]" value="delivery_challan_out_edit" id="permission_delivery_challan_out_edit" {{ in_array('delivery_challan_out_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_delivery_challan_out_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-delivery-challan-out" name="permissions[]" value="delivery_challan_out_delete" id="permission_delivery_challan_out_delete" {{ in_array('delivery_challan_out_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_delivery_challan_out_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_salesorder"><strong>{{__('Salesorder')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-salesorder" name="permissions[]" value="salesorder_view" id="permission_salesorder_view" {{ in_array('salesorder_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_salesorder_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-salesorder" name="permissions[]" value="salesorder_add" id="permission_salesorder_add" {{ in_array('salesorder_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_salesorder_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-salesorder" name="permissions[]" value="salesorder_edit" id="permission_salesorder_edit" {{ in_array('salesorder_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_salesorder_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-salesorder" name="permissions[]" value="salesorder_delete" id="permission_salesorder_delete" {{ in_array('salesorder_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_salesorder_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_discount_coupon"><strong>{{__('Discount Coupon')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-discount-coupon" name="permissions[]" value="discount_coupon_view" id="permission_discount_coupon_view" {{ in_array('discount_coupon_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_discount_coupon_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-discount-coupon" name="permissions[]" value="discount_coupon_add" id="permission_discount_coupon_add" {{ in_array('discount_coupon_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_discount_coupon_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-discount-coupon" name="permissions[]" value="discount_coupon_edit" id="permission_discount_coupon_edit" {{ in_array('discount_coupon_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_discount_coupon_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-discount-coupon" name="permissions[]" value="discount_coupon_delete" id="permission_discount_coupon_delete" {{ in_array('discount_coupon_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_discount_coupon_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_quotation"><strong>{{__('Quotation')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-quotation" name="permissions[]" value="quotation_view" id="permission_quotation_view" {{ in_array('quotation_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_quotation_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-quotation" name="permissions[]" value="quotation_add" id="permission_quotation_add" {{ in_array('quotation_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_quotation_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-quotation" name="permissions[]" value="quotation_edit" id="permission_quotation_edit" {{ in_array('quotation_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_quotation_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-quotation" name="permissions[]" value="quotation_delete" id="permission_quotation_delete" {{ in_array('quotation_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_quotation_delete">{{__('Delete')}}</label>
                                                            </div>
                                                            <!-- Special Permission -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-quotation" name="permissions[]" value="show_all_users_quotations" id="permission_show_all_users_quotations" {{ in_array('show_all_users_quotations', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_show_all_users_quotations">{{__('Show all users Quotations')}}</label>
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
                                                            <label class="form-check-label" for="module_sales_return"><strong>{{__('Sales Return')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="sales_return_view" id="permission_sales_return_view" {{ in_array('sales_return_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_sales_return_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="sales_return_add" id="permission_sales_return_add" {{ in_array('sales_return_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_sales_return_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="sales_return_edit" id="permission_sales_return_edit" {{ in_array('sales_return_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_sales_return_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="sales_return_delete" id="permission_sales_return_delete" {{ in_array('sales_return_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_sales_return_delete">{{__('Delete')}}</label>
                                                            </div>
                                                            <!-- Sales Return Payments -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="sales_return_payments_view" id="permission_sales_return_payments_view" {{ in_array('sales_return_payments_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_sales_return_payments_view">{{__('Sales Return Payments View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="sales_return_payments_add" id="permission_sales_return_payments_add" {{ in_array('sales_return_payments_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_sales_return_payments_add">{{__('Sales Return Payments Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="sales_return_payments_delete" id="permission_sales_return_payments_delete" {{ in_array('sales_return_payments_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_sales_return_payments_delete">{{__('Sales Return Payments Delete')}}</label>
                                                            </div>
                                                            <!-- Special Permission -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-sales-return" name="permissions[]" value="show_all_users_sales_return_invoices" id="permission_show_all_users_sales_return_invoices" {{ in_array('show_all_users_sales_return_invoices', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_show_all_users_sales_return_invoices">{{__('Show all users Sales Return Invoices')}}</label>
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
                                                            <label class="form-check-label" for="module_suppliers"><strong>{{__('Suppliers')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-suppliers" name="permissions[]" value="supplier_view" id="permission_supplier_view" {{ in_array('supplier_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_supplier_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-suppliers" name="permissions[]" value="supplier_add" id="permission_supplier_add" {{ in_array('supplier_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_supplier_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-suppliers" name="permissions[]" value="supplier_edit" id="permission_supplier_edit" {{ in_array('supplier_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_supplier_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-suppliers" name="permissions[]" value="supplier_delete" id="permission_supplier_delete" {{ in_array('supplier_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_supplier_delete">{{__('Delete')}}</label>
                                                            </div>
                                                            <!-- Special Permission -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-suppliers" name="permissions[]" value="import_suppliers" id="permission_import_suppliers" {{ in_array('import_suppliers', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_import_suppliers">{{__('Import Suppliers')}}</label>
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
                                                            <label class="form-check-label" for="module_supplier_advance"><strong>{{__('Supplier Advance Payments')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-supplier-advance" name="permissions[]" value="supplier_advance_view" id="permission_supplier_advance_view" {{ in_array('supplier_advance_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_supplier_advance_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-supplier-advance" name="permissions[]" value="supplier_advance_add" id="permission_supplier_advance_add" {{ in_array('supplier_advance_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_supplier_advance_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-supplier-advance" name="permissions[]" value="supplier_advance_edit" id="permission_supplier_advance_edit" {{ in_array('supplier_advance_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_supplier_advance_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-supplier-advance" name="permissions[]" value="supplier_advance_delete" id="permission_supplier_advance_delete" {{ in_array('supplier_advance_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_supplier_advance_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_purchase"><strong>{{__('Purchase')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="purchase_view" id="permission_purchase_view" {{ in_array('purchase_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="purchase_add" id="permission_purchase_add" {{ in_array('purchase_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="purchase_edit" id="permission_purchase_edit" {{ in_array('purchase_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="purchase_delete" id="permission_purchase_delete" {{ in_array('purchase_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_delete">{{__('Delete')}}</label>
                                                            </div>
                                                            <!-- Purchase Payments -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="purchase_payments_view" id="permission_purchase_payments_view" {{ in_array('purchase_payments_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_payments_view">{{__('Purchase Payments View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="purchase_payments_add" id="permission_purchase_payments_add" {{ in_array('purchase_payments_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_payments_add">{{__('Purchase Payments Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="purchase_payments_delete" id="permission_purchase_payments_delete" {{ in_array('purchase_payments_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_payments_delete">{{__('Purchase Payments Delete')}}</label>
                                                            </div>
                                                            <!-- Special Permission -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase" name="permissions[]" value="show_all_users_purchase_invoices" id="permission_show_all_users_purchase_invoices" {{ in_array('show_all_users_purchase_invoices', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_show_all_users_purchase_invoices">{{__('Show all users Purchase Invoices')}}</label>
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
                                                            <label class="form-check-label" for="module_purchase_order"><strong>{{__('Purchase Order')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-order" name="permissions[]" value="purchase_order_view" id="permission_purchase_order_view" {{ in_array('purchase_order_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_order_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-order" name="permissions[]" value="purchase_order_add" id="permission_purchase_order_add" {{ in_array('purchase_order_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_order_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-order" name="permissions[]" value="purchase_order_edit" id="permission_purchase_order_edit" {{ in_array('purchase_order_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_order_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-order" name="permissions[]" value="purchase_order_delete" id="permission_purchase_order_delete" {{ in_array('purchase_order_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_order_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_purchase_return"><strong>{{__('Purchase Return')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="purchase_return_view" id="permission_purchase_return_view" {{ in_array('purchase_return_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_return_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="purchase_return_add" id="permission_purchase_return_add" {{ in_array('purchase_return_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_return_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="purchase_return_edit" id="permission_purchase_return_edit" {{ in_array('purchase_return_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_return_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="purchase_return_delete" id="permission_purchase_return_delete" {{ in_array('purchase_return_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_return_delete">{{__('Delete')}}</label>
                                                            </div>
                                                            <!-- Purchase Return Payments -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="purchase_return_payments_view" id="permission_purchase_return_payments_view" {{ in_array('purchase_return_payments_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_return_payments_view">{{__('Purchase Return Payments View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="purchase_return_payments_add" id="permission_purchase_return_payments_add" {{ in_array('purchase_return_payments_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_return_payments_add">{{__('Purchase Return Payments Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="purchase_return_payments_delete" id="permission_purchase_return_payments_delete" {{ in_array('purchase_return_payments_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_purchase_return_payments_delete">{{__('Purchase Return Payments Delete')}}</label>
                                                            </div>
                                                            <!-- Special Permission -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-purchase-return" name="permissions[]" value="show_all_users_purchase_return_invoices" id="permission_show_all_users_purchase_return_invoices" {{ in_array('show_all_users_purchase_return_invoices', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_show_all_users_purchase_return_invoices">{{__('Show all users Purchase Return Invoices')}}</label>
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
                                                            <label class="form-check-label" for="module_accounts"><strong>{{__('Accounts')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="account_view" id="permission_account_view" {{ in_array('account_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_account_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="account_add" id="permission_account_add" {{ in_array('account_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_account_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="account_edit" id="permission_account_edit" {{ in_array('account_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_account_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="account_delete" id="permission_account_delete" {{ in_array('account_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_account_delete">{{__('Delete')}}</label>
                                                            </div>
                                                            <!-- Money Deposit -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_deposit_view" id="permission_money_deposit_view" {{ in_array('money_deposit_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_money_deposit_view">{{__('Deposit View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_deposit_add" id="permission_money_deposit_add" {{ in_array('money_deposit_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_money_deposit_add">{{__('Deposit Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_deposit_edit" id="permission_money_deposit_edit" {{ in_array('money_deposit_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_money_deposit_edit">{{__('Deposit Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_deposit_delete" id="permission_money_deposit_delete" {{ in_array('money_deposit_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_money_deposit_delete">{{__('Deposit Delete')}}</label>
                                                            </div>
                                                            <!-- Cash Flow -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="cash_flow_view" id="permission_cash_flow_view" {{ in_array('cash_flow_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_cash_flow_view">{{__('Cash Flow View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="cash_flow_add" id="permission_cash_flow_add" {{ in_array('cash_flow_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_cash_flow_add">{{__('Cash Flow Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="cash_flow_edit" id="permission_cash_flow_edit" {{ in_array('cash_flow_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_cash_flow_edit">{{__('Cash Flow Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="cash_flow_delete" id="permission_cash_flow_delete" {{ in_array('cash_flow_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_cash_flow_delete">{{__('Cash Flow Delete')}}</label>
                                                            </div>
                                                            <!-- Money Transfer -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_transfer_view" id="permission_money_transfer_view" {{ in_array('money_transfer_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_money_transfer_view">{{__('Transfer View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_transfer_add" id="permission_money_transfer_add" {{ in_array('money_transfer_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_money_transfer_add">{{__('Transfer Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_transfer_edit" id="permission_money_transfer_edit" {{ in_array('money_transfer_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_money_transfer_edit">{{__('Transfer Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="money_transfer_delete" id="permission_money_transfer_delete" {{ in_array('money_transfer_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_money_transfer_delete">{{__('Transfer Delete')}}</label>
                                                            </div>
                                                            <!-- Chart of Accounts -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="chart_of_accounts_view" id="permission_chart_of_accounts_view" {{ in_array('chart_of_accounts_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_chart_of_accounts_view">{{__('Chart View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="chart_of_accounts_add" id="permission_chart_of_accounts_add" {{ in_array('chart_of_accounts_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_chart_of_accounts_add">{{__('Chart Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="chart_of_accounts_edit" id="permission_chart_of_accounts_edit" {{ in_array('chart_of_accounts_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_chart_of_accounts_edit">{{__('Chart Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="chart_of_accounts_delete" id="permission_chart_of_accounts_delete" {{ in_array('chart_of_accounts_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_chart_of_accounts_delete">{{__('Chart Delete')}}</label>
                                                            </div>
                                                            <!-- Entries -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="entries_view" id="permission_entries_view" {{ in_array('entries_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_entries_view">{{__('Entries View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="entries_add" id="permission_entries_add" {{ in_array('entries_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_entries_add">{{__('Entries Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="entries_edit" id="permission_entries_edit" {{ in_array('entries_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_entries_edit">{{__('Entries Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="entries_delete" id="permission_entries_delete" {{ in_array('entries_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_entries_delete">{{__('Entries Delete')}}</label>
                                                            </div>
                                                            <!-- Cash Transactions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-accounts" name="permissions[]" value="cash_transactions" id="permission_cash_transactions" {{ in_array('cash_transactions', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_cash_transactions">{{__('Cash Transactions')}}</label>
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
                                                            <label class="form-check-label" for="module_expense"><strong>{{__('Expense')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <!-- Basic Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_view" id="permission_expense_view" {{ in_array('expense_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_expense_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_add" id="permission_expense_add" {{ in_array('expense_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_expense_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_edit" id="permission_expense_edit" {{ in_array('expense_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_expense_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_delete" id="permission_expense_delete" {{ in_array('expense_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_expense_delete">{{__('Delete')}}</label>
                                                            </div>
                                                            <!-- Category Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_category_view" id="permission_expense_category_view" {{ in_array('expense_category_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_expense_category_view">{{__('Category View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_category_add" id="permission_expense_category_add" {{ in_array('expense_category_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_expense_category_add">{{__('Category Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_category_edit" id="permission_expense_category_edit" {{ in_array('expense_category_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_expense_category_edit">{{__('Category Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_category_delete" id="permission_expense_category_delete" {{ in_array('expense_category_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_expense_category_delete">{{__('Category Delete')}}</label>
                                                            </div>
                                                            <!-- Expense Item Permissions -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_item_view" id="permission_expense_item_view" {{ in_array('expense_item_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_expense_item_view">{{__('Item View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_item_add" id="permission_expense_item_add" {{ in_array('expense_item_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_expense_item_add">{{__('Item Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_item_edit" id="permission_expense_item_edit" {{ in_array('expense_item_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_expense_item_edit">{{__('Item Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="expense_item_delete" id="permission_expense_item_delete" {{ in_array('expense_item_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_expense_item_delete">{{__('Item Delete')}}</label>
                                                            </div>
                                                            <!-- Special Permission -->
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-expense" name="permissions[]" value="show_all_users_expenses" id="permission_show_all_users_expenses" {{ in_array('show_all_users_expenses', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_show_all_users_expenses">{{__('Show All Users')}}</label>
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
                                                            <label class="form-check-label" for="module_payment_types"><strong>{{__('Payment Types')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-payment-types" name="permissions[]" value="payment_type_view" id="permission_payment_type_view" {{ in_array('payment_type_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_payment_type_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-payment-types" name="permissions[]" value="payment_type_add" id="permission_payment_type_add" {{ in_array('payment_type_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_payment_type_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-payment-types" name="permissions[]" value="payment_type_edit" id="permission_payment_type_edit" {{ in_array('payment_type_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_payment_type_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-payment-types" name="permissions[]" value="payment_type_delete" id="permission_payment_type_delete" {{ in_array('payment_type_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_payment_type_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_reports"><strong>{{__('Reports')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_delivery_sheet" id="permission_report_delivery_sheet" {{ in_array('report_delivery_sheet', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_delivery_sheet">{{__('Delivery Sheet Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_load_sheet" id="permission_report_load_sheet" {{ in_array('report_load_sheet', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_load_sheet">{{__('Load Sheet Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_customer_orders" id="permission_report_customer_orders" {{ in_array('report_customer_orders', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_customer_orders">{{__('Customer Orders Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_customer" id="permission_report_customer" {{ in_array('report_customer', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_customer">{{__('Customer Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_supplier" id="permission_report_supplier" {{ in_array('report_supplier', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_supplier">{{__('Supplier Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_sales_tax" id="permission_report_sales_tax" {{ in_array('report_sales_tax', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_sales_tax">{{__('Sales Tax Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_purchase_tax" id="permission_report_purchase_tax" {{ in_array('report_purchase_tax', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_purchase_tax">{{__('Purchase Tax Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_supplier_items" id="permission_report_supplier_items" {{ in_array('report_supplier_items', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_supplier_items">{{__('Supplier Items Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_sales" id="permission_report_sales" {{ in_array('report_sales', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_sales">{{__('Sales Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_sales_register" id="permission_report_sales_register" {{ in_array('report_sales_register', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_sales_register">{{__('Sales Register Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_purchase_register" id="permission_report_purchase_register" {{ in_array('report_purchase_register', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_purchase_register">{{__('Purchase Register Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_sales_return" id="permission_report_sales_return" {{ in_array('report_sales_return', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_sales_return">{{__('Sales Return Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_seller_points" id="permission_report_seller_points" {{ in_array('report_seller_points', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_seller_points">{{__('Seller Points Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_purchase" id="permission_report_purchase" {{ in_array('report_purchase', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_purchase">{{__('Purchase Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_overseas_ledger" id="permission_report_overseas_ledger" {{ in_array('report_overseas_ledger', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_overseas_ledger">{{__('Overseas Ledger')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_purchase_return" id="permission_report_purchase_return" {{ in_array('report_purchase_return', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_purchase_return">{{__('Purchase Return Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_expense" id="permission_report_expense" {{ in_array('report_expense', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_expense">{{__('Expense Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_expense_outstanding" id="permission_report_expense_outstanding" {{ in_array('report_expense_outstanding', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_expense_outstanding">{{__('Expense Outstanding Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_expense_payment" id="permission_report_expense_payment" {{ in_array('report_expense_payment', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_expense_payment">{{__('Expense Payment Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_expense_gst" id="permission_report_expense_gst" {{ in_array('report_expense_gst', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_expense_gst">{{__('Expense GST Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_profit" id="permission_report_profit" {{ in_array('report_profit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_profit">{{__('Profit Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_stock" id="permission_report_stock" {{ in_array('report_stock', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_stock">{{__('Stock Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_stock_ledger" id="permission_report_stock_ledger" {{ in_array('report_stock_ledger', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_stock_ledger">{{__('Stock Ledger Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_sales_item" id="permission_report_sales_item" {{ in_array('report_sales_item', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_sales_item">{{__('Sales item Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_return_items" id="permission_report_return_items" {{ in_array('report_return_items', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_return_items">{{__('Return Items Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_purchase_payments" id="permission_report_purchase_payments" {{ in_array('report_purchase_payments', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_purchase_payments">{{__('Purchase Payments Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_sales_payments" id="permission_report_sales_payments" {{ in_array('report_sales_payments', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_sales_payments">{{__('Sales Payments Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_gstr1" id="permission_report_gstr1" {{ in_array('report_gstr1', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_gstr1">{{__('GSTR-1 Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_gstr2" id="permission_report_gstr2" {{ in_array('report_gstr2', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_gstr2">{{__('GSTR-2 Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_sales_gst" id="permission_report_sales_gst" {{ in_array('report_sales_gst', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_sales_gst">{{__('Sales GST Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_purchase_gst" id="permission_report_purchase_gst" {{ in_array('report_purchase_gst', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_purchase_gst">{{__('Purchase GST Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_quotation_items" id="permission_report_quotation_items" {{ in_array('report_quotation_items', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_quotation_items">{{__('Quotation Items Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_purchase_order_item" id="permission_report_purchase_order_item" {{ in_array('report_purchase_order_item', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_purchase_order_item">{{__('Purchase Order Item Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_hsn_summary" id="permission_report_hsn_summary" {{ in_array('report_hsn_summary', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_hsn_summary">{{__('HSN Summary Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_balance_sheet" id="permission_report_balance_sheet" {{ in_array('report_balance_sheet', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_balance_sheet">{{__('Balance Sheet Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_trial_balance" id="permission_report_trial_balance" {{ in_array('report_trial_balance', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_trial_balance">{{__('Trial Balance Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_ledger_statement" id="permission_report_ledger_statement" {{ in_array('report_ledger_statement', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_ledger_statement">{{__('Ledger Statement Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_ledger_entries" id="permission_report_ledger_entries" {{ in_array('report_ledger_entries', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_ledger_entries">{{__('Ledger Entries Report')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-reports" name="permissions[]" value="report_reconciliation" id="permission_report_reconciliation" {{ in_array('report_reconciliation', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_report_reconciliation">{{__('Reconciliation Report')}}</label>
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
                                                            <label class="form-check-label" for="module_users"><strong>{{__('Users')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-users" name="permissions[]" value="user_view" id="permission_user_view" {{ in_array('user_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_user_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-users" name="permissions[]" value="user_add" id="permission_user_add" {{ in_array('user_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_user_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-users" name="permissions[]" value="user_edit" id="permission_user_edit" {{ in_array('user_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_user_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-users" name="permissions[]" value="user_delete" id="permission_user_delete" {{ in_array('user_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_user_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_roles"><strong>{{__('Roles')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-roles" name="permissions[]" value="role_view" id="permission_role_view" {{ in_array('role_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_role_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-roles" name="permissions[]" value="role_add" id="permission_role_add" {{ in_array('role_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_role_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-roles" name="permissions[]" value="role_edit" id="permission_role_edit" {{ in_array('role_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_role_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-roles" name="permissions[]" value="role_delete" id="permission_role_delete" {{ in_array('role_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_role_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_company"><strong>{{__('Company')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-company" name="permissions[]" value="company_view" id="permission_company_view" {{ in_array('company_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_company_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-company" name="permissions[]" value="company_add" id="permission_company_add" {{ in_array('company_add', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_company_add">{{__('Add')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-company" name="permissions[]" value="company_edit" id="permission_company_edit" {{ in_array('company_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_company_edit">{{__('Edit')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-company" name="permissions[]" value="company_delete" id="permission_company_delete" {{ in_array('company_delete', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_company_delete">{{__('Delete')}}</label>
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
                                                            <label class="form-check-label" for="module_store"><strong>{{__('Store(Own Store)')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-store" name="permissions[]" value="store_view" id="permission_store_view" {{ in_array('store_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_store_view">{{__('View')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-store" name="permissions[]" value="store_edit" id="permission_store_edit" {{ in_array('store_edit', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_store_edit">{{__('Edit')}}</label>
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
                                                            <label class="form-check-label" for="module_dashboard"><strong>{{__('Dashboard')}}</strong></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_view" id="permission_dashboard_view" {{ in_array('dashboard_view', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_dashboard_view">{{__('View Dashboard')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_info1" id="permission_dashboard_info1" {{ in_array('dashboard_info1', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_dashboard_info1">{{__('Info Box 1')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_info2" id="permission_dashboard_info2" {{ in_array('dashboard_info2', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_dashboard_info2">{{__('Info Box 2')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_chart" id="permission_dashboard_chart" {{ in_array('dashboard_chart', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_dashboard_chart">{{__('Sales Chart')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_items" id="permission_dashboard_items" {{ in_array('dashboard_items', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_dashboard_items">{{__('Recent Items')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_stock_alert" id="permission_dashboard_stock_alert" {{ in_array('dashboard_stock_alert', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_dashboard_stock_alert">{{__('Stock Alert')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_trending" id="permission_dashboard_trending" {{ in_array('dashboard_trending', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_dashboard_trending">{{__('Trending Items')}}</label>
                                                            </div>
                                                            <div class="col-md-4 form-check">
                                                                <input type="checkbox" class="form-check-input permission-checkbox module-dashboard" name="permissions[]" value="dashboard_recent_sales" id="permission_dashboard_recent_sales" {{ in_array('dashboard_recent_sales', $rolePermissions) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_dashboard_recent_sales">{{__('Recent Sales')}}</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" onclick="window.location.href='{{ route('roles.index') }}'">
                        <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
                    </div>

                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
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

        // 7. Update module checkboxes based on pre-selected permissions
        function updateModuleCheckboxes() {
            $('.module-checkbox').each(function() {
                var moduleId = $(this).attr('id').replace('module_', '');
                var moduleClass = 'module-' + moduleId.replace(/_/g, '-');
                var allPermissions = $('.' + moduleClass);
                var checkedPermissions = allPermissions.filter(':checked');
                
                if (checkedPermissions.length === 0) {
                    $(this).prop('checked', false);
                    $(this).prop('indeterminate', false);
                } else if (checkedPermissions.length === allPermissions.length) {
                    $(this).prop('checked', true);
                    $(this).prop('indeterminate', false);
                } else {
                    $(this).prop('checked', false);
                    $(this).prop('indeterminate', true);
                }
            });
            
            // Update Select All checkbox
            updateSelectAllCheckbox();
            
            // Update visual feedback
            updateVisualFeedback();
        }

        // 8. Initialize on page load
        updateModuleCheckboxes();
        
        // 9. Initialize visual feedback
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
@endpush