@extends('layouts.app')

@section('content')
    @component('components.card', ['class' => 'bg-white'])
        @slot('header')
            <h4 class="mb-0">Dashboard</h4>
        @endslot

        Welcome to Scout!
    @endcomponent
@endsection
