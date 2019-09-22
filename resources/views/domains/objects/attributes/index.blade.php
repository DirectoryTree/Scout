@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.objects.attributes.index', $domain, $object))

@section('page')
    @component('components.card', ['class' => 'bg-white', 'flush' => true])
        <div class="list-group list-group-flush">
            <div class="list-group-item">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-0">Attributes</h5>

                    <div class="text-muted">
                        Updated

                        <span class="badge badge-secondary" title="{{ $object->updated_at }}">
                            {{ $object->updated_at->diffForHumans() }}
                        </span>
                    </div>
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
                    @forelse($object->attributes as $name => $values)
                        <tr>
                            <td class="pl-4 align-middle">{{ $name }}</td>
                            <td class="bg-light">
                                @if(count($values) > 1)
                                    @foreach ($values as $value)
                                        {{ $value }}{{ !$loop->last ? ',' : null }}
                                    @endforeach
                                @else
                                    {{ $values[0] }}
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
