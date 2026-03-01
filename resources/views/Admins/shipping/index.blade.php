@extends('Admins.layout.master')

@section('title', 'Shipping Methods')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__("Shipping Methods Management")}}</h4>
                    <div class="d-flex justify-content-between">
                        <div>
                            {{-- <a href="{{ route('admin.shipping.create') }}" class="btn btn-primary">{{__("Add Shipping Method")}}</a> --}}
                            <a href="{{ route('admin.shipping.slots') }}" class="btn btn-info">{{__("Delivery Slots")}}</a>
                            <a href="{{ route('admin.shipping.regions') }}" class="btn btn-success">{{__("Regions & Governorates")}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($shippingMethods as $method)
                        <div class="col-md-6 mb-4">
                            <div class="card border-{{ $method['type'] == 'fast' ? 'danger' : 'primary' }}">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">{{ $method['name'] }}</h5>
                                    <div>
                                        <span class="badge bg-{{ $method['type'] == 'fast' ? 'danger' : 'primary' }}">
                                            {{ ucfirst($method['type']) }}
                                        </span>
                                        @if(isset($method['active']) && $method['active'])
                                            <span class="badge bg-success">{{__("Active")}}</span>
                                        @else
                                            <span class="badge bg-secondary">{{__("Inactive")}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <strong>{{__("English Name")}}:</strong><br>
                                            {{ $method['name_en'] ?? $method['name'] }}
                                        </div>
                                        <div class="col-6">
                                            <strong>{{__("Base Cost")}}:</strong><br>
                                            {{ number_format($method['base_cost'], 3) }} KWD
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <strong>{{__("Per KM Cost")}}:</strong><br>
                                            {{ number_format($method['per_km_cost'] ?? 0, 3) }} KWD
                                        </div>
                                        <div class="col-6">
                                            <strong>{{__("Free Shipping")}}:</strong><br>
                                            @if(isset($method['min_order_for_free']) && $method['min_order_for_free'])
                                                {{ number_format($method['min_order_for_free'], 3) }} KWD+
                                            @else
                                                {{__("Not Available")}}
                                            @endif
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-3">
                                        @include('Admins.layout.dicountRules', ["button_name" => __('add discount rules'), "model" => "App\Models\ShippingMethod", "model_id" => $method['id'],"discount_conditions" => App\Enums\DiscountConditionEnum::SHIPPING_METHOD->value])

                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.shipping.edit', $method['id']) }}" class="btn btn-sm btn-warning">{{__("Edit")}}</a>
                                            <form method="POST" action="{{ route('admin.shipping.destroy', $method['id']) }}" style="display: inline;" 
                                                  onsubmit="return confirm('{{__('Are you sure you want to delete this shipping method?')}}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">{{__("Delete")}}</button>
                                            </form>
                                        </div>
                                        
                                        <button type="button" class="btn btn-sm btn-info" 
                                                onclick="testShippingCalculation({{ $method['id'] }})">
                                            {{__("Test Calculation")}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                         @empty
                        {{--<div class="col-12">
                            <div class="alert alert-info text-center">
                                <h5>{{__("No Shipping Methods Found")}}</h5>
                                <p>{{__("Create your first shipping method to start managing deliveries.")}}</p>
                                <a href="{{ route('admin.shipping.create') }}" class="btn btn-primary">{{__("Create Shipping Method")}}</a>
                            </div>
                        </div>--}}
                        @endforelse 
                    </div>

                    <!-- Shipping Calculator -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__("Shipping Cost Calculator")}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="calc_governorate" class="form-label">{{__("Governorate")}}</label>
                                            <select id="calc_governorate" class="form-select">
                                                <option value="">{{__("Select Governorate")}}</option>
                                                <option value="1">{{__("Kuwait City")}}</option>
                                                <option value="2">{{__("Hawalli")}}</option>
                                                <option value="3">{{__("Farwaniya")}}</option>
                                                <option value="4">{{__("Mubarak Al-Kabeer")}}</option>
                                                <option value="5">{{__("Ahmadi")}}</option>
                                                <option value="6">{{__("Jahra")}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="calc_region" class="form-label">{{__("Region")}}</label>
                                            <select id="calc_region" class="form-select">
                                                <option value="">{{__("Select Region")}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="calc_delivery_type" class="form-label">{{__("Delivery Type")}}</label>
                                            <select id="calc_delivery_type" class="form-select">
                                                <option value="normal">{{__("Normal")}}</option>
                                                <option value="fast">{{__("Fast")}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="calc_subtotal" class="form-label">{{__("Subtotal")}}</label>
                                            <input type="number" id="calc_subtotal" class="form-control" value="50" step="0.001">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">&nbsp;</label>
                                            <button type="button" class="btn btn-primary d-block" onclick="calculateShipping()">{{__("Calculate")}}</button>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div id="shipping_result" class="alert alert-info" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function testShippingCalculation(methodId) {
    alert('Testing shipping calculation for method ID: ' + methodId + '\nThis feature will calculate shipping costs based on the method configuration.');
}

function calculateShipping() {
    const governorate = document.getElementById('calc_governorate').value;
    const region = document.getElementById('calc_region').value;
    const deliveryType = document.getElementById('calc_delivery_type').value;
    const subtotal = document.getElementById('calc_subtotal').value;

    if (!governorate || !region) {
        alert('{{__("Please select both governorate and region")}}');
        return;
    }

    const resultDiv = document.getElementById('shipping_result');
    resultDiv.style.display = 'block';
    resultDiv.innerHTML = '<i class="fa fa-spinner fa-spin"></i> {{__("Calculating...")}}';

    fetch('{{ route("admin.shipping.calculate") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            governorate_id: governorate,
            region_id: region,
            delivery_type: deliveryType,
            subtotal: subtotal
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            resultDiv.className = 'alert alert-danger';
            resultDiv.innerHTML = `<strong>{{__("Error")}}:</strong> ${data.error}`;
        } else {
            resultDiv.className = 'alert alert-success';
            resultDiv.innerHTML = `
                <strong>{{__("Shipping Cost")}}:</strong> ${data.shipping_fee} KWD<br>
                <strong>{{__("Delivery Type")}}:</strong> ${data.delivery_type}<br>
                <strong>{{__("Estimated Delivery")}}:</strong> ${data.estimated_delivery}
            `;
        }
    })
    .catch(error => {
        resultDiv.className = 'alert alert-danger';
        resultDiv.innerHTML = `<strong>{{__("Error")}}:</strong> ${error.message}`;
    });
}


document.getElementById('calc_governorate').addEventListener('change', function() {
    const governorateId = this.value;
    const regionSelect = document.getElementById('calc_region');
    
    regionSelect.innerHTML = '<option value="">{{__("Loading...")}}</option>';
    
    if (governorateId) {
        fetch(`{{ route("admin.shipping.getRegions", "PLACEHOLDER") }}`.replace('PLACEHOLDER', governorateId))
        .then(response => response.json())
        .then(data => {
            regionSelect.innerHTML = '<option value="">{{__("Select Region")}}</option>';
            data.forEach(region => {
                regionSelect.innerHTML += `<option value="${region.id}">${region.name}</option>`;
            });
        })
        .catch(error => {
            regionSelect.innerHTML = '<option value="">{{__("Error loading regions")}}</option>';
        });
    } else {
        regionSelect.innerHTML = '<option value="">{{__("Select Region")}}</option>';
    }
});
</script>
@endsection