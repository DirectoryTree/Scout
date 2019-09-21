@component('components.card', ['flush' => true])
    <div class="list-group list-group-flush">
        <div class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    @isset($object)
                        <i class="fa fa-level-down-alt"></i> {{ __('Nested Objects') }}
                    @else
                        {{ __('Root Domain Objects') }}
                    @endisset
                </h5>
            </div>
        </div>

        @forelse($objects as $object)
            <div class="list-group-item">
                <div class="row">
                    <div class="col">
                        @if($icon = $object->icon)
                            <span class="text-muted" title="{{ ucfirst($object->type) }}">
                               <i class="{{ $icon }}"></i>
                            </span>
                        @else
                            <span class="text-muted" title="{{ __('Unknown') }}">
                                <i class="fa fa-question-circle"></i>
                            </span>
                        @endif

                        <a href="{{ route('domains.objects.show', [$domain, $object]) }}" class="font-weight-bold">
                            {{ $object->name }}
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col text-muted small">
                        {{ $object->dn }}
                    </div>
                </div>
            </div>
        @empty
            <div class="list-group-item text-center text-muted">
                {{ __('There are no objects to list.') }}
            </div>
        @endforelse
    </div>
@endcomponent

<div class="row my-4">
    <div class="col">
        <div class="d-flex justify-content-center">
            {{ $objects->appends(request()->query())->links() }}
        </div>
    </div>
</div>
