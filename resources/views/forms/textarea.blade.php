{{ Form::scoutInput('hidden', $name, $value, $attributes) }}

<trix-editor
    input="{{ $attributes['id'] }}"
    @if(isset($attributes['placeholder']))placeholder="{{ $attributes['placeholder'] }}"@endif
></trix-editor>
