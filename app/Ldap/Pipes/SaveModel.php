<?php

namespace App\Ldap\Pipes;

use Closure;
use App\LdapObject as DatabaseModel;

class SaveModel extends Pipe
{
    /**
     * Persist the model to the database.
     *
     * @param DatabaseModel $model
     * @param Closure       $next
     *
     * @return void
     */
    public function handle(DatabaseModel $model, Closure $next)
    {
        $model->save();

        return $next($model);
    }
}
