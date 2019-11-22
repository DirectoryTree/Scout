<?php

namespace App\Http\Injectors;

use DatePeriod;
use DateInterval;
use App\LdapChange;

class ChangeCalendarInjector
{
    /**
     * Get the start date.
     *
     * @return \Carbon\CarbonInterface
     */
    public function getStartDate()
    {
        return now()->subMonths(2);
    }

    /**
     * Get the end date.
     *
     * @return \Carbon\CarbonInterface
     */
    public function getEndDate()
    {
        return now()->addMonth();
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
     * Get the changes for the given range.
     *
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getChanges($start, $end)
    {
        return LdapChange::query()
            ->select('ldap_updated_at')
            ->whereBetween('ldap_updated_at', [$start, $end])
            ->get()
            ->groupBy(function (LdapChange $change) {
                return $change->ldap_updated_at->format('Y-m-d');
            })->transform(function ($changes) {
                return $changes->count();
            });
    }
}
