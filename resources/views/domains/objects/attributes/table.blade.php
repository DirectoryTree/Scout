<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr class="text-uppercase text-muted bg-light">
                <th class="pl-4">Name</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
        @forelse($attributes as $name => $values)
            <tr>
                <td class="pl-4 align-middle">{{ $name }}</td>
                <td class="bg-light">
                    @if(count($values) > 1)
                        @foreach ($values as $value)
                            {{ $value }} @if(!$loop->last) <br/> @endif
                        @endforeach
                    @else
                        @if($values[0] instanceof \Carbon\Carbon)
                            {{ $values[0]->diffForHumans() }}

                            <small class="text-muted">{{ $values[0]->toDateTimeString() }}</small>
                        @else
                            {{ $values[0] }}
                        @endif
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td class="pl-4" colspan="2">There are no attributes to list.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
