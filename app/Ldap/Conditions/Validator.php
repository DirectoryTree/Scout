<?php

namespace App\Ldap\Conditions;

use App\LdapNotifierCondition;
use Illuminate\Support\Collection;
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
        LdapNotifierCondition::OPERATOR_CONTAINS => Contains::class,
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
     * @param array      $value
     */
    public function __construct(Collection $conditions, array $value = [])
    {
        $this->conditions = $conditions;
        $this->value = $value;
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
                        $this->getTransformedValue($condition),
                        $condition->attribute,
                        $condition->operator,
                        $condition->value
                    );
                })->passes();
            })->count() == $this->conditions->count();
    }

    /**
     * Get the transformed value.
     *
     * @param LdapNotifierCondition $condition
     *
     * @return mixed
     */
    protected function getTransformedValue(LdapNotifierCondition $condition)
    {
        return $this->transformChangedValue([
            $condition->attribute => $this->value
        ])[$condition->attribute];
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
}
