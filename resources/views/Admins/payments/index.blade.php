@extends('Admins.layout.master')

@section('title', 'Payment Methods')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__("Payment Methods Configuration")}}</h4>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.payments.dashboard') }}" class="btn btn-info">{{__("Payments Dashboard")}}</a>
                        <a href="{{ route('admin.payments.transactions') }}" class="btn btn-success">{{__("View Transactions")}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($paymentMethods as $method)
                        <div class="col-md-4 mb-4">
                            <div class="card border-{{ $method['active'] ? 'success' : 'secondary' }}">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">{{ $method['name'] }}</h5>
                                    <span class="badge bg-{{ $method['active'] ? 'success' : 'secondary' }}">
                                        {{ $method['active'] ? __('Active') : __('Inactive') }}
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>{{__("Arabic Name")}}:</strong> {{ $method['name_ar'] }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>{{__("Type")}}:</strong> 
                                        <span class="badge bg-{{ $method['type'] == 'online' ? 'primary' : 'warning' }}">
                                            {{ ucfirst($method['type']) }}
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <strong>{{__("Fees")}}:</strong> 
                                        @if($method['fees'] > 0)
                                            @if($method['fees'] < 1)
                                                {{ $method['fees'] * 100 }}%
                                            @else
                                                {{ $method['fees'] }} KWD
                                            @endif
                                        @else
                                            {{__("Free")}}
                                        @endif
                                    </div>

                                    <div class="d-grid gap-2">
                                        <!-- Configuration Form -->
                                        <form method="POST" action="{{ route('admin.payments.updateConfig') }}">
                                            @csrf
                                            <input type="hidden" name="method" value="{{ $method['id'] }}">
                                            
                                            <div class="form-check form-switch mb-2">
                                                <input class="form-check-input" type="checkbox" name="enabled" value="1" 
                                                       {{ $method['active'] ? 'checked' : '' }}>
                                                <label class="form-check-label">{{__("Enable Method")}}</label>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label">{{__("Fees")}}</label>
                                                <input type="number" name="fees" class="form-control" 
                                                       value="{{ $method['fees'] }}" step="0.001" min="0">
                                                <small class="text-muted">{{__("Use decimal for percentage (e.g., 0.025 for 2.5%)")}}</small>
                                            </div>

                                            <button type="submit" class="btn btn-primary btn-sm">{{__("Update")}}</button>
                                        </form>

                                        @if($method['type'] == 'online')
                                        <button type="button" class="btn btn-outline-info btn-sm" 
                                                onclick="testGateway('{{ $method['id'] }}')">
                                            {{__("Test Connection")}}
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Gateway Configuration Settings -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__("Gateway Configuration")}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <strong>{{__("Note")}}:</strong> Payment gateway configurations are managed in the environment settings. 
                                        Make sure to set the appropriate API keys and settings for each gateway.
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>{{__("MyFatoorah Configuration")}}</h6>
                                            <ul class="list-unstyled">
                                                <li><code>MYFATOORAH_API_KEY</code></li>
                                                <li><code>MYFATOORAH_COUNTRY_CODE</code></li>
                                                <li><code>MYFATOORAH_TEST_MODE</code></li>
                                                <li><code>MYFATOORAH_CURRENCY</code></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>{{__("Tap Payments Configuration")}}</h6>
                                            <ul class="list-unstyled">
                                                <li><code>TAP_SECRET_KEY</code></li>
                                                <li><code>TAP_PUBLIC_KEY</code></li>
                                                <li><code>TAP_SANDBOX_MODE</code></li>
                                                <li><code>TAP_CURRENCY</code></li>
                                            </ul>
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
</div>

<script>
function testGateway(gateway) {
    fetch('{{ route("admin.payments.testGateway") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ gateway: gateway })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'connected') {
            alert(`Gateway ${gateway} is connected successfully!\nResponse time: ${data.response_time}\nAPI Version: ${data.api_version || 'N/A'}`);
        } else {
            alert(`Gateway ${gateway} connection failed!\nError: ${data.error || 'Unknown error'}`);
        }
    })
    .catch(error => {
        alert('Error testing gateway: ' + error.message);
    });
}
</script>
@endsection