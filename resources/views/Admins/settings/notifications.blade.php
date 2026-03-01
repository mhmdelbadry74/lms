@extends('Admins.layout.master')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6 ps-0">
                <h3>{{__("Notification Settings")}}</h3>
            </div>
            <div class="col-sm-6 pe-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__("Home")}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">{{__("Settings")}}</a></li>
                    <li class="breadcrumb-item active">{{__("Notifications")}}</li>
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
                    <h4>{{__("Notification Settings")}}</h4>
                    <p class="text-muted">{{__("Configure email and system notifications")}}</p>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.notifications.update') }}">
                        @csrf
                        <!-- Email Settings Section -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">{{__("Email Configuration")}}</h5>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="smtp_host" class="form-label">{{__("SMTP Host")}}</label>
                                    <input type="text" class="form-control @error('smtp_host') is-invalid @enderror" 
                                           id="smtp_host" name="smtp_host" value="{{ old('smtp_host', $settings['smtp_host']) }}">
                                    @error('smtp_host')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="smtp_port" class="form-label">{{__("SMTP Port")}}</label>
                                    <input type="number" class="form-control @error('smtp_port') is-invalid @enderror" 
                                           id="smtp_port" name="smtp_port" value="{{ old('smtp_port', $settings['smtp_port']) }}">
                                    @error('smtp_port')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="smtp_username" class="form-label">{{__("SMTP Username")}}</label>
                                    <input type="email" class="form-control @error('smtp_username') is-invalid @enderror" 
                                           id="smtp_username" name="smtp_username" value="{{ old('smtp_username', $settings['smtp_username']) }}">
                                    @error('smtp_username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="smtp_password" class="form-label">{{__("SMTP Password")}}</label>
                                    <input type="password" class="form-control @error('smtp_password') is-invalid @enderror" 
                                           id="smtp_password" name="smtp_password" 
                                           placeholder="{{__('Leave blank to keep current password')}}"
                                           value="{{ old('smtp_password') }}">
                                    @error('smtp_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if(!empty($settings['smtp_password']))
                                        <small class="form-text text-muted">{{__('Password is currently set')}}</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Notification Preferences Section -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">{{__("Notification Preferences")}}</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-light">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">{{__("Admin Notifications")}}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="new_user_registration" name="new_user_registration" 
                                                   {{ old('new_user_registration', $settings['new_user_registration']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="new_user_registration">
                                                {{__("New user registrations")}}
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="new_order" name="new_order" 
                                                   {{ old('new_order', $settings['new_order']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="new_order">
                                                {{__("New orders")}}
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="low_stock" name="low_stock" 
                                                   {{ old('low_stock', $settings['low_stock']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="low_stock">
                                                {{__("Low stock alerts")}}
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="system_errors" name="system_errors" 
                                                   {{ old('system_errors', $settings['system_errors']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="system_errors">
                                                {{__("System errors")}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card border-light">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">{{__("Client Notifications")}}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="order_confirmation" name="order_confirmation" 
                                                   {{ old('order_confirmation', $settings['order_confirmation']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="order_confirmation">
                                                {{__("Order confirmations")}}
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="order_status" name="order_status" 
                                                   {{ old('order_status', $settings['order_status']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="order_status">
                                                {{__("Order status updates")}}
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="promotional_emails" name="promotional_emails" 
                                                   {{ old('promotional_emails', $settings['promotional_emails']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="promotional_emails">
                                                {{__("Promotional emails")}}
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="welcome_emails" name="welcome_emails" 
                                                   {{ old('welcome_emails', $settings['welcome_emails']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="welcome_emails">
                                                {{__("Welcome emails")}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Test Email Section -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">{{__("Test Email")}}</h5>
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="email" class="form-control" placeholder="{{__('Enter email to send test email')}}" id="test_email">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-outline-primary">{{__("Send Test Email")}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-warning">{{__("Save Notification Settings")}}</button>
                                <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">{{__("Cancel")}}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 