<?php

namespace App\Notifications;

use App\LdapObject;
use App\LdapNotifier;
use App\Http\Resources\LdapObject as LdapObjectResource;
use App\Http\Resources\LdapNotifier as LdapNotifierResource;
use Illuminate\Support\Collection;
use Illuminate\Notifications\Notification;

class LdapNotification extends Notification
{
    /**
     * @var LdapNotifier
     */
    protected $notifier;

    /**
     * @var LdapObject
     */
    protected $object;

    /**
     * An array containing all of the notifier log IDs.
     *
     * @var array
     */
    protected $logs;

    /**
     * Constructor.
     *
     * @param LdapNotifier $notifier
     * @param LdapObject   $object
     * @param Collection   $logs
     */
    public function __construct(LdapNotifier $notifier, LdapObject $object, Collection $logs)
    {
        $this->notifier = $notifier;
        $this->object = $object;
        $this->logs = $logs;
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
        return [
            'object' => LdapObjectResource::make($this->object),
            'notifier' => LdapNotifierResource::make($this->notifier),
            'logs' => $this->logs,
        ];
    }
}
