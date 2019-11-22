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

        @if(setting('app.pinning', true))
            <div class="dropdown-divider"></div>

            @if($object->pinned)
                <form method="post" action="{{ route('objects.pin.destroy', $object) }}" data-controller="form">
                    @csrf
                    @method('delete')
                    <button type="submit" class="dropdown-item" data-turbolinks-scroll>
                        <i class="fa fa-thumbtack"></i> Unpin from Dashboard
                    </button>
                </form>
            @else
                <form method="post" action="{{ route('objects.pin.store', $object) }}" data-controller="form">
                    @csrf
                    <button type="submit" class="dropdown-item" data-turbolinks-scroll>
                        <i class="fa fa-thumbtack"></i> Pin to Dashboard
                    </button>
                </form>
            @endif
        @endif
    </div>
</div>
