@extends('layouts.app')

@section('content')
    {{-- TODO: Add ability to pin things to this bar. --}}
    @component('components.card', ['class' => 'mb-3'])
        <h5 class="d-flex justify-content-start mb-0 mr-2 overflow-x">
            @yield('name', $domain->name)
        </h5>

        <div class="text-muted overflow-x">
            @yield('dn', $domain->base_dn)
        </div>
    @endcomponent

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
