@extends('domains.objects.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.objects.changes.show', $domain, $object, $attribute))

@section('page')
    @component('components.card', ['class' => 'bg-white', 'flush' => true])
        <div class="list-group list-group-flush">
            <div class="list-group-item">
                <h5 class="mb-0">
                    <strong>{{ ucfirst($attribute) }}</strong>
                    changes on
                    <strong>{{ $object->name }}</strong>
                </h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
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
                                    <span title="{{ $change->created_at }}">
                                        {{ $change->created_at->diffForHumans() }}
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
    @endcomponent

    <div class="row my-4">
        <div class="col">
            <div class="d-flex justify-content-center">
                {{ $changes->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
