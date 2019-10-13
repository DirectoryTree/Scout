@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('domains.create'))

@section('content')
    <form method="post" action="{{ route('domains.store') }}" data-controller="form-xhr">
        @csrf

        @component('components.card')
            @slot('header', __('Add Domain'))

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
