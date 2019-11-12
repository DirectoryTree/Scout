<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LdapObject extends Model
{
    use SoftDeletes;

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
    protected $appends = ['icon'];

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
     * The belongsTo parent relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * The hasMany children relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->latest();
    }

    /**
     * The hasMany descendants relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
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
     * Determine if the object can have groups.
     *
     * @return bool
     */
    public function canHaveGroups()
    {
        return in_array($this->type, ['group', 'user']);
    }

    /**
     * Get the LDAP objects type icon.
     *
     * @return string
     */
    public function getIconAttribute()
    {
        switch ($this->type) {
            case 'group':
                return 'fas fa-users';
            case 'container':
                return 'far fa-folder';
            case 'user':
                return 'far fa-user';
            case 'domain':
                return '';
        }
    }
}
