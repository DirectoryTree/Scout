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
                <div class="d-flex justify-content-center">
                    <img style="width:200px;" src="{{ asset('img/logo-circle.png') }}" alt="Scout logo">
                </div>

                @yield('content')
            </div>
        </main>
    </div>
@endsection
