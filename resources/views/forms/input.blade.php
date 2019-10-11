<input
    type="{{ $type }}"
    name="{{ $name }}"
    value="{{ old($name, $value) }}"
    {!!
        Html::attributes(array_merge([
            'class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : null)
        ], $attributes))
    !!}
>
