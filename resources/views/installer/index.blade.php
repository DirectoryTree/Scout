@extends('layouts.auth')

@section('content')
    @if($installer->hasBeenSetup())
        @include('installer.migrate')
    @else
        @include('installer.setup')
    @endif
@endsection
