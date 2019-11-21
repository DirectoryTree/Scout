@extends('domains.layout')

@section('title', __('Edit Domain'))

@section('breadcrumbs', Breadcrumbs::render('domains.edit', $domain))

@section('page')
    <form method="post" action="{{ route('domains.update', $domain) }}" data-controller="form">
        @csrf
        @method('patch')

        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0 font-weight-bold text-secondary">{{ __('Edit Domain') }}</h6>
            </div>

            <div class="card-body bg-light">
                @include('domains.form')
            </div>

            <div class="card-footer">
                <div class="form-row justify-content-between">
                    <a href="{{ route('domains.index') }}" class="btn btn-secondary">
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
