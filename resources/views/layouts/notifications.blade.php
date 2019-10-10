<li class="nav-item dropdown" data-controller="notifications" data-notifications-url="{{ route('api.notifications') }}">
    <a
        href="#"
        class="nav-link dropdown-toggle"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
    >
        <i class="far fa-bell"></i>
        <span data-target="notifications.count">0</span>
        <span class="caret"></span>
    </a>

    <div class="dropdown-menu dropdown-menu-right notifications">
        <h6 class="dropdown-header bg-white">Notifications</h6>

        <div data-target="notifications.list">
            @foreach($notifications as $notification)
                @include('notifications.notification')
            @endforeach
        </div>

        <div class="dropdown-divider"></div>

        <div class="p-2 px-3">
            <a class="btn btn-block btn-sm btn-primary" href="#">View All</a>
        </div>
    </div>
</li>
