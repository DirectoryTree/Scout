@if(setting('app.calendar', true))
    @inject('calendar', 'App\Http\Injectors\ChangeCalendarInjector')

    @php
        $start = $calendar->getStartDate();
        $end = $calendar->getEndDate();

        $previous = $start->clone()->subMonth()->toDateString();
        $next = $start->clone()->addMonth()->toDateString();
    @endphp

    <div class="row">
        <div class="col">
            <h6 class="text-center text-uppercase text-muted font-weight-bold">
                <i class="fa fa-sync"></i> {{ __('Changes') }}
            </h6>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between border-bottom">
                    <a href="{{ current_route_filter(['start' =>  $previous]) }}" class="h4 mb-0" data-turbolinks-scroll>
                        <i class="fa fa-chevron-circle-left"></i>
                    </a>

                    {{--
                        We will conditionally show the reset button so
                        the user can easily reset the calendar view.
                    --}}
                    @if(request()->hasAny(['start', 'day']))
                        <a href="{{ route('dashboard') }}" data-turbolinks-scroll>Reset</a>
                    @endif

                    <a href="{{ current_route_filter(['start' => $next]) }}" class="h4 mb-0" data-turbolinks-scroll>
                        <i class="fa fa-chevron-circle-right"></i>
                    </a>
                </div>

                <div class="card-body">
                    <div class="row">
                        @php($period = $calendar->getMonthlyPeriod($start, $end))

                        @foreach($period as $month)
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                @include('calendar', ['date' => $month, 'events' => $calendar->getChangesCountByPeriod($period)])
                            </div>
                        @endforeach
                    </div>

                    @if($day = $calendar->getSelectedDay())
                        @php($changes = $calendar->getChangesOn($day))

                        <hr/>

                        <div class="row">
                            <div class="col">
                                <h6 class="text-muted text-uppercase text-center font-weight-bold">
                                    {{ $day->format('F jS Y') }}
                                </h6>

                                <div class="list-group list-group-flush">
                                    @forelse($changes as $change)
                                        <div class="list-group-item">
                                            <div class="row flex-column">
                                                <div class="col">
                                                    @include('domains.objects.partials.icon', ['object' => $change->object])

                                                    <a href="{{ route('domains.objects.show', [$change->object->domain, $change->object]) }}" class="font-weight-bold">
                                                        {{ $change->object->name }}
                                                    </a>
                                                </div>

                                                <div class="col text-muted small">
                                                    {{ $change->object->dn }}
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="list-group-item">
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
