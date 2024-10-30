<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Model\Breakpoint;
use PragmaGoTech\Interview\Model\FeeRule;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Model\Term;
use PragmaGoTech\Interview\Repositories\FeeStructureRepository;
use PragmaGoTech\Interview\Services\FeeInterpolator;
use Webmozart\Assert\Assert;

readonly class DefaultFeeCalculator implements FeeCalculator
{
    public function __construct(
        private FeeStructureRepository $feeStructure,
        private FeeInterpolator $feeInterpolator
    ) {
    }

    public function calculate(LoanProposal $application): float
    {
        Assert::greaterThanEq($application->amount(), 1000);
        Assert::lessThanEq($application->amount(), 20000);
        Assert::inArray($application->term(), [12, 24]);

        $breakpoint = Breakpoint::fromFloat($application->amount());
        $term = Term::from($application->term());

        $result = $this->feeStructure->getClosestRules($term, $breakpoint);

        if ($result instanceof FeeRule) {
            return $result
                ->getRoundedFee()
                ->toFloat();
        }

        list($lower, $higher) = $result;

        $interpolatedFee = $this->feeInterpolator->interpolate($lower, $higher, $breakpoint);

        return $interpolatedFee
            ->roundToClosestFive($breakpoint)
            ->toFloat();
    }
}
