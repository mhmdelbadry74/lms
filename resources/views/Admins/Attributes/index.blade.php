@extends('Admins.layout.master')
@section('content')
<div class="row">
            @foreach (['success', 'error', 'warning', 'info'] as $msg)
                @if (session()->has($msg))
                    <div class="alert alert-{{ $msg }} alert-dismissible fade show" role="alert">
                        <i class="fa fa-{{ $msg === 'error' ? 'times-circle' : ($msg === 'warning' ? 'exclamation-triangle' : ($msg === 'info' ? 'info-circle' : 'check-circle')) }} me-2"></i>
                        {{ session($msg) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endforeach

            @foreach($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    {{ $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-end mb-3">
                @if(auth("web")->user()->hasRole("super_admin"))
                    @include('Admins.attributes.parts.create')
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12 card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Attributes') }}</h3>
                </div>
                <div class="card-body">
                    @include('Admins.attributes.parts.table', ['attributes' => $attributes])
                </div>
            </div>
        </div>
    </div>
@endsection
