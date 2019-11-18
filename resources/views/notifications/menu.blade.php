@inject('stats', 'App\Http\Injectors\NotificationStatsInjector')

<div class="card menu bg-white shadow-sm rounded mb-4 mb-md-0" data-controller="menu">
    <div class="card-header pt-4">
        <h4 class="mb-0 text-muted font-weight-bold">{{ __('Notifications') }}</h4>
    </div>

    <div class="card-body p-3">
        <div class="list-group list-group-flush d-none d-md-block" data-target="menu.container">
            <a
                href="{{ current_route_filter(['unread' => 'yes']) }}"
                class="list-group-item list-group-item-action font-weight-bold {{ request('unread', 'yes') === 'yes' ? 'active' : null }}"
            >
                <div class="d-flex justify-content-between align-items-center">
                <span>
                    <i class="far fa-envelope"></i> {{ __('Unread') }}
                </span>

                    <span class="badge badge-primary">{{ $stats->getUnreadCount() }}</span>
                </div>
            </a>

            <a
                href="{{ current_route_filter(['unread' => 'no']) }}"
                class="list-group-item list-group-item-action font-weight-bold {{ request('unread') === 'no' ? 'active' : null }}"
            >
                <div class="d-flex justify-content-between align-items-center">
                <span>
                    <i class="far fa-envelope-open"></i> {{ __('Read') }}
                </span>

                    <span class="badge badge-primary">{{ $stats->getReadCount() }}</span>
                </div>
            </a>
        </div>

        <button
            type="button"
            class="btn btn-sm btn-block btn-outline-secondary d-block d-md-none"
            data-target="menu.toggleButton"
        ></button>

        @if(request('unread', 'yes') === 'yes')
            <hr/>

            <form method="post" action="{{ route('notifications.mark.all') }}" data-controller="form">
                @csrf
                @method('patch')

                <button type="submit" class="btn btn-sm btn-block btn-outline-primary">
                    <i class="far fa-check-circle"></i>
                    Mark All As Read
                </button>
            </form>
        @endif
    </div>
</div>
