@extends('domains.layout')

@section('title', __(':attribute Changes', ['attribute' => ucfirst($attribute)]))

@section('breadcrumbs', Breadcrumbs::render('domains.changes.show', $domain, $attribute))

@section('page')
    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h6 class="mb-0">
                <strong>{{ ucfirst($attribute) }}</strong> changes
            </h6>
        </div>

        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @forelse($changes as $change)
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="row flex-column">
                                    <div class="col">
                                        @include('domains.objects.partials.icon', ['object' => $change->object])

                                        <a href="{{ route('domains.objects.show', [$domain, $change->object]) }}" class="font-weight-bold">
                                            {{ $change->object->name }}
                                        </a>
                                    </div>

                                    <div class="col text-muted small">
                                        {{ $change->object->dn }}
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <a
                                    href="{{ route('domains.objects.changes.show', [$domain, $change->object, $change->attribute]) }}"
                                    title="{{ $change->ldap_updated_at }}"
                                >
                                    {{ $change->ldap_updated_at->diffForHumans() }}
                                </a>
                            </div>
                        </div>
                    </div>
                @empty

                @endforelse
            </div>
        </div>
    </div>

    <div class="row my-4">
        <div class="col">
            <div class="d-flex justify-content-center">
                {{ $changes->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
