@extends('domains.objects.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.objects.attributes.index', $domain, $object))

@section('page')
    <div class="card bg-white shadow-sm">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column">
                    <h5 class="mb-0">Attributes</h5>

                    <small class="text-muted">
                        Updated

                        <span class="badge badge-secondary" title="{{ $object->updated_at }}">
                                    {{ $object->updated_at->diffForHumans() }}
                                </span>
                    </small>
                </div>

                <form method="post" action="{{ route('domains.objects.sync', [$domain, $object]) }}" data-controller="form">
                    @csrf
                    @method('patch')

                    <button
                        type="submit"
                        class="btn btn-sm btn-primary"
                        data-size="xs"
                        {{ $object->trashed() ? 'disabled' : null }}
                    >
                        <i class="fas fa-sync"></i> Sync
                    </button>
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @include('domains.objects.attributes.table')
            </div>
        </div>
    </div>
@endsection
