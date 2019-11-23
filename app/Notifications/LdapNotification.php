<?php

namespace App\Notifications;

use App\LdapObject;
use App\LdapNotifier;
use Illuminate\Support\Collection;

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

    public function getName()
    {
        return $this->object->name;
    }

    public function getTitle()
    {
        return $this->notifier->notifiable_name;
    }

    public function getBody()
    {
        return $this->object->dn;
    }
}
