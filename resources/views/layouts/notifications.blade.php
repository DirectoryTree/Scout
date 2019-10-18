<li
    class="nav-item dropdown d-flex align-items-center"
    data-controller="notifications"
    data-notifications-url="{{ route('api.notifications.index') }}"
>
    <a
        href="#"
        class="nav-link dropdown-toggle d-flex align-items-center"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
    >
        <i class="far fa-bell pr-1"></i>
        <span data-target="notifications.count">{{ $notifications->count() }}</span>
        <span class="pl-1 caret"></span>
    </a>

    <div class="dropdown-menu dropdown-menu-right notifications">
        <h6 class="dropdown-header bg-white">Notifications</h6>

        <div class="dropdown-divider m-0"></div>

        <div data-target="notifications.list">
            @foreach($notifications as $notification)
                @include('notifications.notification')
            @endforeach
        </div>

        <div class="dropdown-item text-muted text-center py-2" data-target="notifications.empty">
            You have no notifications.
        </div>

        <div class="dropdown-divider m-0"></div>

        <div class="p-2 px-3">
            <a class="btn btn-block btn-sm btn-primary" href="{{ route('notifications.index') }}">View All</a>
        </div>
    </div>
</li>
