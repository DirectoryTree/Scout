@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.edit', $domain, $notifier))

@section('page')
    <div data-controller="hidden">
        @component('components.card')
            @slot('header')
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="far fa-flag"></i> Notifier Conditions
                    </h5>

                    <button
                        type="button"
                        class="btn btn-sm btn-primary"
                        data-action="click->hidden#open"
                        data-target="hidden.button"
                    >
                        <i class="fa fa-plus-circle"></i> Add New Condition
                    </button>
                </div>
            @endslot

            <form
                method="post"
                action="{{ route('domains.notifiers.store', $domain) }}"
                class="rounded border p-3 bg-white mb-4 d-none"
                data-controller="forms--condition"
                data-target="hidden.container"
            >
                @include('domains.notifiers.form', ['condition' => new \App\LdapNotifierCondition()])

                <div class="form-row justify-content-between">
                    <button type="button" class="btn btn-secondary" data-action="click->hidden#close">
                        <i class="fa fa-times-circle"></i> {{ __('Cancel') }}
                    </button>

                    <button type="submit" class="ml-auto btn btn-success">
                        <i class="fa fa-save"></i> {{ __('Save') }}
                    </button>
                </div>
            </form>

            @foreach($notifier->conditions as $condition)
                <form
                    method="post"
                    action="{{ route('domains.notifiers.store', $domain) }}"
                    data-controller="forms--condition"
                    class="rounded border p-3 bg-white mb-4"
                >
                    @csrf
                    @include('domains.notifiers.form')

                    <div class="form-row justify-content-between">
                        <a href="{{ route('domains.notifiers.index', $domain) }}" class="btn btn-secondary">
                            <i class="fa fa-times-circle"></i> {{ __('Cancel') }}
                        </a>

                        <button type="submit" class="ml-auto btn btn-success">
                            <i class="fa fa-save"></i> {{ __('Save') }}
                        </button>
                    </div>
                </form>
            @endforeach
        @endcomponent
    </div>
@endsection
