<?php

namespace App\Ldap\Transformers;

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
     * @return array
     *
     * @throws \LdapRecord\LdapRecordException
     */
    public function transform(): array
    {
        if ($value = $this->getFirstValue()) {
            $timestamp = new LdapTimestamp($this->type);

            if ($converted = $timestamp->toDateTime($value)) {
                return [$converted];
            }
        }

        return $this->value;
    }
}
