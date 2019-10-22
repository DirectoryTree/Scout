<div class="list-group list-group-flush">
    @forelse($objects as $object)
        <div class="list-group-item {{ $object->trashed() ? 'bg-light' : null }}">
            <div class="row">
                <div class="col">
                    @include('domains.objects.partials.icon')

                    <a href="{{ route('domains.objects.show', [$domain, $object]) }}" class="font-weight-bold">
                        {{ $object->name }}
                    </a>

                    @if($object->children_count)
                        <span class="ml-1 badge badge-light border">
                            {{ $object->children_count }}
                        </span>
                    @endif

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

@if($objects->total() > $objects->perPage())
    <div class="row my-4">
        <div class="col">
            <div class="d-flex justify-content-center">
                {{ $objects->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endif
