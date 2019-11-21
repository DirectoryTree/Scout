@extends('domains.layout')

@section('title', __('Domain Changes'))

@section('breadcrumbs', Breadcrumbs::render('domains.changes.index', $domain))

@section('page')
    <div class="card shadow-sm bg-white">
        <div class="card-header">
            <h6 class="mb-0 text-muted font-weight-bold">
                <i class="fa fa-sync"></i> All Changes
            </h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr class="text-uppercase text-muted bg-light">
                            <th class="pl-4">Attribute</th>
                            <th class="text-center">Objects Changed</th>
                            <th class="text-center">Last Changed</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($changes as $change)
                        <tr>
                            <td class="pl-4 position-relative">
                                <a href="{{ route('domains.changes.show', [$domain, $change->attribute]) }}" class="stretched-link">
                                    {{ $change->attribute }}
                                </a>
                            </td>
                            <td class="text-center">{{ $change->count }}</td>
                            <td class="text-center">
                                {{ $change->ldap_updated_at->diffForHumans() }}

                                <small>({{ $change->ldap_updated_at }})</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                <em>There are no changes to list.</em>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
