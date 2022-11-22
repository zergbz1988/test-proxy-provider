<?php

declare(strict_types=1);

namespace Proxy\Domain;

use InvalidArgumentException;

class IPAddress
{
    private function __construct(public readonly string $value)
    {
    }

    public static function of(string $value): static
    {
        if (filter_var($value, FILTER_VALIDATE_IP) === false) {
            throw new InvalidArgumentException('Valid IP address string value must be provided.');
        }

        return new static($value);
    }
}