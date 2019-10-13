<a
    href="#"
    class="dropdown-item py-2 {{ $notification->read() ? 'bg-light' : null }}"
    data-target="notifications.notification"
    data-read="{{ $notification->read() }}"
>
    @include('domains.objects.partials.badge', ['object' => $notification->notifiable])

    <small>{{ $notification->data['name'] }}</small>
</a>
