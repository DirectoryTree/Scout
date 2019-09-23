<?php

namespace App\Jobs;

use App\LdapScan;
use App\LdapDomain;
use App\LdapObject;
use LdapRecord\Ldap;
use LdapRecord\Container;
use LdapRecord\Connection;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LdapRecord\LdapRecordException;
use LdapRecord\Models\Model;
use LdapRecord\Models\Entry as UnknownModel;
use LdapRecord\Models\OpenLdap\Entry as OpenLdapModel;
use LdapRecord\Models\ActiveDirectory\Entry as ActiveDirectoryModel;

class SynchronizeDomain implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The LDAP domain.
     *
     * @var LdapDomain
     */
    protected $domain;

    /**
     * The current LDAP scan record.
     *
     * @var LdapScan
     */
    protected $scan;

    /**
     * The number of LDAP objects synchronized.
     *
     * @var array
     */
    protected $synchronized = 0;

    /**
     * Create a new job instance.
     *
     * @param LdapDomain $domain
     * @param LdapScan   $scan
     *
     * @return void
     */
    public function __construct(LdapDomain $domain, LdapScan $scan)
    {
        $this->domain = $domain;
        $this->scan = $scan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Set the scan start time.
        $this->scan->fill(['started_at' => now()])->save();

        $conn = $this->getNewLdapConnection($this->getLdapConnectionName());

        // Bind to the LDAP server if not yet bound.
        if (! $conn->getLdapConnection()->isBound()) {
            $config = $conn->getConfiguration();

            try {
                $conn->connect(
                    decrypt($config->get('username')),
                    decrypt($config->get('password'))
                );

                // Run the import.
                $this->import();

                // Update our scans completion stats.
                $this->scan->fill([
                    'success' => true,
                    'synchronized' => $this->synchronized,
                    'completed_at' => now(),
                ])->save();

                // Update the domains synchronization status.
                $this->domain->update([
                    'synchronized_at' => now(),
                    'status' => LdapDomain::STATUS_ONLINE,
                ]);
            } catch (LdapRecordException $e) {
                $status = Str::contains('credentials', $e->getMessage()) ?
                    LdapDomain::STATUS_INVALID_CREDENTIALS :
                    LdapDomain::STATUS_OFFLINE;

                $this->domain->update(['status' => $status]);

                $this->scan->fill([
                    'success' => false,
                    'exception' => $e->getMessage(),
                    'completed_at' => now(),
                ])->save();
            }
        }
    }

    /**
     * Import the LDAP objects on the given connection.
     *
     * @param Model|null      $model
     * @param LdapObject|null $parent
     */
    protected function import(Model $model = null, LdapObject $parent = null)
    {
        $this->query($model)->each(function (Model $child) use ($model, $parent) {
            /** @var LdapObject $object */
            $object = Bus::dispatch(new SynchronizeObject($this->domain, $child, $parent));

            $this->synchronized++;

            // If the object is a container, we will import its descendants.
            if ($object->type == 'container') {
                $this->import($child, $object);
            }
        });
    }

    /**
     * Queries the LDAP directory.
     *
     * If an entry is supplied, it will query leaf LDAP entries.
     *
     * @param Model|null $model
     *
     * @return \LdapRecord\Query\Collection
     */
    protected function query(Model $model = null)
    {
        $query = $model ?
            $model->in($model->getDn()) :
            $this->getDomainLdapModel()->setConnection($this->getLdapConnectionName());

        return $query->listing()
            ->select('*')
            ->paginate(1000);
    }

    /**
     * Get a new LDAP model for the current domains type.
     *
     * @return ActiveDirectoryModel|UnknownModel|OpenLdapModel
     */
    protected function getDomainLdapModel()
    {
        switch($this->domain->type) {
            case LdapDomain::TYPE_ACTIVE_DIRECTORY:
                return new ActiveDirectoryModel();
            case LdapDomain::TYPE_OPEN_LDAP:
                return new OpenLdapModel();
            default:
                return new UnknownModel();
        }
    }

    /**
     * Get a new LDAP connection.
     *
     * @param string $name
     *
     * @return Connection
     */
    protected function getNewLdapConnection($name)
    {
        $conn = new Connection(
            $this->domain->getConnectionAttributes(),
            new Ldap($name)
        );

        // Add the connection to the container.
        Container::getInstance()->add($conn, $name);

        return $conn;
    }

    /**
     * Get the LDAP connection name.
     *
     * @return string
     */
    protected function getLdapConnectionName()
    {
        return $this->domain->slug;
    }
}
