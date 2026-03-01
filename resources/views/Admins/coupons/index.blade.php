@extends('Admins.layout.master')
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @include('Admins.layout.parts.alert')
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0"> {{ __('Discounts') }}</h5>
                                </div>
                                @can("add_coupons")
                                    <div class="flex-shrink-0">
                                        <a class="btn btn-light" href="{{ route('admin.coupons.create') }}">
                                            <i class="fa fa-plus"></i> {{ __('Add New discounts') }}
                                        </a>
                                    </div>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th width="50">#</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Coupon Code') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Start Date') }}</th>
                                            <th>{{ __('End Date') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Usage') }}</th>
                                            <th>{{__("is featured")}}</th>
                                            <th>{{__("is flash sales")}}</th>
                                            <th width="120">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($coupons as $coupon)
                                        <tr>
                                            <td>{{ $loop->iteration + ($coupons->currentPage() - 1) * $coupons->perPage() }}</td>
                                            <td>{{ $coupon->name }}</td>
                                            <td>
                                                <span class="badge badge-info">{{ $coupon->coupon_code ?? 'N/A' }}</span>
                                            </td>
                                            <td class="text-nowrap">
                                                {{ $coupon->amount }}
                                                @if($coupon->type === 'percentage')% @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $coupon->type === 'fixed' ? 'primary' : 'warning' }}">
                                                    {{ ucfirst($coupon->type) }}
                                                </span>
                                            </td>
                                            <td class="text-nowrap">
                                                {{ $coupon->starts_at ? $coupon->starts_at->format('Y-m-d') : 'N/A' }}
                                            </td>
                                            <td class="text-nowrap">
                                                {{ $coupon->ends_at ? $coupon->ends_at->format('Y-m-d') : 'N/A' }}
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $coupon->is_active ? 'success' : 'danger' }}">
                                                    {{ $coupon->is_active ? __('Active') : __('Inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}
                                            </td>
                                            <td>
                                                @if ($coupon->is_featured)
                                                    {{ __("yes") }}
                                                @else
                                                    {{ __("no") }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($coupon->is_flash_sales)
                                                    {{ __("yes") }}
                                                @else
                                                    {{ __("no") }}
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.offers.show',$coupon->id) }}" 
                                                       class="btn btn-info" title="{{ __('View') }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    @can("update_coupons")
                                                    <a href="{{ route('admin.coupons.edit',$coupon->id) }}" 
                                                       class="btn btn-primary" title="{{ __('Edit') }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    @endcan
                                                    @can("delete_coupons")
                                                    <form action="{{ route("admin.coupons.delete",$coupon->id) }}" method="post" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger delete-btn" 
                                                                title="{{ __('Delete') }}"
                                                                data-name="{{ $coupon->name }}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="12" class="text-center py-4">
                                                <i class="fa fa-tag fa-2x text-muted mb-2"></i>
                                                <p class="text-muted">{{ __('No discounts found') }}</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($coupons->hasPages())
                            <div class="card-footer">
                                {{ $coupons->links('pagination::bootstrap-4') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Delete confirmation with SweetAlert
    $('.delete-btn').click(function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const couponName = $(this).data('name');
        
        Swal.fire({
            title: "{{ __('Are you sure?') }}",
            text: "{{ __('You are about to delete coupon') }}: " + couponName,
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
    .text-nowrap {
        white-space: nowrap;
    }
</style>
