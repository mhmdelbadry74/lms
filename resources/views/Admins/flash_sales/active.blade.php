@extends('Admins.layout.master')

@section('title', 'Active Flash Sales')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__("Active Flash Sales")}}</h4>
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('admin.flash_sales.index') }}" class="btn btn-primary">{{__("All Flash Sales")}}</a>
                            <a href="{{ route('admin.flash_sales.upcoming') }}" class="btn btn-info">{{__("Upcoming Sales")}}</a>
                            <a href="{{ route('admin.flash_sales.create') }}" class="btn btn-success">{{__("Create New")}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($flashSales) > 0)
                        <div class="row">
                            @foreach($flashSales as $flashSale)
                            <div class="col-md-6 mb-4">
                                <div class="card border-success">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0">{{ $flashSale['name'] }}</h5>
                                        <span class="badge bg-light text-dark">{{__("ACTIVE NOW")}}</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>{{__("Discount")}}:</strong><br>
                                                @if($flashSale['discount_type'] === 'percentage')
                                                    <span class="badge bg-danger fs-6">{{ $flashSale['discount_value'] }}% OFF</span>
                                                @else
                                                    <span class="badge bg-danger fs-6">{{ $flashSale['discount_value'] }} KWD OFF</span>
                                                @endif
                                            </div>
                                            <div class="col-6">
                                                <strong>{{__("Status")}}:</strong><br>
                                                <span class="badge bg-success">{{ $flashSale['status_text'] }}</span>
                                            </div>
                                        </div>
                                        
                                        @if(isset($flashSale['time_remaining']))
                                        <div class="mt-3">
                                            <strong>{{__("Time Remaining")}}:</strong>
                                            <div class="countdown-display">
                                                {{ $flashSale['time_remaining']['days'] }}d 
                                                {{ $flashSale['time_remaining']['hours'] }}h 
                                                {{ $flashSale['time_remaining']['minutes'] }}m
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="mt-3">
                                            <strong>{{__("Ends At")}}:</strong><br>
                                            <small class="text-muted">{{ $flashSale['end_datetime'] }}</small>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <a href="{{ route('admin.flash_sales.show', $flashSale['id']) }}" class="btn btn-sm btn-info">{{__("View Details")}}</a>
                                            <a href="{{ route('admin.flash_sales.edit', $flashSale['id']) }}" class="btn btn-sm btn-warning">{{__("Edit")}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center">
                            <div class="alert alert-info">
                                <h5>{{__("No Active Flash Sales")}}</h5>
                                <p>{{__("There are currently no active flash sales. Create a new one or check upcoming sales.")}}</p>
                                <a href="{{ route('admin.flash_sales.create') }}" class="btn btn-success">{{__("Create Flash Sale")}}</a>
                                <a href="{{ route('admin.flash_sales.upcoming') }}" class="btn btn-info">{{__("View Upcoming")}}</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection