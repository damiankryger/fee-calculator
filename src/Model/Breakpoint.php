<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

readonly class Breakpoint
{
    public function __construct(
        public int $value
    ) {
    }

    public static function fromFloat(float $amount): self
    {
        return new self((int) round($amount * 100));
    }

    public function toFloat(): float
    {
        $float = (float) $this->value;

        return round($float / 100, 2);
    }

    public function isEqual(Breakpoint $breakpoint): bool
    {
        return $this->value === $breakpoint->value;
    }

    public function isLessThan(Breakpoint $breakpoint): bool
    {
        return $this->value < $breakpoint->value;
    }

    public function isGreaterThan(Breakpoint $breakpoint): bool
    {
        return $this->value > $breakpoint->value;
    }

    public function compare(Breakpoint $breakpoint): int
    {
        return $this->value <=> $breakpoint->value;
    }
}
