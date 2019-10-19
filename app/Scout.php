<?php

namespace App;

use App\Http\ScoutResponse;

class Scout
{
    /**
     * Create a new response.
     *
     * @return ScoutResponse
     */
    public static function response()
    {
        return new ScoutResponse();
    }
}
