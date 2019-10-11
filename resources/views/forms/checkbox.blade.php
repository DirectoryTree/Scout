<div class="custom-control custom-checkbox">
    <input
        name="{{ $name }}"
        value="{{ $value }}"
        type="checkbox"
        {!!
           Html::attributes(array_merge([
               'class' => 'custom-control-input' . ($errors->has($name) ? ' is-invalid' : null)
           ], $attributes))
       !!}
    >
    {{ Form::scoutLabel($name, $label, ['class' => 'custom-control-label', 'for' => $name]) }}
</div>
