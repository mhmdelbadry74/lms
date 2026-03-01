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
                    <h4 class="mb-0">{{ __('Categories Management') }}</h4>
                    <div class="page-title-right">
                        <a href="{{ route('admin.categories.addForm') }}" class="btn btn-success">
                            <i class="fa fa-plus-circle me-1"></i> {{ __('create') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">
                                <i class="fa fa-list me-2"></i>{{ __('Categories') }}
                            </h4>
                            <div class="d-flex">
                                <span class="badge bg-primary rounded-pill">
                                    {{ __('Total') }}: {{ $categories->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 5%">{{ __('Id') }}</th>
                                        <th style="width: 20%">{{ __('Name') }}</th>
                                        <th style="width: 15%">{{ __('created By') }}</th>
                                        <th style="width: 15%">{{ __('product Counts') }}</th>
                                        <th style="width: 15%">{{ __('Register Date') }}</th>
                                        <th style="width: 20%">{{ __('parent category') }}</th>
                                        <th style="width: 10%" class="text-center">{{ __('actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $category)
                                        <tr>
                                            <td class="text-center">{{ $category->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-2">
                                                        <span class="avatar-title bg-soft-primary rounded-circle">
                                                            @if (app()->getLocale() == "ar")
                                                                {{ strtoupper(substr($category->name_ar, 0, 1)) }}
                                                            @else
                                                                {{ strtoupper(substr($category->name_en, 0, 1)) }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">
                                                            @if (app()->getLocale() == "ar")
                                                                {{ $category->name_ar }}
                                                            @else
                                                                {{ $category->name_en }}
                                                            @endif
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-user me-2 text-muted"></i>
                                                    {{ $category->CreateBy->name }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info rounded-pill">
                                                    {{ $category->Products()->count() }} {{ __('Products') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="text-muted">{{ $category->created_at->format('M d, Y') }}</span>
                                                    <small class="text-muted">{{ $category->created_at->format('h:i A') }}</small>
                                                    <small class="text-muted">{{ $category->created_at->diffForHumans() }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($category->parent)
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-2">
                                                            <span class="avatar-title bg-soft-primary rounded-circle">
                                                                {{ strtoupper(substr($category->parent->name, 0, 1)) }}
                                                            </span>
                                                        </div>
                                                        <div>{{ $category->parent->name }}</div>
                                                    </div>
                                                @else
                                                    <span class="badge bg-light text-dark">
                                                        {{ __('independant category') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    @include('Admins.layout.dicountRules', ["button_name" => __('add discount rules'), "model" => "App\Models\Category", "model_id" => $category->id,"discount_conditions" => App\Enums\DiscountConditionEnum::CATEGORY->value])

                                                    @can('update_category')
                                                        <a href="{{ route('admin.categories.UpdateForm', $category->id) }}" 
                                                           class="btn btn-outline-primary"
                                                           data-bs-toggle="tooltip"
                                                           title="{{ __('Edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete_admin')
                                                        <a href="{{ route('admin.categories.delete', $category->id) }}"
                                                                class="btn btn-danger delete-btn"
                                                                data-name="{{ $category->name }}" 
                                                                data-id="{{ $category->id }}"
                                                                data-bs-toggle="tooltip"
                                                                title="{{ __('Delete') }}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="fa fa-folder-open fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">{{ __('No categories found') }}</h5>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fa fa-exclamation-triangle me-2"></i>{{ __('Confirm Deletion') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you want to delete this category?') }}</p>
                    <p class="mb-0">
                        <strong id="category-name" class="text-danger"></strong>
                    </p>
                    <small class="text-muted">{{ __('This action cannot be undone.') }}</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
                const categoryId = $(this).data('id');
                const categoryName = $(this).data('name');
                const deleteUrl = "{{ route('admin.categories.delete', ':id') }}".replace(':id', categoryId);
                
                $('#category-name').text(categoryName);
                $('#delete-form').attr('action', deleteUrl);
                $('#deleteModal').modal('show');
            });
        });
    </script>
@endsection
