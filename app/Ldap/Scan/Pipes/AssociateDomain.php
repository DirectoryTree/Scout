<?php

namespace App\Ldap\Scan\Pipes;

use Closure;
use App\LdapObject;

class AssociateDomain extends Pipe
{
    /**
     * Perform operations on the LDAP object model.
     *
     * @param LdapObject $object
     * @param Closure    $next
     *
     * @return void
     */
    public function handle(LdapObject $object, Closure $next)
    {
        $object->domain()->associate($this->scan->domain);

        return $next($object);
    }
}
