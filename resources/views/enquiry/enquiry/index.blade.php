@extends('layouts.admin')

@section('page-title')
    {{__('Enquiry List')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Enquiry')}}</li>
@endsection

@section('action-btn')
<div class="float-end d-flex gap-2">

    {{-- CSV Download --}}
    <a href="{{ route('enquiry.export.csv') }}" 
       class="btn btn-sm btn-success" 
       data-bs-toggle="tooltip" title="Download CSV">
        <i class="ti ti-file-type-csv"></i>
    </a>

    {{-- PDF Download --}}
    <a href="{{ route('enquiry.export.pdf') }}" 
       class="btn btn-sm btn-danger" 
       data-bs-toggle="tooltip" title="Download PDF">
        <i class="ti ti-file-type-pdf"></i>
    </a>

    {{-- Create new enquiry --}}
    <a href="{{ route('enquiry.create') }}" 
       data-bs-toggle="tooltip" title="{{__('Create New Enquiry')}}" 
       class="btn btn-sm btn-primary">
        <i class="ti ti-plus"></i>
    </a>

</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>{{ __('S.No') }}</th>
                                <th>{{ __('Enquiry No') }}</th>
                                <th>{{ __('Enquiry Date') }}</th>
                                <th>{{ __('Company Name') }}</th>
                                <th>{{ __('Salesman') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enquiries as $index => $enquiry)
                                <tr class="font-style">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $enquiry->enquiry_no ?? 'N/A' }}</td>
                                    <td>
                                        @if($enquiry->enquiry_date)
                                            {{ \Carbon\Carbon::parse($enquiry->enquiry_date)->format('d-m-Y') }}
                                        @else
                                            {{ __('N/A') }}
                                        @endif
                                    </td>
                                    <td>{{ $enquiry->company_name ?? __('N/A') }}</td>
                                    <td>
                                        @if($enquiry->salesman)
                                            {{ $enquiry->salesman->name ?? __('N/A') }}
                                        @else
                                            {{ __('N/A') }}
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = '';
                                            switch(strtolower($enquiry->status ?? '')) {
                                                case 'pending':
                                                    $statusClass = 'bg-warning';
                                                    break;
                                                case 'in progress':
                                                    $statusClass = 'bg-info';
                                                    break;
                                                case 'completed':
                                                    $statusClass = 'bg-success';
                                                    break;
                                                case 'cancelled':
                                                    $statusClass = 'bg-danger';
                                                    break;
                                                default:
                                                    $statusClass = 'bg-secondary';
                                            }
                                        @endphp
                                        <span class="badge {{ $statusClass }}">
                                            {{ ucfirst($enquiry->status ?? __('Pending')) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            @can('view enquiry')
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="{{ route('enquiry.show', $enquiry->id) }}" 
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                    data-bs-toggle="tooltip" 
                                                    title="{{__('View')}}">
                                                        <i class="ti ti-eye text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan

                                            @can('edit enquiry')
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="{{ route('enquiry.edit', $enquiry->id) }}" 
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center" 
                                                    data-bs-toggle="tooltip" 
                                                    title="{{__('Edit')}}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan

                                            @can('delete enquiry')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['enquiry.destroy', $enquiry->id],'id'=>'delete-form-'.$enquiry->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" 
                                                    data-bs-toggle="tooltip" 
                                                    title="{{__('Delete')}}" 
                                                    data-confirm="{{ __('Are You Sure?') }}" 
                                                    data-text="{{ __('This action can not be undone. Do you want to continue?') }}" 
                                                    data-confirm-yes="delete-form-{{ $enquiry->id }}">
                                                        <i class="ti ti-trash text-white"></i>
                                                    </a>
                                                    {!! Form::close() !!}
                                                </div>
                                            @endcan
                                        </div>
                                    </td>
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