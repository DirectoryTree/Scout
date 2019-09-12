@extends('layouts.base')

@push('scripts')
    <script src="{{ asset(mix('js/app.js')) }}" defer data-turbolinks-track="reload"></script>
@endpush

@push('styles')
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet" data-turbolinks-track="reload">
@endpush

@section('body')
    <div id="app" v-cloak>
        <main class="my-4">
            <div class="container">
                <div class="pt-4 text-center">
                    <i class="fa fa-3x fa-binoculars"></i>

                    <div class="my-4">
                        <h3>{{ config('app.name') }}</h3>
                    </div>
                </div>

                @yield('content')
            </div>
        </main>
    </div>
@endsection
