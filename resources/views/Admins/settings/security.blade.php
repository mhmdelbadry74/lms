@extends('Admins.layout.master')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6 ps-0">
                <h3>{{__("Security Settings")}}</h3>
            </div>
            <div class="col-sm-6 pe-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__("Home")}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">{{__("Settings")}}</a></li>
                    <li class="breadcrumb-item active">{{__("Security")}}</li>
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
                    <h4>{{__("Security Settings")}}</h4>
                    <p class="text-muted">{{__("Configure password policies and security options")}}</p>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.security.update') }}">
                        @csrf
                        <!-- Password Policy Section -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">{{__("Password Policy")}}</h5>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="min_password_length" class="form-label">{{__("Minimum Password Length")}}</label>
                                    <input type="number" class="form-control @error('min_password_length') is-invalid @enderror" 
                                           id="min_password_length" name="min_password_length" 
                                           value="{{ old('min_password_length', $settings['min_password_length']) }}" min="6" max="50">
                                    @error('min_password_length')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_expiry" class="form-label">{{__("Password Expiry (days)")}}</label>
                                    <input type="number" class="form-control @error('password_expiry') is-invalid @enderror" 
                                           id="password_expiry" name="password_expiry" 
                                           value="{{ old('password_expiry', $settings['password_expiry']) }}" min="30" max="365">
                                    @error('password_expiry')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="require_uppercase" name="require_uppercase" 
                                               {{ old('require_uppercase', $settings['require_uppercase']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="require_uppercase">
                                            {{__("Require uppercase letters")}}
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="require_lowercase" name="require_lowercase" 
                                               {{ old('require_lowercase', $settings['require_lowercase']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="require_lowercase">
                                            {{__("Require lowercase letters")}}
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="require_numbers" name="require_numbers" 
                                               {{ old('require_numbers', $settings['require_numbers']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="require_numbers">
                                            {{__("Require numbers")}}
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="require_symbols" name="require_symbols" 
                                               {{ old('require_symbols', $settings['require_symbols']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="require_symbols">
                                            {{__("Require special characters")}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Login Security Section -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">{{__("Login Security")}}</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_login_attempts" class="form-label">{{__("Max Login Attempts")}}</label>
                                    <input type="number" class="form-control @error('max_login_attempts') is-invalid @enderror" 
                                           id="max_login_attempts" name="max_login_attempts" 
                                           value="{{ old('max_login_attempts', $settings['max_login_attempts']) }}" min="3" max="10">
                                    @error('max_login_attempts')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lockout_duration" class="form-label">{{__("Lockout Duration (minutes)")}}</label>
                                    <input type="number" class="form-control @error('lockout_duration') is-invalid @enderror" 
                                           id="lockout_duration" name="lockout_duration" 
                                           value="{{ old('lockout_duration', $settings['lockout_duration']) }}" min="5" max="60">
                                    @error('lockout_duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="enable_2fa" name="enable_2fa" 
                                               {{ old('enable_2fa', $settings['enable_2fa']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="enable_2fa">
                                            {{__("Enable Two-Factor Authentication")}}
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="session_timeout" name="session_timeout" 
                                               {{ old('session_timeout', $settings['session_timeout']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="session_timeout">
                                            {{__("Enable session timeout (30 minutes)")}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">{{__("Save Security Settings")}}</button>
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