@php($date = isset($date) ? $date->startOfMonth() : now()->startOfMonth())

<table class="calendar m-auto" style="border-spacing:10px;border-collapse: separate;">
    <thead>
        <tr class="text-center text-uppercase text-secondary">
            <th colspan="7">{{ $date->format('F Y') }}</th>
        </tr>
    </thead>
    <thead>
        <tr class="text-muted text-center">
            <th>M</th>
            <th>T</th>
            <th>W</th>
            <th>T</th>
            <th>F</th>
            <th>S</th>
            <th>S</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            {{-- Day of the week isn't monday, add empty preceding column(s) --}}
            @if($date->format('N') != 1)
                <td colspan="{{ $date->format('N') - 1 }}"></td>
            @endif

            {{-- Get the total number of days in the month. --}}
            @php($daysInMonth = $date->daysInMonth)

            {{-- Go through each day of the month. --}}
            @for($i = 1; $i <= $daysInMonth; $i++)
                {{-- If we've reached monday, we'll create a new row. --}}
                @if($date->format('N') == 1)
                    </tr><tr>
                @endif

                {{-- Output the day. --}}
                <td class="text-center text-secondary rounded-circle bg-light border" rel="{{ $date->format('Y-m-d') }}">
                    <div style="height:20px;width:20px">
                        {{ $date->day }}
                    </div>
                </td>

                {{-- Add another day and continue. --}}
                @php($date->addDay())
            @endfor

            {{-- Last date isn't sunday, append empty column(s). --}}
            @if($date->format('N') != 7)
                <td colspan="{{ (8 - $date->format('N')) }}"></td>
            @endif
        </tr>
    </tbody>
</table>
