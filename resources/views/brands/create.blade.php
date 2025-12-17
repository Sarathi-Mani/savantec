@extends('layouts.admin')

@section('page-title')
    {{ __('Create Brand') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('brands.index') }}">{{ __('Brands') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">{{ __('Add New Brand') }}</h5>
                        <a href="{{ route('brands.index') }}" class="btn btn-sm btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i> {{ __('Back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('brands.store') }}" id="brandForm">
                        @csrf
                        
                        <!-- Simple Form with only 2 inputs -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Brand Name -->
                                <div class="form-group mb-4">
                                    <label for="name" class="form-label">
                                        <strong>{{ __('Brand Name') }} <span class="text-danger">*</span></strong>
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" required 
                                           placeholder="Enter brand name" 
                                           value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{ __('Enter the name of the brand (e.g., Apple, Samsung, Nike)') }}
                                    </small>
                                </div>

                                <!-- Brand Description -->
                                <div class="form-group mb-4">
                                    <label for="description" class="form-label">
                                        <strong>{{ __('Description') }}</strong>
                                    </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" 
                                              rows="5" 
                                              placeholder="Enter brand description (optional)">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{ __('Describe the brand, its products, quality, etc.') }}
                                    </small>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group mt-5">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('brands.index') }}" class="btn btn-secondary px-4">
                                            <i class="ti ti-x me-1"></i> {{ __('Cancel') }}
                                        </a>
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="ti ti-check me-1"></i> {{ __('Create Brand') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 0.95rem;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }
    
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: none;
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 1rem 1.5rem;
        border-bottom: none;
    }
    
    .card-title {
        color: white;
        font-weight: 600;
        font-size: 1rem;
        margin: 0;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(16, 185, 129, 0.4);
    }
    
    .btn-secondary {
        border: 1px solid #e2e8f0;
        background: white;
        color: #4a5568;
    }
    
    .btn-secondary:hover {
        background: #f8f9fa;
        border-color: #cbd5e0;
    }
    
    .form-text {
        font-size: 0.8rem;
        color: #718096;
        margin-top: 4px;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        
        .btn {
            padding: 8px 16px;
            font-size: 0.9rem;
        }
        
        .form-control {
            padding: 10px 12px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Form validation
        $('#brandForm').on('submit', function(e) {
            let isValid = true;
            
            // Check brand name
            const brandName = $('#name').val().trim();
            if (!brandName) {
                $('#name').addClass('is-invalid');
                $('#name').next('.invalid-feedback').remove();
                $('#name').after('<div class="invalid-feedback">Brand name is required</div>');
                isValid = false;
            } else {
                $('#name').removeClass('is-invalid');
            }
            
            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                $('html, body').animate({
                    scrollTop: $('.is-invalid').first().offset().top - 100
                }, 500);
            }
        });
        
        // Remove validation on input
        $('#name').on('input', function() {
            $(this).removeClass('is-invalid');
        });
        
        // Auto-focus on brand name field
        $('#name').focus();
        
        // Character counter for description (optional)
        $('#description').on('input', function() {
            const length = $(this).val().length;
            const counter = $(this).next('.char-counter');
            if (counter.length === 0) {
                $(this).after('<small class="char-counter text-muted float-end mt-1">0/500</small>');
            }
            $(this).next('.char-counter').text(length + '/500');
        });
    });
</script>
@endpush