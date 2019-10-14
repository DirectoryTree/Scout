<a
    href="{{ route('domains.objects.show', [$object->domain, $object]) }}"
    class="badge badge-light border badge-pill"
>
    @include('domains.objects.partials.icon') {{ $object->name }}
</a>
