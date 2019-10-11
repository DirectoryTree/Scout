<div class="custom-control custom-{{ $type }}">
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $value }}"
        type="checkbox"
        {!!
           Html::attributes(array_merge([
               'class' => 'custom-control-input' . ($errors->has($name) ? ' is-invalid' : null)
           ], $attributes))
       !!}
    >
    {{ Form::scoutLabel($name, $label, ['for' => $name, 'class' => 'custom-control-label']) }}
</div>
