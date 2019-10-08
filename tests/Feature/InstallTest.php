<?php

namespace Tests\Feature;

use Exception;
use Mockery as m;
use Tests\TestCase;
use App\Installer\Installer;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Connectors\ConnectionFactory;

class InstallTest extends TestCase
{
    public function test_visiting_site_redirects_to_installer()
    {
        $this->get('/')->assertRedirect(route('install.index'));
    }

    public function test_setup_page_works()
    {
        $installer = m::mock(Installer::class);
        $installer->makePartial();
        $installer->shouldReceive('hasBeenSetup')->andReturnFalse();

        $this->app->instance(Installer::class, $installer);

        $this->get(route('install.index'))
            ->assertSuccessful()
            ->assertSee('Welcome');
    }

    public function test_setting_up_requires_values()
    {
        $this->post(route('install.store'))
            ->assertRedirect()
            ->assertSessionHasErrors([
                'driver', 'host', 'port', 'username',
            ]);
    }

    public function test_setting_up_requires_database_connection()
    {
        $data = [
            'driver' => 'mysql',
            'host' => 'localhost',
            'port' => '3306',
            'database' => 'scout',
            'username' => 'root',
            'password' => 'secret',
        ];

        $factory = m::mock(ConnectionFactory::class);

        $factory->shouldReceive('make')->withArgs([$data])->once()->andReturnSelf();
        $factory->shouldReceive('getPdo')->once()->andThrow(new Exception('Cannot connect.'));

        $this->app->instance('db.factory', $factory);

        $this->post(route('install.store'), $data)
            ->assertRedirect()
            ->assertSessionHasErrors('host');
    }

    public function test_successful_setup_displays_migration_setup()
    {
        $installer = m::mock(Installer::class);
        $installer->makePartial();
        $installer->shouldReceive('hasBeenSetup')->andReturnTrue();
        $installer->shouldReceive('hasRanMigrations')->andReturnFalse();

        $this->app->instance(Installer::class, $installer);

        $this->get(route('install.index'))->assertSee('Setup Database');
    }

    public function test_migrations_are_ran_setting_up_database()
    {
        $installer = m::mock(Installer::class);
        $installer->makePartial();
        $installer->shouldReceive('hasBeenSetup')->andReturnTrue();
        $installer->shouldReceive('hasRanMigrations')->andReturnFalse();

        $this->app->instance(Installer::class, $installer);

        Artisan::shouldReceive('call')->once()->withArgs(['migrate']);

        $this->post(route('install.migrate'))
            ->assertRedirect('/login');
    }

    public function test_migrations_cannot_be_ran_after_setting_up_database()
    {
        $installer = m::mock(Installer::class);
        $installer->makePartial();
        $installer->shouldReceive('hasBeenSetup')->andReturnTrue();
        $installer->shouldReceive('hasRanMigrations')->andReturnTrue();

        $this->app->instance(Installer::class, $installer);

        Artisan::shouldReceive('call')->times(0);

        $this->post(route('install.migrate'))->assertNotFound();
    }
}
