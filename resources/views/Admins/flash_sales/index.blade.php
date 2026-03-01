@extends('Admins.layout.master')

@section('title', 'Flash Sales Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__("Flash Sales Management")}}</h4>
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('admin.flash_sales.create') }}" class="btn btn-primary">{{__("Create Flash Sale")}}</a>
                            <a href="{{ route('admin.flash_sales.active') }}" class="btn btn-success">{{__("Active Sales")}}</a>
                            <a href="{{ route('admin.flash_sales.upcoming') }}" class="btn btn-info">{{__("Upcoming Sales")}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{__("Name")}}</th>
                                    <th>{{__("Discount")}}</th>
                                    <th>{{__("Start Time")}}</th>
                                    <th>{{__("End Time")}}</th>
                                    <th>{{__("Status")}}</th>
                                    <th>{{__("Active")}}</th>
                                    <th>{{__("Actions")}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($flashSales as $flashSale)
                                <tr>
                                    <td>
                                        <strong>{{ $flashSale->name }}</strong>
                                        @if($flashSale->name_ar)
                                        <br><small class="text-muted">{{ $flashSale->name_ar }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($flashSale->discount_percentage > 0)
                                            <span class="badge bg-danger">{{ $flashSale->discount_percentage }}% OFF</span>
                                        @elseif($flashSale->discount_amount > 0)
                                            <span class="badge bg-danger">{{ $flashSale->discount_amount }} KWD OFF</span>
                                        @else
                                            <span class="badge bg-secondary">No Discount</span>
                                        @endif
                                    </td>
                                    <td>{{ $flashSale->start_time }}</td>
                                    <td>{{ $flashSale->end_time }}</td>
                                    <td>
                                        @php
                                            $now = now();
                                            $start = \Carbon\Carbon::parse($flashSale->start_time);
                                            $end = \Carbon\Carbon::parse($flashSale->end_time);
                                            
                                            if ($now < $start) {
                                                $status = 'scheduled';
                                                $badgeClass = 'bg-info';
                                            } elseif ($now->between($start, $end)) {
                                                $status = 'active';
                                                $badgeClass = 'bg-success';
                                            } else {
                                                $status = 'expired';
                                                $badgeClass = 'bg-secondary';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $flashSale->is_active ? 'success' : 'danger' }}">
                                            {{ $flashSale->is_active ? __('Yes') : __('No') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.flash_sales.show', $flashSale->id) }}" class="btn btn-sm btn-info">{{__("View")}}</a>
                                            <a href="{{ route('admin.flash_sales.edit', $flashSale->id) }}" class="btn btn-sm btn-warning">{{__("Edit")}}</a>
                                            <form method="POST" action="{{ route('admin.flash_sales.toggleStatus', $flashSale->id) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-{{ $flashSale->is_active ? 'secondary' : 'success' }}">
                                                    {{ $flashSale->is_active ? __('Deactivate') : __('Activate') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{__("No flash sales found")}}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $flashSales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.badge.bg-success {
    animation: pulse 2s infinite;
}
</style>
@endsection