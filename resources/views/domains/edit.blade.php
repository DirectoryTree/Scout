@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.edit', $domain))

@section('page')
    <form
        method="post"
        action="{{ route('domains.update', $domain) }}"
        data-controller="forms--domain"
        data-forms--domain-message="Updated domain configuration."
    >
        @csrf
        @method('patch')

        @component('components.card')
            @slot('header')
                <h5 class="mb-0">{{ __('Edit Domain') }}</h5>
            @endslot

            @include('domains.form')

            @slot('footer')
                <div class="form-row justify-content-between">
                    <a href="{{ route('domains.index') }}" class="btn btn-secondary">
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
