<?php

namespace App\Installer;

abstract class Requirement
{
    /**
     * Whether the requirement has passed.
     *
     * @var bool
     */
    protected $passed = false;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->passed = $this->passes();
    }

    /**
     * The name of the requirement.
     *
     * @return string
     */
    abstract public function name();

    /**
     * The description of the requirement.
     *
     * @return string
     */
    abstract public function description();

    /**
     * Whether the requirement passes.
     *
     * @return bool
     */
    abstract public function passes();
}
