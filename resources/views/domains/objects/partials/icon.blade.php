@if($icon = $object->icon)
    <span class="text-muted" title="{{ ucfirst($object->type) }}">
       <i class="{{ $icon }}"></i>
    </span>
@else
    <span class="text-muted" title="{{ __('Unknown') }}">
        <i class="far fa-question-circle"></i>
    </span>
@endif
