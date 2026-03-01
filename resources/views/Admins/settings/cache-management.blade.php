@extends('Admins.layout.master')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6 ps-0">
                <h3>{{__("Cache Management")}}</h3>
            </div>
            <div class="col-sm-6 pe-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__("Home")}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">{{__("Settings")}}</a></li>
                    <li class="breadcrumb-item active">{{__("Cache Management")}}</li>
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
                    <h4><i class="fa fa-database me-2"></i>{{__("System Cache Management")}}</h4>
                    <p class="text-muted">{{__("Manage application caches and run essential system commands")}}</p>
                </div>
                <div class="card-body">
                    
                    <!-- Cache Management Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3"><i class="fa fa-trash text-danger me-2"></i>{{__("Cache Management")}}</h5>
                            <div class="row g-3">
                                <!-- Clear All Caches -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="cache-command-card">
                                        <div class="card border-danger h-100">
                                            <div class="card-body text-center p-4">
                                                <div class="cache-icon mb-3">
                                                    <i class="fa fa-broom fa-2x text-danger"></i>
                                                </div>
                                                <h6 class="card-title">{{__("Clear All Caches")}}</h6>
                                                <p class="card-text text-muted small">{{__("Clear all application caches at once")}}</p>
                                                <form method="POST" action="{{ route('admin.settings.cache.clear-all') }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-times me-1"></i>{{__("Clear All")}}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Clear Application Cache -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="cache-command-card">
                                        <div class="card border-warning h-100">
                                            <div class="card-body text-center p-4">
                                                <div class="cache-icon mb-3">
                                                    <i class="fa fa-database fa-2x text-warning"></i>
                                                </div>
                                                <h6 class="card-title">{{__("Application Cache")}}</h6>
                                                <p class="card-text text-muted small">{{__("Clear application data cache")}}</p>
                                                <form method="POST" action="{{ route('admin.settings.cache.clear-cache') }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-trash me-1"></i>{{__("Clear Cache")}}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Clear View Cache -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="cache-command-card">
                                        <div class="card border-info h-100">
                                            <div class="card-body text-center p-4">
                                                <div class="cache-icon mb-3">
                                                    <i class="fa fa-eye fa-2x text-info"></i>
                                                </div>
                                                <h6 class="card-title">{{__("View Cache")}}</h6>
                                                <p class="card-text text-muted small">{{__("Clear compiled view templates")}}</p>
                                                <form method="POST" action="{{ route('admin.settings.cache.clear-view') }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-info btn-sm">
                                                        <i class="fa fa-trash me-1"></i>{{__("Clear Views")}}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Clear Route Cache -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="cache-command-card">
                                        <div class="card border-primary h-100">
                                            <div class="card-body text-center p-4">
                                                <div class="cache-icon mb-3">
                                                    <i class="fa fa-route fa-2x text-primary"></i>
                                                </div>
                                                <h6 class="card-title">{{__("Route Cache")}}</h6>
                                                <p class="card-text text-muted small">{{__("Clear cached routes")}}</p>
                                                <form method="POST" action="{{ route('admin.settings.cache.clear-route') }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="fa fa-trash me-1"></i>{{__("Clear Routes")}}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Clear Config Cache -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="cache-command-card">
                                        <div class="card border-secondary h-100">
                                            <div class="card-body text-center p-4">
                                                <div class="cache-icon mb-3">
                                                    <i class="fa fa-cogs fa-2x text-secondary"></i>
                                                </div>
                                                <h6 class="card-title">{{__("Config Cache")}}</h6>
                                                <p class="card-text text-muted small">{{__("Clear configuration cache")}}</p>
                                                <form method="POST" action="{{ route('admin.settings.cache.clear-config') }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-secondary btn-sm">
                                                        <i class="fa fa-trash me-1"></i>{{__("Clear Config")}}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- System Commands Section -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3"><i class="fa fa-tools text-success me-2"></i>{{__("System Commands")}}</h5>
                            <div class="row g-3">
                                <!-- Generate Application Key -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="cache-command-card">
                                        <div class="card border-success h-100">
                                            <div class="card-body text-center p-4">
                                                <div class="cache-icon mb-3">
                                                    <i class="fa fa-key fa-2x text-success"></i>
                                                </div>
                                                <h6 class="card-title">{{__("Generate App Key")}}</h6>
                                                <p class="card-text text-muted small">{{__("Generate new application encryption key")}}</p>
                                                <form method="POST" action="{{ route('admin.settings.cache.generate-key') }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('{{__("This will generate a new application key. Continue?")}}')">
                                                        <i class="fa fa-key me-1"></i>{{__("Generate Key")}}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Create Storage Link -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="cache-command-card">
                                        <div class="card border-purple h-100">
                                            <div class="card-body text-center p-4">
                                                <div class="cache-icon mb-3">
                                                    <i class="fa fa-link fa-2x text-purple"></i>
                                                </div>
                                                <h6 class="card-title">{{__("Storage Link")}}</h6>
                                                <p class="card-text text-muted small">{{__("Create symbolic link to storage")}}</p>
                                                <form method="POST" action="{{ route('admin.settings.cache.storage-link') }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-purple btn-sm">
                                                        <i class="fa fa-link me-1"></i>{{__("Create Link")}}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Database Migration -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="cache-command-card">
                                        <div class="card border-dark h-100">
                                            <div class="card-body text-center p-4">
                                                <div class="cache-icon mb-3">
                                                    <i class="fa fa-database fa-2x text-dark"></i>
                                                </div>
                                                <h6 class="card-title">{{__("Run Migrations")}}</h6>
                                                <p class="card-text text-muted small">{{__("Execute database migrations")}}</p>
                                                <form method="POST" action="{{ route('admin.settings.cache.migrate') }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-dark btn-sm" onclick="return confirm('{{__("This will run database migrations. Continue?")}}')">
                                                        <i class="fa fa-play me-1"></i>{{__("Run Migration")}}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Optimize Application -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="cache-command-card">
                                        <div class="card border-warning h-100">
                                            <div class="card-body text-center p-4">
                                                <div class="cache-icon mb-3">
                                                    <i class="fa fa-rocket fa-2x text-warning"></i>
                                                </div>
                                                <h6 class="card-title">{{__("Optimize App")}}</h6>
                                                <p class="card-text text-muted small">{{__("Optimize application for production")}}</p>
                                                <form method="POST" action="{{ route('admin.settings.cache.optimize') }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-rocket me-1"></i>{{__("Optimize")}}
                                                    </button>
                                                </form>
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
</div>

<style>
.cache-command-card {
    transition: transform 0.2s ease-in-out;
}

.cache-command-card:hover {
    transform: translateY(-5px);
}

.cache-command-card:hover .card {
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.cache-icon {
    transition: transform 0.2s ease-in-out;
}

.cache-command-card:hover .cache-icon {
    transform: scale(1.1);
}

.text-purple {
    color: #6f42c1 !important;
}

.btn-purple {
    color: #fff;
    background-color: #6f42c1;
    border-color: #6f42c1;
}

.btn-purple:hover {
    color: #fff;
    background-color: #5a359a;
    border-color: #5a359a;
}

.border-purple {
    border-color: #6f42c1 !important;
}

.card-title {
    font-size: 0.95rem;
    font-weight: 600;
}

.card-text {
    font-size: 0.8rem;
    line-height: 1.3;
}
</style>

@endsection