@extends('layouts.base')

@inject('domains', 'App\Http\Injectors\DomainInjector')

@php($addedDomains = $domains->get())

@section('head')
    <script src="{{ asset(mix('js/app.js')) }}" data-turbolinks-track="reload"></script>
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet" data-turbolinks-track="reload">
@endsection

@section('body')
    @include('search.partials.modal')

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-app shadow-sm">
            <div class="container">
                <a class="navbar-brand font-weight-bold" href="{{ url('/') }}">
                    <i class="fa fa-binoculars"></i> {{ config('app.name', 'Scout') }}
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-navigation" aria-controls="app-navigation" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="app-navigation">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : null }}">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="fa fa-tachometer-alt"></i> {{ __('Dashboard') }}
                            </a>
                        </li>

                        <li class="nav-item dropdown {{ request()->routeIs('domains.*') ? 'active' : null }}">
                            <a id="dropdown-domains" class="nav-link dropdown-toggle" href="{{ route('domains.index') }}" data-toggle="dropdown">
                                <i class="fa fa-network-wired"></i> {{ __('Domains') }}

                                @component('components.status-count', ['count' => $addedDomains->count()])
                                    {{ $addedDomains->count() }}
                                @endcomponent

                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdown-domains">
                                @forelse($addedDomains as $domain)
                                    <a href="{{ route('domains.show', $domain) }}" class="dropdown-item d-flex align-items-center">
                                        @component('components.status', [
                                            'status' => $domain->status == \App\LdapDomain::STATUS_ONLINE
                                        ])@endcomponent

                                        <span class="ml-2">
                                            {{ $domain->name }}
                                        </span>
                                    </a>
                                @empty
                                    <a href="{{ route('domains.create') }}" class="dropdown-item">
                                        <i class="fa fa-plus-circle"></i> Add
                                    </a>
                                @endforelse

                                <div class="dropdown-divider"></div>

                                <a href="{{ route('domains.index') }}" class="dropdown-item">
                                    View All
                                </a>
                            </div>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="#" class="nav-link" data-toggle="modal" data-target="#search-modal">
                                <i class="fa fa-search"></i>
                                <span class="d-inline d-md-none">{{ __('Search') }}</span>
                            </a>
                        </li>

                        @include('layouts.notifications')

                        <li class="nav-item dropdown">
                            <a id="dropdown-user" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-user-circle"></i>
                                {{ Auth::user()->name }}
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                                <a href="{{ route('settings.edit') }}" class="dropdown-item">
                                    <i class="fa fa-cogs"></i> Settings
                                </a>

                                <div class="dropdown-divider"></div>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                >
                                    <i class="fa fa-sign-out-alt"></i> {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="my-4">
            <div class="container">
                @yield('breadcrumbs')

                @yield('content')
            </div>
        </main>
    </div>
@endsection
