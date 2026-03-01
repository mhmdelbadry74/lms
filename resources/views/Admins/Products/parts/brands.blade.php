<!-- CSS -->

<!-- JS -->
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('brand') }}</h3>
        </div>
        <div class="card-body">
            <h4 class="text-center">
                @if ($product->brand)
                    @if (app()->getLocale() == 'en')
                        <a href="{{ route('admin.brand.show', $product->brand?->id) }}"
                            class="btn btn-success">{{ $product->brand->name_en }}</a>
                    @else
                        <a href="{{ route('admin.brand.show', $product->brand?->id) }}"
                            class="btn btn-success">{{ $product->brand->name_ar }}</a>
                    @endif
                @endif

            </h4>
            <form action="{{ route('admin.products.assignBrandToProduct', $product->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="brand">{{ __('Brand') }}</label>
                    <select class="form-control" id="brand" name="brand_id">
                        <option value="">{{ __('Select') }}</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">
                                @if (app()->getLocale() == 'en')
                                    {{ $brand->name_en }}
                                @else
                                    {{ $brand->name_ar }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-info"type="submit">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Alternative CDN -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    $(documnet).ready(function() {
        new TomSelect("#brand", {
            plugins: ['remove_button'],
            create: true,
            maxItems: 1
        });
    });
</script>
