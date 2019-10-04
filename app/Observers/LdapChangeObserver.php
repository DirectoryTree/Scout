<?php

namespace App\Observers;

use App\LdapChange;
use App\LdapNotifier;
use App\Ldap\Conditions\Has;
use App\LdapNotifierCondition;
use App\Ldap\Conditions\Equals;
use App\Ldap\Conditions\IsPast;
use App\Ldap\Conditions\Contains;
use App\Notifications\LdapObjectHasChanged;
use App\Ldap\Transformers\AttributeTransformer;

class LdapChangeObserver
{
    /**
     * The conditions map.
     *
     * @var array
     */
    protected $map = [
        LdapNotifierCondition::OPERATOR_HAS => Has::class,
        LdapNotifierCondition::OPERATOR_PAST => IsPast::class,
        LdapNotifierCondition::OPERATOR_EQUALS => Equals::class,
        LdapNotifierCondition::OPERATOR_CONTAINS => Contains::class,
    ];

    /**
     * Fire the relevant events upon LDAP change creation.
     *
     * @param LdapChange $change
     */
    public function created(LdapChange $change)
    {
        logger("Change: {$change->getKey()} created.");

        // Here we will retrieve all the notifiers that contain conditions for the changed attribute.
        LdapNotifier::query()->whereHas('conditions', function ($query) use ($change) {
             return $query->where('attribute', '=', $change->attribute);
        })->with('conditions')->get()->each(function (LdapNotifier $notification) use ($change) {
            if (
                ($notifiable = $notification->notifiable) &&
                $this->isNotifiable($notifiable) &&
                $this->passesConditions($notification->conditions, $change)
            ) {
                $notifiable->notify(new LdapObjectHasChanged($change));
            }
        });
    }

    /**
     * Determine if all of the notifier conditions pass.
     *
     * @param \Illuminate\Support\Collection $conditions
     * @param LdapChange                     $change
     *
     * @return bool
     */
    protected function passesConditions($conditions, LdapChange $change)
    {
        return $conditions->filter(function (LdapNotifierCondition $condition) use ($change) {
            // Create the conditions validator and determine if it passes.
            return transform($this->map[$condition->operator], function ($class) use ($change, $condition) {
                return new $class(
                    $this->getTransformedValue($change),
                    $condition->attribute,
                    $condition->operator,
                    $condition->value
                );
            })->passes();
        })->count() == $conditions->count();
    }

    /**
     * Get the transformed changed value.
     *
     * @param LdapChange $change
     *
     * @return mixed
     */
    protected function getTransformedValue(LdapChange $change)
    {
        return $this->transformChangedValue([
            $change->attribute => $change->after
        ])[$change->attribute];
    }

    /**
     * Transform the changed value for conditional checking.
     *
     * @param array $value
     *
     * @return array|mixed
     */
    protected function transformChangedValue(array $value)
    {
        return (new AttributeTransformer($value))->transform();
    }

    /**
     * Determine if the given model is notifiable.
     *
     * @param mixed $notifiable
     *
     * @return bool
     */
    protected function isNotifiable($notifiable)
    {
        return method_exists($notifiable, 'notify');
    }
}
