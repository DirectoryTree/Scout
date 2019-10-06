<div class="form-group">
    @component('components.form.select', [
        'label' =>  __('Database'),
        'name' => 'database_type',
        'options' => $databases
    ])
    @endcomponent
</div>

<div class="form-group">
    @component('components.form.input', [
       'label' =>  __('Host'),
       'name' => 'database_host',
       'placeholder' => '127.0.0.1'
   ])
    @endcomponent
</div>

<div class="form-group">
    @component('components.form.input', [
       'label' =>  __('Port'),
       'name' => 'database_port',
       'default' => '3306',
       'placeholder' => '3306'
   ])
    @endcomponent
</div>

<div class="form-group">
    @component('components.form.input', [
       'label' =>  __('Username'),
       'name' => 'database_username',
       'default' => 'root',
       'placeholder' => 'Username'
   ])
    @endcomponent
</div>

<div class="form-group">
    @component('components.form.input', [
       'label' =>  __('Password'),
       'type' => 'password',
       'name' => 'database_password',
       'placeholder' => 'Password'
   ])
    @endcomponent
</div>
