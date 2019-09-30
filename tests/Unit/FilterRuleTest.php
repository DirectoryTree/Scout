<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Rules\LdapSearchFilter;

class FilterRuleTest extends TestCase
{
    /**
     * @var LdapSearchFilter
     */
    protected $rule;

    public function setUp(): void
    {
        parent::setUp();

        $this->rule = new LdapSearchFilter();
    }

    public function test_passes()
    {
        $this->assertTrue($this->rule->passes('filter','(test=test)'));
        $this->assertTrue($this->rule->passes('filter','()'));
    }

    public function test_fails()
    {
        $this->assertFalse($this->rule->passes('filter','('));
        $this->assertFalse($this->rule->passes('filter',')'));
        $this->assertFalse($this->rule->passes('filter',')('));
        $this->assertFalse($this->rule->passes('filter','(invalid'));
        $this->assertFalse($this->rule->passes('filter','invalid)'));
    }
}
