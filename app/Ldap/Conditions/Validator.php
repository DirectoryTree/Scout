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
    ];

    /**
     * The conditions to validate against.
     *
     * @var Collection
     */
    protected $conditions;

    /**
     * The value to validate.
     *
     * @var array
     */
    protected $value;

    /**
     * Constructor.
     *
     * @param Collection $conditions
     * @param array      $values
     */
    public function __construct(Collection $conditions, array $values = [])
    {
        $this->conditions = $conditions;
        $this->value = $this->getTransformedValues($values);
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
                        $this->getAttributeValue($condition->attribute),
                        $condition->attribute,
                        $condition->value
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
     * Get the attributes value.
     *
     * @param string $attribute
     *
     * @return mixed
     */
    protected function getAttributeValue($attribute)
    {
        return Arr::get($this->value, $attribute);
    }
}
