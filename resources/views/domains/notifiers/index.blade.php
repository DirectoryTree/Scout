@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.index', $domain))

@section('page')
    @if ($systemNotifiers->isNotEmpty())
        <div class="card shadow-sm mb-4">
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <h5 class="mb-0">Domain Notifiers</h5>
                    </div>

                    @foreach($systemNotifiers as $notifier)
                        @include('domains.notifiers.notifier')
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                <div class="d-flex justify-content-between align-items-center list-group-item">
                    <h5 class="mb-0">Custom Domain Notifiers</h5>

                    <a href="{{ route('domains.notifiers.create', $domain) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus-circle"></i> Add
                    </a>
                </div>

                @forelse($notifiers as $notifier)
                    @include('domains.notifiers.notifier')
                @empty
                    <div class="list-group-item text-muted text-center">
                        No custom domain notifiers have been created yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
