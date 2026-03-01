@extends('Admins.layout.master')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
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
        <div class="page-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 text-gray-800">{{ __('Product Profile') }}</h1>
                <div>
                    <a href="{{ route('admin.products.editForm', $product->id) }}" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fa fa-edit"></i>
                        </span>
                        <span class="text">{{ __('Edit Product') }}</span>
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-icon-split ml-2">
                        <span class="icon text-white-50">
                            <i class="fa fa-arrow-left"></i>
                        </span>
                        <span class="text">{{ __('Back to List') }}</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                @include('Admins.Products.parts.features')
                @include('Admins.Products.parts.brands')
                @include('Admins.Products.parts.collection')
            </div>
            <!-- Left Column -->
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <!-- Product Basic Info Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">{{ __('Basic Information') }}</h6>
                        <span class="badge badge-light">{{ $product->sku }}</span>
                    </div>
                    @include('Admins.Products.parts.productsBasicInfo')
                </div>
                
                    @include('Admins.Products.parts.mediaManagement')

                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-warning text-dark">
                        <h6 class="m-0 font-weight-bold">{{ __('Product Variants') }}</h6>
                        <button id="toggleVariantForm" class="btn btn-dark btn-sm">
                            <i class="fa fa-plus"></i> {{ __('Add Variant') }}
                        </button>
                    </div>
                    <div class="card-body">
                        @include('Admins.Products.parts.addvariants')
                    </div>

                </div>
                @include('Admins.Products.parts.variants')

            </div>

            <!-- Right Column -->
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

            </div>

        </div>
    </div>


@endsection

@push('styles')
    <style>
        .page-header {
            padding: 1rem;
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            border-radius: 0.35rem;
            margin-bottom: 1.5rem;
        }

        .card {
            border: none;
            border-radius: 0.35rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            transform: translateY(-2px);
        }

        .card-header {
            border-radius: 0.35rem 0.35rem 0 0 !important;
        }

        .gallery-thumbnail {
            height: 120px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-thumbnail:hover {
            transform: scale(1.05);
        }

        .variant-row {
            transition: background-color 0.2s ease;
        }

        .variant-row:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }

        .custom-file-label::after {
            content: "{{ __('Browse') }}";
        }

        .badge {
            font-size: 0.85rem;
            font-weight: 600;
        }

        .product-image-main {
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
            padding: 0.5rem;
            background: white;
            max-height: 400px;
            object-fit: contain;
        }
    </style>
@endpush
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
@push('scripts')
    <script>
        $(document).ready(function() {
            // Toggle variant form
            $('#toggleVariantForm').click(function() {
                $('#variantFormContainer').slideToggle();
            });

            // Cancel variant form
            $('#cancelVariantForm').click(function() {
                $('#variantFormContainer').slideUp();
            });

            // Update file input label
            $('#gallery-media').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                let label = $(this).next('.custom-file-label');

                if ($(this)[0].files.length > 1) {
                    label.text($(this)[0].files.length + ' {{ __('files selected') }}');
                } else {
                    label.text(fileName);
                }
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Media upload modal handling
            $('#uploadMediaBtn').click(function() {
                // Add your media upload logic here
                alert('Media upload functionality would be implemented here');
                $('#mediaUploadModal').modal('hide');
            });

            // Make variant rows clickable
            $('.variant-row').click(function() {
                window.location = $(this).data('url');
            }).css('cursor', 'pointer');
        });
    </script>
@endpush
<!-- Alternative CDN -->
