@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-4 col-12">
            @yield('menu')

            @include('settings.menu')
        </div>

        <div class="col-lg-9 col-md-8 col-12">
            @yield('page')
        </div>
    </div>
@endsection
