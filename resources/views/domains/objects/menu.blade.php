<div class="card menu bg-white shadow-sm rounded mb-4" data-controller="menu">
    <div class="card-header pt-4">
        <h6 class="mb-0 text-black-50 font-weight-bold">Object</h6>
        <h4 class="mb-0 text-secondary font-weight-bold">{{ $object->name }}</h4>
    </div>

    <div class="card-body pt-0">
        <div class="list-group list-group-flush d-none d-md-block mb-4 mb-md-0" data-target="menu.container">
            <a
                href="{{ route('domains.objects.show', [$domain, $object]) }}"
                class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('domains.objects.show') ? 'active' : null }}"
            >
                <i class="far fa-eye"></i> Overview
            </a>

            <a href="#" class="list-group-item list-group-item-action font-weight-bold">
                <i class="far fa-bell"></i> Notifications
            </a>

            <a
                href="{{ route('domains.objects.attributes.index', [$domain, $object]) }}"
                class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('domains.objects.attributes.*') ? 'active' : null }}"
            >
                <div class="d-flex justify-content-between align-items-center">
                <span>
                    <i class="fa fa-list-ul"></i> {{ __('Attributes') }}
                </span>

                    <span class="badge badge-primary">{{ count($object->values) }}</span>
                </div>
            </a>

            <a
                href="{{ route('domains.objects.changes.index', [$domain, $object]) }}"
                class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('domains.objects.changes.*') ? 'active' : null }}"
            >
                <div class="d-flex justify-content-between align-items-center">
                <span>
                    <i class="fa fa-sync"></i> {{ __('Changes') }}
                </span>

                    <span class="badge badge-primary">{{ $object->changes()->count() }}</span>
                </div>
            </a>

            @if($object->canHaveGroups())
                <a
                    href="#"
                    class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('domains.objects.groups.*') ? 'active' : null }}"
                >
                    <i class="fa fa-users"></i> {{ __('Groups') }}
                </a>
            @endif

            {{-- Domain write back menu items. --}}
            @if(!$domain->canModifyPasswords())
                <a
                    href="#"
                    class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('domains.objects.password.*') ? 'active' : null }}"
                >
                    <i class="fa fa-key"></i> {{ __('Reset Password') }}
                </a>
            @endif
        </div>

        <button
            type="button"
            class="btn btn-sm btn-block btn-outline-secondary d-block d-md-none"
            data-target="menu.toggleButton"
        ></button>

        <hr/>

        @if($object->pinned)
            <form method="post" action="{{ route('objects.pin.destroy', $object) }}" data-controller="form">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-block btn-primary">
                    <i class="fa fa-thumbtack"></i> Unpin from Dashboard
                </button>
            </form>
        @else
            <form method="post" action="{{ route('objects.pin.store', $object) }}" data-controller="form">
                @csrf
                <button type="submit" class="btn btn-sm btn-block btn-primary">
                    <i class="fa fa-thumbtack"></i> Pin to Dashboard
                </button>
            </form>
        @endif
    </div>
</div>
