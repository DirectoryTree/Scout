<?php

namespace App\Ldap\Transformers;

use LdapRecord\LdapRecordException;
use LdapRecord\Models\Attributes\Timestamp as LdapTimestamp;

abstract class Timestamp extends Transformer
{
    /**
     * The LDAP timestamp type.
     *
     * @var string
     */
    protected $type;

    /**
     * Transforms an LDAP timestamp.
     *
     * @return \Carbon\Carbon[]|null
     *
     * @throws \LdapRecord\LdapRecordException
     */
    public function transform(): array
    {
        if ($value = $this->getFirstValue()) {
            $timestamp = new LdapTimestamp($this->type);

            try {
                // We will attempt to convert the attribute value to
                // a Carbon instance. If it fails we'll report the
                // error so it can be investigated by the user.
                $converted = $timestamp->toDateTime($value);

                return $converted ? [$converted] : $converted;
            } catch (LdapRecordException $ex) {
                report($ex);
            }
        }

        return $this->value;
    }
}
