<tr
    data-controller="poll"
    data-poll-url="{{ route('partials.domains.scans.row.show', [$domain, $scan]) }}"
    data-poll-interval="5000"
    @if($scan->running) data-poll-needed @endif
>
    <td class="pl-4 align-middle">
        @component('components.status', ['status' => $scan->success])@endcomponent
    </td>
    <td class="align-middle text-nowrap">
        @if($scan->started_at)
            <span title="{{ $scan->started_at }}">
                {{ $scan->started_at->diffForHumans() }}
            </span>
        @else
            <em class="text-muted">Not Started</em>
        @endif
    </td>
    <td class="align-middle text-nowrap">
        @if($scan->completed_at)
            <span title="{{ $scan->completed_at }}">
                {{ $scan->completed_at->diffForHumans() }}
            </span>
        @else
            <em class="text-muted">Not completed</em>
        @endif
    </td>
    <td class="text-center align-middle text-nowrap">
        @if($scan->running)
            <div class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        @else
            {{ $scan->duration }}
        @endif
    </td>
    <td class="text-center align-middle">{{ $scan->synchronized }}</td>
    <td class="align-middle p-0">
        @if($scan->message)
            <button
                type="button"
                class="btn btn-sm btn-outline-primary"
                data-action="click->app#openModal"
                data-url="{{ route('partials.domains.scans.message.show', [$domain, $scan]) }}">
                View
            </button>
        @else
            <em class="text-muted">None</em>
        @endif
    </td>
</tr>
