@inject('notifications', 'App\Http\Injectors\NotificationInjector')

@php($unreadNotifications = $notifications->get())

<li
    class="nav-item dropdown"
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
        <span class="pr-1">
            <i class="far fa-bell pr-1"></i>
            <span class="d-inline d-md-none">{{ __('Notifications') }}</span>
        </span>

        <span data-target="notifications.count">{{ $unreadNotifications->count() }}</span>
        <span class="pl-1 caret"></span>
    </a>

    <div class="dropdown-menu dropdown-menu-right notifications">
        <h6 class="text-secondary text-center font-weight-bold">Notifications</h6>

        <hr class="m-0"/>

        <div data-target="notifications.list">
            @foreach($unreadNotifications as $notification)
                @include('notifications.notification')
            @endforeach
        </div>

        <div class="dropdown-item text-muted text-center py-2" data-target="notifications.empty">
            You have no notifications.
        </div>

        <hr class="m-0"/>

        <div class="pt-2 px-3">
            <a class="btn btn-block btn-sm btn-primary" href="{{ route('notifications.index') }}">View All</a>
        </div>
    </div>
</li>
