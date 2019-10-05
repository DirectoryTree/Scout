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

                    <form method="post" action="{{ route('domains.objects.sync', [$domain, $object]) }}">
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

            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="pl-4">Name</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($attributes as $name => $values)
                        <tr>
                            <td class="pl-4 align-middle">{{ $name }}</td>
                            <td class="bg-light">
                                @if(count($values) > 1)
                                    @foreach ($values as $value)
                                        {{ $value }}{{ !$loop->last ? ',' : null }}
                                    @endforeach
                                @else
                                    @if($values[0] instanceof \Carbon\Carbon)
                                        {{ $values[0]->diffForHumans() }}

                                        <small class="text-muted">{{ $values[0]->toDateTimeString() }}</small>
                                    @else
                                        {{ $values[0] }}
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="pl-4" colspan="2">There are no attributes to list.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endcomponent
@endsection
