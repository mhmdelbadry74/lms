@extends('Admins.layout.master')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h3 class="welcome-text">{{__("Welcome")}} {{auth("web")->user()->name}}!</h3>
                    <p class="mb-0">Here's what's happening with your store today.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Admins</h6>
                            <h3 class="mb-0">{{$admin_counts}}</h3>
                        </div>
                        <div class="avatar avatar-lg bg-light-primary">
                            <i class="fa fa-user-shield fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Products</h6>
                            <h3 class="mb-0">{{$product_counts}}</h3>
                        </div>
                        <div class="avatar avatar-lg bg-light-success">
                            <i class="fa fa-box fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Clients</h6>
                            <h3 class="mb-0">{{$client_counts}}</h3>
                        </div>
                        <div class="avatar avatar-lg bg-light-info">
                            <i class="fa fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Orders</h6>
                            <h3 class="mb-0">{{$order_counts}}</h3>
                        </div>
                        <div class="avatar avatar-lg bg-light-warning">
                            <i class="fa fa-shopping-cart fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Monthly Orders Chart -->
        <div class="col-xl-8 mb-4">
            <div class="card h-100">
            <div class="card-header">
                    <h5 class="card-title mb-0">Monthly Statistics</h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyStats" style="min-height: 300px; max-height: 500px;"></canvas>
                </div>
            </div>
        </div>
        <!-- Order Status Distribution -->
        <div class="col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Status Distribution</h5>
            </div>
            <div class="card-body">
                    <canvas id="orderStatus" style="min-height: 300px; max-height: 500px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Tables -->
    <div class="row">
        <!-- Recent Clients -->
        <div class="col-xl-6 mb-4">
            <div class="card h-100">
            <div class="card-header">
                    <h5 class="card-title mb-0">Recent Clients</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_clients as $client)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($client->personal_img) }}" class="rounded-circle me-2" width="32" height="32">
                                            <span>{{ $client->name_en }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->created_at->diffForHumans() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recent Admins -->
        <div class="col-xl-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Admins</h5>
            </div>
            <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_admins as $admin)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($admin->personal_img) }}" class="rounded-circle me-2" width="32" height="32">
                                            <span>{{ $admin->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        @foreach($admin->roles as $role)
                                            <span class="badge bg-primary">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $admin->created_at->diffForHumans() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>

<script>

const getLastSixMonths = () => {
    const months = [];
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const today = new Date();
    for (let i = 5; i >= 0; i--) {
        const month = new Date(today.getFullYear(), today.getMonth() - i, 1);
        months.push(monthNames[month.getMonth()]);
    }
    return months;
};

document.addEventListener('DOMContentLoaded', function() {

    const monthlyStatsCtx = document.getElementById('monthlyStats');

    if (monthlyStatsCtx) {
        const monthLabels = getLastSixMonths();

        new Chart(monthlyStatsCtx, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Orders',
                    data: [0, 0, 0, 0, 0, 0],
                    borderColor: '#4CAF50',
                    backgroundColor: '#4CAF50',
                    tension: 0.4,
                    fill: false
                }, {
                    label: 'New Clients',
                    data: [0, 0, 0, 0, 0, 0],
                    borderColor: '#2196F3',
                    backgroundColor: '#2196F3',
                    tension: 0.4,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    }

    const orderStatusCtx = document.getElementById('orderStatus');

    if (orderStatusCtx) {
        new Chart(orderStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Ready', 'Waiting Shipping', 'Refunded'],
                datasets: [{
                    data: [0, 0, 0, 0],
                    backgroundColor: ['#4CAF50', '#2196F3', '#FFC107', '#F44336'],
                    borderWidth: 1,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                cutout: '70%',
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });
    }
});
</script>
@endpush

<style>
.avatar {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}
.bg-light-primary {
    background-color: rgba(13, 110, 253, 0.1);
}
.bg-light-success {
    background-color: rgba(25, 135, 84, 0.1);
}
.bg-light-info {
    background-color: rgba(13, 202, 240, 0.1);
}
.bg-light-warning {
    background-color: rgba(255, 193, 7, 0.1);
}
.welcome-text {
    font-size: 1.5rem;
    font-weight: 600;
}
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: none;
    margin-bottom: 1.5rem;
}
.card-header {
    background-color: transparent;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    padding: 1rem;
}
.table > :not(:first-child) {
    border-top: none;
}
</style>
@endsection
