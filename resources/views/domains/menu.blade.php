@inject('stats', 'App\Http\Injectors\DomainStatsInjector')

<div class="card menu bg-white shadow-sm rounded mb-4 mb-md-0" data-controller="menu">
    <div class="card-header pt-4">
        <h6 class="mb-0 text-black-50 font-weight-bold">Domain</h6>
        <h4 class="mb-0 text-secondary font-weight-bold">{{ $domain->name }}</h4>
    </div>

    <div class="card-body pt-0">
        <div class="list-group list-group-flush d-none d-md-block" data-target="menu.container">
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

                    <span class="badge badge-primary">{{ $stats->getObjectCount() }}</span>
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

                    <span class="badge badge-primary">{{ $stats->getChangeCount() }}</span>
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

        <button type="button" class="btn btn-sm btn-block btn-outline-secondary d-block d-md-none" data-target="menu.toggleButton"></button>
    </div>
</div>
