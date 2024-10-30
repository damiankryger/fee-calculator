<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Services;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Model\Breakpoint;
use PragmaGoTech\Interview\Model\Fee;
use PragmaGoTech\Interview\Model\FeeRule;
use PragmaGoTech\Interview\Model\Term;
use PragmaGoTech\Interview\Services\FeeInterpolator;

class FeeInterpolatorTest extends TestCase
{
    public static function dataProvider(): array
    {
        return [
            [150, 10000, 100, 11000, 200, 10500],
            [175, 10000, 100, 11000, 200, 10750],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testInterpolate(float $expectedFee, float $lowerBreakpoint, float $lowerFee, float $higherBreakpoint, float $higherFee, float $currentAmount): void
    {
        $interpolator = new FeeInterpolator();

        $fee = $interpolator->interpolate(
            new FeeRule(Term::ONE_YEAR, Breakpoint::fromFloat($lowerBreakpoint), Fee::fromFloat($lowerFee)),
            new FeeRule(Term::ONE_YEAR, Breakpoint::fromFloat($higherBreakpoint), Fee::fromFloat($higherFee)),
            Breakpoint::fromFloat($currentAmount)
        );

        $this->assertEquals($fee->toFloat(), $expectedFee);
    }
}