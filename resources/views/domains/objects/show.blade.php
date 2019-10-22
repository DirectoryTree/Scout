@extends('domains.objects.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.objects.show', $domain, $object))

@section('page')
    @component('components.card', ['class' => 'bg-white', 'flush' => true])
        @slot('header')
            <h5 class="mb-0">
                <i class="fa fa-level-down-alt"></i> {{ __('Nested Objects') }}
            </h5>
        @endslot

        @include('domains.objects.partials.list')
    @endcomponent
@endsection
