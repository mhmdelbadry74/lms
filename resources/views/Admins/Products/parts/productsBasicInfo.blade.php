<div class="card mb-4 col-md-12">
    <div class="card-body text-center">
        <div class="product-image-container mb-4">
            <img src="{{ asset($product->img) }}" class="img-fluid rounded border"
                alt="{{ $product->name_en }}" style="max-height: 300px;">
        </div>

        <!-- Basic Info Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="30%">{{ __('Arabic Name') }}</th>
                        <td>{{ $product->name_ar }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('English Name') }}</th>
                        <td>{{ $product->name_en }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Categories') }}</th>
                        <td>
                            @foreach ($product->categories as $category)
                                <span class="badge badge-primary mr-1 mb-1">
                                    @if (app()->getLocale()=="ar")
                                        {{ $category->name_ar }}
                                    @else
                                        {{ $category->name_en }}
                                    @endif
                                </span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('created at') }}</th>
                        <td>{{ $product->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('updated at') }}</th>
                        <td>{{ $product->updated_at->format('Y-m-d H:i') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Description -->
        @if ($product->description)
            <div class="mt-3">
                <h5>{{ __('Description') }}</h5>
                <div class="border p-3 rounded">
                    @if (app()->getLocale() == 'ar')
                        {{ $product->description_ar }}
                    @else
                        {{ $product->description_en }}
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
<div class='card  mb-4 col-md-12'>
    <div class='card-header'>
        <h3 class='card-title'>{{__("description")}}</h3>
    </div>
    <div class='card-body'>
        @if (app()->getLocale()=="en")
            {!! $product->description_en !!}
        @else
            {!! $product->description_ar !!}
        @endif
    </div>
</div>