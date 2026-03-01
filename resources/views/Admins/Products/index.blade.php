@extends('Admins.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Flash Messages -->
        <div class="row">
            @foreach (['success', 'error', 'warning', 'info'] as $msg)
                @if (session()->has($msg))
                    <div class="alert alert-{{ $msg }} alert-dismissible fade show" role="alert">
                        <i class="fa fa-{{ $msg === 'error' ? 'times-circle' : ($msg === 'warning' ? 'exclamation-triangle' : ($msg === 'info' ? 'info-circle' : 'check-circle')) }} me-2"></i>
                        {{ session($msg) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('Products Management') }}</h4>
                    <div class="page-title-right">
                        <a href="{{ route("admin.products.addForm") }}" class="btn btn-success">
                            <i class="fa fa-plus-circle me-1"></i> {{ __('Create Product') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Combined Products Grid with Search -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 text-muted">
                                <i class="fa fa-box me-2"></i>{{ __('Products') }}
                            </h4>
                            <div class="d-flex">
                                <span class="badge rounded-pill" style="background-color: #e9ecef; color: #6c757d;">
                                    {{ __('Total') }}: {{ $products->total() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search Form inside the card -->
                    <div class="card-body border-bottom" style="background-color: #f8f9fa;">
                        <form method="get" action="{{ route('admin.products.search') }}" class="needs-validation" novalidate>
                            <div class="row g-3">
                                <!-- Name Section -->
                                <div class="col-md-3">
                                    <label class="form-label text-muted">{{ __('Arabic Name') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fa fa-font text-muted"></i></span>
                                        <input type="text" class="form-control border-start-0" name="name_ar" value="{{ request('name_ar') }}" placeholder="{{ __('Enter arabic name...') }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label text-muted">{{ __('English Name') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fa fa-font text-muted"></i></span>
                                        <input type="text" class="form-control border-start-0" name="name_en" value="{{ request('name_en') }}" placeholder="{{ __('Enter english name...') }}">
                                    </div>
                                </div>

                                <!-- Description Section -->
                                <div class="col-md-3">
                                    <label class="form-label text-muted">{{ __('Arabic description') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fa fa-align-left text-muted"></i></span>
                                        <textarea class="form-control border-start-0" rows="1" name="description_ar" placeholder="{{ __('Enter arabic description...') }}">{{ request('ar_description') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label text-muted">{{ __('English description') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fa fa-align-left text-muted"></i></span>
                                        <textarea class="form-control border-start-0" rows="1" name="description_en" placeholder="{{ __('Enter english description...') }}">{{ request('en_description') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-2" style="background-color: #6f42c1; border-color: #6f42c1;">
                                            <i class="fa fa-search me-1"></i> {{ __('search') }}
                                        </button>
                                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                            <i class="fa fa-times me-1"></i> {{ __('Reset') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Products Grid -->
                    <div class="card-body">
                        @if ($products->count())
                            <div class="row">
                                @foreach ($products as $product)
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100 product-card">
                                            <div class="card-header bg-light">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h5 class="mb-0">{{ $product->name_en }}</h5>
                                                        <small class="text-muted">{{ $product->name_ar }}</small>
                                                    </div>
                                                    @if($product->created_at->diffInDays() < 7)
                                                        <span class="badge bg-success">{{ __('New') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <div class="img-container text-center mb-3">
                                                    @if($product->img)
                                                        <img src="{{ asset($product->img) }}" class="img-fluid rounded" style="max-height: 150px; object-fit: contain;" alt="{{ $product->name_en }}" />
                                                    @else
                                                        <div class="placeholder-image">
                                                            <i class="fa fa-image fa-3x text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <div class="text-muted mb-2">{{ __('Categories') }}:</div>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @forelse ($product->Categories()->get() as $category)
                                                            @if (app()->getLocale()=="ar")
                                                                <span class="text-dark">{{ $category->name_ar }}</span>
                                                            @else
                                                            <span class="text-dark">{{ $category->name_en }}</span>

                                                            @endif
                                                        @empty
                                                            <span class="badge bg-light text-dark">{{ __('No categories') }}</span>
                                                        @endforelse
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-auto">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <small class="text-muted">
                                                            <i class="fa fa-clock me-1"></i>
                                                            {{ $product->created_at->diffForHumans() }}
                                                        </small>
                                                        <div class="btn-group btn-group-sm">
                                                            @include('Admins.layout.dicountRules', ["button_name" => __('add discount rules'), "model" => "App\Models\Product", "model_id" => $product->id, "discount_conditions" => App\Enums\DiscountConditionEnum::PRODUCT->value])
                                                            <a href="{{ route("admin.products.profile", $product->id) }}" 
                                                               class="btn btn-outline-primary"
                                                               data-bs-toggle="tooltip"
                                                               title="{{ __('View') }}">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route("admin.products.editForm", $product->id) }}" 
                                                               class="btn btn-outline-primary"
                                                               data-bs-toggle="tooltip"
                                                               title="{{ __('Edit') }}">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a href="{{ route('admin.products.delete',$product->id) }}" 
                                                                    class="btn btn-danger delete-btn"
                                                                    data-name="{{ $product->name_en }}" 
                                                                    data-id="{{ $product->id }}"
                                                                    data-bs-toggle="tooltip"
                                                                    title="{{ __('Delete') }}">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fa fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">{{ __('No products found') }}</h5>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if ($products->hasPages())
                        <div class="card-footer bg-white border-top-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    {{ __('Showing') }} 
                                    <strong>{{ $products->firstItem() }}</strong> 
                                    {{ __('to') }} 
                                    <strong>{{ $products->lastItem() }}</strong> 
                                    {{ __('of') }} 
                                    <strong>{{ $products->total() }}</strong> 
                                    {{ __('entries') }}
                                </div>
                                <div>
                                    {{ $products->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dc3545;">
                    <h5 class="modal-title text-white" id="deleteModalLabel">
                        <i class="fa fa-exclamation-triangle me-2"></i>{{ __('Confirm Deletion') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this product?') }}</p>
                    <p class="mb-0">
                        <strong id="product-name" class="text-danger"></strong>
                    </p>
                    <small class="text-muted">{{ __('This action cannot be undone.') }}</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i>{{ __('Cancel') }}
                    </button>
                    <form id="delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash-alt me-1"></i>{{ __('Delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .product-card {
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .img-container {
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
        }

        .placeholder-image {
            width: 100%;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
        }

        .avatar-sm {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .avatar-title {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }
        
        .bg-soft-primary {
            background-color: rgba(85, 110, 230, 0.25) !important;
            color: #556ee6;
        }
    </style>
@endpush

@section('scripts')
    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            $('.delete-btn').click(function() {
                const productId = $(this).data('id');
                const productName = $(this).data('name');
                const deleteUrl = "{{ route('admin.products.delete', ':id') }}".replace(':id', productId);
                
                $('#product-name').text(productName);
                $('#delete-form').attr('action', deleteUrl);
                $('#deleteModal').modal('show');
            });

            (function() {
                'use strict'
                const forms = document.querySelectorAll('.needs-validation')

                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
            })()
        });
    </script>
@endsection