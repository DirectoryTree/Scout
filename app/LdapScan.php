<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LdapScan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'started_at',
        'completed_at',
        'success',
        'message',
        'synchronized',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'started_at',
        'completed_at',
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
