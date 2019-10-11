<div class="form-group">
    {{ Form::scoutLabel('driver', __('Driver')) }}

    {{ Form::scoutSelect('driver', $databases) }}

    {{ Form::scoutError('driver') }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('host', __('Host')) }}

    {{ Form::scoutText('host', null, ['placeholder' => '127.0.0.1']) }}

    {{ Form::scoutError('host') }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('port', __('Port')) }}

    {{ Form::scoutText('port', 3306, ['placeholder' => '3306']) }}

    {{ Form::scoutError('port') }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('database', __('Database')) }}

    {{ Form::scoutText('database', null, ['placeholder' => 'scout']) }}

    {{ Form::scoutError('database') }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('username', __('Username')) }}

    {{ Form::scoutText('username', null, ['placeholder' => 'Username']) }}

    {{ Form::scoutError('username') }}
</div>

<div class="form-group">
    {{ Form::scoutLabel('password', __('Password')) }}

    {{ Form::scoutPassword('password', ['placeholder' => 'Password']) }}

    {{ Form::scoutError('password') }}
</div>
