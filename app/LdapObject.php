<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class LdapObject extends Model
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dn',
        'guid',
        'domain',
        'attributes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['attributes' => 'array'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // We don't need to worry about eloquent events firing
        // for change records. We'll bulk delete the changes.
        static::deleting(function(LdapObject $object) {
            $object->changes()->delete();
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
}
