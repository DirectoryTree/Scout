<?php

namespace App\Ldap\Conditions;

abstract class Condition
{
    /**
     * The current attributes value.
     *
     * @var array
     */
    protected $current;

    /**
     * The conditions attribute.
     *
     * @var string
     */
    protected $attribute;

    /**
     * The conditions operator.
     *
     * @var string
     */
    protected $operator;

    /**
     * The conditions value.
     *
     * @var array|string|null
     */
    protected $value;

    /**
     * Constructor.
     *
     * @param string      $current
     * @param string      $attribute
     * @param string      $operator
     * @param string|null $value
     */
    public function __construct($current, $attribute, $operator, $value = null)
    {
        $this->current = $current;
        $this->attribute = $attribute;
        $this->operator = $operator;
        $this->value = $value;
    }

    /**
     * Determine if the condition passes.
     *
     * @return bool
     */
    abstract function passes();
}
