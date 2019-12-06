<?php

namespace Tests\Unit\System;

use Tests\TestCase;
use App\System\TaskTrigger;

class TaskTriggerTest extends TestCase
{
    public function test_trigger_is_enabled_by_default()
    {
        $this->assertEquals('true', (new TaskTrigger)->Enabled);
    }

    public function test_root_element_name_can_be_set()
    {
        $trigger = new TaskTrigger();
        $trigger->setRootElementName('Test');
        $this->assertEquals('Test', $trigger->getRootElementName());
        $this->assertEquals(['Enabled' => 'true'], $trigger->getAttributes());
    }

    public function test_trigger_types_populate_root_element()
    {
        $this->assertEquals('BootTrigger', TaskTrigger::boot()->getRootElementName());
        $this->assertEquals('CalendarTrigger', TaskTrigger::calendar()->getRootElementName());
        $this->assertEquals('RegistrationTrigger', TaskTrigger::registration()->getRootElementName());
        $this->assertEquals('IdleTrigger', TaskTrigger::idle()->getRootElementName());
        $this->assertEquals('LogonTrigger', TaskTrigger::logon()->getRootElementName());
        $this->assertEquals('SessionStateChangeTrigger', TaskTrigger::sessionStateChange()->getRootElementName());
    }
}
