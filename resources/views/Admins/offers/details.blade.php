@extends('Admins.layout.master')
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0">{{ __('Offer Details') }}</h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('admin.offers.index') }}" class="btn btn-light btn-sm">
                                        <i class="fa fa-arrow-left"></i> {{ __('Back') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th width="30%">{{ __('Offer Name') }}</th>
                                                    <td>{{ $offer->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Coupon Code') }}</th>
                                                    <td>
                                                        <span
                                                            class="badge badge-info">{{ $offer->coupon_code ?? 'N/A' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Discount Amount') }}</th>
                                                    <td>
                                                        {{ number_format($offer->amount, 2) }}
                                                        @if($offer->type === 'percentage') % @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Discount Type') }}</th>
                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $offer->type === 'fixed' ? 'primary' : 'warning' }}">
                                                            {{ ucfirst($offer->type) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Dates & Status -->
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th width="30%">{{ __('Start Date') }}</th>
                                                    <td>{{ $offer->starts_at ? $offer->starts_at->format('Y-m-d H:i') : 'N/A' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('End Date') }}</th>
                                                    <td>{{ $offer->ends_at ? $offer->ends_at->format('Y-m-d H:i') : 'N/A' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Status') }}</th>
                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $offer->is_active ? 'success' : 'danger' }}">
                                                            {{ $offer->is_active ? __('Active') : __('Inactive') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Flash Sale') }}</th>
                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $offer->is_flash_sale ? 'warning' : 'secondary' }}">
                                                            {{ $offer->is_flash_sale ? __('Yes') : __('No') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Usage') }}</th>
                                                    <td>
                                                        {{ $offer->used_count }} / {{ $offer->usage_limit ?? '∞' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="card-title mb-0">{{ __('Additional Information') }}</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p><strong>{{ __('Created By') }}:</strong>
                                                        {{ $offer->creator->name ?? 'System' }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p><strong>{{ __('Created At') }}:</strong>
                                                        {{ $offer->created_at->format('Y-m-d H:i') }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p><strong>{{ __('Last Updated') }}:</strong>
                                                        {{ $offer->updated_at->format('Y-m-d H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row mt-4">
                                <div class="col-12 text-right">
                                    @can('update_offers')
                                        <a href="{{ route('admin.offers.edit', $offer->id) }}" class="btn btn-primary mr-2">
                                            <i class="fa fa-edit"></i> {{ __('Edit') }}
                                        </a>
                                    @endcan

                                    @can('delete_offers')
                                        <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger confirm-delete">
                                                <i class="fa fa-trash"></i> {{ __('Delete') }}
                                            </button>
                                        </form>
                                    @endcan
                                    <!-- Dates & Status -->
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th width="30%">{{ __('Start Date') }}</th>
                                                        <td>{{ $offer->starts_at ? $offer->starts_at->format('Y-m-d H:i') : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ __('End Date') }}</th>
                                                        <td>{{ $offer->ends_at ? $offer->ends_at->format('Y-m-d H:i') : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ __('Status') }}</th>
                                                        <td>
                                                            <span
                                                                class="badge badge-{{ $offer->is_active ? 'success' : 'danger' }}">
                                                                {{ $offer->is_active ? __('Active') : __('Inactive') }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ __('Flash Sale') }}</th>
                                                        <td>
                                                            <span
                                                                class="badge badge-{{ $offer->is_flash_sale ? 'warning' : 'secondary' }}">
                                                                {{ $offer->is_flash_sale ? __('Yes') : __('No') }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ __('Usage') }}</th>
                                                        <td>
                                                            {{ $offer->used_count }} / {{ $offer->usage_limit ?? '∞' }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <h6 class="card-title mb-0">{{ __('Additional Information') }}</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p><strong>{{ __('Created By') }}:</strong>
                                                            {{ $offer->creator->name ?? 'System' }}</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><strong>{{ __('Created At') }}:</strong>
                                                            {{ $offer->created_at->format('Y-m-d H:i') }}</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p><strong>{{ __('Last Updated') }}:</strong>
                                                            {{ $offer->updated_at->format('Y-m-d H:i') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="row mt-4">
                                    <div class="col-12 text-right">
                                        @can('update_offers')
                                            <a href="{{ route('admin.offers.edit', $offer->id) }}" class="btn btn-primary mr-2">
                                                <i class="fa fa-edit"></i> {{ __('Edit') }}
                                            </a>
                                        @endcan

                                        @can('delete_offers')
                                            <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger confirm-delete">
                                                    <i class="fa fa-trash"></i> {{ __('Delete') }}
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function () {
                $('.confirm-delete').click(function (e) {
                    e.preventDefault();
                    const form = $(this).closest('form');

                    Swal.fire({
                        title: "{{ __('Are you sure?') }}",
                        text: "{{ __('You are about to delete this offer. This action cannot be undone.') }}",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: "{{ __('Yes, delete it!') }}",
                        cancelButtonText: "{{ __('Cancel') }}"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .table th {
                background-color: #f8f9fa;
            }

            .badge {
                font-size: 0.85rem;
                padding: 0.35em 0.65em;
            }
        </style>
    @endpush