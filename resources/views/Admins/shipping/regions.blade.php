@extends('Admins.layout.master')

@section('title', 'Regions & Governorates')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__("Regions & Governorates Management")}}</h4>
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('admin.shipping.index') }}" class="btn btn-primary">{{__("Back to Shipping")}}</a>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addGovernorateModal">
                                {{__("Add Governorate")}}
                            </button>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addRegionModal">
                                {{__("Add Region")}}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Governorates and their Regions -->
                    <div class="row">
                        @if(isset($governorates) && count($governorates) > 0)
                            @foreach($governorates as $governorate)
                            <div class="col-md-6 mb-4">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-0">{{ $governorate['name'] ?? $governorate['name_en'] ?? 'N/A' }}</h5>
                                            <small>{{ $governorate['name_ar'] ?? '' }}</small>
                                        </div>
                                        <div>
                                            @if(($governorate['is_active'] ?? true))
                                                <span class="badge bg-light text-dark">{{__("Active")}}</span>
                                            @else
                                                <span class="badge bg-secondary">{{__("Inactive")}}</span>
                                            @endif
                                            <div class="btn-group btn-group-sm mt-1" role="group">
                                                <button class="btn btn-sm btn-light" onclick="editGovernorate({{ $governorate['id'] ?? 0 }})">
                                                    {{__("Edit")}}
                                                </button>
                                                <button class="btn btn-sm btn-outline-light" onclick="deleteGovernorate({{ $governorate['id'] ?? 0 }})">
                                                    {{__("Delete")}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="mb-3">{{__("Regions")}}:</h6>
                                        
                                        @if(isset($governorate['regions']) && count($governorate['regions']) > 0)
                                            <div class="row">
                                                @foreach($governorate['regions'] as $region)
                                                <div class="col-12 mb-2">
                                                    <div class="alert alert-light border d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>{{ $region['name'] ?? $region['name_en'] ?? 'N/A' }}</strong>
                                                            @if(isset($region['name_ar']))
                                                                <small class="text-muted">({{ $region['name_ar'] }})</small>
                                                            @endif
                                                            <br>
                                                            <small class="text-muted">
                                                                {{__("Zone")}}: {{ $region['shipping_zone'] ?? 'N/A' }} | 
                                                                {{__("Distance")}}: {{ $region['distance_from_center'] ?? 'N/A' }} km
                                                            </small>
                                                        </div>
                                                        <div>
                                                            @if(($region['is_active'] ?? true))
                                                                <span class="badge bg-success">{{__("Active")}}</span>
                                                            @else
                                                                <span class="badge bg-secondary">{{__("Inactive")}}</span>
                                                            @endif
                                                            <div class="btn-group btn-group-sm mt-1" role="group">
                                                                <button class="btn btn-sm btn-outline-primary" onclick="editRegion({{ $region['id'] ?? 0 }})">
                                                                    {{__("Edit")}}
                                                                </button>
                                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteRegion({{ $region['id'] ?? 0 }})">
                                                                    {{__("Delete")}}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <p class="text-muted">{{__("No regions configured for this governorate")}}</p>
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addRegionToGovernorate({{ $governorate['id'] ?? 0 }})">
                                                    {{__("Add Region")}}
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="text-center">
                                    <p class="text-muted">{{__("No governorates configured")}}</p>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGovernorateModal">
                                        {{__("Add First Governorate")}}
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Shipping Zones Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__("Shipping Zones Overview")}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h5 class="text-success">{{__("Zone 1")}}</h5>
                                                    <p class="mb-0">{{__("0-10 km")}}</p>
                                                    <small class="text-muted">{{__("Standard Rate")}}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h5 class="text-primary">{{__("Zone 2")}}</h5>
                                                    <p class="mb-0">{{__("10-25 km")}}</p>
                                                    <small class="text-muted">{{__("Medium Rate")}}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h5 class="text-warning">{{__("Zone 3")}}</h5>
                                                    <p class="mb-0">{{__("25-50 km")}}</p>
                                                    <small class="text-muted">{{__("High Rate")}}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h5 class="text-danger">{{__("Zone 4")}}</h5>
                                                    <p class="mb-0">{{__("50+ km")}}</p>
                                                    <small class="text-muted">{{__("Premium Rate")}}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Governorate Modal -->
<div class="modal fade" id="addGovernorateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__("Add Governorate")}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="governorateForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>{{__("English Name")}}</label>
                                <input type="text" class="form-control" name="name_en" required placeholder="e.g., Kuwait">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>{{__("Arabic Name")}}</label>
                                <input type="text" class="form-control" name="name_ar" required placeholder="الكويت" dir="rtl">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>{{__("Status")}}</label>
                        <select class="form-control" name="is_active">
                            <option value="1">{{__("Active")}}</option>
                            <option value="0">{{__("Inactive")}}</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Cancel")}}</button>
                <button type="button" class="btn btn-success" onclick="saveGovernorate()">{{__("Save Governorate")}}</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Region Modal -->
<div class="modal fade" id="addRegionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__("Add Region")}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="regionForm">
                    <div class="form-group mb-3">
                        <label>{{__("Governorate")}}</label>
                        <select class="form-control" name="governorate_id" required>
                            <option value="">{{__("Select Governorate")}}</option>
                            @if(isset($governorates))
                                @foreach($governorates as $gov)
                                    <option value="{{ $gov['id'] ?? 0 }}">{{ $gov['name'] ?? $gov['name_en'] ?? 'N/A' }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>{{__("English Name")}}</label>
                                <input type="text" class="form-control" name="name_en" required placeholder="e.g., Salmiya">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>{{__("Arabic Name")}}</label>
                                <input type="text" class="form-control" name="name_ar" required placeholder="السالمية" dir="rtl">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>{{__("Shipping Zone")}}</label>
                                <select class="form-control" name="shipping_zone" required>
                                    <option value="1">{{__("Zone 1 (0-10 km)")}}</option>
                                    <option value="2">{{__("Zone 2 (10-25 km)")}}</option>
                                    <option value="3">{{__("Zone 3 (25-50 km)")}}</option>
                                    <option value="4">{{__("Zone 4 (50+ km)")}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>{{__("Distance from Center (km)")}}</label>
                                <input type="number" class="form-control" name="distance_from_center" step="0.1" min="0" placeholder="15.5">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>{{__("Status")}}</label>
                        <select class="form-control" name="is_active">
                            <option value="1">{{__("Active")}}</option>
                            <option value="0">{{__("Inactive")}}</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Cancel")}}</button>
                <button type="button" class="btn btn-info" onclick="saveRegion()">{{__("Save Region")}}</button>
            </div>
        </div>
    </div>
</div>

<script>
function editGovernorate(governorateId) {
    alert(`{{__("Editing governorate ID:")}}} #${governorateId}`);
}

function deleteGovernorate(governorateId) {
    if (confirm('{{__("Are you sure you want to delete this governorate and all its regions?")}}')) {
        alert(`{{__("Deleting governorate ID:")}}} #${governorateId}`);
    }
}

function editRegion(regionId) {
    alert(`{{__("Editing region ID:")}}} #${regionId}`);
}

function deleteRegion(regionId) {
    if (confirm('{{__("Are you sure you want to delete this region?")}}')) {
        alert(`{{__("Deleting region ID:")}}} #${regionId}`);
    }
}

function addRegionToGovernorate(governorateId) {
    document.querySelector('#addRegionModal select[name="governorate_id"]').value = governorateId;
    
    const modal = new bootstrap.Modal(document.getElementById('addRegionModal'));
    modal.show();
}

function saveGovernorate() {
    const form = document.getElementById('governorateForm');
    const formData = new FormData(form);
    
    alert('{{__("Governorate saved successfully! (Mock implementation)")}}');
    
    const modal = bootstrap.Modal.getInstance(document.getElementById('addGovernorateModal'));
    modal.hide();
    form.reset();
}

function saveRegion() {
    const form = document.getElementById('regionForm');
    const formData = new FormData(form);
    
    alert('{{__("Region saved successfully! (Mock implementation)")}}');
    
    const modal = bootstrap.Modal.getInstance(document.getElementById('addRegionModal'));
    modal.hide();
    form.reset();
}
</script>
@endsection