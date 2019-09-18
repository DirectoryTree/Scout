@extends('layouts.app')

@section('content')
    <form method="post" action="{{ route('connections.store') }}">
        @csrf
        @component('components.card')
            @slot('header', __('Create Connection'))

            @include('connections.form')

            @slot('footer')
                <div class="form-row justify-content-between">
                    <a href="{{ route('connections.index') }}" class="btn btn-secondary">
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
