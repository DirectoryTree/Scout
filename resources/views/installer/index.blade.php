@extends('layouts.auth')

@section('content')
    @if($installer->hasSetup())
        @include('installer.migrate')
    @else
        @include('installer.setup')
    @endif
@endsection
