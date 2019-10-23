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
     * The updated object values.
     *
     * @var array
     */
    protected $updated;

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
     * @param array      $updated
     * @param array      $original
     */
    public function __construct(Collection $conditions, array $updated = [], array $original = [])
    {
        $this->conditions = $conditions;
        $this->updated = $updated;
        $this->original = $original;
    }

    /**
     * Determine if all of the conditions pass.
     *
     * @return bool
     */
    public function passes()
    {
        if ($this->conditions->isEmpty()) {
            return false;
        }

        // Here we will go through each of the notifiers conditions,
        // create their validator and ensure that they all pass.
        return $this->conditions->filter(function (LdapNotifierCondition $condition) {
            // Retrieve the condition validator class.
            $conditional = $this->getConditionValidatorByOperator($condition->operator);

            // Create the conditions validator and determine if it passes.
            return transform($conditional, function ($class) use ($condition) {
                return new $class(
                    $this->getUpdatedValueByCondition($condition),
                    $condition->attribute,
                    $this->getConditionValue($condition)
                );
            })->passes();
        })->count() == $this->conditions->count();
    }

    /**
     * Get the condition validator class by the operator.
     *
     * @param string $operator
     *
     * @return string
     */
    protected function getConditionValidatorByOperator($operator)
    {
        return $this->map[$operator];
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
            return $this->getOriginalValueByCondition($condition);
        }

        return Arr::wrap($condition->value);
    }

    /**
     * Get the original value for the conditions attribute.
     *
     * @param LdapNotifierCondition $condition
     *
     * @return array
     */
    protected function getOriginalValueByCondition(LdapNotifierCondition $condition)
    {
        // If the condition requires that the attribute be transformed, then
        // we will transform the values before retrieving the attribute.
        $original = $this->conditionRequiresAttributeTransformation($condition) ?
            $this->getTransformedValues($this->original) : $this->original;

        return Arr::wrap(Arr::get($original, $condition->attribute));
    }

    /**
     * Get the updated value for the conditions attribute.
     *
     * @param LdapNotifierCondition $condition
     *
     * @return array
     */
    protected function getUpdatedValueByCondition(LdapNotifierCondition $condition)
    {
        // If the condition requires that the attribute be transformed, then
        // we will transform the values before retrieving the attribute.
        $updated = $this->conditionRequiresAttributeTransformation($condition) ?
            $this->getTransformedValues($this->updated) : $this->updated;

        return Arr::wrap(Arr::get($updated, $condition->attribute));
    }

    /**
     * Determine if the condition requires that the attribute be transformed.
     *
     * @param LdapNotifierCondition $condition
     *
     * @return bool
     */
    protected function conditionRequiresAttributeTransformation(LdapNotifierCondition $condition)
    {
        return $condition->type === LdapNotifierCondition::TYPE_TIMESTAMP;
    }
}
