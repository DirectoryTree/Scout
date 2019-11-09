@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.edit', $domain, $notifier))

@section('page')
    <form method="post" action="{{ route('notifiers.update', $notifier) }}" data-controller="form" class="mb-4">
        @csrf
        @method('patch')

        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0 font-weight-bold text-secondary">
                    <i class="far fa-bell"></i> Edit Domain Notifier
                </h6>
            </div>

            <div class="card-body bg-light">
                @include('domains.notifiers.form')
            </div>

            <div class="card-footer">
                <div class="form-row justify-content-between">
                    <a href="{{ route('domains.notifiers.show', [$domain, $notifier]) }}" class="btn btn-secondary">
                        <i class="fa fa-times-circle"></i> {{ __('Cancel') }}
                    </a>

                    <button type="submit" class="ml-auto btn btn-success">
                        <i class="fa fa-save"></i> {{ __('Save') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
