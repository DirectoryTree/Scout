@extends('layouts.app')

@section('content')
    <div class="mb-2">
        <h3 class="d-flex justify-content-start mb-0 mr-2 overflow-x">
            @yield('name', $domain->name)
        </h3>

        <div class="text-muted overflow-x">
            @yield('dn', $domain->base_dn)
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-4 col-12">
            @yield('menu')

            @include('domains.menu')
        </div>

        <div class="col-lg-9 col-md-8 col-12">
            @yield('page')
        </div>
    </div>
@endsection
