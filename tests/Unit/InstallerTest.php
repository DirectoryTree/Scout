<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use App\Installer\Installer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InstallerTest extends TestCase
{
    public function test_defaults()
    {
        /** @var Installer $installer */
        $installer = app(Installer::class);

        $this->assertFalse($installer->hasBeenSetup());
        $this->assertFalse($installer->hasRanMigrations());
    }

    public function test_uses_cache()
    {
        /** @var Installer $installer */
        $installer = app(Installer::class);

        Cache::shouldReceive('get')->withArgs(['scout.installed', false])->once()->andReturnFalse();
        Cache::shouldReceive('forever')->withArgs(['scout.installed', false])->once();

        $this->assertFalse($installer->installed());

        Cache::shouldReceive('get')->withArgs(['scout.installed', false])->once()->andReturnTrue();

        $this->assertTrue($installer->installed());
    }

    public function test_preparation_creates_env()
    {
        /** @var Installer $installer */
        $installer = app(Installer::class);

        File::shouldReceive('exists')->withArgs([$installer->getEnvPath()])->once()->andReturnFalse();
        File::shouldReceive('get')->withArgs([$installer->getEnvStubPath()])->once()->andReturn('content');
        File::shouldReceive('put')->withArgs([$installer->getEnvPath(), 'content'])->once()->andReturnTrue();

        Artisan::shouldReceive('call')->withArgs(['key:generate'])->once();

        $installer->prepare();

        $this->assertTrue($installer->wasRecentlyPrepared());
    }

    public function test_preparation_failure_aborts()
    {
        /** @var Installer $installer */
        $installer = app(Installer::class);

        File::shouldReceive('exists')->withArgs([$installer->getEnvPath()])->once()->andReturnFalse();
        File::shouldReceive('get')->withArgs([$installer->getEnvStubPath()])->once()->andReturn('content');
        File::shouldReceive('put')->withArgs([$installer->getEnvPath(), 'content'])->once()->andReturnFalse();

        $this->expectException(HttpException::class);

        $installer->prepare();
    }

    public function test_install()
    {
        /** @var Installer $installer */
        $installer = app(Installer::class);

        $stub = file_get_contents(base_path('tests/stubs/.env.stub'));

        File::shouldReceive('get')->withArgs([$installer->getEnvStubPath()])->once()->andReturn($stub);
        File::shouldReceive('get')->withArgs([$installer->getEnvPath()])->once()->andReturn($stub);
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
        File::shouldReceive('delete')->withArgs([$installer->getEnvStubPath()])->once();

        $installer->install([
            'driver' => 'mysql',
            'database' => 'scout',
            'host' => 'localhost',
            'port' => '3306',
            'username' => 'root',
            'password' => 'secret',
        ]);
    }

    public function test_install_failure_restores_env_stub_and_clears_cache()
    {
        /** @var Installer $installer */
        $installer = app(Installer::class);

        $stub = file_get_contents(base_path('tests/stubs/.env.stub'));

        File::shouldReceive('get')->withArgs([$installer->getEnvStubPath()])->once()->andReturn($stub);
        File::shouldReceive('get')->withArgs([$installer->getEnvPath()])->once()->andReturn($stub);
        File::shouldReceive('put')->once()->andThrow(new Exception());

        Artisan::shouldReceive('call')->withArgs(['cache:clear'])->once();
        File::shouldReceive('put')->once()->withArgs(function ($path, $contents) use ($installer) {
             return $installer->getEnvStubPath() == $path;
        });

        $this->expectException(Exception::class);

        $installer->install([]);
    }
}
