<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

readonly class Fee
{
    public function __construct(
        public int $value
    ) {
    }

    public static function fromFloat(float $value): self
    {
        return new self((int) round($value * 100));
    }

    public function roundToClosestFive(Breakpoint $breakpoint): self
    {
        $result = $this->value + $breakpoint->value;
        $closestFive = (int)(ceil($result / 500)) * 500;

        return new self($closestFive - $breakpoint->value);
    }

    public function toFloat(): float
    {
        $float = (float) $this->value;

        return round($float / 100, 2);
    }
}
