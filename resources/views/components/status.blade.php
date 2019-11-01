<span class="badge {{ $status ? 'badge-success' : 'badge-danger' }}">
    @if($status)
        <i class="fa fa-check-circle"></i>
    @else
        <i class="fa fa-times-circle"></i>
    @endif

    {{ $slot }}
</span>
