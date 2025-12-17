@extends('layouts.admin')

@section('page-title')
    {{ __('Edit Category') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">{{ __('Categories') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">{{ __('Edit Category') }}</h5>
                        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i> {{ __('Back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('categories.update', $category->id) }}" id="categoryForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Simple Form with only 2 inputs -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Category Name -->
                                <div class="form-group mb-4">
                                    <label for="name" class="form-label">
                                        <strong>{{ __('Category Name') }} <span class="text-danger">*</span></strong>
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" required 
                                           placeholder="Enter category name" 
                                           value="{{ old('name', $category->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{ __('Enter the name of the category (e.g., Electronics, Clothing, Furniture)') }}
                                    </small>
                                </div>

                                <!-- Category Description -->
                                <div class="form-group mb-4">
                                    <label for="description" class="form-label">
                                        <strong>{{ __('Description') }}</strong>
                                    </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" 
                                              rows="5" 
                                              placeholder="Enter category description (optional)">{{ old('description', $category->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{ __('Describe the category, types of products, etc.') }}
                                    </small>
                                </div>

                                <!-- Additional Info (Read-only) -->
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <strong>{{ __('Additional Information') }}</strong>
                                    </label>
                                  
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group mt-5">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a href="{{ route('categories.index') }}" class="btn btn-secondary px-4 me-2">
                                                <i class="ti ti-x me-1"></i> {{ __('Cancel') }}
                                            </a>
                                            @if(\Auth::user()->can('item_category_delete'))
                                                <button type="button" class="btn btn-danger px-4" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                    <i class="ti ti-trash me-1"></i> {{ __('Delete') }}
                                                </button>
                                            @endif
                                        </div>
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="ti ti-check me-1"></i> {{ __('Update Category') }}
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

    <!-- Delete Confirmation Modal -->
    @if(\Auth::user()->can('item_category_delete'))
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ __('Delete Category') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this category?') }}</p>
                    <p class="text-danger"><strong>{{ __('Warning:') }}</strong> {{ __('This action cannot be undone.') }}</p>
                    
                    @php
                        $itemCount = \App\Models\Items::where('category', $category->name)
                            ->where('created_by', Auth::user()->creatorId())
                            ->count();
                    @endphp
                    
                    @if($itemCount > 0)
                        <div class="alert alert-warning mt-3">
                            <i class="ti ti-alert-triangle me-2"></i>
                            {{ __('This category is being used in :count items. You cannot delete it until you remove or reassign these items.', ['count' => $itemCount]) }}
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    @if($itemCount == 0)
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">{{ __('Delete Category') }}</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
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
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border: none;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
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
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(239, 68, 68, 0.4);
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
    
    .badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
    }
    
    .text-primary {
        color: #3b82f6 !important;
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
        
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 10px;
        }
        
        .d-flex.justify-content-between > div {
            width: 100%;
            display: flex;
            gap: 10px;
        }
        
        .d-flex.justify-content-between > div .btn {
            flex: 1;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Form validation
        $('#categoryForm').on('submit', function(e) {
            let isValid = true;
            
            // Check category name
            const categoryName = $('#name').val().trim();
            if (!categoryName) {
                $('#name').addClass('is-invalid');
                $('#name').next('.invalid-feedback').remove();
                $('#name').after('<div class="invalid-feedback">Category name is required</div>');
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
        
        // Auto-focus on category name field
        $('#name').focus();
        
        // Character counter for description
        $('#description').on('input', function() {
            const length = $(this).val().length;
            const counter = $(this).next('.char-counter');
            if (counter.length === 0) {
                $(this).after('<small class="char-counter text-muted float-end mt-1">0/1000</small>');
            }
            $(this).next('.char-counter').text(length + '/1000');
        });
        
        // Initialize character counter on page load
        const descLength = $('#description').val().length;
        $('#description').after('<small class="char-counter text-muted float-end mt-1">' + descLength + '/1000</small>');
        
        // Delete modal confirmation
        $('#deleteModal').on('show.bs.modal', function(event) {
            // Any additional logic before showing delete modal
        });
    });
</script>
@endpush