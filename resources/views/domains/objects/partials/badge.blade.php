<a
    href="{{ route('domains.objects.show', [$object['domain']['slug'], $object['id']]) }}"
    class="badge badge-light border badge-pill"
>
    @include('domains.objects.partials.icon')

    {{ $object['name'] }}

    @if($object->pinned)
        <i class="ml-1 fa fa-xs fa-thumbtack"></i>
    @endif
</a>
