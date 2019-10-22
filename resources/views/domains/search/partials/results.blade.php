@isset($objects)
    @component('components.card', ['class' => 'bg-white', 'flush' => true])
        @slot('header')
            <h5 class="mb-0">
                {{ __('Results') }}
            </h5>
        @endslot

        @include('domains.objects.partials.list')
    @endcomponent
@endisset
