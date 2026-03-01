@extends('Admins.layout.master')
@section('content')
    <style>
        .profile-header {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .nav-tabs {
            margin-bottom: 1.5rem;
        }

        .order-card,
        .address-card {
            margin-bottom: 1rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .left-column {
            border-right: 1px solid #eee;
            padding-right: 2rem;
        }

        .right-column {
            padding-left: 2rem;
        }

        @media (max-width: 992px) {
            .left-column {
                border-right: none;
                padding-right: 0;
                border-bottom: 1px solid #eee;
                padding-bottom: 2rem;
                margin-bottom: 2rem;
            }

            .right-column {
                padding-left: 0;
            }
        }
    </style>
    <div class="container-fluid py-5">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <!-- Profile Header -->
        <div class="card">
            <div class="row g-0">
                <div class="col-md-4">
                    <img class="rounded-start img-fluid h-100 object-fit-cover" src="{{ asset($client->avatar) }}"
                        alt="Card image">
                </div>
                <div class="col-md-8">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            @if (app()->getLocale() == 'ar')
                                {{ $client->name_ar }}
                            @else
                                {{ $client->name_en }}
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-2">
                        <ul class="list-group">
                            <li class="list-group-item"><i class="ri-bill-line align-middle me-2"></i><i
                                    class="fas fa-solid fa-location-pin"></i>{{ $client->Addresses()?->get()->first()?->address }}</li>
                            <li class="list-group-item"><i class="ri-file-copy-2-line align-middle me-2"></i><i
                                    class="fa fa-phone"></i>{{ $client->phone }}</li>
                            <li class="list-group-item"><i class="ri-question-answer-line align-middle me-2"></i><i
                                    class="fa fa-solid fa-envelope"></i>{{ $client->email }}</li>
                            <li class="list-group-item">
                                @include("Admins.clients.parts.sendOffers")
                            </li>

                        </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column - Profile Info and Settings -->


            <!-- Right Column - Orders and Addresses -->
            <div class="col-lg-12 right-column">
                <!-- Orders Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Client Orders') }}</h3>
                    </div>
                    <div class="card-body">

                        @if ($client->orders)
                            @foreach ($client->orders as $order)
                            <div class="card order-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Order #{{ $order->id }}</h5>
                                            <p class="card-text text-muted">Placed on
                                                {{ $order->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-primary">{{ $order->status }}</span>
                                            <p class="h5 mt-2">${{ number_format($order->total, 2) }}</p>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View Details</a>
                                </div>
                            </div>
                            @endforeach

                            @else
                                <div class="alert alert-info">No orders found.</div>
                        @endif
                        

                        
                    </div>
                </div>

                <!-- Addresses Section -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="card-title mb-0">{{ __('Saved Addresses') }}</h3>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModalgrid">
                                <i class="bi bi-plus"></i> {{ __('Add New Address') }}
                            </button>
                        </div>
                        
                        @if ($client->Addresses->isEmpty())
                            <div class="alert alert-info">No addresses saved.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Address') }}</th>
                                            <th>{{ __('Government') }}</th>
                                            <th>{{ __('City') }}</th>
                                            <th>{{ __('actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($client->addresses as $address)
                                            <tr>
                                                <td>
                                                    <strong>{{ $address->address }}</strong>
                                                </td>
                                                <td>
                                                    {{ $address->government ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    {{ $address->city ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <form method="POST" action="{{ route('admin.clients.delete-address', ['address_id' => $address->id, 'client_id' => $client->id]) }}" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger waves-effect waves-light" 
                                                                    onclick="return confirm('{{ __('Are you sure you want to delete this address?') }}')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Address Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Address Title (Home, Work, etc.)</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Street Address</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">State/Province</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="defaultAddress">
                            <label class="form-check-label" for="defaultAddress">Set as default address</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save Address</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel"
        aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">{{ __('Add New Address') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.clients.add-address', $client->id) }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <div>
                                    <label for="address" class="form-label">{{ __('Address') }}</label>
                                    <input type="text" name="address" class="form-control" id="address" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-6">
                                <div>
                                    <label for="government" class="form-label">{{ __('Government') }}</label>
                                    <input type="text" name="government" class="form-control" id="government" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-6">
                                <div>
                                    <label for="city" class="form-label">{{ __('City') }}</label>
                                    <input type="text" name="city" class="form-control" id="city" required>
                                </div>
                            </div><!--end col-->
                            <div class="col-12">
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                </div>
                            </div>
                        </div><!--end row-->
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"></script>
@endsection
