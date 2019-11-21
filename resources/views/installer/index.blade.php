@extends('layouts.auth')

@section('title', __('Install'))

@section('content')
    @if($installer->hasBeenSetup())
        @include('installer.migrate')
    @else
        @include('installer.setup')
    @endif
@endsection
