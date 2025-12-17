@extends('layouts.admin')
@section('page-title')
    {{__('Manage Role')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Role')}}</li>
@endsection

@section('action-btn')
<div class="float-end">
    <div class="d-flex flex-wrap gap-2 justify-content-end align-items-center">
            <x-export-buttons 
        tableId="rolesTable"
        :createButton="true"
        createRoute="{{ route('roles.create') }}"
        createPermission="create roles"
        createLabel="New roles"
        createIcon="ti-plus"
        createTooltip="Create New roles"
        :columns="[
            ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
            ['index' => 1, 'name' => 'Role', 'description' => 'Company name'],
            ['index' => 2, 'name' => 'Description', 'description' => 'Email address'],
            ['index' => 3, 'name' => 'Permissions', 'description' => 'Mobile number'],
            ['index' => 4, 'name' => 'Status', 'description' => 'Active/Inactive status'],
            ['index' => 5, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
        ]"
    />

        

        {{-- Create New Role Button --}}
        <div class="ms-md-2">
            <a href="{{ route('roles.create') }}" 
               data-bs-toggle="tooltip" title="{{__('Create New Role')}}" 
               class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i> {{ __('New Role') }}
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table " id="rolesTable">
                        <thead>
                        <tr>
                            <th>{{__('Role')}}</th>
                            <th>{{__('Description')}}</th>
                            <!-- <th>{{__('Permissions')}}</th> -->
                            <th>{{__('Status')}}</th>
                            <th width="200">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $role)
                            @if($role->name != 'client')
                                <tr class="font-style">
                                    <td class="Role">{{ $role->name }}</td>
                                    <td class="Description">
                                        @if($role->description)
                                            <span class="text-muted" data-bs-toggle="tooltip" title="{{ $role->description }}">
                                                {{ Str::limit($role->description, 50) }}
                                            </span>
                                        @else
                                            <span class="text-muted">Not available</span>
                                        @endif
                                    </td>
                                    <!-- <td class="Permission">
                                        @if($role->permissions->count() > 0)
                                            @foreach($role->permissions->take(3) as $permission)
                                                <span class="badge rounded-pill bg-primary mb-1">{{ $permission->name }}</span>
                                            @endforeach
                                            @if($role->permissions->count() > 3)
                                                <span class="badge rounded-pill bg-secondary" data-bs-toggle="tooltip" 
                                                    title="{{ $role->permissions->skip(3)->pluck('name')->implode(', ') }}">
                                                    +{{ $role->permissions->count() - 3 }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-muted">{{ __('No permissions') }}</span>
                                        @endif
                                    </td> -->
                                    <td class="Status">
                                        <span class="badge bg-success">{{ __('Active') }}</span>
                                    </td>
                                    <td class="Action">
                                        <span>
                                            @can('edit role')
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="{{ route('roles.edit', $role->id) }}" 
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                    data-bs-toggle="tooltip" 
                                                    title="{{__('Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan

                                            @if($role->name != 'Employee')
                                                @can('delete role')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id],'id'=>'delete-form-'.$role->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" 
                                                        data-bs-toggle="tooltip" 
                                                        title="{{__('Delete')}}" 
                                                        data-confirm="{{ __('Are You Sure?') }}" 
                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}" 
                                                        data-confirm-yes="delete-form-{{ $role->id }}">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                @endcan
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <x-export-scripts 
        tableId="rolesTable"
        searchPlaceholder="Search roles..."
        pdfTitle="Roles"
    />
@endpush