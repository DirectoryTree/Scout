<?php

namespace Tests\Unit\Ldap;

use Tests\TestCase;
use App\Ldap\Conditions\Has;
use App\Ldap\Conditions\Equals;
use App\Ldap\Conditions\IsPast;
use App\Ldap\Conditions\Changed;
use App\Ldap\Conditions\Contains;
use App\Ldap\Conditions\LessThan;
use App\Ldap\Conditions\NotEquals;
use App\Ldap\Conditions\GreaterThan;

class ConditionsTest extends TestCase
{
    public function test_equals()
    {
        $this->assertTrue((new Equals(['foo'], 'attribute', ['foo']))->passes());
        $this->assertTrue((new Equals(['FOO'], 'attribute', ['foo']))->passes());
        $this->assertFalse((new Equals(['foo'], 'attribute', ['bar']))->passes());
        $this->assertFalse((new Equals(['foo'], 'attribute'))->passes());
    }

    public function test_not_equals()
    {
        $this->assertTrue((new NotEquals(['bar'], 'attribute', ['foo']))->passes());
        $this->assertTrue((new NotEquals([], 'attribute', ['foo']))->passes());
        $this->assertTrue((new NotEquals(['FOO'], 'attribute'))->passes());
        $this->assertFalse((new NotEquals(['foo'], 'attribute', ['foo']))->passes());
        $this->assertFalse((new NotEquals(['FOO'], 'attribute', ['foo']))->passes());
    }

    public function test_contains()
    {
        $this->assertTrue((new Contains(['foo'], 'attribute', ['foo']))->passes());
        $this->assertTrue((new Contains(['foo', 'bar', 'baz'], 'attribute', ['baz']))->passes());
        $this->assertFalse((new Contains([], 'attribute', ['baz']))->passes());
        $this->assertFalse((new Contains(['foo'], 'attribute'))->passes());
        $this->assertFalse((new Contains([], 'attribute'))->passes());
    }

    public function test_has()
    {
        $this->assertTrue((new Has(['value'], 'attribute', ['value']))->passes());
        $this->assertFalse((new Has([], 'attribute', ['value']))->passes());
    }

    public function test_is_past()
    {
        $this->assertTrue((new IsPast([now()->subDay()], 'attribute'))->passes());
        $this->assertFalse((new IsPast(['invalid'], 'attribute'))->passes());
    }

    public function test_greater_than()
    {
        $this->assertTrue((new GreaterThan([100], 'attribute'))->passes());
        $this->assertFalse((new GreaterThan([100], 'attribute', [101]))->passes());
        $this->assertFalse((new GreaterThan([100], 'attribute', [100]))->passes());
        $this->assertFalse((new GreaterThan(['invalid'], 'attribute', [101]))->passes());
    }

    public function test_less_than()
    {
        $this->assertTrue((new LessThan([100], 'attribute', [101]))->passes());
        $this->assertFalse((new LessThan([101], 'attribute', [101]))->passes());
        $this->assertFalse((new LessThan(['invalid'], 'attribute', [101]))->passes());
        $this->assertFalse((new LessThan([100], 'attribute'))->passes());
    }

    public function test_changed()
    {
        $this->assertTrue((new Changed([100], 'attribute'))->passes());
        $this->assertTrue((new Changed([100], 'attribute', [101]))->passes());
        $this->assertTrue((new Changed(['one'], 'attribute', ['one', 'two']))->passes());
        $this->assertTrue((new Changed([], 'attribute', ['one']))->passes());
        $this->assertFalse((new Changed(['one'], 'attribute', ['one']))->passes());
        $this->assertFalse((new Changed([0 => 'one'], 'attribute', [1 => 'one']))->passes());
    }
}
