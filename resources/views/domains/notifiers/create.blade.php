@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.create', $domain))

@section('page')
    <form method="post" action="{{ route('domains.notifiers.store', $domain) }}">
        @csrf

        @component('components.card')
            @slot('header')
                <h4 class="mb-0">Add Domain Notifier</h4>
            @endslot

            @include('domains.notifiers.form')

            @slot('footer')
                <div class="form-row justify-content-between">
                    <a href="{{ route('domains.notifiers.index', $domain) }}" class="btn btn-secondary">
                        <i class="fa fa-times-circle"></i> {{ __('Cancel') }}
                    </a>

                    <button type="submit" class="ml-auto btn btn-success">
                        <i class="fa fa-save"></i> {{ __('Save') }}
                    </button>
                </div>
            @endslot
        @endcomponent
    </form>
@endsection
