<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

readonly class FeeRule
{
    public function __construct(
        public Term       $term,
        public Breakpoint $breakpoint,
        public Fee        $fee
    ) {
    }

    public function getRoundedFee(): Fee
    {
        return $this->fee->roundToClosestFive($this->breakpoint);
    }
}
