@inject('databases', 'App\Http\Injectors\DatabaseTypeInjector')

<div class="form-group">
    {{ Form::scoutLabel('driver', __('Driver')) }}

    {{
        Form::scoutSelect('driver', $databases->get(), null, [
            'data-target' => 'form.input',
            'data-action' => 'change->form#clearError'
        ])
    }}

    {{
        Form::scoutError([
            'data-input' => 'driver',
            'data-target' => 'form.error',
        ])
    }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('host', __('Host')) }}

    {{
        Form::scoutText('host', null, [
            'placeholder' => '127.0.0.1',
            'data-target' => 'form.input',
            'data-action' => 'keyup->form#clearError',
        ])
    }}

    {{
        Form::scoutError([
            'data-input' => 'host',
            'data-target' => 'form.error'
        ])
    }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('port', __('Port')) }}

    {{
        Form::scoutText('port', 3306, [
            'placeholder' => '3306',
            'data-target' => 'form.input',
            'data-action' => 'keyup->form#clearError',
        ])
    }}

    {{
        Form::scoutError([
            'data-input' => 'port',
            'data-target' => 'form.error'
        ])
    }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('database', __('Database')) }}

    {{
        Form::scoutText('database', null, [
            'placeholder' => 'scout',
            'data-target' => 'form.input',
            'data-action' => 'keyup->form#clearError',
        ])
    }}

    {{
        Form::scoutError([
            'data-input' => 'database',
            'data-target' => 'form.error'
        ])
    }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('username', __('Username')) }}

    {{
        Form::scoutText('username', null, [
            'placeholder' => 'Username',
            'data-target' => 'form.input',
            'data-action' => 'keyup->form#clearError',
        ])
    }}

    {{
        Form::scoutError([
            'data-input' => 'username',
            'data-target' => 'form.error'
        ])
    }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('password', __('Password')) }}

    {{
        Form::scoutPassword('password', [
            'placeholder' => 'Password',
            'data-target' => 'form.input',
            'data-action' => 'keyup->form#clearError',
        ])
    }}

    {{
        Form::scoutError([
            'data-input' => 'password',
            'data-target' => 'form.error'
        ])
    }}
</div>
