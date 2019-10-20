<?php

namespace App\Jobs;

use App\User;
use App\LdapObject;
use App\LdapNotifier;
use App\LdapNotifierLog;
use App\LdapNotifierCondition;
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
     * The objects original values.
     *
     * @var array
     */
    protected $original;

    /**
     * The objects updated values.
     *
     * @var array
     */
    protected $updated;

    /**
     * Constructor.
     *
     * @param LdapObject $object
     * @param array      $original
     * @param array      $updated
     */
    public function __construct(LdapObject $object, array $original = [], array $updated = [])
    {
        $this->object = $object;
        $this->original = $original;
        $this->updated = $updated;
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
            if ($this->getConditionValidator($notifier->conditions)->passes()) {
                $logs = $this->createNotifierLogs($notifier)->pluck('id');

                $notification = new LdapNotification($notifier, $this->object, $logs);

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

        $notifier->conditions->each(function (LdapNotifierCondition $condition) use ($notifier, $logs) {
            $log = new LdapNotifierLog();

            $log->notifier()->associate($notifier);
            $log->condition()->associate($condition);
            $log->object()->associate($this->object);

            $log->attribute = $condition->attribute;
            $log->before = $this->getOriginalValue($condition->attribute);
            $log->after = $this->getUpdatedValue($condition->attribute);

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
     * @return Validator
     */
    protected function getConditionValidator($conditions)
    {
        return new Validator(
            $conditions,
            $this->updated,
            $this->original
        );
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
        return Arr::get($this->original, $key);
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
        return Arr::get($this->updated, $key);
    }
}
