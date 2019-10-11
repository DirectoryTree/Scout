<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function (LdapNotifier $notifier) {
            $notifier->conditions()->delete();
        });
    }

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

    /**
     * Get system notifiers.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeSystem(Builder $query)
    {
        return $query->where('system', '=', true);
    }

    /**
     * Get custom notifiers.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeCustom(Builder $query)
    {
        return $query->where('system', '=', false);
    }
}
