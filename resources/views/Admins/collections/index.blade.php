@extends('Admins.layout.master')
@section('content')
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0">{{ __('All Collections') }}</h3>
                            <a href="{{ route('admin.collection.create') }}" class="btn btn-light btn-sm">
                                <i class="fa fa-plus mr-1"></i> {{ __('Add New') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="20%">{{ __('Name') }}</th>
                                        <th width="10%">{{ __('Image') }}</th>
                                        <th width="10%">{{ __('Products') }}</th>
                                        <th width="10%">{{ __('Active') }}</th>
                                        <th width="10%">{{ __('Featured') }}</th>
                                        <th width="20%">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($collections as $collection)
                                    <tr>
                                        <td>{{ $loop->iteration + ($collections->currentPage() - 1) * $collections->perPage() }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="font-weight-bold">{{ $collection->name_en }}</span>
                                                <span class="text-muted small" dir="rtl">{{ $collection->name_ar }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($collection->image)
                                                <img src="{{ asset('storage/' . $collection->image) }}" alt="{{ $collection->name_en }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <span class="text-muted">{{ __('No Image') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-pill badge-info">
                                                {{ $collection->products->count() ?? 0 }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $collection->is_active ? 'success' : 'danger' }}">
                                                {{ $collection->is_active ? __('Active') : __('Inactive') }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge badge-{{ $collection->is_featured ? 'warning' : 'secondary' }}">
                                                {{ $collection->is_featured ? __('Yes') : __('No') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                @include('Admins.layout.dicountRules', ["button_name" => __('add discount rules'), "model" => "App\Models\Collection", "model_id" => $collection->id,"discount_conditions" => App\Enums\DiscountConditionEnum::COLLECTION->value])

                                                <a href="{{ route('admin.collection.edit', $collection->id) }}" 
                                                   class="btn btn-info" title="{{ __('Edit') }}" data-toggle="tooltip">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.collection.show', $collection->id) }}" 
                                                   class="btn btn-primary" title="{{ __('View') }}" data-toggle="tooltip">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.collection.destroy', $collection->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="button" class="btn btn-danger delete-btn" 
                                                            title="{{ __('Delete') }}" data-toggle="tooltip"
                                                            data-name="{{ $collection->name_en }}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="fa fa-box-open fa-2x mb-2"></i>
                                            <p class="mb-0">{{ __('No collections found') }}</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($collections->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $collections->links('pagination::bootstrap-4') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Include necessary JS files -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Delete Confirmation with SweetAlert
    $('.delete-btn').click(function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const collectionName = $(this).data('name');
        
        Swal.fire({
            title: "{{ __('Are you sure?') }}",
            text: "{{ __('You are about to delete') }} \"" + collectionName + "\"",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: "{{ __('Yes, delete it!') }}",
            cancelButtonText: "{{ __('Cancel') }}",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.85rem;
        padding: 0.35em 0.65em;
    }
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
    }
</style>
