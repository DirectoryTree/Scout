<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LdapNotifier extends Model
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
     * The hasMany conditions relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conditions()
    {
        return $this->hasMany(LdapNotifierCondition::class, 'notifier_id');
    }

    /**
     * The owning notifiable models relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function notifiable()
    {
        return $this->morphTo();
    }
}
