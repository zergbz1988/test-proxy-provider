<?php

declare(strict_types=1);

namespace Proxy\App\Service;

use Proxy\Domain\Proxy;
use Proxy\Domain\ProxyCollection;

class ProxyCollectionStringFormatter
{
    public function __construct(private readonly ProxyStringFormatter $formatter)
    {
    }

    public function format(ProxyCollection $collection): array
    {
        return $collection->map(fn(Proxy $proxy) => $this->formatter->format($proxy))->all();
    }
}