<?php

namespace App\Ldap\Transformers;

use LdapRecord\Utilities;

class ObjectSid extends Transformer
{
    /**
     * Transform the value.
     *
     * @return array
     */
    public function transform(): array
    {
        if ($value = $this->getFirstValue()) {
            return Utilities::isValidSid($value) ? [$value] : [Utilities::binarySidToString($value)];
        }

        return $this->value;
    }
}
