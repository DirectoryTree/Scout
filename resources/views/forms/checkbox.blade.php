<div class="custom-control custom-{{ $type }}">
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
    {{ Form::scoutLabel($attributes['id'], $label, ['class' => 'custom-control-label']) }}
</div>
