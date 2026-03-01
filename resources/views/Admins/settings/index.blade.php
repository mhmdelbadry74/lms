@extends('Admins.layout.master')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6 ps-0">
                <h3>{{__("Settings")}}</h3>
            </div>
            <div class="col-sm-6 pe-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__("Home")}}</a></li>
                    <li class="breadcrumb-item active">{{__("Settings")}}</li>
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
                    <h4>{{__("System Settings")}}</h4>
                    <p class="text-muted">{{__("Manage your system settings and configurations")}}</p>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        
                        <!-- General Settings Card -->
                        <div class="col-lg-4 col-md-6">
                            <div class="settings-card h-100" onclick="location.href='{{ route('admin.settings.general') }}'">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body text-center p-4">
                                        <div class="settings-icon mb-3">
                                            <i class="fa fa-cog fa-3x text-primary"></i>
                                        </div>
                                        <h5 class="card-title">{{__("General Settings")}}</h5>
                                        <p class="card-text text-muted">{{__("Basic system settings and configurations")}}</p>
                                        <span class="btn btn-outline-primary btn-sm">{{__("Configure")}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Settings Card -->
                        {{-- <div class="col-lg-4 col-md-6">
                            <div class="settings-card h-100" onclick="location.href='{{ route('admin.settings.security') }}'">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body text-center p-4">
                                        <div class="settings-icon mb-3">
                                            <i class="fa fa-shield-alt fa-3x text-success"></i>
                                        </div>
                                        <h5 class="card-title">{{__("Security Settings")}}</h5>
                                        <p class="card-text text-muted">{{__("Password policies and security configurations")}}</p>
                                        <span class="btn btn-outline-success btn-sm">{{__("Configure")}}</span>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <!-- Notification Settings Card -->
                        <div class="col-lg-4 col-md-6">
                            <div class="settings-card h-100" onclick="location.href='{{ route('admin.settings.notifications') }}'">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body text-center p-4">
                                        <div class="settings-icon mb-3">
                                            <i class="fa fa-bell fa-3x text-warning"></i>
                                        </div>
                                        <h5 class="card-title">{{__("Notifications")}}</h5>
                                        <p class="card-text text-muted">{{__("Email and system notification settings")}}</p>
                                        <span class="btn btn-outline-warning btn-sm">{{__("Configure")}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cache Management Card -->
                        <div class="col-lg-4 col-md-6">
                            <div class="settings-card h-100" onclick="location.href='{{ route('admin.settings.cache') }}'">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body text-center p-4">
                                        <div class="settings-icon mb-3">
                                            <i class="fa fa-database fa-3x text-danger"></i>
                                        </div>
                                        <h5 class="card-title">{{__("Cache Management")}}</h5>
                                        <p class="card-text text-muted">{{__("Clear application cache to improve performance")}}</p>
                                        <span class="btn btn-outline-danger btn-sm">{{__("Clear Cache")}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- System Settings Card -->
                        {{-- <div class="col-lg-4 col-md-6">
                            <div class="settings-card h-100" onclick="location.href='{{ route('admin.settings.system') }}'">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body text-center p-4">
                                        <div class="settings-icon mb-3">
                                            <i class="fa fa-server fa-3x text-info"></i>
                                        </div>
                                        <h5 class="card-title">{{__("System Information")}}</h5>
                                        <p class="card-text text-muted">{{__("System performance and diagnostic information")}}</p>
                                        <span class="btn btn-outline-info btn-sm">{{__("View")}}</span>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <!-- Appearance Settings Card -->
                        {{-- <div class="col-lg-4 col-md-6">
                            <div class="settings-card h-100" onclick="location.href='{{ route('admin.settings.appearance') }}'">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body text-center p-4">
                                        <div class="settings-icon mb-3">
                                            <i class="fa fa-palette fa-3x text-purple"></i>
                                        </div>
                                        <h5 class="card-title">{{__("Appearance")}}</h5>
                                        <p class="card-text text-muted">{{__("Theme and visual customization settings")}}</p>
                                        <span class="btn btn-outline-secondary btn-sm">{{__("Customize")}}</span>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <!-- Backup Settings Card -->
                        {{-- <div class="col-lg-4 col-md-6">
                            <div class="settings-card h-100" onclick="location.href='{{ route('admin.settings.backup') }}'">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body text-center p-4">
                                        <div class="settings-icon mb-3">
                                            <i class="fa fa-download fa-3x text-danger"></i>
                                        </div>
                                        <h5 class="card-title">{{__("Backup & Restore")}}</h5>
                                        <p class="card-text text-muted">{{__("Data backup and restoration tools")}}</p>
                                        <span class="btn btn-outline-danger btn-sm">{{__("Manage")}}</span>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.settings-card {
    cursor: pointer;
    transition: transform 0.2s ease-in-out;
}

.settings-card:hover {
    transform: translateY(-5px);
}

.settings-card:hover .card {
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.settings-icon {
    transition: transform 0.2s ease-in-out;
}

.settings-card:hover .settings-icon {
    transform: scale(1.1);
}

.text-purple {
    color: #6f42c1 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
});
</script>

@endsection 