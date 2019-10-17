<a
    href="{{ route('domains.objects.show', [$object['domain']['slug'], $object['id']]) }}"
    class="badge badge-light border badge-pill"
>
    @include('domains.objects.partials.icon') {{ $object['name'] }}
</a>
