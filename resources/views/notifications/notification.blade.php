<div
    class="dropdown-item notification py-2 {{ $notification->read() ? 'bg-light' : null }}"
    data-target="notifications.notification"
    data-action="click->notifications#view"
    data-read="{{ $notification->read() }}"
    data-notifications-url="{{ route('notifications.show', $notification) }}"
>
    @include('domains.objects.partials.badge', ['object' => $notification->data['object']])

    <small>{{ $notification->data['notifier']['name'] }}</small>
</div>
