<?php

namespace App\Managers;

class EmailManager
{
    /**
     * Determine if email has been enabled.
     *
     * @return bool
     */
    public function enabled()
    {
        return setting('email.enabled', false);
    }
}
