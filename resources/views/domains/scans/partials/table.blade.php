<table
    class="table mb-0"
    data-controller="poll"
    data-poll-needed
    data-poll-url="{{ route_filter('partials.domains.scans.table.show', [$domain]) }}"
    data-poll-interval="15000"
>
    <colgroup>
        <col style="width:1%;">
    </colgroup>
    <thead>
        <tr class="bg-light text-uppercase text-muted font-weight-bold">
            <th class="pl-4"></th>
            <th>Started</th>
            <th>Completed</th>
            <th class="text-center">Duration</th>
            <th class="text-center">Synchronized</th>
            <th>Message</th>
        </tr>
    </thead>
    <tbody>
    @forelse($scans as $scan)
        @include('domains.scans.partials.row')
    @empty
        <tr></tr>
    @endforelse
    </tbody>
</table>
