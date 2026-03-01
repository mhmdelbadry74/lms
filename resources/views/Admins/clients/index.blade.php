@extends('Admins.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Flash Messages -->
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
        </div>

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div class="page-title-right">
                        <a href="{{ route("admin.clients.addForm") }}" class="btn btn-success">
                            <i class="fa fa-plus-circle me-1"></i> {{ __('Add Client') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Combined Clients Table with Search -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 text-muted">
                                <i class="fa fa-users me-2"></i>{{ __('Clients') }}
                            </h4>
                            <div class="d-flex">
                                <span class="badge rounded-pill me-2" style="background-color: #e9ecef; color: #6c757d;">
                                    {{ __('Total') }}: {{ $clients->total() }}
                                </span>
                                @if(request()->has('search'))
                                <span class="badge rounded-pill" style="background-color: #e9ecef; color: #6c757d;">
                                    {{ __('Filtered') }}: {{ $clients->count() }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search Form inside the card -->
                    <div class="card-body border-bottom" style="background-color: #f8f9fa;">
                        <form method="get" action="{{ route("admin.clients.filter") }}">
                            <div class="row g-3">
                                <div class="col-md-10">
                                    <label class="form-label text-muted">{{ __('Search') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fa fa-search text-muted"></i></span>
                                        <input type="text" name="search" class="form-control border-start-0" value="{{ request('search') }}" placeholder="{{ __('Search by name, email, phone, or address...') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary flex-fill" style="background-color: #6f42c1; border-color: #6f42c1;">
                                            <i class="fa fa-search me-1"></i> {{ __('search') }}
                                        </button>
                                        <a href="{{ route('admin.clients.index') }}" class="btn btn-outline-secondary" title="{{ __('Reset') }}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="card-body p-0">
                        @if ($clients->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr style="background-color: #f8f9fa;">
                                            <th style="width: 5%; color: #6c757d;">{{ __('ID') }}</th>
                                            <th style="width: 25%; color: #6c757d;">{{ __('Name') }}</th>
                                         <th style="width: 35%; color: #6c757d;">{{ __('Contact') }}</th>
                                            <th style="width: 15%; color: #6c757d;" class="text-center">{{ __('actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clients as $client)
                                            <tr class="border-bottom">
                                                <td class="text-muted">{{ $client->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($client->avatar)
                                                            <img src="{{ asset($client->avatar) }}" 
                                                                 alt="{{ $client->name }}" 
                                                                 class="rounded-circle me-2"
                                                                 style="width: 36px; height: 36px; object-fit: cover;">
                                                        @else
                                                            <div class="avatar-sm me-2">
                                                                <span class="avatar-title rounded-circle" style="background-color: #e9ecef; color: #6f42c1;">
                                                                    {{ strtoupper(substr($client->name, 0, 1)) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-0" style="color: #495057;">{{ $client->name }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <a href="mailto:{{ $client->email }}" class="text-decoration-none" style="color: #6f42c1;">
                                                            <i class="fa fa-envelope me-2 text-muted"></i>{{ $client->email }}
                                                        </a>
                                                    </div>
                                                    <div class="text-muted">
                                                        <i class="fa fa-phone me-2 text-muted"></i>{{ $client->phone }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        @include('Admins.layout.dicountRules', ["button_name" => __('add discount rules'), "model" => "App\Models\Client", "model_id" => $client->id,"discount_conditions" => App\Enums\DiscountConditionEnum::CLIENT->value])
                                                        <a href="{{ route("admin.clients.profile", $client->id) }}" 
                                                           class="btn btn-light"
                                                           data-bs-toggle="tooltip"
                                                           title="{{ __('View Details') }}">
                                                            <i class="fa fa-eye" style="color: #6f42c1;"></i>
                                                        </a>
                                                        <a href="{{ route('admin.clients.EditForm', $client->id) }}" 
                                                           class="btn btn-light"
                                                           data-bs-toggle="tooltip"
                                                           title="{{ __('Edit') }}">
                                                            <i class="fa fa-edit" style="color: #6f42c1;"></i>
                                                        </a>
                                                        <a      href="{{ route('admin.clients.delete',$client->id) }}"
                                                                class="btn btn-light delete-btn"
                                                                data-name="{{ $client->name_ar }}" 
                                                                data-id="{{ $client->id }}"
                                                                data-bs-toggle="tooltip"
                                                                title="{{ __('Delete') }}">
                                                            <i class="fa fa-trash" style="color: #dc3545;"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fa fa-users-slash fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">{{ __('No clients found') }}</h5>
                                    @if(request()->has('search'))
                                        <a href="{{ route('admin.clients.index') }}" class="btn btn-sm btn-light mt-2">
                                            {{ __('Clear filters') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    @if ($clients->hasPages())
                        <div class="card-footer bg-white border-top-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    {{ __('Showing') }} 
                                    <strong>{{ $clients->firstItem() }}</strong> 
                                    {{ __('to') }} 
                                    <strong>{{ $clients->lastItem() }}</strong> 
                                    {{ __('of') }} 
                                    <strong>{{ $clients->total() }}</strong> 
                                    {{ __('entries') }}
                                </div>
                                <div>
                                    {{ $clients->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dc3545;">
                    <h5 class="modal-title text-white" id="deleteModalLabel">
                        <i class="fa fa-exclamation-triangle me-2"></i>{{ __('Confirm Deletion') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this client account?') }}</p>
                    <p class="mb-0">
                        <strong id="client-name" class="text-danger"></strong>
                    </p>
                    <small class="text-muted">{{ __('This action cannot be undone.') }}</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i>{{ __('Cancel') }}
                    </button>
                    <form id="delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash-alt me-1"></i>{{ __('Delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .avatar-sm {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .avatar-title {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }
        
        .bg-soft-primary {
            background-color: rgba(85, 110, 230, 0.25) !important;
            color: #556ee6;
        }
    </style>
@endpush

@section('scripts')
    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            $('.delete-btn').click(function() {
                const clientId = $(this).data('id');
                const clientName = $(this).data('name');
                const deleteUrl = "{{ route('admin.clients.delete', ':id') }}".replace(':id', clientId);
                
                $('#client-name').text(clientName);
                $('#delete-form').attr('action', deleteUrl);
                $('#deleteModal').modal('show');
            });
        });
    </script>
@endsection
