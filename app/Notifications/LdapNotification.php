<?php

namespace App\Notifications;

use App\LdapObject;
use App\LdapNotifier;
use Illuminate\Support\Arr;
use Illuminate\Notifications\Notification;

class LdapNotification extends Notification
{
    /**
     * @var LdapObject
     */
    protected $object;

    /**
     * @var LdapNotifier
     */
    protected $notifier;

    /**
     * Constructor.
     *
     * @param LdapObject   $object
     * @param LdapNotifier $notifier
     */
    public function __construct(LdapObject $object, LdapNotifier $notifier)
    {
        $this->object = $object;
        $this->notifier = $notifier;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * Returns the modified attributes names.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        $attributes = $this->notifier->conditions->pluck('attribute')->transform(function ($attribute) {
            return [
                $attribute => [
                    'original' => $this->getOriginalValue($attribute),
                    'updated' => $this->getUpdatedValue($attribute),
                ]
            ];
        });

        return [
            'on' => $this->object->name,
            'name' => $this->notifier->name,
            'notifiable_name' => $this->notifier->notifiable_name,
            'attributes' => $attributes,
        ];
    }

    /**
     * Get the LDAP objects original value for the attribute.
     *
     * @param string $key
     *
     * @return mixed
     */
    protected function getOriginalValue($key)
    {
        return Arr::get($this->getOriginalValues(), $key);
    }

    /**
     * Get the LDAP objects updated value for the attribute.
     *
     * @param string $key
     *
     * @return mixed
     */
    protected function getUpdatedValue($key)
    {
        return Arr::get($this->getUpdatedValues(), $key);
    }

    /**
     * Get the LDAP objects original values.
     *
     * @return array
     */
    protected function getOriginalValues()
    {
        return json_decode($this->object->getOriginal('values'), true);
    }

    /**
     * Get the LDAP objects updated values.
     *
     * @return array
     */
    protected function getUpdatedValues()
    {
        return $this->object->getAttribute('values');
    }
}
