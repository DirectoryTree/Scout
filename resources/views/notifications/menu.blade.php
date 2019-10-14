@component('components.card', ['class' => 'mb-4', 'flush' => true])
    <div class="list-group list-group-flush">
        <div class="list-group-item font-weight-bold">
            <h5 class="mb-0">Notifications</h5>
        </div>

        <a
            href="{{ current_route_filter(['unread' => 'yes']) }}"
            class="list-group-item list-group-item-action font-weight-bold {{ request('unread', 'yes') === 'yes' ? 'active' : null }}"
        >
            <i class="far fa-envelope"></i> {{ __('Unread') }}
        </a>

        <a
            href="{{ current_route_filter(['unread' => 'no']) }}"
            class="list-group-item list-group-item-action font-weight-bold {{ request('unread') === 'no' ? 'active' : null }}"
        >
            <i class="far fa-envelope-open"></i> {{ __('Read') }}
        </a>
    </div>
@endcomponent
