<select
    name="{{ $name }}"
    {!!
       Html::attributes(array_merge([
           'class' => 'custom-select' . ($errors->has($name) ? ' is-invalid' : null)
       ], $attributes))
   !!}
>
    @foreach($options as $value => $text)
        <option value="{{ $value }}" {{ old($value, isset($default) ? $default : null) == $value ? 'selected' : null }}>
            {{ $text }}
        </option>
    @endforeach
</select>
