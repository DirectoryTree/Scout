@extends('domains.objects.layout')

@section('title', __(':attribute Changes', ['attribute' => ucfirst($attribute)]))

@section('breadcrumbs', Breadcrumbs::render('domains.objects.changes.show', $domain, $object, $attribute))

@section('page')
    <div class="card shadow-sm">
        <div class="card-header">
            <h6 class="mb-0">
                <strong>{{ ucfirst($attribute) }}</strong>
                changes on
                <strong>{{ $object->name }}</strong>
            </h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr class="text-muted text-uppercase bg-light">
                            <th class="pl-4 text-nowrap">
                                <i class="far fa-clock"></i> Changed
                            </th>
                            <th>New Value</th>
                            <th>Previous Value</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($changes as $change)
                        <tr>
                            <td class="pl-4 text-nowrap align-middle">
                                <span title="{{ $change->ldap_updated_at }}">
                                    {{ $change->ldap_updated_at->diffForHumans() }}
                                </span>
                            </td>
                            <td class="table-success align-middle">
                                @if (count($change->after) > 1)
                                    <ul class="pl-3 mb-0">
                                        @foreach($change->after as $value)
                                            <li>{{ $value }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{ $change->after[0] }}
                                @endif
                            </td>
                            <td class="table-danger align-middle">
                                @if (count($change->before) > 1)
                                    <ul class="pl-3 mb-0">
                                        @foreach($change->before as $value)
                                            <li>{{ $value }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    @if (array_key_exists(0, $change->before))
                                        {{ $change->before[0] }}
                                    @else
                                        <em class="text-muted">None</em>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="pl-4" colspan="3">There are no changes to list.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
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
