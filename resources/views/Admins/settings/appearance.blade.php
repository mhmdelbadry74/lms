@extends('Admins.layout.master')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6 ps-0">
                <h3>{{__("Appearance Settings")}}</h3>
            </div>
            <div class="col-sm-6 pe-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__("Home")}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">{{__("Settings")}}</a></li>
                    <li class="breadcrumb-item active">{{__("Appearance")}}</li>
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
                    <h4>{{__("Appearance Settings")}}</h4>
                    <p class="text-muted">{{__("Customize theme and visual elements")}}</p>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        {{__("Appearance customization features will be available in a future update.")}}
                    </div>
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">{{__("Back to Settings")}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 