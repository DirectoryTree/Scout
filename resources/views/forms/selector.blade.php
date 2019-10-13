<div class="custom-control custom-{{ $switch ? 'switch' : $type }}">
    <input
        name="{{ $name }}"
        value="{{ $value }}"
        type="{{ $type }}"
        {!!
           Html::attributes(array_merge([
               'class' => 'custom-control-input' . ($errors->has($name) ? ' is-invalid' : null)
           ], $attributes))
       !!}
    >
    {{ Form::scoutLabel($attributes['id'], $label, ['class' => 'custom-control-label']) }}
</div>
