
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">{{ __('Product Variants') }}</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>{{ __('SKU') }}</th>
                        <th>{{ __('Slug') }}</th>
                        <th>{{ __('Attributes') }}</th>
                        <th class="text-right">{{ __('Retail Price') }}</th>
                        <th class="text-right">{{ __('Wholesale Price') }}</th>
                        <th class="text-right">{{ __('Min Qty') }}</th>
                        <th class="text-right">{{ __('Stock') }}</th>
                        <th class="text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($product->variants as $variant)
                        <tr>
                            <td>
                                <span class="badge badge-light">{{ $variant->sku }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $variant->slug }}</small>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    @foreach ($variant->attributeValues as $value)
                                        <div class="attribute-pill">
                                            <span class="attribute-name">
                                                {{ app()->getLocale() == 'en' 
                                                    ? ($value->attribute->name_en ?? $value->attribute->name_ar)
                                                    : $value->attribute->name_ar }}:
                                            </span>
                                            <span class="attribute-value">
                                                {{ $value->value[app()->getLocale()] ?? $value->value['en'] ?? '' }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-right font-weight-bold text-success">
                                {{ number_format($variant->retail_price, 2) }}
                            </td>
                            <td class="text-right font-weight-bold text-primary">
                                {{ number_format($variant->wholesale_price, 2) }}
                            </td>
                            <td class="text-right">
                                {{ $variant->wholesale_min_quantity }}
                            </td>
                            <td class="text-right">
                                <span class="badge {{ $variant->stock > 0 ? 'badge-success' : 'badge-danger' }} stock-badge">
                                    {{ $variant->stock }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <div class="btn-group">
                                        @can('update_product_type')
                                            <a href="" class="btn btn-sm btn-primary" title="{{ __('Edit') }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endcan
    
                                        @can('delete_product_type')
                                            <form action="{{ route('admin.productVariance.delete', $variant->id) }}"
                                                method="get" class="d-inline"
                                                onsubmit="return confirm('{{ __('Are you sure you want to delete this variant?') }}')">
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    title="{{ __('Delete') }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
    
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fa fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5 class="mb-1">{{ __('No variants available') }}</h5>
                                    <p class="text-muted">{{ __('Create your first variant to get started') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .attribute-pill {
        background-color: #f8f9fa;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .attribute-name {
        font-weight: 600;
        color: #495057;
    }

    .attribute-value {
        color: #6c757d;
    }

    .stock-badge {
        min-width: 40px;
        padding: 5px 8px;
        font-size: 0.85rem;
    }

    .empty-state {
        max-width: 300px;
        margin: 0 auto;
    }

    .table th, .table td {
        vertical-align: middle;
    }
</style>