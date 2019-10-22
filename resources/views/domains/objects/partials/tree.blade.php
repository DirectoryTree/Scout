<ul id="domain-objects" class="object-tree list-unstyled mb-0{{ isset($parent) ? ' ml-4' : null }}">
    @foreach($objects as $object)
        <li>
            <form
                method="get"
                action="{{ route('partials.domains.objects.tree.show', [$domain, $object]) }}"
                data-controller="object-tree"
                data-object-tree-id="{{ $object->id }}"
                data-object-tree-children="{{ $object->children_count }}"
            >
                <div class="d-flex align-items-center mb-2">
                    @if($object->children_count > 0)
                        <button
                            id="btn_expand_{{ $object->id }}"
                            type="submit"
                            class="btn btn-sm btn-light border position-absolute no-loading"
                        >
                            <i class="fa fa-xs fa-chevron-right"></i>
                        </button>

                        <button
                            id="btn_shrink_{{ $object->id }}"
                            type="button"
                            class="btn btn-sm btn-light border position-absolute d-none"
                            data-action="click->object-tree#shrink"
                        >
                            <i class="fa fa-xs fa-chevron-down"></i>
                        </button>
                    @endif

                    <h5 class="mb-0" style="margin-left:40px;">
                        @include('domains.objects.partials.badge')
                    </h5>
                </div>
            </form>

            <div id="leaves_{{ $object->id }}"></div>
        </li>
    @endforeach
</ul>
