<div class="list-group-item d-flex justify-content-between align-items-center">
    <div class="d-flex justify-content-start align-items-center">
        <div class="mr-2">
            {{
                Form::scoutCheckbox('enabled', true, $notifier->enabled, [
                    'id' => "notifier_$notifier->id",
                    'switch' => true,
                    'label' => $notifier->name,
                    'data-controller' => 'toggle',
                    'data-action' => 'click->toggle#update',
                    'data-toggle-url' => route('api.notifier.toggle', $notifier),
                    'disabled' => $notifier->conditions_count === 0,
                ])
            }}
        </div>

        @if($notifier->conditions_count === 0)
            <div class="badge badge-warning">
                <i class="fa fa-exclamation-circle"></i> Needs Conditions
            </div>
        @endif
    </div>

    <a href="{{ route('domains.notifiers.edit', [$domain, $notifier]) }}">
        Customize
    </a>
</div>
