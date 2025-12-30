@extends('layouts.admin')

@section('page-title')
    {{ __('Enquiry List') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Enquiry') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        @can('enquiry_add')
            <a href="{{ route('enquiry.create') }}" data-bs-toggle="tooltip" title="{{ __('Create') }}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="mt-2" id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => ['enquiry.index'], 'method' => 'GET', 'id' => 'enquiry_form']) }}
                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">

                                    <!-- From Date Filter -->
                                    <div class="col-3">
                                        <div class="btn-box">
                                            {{ Form::label('from_date', __('From Date'), ['class' => 'form-label']) }}
                                            {{ Form::date('from_date', isset($_GET['from_date']) ? $_GET['from_date'] : null, ['class' => 'form-control', 'id' => 'from_date']) }}
                                        </div>
                                    </div>

                                    <!-- To Date Filter -->
                                    <div class="col-3">
                                        <div class="btn-box">
                                            {{ Form::label('to_date', __('To Date'), ['class' => 'form-label']) }}
                                            {{ Form::date('to_date', isset($_GET['to_date']) ? $_GET['to_date'] : null, ['class' => 'form-control', 'id' => 'to_date']) }}
                                        </div>
                                    </div>

                                    <!-- Company Filter -->
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('company_id', __('Company'), ['class' => 'form-label']) }}
                                            {{ Form::select('company_id', $companies, isset($_GET['company_id']) ? $_GET['company_id'] : '', ['class' => 'form-control select', 'id' => 'company_id']) }}
                                        </div>
                                    </div>

                                    <!-- Status Filter -->
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                                            <select name="status" class="form-control select" id="status">
                                                <option value="">{{ __('All Status') }}</option>
                                                <option value="pending" {{ isset($_GET['status']) && $_GET['status'] == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                                <option value="assigned" {{ isset($_GET['status']) && $_GET['status'] == 'assigned' ? 'selected' : '' }}>{{ __('Assigned') }}</option>
                                                <option value="quoted" {{ isset($_GET['status']) && $_GET['status'] == 'quoted' ? 'selected' : '' }}>{{ __('Quoted') }}</option>
                                                <option value="purchased" {{ isset($_GET['status']) && $_GET['status'] == 'purchased' ? 'selected' : '' }}>{{ __('Purchased') }}</option>
                                                <option value="cancelled" {{ isset($_GET['status']) && $_GET['status'] == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                                                <option value="completed" {{ isset($_GET['status']) && $_GET['status'] == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                                                <option value="ignored" {{ isset($_GET['status']) && $_GET['status'] == 'ignored' ? 'selected' : '' }}>{{ __('Ignored') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Sales Engineer Filter -->
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('salesman_id', __('Sales Engineer'), ['class' => 'form-label']) }}
                                            {{ Form::select('salesman_id', $salesmen, isset($_GET['salesman_id']) ? $_GET['salesman_id'] : '', ['class' => 'form-control select', 'id' => 'salesman_id']) }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-auto mt-4">
                                <div class="row">
                                    <div class="col-auto">

                                        <!-- Apply Button -->
                                        <button type="button" class="btn btn-sm btn-primary" id="apply-filter" data-bs-toggle="tooltip" title="{{ __('Apply') }}">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </button>

                                        <!-- Reset Button -->
                                        <a href="{{ route('enquiry.index') }}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{{ __('Reset') }}">
                                            <span class="btn-inner--icon"><i class="ti ti-refresh text-white"></i></span>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style mt-2">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Company') }}</th>
                                    <th>{{ __('Contact Person') }}</th>
                                    <th>{{ __('Product') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Sales Engineer') }}</th>
                                    <th>{{ __('Remarks') }}</th>
                                    @if(Gate::check('enquiry_edit') || Gate::check('enquiry_delete'))
                                        <th width="10%">{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($enquiries as $enquiry)
                                    <tr class="font-style">
                                        <td>{{ Auth::user()->dateFormat($enquiry->enquiry_date) }}</td>
                                        <td>{{ $enquiry->company->name ?? '-' }}</td>
                                        <td>{{ $enquiry->contact_person ?? '-' }}</td>
                                        <td>{{ $enquiry->product ?? '-' }}</td>
                                        <td>{{ $enquiry->quantity ?? '-' }}</td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'pending' => 'warning',
                                                    'assigned' => 'info',
                                                    'quoted' => 'primary',
                                                    'purchased' => 'success',
                                                    'cancelled' => 'danger',
                                                    'completed' => 'dark',
                                                    'ignored' => 'secondary'
                                                ][$enquiry->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">
                                                {{ ucfirst($enquiry->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $enquiry->salesman->name ?? '-' }}</td>
                                        <td>{{ Str::limit($enquiry->remarks, 30) ?? '-' }}</td>
                                        
                                        @if(Gate::check('enquiry_edit') || Gate::check('enquiry_delete'))
                                            <td class="Action">
                                                <span>
                                                    @can('enquiry_edit')
                                                        <div class="action-btn bg-primary ms-2">
                                                            <a href="{{ route('enquiry.edit', $enquiry->id) }}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{ __('Edit') }}" data-original-title="{{ __('Edit') }}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                    @can('enquiry_delete')
                                                        <div class="action-btn bg-danger ms-2">
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['enquiry.destroy', $enquiry->id], 'class' => 'delete-form-btn', 'id' => 'delete-form-'.$enquiry->id]) !!}
                                                            <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{ __('Delete') }}" data-original-title="{{ __('Delete') }}" data-confirm="{{ __('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="document.getElementById('delete-form-{{ $enquiry->id }}').submit();">
                                                                <i class="ti ti-trash text-white"></i>
                                                            </a>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    @endcan
                                                </span>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<!-- <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" /> -->
@endpush

@push('scripts')
<!-- <script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script> -->
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select').select2({
            width: '100%',
            theme: 'bootstrap-5'
        });

        // Apply filter button click handler
        $('#apply-filter').on('click', function() {
            var params = {};
            
            // Collect only non-empty values
            var fromDate = $('#from_date').val();
            var toDate = $('#to_date').val();
            var companyId = $('#company_id').val();
            var status = $('#status').val();
            var salesmanId = $('#salesman_id').val();
            
            if (fromDate) params.from_date = fromDate;
            if (toDate) params.to_date = toDate;
            if (companyId) params.company_id = companyId;
            if (status) params.status = status;
            if (salesmanId) params.salesman_id = salesmanId;
            
            // Build query string
            var queryString = Object.keys(params).map(key => 
                key + '=' + encodeURIComponent(params[key])
            ).join('&');
            
            // Navigate to URL with clean parameters
            var baseUrl = "{{ route('enquiry.index') }}";
            var url = queryString ? baseUrl + '?' + queryString : baseUrl;
            
            window.location.href = url;
        });

        // Optional: Press Enter in any field to apply filter
        $('#enquiry_form input, #enquiry_form select').on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                e.preventDefault();
                $('#apply-filter').click();
            }
        });
    });
</script>
@endpush