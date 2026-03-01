@extends('Admins.layout.master')

@section('title', 'Create Flash Sale')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__("Create Flash Sale")}}</h4>
                    <a href="{{ route('admin.flash_sales.index') }}" class="btn btn-secondary">{{__("Back to Flash Sales")}}</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.flash_sales.store') }}">
                        @csrf
                        
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{__("Basic Information")}}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">{{__("Name")}} *</label>
                                            <input type="text" name="name" id="name" class="form-control" required 
                                                   value="{{ old('name') }}">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="name_ar" class="form-label">{{__("Arabic Name")}}</label>
                                            <input type="text" name="name_ar" id="name_ar" class="form-control" 
                                                   value="{{ old('name_ar') }}">
                                            @error('name_ar')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="name_en" class="form-label">{{__("English Name")}}</label>
                                            <input type="text" name="name_en" id="name_en" class="form-control" 
                                                   value="{{ old('name_en') }}">
                                            @error('name_en')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">{{__("Description")}}</label>
                                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Discount Configuration -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{__("Discount Configuration")}}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">{{__("Discount Type")}}</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="discount_type" value="percentage" 
                                                       id="percentage" {{ old('discount_type') == 'percentage' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="percentage">{{__("Percentage")}}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="discount_type" value="fixed" 
                                                       id="fixed" {{ old('discount_type') == 'fixed' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="fixed">{{__("Fixed Amount")}}</label>
                                            </div>
                                        </div>

                                        <div class="mb-3" id="percentage_field" style="display: none;">
                                            <label for="discount_percentage" class="form-label">{{__("Discount Percentage")}} (%)</label>
                                            <input type="number" name="discount_percentage" id="discount_percentage" 
                                                   class="form-control" min="0" max="100" step="0.01" 
                                                   value="{{ old('discount_percentage') }}">
                                            @error('discount_percentage')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3" id="fixed_field" style="display: none;">
                                            <label for="discount_amount" class="form-label">{{__("Discount Amount")}} (KWD)</label>
                                            <input type="number" name="discount_amount" id="discount_amount" 
                                                   class="form-control" min="0" step="0.001" 
                                                   value="{{ old('discount_amount') }}">
                                            @error('discount_amount')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="max_discount_amount" class="form-label">{{__("Maximum Discount Amount")}} (KWD)</label>
                                            <input type="number" name="max_discount_amount" id="max_discount_amount" 
                                                   class="form-control" min="0" step="0.001" 
                                                   value="{{ old('max_discount_amount') }}">
                                            <small class="text-muted">{{__("Leave empty for no limit")}}</small>
                                            @error('max_discount_amount')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="min_order_amount" class="form-label">{{__("Minimum Order Amount")}} (KWD)</label>
                                            <input type="number" name="min_order_amount" id="min_order_amount" 
                                                   class="form-control" min="0" step="0.001" 
                                                   value="{{ old('min_order_amount') }}">
                                            <small class="text-muted">{{__("Leave empty for no minimum")}}</small>
                                            @error('min_order_amount')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <!-- Time Configuration -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{__("Time Configuration")}}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="start_time" class="form-label">{{__("Start Time")}} *</label>
                                            <input type="datetime-local" name="start_time" id="start_time" 
                                                   class="form-control" required 
                                                   value="{{ old('start_time') }}">
                                            @error('start_time')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="end_time" class="form-label">{{__("End Time")}} *</label>
                                            <input type="datetime-local" name="end_time" id="end_time" 
                                                   class="form-control" required 
                                                   value="{{ old('end_time') }}">
                                            @error('end_time')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                                                   id="is_active" {{ old('is_active') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">{{__("Active")}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Selection -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{__("Product Selection")}}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">{{__("Select Products")}}</label>
                                            <div class="alert alert-info">
                                                {{__("Product selection interface will be implemented based on your product management system. For now, you can specify product IDs manually.")}}
                                            </div>
                                            <textarea name="product_ids_text" class="form-control" rows="3" 
                                                      placeholder="{{__('Enter product IDs separated by commas (e.g., 1,2,3)')}}">{{ old('product_ids_text') }}</textarea>
                                            <small class="text-muted">{{__("Leave empty to apply to all products")}}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('admin.flash_sales.index') }}" class="btn btn-secondary me-md-2">{{__("Cancel")}}</a>
                                    <button type="submit" class="btn btn-primary">{{__("Create Flash Sale")}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const percentageRadio = document.getElementById('percentage');
    const fixedRadio = document.getElementById('fixed');
    const percentageField = document.getElementById('percentage_field');
    const fixedField = document.getElementById('fixed_field');

    function toggleDiscountFields() {
        if (percentageRadio.checked) {
            percentageField.style.display = 'block';
            fixedField.style.display = 'none';
        } else if (fixedRadio.checked) {
            percentageField.style.display = 'none';
            fixedField.style.display = 'block';
        } else {
            percentageField.style.display = 'none';
            fixedField.style.display = 'none';
        }
    }

    percentageRadio.addEventListener('change', toggleDiscountFields);
    fixedRadio.addEventListener('change', toggleDiscountFields);

    toggleDiscountFields();

    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('start_time').min = now.toISOString().slice(0, 16);

    document.getElementById('start_time').addEventListener('change', function() {
        const startTime = new Date(this.value);
        startTime.setHours(startTime.getHours() + 1); 
        document.getElementById('end_time').min = startTime.toISOString().slice(0, 16);
    });
});
</script>
@endsection