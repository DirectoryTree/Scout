<?php

namespace App\Ldap\Conditions;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use App\LdapNotifierCondition;
use App\Ldap\Transformers\AttributeTransformer;

class Validator
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
        LdapNotifierCondition::OPERATOR_NOT_EQUALS => NotEquals::class,
        LdapNotifierCondition::OPERATOR_CONTAINS => Contains::class,
        LdapNotifierCondition::OPERATOR_LESS_THAN => LessThan::class,
        LdapNotifierCondition::OPERATOR_GREATER_THAN => GreaterThan::class,
        LdapNotifierCondition::OPERATOR_CHANGED => Changed::class,
    ];

    /**
     * The conditions to validate against.
     *
     * @var Collection
     */
    protected $conditions;

    /**
     * The values to validate.
     *
     * @var array
     */
    protected $values;

    /**
     * The original object values.
     *
     * @var array
     */
    protected $original;

    /**
     * Constructor.
     *
     * @param Collection $conditions
     * @param array      $values
     * @param array      $original
     */
    public function __construct(Collection $conditions, array $values = [], array $original = [])
    {
        $this->conditions = $conditions;
        $this->values = $this->getTransformedValues($values);
        $this->original = $this->getTransformedValues($original);
    }

    /**
     * Determine if all of the conditions pass.
     *
     * @return bool
     */
    public function passes()
    {
        return $this->conditions->filter(function (LdapNotifierCondition $condition) {
                // Create the conditions validator and determine if it passes.
                return transform($this->map[$condition->operator], function ($class) use ($condition) {
                    return new $class(
                        $this->getValueForAttribute($condition->attribute),
                        $condition->attribute,
                        $this->getConditionValue($condition)
                    );
                })->passes();
            })->count() == $this->conditions->count();
    }

    /**
     * Get the transformed values.
     *
     * @param array $values
     *
     * @return array
     */
    protected function getTransformedValues(array $values)
    {
        return (new AttributeTransformer($values))->transform();
    }

    /**
     * Get the conditions value.
     *
     * @param LdapNotifierCondition $condition
     *
     * @return array
     */
    protected function getConditionValue(LdapNotifierCondition $condition)
    {
        // If we're working with a 'changed' operator, we must pass the
        // original objects values so it can be compared to properly.
        if ($condition->operator == LdapNotifierCondition::OPERATOR_CHANGED) {
            return $this->original;
        }

        return Arr::wrap($condition->value);
    }

    /**
     * Get the attributes value.
     *
     * @param string $attribute
     *
     * @return array
     */
    protected function getValueForAttribute($attribute)
    {
        return Arr::wrap(Arr::get($this->values, $attribute));
    }
}
