@extends('Admins.layout.master')
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @include('Admins.layout.parts.alert')
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="card-title mb-0"> {{ __('Offers') }}</h6>
                                </div>
                                @can("add_offers")
                                    <div class="flex-shrink-0">
                                        <ul class="list-inline card-toolbar-menu d-flex align-items-center mb-0">
                                            <li class="list-inline-item">
                                                <a class="align-middle btn btn-success"
                                                    href="{{ route('admin.offers.create') }}" data-toggle="growing-reload">
                                                    <i class="fa fa-plus"></i> {{ __('Add New') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="50">#</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Arabic Name') }}</th>
                                            <th>{{ __('English Name') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Expire Date') }}</th>
                                            <th width="120">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($offers as $offer)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $offer->name }}</td>
                                            <td>{{ $offer->name_ar }}</td>
                                            <td>{{ $offer->name_en }}</td>
                                            <td>{{ number_format($offer->price, 2) }}</td>
                                            <td>{{ $offer->expire_date }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.offers.show',$offer->id) }}" class='btn btn-sm btn-info'><i class='fa fa-eye'></i></a>
                                                    @can("update_offers")
                                                        <a href="{{ route('admin.offers.edit', $offer->id) }}" 
                                                        class="btn btn-sm btn-primary" title="{{ __('Edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can("delete_offers")
                                                        <form action="{{ route('admin.offers.destroy', $offer->id) }}" 
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                                    title="{{ __('Delete') }}"
                                                                    onclick="return confirm('{{ __('Are you sure?') }}')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('No offers found') }}</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($offers->hasPages())
                            <div class="card-footer">
                                {{ $offers->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection