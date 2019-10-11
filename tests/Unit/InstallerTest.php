<?php

namespace Tests\Unit;

use Exception;
use Mockery as m;
use Tests\TestCase;
use App\Installer\Installer;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InstallerTest extends TestCase
{
    public function test_defaults()
    {
        /** @var Installer $installer */
        $installer = app(Installer::class);

        File::shouldReceive('exists')->withArgs([$installer->getEnvFilePath()])->once()->andReturnFalse();

        $this->assertFalse($installer->hasBeenSetup());
        $this->assertFalse($installer->hasRanMigrations());
    }

    public function test_uses_store()
    {
        /** @var Installer $installer */
        $installer = app(Installer::class);

        $store = m::mock(Valuestore::class);
        $store->shouldReceive('get')->withArgs(['scout.installed', false])->once()->andReturnFalse();
        $store->shouldReceive('put')->withArgs(['scout.installed', false])->once();

        $installer->setStore($store);

        $this->assertFalse($installer->installed());

        $store->shouldReceive('get')->withArgs(['scout.installed', false])->once()->andReturnTrue();

        $this->assertTrue($installer->installed());
    }

    public function test_preparation_creates_env()
    {
        /** @var Installer $installer */
        $installer = app(Installer::class);

        File::shouldReceive('exists')->withArgs([$installer->getEnvFilePath()])->once()->andReturnFalse();
        File::shouldReceive('get')->withArgs([$installer->getEnvStubFilePath()])->once()->andReturn('content');
        File::shouldReceive('put')->withArgs([$installer->getEnvFilePath(), 'content'])->once()->andReturnTrue();

        Artisan::shouldReceive('call')->withArgs(['key:generate'])->once();

        $installer->prepare();

        $this->assertTrue($installer->wasRecentlyPrepared());
    }

    public function test_preparation_failure_aborts()
    {
        /** @var Installer $installer */
        $installer = app(Installer::class);

        File::shouldReceive('exists')->withArgs([$installer->getEnvFilePath()])->once()->andReturnFalse();
        File::shouldReceive('get')->withArgs([$installer->getEnvStubFilePath()])->once()->andReturn('content');
        File::shouldReceive('put')->withArgs([$installer->getEnvFilePath(), 'content'])->once()->andReturnFalse();

        $this->expectException(HttpException::class);

        $installer->prepare();
    }

    public function test_install()
    {
        /** @var Installer $installer */
        $installer = app(Installer::class);

        $stub = file_get_contents(base_path('tests/stubs/.env.stub'));

        File::shouldReceive('get')->withArgs([$installer->getEnvFilePath()])->once()->andReturn($stub);
        File::shouldReceive('put')->withArgs(function ($path, $contents) {
            return Str::containsAll($contents, [
                'DB_CONNECTION="mysql"',
                'DB_HOST="localhost"',
                'DB_HOST="localhost"',
                'DB_PORT="3306"',
                'DB_DATABASE="scout"',
                'DB_USERNAME="root"',
                'DB_PASSWORD="secret"',
            ]);
        })->once();

        $installer->install([
            'driver' => 'mysql',
            'database' => 'scout',
            'host' => 'localhost',
            'port' => '3306',
            'username' => 'root',
            'password' => 'secret',
        ]);
    }

    public function test_install_failure_rethrows_exception()
    {
        /** @var Installer $installer */
        $installer = app(Installer::class);

        $stub = file_get_contents(base_path('tests/stubs/.env.stub'));

        File::shouldReceive('get')->withArgs([$installer->getEnvFilePath()])->once()->andReturn($stub);
        File::shouldReceive('put')->once()->andThrow(new Exception());

        $this->expectException(Exception::class);

        $installer->install([]);
    }
}
