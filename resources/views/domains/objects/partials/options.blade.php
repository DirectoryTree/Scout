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
