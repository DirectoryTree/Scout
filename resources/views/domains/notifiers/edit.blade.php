@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.edit', $domain, $notifier))

@section('page')
    <div data-controller="conditions">
        @component('components.card')
            @slot('header')
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="far fa-flag"></i> Notifier Conditions
                    </h5>

                    <button
                        type="button"
                        class="btn btn-sm btn-primary"
                        data-action="click->conditions#open"
                        data-target="conditions.button"
                    >
                        <i class="fa fa-plus-circle"></i> Add New Condition
                    </button>
                </div>
            @endslot

            <form
                method="post"
                action="{{ route('notifiers.conditions.store', $notifier) }}"
                class="rounded border p-3 bg-white mb-4 d-none"
                data-controller="forms--condition"
                data-target="conditions.container"
            >
                @include('domains.notifiers.conditions.form', ['condition' => new \App\LdapNotifierCondition()])

                <div class="form-row justify-content-between">
                    <button type="button" class="btn btn-secondary" data-action="click->conditions#close">
                        <i class="fa fa-times-circle"></i> {{ __('Cancel') }}
                    </button>

                    <button type="submit" class="ml-auto btn btn-success">
                        <i class="fa fa-save"></i> {{ __('Save') }}
                    </button>
                </div>
            </form>

            @forelse($notifier->conditions as $condition)
                <form
                    method="post"
                    action="{{ route('domains.notifiers.store', $domain) }}"
                    data-controller="forms--condition"
                    class="rounded border p-3 bg-white mb-4"
                >
                    @csrf
                    @include('domains.notifiers.conditions.form')

                    <div class="form-row justify-content-between">
                        <a href="{{ route('domains.notifiers.index', $domain) }}" class="btn btn-secondary">
                            <i class="fa fa-times-circle"></i> {{ __('Cancel') }}
                        </a>

                        <button type="submit" class="ml-auto btn btn-success">
                            <i class="fa fa-save"></i> {{ __('Save') }}
                        </button>
                    </div>
                </form>
            @empty
                <div id="alert-no-notifiers" class="alert alert-primary">
                    There are no conditions for this notifier.
                </div>
            @endforelse
        @endcomponent
    </div>
@endsection
