@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <h2>{{ __('Domains') }}</h2>
        </div>

        <div class="col text-right">
            <a href="{{ route('domains.create') }}" class="btn btn-success">
                <i class="fa fa-plus-circle"></i> {{ __('Add') }}
            </a>
        </div>
    </div>

    <hr/>

    <div class="row">
        <div class="col">
            @forelse($domains as $domain)
                @component('components.card')
                    <a class="h4" href="{{ route('domains.show', $domain) }}">
                        {{ $domain->name }}
                    </a>

                    <hr/>


                @endcomponent
            @empty
                @component('components.card')
                    {{ __("You don't have any domains configured.") }}
                @endcomponent
            @endforelse
        </div>
    </div>
@endsection
