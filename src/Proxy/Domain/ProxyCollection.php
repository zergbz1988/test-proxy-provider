<?php

declare(strict_types=1);

namespace Proxy\Domain;

use Illuminate\Support\Collection;
use InvalidArgumentException;

class ProxyCollection extends Collection
{
    public function add($item): static
    {
        if (!is_a($item, Proxy::class)) {
            throw new InvalidArgumentException('Proxy object must be provided.');
        }

        return parent::add($item);
    }
}