@extends('Admins.layout.master')
@section('content')
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __("Details") }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">{{ __("ID") }}</label>
                                            <input type="text" class="form-control" id="name" value="{{ $brand->id }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group" style="max-width: 200px">
                                            <img src="{{ asset($brand->image) }}"
                                            class="img-thumbnail h-100 w-100 object-fit-cover"
                                            style="object-fit: cover;" alt="{{ $brand->name }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">{{ __("Arabic Name") }}</label>
                                            <input type="text" class="form-control" id="name" value="{{ $brand->name_ar }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">{{ __("English Name") }}</label>
                                            <input type="text" class="form-control" id="name" value="{{ $brand->name_en }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">{{ __("Arabic Description") }}</label>
                                            <textarea class='form-control'readonly>{{ $brand->description_ar }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">{{ __("English Description") }}</label>
                                            <textarea class='form-control'readonly>{{ $brand->description_en }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include("Admins.brands.parts.products")
        </div>
    </div>
</div>
@endsection