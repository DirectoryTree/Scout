<?php

namespace App\Jobs;

use App\User;
use App\LdapObject;
use App\LdapNotifier;
use App\LdapNotifierLog;
use App\Ldap\Conditions\Validator;
use App\Notifications\LdapNotification;
use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateLdapNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The LDAP object.
     *
     * @var LdapObject
     */
    protected $object;

    /**
     * Constructor.
     *
     * @param LdapObject $object
     */
    public function __construct(LdapObject $object)
    {
        $this->object = $object;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $attributes = array_keys($this->object->values);

        // Here we will retrieve all the notifiers that contain conditions for the
        // objects attributes, determine if the notifiable model can be notified
        // and if all the conditions pass for the notifier conditions.
        $this->getNotifiersForAttributes($attributes)->each(function (LdapNotifier $notifier) {
            if ($this->passesConditions($notifier->conditions)) {
                $this->createNotifierLogs($notifier);

                $notification = new LdapNotification($notifier, $this->object);

                $users = $notifier->all_users ? User::all() : $notifier->users()->get();

                /** @var User $user */
                foreach ($users as $user) {
                    $user->notify($notification);
                }
            }
        });
    }

    /**
     * Create the notifier logs.
     *
     * @param LdapNotifier $notifier
     * @param LdapObject   $object
     *
     * @return \Illuminate\Support\Collection
     */
    protected function createNotifierLogs(LdapNotifier $notifier)
    {
        $logs = collect();

        $notifier->conditions->pluck('attribute')->each(function ($attribute) use ($notifier, $logs) {
            $log = new LdapNotifierLog();

            $log->notifier()->associate($notifier);
            $log->object()->associate($this->object);

            $log->before = $this->getOriginalValue($attribute);
            $log->after = $this->getUpdatedValue($attribute);

            $log->save();

            $logs->add($log);
        });

        return $logs;
    }

    /**
     * Get the LDAP notifiers for the given attributes.
     *
     * @param array $attributes
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getNotifiersForAttributes(array $attributes)
    {
        return LdapNotifier::enabled()->whereHas('conditions', function ($query) use ($attributes) {
            return $query->whereIn('attribute', $attributes);
        })->with('conditions')->get();
    }

    /**
     * Determine if all of the notifier conditions pass.
     *
     * @param \Illuminate\Support\Collection $conditions
     *
     * @return bool
     */
    protected function passesConditions($conditions)
    {
        return (new Validator(
            $conditions,
            $this->getUpdatedValues(),
            $this->getOriginalValues()
        ))->passes();
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
     * @param LdapObject $object
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
     * @param LdapObject $object
     *
     * @return array
     */
    protected function getUpdatedValues()
    {
        return $this->object->getAttribute('values');
    }
}
