@extends('layouts.admin')
@php
    // Use the Utility helper function to get the correct file path
    $profile = \App\Models\Utility::get_file('uploads/avatar');
    
    // Determine if user is super admin
    $isSuperAdmin = \Auth::user()->type == 'super admin';
    $isCompanyAdmin = \Auth::user()->type == 'company';
@endphp

@section('page-title')
    {{__('Manage User')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('User')}}</li>
@endsection

@section('action-btn')
    {{-- Use the export buttons component --}}
    <x-export-buttons 
        tableId="userTable"
        :createButton="true"
        createRoute="{{ route('users.create') }}"
        createPermission="create user"
        createLabel="New User"
        createIcon="ti-plus"
        createTooltip="Create New User"
        :columns="[
            ['index' => 0, 'name' => 'Name', 'description' => 'User name and avatar'],
            ['index' => 1, 'name' => 'Email', 'description' => 'Email address'],
            ['index' => 2, 'name' => 'Mobile', 'description' => 'Mobile number'],
            ['index' => 3, 'name' => 'Type', 'description' => 'User type/role'],
            ['index' => 4, 'name' => 'Created On', 'description' => 'Created on date'],
            ['index' => 5, 'name' => 'Status', 'description' => 'Active/Inactive status'],
            ['index' => 6, 'name' => 'Plan', 'description' => 'Subscription plan'],
            ['index' => 7, 'name' => 'Plan Expired', 'description' => 'Plan expiry date'],
            ['index' => 8, 'name' => 'Actions', 'description' => 'Edit/Delete actions']
        ]"
    />

    @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'HR')
                        <div class="mb-3">
                            <a href="{{ route('user.userlog') }}" 
                               class="btn btn-outline-primary btn-sm {{ Request::segment(1) == 'user' }}"
                               data-bs-toggle="tooltip" 
                               data-bs-placement="top" 
                               title="{{ __('User Logs History') }}">
                                <i class="ti ti-user-check me-1"></i> {{ __('User Logs History') }}
                            </a>
                        </div>
                    @endif
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
    <table class="table w-100 " id="userTable">
        <thead>
            <tr>
                <th class="text-center">{{__('#')}}</th> <!-- Change from S.No to # -->
                @if($isSuperAdmin || $isCompanyAdmin)
                    <th>{{__('Company')}}</th>
                @endif
                <th>{{__('Name')}}</th>
                <th>{{__('Email')}}</th>
                <th>{{__('Mobile')}}</th>
                <th>{{__('Role')}}</th>
                <th>{{__('Created On')}}</th>
                <th>{{__('Status')}}</th>
                @if($isSuperAdmin)
                    <th>{{__('Plan')}}</th>
                    <th>{{__('Plan Expired')}}</th>
                @endif
                <th width="150" class="text-center">{{__('Actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td class="text-center"></td> <!-- Empty td - DataTables will fill this -->
                    <!-- Rest of your table content remains the same -->
                    @if($isSuperAdmin || $isCompanyAdmin)
                        <td>
                            @php
                                $companyNames = [];
                                if (is_string($user->company_id) && strpos($user->company_id, '[') !== false) {
                                    $companyIds = json_decode($user->company_id, true);
                                    if (is_array($companyIds)) {
                                        foreach ($companyIds as $companyId) {
                                            $company = \App\Models\User::find($companyId);
                                            if ($company) {
                                                $companyNames[] = $company->name;
                                            }
                                        }
                                    }
                                } else {
                                    $company = \App\Models\User::find($user->company_id);
                                    if ($company) {
                                        $companyNames[] = $company->name;
                                    }
                                }
                            @endphp
                            @if(!empty($companyNames))
                                {{ implode(', ', $companyNames) }}
                            @else
                                -
                            @endif
                        </td>
                    @endif
                    
                    <td>
                        <div class="d-flex align-items-center">
                            @php
                                $avatarPath = $user->avatar;
                                $avatarUrl = null;
                                
                                if (!empty($avatarPath)) {
                                    if (filter_var($avatarPath, FILTER_VALIDATE_URL)) {
                                        $avatarUrl = $avatarPath;
                                    } else {
                                        if (strpos($avatarPath, 'uploads/avatar/') === 0) {
                                            $avatarUrl = asset(Storage::url($avatarPath));
                                        } else {
                                            $possiblePaths = [
                                                $avatarPath,
                                                'uploads/avatar/' . $avatarPath,
                                                'avatar/' . $avatarPath
                                            ];
                                            
                                            foreach ($possiblePaths as $path) {
                                                if (Storage::exists($path) || Storage::disk('public')->exists($path)) {
                                                    $avatarUrl = asset(Storage::url($path));
                                                    break;
                                                }
                                            }
                                            
                                            if (!$avatarUrl) {
                                                $avatarUrl = asset(Storage::url('uploads/avatar/avatar.png'));
                                            }
                                        }
                                    }
                                } else {
                                    $avatarUrl = asset(Storage::url('uploads/avatar/avatar.png'));
                                }
                            @endphp
                            
                            <img src="{{ $avatarUrl }}" 
                                 class="rounded-circle me-2" width="30" height="30" alt="{{ $user->name }}">
                            {{ $user->name }}
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->mobile }}</td>
                    <td>
                        <div class="badge bg-primary p-2 px-3 rounded">
                            {{ ucfirst($user->type) }}
                        </div>
                    </td>
                    <td>
                        {{ !empty($user->created_at) ? $user->created_at->format('Y-m-d') : '-' }}
                    </td>
                    <td>
                        @if($user->delete_status == 0)
                            <span class="badge bg-danger">{{__('Inactive')}}</span>
                        @else
                            <span class="badge bg-success">{{__('Active')}}</span>
                        @endif
                    </td>
                    @if($isSuperAdmin)
                        <td>{{ !empty($user->currentPlan) ? $user->currentPlan->name : '-' }}</td>
                        <td>{{ !empty($user->plan_expire_date) ? \Auth::user()->dateFormat($user->plan_expire_date) : __('Lifetime') }}</td>
                    @endif
                    <td class="text-center">
                        @if($user->is_active == 1)
                            <div class="d-flex justify-content-center">
                                @can('edit user')
                                <div class="action-btn bg-light-secondary ms-2">
                                    <a href="{{ route('users.edit', $user->id) }}" 
                                       class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                       data-bs-toggle="tooltip" 
                                       title="{{__('Edit')}}">
                                        <i class="ti ti-pencil text-dark"></i>
                                    </a>
                                </div>
                                @endcan
                                
                                @can('delete user')
                                <div class="action-btn bg-light-secondary ms-2">
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'id' => 'delete-form-' . $user->id, 'class' => 'd-inline']) !!}
                                    <a href="#!" 
                                       class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para" 
                                       data-bs-toggle="tooltip" 
                                       title="@if($user->delete_status != 0){{__('Delete')}}@else{{__('Restore')}}@endif" 
                                       data-confirm="{{__('Are You Sure?')}}" 
                                       data-text="{{__('This action can not be undone. Do you want to continue?')}}" 
                                       data-confirm-yes="delete-form-{{ $user->id }}">
                                        <i class="ti ti-archive text-dark"></i>
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
                    @php
                        $colspan = 7;
                        if ($isSuperAdmin || $isCompanyAdmin) {
                            $colspan++;
                        }
                        if ($isSuperAdmin) {
                            $colspan += 2;
                        }
                        $colspan++;
                    @endphp
                    <td colspan="{{ $colspan }}" class="text-center">
                        <div class="alert alert-info d-inline-flex align-items-center">
                            <i class="ti ti-info-circle me-2"></i>
                            {{ __('No users found.') }}
                            @can('create user')
                            <a href="{{ route('users.create') }}" class="alert-link ms-1">
                                {{ __('Create your first user') }}
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
        tableId="userTable"
        searchPlaceholder="Search users..."
        pdfTitle="Users"
    />
@endpush