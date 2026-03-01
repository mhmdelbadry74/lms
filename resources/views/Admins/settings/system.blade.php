@extends('Admins.layout.master')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6 ps-0">
                <h3>{{__("System Information")}}</h3>
            </div>
            <div class="col-sm-6 pe-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__("Home")}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">{{__("Settings")}}</a></li>
                    <li class="breadcrumb-item active">{{__("System")}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__("System Information")}}</h4>
                    <p class="text-muted">{{__("View system performance and diagnostic information")}}</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>{{__("Server Information")}}</h5>
                            <table class="table table-bordered">
                                <tr><td><strong>{{__("PHP Version")}}</strong></td><td>{{ phpversion() }}</td></tr>
                                <tr><td><strong>{{__("Laravel Version")}}</strong></td><td>{{ app()->version() }}</td></tr>
                                <tr><td><strong>{{__("Server Software")}}</strong></td><td>{{ $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' }}</td></tr>
                                <tr><td><strong>{{__("Database")}}</strong></td><td>MySQL</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>{{__("System Status")}}</h5>
                            <div class="alert alert-success">{{__("System is running normally")}}</div>
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">{{__("Back to Settings")}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 