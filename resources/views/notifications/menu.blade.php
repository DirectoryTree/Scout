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

                    <span class="badge badge-primary">{{ $counts['unread'] }}</span>
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

                    <span class="badge badge-primary">{{ $counts['read'] }}</span>
                </div>
            </a>
        </div>
    </div>
</div>
