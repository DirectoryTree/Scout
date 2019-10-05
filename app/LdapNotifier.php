<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LdapNotifier extends Model
{
    /**
     * The notifier types.
     *
     * When the notifier should be executed (on changes, attributes, deletes).
     */
    const TYPE_ATTRIBUTES = 'attributes';
    const TYPE_CHANGES = 'changes';
    const TYPE_DELETES = 'deletes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'system',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'system' => 'boolean',
        'enabled' => 'boolean',
    ];

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
