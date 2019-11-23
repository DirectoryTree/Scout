<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function (User $user) {
            $user->notifications()->delete();
        });
    }

    /**
     * The belongsToMany object pins relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pins()
    {
        return $this->belongsToMany(LdapObject::class, 'ldap_object_pins', 'user_id', 'object_id');
    }

    /**
     * Get the users last unread notifications.
     *
     * @param int $limit
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function lastUnreadNotifications($limit = 10)
    {
        return $this->unreadNotifications()->limit($limit);
    }
}
