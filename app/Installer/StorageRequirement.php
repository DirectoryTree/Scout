<?php

namespace App\Installer;

use Illuminate\Support\Facades\File;

class StorageRequirement extends Requirement
{
    /**
     * The name of the requirement.
     *
     * @return string
     */
    public function name()
    {
        return __('Storage Directory');
    }

    /**
     * The description of the requirement.
     *
     * @return string
     */
    public function description()
    {
        return __('The app/storage directory must be writable.');
    }

    /**
     * Determine if the storage directory is writeable.
     *
     * @return bool
     */
    public function passes()
    {
        return File::isWritable(storage_path());
    }
}
