@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.changes.index', $domain))

@section('page')
    @component('components.card', ['class' => 'bg-white', 'flush' => true])
        @slot('header')
            <h5 class="mb-0">All Changes</h5>
        @endslot

        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="pl-4">Attribute</th>
                        <th class="text-center">Objects Changed</th>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">
                                <em>There are no changes to list.</em>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endcomponent
@endsection
