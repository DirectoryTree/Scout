@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('domains.objects.show', $domain, $object))

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h3 class="flex-shrink-1 pr-2">{{ $domain->name }}</h3>

        <div class="flex-grow-1 text-muted">
            {{ $domain->base_dn }}
        </div>
    </div>

    @include('domains.objects.partials.list')
@endsection
