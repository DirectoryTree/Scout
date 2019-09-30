<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Rules\DistinguishedName;

class DistinguishedNameRuleTest extends TestCase
{
    /**
     * @var DistinguishedName
     */
    protected $rule;

    public function setUp(): void
    {
        parent::setUp();

        $this->rule = new DistinguishedName();
    }

    public function test_passes()
    {
        $this->assertTrue($this->rule->passes('dn', 'dc=acme,dc=org'));
        $this->assertTrue($this->rule->passes('dn', 'attribute=value'));
    }

    public function test_fails()
    {
        $this->assertFalse($this->rule->passes('dn', 'invalid'));
        $this->assertFalse($this->rule->passes('dn', 123));
    }
}
