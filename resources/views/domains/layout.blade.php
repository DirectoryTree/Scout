@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="flex-shrink-1 pr-2">{{ $domain->name }}</h3>

        <div class="flex-grow-1 text-muted">
            {{ $domain->base_dn }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <form-confirm
                action="{{ route('domains.destroy', $domain) }}"
                method="post"
                title="Delete domain?"
                message="You cannot undo this action."
            >
                @csrf
                @method('DELETE')

                <button id="delete-domain-btn" type="submit" class="d-none"></button>
            </form-confirm>

            @isset($object)
                @component('components.card', ['class' => 'mb-4', 'flush' => true])
                    <div class="list-group list-group-flush">
                        <div class="list-group-item font-weight-bold">
                            <h5 class="mb-0">{{ $object->name }}</h5>
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

                                <span class="badge badge-primary">{{ $counts['object']['attributes'] }}</span>
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

                                <span class="badge badge-primary">{{ $counts['object']['changes'] }}</span>
                            </div>
                        </a>
                    </div>
                @endcomponent
            @endisset

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
                        href="{{ route('domains.show', $domain) }}"
                        class="list-group-item list-group-item-action font-weight-bold"
                    >
                        <i class="fas fa-search"></i> {{ __('Recent Scans') }}
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
                        href="#"
                        class="list-group-item list-group-item-action font-weight-bold"
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
                        class="list-group-item list-group-item-action font-weight-bold"
                    >
                        <i class="fa fa-edit"></i> {{ __('Edit') }}
                    </a>

                    <a
                        href="#"
                        class="list-group-item list-group-item-action font-weight-bold"
                        onclick="event.preventDefault();document.getElementById('delete-domain-btn').click();">
                        <i class="fa fa-trash"></i> {{ __('Delete') }}
                    </a>
                </div>
            @endcomponent
        </div>

        <div class="col-md-9">
            @yield('page')
        </div>
    </div>
@endsection
