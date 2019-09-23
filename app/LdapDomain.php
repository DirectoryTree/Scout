<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LdapDomain extends Model
{
    // The LDAP connection types.
    const TYPE_UNKNOWN = 1;
    const TYPE_ACTIVE_DIRECTORY = 2;
    const TYPE_OPEN_LDAP = 3;

    // The LDAP connection statuses.
    const STATUS_ONLINE = 1;
    const STATUS_OFFLINE = 2;
    const STATUS_INVALID_CREDENTIALS = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'synchronized_at',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'hosts' => 'array',
        'follow_referrals' => 'bool',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['synchronized_at'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function(LdapDomain $domain) {
            // Delete any scans that have been performed.
            $domain->scans()->delete();

            // The domain may have a large amount of objects. We
            // will chunk our results to keep memory usage low
            // and so object deletion events are fired.
            $domain->objects()->chunk(500, function ($objects) {
                /** @var LdapObject $object */
                foreach ($objects as $object) {
                     $object->forceDelete();
                }
            });
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * The belongsTo creator relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The hasMany LDAP scans relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scans()
    {
        return $this->hasMany(LdapScan::class, 'domain_id');
    }

    /**
     * The hasMany objects relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function objects()
    {
        return $this->hasMany(LdapObject::class, 'domain_id');
    }

    /**
     * Returns the domains connection attributes.
     *
     * @return array
     */
    public function getConnectionAttributes()
    {
        $attributes = $this->only([
            'username',
            'password',
            'hosts',
            'base_dn',
            'port',
            'timeout',
            'follow_referrals'
        ]);

        $attributes['use_ssl'] = $this->encryption == 'ssl';
        $attributes['use_tls'] = $this->encryption == 'tls';

        return $attributes;
    }

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
