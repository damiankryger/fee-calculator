<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\DefaultFeeCalculator;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Repositories\InMemoryFeeStructureRepository;
use PragmaGoTech\Interview\Services\FeeInterpolator;

class DefaultFeeCalculatorTest extends TestCase
{
    public static function correctDataProvider(): array
    {
        return [
            // Test cases for 12 months term based on default structure
            [12, 1000, 50],
            [12, 2000, 90],
            [12, 3000, 90],
            [12, 4000, 115],
            [12, 5000, 100],
            [12, 6000, 120],
            [12, 7000, 140],
            [12, 8000, 160],
            [12, 9000, 180],
            [12, 10000, 200],
            [12, 11000, 220],
            [12, 12000, 240],
            [12, 13000, 260],
            [12, 14000, 280],
            [12, 15000, 300],
            [12, 16000, 320],
            [12, 17000, 340],
            [12, 18000, 360],
            [12, 19000, 380],
            [12, 20000, 400],

            // Test cases for 24 month term based on default structure
            [24, 1000, 70],
            [24, 2000, 100],
            [24, 3000, 120],
            [24, 4000, 160],
            [24, 5000, 200],
            [24, 6000, 240],
            [24, 7000, 280],
            [24, 8000, 320],
            [24, 9000, 360],
            [24, 10000, 400],
            [24, 11000, 440],
            [24, 12000, 480],
            [24, 13000, 520],
            [24, 14000, 560],
            [24, 15000, 600],
            [24, 16000, 640],
            [24, 17000, 680],
            [24, 18000, 720],
            [24, 19000, 760],
            [24, 20000, 800],

            // Test cases for test values
            [24, 11500, 460],
            [12, 19250, 385],

            // My personal test cases
            [24, 13250, 530]
        ];
    }

    /**
     * @dataProvider correctDataProvider
     *
     * @param int $term
     * @param float $amount
     * @param int $expectedFee
     *
     * @return void
     */
    public function testCalculate(int $term, float $amount, int $expectedFee): void
    {
        $feeStructureRepository = new InMemoryFeeStructureRepository();
        $feeInterpolator = new FeeInterpolator();
        $calculator = new DefaultFeeCalculator(
            $feeStructureRepository,
            $feeInterpolator
        );

        $this->assertEquals($expectedFee, $calculator->calculate(new LoanProposal($term, $amount)));
    }
}