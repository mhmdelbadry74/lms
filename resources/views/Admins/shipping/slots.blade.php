@extends('Admins.layout.master')

@section('title', 'Delivery Slots')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{__("Delivery Slots Management")}}</h4>
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('admin.shipping.index') }}" class="btn btn-primary">{{__("Back to Shipping")}}</a>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSlotModal">
                                {{__("Add Time Slot")}}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Normal Delivery Slots -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">{{__("Normal Delivery Slots")}}</h5>
                                    <small>{{__("Scheduled delivery within specified time periods")}}</small>
                                </div>
                                <div class="card-body">
                                    @php 
                                        $normalSlots = isset($slots) ? $slots->where('is_quick', false) : collect();
                                    @endphp
                                    @if($normalSlots->count() > 0)
                                        @foreach($normalSlots as $slot)
                                        <div class="alert alert-light border">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">{{ $slot->name }}</h6>
                                                    <small class="text-muted">
                                                        {{__("Time")}}: {{ $slot->start_time }} - {{ $slot->end_time }}<br>
                                                        {{__("Type")}}: {{__("Normal Delivery")}}
                                                    </small>
                                                </div>
                                                <div>
                                                    <span class="badge bg-success">{{__("Active")}}</span>
                                                    <div class="btn-group mt-1" role="group">
                                                        <button class="btn btn-sm btn-outline-primary" onclick="editSlot({{ $slot->id }})">
                                                            {{__("Edit")}}
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteSlot({{ $slot->id }})">
                                                            {{__("Delete")}}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="text-center">
                                            <p class="text-muted">{{__("No normal delivery slots configured")}}</p>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSlotModal">
                                                {{__("Add First Slot")}}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Fast Delivery Slots -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="mb-0">{{__("Fast Delivery Slots")}}</h5>
                                    <small>{{__("Express delivery within 2 hours")}}</small>
                                </div>
                                <div class="card-body">
                                    @php 
                                        $fastSlots = isset($slots) ? $slots->where('is_quick', true) : collect();
                                    @endphp
                                    @if($fastSlots->count() > 0)
                                        @foreach($fastSlots as $slot)
                                        <div class="alert alert-light border">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">{{ $slot->name }}</h6>
                                                    <small class="text-muted">
                                                        {{__("Available")}}: {{ $slot->start_time }} - {{ $slot->end_time }}<br>
                                                        {{__("Type")}}: {{__("Fast Delivery")}}
                                                    </small>
                                                </div>
                                                <div>
                                                    <span class="badge bg-success">{{__("Active")}}</span>
                                                    <div class="btn-group mt-1" role="group">
                                                        <button class="btn btn-sm btn-outline-primary" onclick="editSlot({{ $slot->id }})">
                                                            {{__("Edit")}}
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteSlot({{ $slot->id }})">
                                                            {{__("Delete")}}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="text-center">
                                            <p class="text-muted">{{__("No fast delivery slots configured")}}</p>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addSlotModal">
                                                {{__("Add Fast Slot")}}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slot Configuration Settings -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__("Delivery Slot Settings")}}</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="#">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{__("Advance Booking (Days)")}}</label>
                                                    <input type="number" class="form-control" name="advance_booking_days" value="7" min="1" max="30">
                                                    <small class="text-muted">{{__("How many days in advance customers can book")}}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{__("Fast Delivery Hours")}}</label>
                                                    <input type="number" class="form-control" name="fast_delivery_hours" value="2" min="1" max="6">
                                                    <small class="text-muted">{{__("Maximum hours for fast delivery")}}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{__("Slot Buffer Time (Minutes)")}}</label>
                                                    <input type="number" class="form-control" name="slot_buffer_minutes" value="30" min="15" max="120">
                                                    <small class="text-muted">{{__("Time between order and delivery")}}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>&nbsp;</label><br>
                                                    <button type="submit" class="btn btn-primary">{{__("Save Settings")}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Slot Modal -->
<div class="modal fade" id="addSlotModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__("Add Delivery Slot")}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="slotForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>{{__("Slot Name")}}</label>
                                <input type="text" class="form-control" name="name" required placeholder="e.g., Morning Slot">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>{{__("Delivery Type")}}</label>
                                <select class="form-control" name="type" required>
                                    <option value="normal">{{__("Normal Delivery")}}</option>
                                    <option value="fast">{{__("Fast Delivery")}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>{{__("Start Time")}}</label>
                                <input type="time" class="form-control" name="start_time" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>{{__("End Time")}}</label>
                                <input type="time" class="form-control" name="end_time" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>{{__("Available Days")}}</label>
                        <div class="form-check-group">
                            @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="days[]" value="{{ strtolower($day) }}" id="day_{{ strtolower($day) }}">
                                <label class="form-check-label" for="day_{{ strtolower($day) }}">{{__($day)}}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>{{__("Maximum Orders")}}</label>
                                <input type="number" class="form-control" name="max_orders" min="1" placeholder="Leave empty for unlimited">
                                <small class="text-muted">{{__("Maximum orders for this slot per day")}}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>{{__("Status")}}</label>
                                <select class="form-control" name="is_active">
                                    <option value="1">{{__("Active")}}</option>
                                    <option value="0">{{__("Inactive")}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Cancel")}}</button>
                <button type="button" class="btn btn-primary" onclick="saveSlot()">{{__("Save Slot")}}</button>
            </div>
        </div>
    </div>
</div>

<script>
function editSlot(slotId) {
    alert(`{{__("Editing slot ID:")}}} #${slotId}`);
}

function deleteSlot(slotId) {
    if (confirm('{{__("Are you sure you want to delete this delivery slot?")}}')) {
        alert(`{{__("Deleting slot ID:")}}} #${slotId}`);
    }
}

function saveSlot() {
    const form = document.getElementById('slotForm');
    const formData = new FormData(form);
    
    alert('{{__("Slot saved successfully! (Mock implementation)")}}');
    
    const modal = bootstrap.Modal.getInstance(document.getElementById('addSlotModal'));
    modal.hide();
    
    form.reset();
    
}
</script>
@endsection