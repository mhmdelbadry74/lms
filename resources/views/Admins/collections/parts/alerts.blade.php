
@if(isset($messages) && $messages)
<div class="alert alert-{{ $type }} alert-dismissible fade show">
    @if(is_array($messages))
    <ul class="mb-0">
        @foreach($messages as $msg)
        <li>{{ $msg }}</li>
        @endforeach
    </ul>
    @else
    {{ $message }}
    @endif
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif