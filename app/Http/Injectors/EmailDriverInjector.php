<?php

namespace App\Http\Injectors;

class EmailDriverInjector
{
    /**
     * Get the available database types.
     *
     * @return array
     */
    public function get()
    {
        return ['smtp' => 'SMTP'];
    }
}
