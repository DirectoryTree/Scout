@extends('layouts.base')

@push('scripts')
    <script src="{{ asset(mix('js/app.js')) }}" data-turbolinks-track="reload"></script>
@endpush

@push('styles')
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet" data-turbolinks-track="reload">
@endpush

@section('body')
    <div id="app">
        <main class="my-4">
            <div class="container">
                <h3 class="my-4 text-center">
                    <i class="fa fa-binoculars"></i> {{ config('app.name') }}
                </h3>

                @yield('content')
            </div>
        </main>
    </div>
@endsection
