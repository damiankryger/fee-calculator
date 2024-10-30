<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Model;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Model\Breakpoint;

class BreakpointTest extends TestCase
{
    public function testNoErrorsDuringDoubleConversionFromFloatToBreakpointAndFromBreakpointToFloatAgain(): void
    {
        $initialValue = 100.25;
        $breakpoint = Breakpoint::fromFloat($initialValue);

        $this->assertEquals($initialValue, $breakpoint->toFloat());
    }

    public function testNoErrorsDuringCheckingIfTwoBreakpointsAreEqual(): void
    {
        $a = Breakpoint::fromFloat(100.25);
        $b = Breakpoint::fromFloat(100.25);
        $c = Breakpoint::fromFloat(101.33);

        $this->assertTrue($a->isEqual($a));
        $this->assertTrue($a->isEqual($b));
        $this->assertFalse($a->isEqual($c));
    }

    public function testNoErrorsDuringCheckingIfBreakpointIsLessThanAnother(): void
    {
        $a = Breakpoint::fromFloat(100.25);
        $b = Breakpoint::fromFloat(100.25);
        $c = Breakpoint::fromFloat(101.33);

        $this->assertFalse($a->isLessThan($a));
        $this->assertFalse($a->isLessThan($b));
        $this->assertTrue($a->isLessThan($c));
        $this->assertFalse($c->isLessThan($a));
    }

    public function testNoErrorsDuringCheckingIfBreakpointIsGreaterThanAnother(): void
    {
        $a = Breakpoint::fromFloat(100.25);
        $b = Breakpoint::fromFloat(100.25);
        $c = Breakpoint::fromFloat(101.33);

        $this->assertFalse($a->isGreaterThan($a));
        $this->assertFalse($a->isGreaterThan($b));
        $this->assertFalse($a->isGreaterThan($c));
        $this->assertTrue($c->isGreaterThan($a));
    }

    public function testNoErrorsDuringComparingTwoBreakpoints(): void
    {
        $a = Breakpoint::fromFloat(100.25);
        $b = Breakpoint::fromFloat(100.25);
        $c = Breakpoint::fromFloat(101.33);
        $d = Breakpoint::fromFloat(99.87);

        $this->assertEquals(0, $a->compare($a));
        $this->assertEquals(0, $a->compare($b));
        $this->assertEquals(-1, $a->compare($c));
        $this->assertEquals(1, $c->compare($a));
        $this->assertEquals(1, $a->compare($d));
        $this->assertEquals(-1, $d->compare($a));
    }
}