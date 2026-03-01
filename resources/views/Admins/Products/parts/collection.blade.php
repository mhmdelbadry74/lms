<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Collections') }}</h3>
        </div>
        <div class="card-body">
            <!-- Current Collections -->
            <div class="mb-4">
                <h5>{{ __('Current Collections') }}</h5>
                @if($product->collections->count() > 0)
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($product->collections as $collection)
                            <span class="badge badge-primary">
                                @if(app()->getLocale()=="ar")
                                    {{ $collection->name_ar }}
                                @else
                                    {{ $collection->name_en }}
                                @endif
                                <form action="{{ route('admin.products.RemoveProductToCollection',["product_id"=>$product->id,"collection"=>$collection->id]) }}" 
                                      method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-xs btn-link text-white" 
                                            onclick="return confirm('{{ __('Remove from this collection?') }}')">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </form>
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">{{ __('This product is not in any collections') }}</p>
                @endif
            </div>

            <!-- Add to Collections -->
            <div>
                <h5>{{ __('Add to Collections') }}</h5>
                <form action="{{ route("admin.products.AddProductToCollection",$product->id) }}" method="POST">
                    @csrf
                    <select name="collections[]" id="collections-select" class="form-control" multiple>
                        @foreach($allCollections as $collection)
                            <option value="{{ $collection->id }}" 
                                {{ $product->collections->contains($collection->id) ? 'disabled' : '' }}>
                                @if (app()->getLocale() =="en")
                                    {{ $collection->name_en }}
                                @else
                                    {{ $collection->name_ar }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="fa fa-plus"></i> {{ __('Add to Selected Collections') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect('#collections-select', {
        plugins: ['remove_button'],
        create: false,
        maxItems: null,
        render: {
            option: function(data, escape) {
                return '<div>' + escape(data.text) + '</div>';
            },
            item: function(data, escape) {
                return '<div>' + escape(data.text) + '</div>';
            }
        }
    });
</script>
