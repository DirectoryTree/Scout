<?php


namespace Tests;

use Illuminate\Foundation\Testing\TestResponse as BaseTestResponse;

class TestResponse extends BaseTestResponse
{
    /**
     * Assert a turoblinks redirect.
     *
     * @param string|null $url
     */
    public function assertTurbolinksRedirect($url = null)
    {
        if ($url) {
            $this->assertSee("Turbolinks.visit('{$url}'");
        } else {
            $this->assertSee('Turbolinks.visit');
        }
    }
}
