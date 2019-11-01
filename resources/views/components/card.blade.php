<div class="card {{ $class ?? null }}">
    @isset($header)
        <div class="card-header border-bottom">
            {{ $header }}
        </div>
    @endisset

    <div class="card-body {{ isset($flush) && $flush === true ? 'p-0' : null }}">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="card-footer border-top">
            {{ $footer }}
        </div>
    @endisset
</div>
