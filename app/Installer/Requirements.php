<?php

namespace App\Installer;

class Requirements
{
    /**
     * The installation requirements.
     *
     * @var array
     */
    protected $requirements = [
        PhpRequirement::class,
        LdapRequirement::class,
        StorageRequirement::class,
    ];

    /**
     * The checked requirements.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $checked;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->checked = collect($this->requirements)->transform(function ($requirement) {
            return (new $requirement);
        });
    }

    /**
     * Get the checked requirements.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        return $this->checked;
    }

    /**
     * Determine if all application requirements pass.
     *
     * @return bool
     */
    public function passes()
    {
        return $this->checked->filter(function (Requirement $requirement) {
            return $requirement->passes();
        })->count() === $this->checked->count();
    }
}
