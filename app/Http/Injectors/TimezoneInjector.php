<?php

namespace App\Http\Injectors;

use DateTimeZone;

class TimezoneInjector
{
    /**
     * Get an array of all available timezones.
     *
     * @return array
     */
    public function get()
    {
        $identifiers = DateTimeZone::listIdentifiers();

        return array_combine($identifiers, $identifiers);
    }
}
