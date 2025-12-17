@extends('layouts.admin')

@section('page-title')
    {{ __('Create Item Variant') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('item-variants.index') }}">{{ __('Item Variants') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create') }}</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Create New Variant') }}</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('item-variants.store') }}">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">{{ __('Description') }}</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    <a href="{{ route('item-variants.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection