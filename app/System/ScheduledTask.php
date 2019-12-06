<?php

namespace App\System;

use Illuminate\Support\Str;
use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\PhpExecutableFinder;

class ScheduledTask extends Fluent
{
    use GeneratesXml;

    /**
     * The format to use for the scheduled task dates.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d\TH:i:s';

    /**
     * Create the scheduled task XML file.
     *
     * @return string
     */
    public function create()
    {
        $path = $this->path();

        File::put($path, $this->toXml());

        return $path;
    }

    /**
     * Determine if the scheduled task file exists.
     *
     * @return bool
     */
    public function exists()
    {
        return File::exists($this->path());
    }

    /**
     * Get the full file path of the XML document.
     *
     * @return string
     */
    public function path()
    {
        return storage_path(sprintf('app'.DIRECTORY_SEPARATOR.'%s.xml', $this->name));
    }

    /**
     * Generate a command for importing the scheduled task.
     *
     * @return string
     */
    public function command()
    {
        return sprintf('schtasks /Create /TN "%s" /XML "%s" /F', $this->name, $this->path());
    }

    /**
     * Get the triggers for the scheduled task.
     *
     * @return TaskTrigger[]
     */
    public function triggers()
    {
        return [
            // We will enable a registration trigger to trigger the task
            // as soon as it's imported. Then, the boot trigger will
            // take over if the server is ever restarted.
            TaskTrigger::registration([
                'Repetition' => [
                    'Interval' => $this->interval,
                    'StopAtDurationEnd' => 'false',
                ],
                'StartBoundary' => $this->getStartDate(),
            ]),
            TaskTrigger::boot([
                'Repetition' => [
                    'Interval' => $this->interval,
                    'StopAtDurationEnd' => 'false',
                ],
                'StartBoundary' => $this->getStartDate(),
            ]),
            // We will create a daily calendar trigger to regularly try starting
            // the task in case it fails. This trigger should begin once the
            // task is imported for the first time.
            TaskTrigger::calendar([
                'Repetition' => [
                    'Interval' => $this->interval,
                    'StopAtDurationEnd' => 'false',
                ],
                'StartBoundary' => $this->getStartDate(),
                'ScheduleByDay' => [
                    'DaysInterval' => 1
                ],
            ]),
        ];
    }

    /**
     * Get the scheduled task triggers mapped via key.
     *
     * @return array
     */
    protected function getMappedTriggers()
    {
        $triggers = [];

        foreach ($this->triggers() as $trigger) {
            $triggers[$trigger->getRootElementName()] = $trigger->toArray();
        }

        return $triggers;
    }

    /**
     * Get the start date of the task.
     *
     * @return string
     */
    protected function getStartDate()
    {
        return $this->get('start', now()->subMinute()->format($this->dateFormat));
    }

    /**
     * The XML template.
     *
     * @return array
     */
    protected function template()
    {
        return [
            'RegistrationInfo' => [
                'Date' => $this->get('date', now()->format($this->dateFormat)),
                'Author' => $this->author,
                'Description' => $this->description,
                'URI' => Str::start($this->name, '\\'),
            ],
            'Triggers' => $this->getMappedTriggers(),
            'Principals' => [
                'Principal' => [
                    '_attributes' => [
                        'id' => 'Author',
                    ],
                    'UserId' => $this->user_id,
                    'RunLevel' => 'LeastPrivilege',
                ],
            ],
            'Settings' => [
                'MultipleInstancesPolicy' => 'IgnoreNew',
                'DisallowStartIfOnBatteries' => 'true',
                'StopIfGoingOnBatteries' => 'true',
                'AllowHardTerminate' => 'true',
                'StartWhenAvailable' => 'true',
                'RunOnlyIfNetworkAvailable' => 'false',
                'IdleSettings' => [
                    'StopOnIdleEnd' => 'true',
                    'RestartOnIdle' => 'true',
                ],
                'AllowStartOnDemand' => 'true',
                'Enabled' => 'true',
                'Hidden' => 'false',
                'RunOnlyIfIdle' => 'false',
                'WakeToRun' => 'false',
                'ExecutionTimeLimit' => $this->time_limit,
                'Priority' => 7,
            ],
            'Actions' => [
                '_attributes' => [
                    'Context' => 'Author',
                ],
                'Exec' => [
                    'Command' => $this->phpExecutable(),
                    'Arguments' => sprintf('artisan %s', $this->command),
                    'WorkingDirectory' => $this->get('path', base_path()),
                ],
            ]
        ];
    }

    /**
     * The root XML document properties.
     *
     * @return array
     */
    protected function rootAttributes()
    {
        return [
            'rootElementName' => 'Task',
            '_attributes' => [
                'xmlns' => 'http://schemas.microsoft.com/windows/2004/02/mit/task',
                'version' => '1.2',
            ],
        ];
    }

    /**
     * Get the PHP executable path.
     *
     * @return string
     */
    protected function phpExecutable()
    {
        return (new PhpExecutableFinder())->find() ?? 'php';
    }
}
