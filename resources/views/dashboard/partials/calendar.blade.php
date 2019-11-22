@if(setting('app.calendar', true))
    @inject('calendar', 'App\Http\Injectors\ChangeCalendarInjector')

    @php
        $start = $calendar->getStartDate();
        $end = $calendar->getEndDate();
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
                <div class="card-body">
                    <div class="row">
                        @foreach($calendar->getMonthlyPeriod($start, $end) as $month)
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                @include('calendar', ['date' => $month, 'events' => $calendar->getChanges($start, $end)])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
