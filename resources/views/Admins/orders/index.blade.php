@extends('Admins.layout.master')

@section('title', 'Orders Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__("Orders Management")}}</h4>
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('admin.orders.dashboard') }}" class="btn btn-info">{{__("Orders Dashboard")}}</a>
                            <a href="{{ route('admin.orders.export') }}" class="btn btn-success">{{__("Export Orders")}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('admin.orders.search') }}" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" placeholder="{{__('Search orders...')}}" value="{{ request('search') }}">
                                <select name="status" class="form-select me-2">
                                    <option value="">{{__("All Statuses")}}</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{__("Pending")}}</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>{{__("Confirmed")}}</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>{{__("Processing")}}</option>
                                    <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>{{__("Ready")}}</option>
                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>{{__("Delivered")}}</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{__("Cancelled")}}</option>
                                </select>
                                <button type="submit" class="btn btn-primary">{{__("Search")}}</button>
                            </form>
                        </div>
                    </div>

                    <!-- Bulk Actions Form -->
                    <form id="bulkForm" method="POST" action="{{ route('admin.orders.bulkAction') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <select name="action" class="form-select" required>
                                    <option value="">{{__("Select Action")}}</option>
                                    <option value="update_status">{{__("Update Status")}}</option>
                                    <option value="delete">{{__("Delete Selected")}}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="status" class="form-select" style="display: none;" id="statusSelect">
                                    <option value="confirmed">{{__("Confirmed")}}</option>
                                    <option value="processing">{{__("Processing")}}</option>
                                    <option value="ready">{{__("Ready")}}</option>
                                    <option value="delivered">{{__("Delivered")}}</option>
                                    <option value="cancelled">{{__("Cancelled")}}</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-warning">{{__("Apply")}}</button>
                            </div>
                        </div>

                        <!-- Orders Table -->
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>{{__("Order ID")}}</th>
                                        <th>{{__("Customer")}}</th>
                                        <th>{{__("Total Amount")}}</th>
                                        <th>{{__("Status")}}</th>
                                        <th>{{__("Payment Method")}}</th>
                                        <th>{{__("Delivery Type")}}</th>
                                        <th>{{__("Created At")}}</th>
                                        <th>{{__("Actions")}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <td><input type="checkbox" name="order_ids[]" value="{{ $order->id }}"></td>
                                        <td><strong>#{{ $order->id }}</strong></td>
                                        <td>{{ $order->client ? $order->client->name : 'Guest Customer' }}</td>
                                        <td>{{ number_format($order->total, 3) }} KWD</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
                                        <td>{{ $order->shipping_status ? ucfirst(str_replace('_', ' ', $order->shipping_status)) : 'N/A' }}</td>
                                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">{{__("View")}}</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">{{__("No orders found")}}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="order_ids[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    
    document.querySelector('select[name="action"]').addEventListener('change', function() {
        const statusSelect = document.getElementById('statusSelect');
        if (this.value === 'update_status') {
            statusSelect.style.display = 'block';
            statusSelect.required = true;
        } else {
            statusSelect.style.display = 'none';
            statusSelect.required = false;
        }
    });
</script>
@endsection