<?php

namespace App\Installer;

use Exception;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\DB;

class Installer
{
    /**
     * Whether the installer has just performed initial preparation.
     *
     * @var bool
     */
    public $initialPreparation = false;

    /**
     * The installer value store.
     *
     * @var Valuestore
     */
    protected $store;

    /**
     * The configuration installer instance.
     *
     * @var Configuration
     */
    protected $config;

    /**
     * The installation key.
     *
     * @var string
     */
    protected $key = 'scout.installed';

    /**
     * Create a new installer instance.
     *
     * @param Valuestore $store
     */
    public function __construct(Valuestore $store)
    {
        $this->store = $store;
        $this->config = new Configuration($this->store);
    }

    /**
     * Set the installer value store.
     *
     * @param Valuestore $store
     */
    public function setStore(Valuestore $store)
    {
        $this->store = $store;
    }

    /**
     * Perform the install.
     *
     * @param array $data
     *
     * @throws Exception
     */
    public function install(array $data)
    {
        try {
            $this->config->update($data);
        } catch (Exception $ex) {
            // Re-throw the exception.
            throw $ex;
        }
    }

    /**
     * Determine if the application is installed.
     *
     * @return bool
     */
    public function installed()
    {
        if ($this->store->get($this->key, false)) {
            return true;
        }

        $installed = $this->hasBeenSetup() && $this->hasRanMigrations();

        try {
            $this->store->put($this->key, $installed);
        } catch (Exception $ex) {
            // File permission error.
        }

        return $installed;
    }

    /**
     * Determine if the setup has been ran.
     *
     * @return bool
     */
    public function hasBeenSetup()
    {
        return $this->config->hasBeenCreated() && $this->config->hasBeenUpdated();
    }

    /**
     * Determine if the application migrations have been ran.
     *
     * @return bool
     */
    public function hasRanMigrations()
    {
        try {
            return DB::table('migrations')->count() > 0;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Prepare the application for installation.
     *
     * @return void
     */
    public function prepare()
    {
        $this->config->create();

        $this->initialPreparation = $this->config->wasRecentlyCreated;
    }

    /**
     * Determine if the application installation was recently prepared.
     *
     * @return bool
     */
    public function wasRecentlyPrepared()
    {
        return $this->initialPreparation;
    }
}
