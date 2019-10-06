@isset($label)
    @if($label !== false)
        @component('components.form.label', ['name' => $name])
            {{ $label }}
        @endcomponent
    @endif
@endisset

<select name="{{ $name }}" class="custom-select {{ $errors->has($name) ? 'is-invalid' : '' }}">
    @foreach($options as $value => $text)
        <option value="{{ $value }}" {{ old($value, isset($default) ? $default : null) == $value ? 'selected' : null }}>
            {{ $text }}
        </option>
    @endforeach
</select>

{{ $slot }}

@include('components.form.error')
