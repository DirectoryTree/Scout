<?php

namespace App\Actions;

abstract class Action
{
    /**
     * Execute the action.
     *
     * @return mixed
     */
    abstract public function execute();
}
