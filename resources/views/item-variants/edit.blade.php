@extends('layouts.admin')

@section('page-title')
    {{ __('Edit Item Variant') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('item-variants.index') }}">{{ __('Item Variants') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="ti ti-edit me-2"></i>{{ __('Edit Item Variant') }}
                        </h5>
                        <a href="{{ route('item-variants.index') }}" class="btn btn-sm btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>{{ __('Back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('item-variants.update', $itemVariant->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="form-label">{{ __('Variant Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $itemVariant->name) }}" 
                                           placeholder="{{ __('Enter variant name') }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="description" class="form-label">{{ __('Description') }}</label>
                                    <textarea name="description" id="description" 
                                              class="form-control @error('description') is-invalid @enderror" 
                                              rows="4" 
                                              placeholder="{{ __('Enter variant description (optional)') }}">{{ old('description', $itemVariant->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-12 mt-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-check me-1"></i> {{ __('Update Variant') }}
                                    </button>
                                  
                                    <a href="{{ route('item-variants.index') }}" class="btn btn-outline-secondary">
                                        <i class="ti ti-x me-1"></i> {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @foreach($errors->all() as $error)
                    toastr.error('{{ $error }}');
                @endforeach
            });
        </script>
    @endif
@endsection