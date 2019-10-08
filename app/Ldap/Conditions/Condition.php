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
     * The conditions value.
     *
     * @var array
     */
    protected $values;

    /**
     * Constructor.
     *
     * @param array       $current
     * @param string      $attribute
     * @param array|null  $values
     */
    public function __construct(array $current, $attribute, array $values = [])
    {
        $this->current = $current;
        $this->attribute = $attribute;
        $this->values = $values;
    }

    /**
     * Determine if the condition passes.
     *
     * @return bool
     */
    abstract function passes();
}
