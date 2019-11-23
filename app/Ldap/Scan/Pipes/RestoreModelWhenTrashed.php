<?php

namespace App\Ldap\Scan\Pipes;

use Closure;
use App\LdapObject;

class RestoreModelWhenTrashed extends Pipe
{
    /**
     * Restore the model if it's trashed.
     *
     * @param LdapObject $object
     * @param Closure    $next
     *
     * @return void
     */
    public function handle(LdapObject $object, Closure $next)
    {
        if ($object->trashed()) {
            $object->restore();
        }

        return $next($object);
    }
}
