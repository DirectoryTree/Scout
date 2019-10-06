@isset($label)
    @if($label !== false)
        @component('components.form.label', ['name' => $name])
            {{ $label }}
        @endcomponent
    @endif
@endisset

<input
    name="{{ $name }}"
    type="{{ isset($type) ? $type : 'text' }}"
    value="{{ old($name, isset($default) ? $default : null) }}"
    class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}"
    placeholder="{{ isset($placeholder) ? $placeholder : null }}"
    {{ isset($required) ? ' required' : null }}
>

{{ $slot }}

@include('components.form.error')
