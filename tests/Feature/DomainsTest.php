<?php

namespace Tests\Feature;

use Tests\TestCase;

class DomainsTest extends TestCase
{
    public function test_viewing_all_initial_domains()
    {
        $this->signIn();

        $this->get(route('domains.index'))->assertSee('Domains');
    }

    public function test_adding_domain()
    {
        $this->signIn();

        $this->post(route('domains.store'));
    }
}
