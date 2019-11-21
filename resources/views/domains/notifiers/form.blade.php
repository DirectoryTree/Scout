@if(!$notifier->exists)
    <div class="alert alert-primary shadow-sm">
        <strong>Heads up!</strong> This is a domain notifier. Any domain objects
        that pass the notifiers conditions will generate a notification.
    </div>
@endif

<div class="form-group">
    {{ form()->label()->for('short_name')->text(__('Subject / Short Name')) }}

    {{
        form()->input()
            ->name('short_name')
            ->value($notifier->notifiable_name)
            ->placeholder('Ex. Account Expired')
            ->data('target', 'form.input')
            ->data('action', 'keyup->form#clearError')
    }}

    <small class="help-text">
        This name is displayed in your notifications for easy identification.
    </small>

    {{ form()->error()->data('input', 'short_name')->data('target', 'form.error') }}
</div>

<div class="form-group">
    {{ form()->label()->for('name')->text(__('Name')) }}

    {{
        form()->input()
            ->name('name')
            ->value($notifier->name)
            ->placeholder('Ex. Notify me when...')
            ->data('target', 'form.input')
            ->data('action', 'keyup->form#clearError')
    }}

    <small class="help-text">
        This name is displayed in your notification inbox.
    </small>

    {{ form()->error()->data('input', 'name')->data('target', 'form.error') }}
</div>

<div class="form-group">
    {{ form()->label()->for('description')->text(__('Description')) }}

    {{
        form()->editor()
            ->name('description')
            ->value($notifier->description)
            ->placeholder('Enter the notifier description')
            ->data('target', 'form.input')
            ->data('action', 'keyup->form#clearError')
    }}

    {{ form()->error()->data('input', 'description')->data('target', 'form.error') }}
</div>
