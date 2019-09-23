<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LdapNotification extends Model
{
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
     * The belongsTo object relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function object()
    {
        return $this->belongsTo(LdapObject::class, 'object_id');
    }
}
