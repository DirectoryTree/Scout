@inject('databases', 'App\Http\Injectors\DatabaseTypeInjector')

<div class="form-group">
    {{ form()->label()->for('driver')->text(__('Driver')) }}

    {{
        form()->select()
            ->name('driver')
            ->options($databases->get())
            ->data('target', 'form.input')
            ->data('action', 'change->form#clearError')
    }}

    {{ form()->error()->data('input', 'driver')->data('target', 'form.error') }}
</div>

<div class="form-group">
    {{ form()->label()->for('host')->text(__('Host')) }}

    {{
        form()->input()
            ->name('host')
            ->placeholder('127.0.0.1')
            ->data('target', 'form.input')
            ->data('action', 'keyup->form#clearError')
    }}

    {{ form()->error()->data('input', 'host')->data('target', 'form.error') }}
</div>

<div class="form-group">
    {{ form()->label()->for('port')->text(__('Port')) }}

    {{
        form()->input()
            ->name('port')
            ->value(3306)
            ->placeholder('3306')
            ->data('target', 'form.input')
            ->data('action', 'keyup->form#clearError')
    }}

    {{ form()->error()->data('input', 'port')->data('target', 'form.error') }}
</div>

<div class="form-group">
    {{ form()->label()->for('database')->text(__('Database')) }}

    {{
        form()->input()
            ->name('database')
            ->placeholder('scout')
            ->data('target', 'form.input')
            ->data('action', 'keyup->form#clearError')
    }}

    {{ form()->error()->data('input', 'database')->data('target', 'form.error') }}
</div>

<div class="form-group">
    {{ form()->label()->for('username')->text(__('Username')) }}

    {{
        form()->input()
            ->name('username')
            ->placeholder('Username')
            ->data('target', 'form.input')
            ->data('action', 'keyup->form#clearError')
    }}

    {{ form()->error()->data('input', 'username')->data('target', 'form.error') }}
</div>

<div class="form-group">
    {{ form()->label()->for('password')->text(__('Password')) }}

    {{
        form()->password()
            ->name('password')
            ->placeholder('Password')
            ->data('target', 'form.input')
            ->data('action', 'keyup->form#clearError')
    }}

    {{ form()->error()->data('input', 'password')->data('target', 'form.error') }}
</div>
