<div class="list-group">
    @forelse($objects as $object)
        <div class="list-group-item border-0 {{ $object->trashed() ? 'bg-light' : null }}">
            <div class="d-flex justify-content-between align-items-center pb-2{{ !$loop->last ? ' border-bottom' : null }}">
                <div class="mr-2">
                    <h5>
                        @include('domains.objects.partials.badge')

                        @if($object->children_count)
                            <span class="ml-2 badge badge-light border" title="{{ $object->children_count }} nested">
                                {{ $object->children_count }}
                            </span>
                        @endif
                    </h5>

                    <div class="row">
                        <div class="col text-muted small">
                            {{ $object->dn }}
                        </div>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="btn btn-sm btn-light border rounded-pill" type="button" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <i class="far fa-bell"></i> Notifications
                        </a>

                        <a href="{{ route('domains.objects.attributes.index', [$domain, $object]) }}" class="dropdown-item">
                            <i class="fa fa-list-ul"></i> Attributes
                        </a>

                        <a href="{{ route('domains.objects.changes.index', [$domain, $object]) }}" class="dropdown-item">
                            <i class="fa fa-sync"></i> Changes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="list-group-item border-0 text-center text-muted">
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
