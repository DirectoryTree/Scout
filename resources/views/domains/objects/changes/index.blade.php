@extends('domains.objects.layout')

@section('title', __(':name Changes', ['name' => $object->name]))

@section('breadcrumbs', Breadcrumbs::render('domains.objects.changes.index', $domain, $object))

@section('page')
    <div class="card shadow-sm overflow-hidden">
        <div class="card-header">
            <h6 class="mb-0 text-muted">
                <i class="fa fa-sync"></i> Changes
            </h6>
        </div>

        <div class="card-body bg-white p-0">
            <div class="list-group list-group-flush overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="text-uppercase text-muted bg-light">
                                <th class="pl-4">Attribute</th>
                                <th class="text-center">Times Changed</th>
                                <th>
                                    <i class="far fa-clock"></i> Last Change
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($changes as $change)
                            <tr>
                                <td class="pl-4 position-relative">
                                    <a
                                        class="stretched-link"
                                        href="{{ route('domains.objects.changes.show', [$domain, $object, $change->attribute]) }}"
                                    >
                                        {{ $change->attribute }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $change->count }}</td>
                                <td>
                                    <span title="{{ $change->ldap_updated_at }}">
                                        {{ $change->ldap_updated_at->diffForHumans() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    <em>There are no changes to list.</em>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
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
