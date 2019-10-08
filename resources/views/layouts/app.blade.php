@extends('layouts.base')

@section('head')
    <script src="{{ asset(mix('js/app.js')) }}" data-turbolinks-track="reload"></script>
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet" data-turbolinks-track="reload">
@endsection

@section('body')
    <div id="app" v-cloak>
        @include('layouts.flash')

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
                        @auth
                            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : null }}">
                                <a class="nav-link" href="{{ route('dashboard') }}">
                                    <i class="fa fa-tachometer-alt"></i> {{ __('Dashboard') }}
                                </a>
                            </li>

                            <li class="nav-item {{ request()->routeIs('domains.*') ? 'active' : null }}">
                                <a class="nav-link" href="{{ route('domains.index') }}">
                                    <i class="fa fa-network-wired"></i> {{ __('Domains') }}

                                    @component('components.status-count', ['count' => $counts['domains']])
                                        {{ $counts['domains'] }}
                                    @endcomponent
                                </a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fa fa-sign-in-alt"></i>
                                    {{ __('Login') }}
                                </a>
                            </li>
                        @else
                            <notifications url="{{ route('api.notifications') }}"></notifications>

                            <li class="nav-item dropdown">
                                <a id="user-dropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa fa-user-circle"></i>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="user-dropdown">
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
                        @endguest
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
