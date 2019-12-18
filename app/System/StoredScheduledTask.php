<?php

namespace App\System;

use Illuminate\Support\Facades\File;

class StoredScheduledTask extends ScheduledTask
{
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
}
