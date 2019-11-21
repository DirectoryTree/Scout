<?php

namespace App\Ldap\Pipes;

use Closure;
use App\LdapObject;

class AssociateDomain extends Pipe
{
    /**
     * Perform operations on the LDAP object model.
     *
     * @param LdapObject $model
     * @param Closure    $next
     *
     * @return void
     */
    public function handle(LdapObject $model, Closure $next)
    {
        $model->domain()->associate($this->domain);

        return $next($model);
    }
}
