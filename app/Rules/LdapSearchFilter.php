<?php

namespace App\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class LdapSearchFilter implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * This rule doesn't do much validation on purpose.
     *
     * We will allow searches to be conducted on invalid
     * filters, as an exception will be generated from
     * the LDAP server itself and inform the user.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Str::startsWith($value, '(') && Str::endsWith($value, ')');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The :attribute must be a valid search filter (example: (objectclass=user)).');
    }
}
