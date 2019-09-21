@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('domains.show', $domain))

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h3 class="flex-shrink-1 pr-2">{{ $domain->name }}</h3>

        <div class="flex-grow-1 text-muted">
            {{ $domain->base_dn }}
        </div>
    </div>

    <div class="row">
        <div class="col">
            @component('components.card')
                <a href="{{ route('domains.objects.index', $domain) }}">
                    Objects
                </a>
            @endcomponent
        </div>
    </div>
@endsection
