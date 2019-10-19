@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.create', $domain))

@section('page')
    <form method="post" action="{{ route('notifiers.notifiable.store', ['domain', $domain]) }}" data-controller="form">
        @csrf

        @component('components.card', ['class' => 'bg-white'])
            @slot('header')
                <h5 class="mb-0">
                    <i class="far fa-bell"></i> Add Domain Notifier
                </h5>
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
