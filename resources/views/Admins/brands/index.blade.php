@extends('Admins.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Display success message -->
        @if (session('success'))
            <div class="alert alert-success mb-4">
                <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Display form errors -->
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12">
                    @include('Admins.brands.parts.search')
                </div>
                <div class="col-12 card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('brands') }}</h3>
                        @include('Admins.brands.parts.add')
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Arabic Name') }}</th>
                                    <th>{{ __('English Name') }}</th>
                                    <th>{{ __('image') }}</th>
                                    <th>{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $brand)
                                    <tr>
                                        <td>{{ $brand->name_en }}</td>

                                        <td>{{ $brand->name_ar }}</td>
                                        <td style="width: 100px; height: 100px;">
                                            <img src="{{ asset($brand->image) }}"
                                                class="img-thumbnail h-100 w-100 object-fit-cover"
                                                style="object-fit: cover;" alt="{{ $brand->name }}">
                                        </td>
                                        <td class="d-flex align-items-center gap-2">
                                            @include('Admins.layout.dicountRules',["button_name" => __('add discount rules'), "model" => "App\Models\Brand", "model_id" => $brand->id, "discount_conditions" => App\Enums\DiscountConditionEnum::BRAND->value])
                                            <a href="{{ route('admin.brand.show',$brand->id) }}"class="btn btn-info"><i class='fa fa-eye'></i></a>
                                            @include('Admins.brands.parts.update')
                                            <form action="{{ route('admin.brand.destroy', $brand->id) }}" method="post"
                                                class="m-0"
                                                onsubmit="return confirm('Are you sure to delete this brand?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger px-3 py-1">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
