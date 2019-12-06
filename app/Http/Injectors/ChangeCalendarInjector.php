<?php

namespace App\Http\Injectors;

use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\LdapChange;

class ChangeCalendarInjector
{
    /**
     * Get the start date.
     *
     * @return \Carbon\CarbonInterface
     *
     * @throws \Exception
     */
    public function getStartDate()
    {
        // We must use the start of the month to ensure all changes
        // for the entire calendar range are queried for.
        $date = request('start', now()->subMonths(2)->startOfMonth());

        return $date instanceof Carbon ? $date : new Carbon($date);
    }

    /**
     * Get the end date.
     *
     * @return \Carbon\CarbonInterface
     *
     * @throws \Exception
     */
    public function getEndDate()
    {
        return $this->getStartDate()->addMonths(3);
    }

    /**
     * Get the selected day.
     *
     * @return Carbon|null
     *
     * @throws \Exception
     */
    public function getSelectedDay()
    {
        if ($this->hasSelectedDay()) {
            return new Carbon(request('day'));
        }
    }

    /**
     * Determine if a day has been selected.
     *
     * @return bool
     */
    public function hasSelectedDay()
    {
        return request()->has('day');
    }

    /**
     * Get the monthly period for the given range.
     *
     * @param \Carbon\CarbonInterface $start
     * @param \Carbon\CarbonInterface $end
     *
     * @return DatePeriod
     *
     * @throws \Exception
     */
    public function getMonthlyPeriod($start, $end)
    {
        return new DatePeriod($start, new DateInterval('P1M'), $end);
    }

    /**
     * Get the changes that occurred on the specific day.
     *
     * @param Carbon $date
     *
     * @return \Illuminate\Database\Eloquent\Collection
     *
     * @throws \Exception
     */
    public function getChangesOn($date)
    {
        // We must clone the date so it is not mutated in the view.
        $date = $date->clone();

        return LdapChange::query()
            ->with('object.domain')
            ->whereBetween('ldap_updated_at', [$date->toDateString(), $date->addDay()->toDateString()])
            ->latest('ldap_updated_at')
            ->get();
    }

    /**
     * Get the changes for the given range.
     *
     * @param DatePeriod $period
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getChangesCountByPeriod(DatePeriod $period)
    {
        return LdapChange::query()
            ->select('ldap_updated_at')
            ->whereBetween('ldap_updated_at', [$period->start, $period->end])
            ->get()
            ->groupBy(function (LdapChange $change) {
                return $change->ldap_updated_at->format('Y-m-d');
            })->transform(function ($changes) {
                return $changes->count();
            });
    }
}
