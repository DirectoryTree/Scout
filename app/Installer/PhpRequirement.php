<?php

namespace App\Installer;

class PhpRequirement extends Requirement
{
    /**
     * The minimum required PHP version.
     *
     * @var string
     */
    protected $version = '7.2';

    /**
     * The name of the requirement.
     *
     * @return string
     */
    public function name()
    {
        return 'PHP';
    }

    /**
     * The description of the requirement.
     *
     * @return string
     */
    public function description()
    {
        return __("The servers PHP version must be greater or equal to {$this->version}");
    }

    /**
     * Determine if the PHP requirement is satisfied.
     *
     * @return bool
     */
    public function passes()
    {
        return version_compare(PHP_VERSION, $this->version) > 0;
    }
}
