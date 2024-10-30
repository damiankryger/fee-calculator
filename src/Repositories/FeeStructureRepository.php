<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Repositories;

use PragmaGoTech\Interview\Model\Breakpoint;
use PragmaGoTech\Interview\Model\FeeRule;
use PragmaGoTech\Interview\Model\Term;

interface FeeStructureRepository
{
    /**
     * @param Term $term
     * @param Breakpoint $breakpoint
     * @return FeeRule|FeeRule[]
     */
    public function getClosestRules(Term $term, Breakpoint $breakpoint): FeeRule|array;
}
