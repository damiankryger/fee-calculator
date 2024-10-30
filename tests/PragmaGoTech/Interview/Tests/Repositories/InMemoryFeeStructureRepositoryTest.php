<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Repositories;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Model\Breakpoint;
use PragmaGoTech\Interview\Model\FeeRule;
use PragmaGoTech\Interview\Model\Term;
use PragmaGoTech\Interview\Repositories\InMemoryFeeStructureRepository;

class InMemoryFeeStructureRepositoryTest extends TestCase
{
    public function testGettingProperRules(): void
    {
        $repository = new InMemoryFeeStructureRepository();

        // CASE 1
        $result = $repository->getClosestRules(Term::ONE_YEAR, Breakpoint::fromFloat(10000));

        $this->assertInstanceOf(FeeRule::class, $result);
        $this->assertEquals(10000, $result->breakpoint->toFloat());
        $this->assertEquals(200, $result->fee->toFloat());

        // CASE 2
        $result = $repository->getClosestRules(Term::ONE_YEAR, Breakpoint::fromFloat(10500));

        $this->assertIsArray($result);
        $this->assertInstanceOf(FeeRule::class, $lower = $result[0]);
        $this->assertInstanceOf(FeeRule::class, $higher = $result[1]);

        $this->assertEquals(10000, $lower->breakpoint->toFloat());
        $this->assertEquals(11000, $higher->breakpoint->toFloat());
    }
}