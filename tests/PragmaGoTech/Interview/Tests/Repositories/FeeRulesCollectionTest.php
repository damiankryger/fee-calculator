<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Repositories;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Model\Breakpoint;
use PragmaGoTech\Interview\Model\Fee;
use PragmaGoTech\Interview\Model\FeeRule;
use PragmaGoTech\Interview\Model\Term;
use PragmaGoTech\Interview\Repositories\FeeRulesCollection;

class FeeRulesCollectionTest extends TestCase
{
    public function testNoErrorDuringCreation(): void
    {
        $rules = [
            new FeeRule(Term::ONE_YEAR, Breakpoint::fromFloat(10000), Fee::fromFloat(100)),
            new FeeRule(Term::ONE_YEAR, Breakpoint::fromFloat(15000), Fee::fromFloat(120)),
            new FeeRule(Term::TWO_YEARS, Breakpoint::fromFloat(10000), Fee::fromFloat(200)),
        ];

        $collection = new FeeRulesCollection($rules);
        $last = $collection->last();

        $this->assertEquals(Term::TWO_YEARS, $last->term);
        $this->assertEquals(10000, $last->breakpoint->toFloat());
        $this->assertEquals(200, $last->fee->toFloat());
    }

    public function testErrorDuringCreationWhenItemIsNotCorrect(): void
    {
        $rules = [
            Fee::fromFloat(100),
        ];

        $this->expectException(\TypeError::class);

        new FeeRulesCollection($rules);
    }

    public function testFilteringByTerm(): void
    {
        $rules = [
            new FeeRule(Term::ONE_YEAR, Breakpoint::fromFloat(10000), Fee::fromFloat(100)),
            new FeeRule(Term::ONE_YEAR, Breakpoint::fromFloat(15000), Fee::fromFloat(120)),
            new FeeRule(Term::TWO_YEARS, Breakpoint::fromFloat(10000), Fee::fromFloat(200)),
        ];

        $collection = new FeeRulesCollection($rules);
        $filtered = $collection->filterByTerm(Term::TWO_YEARS);
        $element = $filtered->first();

        $this->assertEquals(Term::TWO_YEARS, $element->term);
        $this->assertEquals(10000, $element->breakpoint->toFloat());
        $this->assertEquals(200, $element->fee->toFloat());
    }

    public function testFilteringByBreakpoint(): void
    {
        $rules = [
            new FeeRule(Term::ONE_YEAR, Breakpoint::fromFloat(10000), Fee::fromFloat(100)),
            new FeeRule(Term::ONE_YEAR, Breakpoint::fromFloat(15000), Fee::fromFloat(120)),
            new FeeRule(Term::TWO_YEARS, Breakpoint::fromFloat(10000), Fee::fromFloat(200)),
        ];

        $collection = new FeeRulesCollection($rules);
        $filtered = $collection->filterByBreakpoint(Breakpoint::fromFloat(15000));
        $element = $filtered->first();

        $this->assertEquals(Term::ONE_YEAR, $element->term);
        $this->assertEquals(15000, $element->breakpoint->toFloat());
        $this->assertEquals(120, $element->fee->toFloat());
    }

    public function testGettingByTermAndBreakpoint(): void
    {
        $rules = [
            new FeeRule(Term::ONE_YEAR, Breakpoint::fromFloat(10000), Fee::fromFloat(100)),
            new FeeRule(Term::ONE_YEAR, Breakpoint::fromFloat(15000), Fee::fromFloat(120)),
            new FeeRule(Term::TWO_YEARS, Breakpoint::fromFloat(10000), Fee::fromFloat(200)),
        ];

        $collection = new FeeRulesCollection($rules);
        $item = $collection->getOneByTermAndBreakpoint(Term::ONE_YEAR, Breakpoint::fromFloat(15000));

        $this->assertNotNull($item);
        $this->assertEquals(Term::ONE_YEAR, $item->term);
        $this->assertEquals(15000, $item->breakpoint->toFloat());
        $this->assertEquals(120, $item->fee->toFloat());
    }
}