<?php

namespace App\Installer;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Spatie\Valuestore\Valuestore;

class Configuration
{
    /**
     * Whether the configuration file was recently created.
     *
     * @var bool
     */
    public $wasRecentlyCreated = false;

    /**
     * The configuration key.
     *
     * @var string
     */
    protected $key = 'scout.configured';

    /**
     * The configuration value store.
     *
     * @var Valuestore
     */
    protected $store;

    /**
     * Create a new configuration instance.
     *
     * @param Valuestore $store
     */
    public function __construct(Valuestore $store)
    {
        $this->store = $store;
    }

    /**
     * The .env file path.
     *
     * @return string
     */
    public static function getEnvFilePath()
    {
        return base_path('.env');
    }

    /**
     * The .env stub file path.
     *
     * @return string
     */
    public static function getEnvStubFilePath()
    {
        return base_path('.env.stub');
    }

    /**
     * Create the application configuration file.
     */
    public function create()
    {
        if ($this->hasBeenCreated()) {
            return;
        }

        if (!$this->createEnvFile()) {
            abort(500, 'Unable to create application .env file.');
        }

        Artisan::call('key:generate');

        $this->wasRecentlyCreated = true;
    }

    /**
     * Create the application .env file.
     *
     * @return bool
     */
    protected function createEnvFile()
    {
        return File::put($this->getEnvFilePath(), File::get($this->getEnvStubFilePath()));
    }

    /**
     * Update the application .env file with the given data.
     *
     * @param array $data
     */
    public function update(array $data)
    {
        $contents = strtr(File::get($this->getEnvFilePath()), [
            '{{DB_DRIVER}}' => Arr::get($data, 'driver'),
            '{{DB_HOST}}' => Arr::get($data, 'host'),
            '{{DB_PORT}}' => Arr::get($data, 'port'),
            '{{DB_DATABASE}}' => Arr::get($data, 'database'),
            '{{DB_USERNAME}}' => Arr::get($data, 'username'),
            '{{DB_PASSWORD}}' => Arr::get($data, 'password'),
        ]);

        // Save the env configuration.
        File::put($this->getEnvFilePath(), $contents);

        // Indicate that the configuration was updated.
        $this->store->put($this->key, true);
    }

    /**
     * Determine if the configuration file has already been created.
     *
     * @return bool
     */
    public function hasBeenCreated()
    {
        return File::exists($this->getEnvFilePath());
    }

    /**
     * Determine if the configuration has been updated.
     *
     * @return bool
     */
    public function hasBeenUpdated()
    {
        return $this->store->get($this->key, false);
    }
}
