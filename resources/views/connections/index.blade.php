@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <h2>{{ __('Connections') }}</h2>
        </div>

        <div class="col text-right">
            <a href="{{ route('connections.create') }}" class="btn btn-success">
                <i class="fa fa-plus-circle"></i> {{ __('Add') }}
            </a>
        </div>
    </div>

    <hr/>

    <div class="row">
        <div class="col">
            @forelse($connections as $connection)

            @empty
                @component('components.card')
                    {{ __("You don't have any connections configured.") }}
                @endcomponent
            @endforelse
        </div>
    </div>
@endsection
