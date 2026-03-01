<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test MyFatoorah Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h4>Test MyFatoorah Payment Integration</h4>
                        <p class="text-muted">Select an order to test payment functionality</p>
                    </div>
                    <div class="card-body">
                        @if($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Email</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Payment Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td>#{{ $order->id }}</td>
                                                <td>{{ $order->client ? $order->client->name : 'Guest' }}</td>
                                                <td>{{ $order->client ? $order->client->email : 'N/A' }}</td>
                                                <td>{{ number_format($order->total, 3) }} KWD</td>
                                                <td>
                                                    @switch($order->status)
                                                        @case('pending')
                                                            <span class="badge bg-warning">Pending</span>
                                                            @break
                                                        @case('ready_for_pickup')
                                                            <span class="badge bg-success">Ready</span>
                                                            @break
                                                        @case('out_for_delivery')
                                                            <span class="badge bg-info">Out for Delivery</span>
                                                            @break
                                                        @case('completed')
                                                            <span class="badge bg-success">Completed</span>
                                                            @break
                                                        @case('cancelled')
                                                            <span class="badge bg-danger">Cancelled</span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary">{{ $order->status }}</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    @switch($order->payment_status ?? 'pending')
                                                        @case('pending')
                                                            <span class="badge bg-warning">Pending</span>
                                                            @break
                                                        @case('paid')
                                                            <span class="badge bg-success">Paid</span>
                                                            @break
                                                        @case('failed')
                                                            <span class="badge bg-danger">Failed</span>
                                                            @break
                                                        @case('refunded')
                                                            <span class="badge bg-info">Refunded</span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary">Unknown</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    @if(($order->payment_status ?? 'pending') !== 'paid')
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('myfatoorah.index', ['oid' => $order->id]) }}" 
                                                               class="btn btn-primary btn-sm">
                                                                Pay with MyFatoorah
                                                            </a>
                                                            <a href="{{ route('myfatoorah.checkout', ['oid' => $order->id]) }}" 
                                                               class="btn btn-secondary btn-sm">
                                                                Checkout Page
                                                            </a>
                                                        </div>
                                                    @else
                                                        <span class="text-success">✓ Paid</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <h5>No Orders Found</h5>
                                <p>Please run the OrderTestSeeder first to create test orders:</p>
                                <code>php artisan db:seed --class=OrderTestSeeder</code>
                            </div>
                        @endif
                    </div>
                </div>

                @if($orders->count() > 0)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5>Payment Integration Instructions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>🔧 Configuration Required:</h6>
                                    <ol>
                                        <li>Get your MyFatoorah API credentials from your account</li>
                                        <li>Update <code>config/myfatoorah.php</code> with your API key</li>
                                        <li>Set your country ISO code (default: KWT)</li>
                                        <li>Configure webhook URL in MyFatoorah dashboard</li>
                                    </ol>
                                </div>
                                <div class="col-md-6">
                                    <h6>🚀 Payment Flow:</h6>
                                    <ul>
                                        <li><strong>Pay with MyFatoorah:</strong> Direct payment link</li>
                                        <li><strong>Checkout Page:</strong> Embedded payment form</li>
                                        <li><strong>Callback:</strong> Handles payment success/failure</li>
                                        <li><strong>Webhook:</strong> Receives payment status updates</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>