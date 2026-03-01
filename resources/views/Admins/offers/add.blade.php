@extends('Admins.layout.master')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-tag"></i> {{__("Add Offer")}}</h3>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form action="{{ route('admin.offers.store') }}" method="POST" class="row">
                            @csrf
                            
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <label for="name_ar">{{__("Arabic Name")}} <span class="text-danger">*</span></label>
                                <input type="text" name="name_ar" id="name_ar" class="form-control @error('name_ar') is-invalid @enderror" 
                                       placeholder="{{__("Arabic Name")}}" value="{{ old('name_ar') }}" required>
                                @error('name_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <label for="name_en">{{__("English Name")}} <span class="text-danger">*</span></label>
                                <input type="text" name="name_en" id="name_en" class="form-control @error('name_en') is-invalid @enderror" 
                                       placeholder="{{__("English Name")}}" value="{{ old('name_en') }}" required>
                                @error('name_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <label for="price">{{__("Price")}} <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror" 
                                       placeholder="{{__("Price")}}" value="{{ old('price') }}" required>
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <label for="expire_date">{{__("Expire Date")}} <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="expire_date" id="expire_date" 
                                       class="form-control @error('expire_date') is-invalid @enderror" 
                                       value="{{ old('expire_date') }}" required>
                                @error('expire_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-12">
                                <label for="description_ar">{{__("Arabic Description")}} <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description_ar') is-invalid @enderror" 
                                          name="description_ar" id="description_ar" rows="5">{{ old('description_ar') }}</textarea>
                                @error('description_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-12">
                                <label for="description_en">{{__("English Description")}} <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description_en') is-invalid @enderror" 
                                          name="description_en" id="description_en" rows="5">{{ old('description_en') }}</textarea>
                                @error('description_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> {{__("Save Offer")}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection