@extends('Admins.layout.master')
@section('content')
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0">{{ __('Collection Details') }}</h3>
                            <a href="{{ route('admin.collection.index') }}" class="btn btn-light btn-sm">
                                <i class="fa fa-arrow-left mr-1"></i> {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-info text-white">
                                        <h4 class="mb-0">{{ __('Basic Information') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="30%">{{ __('ID') }}</th>
                                                <td>{{ $collection->id }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Arabic Name') }}</th>
                                                <td>{{ $collection->name_ar }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('English Name') }}</th>
                                                <td>{{ $collection->name_en }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Description') }}</th>
                                                <td>{{ $collection->description_en }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Status') }}</th>
                                                <td>
                                                    <span class="badge badge-{{ $collection->is_active ? 'success' : 'danger' }}">
                                                        {{ $collection->is_active ? __('Active') : __('Inactive') }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('Show in Header') }}</th>
                                                <td>
                                                    <span class="badge badge-{{ $collection->is_featured ? 'success' : 'danger' }}">
                                                        {{ $collection->is_featured ? __('Yes') : __('No') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Products in Collection -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h4 class="mb-0">{{ __('Products in Collection') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        @if($collection->products()->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('ID') }}</th>
                                                            <th>{{ __('Name') }}</th>
                                                            <th>{{ __('Actions') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($collection->products as $product)
                                                        <tr>
                                                            <td>{{ $product->id }}</td>
                                                            <td>
                                                                @if (app()->getLocale="en")
                                                                    {{ $product->name_en }}
                                                                @else
                                                                    {{ $product->name_en }}


                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('admin.products.profile', $product->id) }}" 
                                                                   class="btn btn-sm btn-primary" title="{{ __('View') }}">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-warning">
                                                {{ __('No products found in this collection.') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.collection.edit', $collection->id) }}" 
                               class="btn btn-warning mr-2">
                                <i class="fa fa-edit mr-1"></i> {{ __('Edit') }}
                            </a>
                            <form action="{{ route('admin.collection.destroy', $collection->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('{{ __('Are you sure you want to delete this collection?') }}')">
                                    <i class="fa fa-trash mr-1"></i> {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection