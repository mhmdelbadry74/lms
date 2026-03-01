@extends('Admins.layout.master')

@section('title', 'Payments Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__("Payments Dashboard")}}</h4>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-primary">{{__("Payment Methods")}}</a>
                        <a href="{{ route('admin.payments.transactions') }}" class="btn btn-success">{{__("View Transactions")}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Statistics Display -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $statistics['total_transactions'] ?? 0 }}</h3>
                                    <p>{{__("Total Transactions")}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $statistics['successful_payments'] ?? 0 }}</h3>
                                    <p>{{__("Successful Payments")}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $statistics['failed_payments'] ?? 0 }}</h3>
                                    <p>{{__("Failed Payments")}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h3>{{ $statistics['pending_payments'] ?? 0 }}</h3>
                                    <p>{{__("Pending Payments")}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue Information -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__("Revenue Overview")}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <h4>{{ number_format($statistics['total_revenue'] ?? 0, 3) }} KWD</h4>
                                            <p>{{__("Total Revenue")}}</p>
                                        </div>
                                        <div class="col-6">
                                            <h4>{{ number_format(($statistics['total_revenue'] ?? 0) / max($statistics['successful_payments'] ?? 1, 1), 3) }} KWD</h4>
                                            <p>{{__("Average Transaction")}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Methods Distribution -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__("Payment Methods")}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <h4>{{ $statistics['cod_orders'] ?? 0 }}</h4>
                                            <p>{{__("COD Orders")}}</p>
                                        </div>
                                        <div class="col-6">
                                            <h4>{{ $statistics['online_payments'] ?? 0 }}</h4>
                                            <p>{{__("Online Payments")}}</p>
                                        </div>
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
                                            <a href="{{ route('admin.payments.index') }}" class="btn btn-primary btn-block">{{__("Payment Methods")}}</a>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{ route('admin.payments.transactions') }}" class="btn btn-info btn-block">{{__("All Transactions")}}</a>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{ route('admin.orders.index') }}" class="btn btn-warning btn-block">{{__("View Orders")}}</a>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary btn-block">{{__("Settings")}}</a>
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
@endsection