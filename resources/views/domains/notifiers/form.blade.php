<div class="form-group">
    {{ Form::scoutLabel('short_name', __('Short Name')) }}

    {{
        Form::scoutText('short_name', $notifier->notifiable_name, [
            'placeholder' => 'Enter the short name for the notifier',
            'data-target' => 'form.input',
            'data-action' => 'keyup->form#clearError',
        ])
    }}

    <small class="help-text">
        This name is displayed in your notifications for easy identification.
    </small>

    {{
        Form::scoutError([
            'data-input' => 'short_name',
            'data-target' => 'form.error',
        ])
    }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('name', __('Name')) }}

    {{
        Form::scoutText('name', $notifier->name, [
            'placeholder' => 'Enter the notfier name',
            'data-target' => 'form.input',
            'data-action' => 'keyup->form#clearError',
        ])
    }}

    <small class="help-text">
        This name is displayed in your notification inbox.
    </small>

    {{
        Form::scoutError([
            'data-input' => 'name',
            'data-target' => 'form.error',
        ])
    }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('description', __('Description')) }}

    {{
        Form::scoutTextarea('description', $notifier->description, [
            'placeholder' => 'Enter the notifier description',
            'data-target' => 'form.input',
            'data-action' => 'keyup->form#clearError',
        ])
    }}

    {{
        Form::scoutError([
            'data-input' => 'name',
            'data-target' => 'form.error',
        ])
    }}
</div>
