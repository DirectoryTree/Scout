<div class="card {{ $class ?? null }} shadow-sm">
    @isset($header)
        <div class="card-header bg-white">
            {{ $header }}
        </div>
    @endisset

    <div class="card-body {{ isset($flush) ? 'p-0' : null }}">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="card-footer bg-white">
            {{ $footer }}
        </div>
    @endisset
</div>
