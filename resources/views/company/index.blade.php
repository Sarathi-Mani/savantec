@extends('layouts.admin')
@php
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp

@section('page-title')
    {{__('Manage Company')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Company')}}</li>
@endsection


@section('action-btn')
    {{-- Use the export buttons component --}}
<div class="float-end">
    <div class="d-flex flex-wrap gap-2 justify-content-end align-items-center">
        <x-export-buttons 
            tableId="companyTable"
            :createButton="true"
            createRoute="{{ route('company.create') }}"
            createPermission="create company"
            createLabel="New Company"
            createIcon="ti-plus"
            createTooltip="Create New Company"
            :columns="[
                ['index' => 0, 'name' => '#', 'description' => 'Serial number'],
                ['index' => 1, 'name' => 'Name', 'description' => 'Company name'],
                ['index' => 2, 'name' => 'Email', 'description' => 'Email address'],
                ['index' => 3, 'name' => 'Mobile', 'description' => 'Mobile number'],
                ['index' => 4, 'name' => 'Status', 'description' => 'Active/Inactive status'],
                ['index' => 5, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
            ]"
        />

        {{-- Create New Role Button --}}
        <div class="ms-md-2">
            <a href="{{ route('company.create') }}" 
               data-bs-toggle="tooltip" title="{{__('Create New Company')}}" 
               class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i> {{ __('New Company') }}
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
                        <table class="table w-10 0 " id="companyTable">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center">{{__('#')}}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Email')}}</th>
                                    <th>{{__('Mobile')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th width="150" class="text-center">{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($companies as $key => $company)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>{{ $company->name }}</td>
                                        <td>{{ $company->email }}</td>
                                        <td>{{ $company->mobile ?? '-' }}</td>
                                        <td class="text-center">
                                            @if($company->delete_status == 0)
                                                <span class="badge bg-danger">{{__('Inactive')}}</span>
                                            @else
                                                <span class="badge bg-success">{{__('Active')}}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($company->is_active == 1)
                                                <div class="d-flex justify-content-center">
                                                    @can('edit company')
                                                    <div class="action-btn bg-light-secondary ms-2">
                                                        <a href="{{ route('company.edit', $company->id) }}" 
                                                           class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                           data-bs-toggle="tooltip" 
                                                           title="{{__('Edit')}}">
                                                            <i class="ti ti-pencil text-dark"></i>
                                                        </a>
                                                    </div>
                                                    @endcan
                                                    
                                                    @can('delete company')
                                                    <div class="action-btn bg-light-secondary ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['company.destroy', $company->id], 'id' => 'delete-form-' . $company->id, 'class' => 'd-inline']) !!}
                                                        <a href="#!" 
                                                           class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" 
                                                           data-bs-toggle="tooltip" 
                                                           title="{{__('Delete')}}" 
                                                           data-confirm="{{__('Are You Sure?')}}" 
                                                           data-text="{{__('This action will permanently delete the company. Do you want to continue?')}}" 
                                                           data-confirm-yes="delete-form-{{ $company->id }}">
                                                            <i class="ti ti-trash text-danger"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                    @endcan
                                                </div>
                                            @else
                                                <span class="text-muted">{{__('Locked')}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="alert alert-info d-inline-flex align-items-center">
                                                <i class="ti ti-info-circle me-2"></i>
                                                {{ __('No companies found.') }}
                                                @can('create company')
                                                <a href="{{ route('company.create') }}" class="alert-link ms-1">
                                                    {{ __('Create your first company') }}
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
        tableId="companyTable"
        searchPlaceholder="Search companies..."
        pdfTitle="Companies"
    />
@endpush