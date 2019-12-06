<?php

namespace Tests\Unit\System;

use Tests\TestCase;
use App\System\TaskTrigger;
use App\System\ScheduledTask;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ScheduledTaskTest extends TestCase
{
    public function test_default_triggers()
    {
        $task = new ScheduledTask();
        $this->assertContainsOnlyInstancesOf(TaskTrigger::class, $task->triggers());
    }

    public function test_path()
    {
        $task = new ScheduledTask();
        $task->name = 'Test';
        $this->assertTrue(Str::contains($task->path(), storage_path('app'.DIRECTORY_SEPARATOR.'Test.xml')));
    }

    public function test_command()
    {
        $task = new ScheduledTask();
        $task->name = 'Test';
        $this->assertEquals(sprintf('schtasks /Create /TN "Test" /XML "%s" /F', $task->path()), $task->command());
    }

    public function test_create()
    {
        $task = new ScheduledTask();
        $task->name = 'Test';
        File::shouldReceive('put')->withArgs([$task->path(), $task->toXml()])->once();
        $this->assertEquals($task->path(), $task->create());
    }

    public function test_exists()
    {
        $task = new ScheduledTask();
        $task->name = 'Test';

        File::shouldReceive('exists')->withArgs([$task->path()])->once()->andReturnTrue();
        $this->assertTrue($task->exists());
    }
}
