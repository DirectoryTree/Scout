@extends('domains.objects.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.objects.attributes.index', $domain, $object))

@section('page')
    <div class="card bg-white shadow-sm">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="text-muted font-weight-bold mb-0">Attributes</h6>

                <small class="text-muted">
                    Updated

                    <span class="badge badge-secondary" title="{{ $object->updated_at }}">
                        {{ $object->updated_at->diffForHumans() }}
                    </span>
                </small>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @include('domains.objects.attributes.table')
            </div>
        </div>
    </div>
@endsection
