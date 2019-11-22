<div class="card menu bg-white shadow-sm rounded mb-4 mb-md-0" data-controller="menu">
    <div class="card-header pt-4">
        <h6 class="mb-0 text-black-50 font-weight-bold">Scout</h6>
        <h4 class="mb-0 text-secondary font-weight-bold">Settings</h4>
    </div>

    <div class="card-body pt-0">
        <div class="list-group list-group-flush d-none d-md-block" data-target="menu.container">
            <a
                href="{{ route('settings.edit') }}"
                class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('settings.edit') ? 'active' : null }}"
            >
                <i class="fas fa-tools"></i> {{ __('Application') }}
            </a>

            <a
                href="{{ route('settings.users.index') }}"
                class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('settings.users.*') ? 'active' : null }}"
            >
                <i class="fas fa-user-friends"></i> {{ __('Users') }}
            </a>

            <a
                href="{{ route('settings.email.edit') }}"
                class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('settings.email.edit') ? 'active' : null }}"
            >
                <i class="fas fa-envelope-open-text"></i> {{ __('Email') }}
            </a>

            <a
                href="#"
                class="list-group-item list-group-item-action font-weight-bold {{ request()->routeIs('settings.email') ? 'active' : null }}"
            >
                <i class="fas fa-mail-bulk"></i> {{ __('Notifications') }}
            </a>
        </div>

        <button type="button" class="btn btn-sm btn-block btn-outline-secondary d-block d-md-none" data-target="menu.toggleButton"></button>
    </div>
</div>
