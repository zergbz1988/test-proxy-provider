<?php

declare(strict_types=1);

namespace Proxy\Domain;

use InvalidArgumentException;

class Port
{
    private function __construct(public readonly int $value)
    {
    }

    public static function of(int $value): static
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Positive integer value must be provided.');
        }

        return new static($value);
    }
}