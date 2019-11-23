<?php

namespace App;

use App\Ldap\TypeGuesser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LdapObject extends Model
{
    use SoftDeletes, IsSelfReferencing;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dn',
        'guid',
        'domain',
        'values',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'values' => 'array',
        'pinned' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['icon', 'pinned'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // We don't need to worry about eloquent events firing
        // for change records. We'll bulk delete the changes
        // if the LDAP object is being force deleted.
        static::deleting(function(LdapObject $object) {
            if ($object->isForceDeleting()) {
                $object->changes()->delete();
                $object->notifiers()->delete();
                $object->users()->detach();
            }
        });
    }

    /**
     * The belongsTo domain relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domain()
    {
        return $this->belongsTo(LdapDomain::class, 'domain_id');
    }

    /**
     * The hasMany changes relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function changes()
    {
        return $this->hasMany(LdapChange::class, 'object_id');
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
     * The belongsToMany users relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'ldap_object_pins', 'object_id', 'user_id');
    }

    /**
     * Determine if the object can have groups.
     *
     * @return bool
     */
    public function canHaveGroups()
    {
        return in_array($this->type, [
            TypeGuesser::TYPE_GROUP,
            TypeGuesser::TYPE_USER
        ]);
    }

    /**
     * Determine if the object is pinned to the current users dashboard.
     *
     * @return bool
     */
    public function getPinnedAttribute()
    {
        return $this->users()->where('user_id', auth()->id())->exists();
    }

    /**
     * Get the LDAP objects type icon.
     *
     * @return string
     */
    public function getIconAttribute()
    {
        switch ($this->type) {
            case TypeGuesser::TYPE_GROUP:
                return 'fas fa-users';
            case TypeGuesser::TYPE_CONTAINER:
                return 'far fa-folder';
            case TypeGuesser::TYPE_USER:
                return 'far fa-user';
            case 'domain':
                return '';
        }
    }
}
