@isset($objects)
    <div class="card shadow-sm mt-4 bg-white">
        <div class="card-header border-bottom">
            <h5 class="mb-0">{{ __('Results') }}</h5>
        </div>

        <div class="card-body p-0">
            @include('domains.objects.partials.list')
        </div>
    </div>
@endisset
