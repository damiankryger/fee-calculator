<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Model;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Model\Breakpoint;
use PragmaGoTech\Interview\Model\Fee;

class FeeTest extends TestCase
{
    public function testNoErrorsDuringDoubleConversionFromFloatToFeeAndFromFeeToFloatAgain(): void
    {
        $initialValue = 100.25;
        $breakpoint = Fee::fromFloat($initialValue);

        $this->assertEquals($initialValue, $breakpoint->toFloat());
    }

    public static function dataProvider(): array
    {
        return [
            [100, 10000, 96],
            [95, 10000, 95],
            [95, 10000, 94],
            [99.25, 10000.75, 95]
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testNoErrorsDuringRoundingToClosestFive(float $expectedFee, float $breakpoint, float $currentFee): void
    {
        $breakpoint = Breakpoint::fromFloat($breakpoint);
        $fee = Fee::fromFloat($currentFee);

        $this->assertEquals($expectedFee, $fee->roundToClosestFive($breakpoint)->toFloat());
    }
}