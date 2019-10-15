@extends('domains.layout')

@section('breadcrumbs', Breadcrumbs::render('domains.notifiers.index', $domain))

@section('page')
    @if ($systemNotifiers->isNotEmpty())
        @component('components.card', ['flush' => true, 'class' => 'mb-4'])
            <div class="list-group list-group-flush">
                <div class="list-group-item">
                    <h5 class="mb-0">Domain Notifiers</h5>
                </div>

                @foreach($systemNotifiers as $notifier)
                    <div class="list-group-item">
                        {{
                            Form::scoutCheckbox('enabled', true, $notifier->enabled, [
                                'id' => "notifier_$notifier->id",
                                'switch' => true,
                                'label' => $notifier->name,
                                'data-controller' => 'toggle',
                                'data-action' => 'click->toggle#update',
                                'data-toggle-url' => route('api.notifier.toggle', $notifier)
                            ])
                        }}
                    </div>
                @endforeach
            </div>
        @endcomponent
    @endif

    @component('components.card', ['flush' => true])
        <div class="list-group list-group-flush">
            <div class="d-flex justify-content-between align-items-center list-group-item">
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
                    No custom domain notifiers have been created yet.
                </div>
            @endforelse
        </div>
    @endcomponent
@endsection
