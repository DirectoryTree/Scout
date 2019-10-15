@component('components.card', ['flush' => true])
    <div class="list-group list-group-flush">
        <div class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    @isset($object)
                        <i class="fa fa-level-down-alt"></i> {{ __('Nested Objects') }}
                    @else
                        {{ __('Domain Objects') }}
                    @endisset
                </h5>
            </div>
        </div>

        @forelse($objects as $object)
            <div class="list-group-item {{ $object->trashed() ? 'bg-light' : null }}">
                <div class="row">
                    <div class="col">
                        @include('domains.objects.partials.icon')

                        <a href="{{ route('domains.objects.show', [$domain, $object]) }}" class="font-weight-bold">
                            {{ $object->name }}
                        </a>

                        @if($object->trashed())
                            <small class="text-muted">(deleted)</small>
                        @endif
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
