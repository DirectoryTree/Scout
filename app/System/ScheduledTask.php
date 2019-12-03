<?php

namespace App\System;

use Illuminate\Support\Str;
use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\File;
use Spatie\ArrayToXml\ArrayToXml;
use Symfony\Component\Process\PhpExecutableFinder;

abstract class ScheduledTask extends Fluent
{
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
        $path = storage_path(sprintf('app/%s.xml', $this->name));

        File::put($path, $this->generate());

        return $path;
    }

    /**
     * Generate a command for importing the scheduled task.
     *
     * @param string $path The path to the scheduled task XML file.
     *
     * @return string
     */
    public function command($path)
    {
        return sprintf('schtasks /Create /TN "%s" /XML "%s" /F', $this->name, $path);
    }

    /**
     * Generate the XML document.
     *
     * @return string
     */
    public function generate()
    {
        return ArrayToXml::convert(
            $this->template(),
            $this->rootAttributes(),
            $replaceSpacesByUnderScoresInKeyNames = true,
            $xmlEncoding = 'UTF-16',
            $xmlVersion = '1.0',
            ['formatOutput' => true]
        );
    }

    /**
     * Get the start date of the task.
     *
     * @return string
     */
    protected function getStartDate()
    {
        return $this->get('start', now()->format($this->dateFormat));
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
            'Triggers' => [
                'CalendarTrigger' => [
                    'Repetition' => [
                        'Interval' => $this->interval,
                        'StopAtDurationEnd' => 'false',
                    ],
                    'StartBoundary' => $this->getStartDate(),
                    'Enabled' => 'true',
                    'ScheduleByDay' => [
                        'DaysInterval' => 1
                    ],
                ],
            ],
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
