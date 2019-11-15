<?php

namespace App;

use App\Http\ScoutResponse;
use App\Managers\EmailManager;

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

    /**
     * Create a new email manager.
     *
     * @return EmailManager
     */
    public static function email()
    {
        return new EmailManager();
    }
}
