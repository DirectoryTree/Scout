<div class="form-group">
    @component('components.form.select', [
        'label' =>  __('Driver'),
        'name' => 'driver',
        'options' => $databases
    ])
    @endcomponent
</div>

<div class="form-group">
    @component('components.form.input', [
       'label' =>  __('Host'),
       'name' => 'host',
       'placeholder' => '127.0.0.1'
   ])
    @endcomponent
</div>

<div class="form-group">
    @component('components.form.input', [
       'label' =>  __('Port'),
       'name' => 'port',
       'default' => '3306',
       'placeholder' => '3306'
   ])
    @endcomponent
</div>

<div class="form-group">
    @component('components.form.input', [
       'label' =>  __('Database'),
       'name' => 'database',
       'placeholder' => 'scout'
   ])
    @endcomponent
</div>

<div class="form-group">
    @component('components.form.input', [
       'label' =>  __('Username'),
       'name' => 'username',
       'default' => 'root',
       'placeholder' => 'Username'
   ])
    @endcomponent
</div>

<div class="form-group">
    @component('components.form.input', [
       'label' =>  __('Password'),
       'type' => 'password',
       'name' => 'password',
       'placeholder' => 'Password'
   ])
    @endcomponent
</div>
