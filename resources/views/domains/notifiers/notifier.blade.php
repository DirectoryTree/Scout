<div class="list-group-item d-flex justify-content-between align-items-center">
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

    <a href="{{ route('domains.notifiers.edit', [$domain, $notifier]) }}">
        Customize
    </a>
</div>
