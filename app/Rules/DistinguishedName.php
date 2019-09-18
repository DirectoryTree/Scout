<?php

namespace App\Rules;

use LdapRecord\Utilities;
use Illuminate\Contracts\Validation\Rule;

class DistinguishedName implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Utilities::explodeDn($value) !== false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid RDN.';
    }
}
