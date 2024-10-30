<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Repositories;

use PragmaGoTech\Interview\Model\Breakpoint;
use PragmaGoTech\Interview\Model\FeeRule;
use PragmaGoTech\Interview\Model\Term;

class FeeRulesCollection
{
    /**
     * @var array<FeeRule>
     */
    private array $items = [];

    /**
     * @param array<FeeRule> $items
     */
    public function __construct(array $items = [])
    {
        $this->items = [];

        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function add(FeeRule $feeRule): void
    {
        $this->items[] = $feeRule;
    }

    public function filterByTerm(Term $term): self
    {
        return new self(array_filter($this->items, function (FeeRule $feeRule) use ($term) {
            return $feeRule->term === $term;
        }));
    }

    public function filterByBreakpoint(Breakpoint $breakpoint): self
    {
        return new self(array_filter($this->items, function (FeeRule $feeRule) use ($breakpoint) {
            return $feeRule->breakpoint->isEqual($breakpoint);
        }));
    }

    public function filterLessThanBreakpoint(Breakpoint $breakpoint): self
    {
        return new self(array_filter($this->items, function (FeeRule $feeRule) use ($breakpoint) {
            return $feeRule->breakpoint->isLessThan($breakpoint);
        }));
    }

    public function filterGreaterThanBreakpoint(Breakpoint $breakpoint): self
    {
        return new self(array_filter($this->items, function (FeeRule $feeRule) use ($breakpoint) {
            return $feeRule->breakpoint->isGreaterThan($breakpoint);
        }));
    }

    public function first(): ?FeeRule
    {
        $item = reset($this->items);

        if (!$item) {
            return null;
        }

        return $item;
    }

    public function last(): ?FeeRule
    {
        $item = end($this->items);

        if (!$item) {
            return null;
        }

        return $item;
    }

    public function sortByBreakpoints(): self
    {
        $copiedItems = $this->items;

        usort($copiedItems, function (FeeRule $a, FeeRule $b) {
            return $a->breakpoint->compare($b->breakpoint);
        });

        return new self($copiedItems);
    }

    public function getOneByTermAndBreakpoint(Term $term, Breakpoint $breakpoint): ?FeeRule
    {
        return $this
            ->filterByTerm($term)
            ->filterByBreakpoint($breakpoint)
            ->first();
    }

    /**
     * @param Breakpoint $breakpoint
     *
     * @return array<self>
     */
    public function partitionByBreakpoint(Breakpoint $breakpoint): array
    {
        return [
            $this->filterLessThanBreakpoint($breakpoint)->sortByBreakpoints(),
            $this->filterGreaterThanBreakpoint($breakpoint)->sortByBreakpoints(),
        ];
    }
}
