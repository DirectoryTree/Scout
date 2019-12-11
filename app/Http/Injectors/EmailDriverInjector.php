<?php

namespace App\Http\Injectors;

class EmailDriverInjector
{
    /**
     * Get the available email driver types.
     *
     * @return array
     */
    public function get()
    {
        return [
            'smtp' => 'SMTP',
            'mail' => 'Mail',
            'sendmail' => 'Sendmail',
            'mailgun' => 'Mailgun',
            'ses' => 'Ses',
        ];
    }
}
