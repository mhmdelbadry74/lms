<div class="row">
    @foreach (['success', 'error', 'warning', 'info'] as $msg)
        @if (session()->has($msg))
            <div class="alert alert-{{ $msg }} alert-dismissible fade show" role="alert">
                <i class="fa fa-{{ $msg === 'error' ? 'times-circle' : ($msg === 'warning' ? 'exclamation-triangle' : ($msg === 'info' ? 'info-circle' : 'check-circle')) }} me-2"></i>
                {{ __(session($msg)) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endforeach
</div>