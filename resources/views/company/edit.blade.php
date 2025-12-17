@extends('layouts.admin')

@section('page-title')
    {{__('Edit Company')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('company.index')}}">{{__('Company')}}</a></li>
    <li class="breadcrumb-item">{{__('Edit')}}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{__('Edit Company')}}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('company.update', $company->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">{{ __('Company Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $company->name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $company->email) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile" class="form-label">{{ __('Mobile') }}</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile', $company->mobile) }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-end mt-4">
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            <a href="{{ route('company.index') }}" class="btn btn-secondary">{{ __('Close') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection