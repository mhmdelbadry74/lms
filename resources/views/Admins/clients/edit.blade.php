@extends('Admins.layout.master')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h3 mb-0 page-title">
                    <i class="fa fa-user-plus me-2"></i>{{ __($form_title) }}
                </h2>

            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fa fa-user-edit me-2"></i>{{ __('Client Information') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ isset($client)?route('admin.clients.edit',$client->id):route('admin.clients.Add') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- Arabic Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="name_ar" class="form-label">
                                        {{ __('Name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ isset($client)?$client->name:old('name') }}" @if(!isset($client))required @endif>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            
                            </div>

                            <div class="row">
                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        {{ __('Email') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ isset($client)?$client->email:old('email') }}" @if(!isset($client))required @endif>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">
                                        {{ __('Phone') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{isset($client)? $client->phone:old('phone') }}" @if(!isset($client))required @endif>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label">{{ __('Address') }}</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ isset($client)?$client->address:old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <!-- Password -->
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">
                                        {{ __('Password') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" @if(!isset($client))required @endif>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">
                                        {{ __('Confirm Password') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation"@if(!isset($client)) required @endif>
                                </div>
                            </div>

                            <!-- Profile Image -->
                            <div class="mb-4">
                                <label for="personal_img" class="form-label">{{ __('Profile Image') }}</label>
                                <input type="file" class="form-control @error('personal_img') is-invalid @enderror"
                                    id="personal_img" name="personal_img" accept="image/*">
                                @error('personal_img')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small
                                    class="text-muted">{{ __('Maximum file size: 2MB. Allowed formats: jpg, png, gif') }}</small>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left me-2"></i>{{ __('Cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save me-2"></i>{{ __('Save Client') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar with Help Information -->
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fa fa-info-circle me-2"></i>{{ __('Guidelines') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6 class="text-primary">{{ __('Required Fields') }}</h6>
                        <p>{{__("to keep current password keep the password field and the confirmation blank")}}</p>
                        <p>{{__("to keep current img don't choose image")}}</p>

                        <p class="small">{{ __('Fields marked with') }} <span class="text-danger">*</span>
                            {{ __('are required') }}.</p>

                        <h6 class="text-primary mt-3">{{ __('Password Requirements') }}</h6>
                        <ul class="small">
                            <li>{{ __('Minimum 8 characters') }}</li>
                            <li>{{ __('At least one uppercase letter') }}</li>
                            <li>{{ __('At least one number') }}</li>
                            <li>{{ __('At least one special character') }}</li>
                        </ul>

                        <h6 class="text-primary mt-3">{{ __('Profile Image') }}</h6>
                        <p class="small">{{ __('Recommended size: 300x300 pixels') }}<br>
                            {{ __('Formats: JPG, PNG, GIF') }}<br>
                            {{ __('Max size: 2MB') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border-radius: 8px;
            border: none;
        }

        .card-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-label {
            font-weight: 500;
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
        }

        .page-title {
            color: #333;
        }
    </style>
@endpush
