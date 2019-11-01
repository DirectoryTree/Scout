@extends('layouts.app')

@section('content')
    {{-- TODO: Add ability to pin things to this bar. --}}
    {{--
     @component('components.card', ['class' => 'mb-3'])

    @endcomponent
    --}}

    <div class="row">
        <div class="col-lg-3 col-md-4 col-12 bg-white shadow-sm rounded">
            @yield('menu')

            @include('domains.menu')
        </div>

        <div class="col-lg-9 col-md-8 col-12">
            @yield('page')
        </div>
    </div>
@endsection
