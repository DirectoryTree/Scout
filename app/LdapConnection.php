<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LdapConnection extends Model
{
    // The LDAP connection types.
    const TYPE_ACTIVE_DIRECTORY = 1;
    const TYPE_OPEN_LDAP = 2;

    // The LDAP connection statuses.
    const STATUS_ONLINE = 1;
    const STATUS_OFFLINE = 2;
    const STATUS_INVALID_CREDENTIALS = 3;
}
