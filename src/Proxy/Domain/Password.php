<?php

declare(strict_types=1);

namespace Proxy\Domain;

use InvalidArgumentException;

class Password
{
    private function __construct(public readonly string $value)
    {
    }

    public static function of(string $value): static
    {
        if (mb_strlen($value) < 6) {
            throw new InvalidArgumentException('String value with length >= 6 must be provided.');
        }

        return new static($value);
    }
}