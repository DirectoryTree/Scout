<div
    class="dropdown-item notification py-2"
    data-target="notifications.notification"
    data-action="click->notifications#view"
    data-read="{{ $notification->read() }}"
    data-notifications-url="{{ route('notifications.show', $notification) }}"
>
    @include('domains.objects.partials.badge', ['object' => $notification->object])

    <small>{{ optional($notification->notifier)->name }}</small>
</div>
