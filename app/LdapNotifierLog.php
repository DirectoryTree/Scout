<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LdapNotifierLog extends Model
{
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
     * The belongsTo notifier relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notifier()
    {
        return $this->belongsTo(LdapNotifier::class, 'notifier_id');
    }

    /**
     * The belongsTo object relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function object()
    {
        return $this->belongsTo(LdapObject::class, 'object_id');
    }
}
