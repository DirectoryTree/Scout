@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.index', $domain))

@section('page')
    @component('components.card', ['flush' => true])
        @slot('header')
            <div class="d-flex justify-content-between">
                <h4 class="mb-0">Domain Notifiers</h4>

                <a href="{{ route('domains.notifiers.create', $domain) }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus-circle"></i> Add
                </a>
            </div>
        @endslot

        <div class="list-group list-group-flush">
            @forelse($notifiers as $notifier)
                <div class="list-group-item">
                    
                </div>
            @empty
                <div class="list-group-item text-muted text-center">
                    There are no domain notifiers to list.
                </div>
            @endforelse
        </div>
    @endcomponent
@endsection
