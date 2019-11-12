<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use LdapRecord\Models\Entry as UnknownModel;
use LdapRecord\Models\OpenLDAP\Entry as OpenLdapModel;
use LdapRecord\Models\ActiveDirectory\Entry as ActiveDirectoryModel;

class LdapDomain extends Model
{
    // The LDAP connection types.
    const TYPE_UNKNOWN = 1;
    const TYPE_ACTIVE_DIRECTORY = 2;
    const TYPE_OPEN_LDAP = 3;
    const TYPE_ACTIVE_DIRECTORY_LDS = 4;

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
        'attempted_at',
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
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'username',
        'password',
        'token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['attempted_at'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function (LdapDomain $domain) {
            $domain->token = Str::random(40);
        });

        static::deleting(function(LdapDomain $domain) {
            // Delete any scans that have been performed.
            $domain->scans()->delete();

            // Delete any LDAP notifiers.
            $domain->notifiers()->each(function (LdapNotifier $notifier) {
                $notifier->delete();
            });

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
     * The hasManyThrough changes relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function changes()
    {
        return $this->hasManyThrough(LdapChange::class, LdapObject::class, 'domain_id', 'object_id');
    }

    /**
     * The morphMany LDAP notifiers relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifiers()
    {
        return $this->morphMany(LdapNotifier::class, 'notifiable');
    }

    /**
     * Determine if password operations can be ran for the domain.
     *
     * @return bool
     */
    public function canModifyPasswords()
    {
        return in_array($this->encryption, ['tls', 'ssl']);
    }

    /**
     * Returns the domains connection name.
     *
     * @return string
     */
    public function getLdapConnectionName()
    {
        return $this->slug;
    }

    /**
     * Returns the domains connection attributes.
     *
     * @return array
     */
    public function getLdapConnectionAttributes()
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
     * Get the domains LDAP model.
     *
     * @return ActiveDirectoryModel|UnknownModel|OpenLdapModel
     */
    public function getLdapModel()
    {
        switch($this->type) {
            case LdapDomain::TYPE_ACTIVE_DIRECTORY:
            case LdapDomain::TYPE_ACTIVE_DIRECTORY_LDS:
                $model = new ActiveDirectoryModel();
                break;
            case LdapDomain::TYPE_OPEN_LDAP:
                $model = new OpenLdapModel();
                break;
            default:
                $model = new UnknownModel();
                break;
        }

        $model->setConnection($this->getLdapConnectionName());

        return $model;
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
