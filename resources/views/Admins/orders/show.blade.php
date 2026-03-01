@extends('Admins.layout.master')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__("Order Details")}} - #{{ $order->id }}</h4>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">{{__("Back to Orders")}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Order Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__("Order Information")}}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>{{__("Order ID")}}:</strong></td>
                                            <td>#{{ $order->id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{__("Status")}}:</strong></td>
                                            <td>
                                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{__("Payment Method")}}:</strong></td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{__("Delivery Type")}}:</strong></td>
                                            <td>{{ $order->shipping_status ? ucfirst(str_replace('_', ' ', $order->shipping_status)) : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{__("Created At")}}:</strong></td>
                                            <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__("Customer Information")}}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>{{__("Name")}}:</strong></td>
                                            <td>{{ $order->client ? $order->client->name : 'Guest Customer' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{__("Phone")}}:</strong></td>
                                            <td>{{ $order->client ? $order->client->phone : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{__("Address")}}:</strong></td>
                                            <td>{{ $order->client && $order->client->addresses->first() ? $order->client->addresses->first()->address : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{__("Notes")}}:</strong></td>
                                            <td>{{ $order->notes ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Totals -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__("Order Totals")}}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>{{__("Subtotal")}}:</strong></td>
                                            <td>{{ number_format($order->subtotal ?? 0, 3) }} KWD</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{__("Shipping Fee")}}:</strong></td>
                                            <td>{{ number_format($order->shipping_cost ?? 0, 3) }} KWD</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{__("Discount")}}:</strong></td>
                                            <td>-{{ number_format($order->discount_amount ?? 0, 3) }} KWD</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{__("Fees")}}:</strong></td>
                                            <td>{{ number_format(0, 3) }} KWD</td>
                                        </tr>
                                        <tr class="border-top">
                                            <td><strong>{{__("Total Amount")}}:</strong></td>
                                            <td><strong>{{ number_format($order->total, 3) }} KWD</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Update Status -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__("Update Order Status")}}</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="status" class="form-label">{{__("Status")}}</label>
                                            <select name="status" id="status" class="form-select" required>
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>{{__("Pending")}}</option>
                                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>{{__("Confirmed")}}</option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>{{__("Processing")}}</option>
                                                <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>{{__("Ready for Delivery")}}</option>
                                                <option value="out_for_delivery" {{ $order->status == 'out_for_delivery' ? 'selected' : '' }}>{{__("Out for Delivery")}}</option>
                                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>{{__("Delivered")}}</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>{{__("Cancelled")}}</option>
                                                <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>{{__("Refunded")}}</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{__("Update Status")}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__("Order Items")}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>{{__("Product")}}</th>
                                                    <th>{{__("Price")}}</th>
                                                    <th>{{__("Quantity")}}</th>
                                                    <th>{{__("Total")}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Mock data - replace with actual order items -->
                                                <tr>
                                                    <td>Sample Product</td>
                                                    <td>10.000 KWD</td>
                                                    <td>2</td>
                                                    <td>20.000 KWD</td>
                                                </tr>
                                            </tbody>
                                        </table>
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
@endsection