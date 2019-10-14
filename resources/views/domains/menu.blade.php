@component('components.card', ['class' => 'mb-4', 'flush' => true])
    <div class="list-group list-group-flush">
        <div class="list-group-item font-weight-bold">
            <h5 class="mb-0">Domain</h5>
        </div>

        <a
            href="{{ route('domains.show', $domain) }}"
            class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('domains.show') ? 'active' : null }}"
        >
            <i class="far fa-eye"></i> {{ __('Overview') }}
        </a>

        <a
            href="{{ route('domains.notifiers.index', $domain) }}"
            class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('domains.notifiers.*') ? 'active' : null }}"
        >
            <i class="far fa-bell"></i> Notifications
        </a>

        <a
            href="{{ route('domains.search.index', $domain) }}"
            class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('domains.search.*') ? 'active' : null }}"
        >
            <i class="fas fa-search"></i> {{ __('Search') }}
        </a>

        <a
            href="{{ route('domains.scans.index', $domain) }}"
            class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('domains.scans.*') ? 'active' : null }}"
        >
            <i class="fas fa-heartbeat"></i> {{ __('Recent Scans') }}
        </a>

        <a
            href="{{ route('domains.objects.index', $domain) }}"
            class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('domains.objects.index') ? 'active' : null }}"
        >
            <div class="d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-cubes"></i> {{ __('All Objects') }}
                            </span>

                <span class="badge badge-primary">{{ $counts['objects'] }}</span>
            </div>
        </a>

        <a
            href="{{ route('domains.changes.index', $domain) }}"
            class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('domains.changes.*') ? 'active' : null }}"
        >
            <div class="d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fa fa-sync"></i> {{ __('All Changes') }}
                            </span>

                <span class="badge badge-primary">{{ $counts['changes'] }}</span>
            </div>
        </a>

        <a
            href="{{ route('domains.edit', $domain) }}"
            class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('domains.edit') ? 'active' : null }}"
        >
            <i class="far fa-edit"></i> {{ __('Edit') }}
        </a>

        <a
            href="{{ route('domains.delete', $domain) }}"
            class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('domains.delete') ? 'active' : null }}"
        >
            <i class="far fa-trash-alt"></i> {{ __('Delete') }}
        </a>
    </div>
@endcomponent
