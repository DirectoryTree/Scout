@inject('stats', 'App\Http\Injectors\NotificationStatsInjector')

<div class="card menu shadow-sm mb-4">
    <div class="card-body p-3">
        <div class="list-group list-group-flush">
            <div class="list-group-item font-weight-bold">
                <h5 class="mb-0">Notifications</h5>
            </div>

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
