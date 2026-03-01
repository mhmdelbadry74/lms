@extends('Admins.layout.master')

@section('title', 'Orders Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>{{__("Total Orders")}}</h5>
                            <h2>{{ $statistics['total_orders'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>{{__("Pending Orders")}}</h5>
                            <h2>{{ $statistics['pending_orders'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>{{__("Delivered")}}</h5>
                            <h2>{{ $statistics['delivered_orders'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>{{__("Cancelled")}}</h5>
                            <h2>{{ $statistics['cancelled_orders'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-times-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Status Distribution Chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("Order Status Distribution")}}</h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("Recent Orders")}}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>{{__("Order")}}</th>
                                    <th>{{__("Customer")}}</th>
                                    <th>{{__("Amount")}}</th>
                                    <th>{{__("Status")}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistics['recent_orders'] as $order)
                                <tr>
                                    <td><a href="{{ route('admin.orders.show', $order->id) }}">#{{ $order->id }}</a></td>
                                    <td>{{ $order->client ? $order->client->name : 'Guest Customer' }}</td>
                                    <td>{{ number_format($order->total ?? 0, 3) }} KWD</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">{{__("View All Orders")}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("Quick Actions")}}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-block">{{__("All Orders")}}</a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn btn-warning btn-block">{{__("Pending Orders")}}</a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.orders.export') }}" class="btn btn-success btn-block">{{__("Export Orders")}}</a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.payments.dashboard') }}" class="btn btn-info btn-block">{{__("Payments")}}</a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.shipping.index') }}" class="btn btn-secondary btn-block">{{__("Shipping")}}</a>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.flash_sales.index') }}" class="btn btn-danger btn-block">{{__("Flash Sales")}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [
                @foreach($statistics['status_distribution'] as $status => $count)
                '{{ ucfirst($status) }}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($statistics['status_distribution'] as $status => $count)
                    {{ $count }},
                    @endforeach
                ],
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection