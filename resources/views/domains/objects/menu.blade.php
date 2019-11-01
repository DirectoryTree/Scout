@component('components.card', ['class' => 'menu mb-4', 'flush' => true])
    <div class="list-group list-group-flush">
        <div class="list-group-item font-weight-bold">
            <h6 class="mb-0 text-black-50 font-weight-bold">Object</h6>
            <h4 class="mb-0 text-secondary font-weight-bold">{{ $object->name }}</h4>
        </div>

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

        @if(!$domain->canModifyPasswords())
            <a
                href="#"
                class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('domains.objects.password.*') ? 'active' : null }}"
            >
                <i class="fa fa-key"></i> {{ __('Reset Password') }}
            </a>
        @endif
    </div>
@endcomponent
