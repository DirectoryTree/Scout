@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.objects.changes.index', $domain, $object))

@section('page')
    @component('components.card', ['class' => 'bg-white', 'flush' => true])
        <div class="list-group list-group-flush">
            <div class="list-group-item">
                <h5 class="mb-0">Changes</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
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
    @endcomponent

    <div class="row my-4">
        <div class="col">
            <div class="d-flex justify-content-center">
                {{ $changes->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
