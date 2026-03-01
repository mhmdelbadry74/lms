@extends('Admins.layout.master')

@section('title', 'Payment Transactions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__("Payment Transactions")}}</h4>
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('admin.payments.dashboard') }}" class="btn btn-info">{{__("Payments Dashboard")}}</a>
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-success">{{__("Payment Methods")}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h5>Transaction List</h5>
                    
                    @if(isset($transactions) && $transactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Order ID</th>
                                        <th>Method</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->id ?? 'N/A' }}</td>
                                        <td>{{ $transaction->order_id ?? 'N/A' }}</td>
                                        <td>{{ $transaction->method ?? 'N/A' }}</td>
                                        <td>{{ number_format($transaction->amount ?? 0, 3) }} KWD</td>
                                        <td>
                                            @if(($transaction->status ?? '') == 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @elseif(($transaction->status ?? '') == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif(($transaction->status ?? '') == 'failed')
                                                <span class="badge bg-danger">Failed</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $transaction->status ?? 'Unknown' }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $transaction->created_at ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No transactions found.</p>
                    @endif
                    
                    <!-- Statistics -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5>Total Transactions</h5>
                                    <h3>{{ $transactions->count() ?? 0 }}</h3>
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