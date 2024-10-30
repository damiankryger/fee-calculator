<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Services;

use PragmaGoTech\Interview\Model\Breakpoint;
use PragmaGoTech\Interview\Model\Fee;
use PragmaGoTech\Interview\Model\FeeRule;

class FeeInterpolator
{
    public function interpolate(FeeRule $lower, FeeRule $higher, Breakpoint $amount): Fee
    {
        $proportion = $this->calculateProportion($lower->breakpoint, $higher->breakpoint, $amount);

        return $this->calculateInterpolatedFee($lower->fee, $higher->fee, $proportion);
    }

    private function calculateProportion(Breakpoint $lower, Breakpoint $higher, Breakpoint $value): float
    {
        return ($value->value - $lower->value) / ($higher->value - $lower->value);
    }

    private function calculateInterpolatedFee(Fee $lower, Fee $higher, float $proportion): Fee
    {
        $result = (1 - $proportion) * $lower->value + $proportion * $higher->value;

        return new Fee((int)round($result));
    }
}
