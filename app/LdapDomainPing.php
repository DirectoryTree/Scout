<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LdapDomainPing extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'host',
        'success',
        'message',
        'response_time',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['success' => 'boolean'];

    /**
     * The belongsTo domain relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domain()
    {
        return $this->belongsTo(LdapDomain::class, 'domain_id');
    }
}
