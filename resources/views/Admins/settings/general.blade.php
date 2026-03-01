@extends('Admins.layout.master')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6 ps-0">
                <h3>{{__("General Settings")}}</h3>
            </div>
            <div class="col-sm-6 pe-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__("Home")}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">{{__("Settings")}}</a></li>
                    <li class="breadcrumb-item active">{{__("General")}}</li>
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
                    <h4>{{__("General Settings")}}</h4>
                    <p class="text-muted">{{__("Configure basic system settings")}}</p>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.general.update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="site_name" class="form-label">{{__("Site Name")}}</label>
                                    <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                                           id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name']) }}">
                                    @error('site_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="site_description" class="form-label">{{__("Site Description")}}</label>
                                    <input type="text" class="form-control @error('site_description') is-invalid @enderror" 
                                           id="site_description" name="site_description" value="{{ old('site_description', $settings['site_description']) }}">
                                    @error('site_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="admin_email" class="form-label">{{__("Admin Email")}}</label>
                                    <input type="email" class="form-control @error('admin_email') is-invalid @enderror" 
                                           id="admin_email" name="admin_email" value="{{ old('admin_email', $settings['admin_email']) }}">
                                    @error('admin_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="timezone" class="form-label">{{__("Timezone")}}</label>
                                    <select class="form-control @error('timezone') is-invalid @enderror" id="timezone" name="timezone">
                                        <option value="UTC" {{ old('timezone', $settings['timezone']) == 'UTC' ? 'selected' : '' }}>UTC</option>
                                        <option value="America/New_York" {{ old('timezone', $settings['timezone']) == 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                                        <option value="Europe/London" {{ old('timezone', $settings['timezone']) == 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                                        <option value="Asia/Dubai" {{ old('timezone', $settings['timezone']) == 'Asia/Dubai' ? 'selected' : '' }}>Asia/Dubai</option>
                                    </select>
                                    @error('timezone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="language" class="form-label">{{__("Default Language")}}</label>
                                    <select class="form-control @error('language') is-invalid @enderror" id="language" name="language">
                                        <option value="en" {{ old('language', $settings['language']) == 'en' ? 'selected' : '' }}>{{__("English")}}</option>
                                        <option value="ar" {{ old('language', $settings['language']) == 'ar' ? 'selected' : '' }}>{{__("Arabic")}}</option>
                                    </select>
                                    @error('language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{__("Changes will take effect after saving and refreshing the page")}}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="currency" class="form-label">{{__("Default Currency")}}</label>
                                    <select class="form-control @error('currency') is-invalid @enderror" id="currency" name="currency">
                                        <option value="USD" {{ old('currency', $settings['currency']) == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                        <option value="EUR" {{ old('currency', $settings['currency']) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                        <option value="AED" {{ old('currency', $settings['currency']) == 'AED' ? 'selected' : '' }}>AED - UAE Dirham</option>
                                        <option value="SAR" {{ old('currency', $settings['currency']) == 'SAR' ? 'selected' : '' }}>SAR - Saudi Riyal</option>
                                    </select>
                                    @error('currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- SEO Meta Tags Section -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">{{__("SEO Meta Tags")}}</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="site_meta_title" class="form-label">{{__("Site Meta Title")}}</label>
                                    <input type="text" class="form-control @error('site_meta_title') is-invalid @enderror" 
                                           id="site_meta_title" name="site_meta_title" value="{{ old('site_meta_title', $settings['site_meta_title']) }}"
                                           placeholder="{{__('Title shown in browser tab and search results')}}">
                                    @error('site_meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{__("Recommended: 50-60 characters")}}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="site_meta_description" class="form-label">{{__("Site Meta Description")}}</label>
                                    <textarea class="form-control @error('site_meta_description') is-invalid @enderror" 
                                              id="site_meta_description" name="site_meta_description" rows="3"
                                              placeholder="{{__('Description shown in search engine results')}}">{{ old('site_meta_description', $settings['site_meta_description']) }}</textarea>
                                    @error('site_meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{__("Recommended: 150-160 characters")}}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="site_meta_keywords" class="form-label">{{__("Site Meta Keywords")}}</label>
                                    <input type="text" class="form-control @error('site_meta_keywords') is-invalid @enderror" 
                                           id="site_meta_keywords" name="site_meta_keywords" value="{{ old('site_meta_keywords', $settings['site_meta_keywords']) }}"
                                           placeholder="{{__('Comma-separated keywords (optional)')}}">
                                    @error('site_meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{__("Example: university, events, party, management")}}</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="hidden" name="maintenance_mode" value="0">
                                        <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1"
                                               {{ old('maintenance_mode', $settings['maintenance_mode']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="maintenance_mode">
                                            {{__("Enable Maintenance Mode")}}
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">{{__("When enabled, site will show maintenance page to visitors")}}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{__("Save Changes")}}</button>
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