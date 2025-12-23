@extends('layouts.admin')
@section('page-title')
    {{__('Manage Role')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Role')}}</li>p
@endsection

@section('action-btn')
<div class="float-end">
    <div class="d-flex flex-wrap gap-2 justify-content-end align-items-center">
        <x-export-buttons 
            tableId="rolesTable"
            :createButton="true"
            createRoute="{{ route('roles.create') }}"
            createPermission="create roles"
            createLabel="New Role"
            createIcon="ti-plus"
            createTooltip="Create New Role"
            :columns="[
                ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
                ['index' => 1, 'name' => 'Role', 'description' => 'Role name'],
                ['index' => 2, 'name' => 'Description', 'description' => 'Role description'],
                ['index' => 3, 'name' => 'Status', 'description' => 'Active status'],
                ['index' => 4, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
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
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="ti ti-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="ti ti-alert-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table w-100" id="rolesTable">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center">{{__('#')}}</th>
                                    <th>{{__('Role')}}</th>
                                    <th>{{__('Description')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th width="150" class="text-center">{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $key => $role)
                                    @if($role->name != 'client')
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @if($role->description)
                                                    <span class="text-muted" data-bs-toggle="tooltip" title="{{ $role->description }}">
                                                        {{ Str::limit($role->description, 50) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">{{ __('Not available') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success">{{ __('Active') }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    @can('edit role')
                                                    <div class="action-btn bg-light-secondary ms-2">
                                                        <a href="{{ route('roles.edit', $role->id) }}" 
                                                           class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                           data-bs-toggle="tooltip" 
                                                           title="{{__('Edit')}}">
                                                            <i class="ti ti-pencil text-dark"></i>
                                                        </a>
                                                    </div>
                                                    @endcan
                                                    
                                                    @if($role->name != 'Employee')
                                                        @can('delete role')
                                                        <div class="action-btn bg-light-secondary ms-2">
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'id' => 'delete-form-' . $role->id, 'class' => 'd-inline']) !!}
                                                            <a href="#!" 
                                                               class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" 
                                                               data-bs-toggle="tooltip" 
                                                               title="{{__('Delete')}}" 
                                                               data-confirm="{{__('Are You Sure?')}}" 
                                                               data-text="{{__('This action will permanently delete the role. Do you want to continue?')}}" 
                                                               data-confirm-yes="delete-form-{{ $role->id }}">
                                                                <i class="ti ti-trash text-danger"></i>
                                                            </a>
                                                            {!! Form::close() !!}
                                                        </div>
                                                        @endcan
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <div class="alert alert-info d-inline-flex align-items-center">
                                                <i class="ti ti-info-circle me-2"></i>
                                                {{ __('No roles found.') }}
                                                @can('create roles')
                                                <a href="{{ route('roles.create') }}" class="alert-link ms-1">
                                                    {{ __('Create your first role') }}
                                                </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
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