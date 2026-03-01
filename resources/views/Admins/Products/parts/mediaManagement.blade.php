<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">{{ __('Product Media') }}</h5>
    </div>
    <div class="card-body">
        <div class="row" id="product-gallery">
            @foreach ($product->getMedia('product_img') as $media)
                <div class="col-md-4 col-6 mb-3 gallery-item" data-media-id="{{ $media->id }}">
                    <div class="card h-100">
                        @if (str_contains($media->mime_type, 'video'))
                            <video class="card-img-top"
                                style="height: 120px; object-fit: cover;"controls>
                                <source src="{{ $media->getUrl() }}"
                                    type="{{ $media->mime_type }}">
                            </video>
                        @else
                            <img src="{{ $media->getUrl() }}" class="card-img-top"
                                style="height: 120px; object-fit: cover;">
                        @endif
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between">
                                <small class="text-muted text-truncate">{{ $media->name }}</small>
                            </div>
                        </div>
                        <a class="btn btn-danger btn-sm delete-media"
                            href="{{ route('admin.products.destroymedia', ['product_id' => $product->id, 'media_id' => $media->id]) }}">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Upload Form -->
        <div class="mt-3">
            <form id="gallery-upload-form"
                action="{{ route('admin.products.uploadMedia', $product->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="gallery-media"
                        name="media" multiple accept="image/*, video/*">
                    <label class="custom-file-label"
                        for="gallery-media">{{ __('Choose files (images or videos)') }}</label>
                </div>
                <button type="submit" class="btn btn-primary mt-2 btn-sm">
                    <i class="fa fa-upload"></i> {{ __('Upload') }}
                </button>
            </form>
        </div>
    </div>
</div>