@extends('domains.layout')

@section('title', __('Domain Notifiers'))

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.index', $domain))

@section('page')
    @if ($systemNotifiers->isNotEmpty())
        <div class="card shadow-sm mb-4">
            <div class="card-header border-bottom">
                <h6 class="mb-0 font-weight-bold text-secondary">{{ __('Domain Notifiers') }}</h6>
            </div>

            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($systemNotifiers as $notifier)
                        @include('domains.notifiers.notifier')
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h6 class="mb-0 font-weight-bold text-secondary">Custom Domain Notifiers</h6>

            <a href="{{ route('domains.notifiers.create', $domain) }}">Add Notifier</a>
        </div>

        <div class="card-body p-0">
            <div class="list-group list-group-flush">
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
