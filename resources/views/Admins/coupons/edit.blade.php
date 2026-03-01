@extends('Admins.layout.master')
@section('content')
    <div class="container-fluid">
        <div class="content-wrpper">
            <div class="row">
                @include("Admins.layout.parts.alert")
                <div class="col-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('Update Coupon') }}</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST"action="{{ route('admin.coupons.update',$coupon->id) }}">
                                @csrf
                                <div class="row">
                                    <!-- Coupon Code -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code">{{ __('Coupon Code') }}</label>
                                            <input type="text" name="coupon_code"
                                                class="form-control @error('coupon_code') is-invalid @enderror"value="{{ $coupon->coupon_code }}" id="code"
                                                  >
                                            @error('coupon_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Arabic Name -->
                                   

                                    <!-- English Name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ __('Name') }}</label>
                                            <input type="text"
                                                class="form-control @error('name_en') is-invalid @enderror" name="name"value="{{ $coupon->name }}"id="name_en"
                                                placeholder="{{ __('Name') }}"
                                                required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type">{{__("Coupon Type")}}</label>
                                            <select name="type" id="type" 
                                                        class="form-control @error('type') is-invalid @enderror" required>
                                                <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>
                                                    {{ __("fixed") }}
                                                </option>
                                                <option value="percentage" {{ $coupon->type == 'percentage'? 'selected' : '' }}>
                                                    {{ __("percentage") }}
                                                </option>
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Finish At -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="finish_at">{{ __('Finish On') }}</label>
                                            <input type="datetime-local" name="ends_at"
                                                class="form-control @error('finish_ends_at') is-invalid @enderror" id="finish_at"
                                                placeholder="{{ __('Finish On') }}" value="{{ $coupon->ends_at}}"
                                                required>
                                            @error('finish_ends_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="is_active" 
                                                        name="is_active" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_active">{{ __('Active') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="is_flash_sale" 
                                                        name="is_flash_sale" {{ old('is_flash_sale', $coupon->is_flash_sale) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_flash_sale">{{ __('Flash Sale') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Discount -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="amount">{{ __('Amount') }}</label>
                                            <input type="number" name="amount"
                                                class="form-control @error('amount') is-invalid @enderror" id="amount"
                                                placeholder="{{ __('Amount') }}" min="0" max="100"
                                                value="{{ $coupon->amount }}" required>
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Valid From -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="valid_from">{{ __('Valid From') }}</label>
                                            <input type="datetime-local" name="starts_at"
                                                class="form-control @error('valid_from') is-invalid @enderror"
                                                id="valid_from" placeholder="{{ __('Valid From') }}"
                                                value="{{$coupon->starts_at}}" required>
                                            @error('valid_from')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Usage Limit -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="usage_limit">{{ __('Usage Limit') }}</label>
                                            <input type="number" name="usage_limit"
                                                class="form-control @error('usage_limit') is-invalid @enderror"
                                                id="usage_limit"  min="1"
                                                value="{{  $coupon->usage_limit}}" required>
                                            @error('usage_limit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                                        <div class="button-group">
                                            <button class="btn btn-success" type="submit"><i class="fa fa-plus"></i>
                                                {{ __('update') }}</button>
                                            <button class="btn btn-warning" type="reset"><i class="fa fa-undo"></i>
                                                {{ __('Reset') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const validFrom = document.getElementById('valid_from');
        const finishAt = document.getElementById('finish_at');

        validFrom.addEventListener('change', function() {
            finishAt.min = this.value;
        });

        finishAt.addEventListener('change', function() {
            if (validFrom.value && this.value < validFrom.value) {
                this.setCustomValidity('End date must be after start date');
            } else {
                this.setCustomValidity('');
            }
        });
    });
</script>
