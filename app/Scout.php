<?php

namespace App;

use App\Http\ScoutResponse;

class Scout
{
    /**
     * Create a new response.
     *
     * @param array $data
     * @param int   $status
     * @param array $headers
     *
     * @return ScoutResponse
     */
    public static function response(array $data = [], $status = 200, array $headers = [])
    {
        return new ScoutResponse($data, $status, $headers);
    }
}
