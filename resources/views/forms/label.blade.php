<label
    for="{{ $name }}"
    {!!
       Html::attributes(array_merge(['class' => 'font-weight-bold'], $attributes))
   !!}
>
    {{ $value }}
</label>
