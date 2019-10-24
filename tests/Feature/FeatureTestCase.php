<?php

namespace Tests\Feature;

use Mockery as m;
use Tests\TestCase;
use App\Installer\Installer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeatureTestCase extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $installer = m::mock(Installer::class);
        $installer->shouldReceive('installed')->andReturnTrue();

        $this->app->instance(Installer::class, $installer);
    }
}
