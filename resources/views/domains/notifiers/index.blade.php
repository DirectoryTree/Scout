@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.index', $domain))

@section('page')
    @component('components.card', ['flush' => true, 'class' => 'mb-4'])
        <div class="list-group list-group-flush">
            <div class="list-group-item">
                <h5 class="mb-0">Domain Notifiers</h5>
            </div>

            <div class="list-group-item">
                <div class="alert alert-primary">

                </div>
            </div>
        </div>
    @endcomponent

    @component('components.card', ['flush' => true])
        <div class="list-group list-group-flush">
            <div class="d-flex justify-content-between list-group-item">
                <h5 class="mb-0">Custom Domain Notifiers</h5>

                <a href="{{ route('domains.notifiers.create', $domain) }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus-circle"></i> Add
                </a>
            </div>

            @forelse($notifiers as $notifier)
                <div class="list-group-item h5">
                    <span class="badge badge-light">
                        Notify me when:
                    </span>

                    <span class="badge badge-primary">
                        {{ $notifier->attribute }}
                    </span>

                    <span class="badge badge-secondary">
                        @if ($notifier->operator == \App\LdapNotifier::OPERATOR_CONTAINS)
                            @if ($notifier->value)
                                {{ __('contains') }}
                            @else
                                {{ __('exists') }}
                            @endif
                        @elseif ($notifier->operator == \App\LdapNotifier::OPERATOR_PAST)
                            {{ __('is past') }}
                        @else
                            {{ $notifier->operator }}
                        @endif
                    </span>

                    <span class="badge badge-warning">
                         {{ $notifier->value }}
                    </span>
                </div>
            @empty
                <div class="list-group-item text-muted text-center">
                    There are no domain notifiers to list.
                </div>
            @endforelse
        </div>
    @endcomponent
@endsection
