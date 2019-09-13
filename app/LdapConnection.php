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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'hosts' => 'array',
        'use_ssl' => 'bool',
        'use_tls' => 'bool',
        'follow_referrals' => 'bool',
    ];

    /**
     * Encrypts the username upon it being set.
     *
     * @param string $username
     */
    public function setUsernameAttribute($username)
    {
        $this->attributes['username'] = encrypt($username);
    }

    /**
     * Encrypts the password upon it being set.
     *
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = encrypt($password);
    }
}
