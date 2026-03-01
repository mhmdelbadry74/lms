@extends('Admins.layout.master')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include('Admins.layout.parts.alert')
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-0">{{ __('Add New Offer') }}</h5>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="{{ route('admin.offers.index') }}" class="btn btn-light btn-sm">
                                    <i class="fa fa-arrow-left"></i> {{ __('Back') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.coupons.store') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('Discount Name') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="coupon_code">{{ __('Coupon Code') }}</label>
                                        <div class="input-group">
                                            <input type="text" name="coupon_code" id="coupon_code" 
                                                   class="form-control @error('coupon_code') is-invalid @enderror" 
                                                   value="{{ old('coupon_code') }}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary" id="generate-code">
                                                    <i class="fa fa-random"></i> {{ __('Generate') }}
                                                </button>
                                            </div>
                                        </div>
                                        @error('coupon_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="amount">{{ __('Amount') }} <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" name="amount" id="amount" 
                                                       class="form-control @error('amount') is-invalid @enderror" 
                                                       value="{{ old('amount', null) }}" required min="0">
                                                @error('amount')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="type">{{ __('Type') }} <span class="text-danger">*</span></label>
                                                <select name="type" id="type" 
                                                        class="form-control @error('type') is-invalid @enderror" required>
                                                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>
                                                        {{ __("fixed") }}
                                                    </option>
                                                    <option value="percentage" {{ old('type') == 'percentage'? 'selected' : '' }}>
                                                        {{ __("percentage") }}
                                                    </option>
                                                </select>
                                                @error('type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div class=" col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_active" 
                                                    name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_active">{{ __('Active') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_flash_sale" 
                                                    name="is_flash_sale" value="1" {{ old('is_flash_sale') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_flash_sale">{{ __('Flash Sale') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Dates & Limits -->
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="starts_at">{{ __('Start Date') }} <span class="text-danger">*</span></label>
                                                <input type="datetime-local" name="starts_at" id="start_at" 
                                                       class="form-control @error('starts_at') is-invalid @enderror" 
                                                       value="{{ old('starts_at') }}" required>
                                                @error('start_at')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ends_at">{{ __('End Date') }} <span class="text-danger">*</span></label>
                                                <input type="datetime-local" name="ends_at" id="ends_at" 
                                                       class="form-control @error('ends_at') is-invalid @enderror" 
                                                       value="{{ old('ends_at') }}" required>
                                                @error('end_at')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="usage_limit">{{ __('Usage Limit') }}</label>
                                        <input type="number" name="usage_limit" id="usage_limit" 
                                               class="form-control @error('usage_limit') is-invalid @enderror" 
                                               value="{{ old('usage_limit') }}" min="1">
                                        <small class="text-muted">{{ __('Leave empty for unlimited usage') }}</small>
                                        @error('usage_limit')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fa fa-save"></i> {{ __('Save Offer') }}
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate random coupon code
    document.getElementById('generate-code').addEventListener('click', function() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let result = '';
        for (let i = 0; i < 8; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('coupon_code').value = result;
    });

    // Set default dates if not provided
    const now = new Date();
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    if (!document.getElementById('start_at').value) {
        document.getElementById('start_at').value = now.toISOString().slice(0, 16);
    }
    
    if (!document.getElementById('end_at').value) {
        document.getElementById('end_at').value = tomorrow.toISOString().slice(0, 16);
    }

    // Dynamic amount validation based on type
    document.getElementById('type').addEventListener('change', function() {
        const amountField = document.getElementById('amount');
        if (this.value === 'percentage') {
            amountField.max = 100;
            if (parseFloat(amountField.value) > 100) {
                amountField.value = 100;
            }
        } else {
            amountField.removeAttribute('max');
        }
    });
});
</script>


<style>
    .custom-switch .custom-control-label::after {
        background-color: #fff;
    }
    .custom-control-input:checked~.custom-control-label::before {
        border-color: #007bff;
        background-color: #007bff;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
</style>
