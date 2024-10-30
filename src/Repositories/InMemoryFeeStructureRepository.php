<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Repositories;

use PragmaGoTech\Interview\Model\Breakpoint;
use PragmaGoTech\Interview\Model\Fee;
use PragmaGoTech\Interview\Model\FeeRule;
use PragmaGoTech\Interview\Model\Term;

class InMemoryFeeStructureRepository implements FeeStructureRepository
{
    private const array FEE_STRUCTURE = [
        12 => [
            1000 => 50,
            2000 => 90,
            3000 => 90,
            4000 => 115,
            5000 => 100,
            6000 => 120,
            7000 => 140,
            8000 => 160,
            9000 => 180,
            10000 => 200,
            11000 => 220,
            12000 => 240,
            13000 => 260,
            14000 => 280,
            15000 => 300,
            16000 => 320,
            17000 => 340,
            18000 => 360,
            19000 => 380,
            20000 => 400,
        ],
        24 => [
            1000 => 70,
            2000 => 100,
            3000 => 120,
            4000 => 160,
            5000 => 200,
            6000 => 240,
            7000 => 280,
            8000 => 320,
            9000 => 360,
            10000 => 400,
            11000 => 440,
            12000 => 480,
            13000 => 520,
            14000 => 560,
            15000 => 600,
            16000 => 640,
            17000 => 680,
            18000 => 720,
            19000 => 760,
            20000 => 800,
        ]
    ];

    private FeeRulesCollection $feeRules;

    public function __construct()
    {
        $this->feeRules = new FeeRulesCollection();

        foreach (self::FEE_STRUCTURE[12] as $breakpoint => $fee) {
            $this->feeRules->add(new FeeRule(Term::from(12), Breakpoint::fromFloat($breakpoint), Fee::fromFloat($fee)));
        }

        foreach (self::FEE_STRUCTURE[24] as $breakpoint => $fee) {
            $this->feeRules->add(new FeeRule(Term::from(24), Breakpoint::fromFloat($breakpoint), Fee::fromFloat($fee)));
        }
    }

    /**
     * @param Term $term
     * @param Breakpoint $breakpoint
     * @return FeeRule|FeeRule[]
     */
    public function getClosestRules(Term $term, Breakpoint $breakpoint): FeeRule|array
    {
        $rule = $this->feeRules->getOneByTermAndBreakpoint($term, $breakpoint);

        if ($rule) {
            return $rule;
        }

        $itemsForTerm = $this->feeRules->filterByTerm($term);
        list($lowerBreakpoints, $higherBreakpoints) = $itemsForTerm->partitionByBreakpoint($breakpoint);

        $lower = $lowerBreakpoints->last();
        $higher = $higherBreakpoints->first();

        if ($lower === null || $higher === null) {
            throw new \RuntimeException('Range has not been found');
        }

        return [$lower, $higher];
    }
}
