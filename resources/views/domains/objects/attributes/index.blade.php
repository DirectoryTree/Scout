@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.objects.attributes.index', $domain, $object))

@section('page')
    @component('components.card', ['class' => 'bg-white', 'flush' => true])
        <div class="list-group list-group-flush">
            <div class="list-group-item">
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

                    <form
                        method="post"
                        action="{{ route('domains.objects.sync', [$domain, $object]) }}"
                        data-controller="forms--sync-object"
                        data-forms--sync-object-redirect="true"
                        data-forms--sync-object-message="Synchronized object."
                    >
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

            @include('domains.objects.attributes.table')
        </div>
    @endcomponent
@endsection
