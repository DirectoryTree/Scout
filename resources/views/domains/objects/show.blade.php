@extends('domains.objects.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.objects.show', $domain, $object))

@section('page')
    <div class="card bd-white shadow-sm">
        <div class="card-header border-bottom">
            <h6 class="mb-0 text-muted font-weight-bold">
                <i class="fa fa-level-down-alt"></i> {{ __('Nested Objects') }}
            </h6>
        </div>

        <div class="card-body p-0">
            @include('domains.objects.partials.list')
        </div>
    </div>
@endsection
