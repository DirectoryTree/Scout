<?php

namespace App\System;

use Illuminate\Support\Fluent;

class TaskTrigger extends Fluent
{
    /**
     * The default task attributes.
     *
     * @var array
     */
    protected $attributes = [
        'Enabled' => 'true',
    ];

    /**
     * Get the root element name of the trigger.
     *
     * @var string|null
     */
    protected $rootElementName;

    /**
     * Generate a calendar trigger.
     *
     * @param array $attributes
     *
     * @return static
     */
    public static function calendar(array $attributes = [])
    {
        return (new static($attributes))->setRootElementName('CalendarTrigger');
    }

    /**
     * Generate a boot trigger.
     *
     * @param array $attributes
     *
     * @return static
     */
    public static function boot(array $attributes = [])
    {
        return (new static($attributes))->setRootElementName('BootTrigger');
    }

    /**
     * Generate a logon trigger.
     *
     * @param array $attributes
     *
     * @return static
     */
    public static function logon(array $attributes = [])
    {
        return (new static($attributes))->setRootElementName('LogonTrigger');
    }

    /**
     * Generate an idle trigger.
     *
     * @param array $attributes
     *
     * @return static
     */
    public static function idle(array $attributes = [])
    {
        return (new static($attributes))->setRootElementName('IdleTrigger');
    }

    /**
     * Generate an event trigger.
     *
     * @param array $attributes
     *
     * @return static
     */
    public static function event(array $attributes = [])
    {
        return (new static($attributes))->setRootElementName('EventTrigger');
    }

    /**
     * Generate a registration trigger.
     *
     * @param array $attributes
     *
     * @return static
     */
    public static function registration(array $attributes = [])
    {
        return (new static($attributes))->setRootElementName('RegistrationTrigger');
    }

    /**
     * Generate a state change trigger.
     *
     * @param array $attributes
     *
     * @return static
     */
    public static function sessionStateChange(array $attributes = [])
    {
        return (new static($attributes))->setRootElementName('SessionStateChangeTrigger');
    }

    /**
     * Set the root task element name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setRootElementName($name)
    {
        $this->rootElementName = $name;

        return $this;
    }

    /**
     * Get the task root element name.
     *
     * @return string|null
     */
    public function getRootElementName()
    {
        return $this->rootElementName;
    }
}
