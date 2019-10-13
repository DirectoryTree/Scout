<div class="form-group">
    {{ Form::scoutLabel('driver', __('Driver')) }}

    {{
        Form::scoutSelect('driver', $databases, null, [
            'data-target' => 'forms--install.input',
            'data-action' => 'change->forms--install#clearError'
        ])
    }}

    {{
        Form::scoutError([
            'data-input' => 'driver',
            'data-target' => 'forms--install.error',
        ])
    }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('host', __('Host')) }}

    {{
        Form::scoutText('host', null, [
            'placeholder' => '127.0.0.1',
            'data-target' => 'forms--install.input',
            'data-action' => 'keyup->forms--install#clearError',
        ])
    }}

    {{
        Form::scoutError([
            'data-input' => 'host',
            'data-target' => 'forms--install.error'
        ])
    }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('port', __('Port')) }}

    {{
        Form::scoutText('port', 3306, [
            'placeholder' => '3306',
            'data-target' => 'forms--install.input',
            'data-action' => 'keyup->forms--install#clearError',
        ])
    }}

    {{
        Form::scoutError([
            'data-input' => 'port',
            'data-target' => 'forms--install.error'
        ])
    }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('database', __('Database')) }}

    {{
        Form::scoutText('database', null, [
            'placeholder' => 'scout',
            'data-target' => 'forms--install.input',
            'data-action' => 'keyup->forms--install#clearError',
        ])
    }}

    {{
        Form::scoutError([
            'data-input' => 'database',
            'data-target' => 'forms--install.error'
        ])
    }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('username', __('Username')) }}

    {{
        Form::scoutText('username', null, [
            'placeholder' => 'Username',
            'data-target' => 'forms--install.input',
            'data-action' => 'keyup->forms--install#clearError',
        ])
    }}

    {{
        Form::scoutError([
            'data-input' => 'username',
            'data-target' => 'forms--install.error'
        ])
    }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('password', __('Password')) }}

    {{
        Form::scoutPassword('password', [
            'placeholder' => 'Password',
            'data-target' => 'forms--install.input',
            'data-action' => 'keyup->forms--install#clearError',
        ])
    }}

    {{
        Form::scoutError([
            'data-input' => 'password',
            'data-target' => 'forms--install.error'
        ])
    }}
</div>
