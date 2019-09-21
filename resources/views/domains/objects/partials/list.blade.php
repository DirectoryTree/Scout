@component('components.card', ['flush' => true])
    <div class="list-group list-group-flush">
        @forelse($objects as $object)
            <div class="list-group-item">
                <div class="row">
                    <div class="col">
                            <span class="text-muted">
                                @if($icon = $object->icon)
                                    <i class="{{ $icon }}"></i>
                                @else
                                    <i class="fa fa-question-circle"></i>
                                @endif
                            </span>

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
            <div class="list-group-item">
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
