<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LdapChange extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attribute',
        'before',
        'after',
        'ldap_updated_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['ldap_updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'before' => 'array',
        'after' => 'array',
    ];

    /**
     * The belongsTo LDAP object relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function object()
    {
        return $this->belongsTo(LdapObject::class, 'object_id');
    }
}
