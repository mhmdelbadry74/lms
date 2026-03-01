<div class="col-12">
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">{{ __('Products') }}</h3>
           
        </div>

        <div class="row g-4">
            @forelse ($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card h-100 product-card shadow-sm border-0 overflow-hidden">
                        <!-- Product Status Badges -->
                        <div class="position-absolute top-0 end-0 p-2 z-1">
                            @if ($product->created_at->diffInDays() < 7)
                                <span class="badge rounded-pill bg-success">
                                    <i class="fa fa-bolt me-1"></i> {{ __('New') }}
                                </span>
                            @endif
                            @if($product->is_special)
                                <span class="badge rounded-pill bg-warning text-dark mt-1">
                                    <i class="fa fa-star me-1"></i> {{ __('Special') }}
                                </span>
                            @endif
                        </div>

                        <!-- Product Image -->
                        <div class="product-img-container position-relative" style="height: 180px; background-color: #f8f9fa;">
                            @if ($product->img)
                                <img src="{{ asset($product->img) }}" 
                                     class="img-fluid h-100 w-100 object-fit-contain p-3"
                                     alt="{{ $product->name_en }}">
                            @else
                                <div class="d-flex justify-content-center align-items-center h-100 text-muted">
                                    <i class="fa fa-image fa-4x opacity-25"></i>
                                </div>
                            @endif
                            <div class="product-overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center opacity-0">
                                <a href="{{ route('admin.products.profile', $product->id) }}" 
                                   class="btn btn-primary rounded-pill px-4">
                                    <i class="fa fa-eye me-1"></i> {{ __('Quick View') }}
                                </a>
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="mb-0 text-truncate">{{ $product->name_en }}</h5>
                                    <small class="text-muted">{{ $product->name_ar }}</small>
                                </div>
                                <span class="badge bg-light text-dark">{{ $product->sku }}</span>
                            </div>

                            <!-- Categories -->
                            <div class="mb-3">
                                <div class="text-muted small mb-1">{{ __('Categories') }}</div>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse ($product->categories as $category)
                                        <span class="badge bg-primary bg-opacity-10  rounded-pill">{{ $category->name }}</span>
                                    @empty
                                        <span class="badge bg-light text-muted">{{ __('Uncategorized') }}</span>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Additional Info -->
                            <div class="d-flex justify-content-between small text-muted mb-3">
                                <span><i class="far fa-calendar-alt me-1"></i> {{ $product->created_at->format('M d, Y') }}</span>
                                <span><i class="fa fa-box me-1"></i> {{ $product->stock }} {{ __('in stock') }}</span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <div>
                                    @if($product->price)
                                        <span class="h5 text-primary">{{ format_currency($product->price) }}</span>
                                        @if($product->old_price)
                                            <del class="text-muted small ms-2">{{ format_currency($product->old_price) }}</del>
                                        @endif
                                    @endif
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('admin.products.editForm', $product->id) }}" 
                                       class="btn btn-sm btn-outline-secondary" 
                                       data-bs-toggle="tooltip" 
                                       title="{{ __('Edit') }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger delete-btn"
                                            data-id="{{ $product->id }}"
                                            data-name="{{ $product->name_en }}"
                                            data-bs-toggle="tooltip"
                                            title="{{ __('Delete') }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fa fa-box-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('No products found') }}</h5>
                            <a href="" class="btn btn-primary mt-3">
                                <i class="fa fa-plus me-1"></i> {{ __('Add New Product') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .product-card {
        transition: all 0.3s ease;
        border-radius: 0.75rem;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .product-img-container {
        overflow: hidden;
        position: relative;
    }
    .product-overlay {
        background: rgba(0,0,0,0.5);
        transition: opacity 0.3s ease;
    }
    .product-card:hover .product-overlay {
        opacity: 1;
    }
    .object-fit-contain {
        object-fit: contain;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize tooltips
    $(document).ready(function(){
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        // Delete button confirmation
        $('.delete-btn').click(function(){
            const productName = $(this).data('name');
            Swal.fire({
                title: '{{ __("Confirm Delete") }}',
                text: '{{ __("Are you sure you want to delete") }} ' + productName + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __("Yes, delete it") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit delete form
                    $('#delete-form-'+$(this).data('id')).submit();
                }
            });
        });
    });
</script>
@endpush