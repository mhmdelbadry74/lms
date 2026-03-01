
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-primary">
            <i class="fa fa-history me-2"></i>Activity Log for {{ $admin->name }}
        </h2>
        <div class="d-flex">
            <button class="btn btn-outline-primary me-2" onclick="window.print()">
                <i class="fa fa-print me-1"></i> Print
            </button>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light-primary">
                        <tr>
                            <th class="ps-4 text-nowrap">Date & Time</th>
                            <th class="text-nowrap">Action</th>
                            <th class="text-nowrap">Model</th>
                            <th class="text-nowrap">Target ID</th>
                            <th class="pe-4 text-end">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                        <tr class="border-bottom">
                            <td class="ps-4">
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold">{{ $activity->created_at->format('M j, Y') }}</span>
                                    <small class="text-muted">{{ $activity->created_at->format('h:i A') }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-{{ getActionColor($activity->description) }} px-3 py-1">
                                    <i class="fa fa-{{ getActionIcon($activity->description) }} me-1"></i>
                                    {{ ucfirst($activity->description) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $activity->subject_type ? class_basename($activity->subject_type) : 'System' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 px-3">
                                    #{{ $activity->subject_id }}
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                @if($activity->properties->count())
                                    <button class="btn btn-sm btn-outline-info rounded-pill px-3" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#details-{{ $activity->id }}">
                                        <i class="fa fa-chevron-down me-1"></i> Details
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @if($activity->properties->count())
                        <tr class="bg-light">
                            <td colspan="5" class="p-0 border-0">
                                <div id="details-{{ $activity->id }}" class="collapse">
                                    <div class="p-3">
                                        <div class="card border-0 shadow-none">
                                            <div class="card-body bg-white rounded">
                                                <h6 class="mb-3 text-muted">
                                                    <i class="fa fa-info-circle me-2"></i>Change Details
                                                </h6>
                                                <div class="bg-dark p-3 rounded border">
                                                    <pre class="mb-0 p-0 bg-transparent" style="white-space: pre-wrap;">{{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}</pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center text-muted">
                                    <i class="fa fa-inbox fa-3x mb-3"></i>
                                    <p class="h5">No activities found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($activities->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted small">
            Showing {{ $activities->firstItem() }} to {{ $activities->lastItem() }} of {{ $activities->total() }} entries
        </div>
        <div>
            {{ $activities->onEachSide(1)->links() }}
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    /* Custom styles */
    .bg-light-primary {
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.03) !important;
    }
    
    pre {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.375rem;
        border: 1px solid #e9ecef;
        max-height: 300px;
        overflow-y: auto;
        font-size: 0.875rem;
        line-height: 1.5;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .pagination .page-link {
        color: #0d6efd;
    }
    
    @media (max-width: 768px) {
        .table-responsive {
            border: 0;
        }
        
        .table thead {
            display: none;
        }
        
        .table tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }
        
        .table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            border-bottom: 1px solid #dee2e6;
        }
        
        .table td::before {
            content: attr(data-label);
            font-weight: bold;
            margin-right: 1rem;
        }
        
        .table td:last-child {
            border-bottom: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-close other details when opening a new one
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
        button.addEventListener('click', function() {
            const target = this.getAttribute('data-bs-target');
            document.querySelectorAll('.collapse.show').forEach(el => {
                if (el.id !== target.substring(1)) {
                    bootstrap.Collapse.getInstance(el).hide();
                }
            });
            
            // Toggle icon
            const icon = this.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
            }
        });
    });
</script>
@endpush